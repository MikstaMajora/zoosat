<?php

namespace Yandex\Market\Trading\Service\Marketplace;

use Yandex\Market;
use Bitrix\Main;
use Yandex\Market\Trading\Service as TradingService;
use Yandex\Market\Trading\Entity as TradingEntity;

class Options extends TradingService\Common\Options
{
	/** @var Provider */
	protected $provider;

	protected static function includeMessages()
	{
		Main\Localization\Loc::loadMessages(__FILE__);
		parent::includeMessages();
	}

	public function __construct(Provider $provider)
	{
		parent::__construct($provider);
	}

	public function getTitle($version = '')
	{
		$suffix = $version !== '' ? '_' . $version : '';

		return static::getLang('TRADING_SERVICE_MARKETPLACE_TITLE' . $suffix);
	}

	public function getPaySystemId()
	{
		return (string)$this->getValue('PAY_SYSTEM_ID');
	}

	public function getDeliveryId()
	{
		return (string)$this->getValue('DELIVERY_ID');
	}

	public function includeBasketSubsidy()
	{
		return (string)$this->getValue('BASKET_SUBSIDY_INCLUDE') === Market\Reference\Storage\Table::BOOLEAN_Y;
	}

	public function getSubsidyPaySystemId()
	{
		return (string)$this->getValue('SUBSIDY_PAY_SYSTEM_ID');
	}

	public function useWarehouses()
	{
		return (string)$this->getValue('USE_WAREHOUSES') === Market\Reference\Storage\Table::BOOLEAN_Y;
	}

	public function getWarehouseStoreField()
	{
		return $this->getRequiredValue('WAREHOUSE_STORE_FIELD');
	}

	public function getProductStores()
	{
		return (array)$this->getRequiredValue('PRODUCT_STORE');
	}

	public function usePushStocks()
	{
		return (string)$this->getValue('USE_PUSH_STOCKS') === Market\Reference\Storage\Table::BOOLEAN_Y;
	}

	public function getWarehousePrimary()
	{
		return $this->getRequiredValue('WAREHOUSE_PRIMARY');
	}

	public function getWarehousePrimaryField()
	{
		return $this->getRequiredValue('WAREHOUSE_PRIMARY_FIELD');
	}

	public function getProductFeeds()
	{
		$ids = (array)$this->getValue('PRODUCT_FEED');

		Main\Type\Collection::normalizeArrayValuesByInt($ids, false);

		return $ids;
	}

	public function productUpdatedAt()
	{
		$dateFormatted = (string)$this->getValue('PRODUCT_UPDATED_AT');

		return (
			$dateFormatted !== ''
				? new Main\Type\DateTime($dateFormatted, \DateTime::ATOM)
				: null
		);
	}

	public function useOrderReserve()
	{
		return (string)$this->getValue('USE_ORDER_RESERVE') === Market\Reference\Storage\Table::BOOLEAN_Y;
	}

	public function isAllowModifyPrice()
	{
		return true;
	}

	public function isAllowProductSkuPrefix()
	{
		return Market\Config::isExpertMode();
	}

	/** @return Options\SelfTestOption */
	public function getSelfTestOption()
	{
		return $this->getFieldset('SELF_TEST');
	}

	public function getEnvironmentFieldActions()
	{
		return array_filter([
			$this->getEnvironmentCisActions(),
			$this->getEnvironmentItemsActions(),
		]);
	}

	protected function getEnvironmentCisActions()
	{
		return [
			'FIELD' => 'SHIPMENT.ITEM.STORE.MARKING_CODE',
			'PATH' => 'send/cis',
			'PAYLOAD' => static function(array $action) {
				$itemsMap = [];
				$newIndex = 0;
				$result = [
					'items' => [],
				];

				foreach ($action['VALUE'] as $storeItem)
				{
					$markingCode = trim($storeItem['VALUE']);

					if ($markingCode === '') { continue; }

					$itemKey = $storeItem['XML_ID'] . ':' . $storeItem['PRODUCT_ID'];
					$cis = Market\Data\Trading\Cis::fromMarkingCode($markingCode);

					if (isset($itemsMap[$itemKey]))
					{
						$itemIndex = $itemsMap[$itemKey];
						$result['items'][$itemIndex]['instances'][] = [ 'cis' => $cis ];
					}
					else
					{
						$itemsMap[$itemKey] = $newIndex;
						$result['items'][$newIndex] = [
							'productId' => $storeItem['PRODUCT_ID'],
							'xmlId' => $storeItem['XML_ID'],
							'instances' => [
								[ 'cis' => $cis ],
							],
						];

						++$newIndex;
					}
				}

				return !empty($result['items']) ? $result : null;
			}
		];
	}

	protected function getEnvironmentItemsActions()
	{
		if (Market\Config::getOption('trading_silent_basket', 'N') === 'Y') { return null; }

		return [
			'FIELD' => 'BASKET.QUANTITY',
			'PATH' => 'send/items',
			'PAYLOAD' => static function(array $action) {
				$result = [
					'items' => [],
				];

				foreach ($action['VALUE'] as $basketItem)
				{
					$quantity = (float)$basketItem['VALUE'];

					if ($quantity <= 0) { continue; }

					$result['items'][] = [
						'productId' => $basketItem['PRODUCT_ID'],
						'xmlId' => $basketItem['XML_ID'],
						'count' => $quantity,
					];
				}

				return $result;
			}
		];
	}

	protected function applyProductStoresReserve()
	{
		$stored = (array)$this->getValue('PRODUCT_STORE');
		$required = array_diff($stored, [
			TradingEntity\Common\Store::PRODUCT_FIELD_QUANTITY_RESERVED,
		]);

		if (count($stored) !== count($required))
		{
			$this->values['PRODUCT_STORE'] = array_values($required);
			$this->values['USE_ORDER_RESERVE'] = Market\Ui\UserField\BooleanType::VALUE_Y;
		}
		else if (!empty($stored) && !isset($this->values['USE_ORDER_RESERVE']))
		{
			$this->values['USE_ORDER_RESERVE'] = Market\Ui\UserField\BooleanType::VALUE_N;
		}
	}

	public function takeChanges(TradingService\Reference\Options\Skeleton $previous)
	{
		/** @var Options $previous */
		Market\Reference\Assert::typeOf($previous, static::class, 'previous');

		$this->takeProductChanges($previous);
	}

	protected function takeProductChanges(Options $previous)
	{
		if ($this->compareStoreChanges($previous) || $this->compareSkuChanges($previous) || $this->compareReserveChanges($previous))
		{
			$timestamp = new Main\Type\DateTime();

			$this->values['PRODUCT_UPDATED_AT'] = $timestamp->format(\DateTime::ATOM);
		}
	}

	protected function compareStoreChanges(Options $previous)
	{
		if ($previous->useWarehouses() !== $this->useWarehouses())
		{
			$changed = true;
		}
		else if ($this->useWarehouses())
		{
			$changed = $previous->getWarehouseStoreField() !== $this->getWarehouseStoreField();
		}
		else
		{
			$currentStores = $this->getProductStores();
			$previousStores = $previous->getProductStores();
			$newStores = array_diff($currentStores, $previousStores);
			$deletedStores = array_diff($previousStores, $currentStores);

			$changed = !empty($newStores) || !empty($deletedStores);
		}

		return $changed;
	}

	protected function compareSkuChanges(Options $previous)
	{
		$currentMap = $this->getProductSkuMap();
		$previousMap = $previous->getProductSkuMap();

		if (empty($currentMap) !== empty($previousMap))
		{
			$changed = true;
		}
		else if (!empty($previousMap))
		{
			$changed = false;

			foreach ($previousMap as $key => $previousLink)
			{
				$currentLink = isset($currentMap[$key])
					? $currentMap[$key]
					: null;

				if (
					$currentLink === null
					|| $currentLink['IBLOCK'] !== $previousLink['IBLOCK']
					|| $currentLink['FIELD'] !== $previousLink['FIELD']
				)
				{
					$changed = true;
					break;
				}
			}
		}
		else
		{
			$changed = false;
		}

		return $changed;
	}

	protected function compareReserveChanges(Options $previous)
	{
		return $this->useOrderReserve() !== $previous->useOrderReserve();
	}

	public function getTabs()
	{
		return [
			'COMMON' => [
				'name' => static::getLang('TRADING_SERVICE_MARKETPLACE_TAB_COMMON'),
				'sort' => 1000,
			],
			'STORE' => [
				'name' => static::getLang('TRADING_SERVICE_MARKETPLACE_TAB_STORE'),
				'sort' => 2000,
			],
			'STATUS' => [
				'name' => static::getLang('TRADING_SERVICE_MARKETPLACE_TAB_STATUS'),
				'sort' => 3000,
				'data' => [
					'WARNING' => static::getLang('TRADING_SERVICE_MARKETPLACE_TAB_STATUS_NOTE'),
				]
			],
		];
	}

	public function getFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		return
			$this->getCommonFields($environment, $siteId)
			+ $this->getCompanyFields($environment, $siteId)
			+ $this->getIncomingRequestFields($environment, $siteId)
			+ $this->getOauthRequestFields($environment, $siteId)
			+ $this->getOrderPersonFields($environment, $siteId)
			+ $this->getOrderPaySystemFields($environment, $siteId)
			+ $this->getOrderDeliveryFields($environment, $siteId)
			+ $this->getOrderBasketSubsidyFields($environment, $siteId)
			+ $this->getOrderPropertyUtilFields($environment, $siteId)
			+ $this->getProductSkuMapFields($environment, $siteId)
			+ $this->getProductStoreFields($environment, $siteId)
			+ $this->getProductPriceFields($environment, $siteId)
			+ $this->getPushStocksFields($environment, $siteId)
			+ $this->getProductFeedFields($environment, $siteId)
			+ $this->getProductSelfTestFields($environment, $siteId)
			+ $this->getStatusInFields($environment, $siteId)
			+ $this->getStatusOutFields($environment, $siteId);
	}

	protected function getCommonFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = parent::getCommonFields($environment, $siteId);

		return $this->applyFieldsOverrides($result, [
			'GROUP' => static::getLang('TRADING_SERVICE_COMMON_GROUP_SERVICE_REQUEST'),
		]);
	}

	protected function getCompanyFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = parent::getCompanyFields($environment, $siteId);

		return $this->applyFieldsOverrides($result, [
			'GROUP' => static::getLang('TRADING_SERVICE_COMMON_GROUP_SERVICE_REQUEST'),
			'DEPRECATED' => 'Y',
		]);
	}

	protected function getPersonTypeDefaultValue(TradingEntity\Reference\PersonType $personType, $siteId)
	{
		return $personType->getLegalId($siteId);
	}

	protected function getOrderPersonFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = parent::getOrderPersonFields($environment, $siteId);

		return $this->applyFieldsOverrides($result, [
			'GROUP' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER'),
			'GROUP_DESCRIPTION' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER_DESCRIPTION'),
			'SORT' => 3200,
		]);
	}

	protected function getOrderPaySystemFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		try
		{
			$paySystem = $environment->getPaySystem();
			$paySystemEnum = $paySystem->getEnum($siteId);
			$firstPaySystem = reset($paySystemEnum);

			$result = [
				'PAY_SYSTEM_ID' => [
					'TYPE' => 'enumeration',
					'MANDATORY' => $paySystem->isRequired() ? 'Y' : 'N',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_PAY_SYSTEM_ID'),
					'GROUP' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER'),
					'GROUP_DESCRIPTION' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER_DESCRIPTION'),
					'VALUES' => $paySystemEnum,
					'SETTINGS' => [
						'DEFAULT_VALUE' => $firstPaySystem !== false ? $firstPaySystem['ID'] : null,
						'STYLE' => 'max-width: 220px;',
					],
					'SORT' => 3400,
				]
			];
		}
		catch (Market\Exceptions\NotImplemented $exception)
		{
			$result = [];
		}

		return $result;
	}

	protected function getOrderDeliveryFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		try
		{
			$delivery = $environment->getDelivery();
			$deliveryEnum = $delivery->getEnum($siteId);
			$defaultDelivery = null;
			$emptyDelivery = array_filter($deliveryEnum, function($option) {
				return $option['TYPE'] === Market\Data\Trading\Delivery::EMPTY_DELIVERY;
			});

			if (empty($emptyDelivery))
			{
				$firstEmptyDelivery = reset($emptyDelivery);
				$defaultDelivery = $firstEmptyDelivery['ID'];
			}
			else if (!empty($deliveryEnum))
			{
				$firstDelivery = reset($deliveryEnum);
				$defaultDelivery = $firstDelivery['ID'];
			}

			$result = [
				'DELIVERY_ID' => [
					'TYPE' => 'enumeration',
					'MANDATORY' => $delivery->isRequired() ? 'Y' : 'N',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_DELIVERY_ID'),
					'GROUP' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER'),
					'GROUP_DESCRIPTION' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER_DESCRIPTION'),
					'VALUES' => $deliveryEnum,
					'SETTINGS' => [
						'DEFAULT_VALUE' => $defaultDelivery,
						'STYLE' => 'max-width: 220px;',
					],
					'SORT' => 3300,
				],
			];
		}
		catch (Market\Exceptions\NotImplemented $exception)
		{
			$result = [];
		}

		return $result;
	}

	protected function getOrderBasketSubsidyFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		try
		{
			$paySystem = $environment->getPaySystem();
			$paySystemEnum = $paySystem->getEnum($siteId);

			$result = [
				'BASKET_SUBSIDY_INCLUDE' => [
					'TYPE' => 'boolean',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_BASKET_SUBSIDY_INCLUDE'),
					'SORT' => 3450,
				],
				'SUBSIDY_PAY_SYSTEM_ID' => [
					'TYPE' => 'enumeration',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_SUBSIDY_PAY_SYSTEM_ID'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_SUBSIDY_PAY_SYSTEM_ID_HELP'),
					'VALUES' => $paySystemEnum,
					'SETTINGS' => [
						'CAPTION_NO_VALUE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_SUBSIDY_PAY_SYSTEM_ID_NO_VALUE'),
						'STYLE' => 'max-width: 220px;'
					],
					'SORT' => 3451,
					'DEPEND' => [
						'BASKET_SUBSIDY_INCLUDE' => [
							'RULE' => 'ANY',
							'VALUE' => Market\Ui\UserField\BooleanType::VALUE_Y,
						],
					],
				],
			];
		}
		catch (Market\Exceptions\NotImplemented $exception)
		{
			$result = [];
		}

		return $result;
	}

	protected function getOrderPropertyUtilFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = parent::getOrderPropertyUtilFields($environment, $siteId);

		return $this->applyFieldsOverrides($result, [
			'GROUP' => static::getLang('TRADING_SERVICE_MARKETPLACE_GROUP_ORDER_PROPERTY'),
			'SORT' => 3500,
		]);
	}

	protected function getProductSkuMapFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = parent::getProductSkuMapFields($environment, $siteId);
		$overridable = array_diff_key($result, [
			'PRODUCT_SKU_ADV_PREFIX' => true,
		]);

		return
			$this->applyFieldsOverrides($overridable, [ 'HIDDEN' => 'N' ])
			+ $result;
	}

	protected function getProductStoreFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		global $APPLICATION;

		try
		{
			$store = $environment->getStore();
			$supportsWarehouses = $this->provider->getFeature()->supportsWarehouses();

			$warehouseFields = [
				'USE_WAREHOUSES' => [
					'TYPE' => 'boolean',
					'TAB' => 'STORE',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_USE_WAREHOUSES'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_USE_WAREHOUSES_HELP'),
					'SORT' => 1100,
					'HIDDEN' => $supportsWarehouses ? 'N' : 'Y',
					'DEPRECATED' => 'Y',
				],
				'WAREHOUSE_STORE_FIELD' => [
					'TYPE' => 'enumeration',
					'TAB' => 'STORE',
					'MANDATORY' => 'Y',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_WAREHOUSE_STORE_FIELD'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_WAREHOUSE_STORE_FIELD_HELP', [
						'#LANG#' => LANGUAGE_ID,
						'#BACKURL#' => rawurlencode($APPLICATION->GetCurPageParam('')),
					]),
					'SORT' => 1105,
					'VALUES' => $store->getFieldEnum($siteId),
					'HIDDEN' => $supportsWarehouses ? 'N' : 'Y',
					'SETTINGS' => [
						'DEFAULT_VALUE' => $store->getWarehouseDefaultField(),
						'STYLE' => 'max-width: 220px;',
					],
					'DEPEND' => [
						'USE_WAREHOUSES' => [
							'RULE' => 'EMPTY',
							'VALUE' => false,
						],
					],
				],
			];
			$commonFields = parent::getProductStoreFields($environment, $siteId);
			$commonFields += [
				'USE_ORDER_RESERVE' =>  [
					'TYPE' => 'boolean',
					'TAB' => 'STORE',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_USE_ORDER_RESERVE'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_USE_ORDER_RESERVE_HELP'),
					'SORT' => 1105,
					'SETTINGS' => [
						'DEFAULT_VALUE' => Market\Ui\UserField\BooleanType::VALUE_Y,
					],
				],
			];

			if ($supportsWarehouses)
			{
				$excludeDepend = [
					'PRODUCT_RATIO_SOURCE' => true,
				];

				foreach ($commonFields as $commonFieldKey => &$commonField)
				{
					if (isset($commonField['INTRO']))
					{
						$warehouseFields['USE_WAREHOUSES']['INTRO'] = $commonField['INTRO'];
						unset($commonField['INTRO']);
					}

					$commonField['SORT'] += 5;

					if (!isset($excludeDepend[$commonFieldKey]))
					{
						$commonField['DEPEND'] = [
							'USE_WAREHOUSES' => [
								'RULE' => 'EMPTY',
								'VALUE' => true,
							],
						];
					}
				}
				unset($commonField);
			}

			$result = $warehouseFields + $commonFields;
		}
		catch (Market\Exceptions\NotImplemented $exception)
		{
			$result = [];
		}

		return $result;
	}

	protected function getPushStocksFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		global $APPLICATION;

		try
		{
			$store = $environment->getStore();

			$result = [
				'USE_PUSH_STOCKS' => [
					'TYPE' => 'boolean',
					'TAB' => 'STORE',
					'GROUP' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_GROUP_PUSH_DATA'),
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_USE_PUSH_STOCKS'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_USE_PUSH_STOCKS_HELP'),
					'SORT' => 2200,
				],
				'WAREHOUSE_PRIMARY' => [
					'TYPE' => 'string',
					'TAB' => 'STORE',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_WAREHOUSE_PRIMARY'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_WAREHOUSE_PRIMARY_HELP'),
					'MANDATORY' => 'Y',
					'SORT' => 2205,
					'DEPEND' => [
						'USE_WAREHOUSES' => [
							'RULE' => 'EMPTY',
							'VALUE' => true,
						],
						'USE_PUSH_STOCKS' => [
							'RULE' => 'EMPTY',
							'VALUE' => false,
						],
					],
				],
				'WAREHOUSE_PRIMARY_FIELD' => [
					'TYPE' => 'enumeration',
					'TAB' => 'STORE',
					'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_WAREHOUSE_PRIMARY_FIELD'),
					'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_WAREHOUSE_PRIMARY_FIELD_HELP', [
						'#LANG#' => LANGUAGE_ID,
						'#BACKURL#' => rawurlencode($APPLICATION->GetCurPageParam('')),
					]),
					'MANDATORY' => 'Y',
					'VALUES' => $store->getFieldEnum($siteId),
					'SORT' => 2205,
					'DEPEND' => [
						'USE_WAREHOUSES' => [
							'RULE' => 'EMPTY',
							'VALUE' => false,
						],
						'USE_PUSH_STOCKS' => [
							'RULE' => 'EMPTY',
							'VALUE' => false,
						],
					],
				],
			];
		}
		catch (Market\Exceptions\NotImplemented $exception)
		{
			$result = [];
		}

		return $result;
	}

	protected function getProductFeedFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		return [
			'PRODUCT_FEED' => [
				'TYPE' => 'enumeration',
				'TAB' => 'STORE',
				'NAME' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_PRODUCT_FEED'),
				'HELP_MESSAGE' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_PRODUCT_FEED_HELP'),
				'MULTIPLE' => 'Y',
				'VALUES' => $this->getFeedEnum(),
				'SORT' => 2250,
				'SETTINGS' => [
					'STYLE' => 'max-width: 220px;',
				],
				'DEPEND' => [
					'USE_PUSH_STOCKS' => [
						'RULE' => 'EMPTY',
						'VALUE' => false,
					],
				],
			]
		];
	}

	protected function getFeedEnum()
	{
		$result = [];

		$query = Market\Export\Setup\Table::getList([
			'select' => [ 'ID', 'NAME', 'GROUP_NAME' => 'GROUP.NAME' ],
			'order' => [ 'GROUP.ID' => 'ASC', 'ID' => 'ASC' ],
		]);

		while ($row = $query->fetch())
		{
			$result[] = [
				'ID' => $row['ID'],
				'VALUE' => sprintf('[%s] %s', $row['ID'], $row['NAME']),
				'GROUP' => $row['GROUP_NAME'],
			];
		}

		return $result;
	}

	protected function getProductPriceFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = parent::getProductPriceFields($environment, $siteId);

		if (!Market\Config::isExpertMode())
		{
			$result = $this->applyFieldsOverrides($result, [
				'HIDDEN' => 'Y',
			]);
		}

		return $result;
	}

	protected function getProductSelfTestFields(TradingEntity\Reference\Environment $environment, $siteId)
	{
		$result = [];
		$defaults = [
			'TAB' => 'STORE',
			'GROUP' => static::getLang('TRADING_SERVICE_MARKETPLACE_OPTION_SELF_TEST'),
			'SORT' => 2300,
		];

		foreach ($this->getSelfTestOption()->getFields($environment, $siteId) as $name => $field)
		{
			$key = sprintf('SELF_TEST[%s]', $name);

			$result[$key] = $field + $defaults;
		}

		return $result;
	}

	protected function getFieldsetMap()
	{
		return [
			'SELF_TEST' => Options\SelfTestOption::class,
		];
	}
}