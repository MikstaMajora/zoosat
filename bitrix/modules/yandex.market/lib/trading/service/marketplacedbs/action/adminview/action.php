<?php

namespace Yandex\Market\Trading\Service\MarketplaceDbs\Action\AdminView;

use Bitrix\Main;
use Yandex\Market;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

/**
 * @property TradingService\MarketplaceDbs\Model\Order $externalOrder
 * @property TradingService\MarketplaceDbs\Provider $provider
 */
class Action extends TradingService\Marketplace\Action\AdminView\Action
	implements TradingService\Reference\Action\HasActivity
{
	use Market\Reference\Concerns\HasMessage;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
		parent::includeMessages();
	}

	public function getActivity()
	{
		return new Activity($this->provider, $this->environment);
	}

	public function process()
	{
		parent::process();
		$this->collectBuyer();
	}

	protected function getOrderRow()
	{
		$serviceUniqueKey = $this->provider->getUniqueKey();

		return parent::getOrderRow() + [
			'AUTO_FINISH' => $this->isAutoFinishUsed(),
			'CANCELLATION_ACCEPT' => Market\Trading\State\OrderData::getValue($serviceUniqueKey, $this->externalOrder->getId(), 'CANCELLATION_ACCEPT'),
		];
	}

	protected function isAutoFinishUsed()
	{
		$delivery = $this->externalOrder->getDelivery();
		$partnerType = $delivery->getPartnerType();

		if (!$this->provider->getDelivery()->isShopDelivery($partnerType)) { return false; }

		$deliveryId = $delivery->getShopDeliveryId();
		$deliveryOption = $this->provider->getOptions()->getDeliveryOptions()->getItemByServiceId($deliveryId);

		if ($deliveryOption === null) { return false; }

		return $deliveryOption->useAutoFinish();
	}

	protected function collectOrderActions()
	{
		$actions = array_filter([
			TradingEntity\Operation\Order::ITEM => $this->isOrderProcessing(),
			TradingEntity\Operation\Order::BOX => $this->isOrderProcessing(),
			TradingEntity\Operation\Order::CIS => $this->isOrderProcessing(),
			TradingEntity\Operation\Order::DIGITAL => (
				$this->isOrderProcessing()
				&& !$this->isOrderShipped()
				&& $this->externalOrder->hasDelivery()
				&& $this->externalOrder->getDelivery()->getType() === TradingService\MarketplaceDbs\Delivery::TYPE_DIGITAL
			),
		]);
		$actions = $this->filterOrderActionsByAccess($actions);

		$this->response->setField('orderActions', $actions);
	}

	protected function collectShipments()
	{
		// nothing
	}

	/** @deprecated */
	protected function collectTracks()
	{
		$delivery = $this->externalOrder->getDelivery();
		$tracks = $delivery->getTracks();

		if ($tracks === null) { return; }

		$codes = [];

		foreach ($tracks as $track)
		{
			$codes[] = (string)$track->getTrackCode();
		}

		if (empty($codes)) { return; }

		$this->response->pushField('properties', [
			'ID' => 'TRACKS',
			'NAME' => self::getMessage('PROPERTY_TRACKING_NUMBER'),
			'VALUE' => implode(', ', $codes),
		]);
	}

	protected function getPropertyFields()
	{
		$result = parent::getPropertyFields();
		$insertMap = [
			'cancelRequested' => [
				'cancellationAccept',
			],
			'paymentMethod' => [
				'paymentTotal',
				'subsidyTotal',
			],
		];

		foreach ($insertMap as $search => $new)
		{
			$searchIndex = array_search($search, $result);

			if ($searchIndex === false)
			{
				array_push($result, ...$new);
			}
			else
			{
				array_splice($result, $searchIndex + 1, 0, $new);
			}
		}

		return $result;
	}

	protected function getPropertyValue($propertyName)
	{
		if ($propertyName === 'paymentTotal')
		{
			$result = $this->externalOrder->getTotal();
		}
		else if ($propertyName === 'cancellationAccept')
		{
			$result = Market\Trading\State\OrderData::getValue(
				$this->provider->getUniqueKey(),
				$this->externalOrder->getId(),
				'CANCELLATION_ACCEPT'
			);
		}
		else
		{
			$result = parent::getPropertyValue($propertyName);
		}

		return $result;
	}

	protected function formatPropertyValue($propertyName, $propertyValue)
	{
		if ($propertyName === 'paymentTotal')
		{
			$result = Market\Data\Currency::format(
				$propertyValue,
				$this->externalOrder->getCurrency()
			);
		}
		else if ($propertyName === 'subsidyTotal')
		{
			if ((float)$propertyValue <= 0.0) { return ''; }

			$result = Market\Data\Currency::format(
				$propertyValue,
				$this->externalOrder->getCurrency()
			);
		}
		else if ($propertyName === 'cancellationAccept')
		{
			$result = Market\Data\Trading\CancellationAccept::getStateTitle($propertyValue);
		}
		else
		{
			$result = parent::formatPropertyValue($propertyName, $propertyValue);
		}

		return $result;
	}

	protected function getPropertyTitle($propertyName)
	{
		if ($propertyName === 'paymentTotal' && $this->isPaymentPrepaid())
		{
			$propertyName .= '_PAID';
		}

		return parent::getPropertyTitle($propertyName);
	}

	protected function getPropertyData($propertyName)
	{
		if ($propertyName === 'cancellationAccept')
		{
			return [
				'ACTIVITY' => 'send/cancellation/accept',
			];
		}

		return parent::getPropertyData($propertyName);
	}

	protected function getDeliveryFields()
	{
		return [
			'price',
			'lift',
			'dates',
			'type',
			'region',
			'outlet',
			'address',
			'coordinates',
		];
	}

	/** @noinspection PhpUnused */
	protected function getDeliveryLiftValue(Market\Api\Model\Order\Delivery $delivery)
	{
		if (!($delivery instanceof TradingService\MarketplaceDbs\Model\Order\Delivery)) { return null; }
		if ($delivery->getLiftType() === null) { return null; }
		if ($delivery->getLiftType() === TradingService\MarketplaceDbs\Delivery::LIFT_NOT_NEEDED) { return null; }

		return [
			'TYPE' => $delivery->getLiftType(),
			'PRICE' => $delivery->getLiftPrice(),
		];
	}

	/** @noinspection PhpUnused */
	protected function formatDeliveryLiftValue(
		Market\Api\Model\Order\Delivery $delivery,
		array $liftData
	)
	{
		$currency = $this->externalOrder->getCurrency();

		return self::getMessage('DELIVERY_LIFT_FORMAT', [
			'#TYPE#' => $this->provider->getDelivery()->getLiftTitle($liftData['TYPE']),
			'#PRICE#' => Market\Data\Currency::format($liftData['PRICE'], $currency),
		]);
	}

	/** @noinspection PhpUnused */
	protected function getDeliveryCoordinatesValue(Market\Api\Model\Order\Delivery $delivery)
	{
		if (!($delivery instanceof TradingService\MarketplaceDbs\Model\Order\Delivery)) { return null; }

		$address = $delivery->getAddress();

		if ($address === null) { return null; }

		$result = [
			'LAT' => $address->getLat(),
			'LON' => $address->getLon(),
		];

		if (count(array_filter($result)) !== count($result)) { return null; }

		return $result;
	}

	/** @noinspection PhpUnused */
	protected function formatDeliveryAddressValue(
		Market\Api\Model\Order\Delivery $delivery,
		TradingService\MarketplaceDbs\Model\Order\Delivery\Address $address
	)
	{
		return $address->getMeaningfulAddress();
	}

	/** @noinspection PhpUnused */
	protected function formatDeliveryOutletValue(
		Market\Api\Model\Order\Delivery $delivery,
		TradingService\MarketplaceDbs\Model\Order\Delivery\Outlet $outlet
	)
	{
		$result = $this->formatDeliveryOutletByStore($outlet);

		if ($result === null)
		{
			$result = $this->formatDeliveryOutletByRegistry($outlet);
		}

		return $result;
	}

	protected function formatDeliveryOutletByStore(TradingService\MarketplaceDbs\Model\Order\Delivery\Outlet $outlet)
	{
		$storeField = (string)$this->provider->getOptions()->getOutletStoreField();
		$code = $outlet->getCode();

		if ($storeField === '') { return null; }

		$storeService = $this->environment->getStore();
		$storeId = $storeService->findStore($storeField, $code);

		if ($storeId === null) { return null; }

		$result = null;

		foreach ($storeService->getEnum() as $storeOption)
		{
			if ((string)$storeId !== (string)$storeOption['ID']) { continue; }

			$result = $storeOption['VALUE'];
			break;
		}

		return $result;
	}

	protected function formatDeliveryOutletByRegistry(TradingService\MarketplaceDbs\Model\Order\Delivery\Outlet $outlet)
	{
		$stored = Market\Trading\State\EntityRegistry::get(
			$this->provider->getOptions()->getSetupId(),
			TradingEntity\Registry::ENTITY_TYPE_OUTLET,
			$outlet->getCode()
		);

		if ($stored === null) { return null; }

		$outletDetails = new Market\Api\Model\Outlet($stored);
		$coords = $outletDetails->getCoords();
		$address = TradingService\MarketplaceDbs\Model\Order\Delivery\Address::fromOutlet($outletDetails);
		$addressString = $address->getMeaningfulAddress();

		if ($coords !== null)
		{
			$url = 'https://yandex.ru/maps/?' . http_build_query([
				'pt' => implode(',', [
					$coords->getLon(),
					$coords->getLat(),
				]),
				'z' => 14,
			]);

			$addressString = sprintf('<a href="%s" target="_blank">%s</a>', $url, $addressString);
		}

		return sprintf(
			'[%s] %s: %s',
			$outlet->getCode(),
			$outletDetails->getName(),
			$addressString
		);
	}

	protected function getDeliveryData($name)
	{
		if ($name === 'dates')
		{
			return [
				'ACTIVITY' => 'send/delivery/date',
			];
		}

		return parent::getDeliveryData($name);
	}

	protected function collectBuyer()
	{
		if (!$this->isOrderConfirmed()) { return; }

		$activities = $this->getBuyerActivities();

		foreach ($this->getBuyerFields() as $name)
		{
			$value = $this->getBuyerValue($name);
			$activity = isset($activities[$name]) ? $activities[$name] : null;
			$valid = false;
			$formatted = '';

			if ($activity !== null) { $valid = true; }

			if ($value !== null)
			{
				$formatted = (string)$this->formatBuyerValue($name, $value);
				$valid = ($valid || $formatted !== '');
			}

			if (!$valid) { continue; }

			$this->response->pushField('buyer', [
				'ID' => $name,
				'NAME' => $this->getBuyerTitle($name),
				'VALUE' => $formatted,
				'ACTIVITY' => $activity,
			]);
		}
	}

	protected function getBuyerFields()
	{
		return [
			'name',
			'phone',
			'email',
		];
	}

	protected function getBuyerActivities()
	{
		return [
			'phone' => 'admin/view|buyer',
		];
	}

	protected function getBuyerValue($name)
	{
		$actionMethod = 'getBuyer' . Market\Data\TextString::ucfirst($name) . 'Value';
		$getMethod = 'get' . Market\Data\TextString::ucfirst($name);
		$buyer = $this->externalOrder->getBuyer();

		if ($buyer === null) { return null; }

		if (method_exists($this, $actionMethod))
		{
			$result = $this->{$actionMethod}($buyer);
		}
		else if (method_exists($buyer, $getMethod))
		{
			$result = $buyer->{$getMethod}();
		}
		else
		{
			$result = $buyer->getField($name);
		}

		return $result;
	}

	protected function formatBuyerValue($name, $value)
	{
		$actionMethod = 'formatBuyer' . Market\Data\TextString::ucfirst($name) . 'Value';
		$buyer = $this->externalOrder->getBuyer();

		if (method_exists($this, $actionMethod))
		{
			$result = $this->{$actionMethod}($buyer, $value);
		}
		else
		{
			$result = is_array($value) ? implode(', ', $value) : (string)$value;
		}

		return $result;
	}

	/** @noinspection PhpUnused */
	protected function getBuyerNameValue(TradingService\MarketplaceDbs\Model\Order\Buyer $buyer)
	{
		$format = \CSite::getNameFormat(false);
		$data = [
			'NAME' => $buyer->getFirstName(),
			'LAST_NAME' => $buyer->getLastName(),
			'SECOND_NAME' => $buyer->getMiddleName(),
		];

		return \CUser::FormatName($format, $data, false, false);
	}

	protected function getBuyerTitle($name)
	{
		$nameUpper = Market\Data\TextString::toUpper($name);

		return static::getLang('TRADING_MARKETPLACE_ORDER_VIEW_BUYER_' . $nameUpper, null, $name);
	}

	protected function getBasketColumns()
	{
		$result = parent::getBasketColumns();

		if (
			$this->externalOrder->hasDelivery()
			&& $this->externalOrder->getDelivery()->getType() === TradingService\MarketplaceDbs\Delivery::TYPE_DIGITAL
		)
		{
			array_splice($result, 1, 0, [ 'DIGITAL' ]);
		}

		return $result;
	}

	protected function getBasketSummaryValues()
	{
		$currency = $this->externalOrder->getCurrency();

		return array_filter([
			'ITEMS_TOTAL' => Market\Data\Currency::format($this->externalOrder->getItemsTotal(), $currency),
			'SUBSIDY_TOTAL' => $this->externalOrder->getSubsidyTotal() > 0
				? Market\Data\Currency::format($this->externalOrder->getSubsidyTotal(), $currency)
				: null,
			'DELIVERY' => $this->externalOrder->hasDelivery()
				? Market\Data\Currency::format($this->externalOrder->getDelivery()->getPrice(), $currency)
				: null,
			'TOTAL' => Market\Data\Currency::format($this->externalOrder->getTotal(), $currency),
		]);
	}
}