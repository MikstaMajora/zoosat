<?php

namespace Yandex\Market\Trading\Service\MarketplaceDbs\Options;

use Bitrix\Main;
use Yandex\Market;
use Yandex\Market\Trading\Entity as TradingEntity;
use Yandex\Market\Trading\Service as TradingService;

class PaySystemOption extends TradingService\Reference\Options\Fieldset
{
	use Market\Reference\Concerns\HasLang;

	/** @var TradingService\MarketplaceDbs\Provider $provider */
	protected $provider;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
	}

	/** @return int */
	public function getPaySystemId()
	{
		return (int)$this->getRequiredValue('ID');
	}

	/** @return string */
	public function getType()
	{
		return (string)$this->getRequiredValue('TYPE');
	}

	/** @return bool */
	public function useMethod()
	{
		return (string)$this->getValue('USE_METHOD') === Market\Ui\UserField\BooleanType::VALUE_Y;
	}

	/** @return string */
	public function getMethod()
	{
		return (string)$this->getRequiredValue('METHOD');
	}

	protected function applyValues()
	{
		$this->applyUseMethod();
	}

	protected function applyUseMethod()
	{
		if (isset($this->values['USE_METHOD']) || empty($this->values['METHOD'])) { return; }

		$this->values['USE_METHOD'] = Market\Ui\UserField\BooleanType::VALUE_Y;
	}

	public function getFieldDescription(TradingEntity\Reference\Environment $environment, $siteId)
	{
		return parent::getFieldDescription($environment, $siteId) + [
			'SETTINGS' => [
				'SUMMARY' => '&laquo;#ID#&raquo; (#TYPE#, #METHOD#)',
				'LAYOUT' => 'summary',
			]
		];
	}

	public function getFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		try
		{
			$result = [
				'ID' => [
					'TYPE' => 'enumeration',
					'MANDATORY' => 'Y',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTIONS_PAY_SYSTEM_OPTION_ID'),
					'VALUES' => $environment->getPaySystem()->getEnum($siteId),
				],
				'TYPE' => [
					'TYPE' => 'enumeration',
					'MANDATORY' => 'Y',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTIONS_PAY_SYSTEM_OPTION_TYPE'),
					'VALUES' => $this->provider->getPaySystem()->getTypeEnum(),
					'DEPEND' => [
						'USE_METHOD' => [
							'RULE' => Market\Utils\UserField\DependField::RULE_EMPTY,
							'VALUE' => true,
						],
					],
				],
				'METHOD' => [
					'TYPE' => 'enumeration',
					'MANDATORY' => 'Y',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTIONS_PAY_SYSTEM_OPTION_METHOD'),
					'VALUES' => $this->provider->getPaySystem()->getMethodEnum(),
					'DEPEND' => [
						'USE_METHOD' => [
							'RULE' => Market\Utils\UserField\DependField::RULE_EMPTY,
							'VALUE' => false,
						],
					],
				],
				'USE_METHOD' => [
					'TYPE' => 'boolean',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTIONS_PAY_SYSTEM_OPTION_USE_METHOD'),
				],
			];
		}
		catch (Market\Exceptions\NotImplemented $exception)
		{
			$result = [];
		}

		return $result;
	}
}
