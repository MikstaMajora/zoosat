<?php

namespace Yandex\Market\Trading\Service\Marketplace\Action\PushStocks;

use Bitrix\Main;
use Yandex\Market;
use Yandex\Market\Trading\Service as TradingService;

/**
 * @property TradingService\Marketplace\Provider $provider
 * @property Request $request
*/
class Action extends TradingService\Reference\Action\DataAction
{
	use Market\Reference\Concerns\HasMessage;

	protected $pushStore;
	protected $warehouseMap;

	protected function createRequest(array $data)
	{
		return new Request($data);
	}

	public function process()
	{
		$productIds = $this->getProducts();

		if (empty($productIds)) { return; }

		$this->collectNext($productIds);

		$productIds = $this->feedExists($productIds);
		$amounts = $this->getAmounts($productIds);
		$amounts = $this->applyReserves($amounts);
		$amounts = $this->applyPackRatio($amounts);
		$amounts = $this->applyAmountsSku($amounts);
		$amounts = $this->filterExpired($amounts);
		$amounts = $this->filterChanged($amounts);

		if (empty($amounts)) { return; }

		$skus = $this->buildSkus($amounts);

		$this->sendSkus($skus);
		$this->commitChanged($amounts);
	}

	protected function getProducts()
	{
		$warehouseMap = $this->getWarehouseMap();
		$stores = !empty($warehouseMap) ? array_merge(...array_values($warehouseMap)) : [];

		return $this->environment->getStore()->getChanged(
			$stores,
			$this->request->getTimestamp(),
			$this->request->getOffset(),
			$this->request->getLimit()
		);
	}

	protected function feedExists($productIds)
	{
		$command = new TradingService\Marketplace\Command\FeedExists(
			$this->provider,
			$this->environment
		);

		return $command->filterProducts($productIds);
	}

	protected function collectNext($productIds)
	{
		$offset = $this->request->getOffset();
		$limit = $this->request->getLimit();
		$found = count($productIds);

		if ($found < $limit) { return; }

		$this->response->setField('hasNext', true);
		$this->response->setField('offset', $offset + $limit);
	}

	protected function getAmounts($productIds)
	{
		$resultParts = [];

		foreach ($this->getWarehouseMap() as $warehouseId => $stores)
		{
			$amounts = $this->environment->getStore()->getAmounts($stores, $productIds);

			foreach ($amounts as &$amount)
			{
				$amount['WAREHOUSE_ID'] = $warehouseId;
			}
			unset($amount);

			$resultParts[] = $amounts;
		}

		return !empty($resultParts) ? array_merge(...$resultParts) : [];
	}

	protected function getWarehouseMap()
	{
		if ($this->warehouseMap === null)
		{
			$this->warehouseMap = $this->buildWarehouseMap();
		}

		return $this->warehouseMap;
	}

	protected function buildWarehouseMap()
	{
		$options = $this->provider->getOptions();
		$result = [];

		if ($options->useWarehouses())
		{
			$primaryField = $options->getWarehousePrimaryField();
			$storeService = $this->environment->getStore();
			$storesMap = $storeService->existsStores($primaryField);

			foreach ($storesMap as $storeId => $warehouseId)
			{
				if (!isset($result[$warehouseId]))
				{
					$result[$warehouseId] = [ $storeId ];
				}
				else
				{
					$result[$warehouseId][] = $storeId;
				}
			}
		}
		else
		{
			$result[$options->getWarehousePrimary()] = $options->getProductStores();
		}

		return $result;
	}

	protected function applyAmountsSku($amounts)
	{
		$productIds = array_column($amounts, 'ID');
		$skuMap = $this->getSkuMap($productIds);

		if ($skuMap === null) { return $amounts; }

		$result = [];

		foreach ($amounts as $amount)
		{
			if (!isset($skuMap[$amount['ID']])) { continue; }

			$sku = $skuMap[$amount['ID']];

			$result[] = [ 'ID' => $sku ] + $amount;
		}

		return $result;
	}

	protected function getSkuMap($productIds)
	{
		$command = new TradingService\Common\Command\SkuMap(
			$this->provider,
			$this->environment
		);

		return $command->make($productIds);
	}

	protected function applyReserves($amounts)
	{
		if (!$this->provider->getOptions()->useOrderReserve()) { return $amounts; }

		$command = new TradingService\Marketplace\Command\ProductReserves(
			$this->provider,
			$this->environment,
			$this->getPlatform()
		);

		return $command->execute($amounts);
	}

	protected function applyPackRatio($amounts)
	{
		$command = new TradingService\Marketplace\Command\AmountsPackRatio(
			$this->provider,
			$this->environment
		);

		return $command->execute($amounts);
	}

	protected function filterExpired($amounts)
	{
		$expired = $this->expireDate();

		foreach ($amounts as $key => $amount)
		{
			if (Market\Data\DateTime::compare($amount['TIMESTAMP_X'], $expired) !== 1)
			{
				unset($amounts[$key]);
			}
		}

		return $amounts;
	}

	protected function expireDate()
	{
		$result = new Main\Type\DateTime();
		$result->add('-P1D');

		return $result;
	}

	protected function filterChanged($amounts)
	{
		return $this->getPushStore()->filterChanged($amounts);
	}

	protected function buildSkus($amounts)
	{
		$result = [];

		foreach ($amounts as $amount)
		{
			$updatedAt = Market\Data\Date::convertForService($amount['TIMESTAMP_X']);
			$item = [
				'sku' => (string)$amount['ID'],
				'warehouseId' => (string)$amount['WAREHOUSE_ID'],
				'items' => []
			];

			if (isset($amount['QUANTITY_LIST']))
			{
				foreach ($amount['QUANTITY_LIST'] as $type => $quantity)
				{
					$item['items'][] = [
						'type' => $type,
						'count' => (string)$this->normalizeItemCount($quantity),
						'updatedAt' => $updatedAt
					];
				}
			}
			else if (isset($amount['QUANTITY']))
			{
				$item['items'][] = [
					'type' => Market\Data\Trading\Stocks::TYPE_FIT,
					'count' => (string)$this->normalizeItemCount($amount['QUANTITY']),
					'updatedAt' => $updatedAt
				];
			}

			$result[] = $item;
		}

		return $result;
	}

	protected function normalizeItemCount($count)
	{
		return max(0, (int)$count);
	}

	protected function sendSkus($skus)
	{
		$request = new TradingService\Marketplace\Api\SendStocks\Request();
		$options = $this->provider->getOptions();
		$logger = $this->provider->getLogger();

		$request->setLogger($logger);
		$request->setOauthClientId($options->getOauthClientId());
		$request->setOauthToken($options->getOauthToken()->getAccessToken());
		$request->setCampaignId($options->getCampaignId());
		$request->setSkus($skus);

		$result = $request->send();

		Market\Exceptions\Api\Facade::handleResult($result, self::getMessage('SEND_FAILED'));
	}

	protected function commitChanged($amounts)
	{
		$this->getPushStore()->commit($amounts);
	}

	protected function getPushStore()
	{
		if ($this->pushStore === null)
		{
			$this->pushStore = $this->creatPushStore();
		}

		return $this->pushStore;
	}

	protected function creatPushStore()
	{
		return new Market\Trading\State\PushStore(
			$this->provider->getOptions()->getSetupId(),
			Market\Trading\Entity\Registry::ENTITY_TYPE_STOCKS,
			['ID', 'WAREHOUSE_ID'],
			[$this, 'pushStoreSign']
		);
	}

	public function pushStoreSign($amount)
	{
		if (isset($amount['QUANTITY_LIST']))
		{
			$parts = [];

			foreach ($amount['QUANTITY_LIST'] as $type => $quantity)
			{
				$parts[] = $type . '=' . (int)$quantity;
			}

			$result = implode(':', $parts);
		}
		else if (isset($amount['QUANTITY']))
		{
			$result = (int)$amount['QUANTITY'];
		}
		else
		{
			$result = null;
		}

		return $result;
	}
}