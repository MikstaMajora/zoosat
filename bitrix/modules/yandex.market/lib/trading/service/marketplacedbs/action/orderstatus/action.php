<?php

namespace Yandex\Market\Trading\Service\MarketplaceDbs\Action\OrderStatus;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

class Action extends TradingService\Marketplace\Action\OrderStatus\Action
{
	use TradingService\Common\Concerns\Action\HasUserRegistration;
	use TradingService\MarketplaceDbs\Concerns\Action\HasDeliveryDates;
	use TradingService\MarketplaceDbs\Concerns\Action\HasAddress;

	/** @var TradingService\MarketplaceDbs\Provider */
	protected $provider;
	/** @var Request */
	protected $request;

	public function __construct(TradingService\MarketplaceDbs\Provider $provider, TradingEntity\Reference\Environment $environment, Main\HttpRequest $request, Main\Server $server)
	{
		parent::__construct($provider, $environment, $request, $server);
	}

	protected function createRequest(Main\HttpRequest $request, Main\Server $server)
	{
		return new Request($request, $server);
	}

	protected function fillOrder()
	{
		parent::fillOrder();
		$this->fillUser();
		$this->fillContact();
	}

	protected function statusConfiguredAction($status)
	{
		$result = parent::statusConfiguredAction($status);

		if ($result === null && $this->useAutoFinish())
		{
			$result = $this->provider->getOptions()->getStatusOutRaw($status);
		}

		return $result;
	}

	protected function useAutoFinish()
	{
		$delivery = $this->request->getOrder()->getDelivery();
		$partnerType = $delivery->getPartnerType();

		if (!$this->provider->getDelivery()->isShopDelivery($partnerType)) { return false; }

		$deliveryId = $delivery->getShopDeliveryId();
		$deliveryOption = $this->provider->getOptions()->getDeliveryOptions()->getItemByServiceId($deliveryId);

		if ($deliveryOption === null) { return false; }

		return $deliveryOption->useAutoFinish();
	}

	protected function fillProperties()
	{
		$this->fillBuyerProperties();
		$this->fillAddressProperties();
		$this->fillDeliveryDatesProperties();
		$this->fillUtilProperties();
		$this->fillCancelReasonProperty();
	}

	protected function fillBuyerProperties()
	{
		$order = $this->request->getOrder();
		$buyer = $order->getBuyer();

		if ($buyer === null) { return null; }

		$statusService = $this->provider->getStatus();
		$status = $order->getStatus();
		$isFinal = ($statusService->isOrderDelivered($status) || $statusService->isCanceled($status));
		$values = $buyer->getMeaningfulValues() + $buyer->getCompatibleValues();

		if ($isFinal)
		{
			$values['PHONE'] = '';
			$this->clearBuyerPhoneTask();
		}
		else if (!isset($values['PHONE']) && $this->hasBuyerPhoneProperty() && $this->isBuyerPhoneExpired())
		{
			$this->createBuyerPhoneTask();
		}

		$this->setMeaningfulPropertyValues($values);
	}

	protected function clearBuyerPhoneTask()
	{
		$setupId = $this->provider->getOptions()->getSetupId();
		list($task) = $this->makeOrderTask();

		$task->clear($setupId, 'fill/phone');
	}

	protected function createBuyerPhoneTask()
	{
		$setupId = $this->provider->getOptions()->getSetupId();
		list($task, $payload) = $this->makeOrderTask();

		$task->clear($setupId, 'fill/phone');
		$task->schedule($setupId, 'fill/phone', $payload);
	}

	protected function hasBuyerPhoneProperty()
	{
		return (string)$this->provider->getOptions()->getProperty('PHONE') !== '';
	}

	protected function isBuyerPhoneExpired()
	{
		$uniqueKey = $this->provider->getUniqueKey();
		$orderId = $this->request->getOrder()->getId();
		$timestamp = Market\Trading\State\OrderData::getTimestamp($uniqueKey, $orderId, 'PHONE');

		if ($timestamp === null) { return true; }

		$limit = new Main\Type\DateTime();
		$limit->add('-P7D');

		return ($timestamp->getTimestamp() <= $limit->getTimestamp());
	}

	protected function makeOrderTask()
	{
		$orderNum = $this->order->getAccountNumber();
		$task = new Market\Trading\Procedure\Task(TradingEntity\Registry::ENTITY_TYPE_ORDER, $orderNum);
		$payload = [
			'internalId' => $this->order->getId(),
			'orderId' => $this->request->getOrder()->getId(),
			'orderNum' => $orderNum,
		];

		return [$task, $payload];
	}

	protected function fillCancelReasonProperty()
	{
		$requestOrder = $this->request->getOrder();
		$status = $requestOrder->getStatus();
		$subStatus = $requestOrder->getSubStatus();

		if ($status !== TradingService\MarketplaceDbs\Status::STATUS_CANCELLED) { return; }

		$propertyId = (string)$this->provider->getOptions()->getProperty('REASON_CANCELED');

		if ($propertyId === '') { return; }

		$fillResult = $this->order->fillProperties([
			$propertyId => $subStatus,
		]);
		$fillData = $fillResult->getData();

		if (!empty($fillData['CHANGES']))
		{
			$this->pushChange('PROPERTIES', $fillData['CHANGES']);
		}
	}

	protected function fillUser()
	{
		$buyer = $this->request->getOrder()->getBuyer();

		if ($buyer !== null && $this->needUserRegister() && $this->isOrderUserAnonymous())
		{
			$buyerData = $buyer->getMeaningfulValues();
			$userRegistry = $this->environment->getUserRegistry();
			$user = $userRegistry->getUser($buyerData);

			$this->configureUserRule($user);

			if (!$user->isInstalled())
			{
				$this->registerUser($user);
			}

			$this->attachUserToGroup($user);
			$this->changeOrderUser($user);
			$this->pushChange('USER', $user->getId());
		}
	}

	protected function isOrderUserAnonymous()
	{
		$userId = $this->order->getUserId();

		return (
			$userId === null
			|| $userId === $this->getAnonymousUser()->getId()
		);
	}

	protected function getAnonymousUser()
	{
		$userRegistry = $this->environment->getUserRegistry();

		return $userRegistry->getAnonymousUser($this->provider->getServiceCode(), $this->getSiteId());
	}

	protected function fillContact()
	{
		try
		{
			$command = new TradingService\Common\Command\OrderContact(
				$this->provider,
				$this->environment,
				$this->order
			);

			if ($command->needExecute())
			{
				$command->execute();
				$this->pushChange('CONTACTS', $this->order->getContacts());
			}
		}
		catch (Main\SystemException $exception)
		{
			$this->provider->getLogger()->warning($exception);
		}
	}

	protected function updateOrder()
	{
		parent::updateOrder();
		$this->saveProfile();
	}

	protected function saveProfile()
	{
		if ($this->getChange('USER') === null) { return; }

		$values = $this->order->getPropertyValues();
		$values = array_filter($values);

		$command = new TradingService\Common\Command\SaveBuyerProfile(
			$this->provider,
			$this->environment,
			$this->order->getUserId(),
			$this->order->getPersonType(),
			$this->order->getProfileName(),
			$values
		);
		$command->execute();
	}

	protected function makeData()
	{
		return
			$this->makeStatusData()
			+ $this->makeDeliveryData()
			+ $this->makeItemsData();
	}

	protected function makeDeliveryData()
	{
		$order = $this->request->getOrder();

		if (!$order->hasDelivery()) { return []; }

		$delivery = $order->getDelivery();
		$dates = $delivery->getDates();
		$deliveryDate = $dates !== null ? $dates->getFrom() : null;
		$realDeliveryDate = $dates !== null ? $dates->getRealDeliveryDate() : null;

		$result = [
			'DELIVERY_SERVICE_ID' => $delivery->getServiceId(),
			'DELIVERY_DATE' => $deliveryDate !== null
				? $deliveryDate->format(Market\Data\Date::FORMAT_DEFAULT_SHORT)
				: null,
		];

		if ($realDeliveryDate !== null)
		{
			$result['REAL_DELIVERY_DATE'] = $realDeliveryDate->format(Market\Data\Date::FORMAT_DEFAULT_SHORT);
		}

		if ($delivery->hasShopDeliveryId()) // status sync support
		{
			$result['DELIVERY_ID'] = $delivery->getShopDeliveryId();
		}

		return $result;
	}
}