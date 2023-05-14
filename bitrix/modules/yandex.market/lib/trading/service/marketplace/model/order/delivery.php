<?php

namespace Yandex\Market\Trading\Service\Marketplace\Model\Order;

use Yandex\Market;

class Delivery extends Market\Api\Model\Order\Delivery
{
	/** @return Delivery\Courier|null */
	public function getCourier()
	{
		return $this->getChildModel('courier');
	}

	protected function getChildModelReference()
	{
		return array_merge(parent::getChildModelReference(), [
			'courier' => Delivery\Courier::class,
		]);
	}
}