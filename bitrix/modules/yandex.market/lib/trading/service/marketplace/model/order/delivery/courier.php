<?php

namespace Yandex\Market\Trading\Service\Marketplace\Model\Order\Delivery;

use Yandex\Market;

class Courier extends Market\Api\Reference\Model
{
	use Market\Reference\Concerns\HasMessage;

	public static function getMeaningfulFields()
	{
		return [
			'FIO',
			'PHONE',
			'CAR_NUMBER',
			'CAR_DESCRIPTION',
		];
	}

	public static function getMeaningfulFieldTitle($name)
	{
		return self::getMessage($name);
	}

	public function getMeaningfulValues()
	{
		return [
			'FIO' => $this->getFio(),
			'PHONE' => $this->getMeaningfulPhone(),
			'CAR_NUMBER' => $this->getCarNumber(),
			'CAR_DESCRIPTION' => $this->getCarDescription(),
		];
	}

	public function getMeaningfulPhone()
	{
		$result = $this->getPhone();
		$extension = $this->getPhoneExtension();

		if ((string)$extension !== '')
		{
			$result .= ', ' . self::getMessage('PHONE_EXTENSION', [ '#EXTENSION#' => $extension ], $extension);
		}

		return $result;
	}

	public function getFio()
	{
		return $this->getField('fio');
	}

	public function getPhone()
	{
		return $this->getField('phone');
	}

	public function getPhoneExtension()
	{
		return $this->getField('phoneExtension');
	}

	public function getCarNumber()
	{
		return $this->getField('carNumber');
	}

	public function getCarDescription()
	{
		return $this->getField('carDescription');
	}
}