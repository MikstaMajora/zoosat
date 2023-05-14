<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { die(); }

use Bitrix\Main\Localization\Loc;

$sections = [
	'PROPERTIES',
	'DELIVERY',
	'COURIER',
	'BUYER',
];

foreach ($sections as $section)
{
	if (empty($arResult[$section])) { continue; }

	$properties = $arResult[$section];
	$configSection = [
		'name' => $section,
		'title' => Loc::getMessage('YANDEX_MARKET_T_TRADING_ORDER_VIEW_' . $section . '_TITLE') ?: $section,
		'type' => 'section',
		'data' => [
			'showButtonPanel' => false,
			'isChangeable' => false,
			'isRemovable' => false,
		],
		'elements' => [],
	];

	foreach ($properties as $property)
	{
		$configSection['elements'][] = [
			'name' => $property['ID'],
		];

		$arResult['EDITOR']['ENTITY_FIELDS'][] = [
			'name' => $property['ID'],
			'title' => html_entity_decode($property['NAME']),
			'type' => 'text',
			'editable' => false,
		];

		$arResult['EDITOR']['ENTITY_DATA'][$property['ID']] = html_entity_decode(htmlspecialcharsback($property['VALUE']));
	}

	$arResult['EDITOR']['ENTITY_CONFIG'][] = $configSection;
}
