<?php

namespace Yandex\Market\Trading\State;

use Bitrix\Main;
use Yandex\Market;
use Yandex\Market\Trading\Service as TradingService;

class OrderStatusSync extends Internals\AgentSkeleton
{
	protected static $expireDate;

	public static function getDefaultParams()
	{
		return [
			'interval' => static::getPeriod('restart', 86400),
		];
	}

	public static function start($setupId)
	{
		static::register([
			'method' => 'sync',
			'arguments' => [ $setupId ],
			'interval' => static::getPeriod('step', static::PERIOD_STEP_DEFAULT),
		]);
	}

	public static function sync($setupId, $offset = 0, $errorCount = 0)
	{
		return static::wrapAction(
			[static::class, 'syncBody'],
			[ $setupId, $offset ],
			$errorCount
		);
	}

	protected static function syncBody($setupId, $offset = 0)
	{
		$setup = static::getSetup($setupId);
		$service = $setup->wakeupService();
		$orderCollection = static::loadOrderCollection($service, $offset);
		$pager = $orderCollection->getPager();
		$hasNext = ($pager !== null && $pager->hasNext());
		$orders = static::mapOrderCollection($orderCollection);
		$orders = static::applyOffset($orders, $offset);
		$accountNumberMap = static::getAccountNumberMap($orders, $setup);

		foreach ($orders as $orderId => $order)
		{
			++$offset;

			if (!isset($accountNumberMap[$orderId])) { continue; }
			if (!static::isChanged($service, $order)) { continue; }

			if (static::isTimeExpired())
			{
				$hasNext = true;
				break;
			}

			if (static::emulateStatus($setup, $order, $accountNumberMap[$orderId]))
			{
				static::commit($service, $order);
			}
		}

		return $hasNext ? [ $setupId, $offset ] : false;
	}

	protected static function getOptionPrefix()
	{
		return 'trading_status_sync';
	}

	protected static function getPageSize()
	{
		$name = static::optionName('page_size');
		$option = (int)Market\Config::getOption($name, 10);

		return max(1, min(50, $option));
	}

	/**
	 * @param TradingService\Reference\Provider $service
	 * @param int $offset
	 *
	 * @return Market\Api\Model\OrderCollection
	 * @throws Main\SystemException
	 */
	protected static function loadOrderCollection(TradingService\Reference\Provider $service, $offset = 0)
	{
		/** @var Market\Api\Reference\HasOauthConfiguration $options */
		$options = $service->getOptions();
		$pageSize = static::getPageSize();
		$parameters = [
			'page' => floor($offset / $pageSize) + 1,
			'pageSize' => $pageSize,
		];

		$orderFacade = $service->getModelFactory()->getOrderFacadeClassName();

		return $orderFacade::loadList($options, $parameters);
	}

	protected static function mapOrderCollection(Market\Api\Model\OrderCollection $orderCollection)
	{
		$result = [];

		foreach ($orderCollection as $order)
		{
			$result[$order->getId()] = $order;
		}

		return $result;
	}

	protected static function applyOffset(array $orders, $offset = 0)
	{
		$pageOffset = $offset % static::getPageSize();

		if ($pageOffset === 0) { return $orders; }

		return array_slice($orders, $pageOffset, null, true);
	}

	protected static function getAccountNumberMap(array $orders, Market\Trading\Setup\Model $setup)
	{
		return $setup->getEnvironment()->getOrderRegistry()->searchList(
			array_keys($orders),
			$setup->getPlatform(),
			false
		);
	}

	protected static function isChanged(TradingService\Reference\Provider $service, Market\Api\Model\Order $order)
	{
		$current = $order->getStatus();
		$storedFull = OrderStatus::getValue($service->getUniqueKey(), $order->getId());

		if ($storedFull === null && static::isExpired($order)) { return false; }

		list($stored) = explode(':', (string)$storedFull, 2);

		if ($stored === $current) { return false; }

		$storedOrder = $service->getStatus()->getStatusOrder($stored);
		$currentOrder = $service->getStatus()->getStatusOrder($current);

		return ($currentOrder !== null && $currentOrder > $storedOrder);
	}

	protected static function isExpired(Market\Api\Model\Order $order)
	{
		$expireDate = static::getExpireDate();
		$createDate = $order->getCreationDate();

		return Market\Data\DateTime::compare($createDate, $expireDate) === -1;
	}

	protected static function getExpireDate()
	{
		if (static::$expireDate === null)
		{
			$expireDays = Internals\DataCleaner::getExpireDays('status');
			$expireDate = new Main\Type\DateTime();
			$expireDate->add(sprintf('-P%sD', $expireDays));

			static::$expireDate = $expireDate;
		}

		return static::$expireDate;
	}

	protected static function commit(TradingService\Reference\Provider $service, Market\Api\Model\Order $order)
	{
		if (static::isChanged($service, $order))
		{
			$statusEncoded = implode(':', [
				$order->getStatus(),
				$order->getSubStatus()
			]);

			OrderStatus::setValue($service->getUniqueKey(), $order->getId(), $statusEncoded);
		}

		OrderStatus::commit($service->getUniqueKey(), $order->getId());
	}

	protected static function emulateStatus(Market\Trading\Setup\Model $setup, Market\Api\Model\Order $order, $accountNumber)
	{
		$logger = null;
		$audit = null;

		try
		{
			$environment = $setup->getEnvironment();
			$service = $setup->wakeupService();
			$logger = $service->getLogger();
			$server = Main\Context::getCurrent()->getServer();
			$request = static::makeRequestFromOrder($server, $order);

			$action = $service->getRouter()->getHttpAction('order/status', $environment, $request, $server);
			$audit = $action->getAudit();

			$action->process();

			$result = true;
		}
		catch (Main\SystemException $exception)
		{
			if ($logger === null) { throw $exception; }

			$logger->error($exception, array_filter([
				'AUDIT' => $audit,
				'ENTITY_TYPE' => Market\Trading\Entity\Registry::ENTITY_TYPE_ORDER,
				'ENTITY_ID' => $accountNumber,
			]));

			$result = false;
		}

		return $result;
	}

	protected static function makeRequestFromOrder(Main\Server $server, Market\Api\Model\Order $order)
	{
		return new Main\HttpRequest(
			$server,
			[], // query string
			[
				'order' => $order->getFields(),
				'emulated' => true,
			], // post
			[], // files
			[] // cookies
		);
	}
}