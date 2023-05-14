<?php

namespace Yandex\Market\Trading\Service\Marketplace\Command;

use Bitrix\Main;
use Yandex\Market;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

class ProductReserves
{
	const ORDER_PROCESSING = 'processing';
	const ORDER_SHIPPED = 'shipped';

	protected $provider;
	protected $environment;
	protected $platform;

	public function __construct(
		TradingService\Marketplace\Provider $provider,
		TradingEntity\Reference\Environment $environment,
		TradingEntity\Reference\Platform $platform
	)
	{
		$this->provider = $provider;
		$this->environment = $environment;
		$this->platform = $platform;
	}

	public function execute(array $amounts)
	{
		if (empty($amounts)) { return []; }

		$productIds = array_column($amounts, 'ID');
		$earliestUpdateAt = $this->earliestUpdateAt($amounts);
		$orderStates = $this->processingOrders($earliestUpdateAt);
		$orderStates = $this->filterFakeOrders($orderStates);
		$orderStates = $this->mapExistsOrders($orderStates);
		list($processingStates, $shippedStates) = $this->splitProcessingOrders($orderStates);

		$this->configureEnvironment();

		$reserves = $this->loadReserves($processingStates, $productIds);
		$shipped = $this->loadShipped($shippedStates, $productIds, $earliestUpdateAt);

		$amounts = $this->applyReserves($amounts, $reserves);
		$amounts = $this->applyShipped($amounts, $shipped);

		return $amounts;
	}

	protected function earliestUpdateAt(array $amounts)
	{
		$result = null;

		foreach ($amounts as $amount)
		{
			if (
				$result === null
				|| Market\Data\DateTime::compare($amount['TIMESTAMP_X'], $result) === -1
			)
			{
				$result = $amount['TIMESTAMP_X'];
			}
		}

		return $result;
	}

	protected function processingOrders(Main\Type\DateTime $earliestUpdatedAt = null)
	{
		$statusService = $this->provider->getStatus();
		$result = [];

		$query = Market\Trading\State\Internals\StatusTable::getList([
			'filter' => [
				'=SERVICE' => $this->provider->getUniqueKey(),
				'>TIMESTAMP_X' => $this->getProcessingExpire(),
			],
			'select' => [
				'ENTITY_ID',
				'VALUE',
				'TIMESTAMP_X',
			],
		]);

		while ($row = $query->fetch())
		{
			list($storedStatus, $storedSubstatus) = explode(':', $row['VALUE'], 2);

			if ($statusService->isShipped($storedStatus, $storedSubstatus))
			{
				if ($earliestUpdatedAt !== null && Market\Data\DateTime::compare($row['TIMESTAMP_X'], $earliestUpdatedAt) === -1) { continue; }

				$status = static::ORDER_SHIPPED;
			}
			else if ($statusService->isCanceled($storedStatus))
			{
				continue;
			}
			else
			{
				$status = static::ORDER_PROCESSING;
			}

			$result[$row['ENTITY_ID']] = [
				'STATE' => $status,
				'TIMESTAMP_X' => $row['TIMESTAMP_X'],
			];
		}

		return $result;
	}

	protected function getProcessingExpire()
	{
		$days = (int)Market\Config::getOption('trading_reserve_days', 7);
		$days = max(1, $days);

		$result = new Main\Type\DateTime();
		$result->add(sprintf('-P%sD', $days));
		$result->setTime(0, 0);

		return $result;
	}

	protected function filterFakeOrders(array $orderStates)
	{
		if (empty($orderStates)) { return $orderStates; }

		$queryFakes = Market\Trading\State\Internals\DataTable::getList([
			'filter' => [
				'=SERVICE' => $this->provider->getUniqueKey(),
				'=ENTITY_ID' => array_keys($orderStates),
				'=NAME' => 'FAKE',
				'=VALUE' => 'Y',
			],
			'select' => [ 'ENTITY_ID' ],
		]);

		$fakes = $queryFakes->fetchAll();
		$fakeIds = array_column($fakes, 'ENTITY_ID');

		return array_diff_key($orderStates, array_flip($fakeIds));
	}

	protected function mapExistsOrders(array $orderStates)
	{
		$orderRegistry = $this->environment->getOrderRegistry();
		$orderMap = $orderRegistry->searchList(array_keys($orderStates), $this->platform, false);
		$orderStates = array_intersect_key($orderStates, $orderMap);

		foreach ($orderMap as $externalId => $internalId)
		{
			$orderStates[$externalId]['INTERNAL_ID'] = $internalId;
		}

		return $orderStates;
	}

	protected function splitProcessingOrders(array $orderStates)
	{
		$processing = [];
		$shipped = [];

		foreach ($orderStates as $externalId => $orderState)
		{
			if ($orderState['STATE'] === static::ORDER_PROCESSING)
			{
				$processing[$externalId] = $orderState;
			}
			else
			{
				$shipped[$externalId] = $orderState;
			}
		}

		return [$processing, $shipped];
	}

	protected function configureEnvironment()
	{
		$this->environment->getReserve()->configure([
			'STORES' => $this->provider->getOptions()->getProductStores(),
		]);
	}

	protected function loadReserves(array $orderStates, array $productIds)
	{
		$orderIds = array_column($orderStates, 'INTERNAL_ID');

		return $this->environment->getReserve()->getAmounts($orderIds, $productIds);
	}

	protected function applyReserves(array $amounts, array $reserves)
	{
		foreach ($amounts as &$amount)
		{
			if (!isset($reserves[$amount['ID']])) { continue; }

			$reserve = $reserves[$amount['ID']];

			if (isset($amount['QUANTITY_LIST'][Market\Data\Trading\Stocks::TYPE_FIT]))
			{
				$amount['QUANTITY_LIST'][Market\Data\Trading\Stocks::TYPE_FIT] += $reserve['QUANTITY'];
			}

			if (isset($amount['QUANTITY']))
			{
				$amount['QUANTITY'] += $reserve['QUANTITY'];
			}

			if (Market\Data\DateTime::compare($reserve['TIMESTAMP_X'], $amount['TIMESTAMP_X']) === 1)
			{
				$amount['TIMESTAMP_X'] = $reserve['TIMESTAMP_X'];
			}
		}
		unset($amount);

		return $amounts;
	}

	protected function loadShipped(array $orderStates, array $productIds, Main\Type\DateTime $updatedAt = null)
	{
		$orderIds = array_map(static function($orderState) { return $orderState['INTERNAL_ID']; }, $orderStates);
		$orderMap = array_flip($orderIds);
		$allOrdersProducts = $this->environment->getReserve()->mapProducts($orderIds, $productIds, $updatedAt);
		$result = [];

		foreach ($allOrdersProducts as $internalId => $orderProducts)
		{
			/** @var Main\Type\DateTime $timestamp */
			$externalId = $orderMap[$internalId];
			$timestamp = $orderStates[$externalId]['TIMESTAMP_X'];

			foreach ($orderProducts as $productId)
			{
				if (
					!isset($result[$productId])
					|| Market\Data\DateTime::compare($timestamp, $result[$productId]) === 1
				)
				{
					$result[$productId] = $timestamp;
				}
			}
		}

		return $result;
	}

	protected function applyShipped(array $amounts, array $shipped)
	{
		foreach ($amounts as &$amount)
		{
			if (!isset($shipped[$amount['ID']])) { continue; }

			$timestamp = $shipped[$amount['ID']];

			if (Market\Data\DateTime::compare($timestamp, $amount['TIMESTAMP_X']) === 1)
			{
				$amount['TIMESTAMP_X'] = $timestamp;
			}
		}
		unset($amount);

		return $amounts;
	}
}