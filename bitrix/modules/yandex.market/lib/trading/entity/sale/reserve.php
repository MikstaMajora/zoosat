<?php

namespace Yandex\Market\Trading\Entity\Sale;

use Yandex\Market;
use Yandex\Market\Trading\Entity\Reference as EntityReference;
use Yandex\Market\Trading\Entity\Common as EntityCommon;
use Bitrix\Main;
use Bitrix\Sale;

class Reserve extends EntityReference\Reserve
{
	protected $usedAvailableQuantity = true;

	public function configure(array $context)
	{
		$this->usedAvailableQuantity = in_array(EntityCommon\Store::PRODUCT_FIELD_QUANTITY, $context['STORES'], true);
	}

	public function getAmounts(array $orderIds, array $productIds)
	{
		list($reservedOrders, $shippedOrders) = $this->groupOrders($orderIds);

		$reserveBasket = $this->mapBasketProducts(
			array_unique(array_column($reservedOrders, 'ORDER_ID')),
			$productIds
		);
		$shippedBasket = $this->mapBasketProducts(
			array_unique(array_column($shippedOrders, 'ORDER_ID')),
			$productIds
		);

		return $this->mergeAmounts(
			$this->loadShipmentReserves($reservedOrders, $reserveBasket),
			$this->loadShipmentShipped($shippedOrders, $shippedBasket)
		);
	}

	public function mapProducts(array $orderIds, array $productIds, Main\Type\DateTime $after = null)
	{
		list($reservedOrders, $shippedOrders) = $this->groupOrders($orderIds, $after);

		$foundOrders = array_merge(
			array_unique(array_column($reservedOrders, 'ORDER_ID')),
			array_unique(array_column($shippedOrders, 'ORDER_ID'))
		);
		$result = [];

		foreach ($this->mapBasketProducts($foundOrders, $productIds) as $basketProduct)
		{
			$orderId = (int)$basketProduct['ORDER_ID'];
			$productId = (string)$basketProduct['PRODUCT_ID'];

			if (!isset($result[$orderId]))
			{
				$result[$orderId] = [];
			}

			$result[$orderId][] = $productId;
		}

		return $result;
	}

	protected function groupOrders(array $orderIds, Main\Type\DateTime $after = null)
	{
		$shipped = $this->findShippedOrders($orderIds, $after);

		if (!$this->usedAvailableQuantity || $this->isReservedEqualShipped())
		{
			$reserved = [];
		}
		else
		{
			$found = array_unique(array_column($shipped, 'ORDER_ID'));
			$left = array_diff($orderIds, $found);

			$reserved = $this->findReservedOrders($left, $after);
		}

		return [$reserved, $shipped];
	}

	/**
	 * @param int[] $orderIds
	 * @param Main\Type\DateTime|null $after
	 *
	 * @return array{ORDER_ID: int, DATE: Main\Type\DateTime|null}
	 */
	protected function findReservedOrders(array $orderIds, Main\Type\DateTime $after = null)
	{
		$rule = $this->reserveRule();
		$orderField = $rule['ENTITY'] === 'ORDER' ? 'ID' : 'ORDER_ID';
		$dataClass = $this->entityDataClass($rule['ENTITY']);
		$result = [];

		foreach (array_chunk($orderIds, 500) as $orderChunk)
		{
			$filter = [
				'=' . $orderField => $orderChunk,
			];

			if ($rule['FLAG'] !== null)
			{
				$filter['=' . $rule['FLAG']] = 'Y';
			}

			if ($after !== null)
			{
				$filter['>=' . $rule['DATE']] = $this->adjustAfterFilter($after);
			}

			$query = $dataClass::getList([
				'filter' => $filter,
				'select' => [
					$orderField,
					$rule['DATE'],
				],
			]);

			while ($row = $query->fetch())
			{
				$orderId = $row[$orderField];
				$date = $row[$rule['DATE']];

				if (!isset($result[$orderId]))
				{
					$result[$orderId] = [
						'ORDER_ID' => $row[$orderField],
						'DATE' => $date,
					];
				}
				else if (
					$result[$orderId]['DATE'] === null
					|| (
						$date !== null
						&& Market\Data\DateTime::compare($date, $result[$orderId]['DATE']) === 1
					)
				)
				{
					$result[$orderId]['DATE'] = $date;
				}
			}
		}

		return array_values($result);
	}

	protected function loadShipmentReserves(array $reservedOrders, array $basketProducts)
	{
		$clearReservePeriod = $this->clearReservePeriod();
		$canClearReserve = ($clearReservePeriod > 0);
		$reservedMap = array_column($reservedOrders, 'DATE', 'ORDER_ID');
		$result = [];

		foreach (array_chunk($basketProducts, 500, true) as $basketChunk)
		{
			$filter = [
				'=BASKET_ID' => array_keys($basketChunk),
			];

			if (!$canClearReserve)
			{
				$filter['>RESERVED_QUANTITY'] = 0;
			}

			$query = Sale\Internals\ShipmentItemTable::getList([
				'filter' => $filter,
				'select' => [
					'DATE_INSERT',
					'BASKET_ID',
					'RESERVED_QUANTITY',
				],
			]);

			while ($row = $query->fetch())
			{
				$basketRow = $basketChunk[$row['BASKET_ID']];
				$productId = $basketRow['PRODUCT_ID'];
				$quantity = (float)$row['RESERVED_QUANTITY'];

				if ($quantity > 0)
				{
					$orderId = $basketRow['ORDER_ID'];
					$timestamp = $reservedMap[$orderId] ?: $row['DATE_INSERT'];
				}
				else
				{
					$quantity = 0;
					$timestamp = Market\Data\DateTime::min(
						$row['DATE_INSERT']->add(sprintf('P%sD', $clearReservePeriod)),
						new Main\Type\DateTime()
					);
				}

				if (!isset($result[$productId]))
				{
					$result[$productId] = [
						'QUANTITY' => $quantity,
						'TIMESTAMP_X' => $timestamp
					];
				}
				else
				{
					$result[$productId]['QUANTITY'] += $quantity;
					$result[$productId]['TIMESTAMP_X'] = Market\Data\DateTime::max(
						$result[$productId]['TIMESTAMP_X'],
						$timestamp
					);
				}
			}
		}

		return $result;
	}

	protected function findShippedOrders(array $orderIds, Main\Type\DateTime $after = null)
	{
		$result = [];

		foreach (array_chunk($orderIds, 500) as $orderChunk)
		{
			$filter = [
				'=ORDER_ID' => $orderChunk,
				'=DEDUCTED' => 'Y',
			];

			if ($after !== null)
			{
				$filter['>=DATE_DEDUCTED'] = $this->adjustAfterFilter($after);
			}

			$query = Sale\Internals\ShipmentTable::getList([
				'filter' => $filter,
				'select' => [
					'ID',
					'ORDER_ID',
					'DATE_DEDUCTED',
				],
			]);

			while ($row = $query->fetch())
			{
				$result[] = [
					'SHIPMENT_ID' => $row['ID'],
					'ORDER_ID' => $row['ORDER_ID'],
					'DATE' => $row['DATE_DEDUCTED'],
				];
			}
		}

		return $result;
	}

	protected function loadShipmentShipped(array $shippedOrders, array $basketProducts)
	{
		$result = [];
		$shippedMap = array_column($shippedOrders, 'DATE', 'SHIPMENT_ID');

		foreach (array_chunk($basketProducts, 500, true) as $basketChunk)
		{
			$query = Sale\Internals\ShipmentItemTable::getList([
				'filter' => [
					'=BASKET_ID' => array_keys($basketChunk),
				],
				'select' => [
					'DATE_INSERT',
					'BASKET_ID',
					'ORDER_DELIVERY_ID',
					'QUANTITY',
				],
			]);

			while ($row = $query->fetch())
			{
				$shipmentId = $row['ORDER_DELIVERY_ID'];

				if (!isset($shippedMap[$shipmentId]) && !array_key_exists($shipmentId, $shippedMap)) { continue; } // not shipped

				$basketRow = $basketChunk[$row['BASKET_ID']];
				$productId = $basketRow['PRODUCT_ID'];
				$quantity = (float)$row['QUANTITY'];
				$timestamp = $shippedMap[$shipmentId] ?: $row['DATE_INSERT'];

				if (!isset($result[$productId]))
				{
					$result[$productId] = [
						'QUANTITY' => $quantity,
						'TIMESTAMP_X' => $timestamp
					];
				}
				else
				{
					$result[$productId]['QUANTITY'] += $quantity;
					$result[$productId]['TIMESTAMP_X'] = Market\Data\DateTime::max(
						$result[$productId]['TIMESTAMP_X'],
						$timestamp
					);
				}
			}
		}

		return $result;
	}

	protected function adjustAfterFilter(Main\Type\DateTime $after)
	{
		$result = clone $after;
		$result->add('-PT10S'); // allowed gap between product and order change

		return $result;
	}

	protected function mergeAmounts(array ...$groups)
	{
		$result = array_shift($groups);

		if ($result === null) { return []; }

		foreach ($groups as $group)
		{
			foreach ($group as $productId => $amount)
			{
				if (!isset($result[$productId]))
				{
					$result[$productId] = $amount;
				}
				else
				{
					$result[$productId]['QUANTITY'] += $amount['QUANTITY'];
					$result[$productId]['TIMESTAMP_X'] = Market\Data\DateTime::max(
						$result[$productId]['TIMESTAMP_X'],
						$amount['TIMESTAMP_X']
					);
				}
			}
		}

		return $result;
	}

	protected function mapBasketProducts(array $orderIds, array $productIds)
	{
		$result = [];

		foreach (array_chunk($orderIds, 500) as $orderChunk)
		{
			foreach (array_chunk($productIds, 500) as $productChunk)
			{
				$query = Sale\Internals\BasketTable::getList([
					'filter' => [
						'=ORDER_ID' => $orderChunk,
						'=PRODUCT_ID' => $productChunk,
					],
					'select' => [
						'ID',
						'PRODUCT_ID',
						'ORDER_ID',
					],
				]);

				while ($row = $query->fetch())
				{
					$result[$row['ID']] = [
						'PRODUCT_ID' => $row['PRODUCT_ID'],
						'ORDER_ID' => $row['ORDER_ID'],
					];
				}
			}
		}

		return $result;
	}

	protected function isReservedEqualShipped()
	{
		return (Sale\Configuration::getProductReservationCondition() === Sale\Configuration::RESERVE_ON_SHIP);
	}

	protected function reserveRule()
	{
		$condition = Sale\Configuration::getProductReservationCondition();

		if ($condition === Sale\Configuration::RESERVE_ON_ALLOW_DELIVERY)
		{
			$entity = 'SHIPMENT';
			$flag = 'ALLOW_DELIVERY';
			$date = 'DATE_ALLOW_DELIVERY';
		}
		else if ($condition === Sale\Configuration::RESERVE_ON_SHIP)
		{
			$entity = 'SHIPMENT';
			$flag = 'DEDUCTED';
			$date = 'DATE_DEDUCTED';
		}
		else if ($condition === Sale\Configuration::RESERVE_ON_PAY)
		{
			$entity = 'PAYMENT';
			$flag = 'PAID';
			$date = 'DATE_PAID';
		}
		else if ($condition === Sale\Configuration::RESERVE_ON_FULL_PAY)
		{
			$entity = 'ORDER';
			$flag = 'PAYED';
			$date = 'DATE_PAYED';
		}
		else
		{
			$entity = 'ORDER';
			$flag = null;
			$date = 'DATE_INSERT';
		}

		return [
			'ENTITY' => $entity,
			'FLAG' => $flag,
			'DATE' => $date,
		];
	}

	protected function clearReservePeriod()
	{
		return Sale\Configuration::getProductReserveClearPeriod();
	}

	/**
	 * @param string $entity
	 *
	 * @return class-string<Main\Entity\DataManager>
	 */
	protected function entityDataClass($entity)
	{
		if ($entity === 'ORDER')
		{
			$result = Sale\Internals\OrderTable::class;
		}
		else if ($entity === 'PAYMENT')
		{
			$result = Sale\Internals\PaymentTable::class;
		}
		else if ($entity === 'SHIPMENT')
		{
			$result = Sale\Internals\ShipmentTable::class;
		}
		else
		{
			throw new Main\SystemException(sprintf('cant map entity %s to data class', $entity));
		}

		return $result;
	}
}