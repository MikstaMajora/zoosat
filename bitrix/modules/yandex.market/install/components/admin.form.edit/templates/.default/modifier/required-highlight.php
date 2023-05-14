<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { die(); }

$isAllRequired = true;

foreach ($arResult['TABS'] as $tab)
{
	foreach ($tab['FIELDS'] as $fieldKey)
	{
		$field = $component->getField($fieldKey);
		$isRequired = ($field['MANDATORY'] === 'Y');

		if (!$isRequired)
		{
			$isAllRequired = false;
			break;
		}
	}

	if (!$isAllRequired) { break; }
}

if ($isAllRequired)
{
	$arResult['DISABLE_REQUIRED_HIGHLIGHT'] = true;
}
