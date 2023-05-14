<?php

namespace Yandex\Market\Trading\Service\Marketplace\Action\OrderStatus;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

class Action extends TradingService\Common\Action\OrderStatus\Action
{
	/** @var TradingService\Marketplace\Provider */
	protected $provider;
	/** @var Request */
	protected $request;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
		parent::includeMessages();
	}

	public function __construct(TradingService\Marketplace\Provider $provider, TradingEntity\Reference\Environment $environment, Main\HttpRequest $request, Main\Server $server)
	{
		parent::__construct($provider, $environment, $request, $server);
	}

	protected function createRequest(Main\HttpRequest $request, Main\Server $server)
	{
		return new Request($request, $server);
	}

	protected function loadOrder()
	{
		try
		{
			parent::loadOrder();
		}
		catch (Main\InvalidOperationException $exception)
		{
			$proxyException = new Market\Exceptions\Trading\NotRecoverable($exception->getMessage(), $exception->getCode(), '', 0, $exception);
			$status = $this->request->getOrder()->getStatus();
			$subStatus = $this->request->getOrder()->getSubStatus();

			if ($this->provider->getStatus()->isCanceled($status, $subStatus))
			{
				$proxyException->setLogLevel(Market\Logger\Level::DEBUG);
			}

			throw $proxyException;
		}
	}

	protected function fillOrder()
	{
		parent::fillOrder();
		$this->fillItems();
	}

	protected function makeStatusInSearchVariants($status)
	{
		$result = [
			$status,
		];

		if ($status === TradingService\MarketplaceDbs\Status::STATUS_PROCESSING && $this->isPrepaid())
		{
			array_unshift($result, $status . '_PREPAID');
		}
		else if ($status === TradingService\MarketplaceDbs\Status::STATUS_DELIVERED && !$this->isPrepaid())
		{
			array_unshift($result, $status . '_POSTPAID');
		}

		return $result;
	}

	protected function isPrepaid()
	{
		$paymentType = $this->request->getOrder()->getPaymentType();

		return $this->provider->getPaySystem()->isPrepaid($paymentType);
	}

	protected function fillUtilProperties()
	{
		$meaningfulValues = $this->request->getOrder()->getMeaningfulValues();

		if (!$this->request->isEmulated())
		{
			$meaningfulValues += [
				'ELECTRONIC_ACCEPTANCE_CERTIFICATE' => '',
				'VEHICLE_NUMBER' => '',
			];
		}

		$this->setMeaningfulPropertyValues($meaningfulValues);
	}

	protected function fillItems()
	{
		$items = $this->request->getOrder()->getItems();
		$offerMap = $this->getOfferMap($items);
		$ratioMap = $this->getRatioMap($items, $offerMap);
		$basketMap = $this->getBasketMap($items, $offerMap);
		$basketMissing = $this->getBasketMissing($basketMap);

		if (count($basketMap) !== $items->count())
		{
			$message = static::getLang('TRADING_ACTION_ORDER_STATUS_ITEMS_NOT_MATCHED_BASKET', [
				'#BASKET_COUNT#' => count($basketMap),
				'#ITEMS_COUNT#' => $items->count(),
			]);
			$this->provider->getLogger()->warning($message);
			return;
		}

		$this->updateItemsQuantity($items, $basketMap, $ratioMap);
		$this->deleteBasketMissing($basketMissing);
	}

	protected function updateItemsQuantity(Market\Api\Model\Order\ItemCollection $items, $basketMap, $ratioMap)
	{
		$changes = [];

		/** @var Market\Api\Model\Order\Item $item */
		foreach ($items as $index => $item)
		{
			$basketCode = $basketMap[$item->getInternalId()];
			$basketResult = $this->order->getBasketItemData($basketCode);

			if (!$basketResult->isSuccess())
			{
				$message = static::getLang('TRADING_ACTION_ORDER_STATUS_ITEM_BASKET_ERROR', [
					'#ITEM_NAME#' => $this->getItemName($item),
					'#MESSAGE#' => implode(', ', $basketResult->getErrorMessages()),
				]);
				$this->provider->getLogger()->warning($message);
				continue;
			}

			$basketData = $basketResult->getData();

			if (!isset($basketData['QUANTITY']))
			{
				$message = static::getLang('TRADING_ACTION_ORDER_STATUS_ITEM_BASKET_DATA_QUANTITY_MISSING', [
					'#ITEM_NAME#' => $this->getItemName($item),
					'#MESSAGE#' => implode(', ', $basketResult->getErrorMessages()),
				]);
				$this->provider->getLogger()->warning($message);
				continue;
			}

			$basketQuantity = (float)$basketData['QUANTITY'];
			$ratio = isset($ratioMap[$index]) ? $ratioMap[$index] : 1;
			$itemCount = $item->getCount() * $ratio;

			if (Market\Data\Quantity::equal($basketQuantity, $itemCount)) { continue; }

			$setResult = $this->order->setBasketItemQuantity($basketCode, $itemCount);

			if (!$setResult->isSuccess())
			{
				$message = static::getLang('TRADING_ACTION_ORDER_STATUS_ITEM_SET_QUANTITY_ERROR', [
					'#ITEM_NAME#' => $this->getItemName($item),
					'#MESSAGE#' => implode(', ', $setResult->getErrorMessages()),
				]);
				$this->provider->getLogger()->warning($message);
				continue;
			}

			$changes[] = [
				'BASKET_CODE' => $basketCode,
				'QUANTITY' => $itemCount,
			];
		}

		if (!empty($changes))
		{
			$this->pushChange('BASKET.QUANTITY', $changes);
		}
	}

	protected function deleteBasketMissing($basketCodes)
	{
		$changes = [];

		foreach ($basketCodes as $basketCode)
		{
			$deleteResult = $this->order->deleteBasketItem($basketCode);

			if (!$deleteResult->isSuccess())
			{
				$message = static::getLang('TRADING_ACTION_ORDER_STATUS_ITEM_DELETE_ERROR', [
					'#ITEM_NAME#' => $this->getBasketItemName($basketCode),
					'#MESSAGE#' => implode(', ', $deleteResult->getErrorMessages()),
				]);
				$this->provider->getLogger()->warning($message);
				continue;
			}

			$changes[] = [
				'BASKET_CODE' => $basketCode,
			];
		}

		if (!empty($changes))
		{
			$this->pushChange('BASKET.DELETE', $changes);
		}
	}

	protected function getBasketMap(Market\Api\Model\Order\ItemCollection $items, $offerMap = null)
	{
		$result = [];

		/** @var Market\Api\Model\Order\Item $item */
		foreach ($items as $item)
		{
			$basketCode = $this->getItemBasketCode($item, $offerMap);

			if ($basketCode === null) { continue; }

			$result[$item->getInternalId()] = $basketCode;
		}

		return $result;
	}

	protected function getBasketMissing($foundCodes)
	{
		$existsCodes = $this->order->getExistsBasketItemCodes();
		$notFoundCodes = array_diff($existsCodes, $foundCodes);
		$result = [];

		foreach ($notFoundCodes as $basketCode)
		{
			$basketData = $this->order->getBasketItemData($basketCode)->getData();

			if (isset($basketData['XML_ID']))
			{
				$match = $this->provider->getDictionary()->parseOrderItemXmlId($basketData['XML_ID']);

				if ($match === null) { continue; }
			}

			$result[] = $basketCode;
		}

		return $result;
	}

	protected function getOfferMap(Market\Api\Model\Order\ItemCollection $items)
	{
		$offerIds = $items->getOfferIds();
		$command = new TradingService\Common\Command\OfferMap(
			$this->provider,
			$this->environment
		);

		return $command->make($offerIds);
	}

	protected function getRatioMap(Market\Api\Model\Cart\ItemCollection $items, $offerMap = null)
	{
		$productIds = $offerMap !== null ? array_values($offerMap) : $items->getOfferIds();
		$command = new TradingService\Common\Command\OfferPackRatio($this->provider, $this->environment);
		$result = [];

		$packRatio = $command->make($productIds);

		/** @var Market\Api\Model\Cart\Item $item */
		foreach ($items as $index => $item)
		{
			$productId = $item->mapProductId($offerMap);

			if ($productId === null) { continue; }
			if (!isset($packRatio[$productId])) { continue; }

			$result[$index] = $packRatio[$productId];
		}

		return $result;
	}

	protected function getItemBasketCode(Market\Api\Model\Order\Item $item, $offerMap = null)
	{
		$xmlId = $this->provider->getDictionary()->getOrderItemXmlId($item);
		$productId = $item->mapProductId($offerMap);
		$result = $this->order->getBasketItemCode($xmlId, 'XML_ID');

		if ($result === null && $productId !== null)
		{
			$result = $this->order->getBasketItemCode($productId);
		}

		return $result;
	}

	protected function getItemName(Market\Api\Model\Cart\Item $item)
	{
		$offerName = $item->getOfferName();

		if ($offerName !== '')
		{
			$result = sprintf('[%s] %s', $item->getOfferId(), $item->getOfferName());
		}
		else
		{
			$offerId = $item->getOfferId();

			$result = static::getLang('TRADING_ACTION_ORDER_STATUS_ITEM_NAME_FALLBACK', [
				'#OFFER_ID#' => $offerId,
			], $offerId);
		}

		return $result;
	}

	protected function getBasketItemName($basketCode)
	{
		$basketData = $this->order->getBasketItemData($basketCode)->getData();
		$result = isset($basketData['NAME']) ? trim($basketData['NAME']) : '';

		if ($result === '')
		{
			$result = static::getLang('TRADING_ACTION_ORDER_STATUS_BASKET_ITEM_NAME_FALLBACK', [
				'#BASKET_CODE#' => $basketCode,
			], $basketCode);
		}

		return $result;
	}

	protected function makeStatusPayload($meaningfulStatus)
	{
		if ($meaningfulStatus === Market\Data\Trading\MeaningfulStatus::PAYED)
		{
			$result = [
				'EXCLUDE' => [
					'SUBSIDY' => true,
				],
			];
		}
		else
		{
			$result = parent::makeStatusPayload($meaningfulStatus);
		}

		return $result;
	}

	protected function makeData()
	{
		return
			$this->makeStatusData()
			+ $this->makeAcceptanceData()
			+ $this->makeDeliveryData()
			+ $this->makeItemsData();
	}

	protected function makeAcceptanceData()
	{
		$order = $this->request->getOrder();
		$result = [
			'ELECTRONIC_ACCEPTANCE_CERTIFICATE' => $order->getElectronicAcceptanceCertificate(),
			'VEHICLE_NUMBER' => $order->getVehicleNumber(),
		];

		if ($this->request->isEmulated())
		{
			$result = array_filter($result);
		}

		return $result;
	}

	protected function makeDeliveryData()
	{
		$order = $this->request->getOrder();

		if (!$order->hasDelivery()) { return []; }

		$delivery = $order->getDelivery();
		$shipment = $delivery->getShipments()->current();

		return [
			'SHIPMENT_ID' => $shipment !== false ? $shipment->getId() : null,
		];
	}

	protected function makeItemsData()
	{
		$items = $this->request->getOrder()->getItems();

		return [
			'ITEMS_TOTAL' => $items->getTotalCount(),
		];
	}
}