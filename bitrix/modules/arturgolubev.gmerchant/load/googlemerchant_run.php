<?
//<title>Google Merchant Center</title>

use Bitrix\Main,
	Bitrix\Main\Loader,
	Bitrix\Currency,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Sale;

IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/arturgolubev.gmerchant/export_google.php');
IncludeModuleLangFile(__FILE__);

define("CATALOG_EXPORT_PROCESS", "Y");

$arRunErrors = array();

if(!CModule::IncludeModule('arturgolubev.gmerchant') || !CModule::IncludeModule("catalog"))
{
	$arRunErrors[] = GetMessage('YANDEX_ERR_BAD_MODULE');
}
else
{
	$m = new CArturgolubevGmerchant();
	$moduleWorker = new CArturgolubevGmerchant();
}

$MAX_EXECUTION_TIME = (isset($MAX_EXECUTION_TIME) ? (int)$MAX_EXECUTION_TIME : 0);
if ($MAX_EXECUTION_TIME <= 0)
	$MAX_EXECUTION_TIME = 0;

if(empty($arRunErrors))
{
	if (!$moduleWorker->checkModule('sale', '17.0.0'))
		$MAX_EXECUTION_TIME = 0;
}

if (defined('BX_CAT_CRON') && BX_CAT_CRON == true)
{
	$MAX_EXECUTION_TIME = 0;
	$firstStep = true;
}
if (defined("CATALOG_EXPORT_NO_STEP") && CATALOG_EXPORT_NO_STEP == true)
{
	$MAX_EXECUTION_TIME = 0;
	$firstStep = true;
}
if ($MAX_EXECUTION_TIME == 0)
	set_time_limit(0);

$CHECK_PERMISSIONS = (isset($CHECK_PERMISSIONS) && $CHECK_PERMISSIONS == 'Y' ? 'Y' : 'N');
if ($CHECK_PERMISSIONS == 'Y')
	$permissionFilter = array('CHECK_PERMISSIONS' => 'Y', 'MIN_PERMISSION' => 'R', 'PERMISSIONS_BY' => 0);
else
	$permissionFilter = array('CHECK_PERMISSIONS' => 'N');

if (!isset($firstStep))
	$firstStep = true;


$pageSize = 25*$MAX_EXECUTION_TIME;
if($pageSize <= 0) $pageSize = 250;

$navParams = array('nTopCount' => $pageSize);

$SETUP_VARS_LIST = 'IBLOCK_ID,SITE_ID,V,XML_DATA,SETUP_SERVER_NAME,COMPANY_NAME,COMPANY_DESCRIPTION,SETUP_FILE_NAME,USE_HTTPS,HIDE_WITHOT_PICTURES,NO_USE_STANDART_PICTURES,NO_CLEAR_DESCRIPTION_TAGS,ONLY_STANDART_PRICE,HIDE_WITHOT_DESCRIPTION,HIDE_QUANTITY_NULL,LOCK_CUPON_CHECK,FILTER_AVAILABLE,DISABLE_REFERERS,MAX_EXECUTION_TIME,CHECK_PERMISSIONS,EXPORT_TYPE';
$INTERNAL_VARS_LIST = 'intMaxSectionID,arSectionIDs,arAvailGroups';

global $USER, $APPLICATION;
$bTmpUserCreated = false;
if (!CCatalog::IsUserExists())
{
	$bTmpUserCreated = true;
	if (isset($USER))
		$USER_TMP = $USER;
	$USER = new CUser();
}

$formatList = array(
	'google' => array(
		
	),
);

$arBase = array(
	'id', 'id_sku',
	'title', 'title_sku',
	'additional_image_link', 'additional_image_link_sku',
	'gtin', 'gtin_sku',
	'mpn', 'mpn_sku',
	'availability', 'condition', 'product_type', 'brand', 'mobile_link', 'google_product_category', 'color', 'color_sku', 'gender', 'age_group', 'adult', 'material', 'pattern', 'size_system', 'size',
	'shipping_height', 'shipping_block',
	'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4'
);

$arGoogleE = array(
	'availability_date',
	'product_weight', 'product_length', 'product_width', 'product_height',
	'shipping_weight', 'shipping_length', 'shipping_width', 'shipping_label', 'ships_from_country',
	'product_highlight', 'cost_of_goods_sold', 'pickup_method', 'pickup_SLA', 'unit_pricing_measure', 'unit_pricing_base_measure', 'store_code', 'region_id', 'quantity'
);
$ararFacebookE = array('inventory', 'override', 'fb_product_category');
$arTtE = array();
$arGoogleRE = array('display_ads_id', 'display_ads_similar_id', 'display_ads_title', 'display_ads_link', 'display_ads_value', 'excluded_destination', 'ads_grouping', 'ads_labels');

$arGoogle = array_merge($arBase, $arGoogleE);
$arFacebook = array_merge($arBase, $ararFacebookE);
$arTikTok = array_merge($arBase, $arTtE);
$arGoogleR = array_merge($arGoogle, $arGoogleRE);

// echo 'arBase <pre>'; print_r($arBase); echo '</pre>';
// echo 'arFacebook<pre>'; print_r($arFacebook); echo '</pre>';
// echo 'arTikTok<pre>'; print_r($arTikTok); echo '</pre>';
// echo 'arGoogle<pre>'; print_r($arGoogle); echo '</pre>';
// echo 'arGoogleR<pre>'; print_r($arGoogleR); echo '</pre>';

if($EXPORT_TYPE == 'facebook'){
	$formatList["google"] = $arFacebook;
}elseif($EXPORT_TYPE == 'tiktok'){
	$formatList["google"] = $arTikTok;
}elseif($EXPORT_TYPE == 'google'){
	$formatList["google"] = $arGoogle;
}elseif($EXPORT_TYPE == 'googlerem'){
	$formatList["google"] = $arGoogleR;
}else{
	$formatList["google"] = array_merge($arBase, $arGoogleE, $ararFacebookE, $arGoogleRE);
}


// echo '<pre>'; print_r($formatList); echo '</pre>';
// die();

if (!function_exists("yandex_replace_special"))
{
	function yandex_replace_special($arg)
	{
		if (in_array($arg[0], array("&quot;", "&amp;", "&lt;", "&gt;")))
			return $arg[0];
		else
			return " ";
	}
}

$saleIncluded = Loader::includeModule('sale');

if(empty($arRunErrors))
{
	if ($saleIncluded && $moduleWorker->checkModule('sale', '16.5.0'))
		Sale\DiscountCouponsManager::freezeCouponStorage();
}

CCatalogDiscountSave::Disable();

if (isset($XML_DATA))
{
	if (is_string($XML_DATA) && CheckSerializedData($XML_DATA))
		$XML_DATA = unserialize(stripslashes($XML_DATA));
}
if (!isset($XML_DATA) || !is_array($XML_DATA))
	$arRunErrors[] = GetMessage('YANDEX_ERR_BAD_XML_DATA');

$yandexFormat = 'google';
if (isset($XML_DATA['TYPE']) && isset($formatList[$XML_DATA['TYPE']]))
	$yandexFormat = $XML_DATA['TYPE'];

$productFormat = ($yandexFormat != 'google' ? ' type="'.htmlspecialcharsbx($yandexFormat).'"' : '');

$fields = array();
$parametricFields = array();
$fieldsExist = !empty($XML_DATA['XML_DATA']) && is_array($XML_DATA['XML_DATA']);
$parametricFieldsExist = false;
if ($fieldsExist)
{
	foreach ($XML_DATA['XML_DATA'] as $key => $value)
	{
		if ($key == 'PARAMS')
			$parametricFieldsExist = (!empty($value) && is_array($value));
		if (is_array($value))
			continue;
		$value = (string)$value;
		if ($value == '')
			continue;
		$fields[$key] = $value;
	}
	unset($key, $value);
	$fieldsExist = !empty($fields);
}

if(!$fields["additional_image_link_sku"] && $fields["additional_image_link"])
	$fields["additional_image_link_sku"] = $fields["additional_image_link"];

// ProfileParams
$arUserParams = array();

$arUserParams["FILTER_PRICE"]["FROM"] = IntVal($XML_DATA['F_PRICE_FROM']);
$arUserParams["FILTER_PRICE"]["TO"] = IntVal($XML_DATA['F_PRICE_TO']);

$arUserParams["HIDE_ELEMENTS"]["QUANTITY_ZERO"] = ($HIDE_QUANTITY_NULL == 'Y');
$arUserParams["HIDE_ELEMENTS"]["EMPTY_DESCRIPTION"] = ($HIDE_WITHOT_DESCRIPTION == 'Y');
$arUserParams["HIDE_ELEMENTS"]["EMPTY_PICTURE"] = ($HIDE_WITHOT_PICTURES == 'Y');

$arUserParams["PROPS_SETTING"]["NO_USE_SALE_PRICE"] = ($ONLY_STANDART_PRICE == 'Y');

if(empty($arRunErrors))
{
	if(!$moduleWorker->checkModule('catalog', '16.0.4'))
		$arUserParams["ONE_CATALOG_TYPE"] = 'Y';
}

$arUserParams['arUtmParams'] = array('utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term');

if(class_exists('\Bitrix\Iblock\InheritedProperty\ElementValues')){
	$tmp = array("ELEMENT_PAGE_TITLE_MAIN", "ELEMENT_META_TITLE_MAIN", "ELEMENT_META_DESCRIPTION_MAIN");
	foreach($tmp as $v){
		if(in_array($v, $fields)){
			$arUserParams["PROPS_SETTING"]["GET_SEO_FIELDS"] = 1;
		}
	}
}

if(in_array("CATALOG_MEASURE", $fields)){
	$directoryMeasure = array();
	
	$res_measure = CCatalogMeasure::getList();
	while($measure = $res_measure->Fetch()) {
		$directoryMeasure[$measure["ID"]] = $measure;
	}
}

// echo '<pre>'; print_r($arUserParams); echo '</pre>';
// echo '<pre>'; print_r($XML_DATA); echo '</pre>';
// die();

// end ProfileParams


if(empty($arRunErrors))
{
	$arTextFiled = $XML_DATA['TEXT_FIELDS'][$XML_DATA['TYPE']];
	if(is_array($arTextFiled) && count($arTextFiled) > 0)
	{
		foreach($arTextFiled as $k=>$v){
			CArturgolubevGmerchant::setStorage("property_textfield_value", $k, $v);
		}
	}
}



if ($parametricFieldsExist)
{
	$parametricFields = $XML_DATA['XML_DATA']['PARAMS'];
	if (!empty($parametricFields))
	{
		foreach (array_keys($parametricFields) as $index)
		{
			if ((string)$parametricFields[$index] === '')
				unset($parametricFields[$index]);
		}
	}
	$parametricFieldsExist = !empty($parametricFields);
}

$needProperties = $fieldsExist || $parametricFieldsExist;
$getPropertyIds = array();
if ($fieldsExist){
	foreach ($fields as $id)
		if(IntVal($id)>0)
			$getPropertyIds[$id] = true;
}
if ($parametricFieldsExist){
	foreach ($parametricFields as $id){
		$id = IntVal($id);
		if($id>0)
			$getPropertyIds[$id] = true;
	}
}
unset($id);

$propertyFields = array(
	'ID', 'PROPERTY_TYPE', 'MULTIPLE', 'USER_TYPE'
);

$IBLOCK_ID = (int)$IBLOCK_ID;
$db_iblock = CIBlock::GetByID($IBLOCK_ID);
if (!($ar_iblock = $db_iblock->Fetch()))
{
	$arRunErrors[] = str_replace('#ID#', $IBLOCK_ID, GetMessage('YANDEX_ERR_NO_IBLOCK_FOUND_EXT'));
}
/*elseif (!CIBlockRights::UserHasRightTo($IBLOCK_ID, $IBLOCK_ID, 'iblock_admin_display'))
{
	$arRunErrors[] = str_replace('#IBLOCK_ID#',$IBLOCK_ID,GetMessage('CET_ERROR_IBLOCK_PERM'));
} */
else
{
	$ar_iblock['PROPERTY'] = array();
	$rsProps = \CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'NAME' => 'ASC'),
		array('IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y', 'CHECK_PERMISSIONS' => 'N')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$arProp['ID'] = (int)$arProp['ID'];
		$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
		$arProp['CODE'] = (string)$arProp['CODE'];
		if ($arProp['CODE'] == '')
			$arProp['CODE'] = $arProp['ID'];
		$arProp['LINK_IBLOCK_ID'] = (int)$arProp['LINK_IBLOCK_ID'];
		$ar_iblock['PROPERTY'][$arProp['ID']] = $arProp;
	}
	unset($arProp, $rsProps);
	
	global $USER_FIELD_MANAGER;
	$uFields = $USER_FIELD_MANAGER->GetUserFields("IBLOCK_".$IBLOCK_ID."_SECTION");
	if(is_array($uFields["UF_GM_PCATEGORY"]) && !empty($uFields["UF_GM_PCATEGORY"]))
	{
		$arUserParams["PROPS_SETTING"]["SECTION_HAS_GPC"] = 1;
	}
	if(is_array($uFields["UF_GM_FPCATEGORY"]) && !empty($uFields["UF_GM_FPCATEGORY"]))
	{
		$arUserParams["PROPS_SETTING"]["SECTION_HAS_FPC"] = 1;
	}
}

$SETUP_SERVER_NAME = (isset($SETUP_SERVER_NAME) ? trim($SETUP_SERVER_NAME) : '');
$COMPANY_NAME = (isset($COMPANY_NAME) ? trim($COMPANY_NAME) : '');
$COMPANY_DESCRIPTION = (isset($COMPANY_DESCRIPTION) ? trim($COMPANY_DESCRIPTION) : '');
$SITE_ID = (isset($SITE_ID) ? (string)$SITE_ID : '');
if ($SITE_ID === '')
	$SITE_ID = $ar_iblock['LID'];
$iterator = Main\SiteTable::getList(array(
	'select' => array('LID', 'SERVER_NAME', 'SITE_NAME', 'DIR'),
	'filter' => array('=LID' => $SITE_ID, '=ACTIVE' => 'Y')
));
$site = $iterator->fetch();
unset($iterator);
if (empty($site))
{
	$arRunErrors[] = GetMessage('BX_CATALOG_EXPORT_YANDEX_ERR_BAD_SITE');
}
else
{
	$site['SITE_NAME'] = (string)$site['SITE_NAME'];
	if ($site['SITE_NAME'] === '')
		$site['SITE_NAME'] = (string)Main\Config\Option::get('main', 'site_name');
	$site['COMPANY_NAME'] = $COMPANY_NAME;
	if ($site['COMPANY_NAME'] === '')
		$site['COMPANY_NAME'] = (string)Main\Config\Option::get('main', 'site_name');
	$site['SERVER_NAME'] = (string)$site['SERVER_NAME'];
	if ($SETUP_SERVER_NAME !== '')
		$site['SERVER_NAME'] = $SETUP_SERVER_NAME;
	if ($site['SERVER_NAME'] === '')
	{
		$site['SERVER_NAME'] = (defined('SITE_SERVER_NAME')
			? SITE_SERVER_NAME
			: (string)Main\Config\Option::get('main', 'server_name')
		);
	}
	if ($site['SERVER_NAME'] === '')
	{
		$arRunErrors[] = GetMessage('BX_CATALOG_EXPORT_YANDEX_ERR_BAD_SERVER_NAME');
	}
}

global $iblockServerName;
$iblockServerName = $site['SERVER_NAME'];

$arProperties = array();
if (isset($ar_iblock['PROPERTY']))
	$arProperties = $ar_iblock['PROPERTY'];

$boolOffers = false;
$arOffers = false;
$arOfferIBlock = false;
$intOfferIBlockID = 0;
$offersCatalog = false;
$arSelectOfferProps = array();
$arSelectedPropTypes = array(
	Iblock\PropertyTable::TYPE_STRING,
	Iblock\PropertyTable::TYPE_NUMBER,
	Iblock\PropertyTable::TYPE_LIST,
	Iblock\PropertyTable::TYPE_ELEMENT,
	Iblock\PropertyTable::TYPE_SECTION
);
$arOffersSelectKeys = array(
	YANDEX_SKU_EXPORT_ALL,
	YANDEX_SKU_EXPORT_MIN_PRICE,
	YANDEX_SKU_EXPORT_PROP,
);
$arCondSelectProp = array(
	'ZERO',
	'NONZERO',
	'EQUAL',
	'NONEQUAL',
	'MORE',
	'LESS',
);
$arSKUExport = array();

$arCatalog = CCatalogSku::GetInfoByIBlock($IBLOCK_ID);
if (empty($arCatalog))
{
	$arRunErrors[] = str_replace('#ID#', $IBLOCK_ID, GetMessage('YANDEX_ERR_NO_IBLOCK_IS_CATALOG'));
}
else
{
	$arCatalog['VAT_ID'] = (int)$arCatalog['VAT_ID'];
	$arOffers = CCatalogSku::GetInfoByProductIBlock($IBLOCK_ID);
	if (!empty($arOffers['IBLOCK_ID']))
	{
		$intOfferIBlockID = $arOffers['IBLOCK_ID'];
		$rsOfferIBlocks = CIBlock::GetByID($intOfferIBlockID);
		if (($arOfferIBlock = $rsOfferIBlocks->Fetch()))
		{
			$boolOffers = true;
			$rsProps = \CIBlockProperty::GetList(
				array('SORT' => 'ASC', 'NAME' => 'ASC'),
				array('IBLOCK_ID' => $intOfferIBlockID, 'ACTIVE' => 'Y', 'CHECK_PERMISSIONS' => 'N')
			);
			while ($arProp = $rsProps->Fetch())
			{
				$arProp['ID'] = (int)$arProp['ID'];
				if ($arOffers['SKU_PROPERTY_ID'] != $arProp['ID'])
				{
					$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
					$arProp['CODE'] = (string)$arProp['CODE'];
					if ($arProp['CODE'] == '')
						$arProp['CODE'] = $arProp['ID'];
					$arProp['LINK_IBLOCK_ID'] = (int)$arProp['LINK_IBLOCK_ID'];

					$ar_iblock['OFFERS_PROPERTY'][$arProp['ID']] = $arProp;
					$arProperties[$arProp['ID']] = $arProp;
					if (in_array($arProp['PROPERTY_TYPE'], $arSelectedPropTypes))
						$arSelectOfferProps[] = $arProp['ID'];
				}
			}
			unset($arProp, $rsProps);
			$arOfferIBlock['LID'] = $site['LID'];
		}
		else
		{
			$arRunErrors[] = GetMessage('YANDEX_ERR_BAD_OFFERS_IBLOCK_ID');
		}
		unset($rsOfferIBlocks);
	}
	if ($boolOffers)
	{
		$offersCatalog = \CCatalog::GetByID($intOfferIBlockID);
		$offersCatalog['VAT_ID'] = (int)$offersCatalog['VAT_ID'];
		if (empty($XML_DATA['SKU_EXPORT']))
		{
			$arRunErrors[] = GetMessage('YANDEX_ERR_SKU_SETTINGS_ABSENT');
		}
		else
		{
			$arSKUExport = $XML_DATA['SKU_EXPORT'];
			if (empty($arSKUExport['SKU_EXPORT_COND']) || !in_array($arSKUExport['SKU_EXPORT_COND'],$arOffersSelectKeys))
			{
				$arRunErrors[] = GetMessage('YANDEX_SKU_EXPORT_ERR_CONDITION_ABSENT');
			}
			if (YANDEX_SKU_EXPORT_PROP == $arSKUExport['SKU_EXPORT_COND'])
			{
				if (empty($arSKUExport['SKU_PROP_COND']) || !is_array($arSKUExport['SKU_PROP_COND']))
				{
					$arRunErrors[] = GetMessage('YANDEX_SKU_EXPORT_ERR_PROPERTY_ABSENT');
				}
				else
				{
					if (empty($arSKUExport['SKU_PROP_COND']['PROP_ID']) || !in_array($arSKUExport['SKU_PROP_COND']['PROP_ID'],$arSelectOfferProps))
					{
						$arRunErrors[] = GetMessage('YANDEX_SKU_EXPORT_ERR_PROPERTY_ABSENT');
					}
					if (empty($arSKUExport['SKU_PROP_COND']['COND']) || !in_array($arSKUExport['SKU_PROP_COND']['COND'],$arCondSelectProp))
					{
						$arRunErrors[] = GetMessage('YANDEX_SKU_EXPORT_ERR_PROPERTY_COND_ABSENT');
					}
					else
					{
						if ($arSKUExport['SKU_PROP_COND']['COND'] == 'EQUAL' || $arSKUExport['SKU_PROP_COND']['COND'] == 'NONEQUAL')
						{
							if (empty($arSKUExport['SKU_PROP_COND']['VALUES']))
							{
								$arRunErrors[] = GetMessage('YANDEX_SKU_EXPORT_ERR_PROPERTY_VALUES_ABSENT');
							}
						}
					}
				}
			}
		}
	}
}

if (empty($arRunErrors))
{
	if (
		$arCatalog['CATALOG_TYPE'] == CCatalogSku::TYPE_FULL
		|| $arCatalog['CATALOG_TYPE'] == CCatalogSku::TYPE_PRODUCT
	)
		$getPropertyIds[$arCatalog['SKU_PROPERTY_ID']] = true;
}

$arUserTypeFormat = array();
foreach($arProperties as $key => $arProperty)
{
	$arUserTypeFormat[$arProperty['ID']] = false;
	if ($arProperty['USER_TYPE'] == '')
		continue;

	$arUserType = \CIBlockProperty::GetUserType($arProperty['USER_TYPE']);
	if (isset($arUserType['GetPublicViewHTML']))
	{
		$arUserTypeFormat[$arProperty['ID']] = $arUserType['GetPublicViewHTML'];
		$arProperties[$key]['PROPERTY_TYPE'] = 'USER_TYPE';
	}
}
unset($arUserType, $key, $arProperty);

$bAllSections = false;
$arSections = array();


if (empty($arRunErrors))
{
	if (is_array($V))
	{
		foreach ($V as $key => $value)
		{
			if (trim($value)=="0")
			{
				$bAllSections = true;
				continue;
			}
			$value = (int)$value;
			if ($value > 0)
			{
				$arSections[] = $value;
			}
		}
	}
	
	if (!$bAllSections && !empty($arSections) && $CHECK_PERMISSIONS == 'Y')
	{
		$clearedValues = array();
		$filter = array(
			'IBLOCK_ID' => $IBLOCK_ID,
			'ID' => $arSections
		);
		$iterator = CIBlockSection::GetList(
			array(),
			array_merge($filter, $permissionFilter),
			false,
			array('ID')
		);
		while ($row = $iterator->Fetch())
			$clearedValues[] = (int)$row['ID'];
		unset($row, $iterator);
		$arSections = $clearedValues;
		unset($clearedValues);
	}

	if (!$bAllSections && empty($arSections))
	{
		$arRunErrors[] = GetMessage('YANDEX_ERR_NO_SECTION_LIST');
	}
}

$selectedPriceType = 0;
if (!empty($XML_DATA['PRICE']))
{
	$XML_DATA['PRICE'] = (int)$XML_DATA['PRICE'];
	if ($XML_DATA['PRICE'] > 0)
	{
		/* $rsCatalogGroups = CCatalogGroup::GetGroupsList(array('CATALOG_GROUP_ID' => $XML_DATA['PRICE'],'GROUP_ID' => 2));
		if (!($arCatalogGroup = $rsCatalogGroups->Fetch()))
		{
			$arRunErrors[] = GetMessage('YANDEX_ERR_BAD_PRICE_TYPE');
		}
		else
		{
			$selectedPriceType = $XML_DATA['PRICE'];
		}
		unset($arCatalogGroup, $rsCatalogGroups); */
		
		$selectedPriceType = $XML_DATA['PRICE'];
	}
	else
	{
		$arRunErrors[] = GetMessage('YANDEX_ERR_BAD_PRICE_TYPE');
	}
}

$oldPriceType = 0;
$oldPriceProp = array();
if (!empty($XML_DATA['OLD_PRICE']))
{	
	if (IntVal($XML_DATA['OLD_PRICE']) > 0){
		$oldPriceType = (int)$XML_DATA['OLD_PRICE'];
	}else{		
		$properties = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "CODE"=>$XML_DATA['OLD_PRICE'], "IBLOCK_ID"=>$IBLOCK_ID));
		while ($prop_fields = $properties->GetNext())
		{
			// echo '<pre>'; print_r($prop_fields); echo '</pre>';
			$getPropertyIds[$prop_fields["ID"]] = 1;
			$needProperties = 1;
			
			$oldPriceProp[$IBLOCK_ID] = $prop_fields["ID"];
		}
		
		if($intOfferIBlockID){
			$properties = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "CODE"=>$XML_DATA['OLD_PRICE'], "IBLOCK_ID"=>$intOfferIBlockID));
			while ($prop_fields = $properties->GetNext())
			{
				// echo '<pre>'; print_r($prop_fields); echo '</pre>';
				$getPropertyIds[$prop_fields["ID"]] = 1;
				$needProperties = 1;
				
				$oldPriceProp[$intOfferIBlockID] = $prop_fields["ID"];
			}
		}
		
	}
}

$usedProtocol = (isset($USE_HTTPS) && $USE_HTTPS == 'Y' ? 'https://' : 'http://');
$filterAvailable = (isset($FILTER_AVAILABLE) && $FILTER_AVAILABLE == 'Y');

$vatExportSettings = array(
	'ENABLE' => 'N',
	'BASE_VAT' => ''
);

$vatRates = array(
	'0%' => 'VAT_0',
	'10%' => 'VAT_10',
	'18%' => 'VAT_18'
);
$vatList = array();

if (!empty($XML_DATA['VAT_EXPORT']) && is_array($XML_DATA['VAT_EXPORT']))
	$vatExportSettings = array_merge($vatExportSettings, $XML_DATA['VAT_EXPORT']);
$vatExport = $vatExportSettings['ENABLE'] == 'Y';
if ($vatExport)
{
	if ($vatExportSettings['BASE_VAT'] == '')
	{
		$vatExport = false;
	}
	else
	{
		if ($vatExportSettings['BASE_VAT'] != '-')
			$vatList[0] = 'NO_VAT';

		$filter = array('=RATE' => array_keys($vatRates));
		if (isset($vatRates[$vatExportSettings['BASE_VAT']]))
			$filter['!=RATE'] = $vatExportSettings['BASE_VAT'];
		$iterator = Catalog\VatTable::getList(array(
			'select' => array('ID', 'RATE'),
			'filter' => $filter,
			'order' => array('ID' => 'ASC')
		));
		while ($row = $iterator->fetch())
		{
			$row['ID'] = (int)$row['ID'];
			$row['RATE'] = (float)$row['RATE'];
			$index = $row['RATE'].'%';
			if (isset($vatRates[$index]))
				$vatList[$row['ID']] = $vatRates[$index];
		}
		unset($index, $row, $iterator);
	}
}

$mainOptions = array(
	"file" => $SETUP_FILE_NAME
);

$itemOptions = array(
	'PROTOCOL' => $usedProtocol,
	'SITE_NAME' => $site['SERVER_NAME'],
	'SITE_DIR' => $site['DIR'],
	'MAX_DESCRIPTION_LENGTH' => 4750,
	'NO_USE_STANDART_PICTURES' => $NO_USE_STANDART_PICTURES,
	'DESCRIPTION_TAGS' => trim($NO_CLEAR_DESCRIPTION_TAGS),
);

// echo '<pre>'; print_r($itemOptions); echo '</pre>';
// die();

$sectionFileName = '';
$itemFileName = '';
if (strlen($SETUP_FILE_NAME) <= 0)
{
	$arRunErrors[] = GetMessage("CATI_NO_SAVE_FILE");
}
elseif (preg_match(BX_CATALOG_FILENAME_REG,$SETUP_FILE_NAME))
{
	$arRunErrors[] = GetMessage("CES_ERROR_BAD_EXPORT_FILENAME");
}
else
{
	$SETUP_FILE_NAME = Rel2Abs("/", $SETUP_FILE_NAME);
}
if (empty($arRunErrors))
{
/*	if ($GLOBALS["APPLICATION"]->GetFileAccessPermission($SETUP_FILE_NAME) < "W")
	{
		$arRunErrors[] = str_replace('#FILE#', $SETUP_FILE_NAME,GetMessage('YANDEX_ERR_FILE_ACCESS_DENIED'));
	} */
	$sectionFileName = $SETUP_FILE_NAME.'_sections';
	$itemFileName = $SETUP_FILE_NAME.'_items';
}

$itemsFile = null;

$BASE_CURRENCY = Currency\CurrencyManager::getBaseCurrency();
if($XML_DATA['CURRENCY_SELECT']){
	if($XML_DATA['CURRENCY_SELECT'] == "SITE_CURRENCY")
	{
		$SITE_CURRENCY = \Bitrix\Sale\Internals\SiteCurrencyTable::getSiteCurrency($site['LID']);
		if($SITE_CURRENCY) $BASE_CURRENCY = $SITE_CURRENCY;
	}
	else
	{
		$BASE_CURRENCY = $XML_DATA['CURRENCY_SELECT'];
	}
}

if ($firstStep)
{
	if (empty($arRunErrors))
	{
		CheckDirPath($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME);

		if (!$fp = @fopen($_SERVER["DOCUMENT_ROOT"].$sectionFileName, "wb"))
		{
			$arRunErrors[] = str_replace('#FILE#', $sectionFileName, GetMessage('YANDEX_ERR_FILE_OPEN_WRITING'));
		}
		else
		{
			if (!@fwrite($fp, '<?xml version="1.0"?>'."\n"))
			{
				$arRunErrors[] = str_replace('#FILE#', $sectionFileName, GetMessage('YANDEX_ERR_SETUP_FILE_WRITE'));
				@fclose($fp);
			}
		}
	}

	if (empty($arRunErrors))
	{
		fwrite($fp, '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">'."\n");
		
		fwrite($fp, '<channel>'."\n");
		
		fwrite($fp, '<title>'.$APPLICATION->ConvertCharset(htmlspecialcharsbx($COMPANY_NAME), LANG_CHARSET, 'utf-8')."</title>\n");
		fwrite($fp, '<link>'.$usedProtocol.htmlspecialcharsbx($site['SERVER_NAME'])."</link>\n");
		
		if($COMPANY_DESCRIPTION)
			fwrite($fp, '<description>'.$APPLICATION->ConvertCharset(htmlspecialcharsbx($COMPANY_DESCRIPTION), LANG_CHARSET, 'utf-8')."</description>\n");
		
		$arSectionIDs = array();
		if (!$bAllSections)
		{
			for ($i = 0, $intSectionsCount = count($arSections); $i < $intSectionsCount; $i++)
			{
				$sectionIterator = CIBlockSection::GetNavChain($IBLOCK_ID, $arSections[$i], array('ID', 'IBLOCK_SECTION_ID', 'NAME', 'LEFT_MARGIN', 'RIGHT_MARGIN'));
				$curLEFT_MARGIN = 0;
				$curRIGHT_MARGIN = 0;
				while ($section = $sectionIterator->Fetch())
				{
					$section['ID'] = (int)$section['ID'];
					$section['IBLOCK_SECTION_ID'] = (int)$section['IBLOCK_SECTION_ID'];
					if ($arSections[$i] == $section['ID'])
					{
						$curLEFT_MARGIN = (int)$section['LEFT_MARGIN'];
						$curRIGHT_MARGIN = (int)$section['RIGHT_MARGIN'];
						$arSectionIDs[$section['ID']] = $section['ID'];
					}
					$arAvailGroups[$section['ID']] = array(
						'ID' => $section['ID'],
						'IBLOCK_SECTION_ID' => $section['IBLOCK_SECTION_ID'],
						'NAME' => $section['NAME']
					);
					if ($intMaxSectionID < $section['ID'])
						$intMaxSectionID = $section['ID'];
				}
				unset($section, $sectionIterator);

				$filter = array(
					'IBLOCK_ID' => $IBLOCK_ID,
					'>LEFT_MARGIN' => $curLEFT_MARGIN,
					'<RIGHT_MARGIN' => $curRIGHT_MARGIN,
					'GLOBAL_ACTIVE' => 'Y'
				);
				$sectionIterator = CIBlockSection::GetList(
					array('LEFT_MARGIN' => 'ASC'),
					array_merge($filter, $permissionFilter),
					false,
					array('ID', 'IBLOCK_SECTION_ID', 'NAME')
				);
				while ($section = $sectionIterator->Fetch())
				{
					$section['ID'] = (int)$section['ID'];
					$section['IBLOCK_SECTION_ID'] = (int)$section['IBLOCK_SECTION_ID'];
					$arAvailGroups[$section['ID']] = $section;
					if ($intMaxSectionID < $section['ID'])
						$intMaxSectionID = $section['ID'];
				}
				unset($section, $sectionIterator);
			}
		}
		else
		{
			$filter = array(
				'IBLOCK_ID' => $IBLOCK_ID,
				'GLOBAL_ACTIVE' => 'Y'
			);
			$sectionIterator = CIBlockSection::GetList(
				array('LEFT_MARGIN' => 'ASC'),
				array_merge($filter, $permissionFilter),
				false,
				array('ID', 'IBLOCK_SECTION_ID', 'NAME')
			);
			while ($section = $sectionIterator->Fetch())
			{
				$section['ID'] = (int)$section['ID'];
				$section['IBLOCK_SECTION_ID'] = (int)$section['IBLOCK_SECTION_ID'];
				$arAvailGroups[$section['ID']] = $section;
				$arSectionIDs[$section['ID']] = $section['ID'];
				if ($intMaxSectionID < $section['ID'])
					$intMaxSectionID = $section['ID'];
			}
			unset($section, $sectionIterator);
		}
		
		
		fclose($fp);

		$itemsFile = @fopen($_SERVER["DOCUMENT_ROOT"].$itemFileName, 'wb');
		if (!$itemsFile)
		{
			$arRunErrors[] = str_replace('#FILE#', $itemFileName, GetMessage('YANDEX_ERR_FILE_OPEN_WRITING'));
		}
	}
}
else
{
	$itemsFile = @fopen($_SERVER["DOCUMENT_ROOT"].$itemFileName, 'ab');
	if (!$itemsFile)
	{
		$arRunErrors[] = str_replace('#FILE#', $itemFileName, GetMessage('YANDEX_ERR_FILE_OPEN_WRITING'));
	}
}
unset($arSections);

// Work with prices
if (empty($arRunErrors))
{
	$saleDiscountOnly = false;
	if($moduleWorker->checkModule('sale', '17.5.0'))
	{
		if($moduleWorker->checkModule('catalog', '17.6.5'))
		{
			$calculationConfig = array(
				'CURRENCY' => $BASE_CURRENCY,
				'USE_DISCOUNTS' => true,
				'RESULT_WITH_VAT' => true,
				'RESULT_MODE' => Catalog\Product\Price\Calculation::RESULT_MODE_COMPONENT
			);
			if ($saleIncluded)
			{
				$saleDiscountOnly = (string)Main\Config\Option::get('sale', 'use_sale_discount_only') == 'Y';
				if ($saleDiscountOnly)
					$calculationConfig['PRECISION'] = (int)Main\Config\Option::get('sale', 'value_precision');
			}
		}
		else
		{
			$calculationConfig = array(
				'CURRENCY' => $BASE_CURRENCY,
				'USE_DISCOUNTS' => true,
				'RESULT_WITH_VAT' => true,
			);
		}
		
		Catalog\Product\Price\Calculation::setConfig($calculationConfig);
		unset($calculationConfig);

		if ($selectedPriceType > 0)
		{
			$priceTypeList = array($selectedPriceType);
		}
		else
		{
			$priceTypeList = array();
			$priceIterator = Catalog\GroupAccessTable::getList(array(
				'select' => array('CATALOG_GROUP_ID'),
				'filter' => array('=GROUP_ID' => 2),
				'order' => array('CATALOG_GROUP_ID' => 'ASC')
			));
			while ($priceType = $priceIterator->fetch())
			{
				$priceTypeId = (int)$priceType['CATALOG_GROUP_ID'];
				$priceTypeList[$priceTypeId] = $priceTypeId;
				unset($priceTypeId);
			}
			unset($priceType, $priceIterator);
		}
	}else{
		$priceTypeList = array();
		$db_res = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>2, "BUY"=>"Y"));
		while ($ar_res = $db_res->Fetch())
		{
			$priceTypeId = (int)$ar_res['CATALOG_GROUP_ID'];
			$priceTypeList[$priceTypeId] = $priceTypeId;
		}
	}
	
	if(empty($priceTypeList))
	{
		$arRunErrors[] = GetMessage('GOOGLE_EXPORT_ERROR_NO_AVIAL_PRICE');
	}
}

if (empty($arRunErrors))
{
	if($LOCK_CUPON_CHECK != 'Y')
	{
		$needDiscountCache = \CIBlockPriceTools::SetCatalogDiscountCache($priceTypeList, array(2), $site['LID']);
	}

	$itemFields = array(
		'ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'NAME',
		'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PREVIEW_TEXT_TYPE', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL',
		'CATALOG_AVAILABLE', 'CATALOG_TYPE', "CATALOG_QUANTITY"
	);
	$offerFields = array(
		'ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'NAME',
		'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PREVIEW_TEXT_TYPE', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL',
		'CATALOG_AVAILABLE', "CATALOG_QUANTITY"
	);
	
	//*** allowedTypes - start //
	$arProductTypes = $moduleWorker->getProductTypes();
	
	$allowedTypes = array();
	switch ($arCatalog['CATALOG_TYPE'])
	{
		case CCatalogSku::TYPE_CATALOG:
			$allowedTypes = array(
				$arProductTypes["TYPE_PRODUCT"] => true,
				$arProductTypes["TYPE_SET"] => true
			);
			break;
		case CCatalogSku::TYPE_OFFERS:
			$allowedTypes = array(
				$arProductTypes["TYPE_OFFER"] => true
			);
			break;
		case CCatalogSku::TYPE_FULL:
			$allowedTypes = array(
				$arProductTypes["TYPE_PRODUCT"] => true,
				$arProductTypes["TYPE_SET"] => true,
				$arProductTypes["TYPE_SKU"] => true
			);
			break;
		case CCatalogSku::TYPE_PRODUCT:
			$allowedTypes = array(
				$arProductTypes["TYPE_SKU"] => true
			);
			break;
	}
	
	if($arUserParams["ONE_CATALOG_TYPE"] == 'Y')
	{
		$allowedTypes[1] = true;
	}
	// allowedTypes - end ***//
	
	/* prod filter */
	$filter = array(
		'IBLOCK_ID' => $IBLOCK_ID,
		'ACTIVE' => 'Y',
		'ACTIVE_DATE' => 'Y',
	);
	if (!$bAllSections && !empty($arSectionIDs))
	{
		$filter['INCLUDE_SUBSECTIONS'] = 'Y';
		$filter['SECTION_ID'] = $arSectionIDs;
	}
	
	if ($filterAvailable)
		$filter['CATALOG_AVAILABLE'] = 'Y';
	
	if ($arUserParams["HIDE_ELEMENTS"]["QUANTITY_ZERO"] && $arCatalog["CATALOG_TYPE"] == 'D')
	{
		$filter['>CATALOG_QUANTITY'] = '0';
	}
	
	$filter = $m->prepareProductFilter(array_merge($filter, $permissionFilter), $parametricFields, $mainOptions);
	
	/* sku filter */
	$offersFilter = array('ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y');
	
	if ($filterAvailable)
		$offersFilter['CATALOG_AVAILABLE'] = 'Y';
	
	if ($arUserParams["HIDE_ELEMENTS"]["QUANTITY_ZERO"])
	{
		$offersFilter['>CATALOG_QUANTITY'] = '0';
	}
	
	if (isset($allowedTypes[$arProductTypes["TYPE_SKU"]]))
	{
		if ($arSKUExport['SKU_EXPORT_COND'] == YANDEX_SKU_EXPORT_PROP)
		{
			$mxValues = false;
			if ($arSKUExport['SKU_PROP_COND']['COND'] == 'EQUAL' || $arSKUExport['SKU_PROP_COND']['COND'] == 'NONEQUAL')
				$mxValues = $arSKUExport['SKU_PROP_COND']['VALUES'];
			if ($arSKUExport['SKU_PROP_COND']['COND'] == 'MORE' || $arSKUExport['SKU_PROP_COND']['COND'] == 'LESS')
				$mxValues = $arSKUExport['SKU_PROP_COND']['VALUES'][0];
			
			$strExportKey = '';
			if ($arSKUExport['SKU_PROP_COND']['COND'] == 'NONZERO' || $arSKUExport['SKU_PROP_COND']['COND'] == 'NONEQUAL')
				$strExportKey = '!';
			if ($arSKUExport['SKU_PROP_COND']['COND'] == 'MORE')
				$strExportKey = '>';
			if ($arSKUExport['SKU_PROP_COND']['COND'] == 'LESS')
				$strExportKey = '<';
			$strExportKey .= 'PROPERTY_'.$arSKUExport['SKU_PROP_COND']['PROP_ID'];
			
			$offersFilter[$strExportKey] = $mxValues;
		}
	}
	
	$offersFilter = $m->prepareSkuFilter(array_merge($offersFilter, $permissionFilter), $parametricFields, $mainOptions);
	
	$propertyIdList = array_keys($getPropertyIds); // get property info
	
	
	// echo '<pre>'; print_r($arCatalog); echo '</pre>';
	
	// echo '<pre>'; print_r($filter); echo '</pre>';
	// echo '<pre>'; print_r($offersFilter); echo '</pre>';
	// die();
	
	do
	{
		if (isset($CUR_ELEMENT_ID) && $CUR_ELEMENT_ID > 0)
			$filter['>ID'] = $CUR_ELEMENT_ID;

		$existItems = false;

		$itemIdsList = array();
		$items = array();

		$skuIdsList = array();
		$simpleIdsList = array();
		
		$iterator = CIBlockElement::GetList(
			array('ID' => 'ASC'),
			$filter,
			false,
			$navParams,
			$itemFields
		);
		while ($row = $iterator->Fetch())
		{
			$finalExport = false; // items exist
			$existItems = true;

			$id = (int)$row['ID'];
			$CUR_ELEMENT_ID = $id;

			$row['CATALOG_TYPE'] = (int)$row['CATALOG_TYPE'];
			$elementType = $row['CATALOG_TYPE'];
			if (!isset($allowedTypes[$elementType]))
				continue;

			$row['SECTIONS'] = array();
			if ($needProperties || $needDiscountCache)
				$row['PROPERTIES'] = array();
			$row['PRICES'] = array();

			$items[$id] = $row;
			$itemIdsList[$id] = $id;

			if ($elementType == $arProductTypes["TYPE_SKU"])
				$skuIdsList[$id] = $id;
			else
				$simpleIdsList[$id] = $id;
		}
		unset($row, $iterator);

		if($arUserParams["ONE_CATALOG_TYPE"] == 'Y')
		{
			$skuIdsList = $simpleIdsList;
		}
		
		if (!empty($items))
		{
			$moduleWorker->PrepareProducts($items, array(), $itemOptions);

			/* foreach (array_chunk($itemIdsList, 500) as $pageIds)
			{
				$iterator = Iblock\SectionElementTable::getList(array(
					'select' => array('IBLOCK_ELEMENT_ID', 'IBLOCK_SECTION_ID'),
					'filter' => array('@IBLOCK_ELEMENT_ID' => $pageIds, '==ADDITIONAL_PROPERTY_ID' => null),
					'order' => array('IBLOCK_ELEMENT_ID' => 'ASC')
				));
				while ($row = $iterator->fetch())
				{
					$id = (int)$row['IBLOCK_ELEMENT_ID'];
					$sectionId = (int)$row['IBLOCK_SECTION_ID'];
					$items[$id]['SECTIONS'][$sectionId] = $sectionId;
					unset($sectionId, $id);
				}
				unset($row, $iterator);
			}
			unset($pageIds); */

			if ($needProperties || $needDiscountCache)
			{
				if (!empty($propertyIdList))
				{
					\CIBlockElement::GetPropertyValuesArray(
						$items,
						$IBLOCK_ID,
						array(
							'ID' => $itemIdsList,
							'IBLOCK_ID' => $IBLOCK_ID
						),
						array('ID' => $propertyIdList),
						array('USE_PROPERTY_ID' => 'Y', 'PROPERTY_FIELDS' => $propertyFields)
					);
				}
				
				// foreach($items as $item){
					// echo '<pre>'; print_r($item["NAME"] . ' ' . count($item["PROPERTIES"])); echo '</pre>';
				// }

				if ($needDiscountCache)
				{
					foreach ($itemIdsList as $id)
						\CCatalogDiscount::SetProductPropertiesCache($id, $items[$id]['PROPERTIES']);
					unset($id);
				}

				if (!$needProperties)
				{
					foreach ($itemIdsList as $id)
						$items[$id]['PROPERTIES'] = array();
					unset($id);
				}
				else
				{
					foreach ($itemIdsList as $id)
					{
						if (empty($items[$id]['PROPERTIES']))
							continue;
						foreach (array_keys($items[$id]['PROPERTIES']) as $index)
						{
							$propertyId = $items[$id]['PROPERTIES'][$index]['ID'];
							if (!isset($getPropertyIds[$propertyId]))
								unset($items[$id]['PROPERTIES'][$index]);
						}
						unset($propertyId, $index);
					}
					unset($id);
				}
				
				// foreach($items as $item){
					// echo '<pre>'; print_r($item["NAME"] . ' ' . count($item["PROPERTIES"])); echo '</pre>';
				// }
			}

			if ($needDiscountCache)
			{
				\CCatalogDiscount::SetProductSectionsCache($itemIdsList);
				\CCatalogDiscount::SetDiscountProductCache($itemIdsList, array('IBLOCK_ID' => $IBLOCK_ID, 'GET_BY_ID' => 'Y'));
			}

			if (!empty($skuIdsList))
			{
				$offerPropertyFilter = array();
				if ($needProperties || $needDiscountCache)
				{
					if (!empty($propertyIdList))
						$offerPropertyFilter = array('ID' => $propertyIdList);
				}

				$offers = \CCatalogSku::getOffersList(
					$skuIdsList,
					$IBLOCK_ID,
					$offersFilter,
					$offerFields,
					$offerPropertyFilter,
					array('USE_PROPERTY_ID' => 'Y', 'PROPERTY_FIELDS' => $propertyFields)
				);
				unset($offerPropertyFilter);

				if (!empty($offers))
				{
					$offerLinks = array();
					$offerIdsList = array();
					$parentsUrl = array();
					foreach (array_keys($offers) as $productId)
					{
						unset($skuIdsList[$productId]);
						$items[$productId]['OFFERS'] = array();
						$parentsUrl[$productId] = $items[$productId]['DETAIL_PAGE_URL'];
						foreach (array_keys($offers[$productId]) as $offerId)
						{
							$productOffer = $offers[$productId][$offerId];

							$productOffer['PRICES'] = array();
							if ($needDiscountCache)
								\CCatalogDiscount::SetProductPropertiesCache($offerId, $productOffer['PROPERTIES']);
							if (!$needProperties)
							{
								$productOffer['PROPERTIES'] = array();
							}
							else
							{
								if (!empty($productOffer['PROPERTIES']))
								{
									foreach (array_keys($productOffer['PROPERTIES']) as $index)
									{
										$propertyId = $productOffer['PROPERTIES'][$index]['ID'];
										if (!isset($getPropertyIds[$propertyId]))
											unset($productOffer['PROPERTIES'][$index]);
									}
									unset($propertyId, $index);
								}
							}
							$items[$productId]['OFFERS'][$offerId] = $productOffer;
							unset($productOffer);

							$offerLinks[$offerId] = &$items[$productId]['OFFERS'][$offerId];
							$offerIdsList[$offerId] = $offerId;
						}
						unset($offerId);
					}
					if (!empty($offerIdsList))
					{
						$moduleWorker->PrepareProducts($offerLinks, $parentsUrl, $itemOptions);

						foreach (array_chunk($offerIdsList, 500) as $pageIds)
						{
							if ($needDiscountCache)
							{
								\CCatalogDiscount::SetProductSectionsCache($pageIds);
								\CCatalogDiscount::SetDiscountProductCache(
									$pageIds,
									array('IBLOCK_ID' => $arCatalog['IBLOCK_ID'], 'GET_BY_ID' => 'Y')
								);
							}

							if (!$filterAvailable)
							{
								if($moduleWorker->checkModule('catalog', '17.0.0'))
								{
									$iterator = Catalog\ProductTable::getList(array(
										'select' => ($vatExport ? array('ID', 'AVAILABLE', 'VAT_ID', 'VAT_INCLUDED') : array('ID', 'AVAILABLE')),
										'filter' => array('@ID' => $pageIds)
									));
									while ($row = $iterator->fetch())
									{
										$id = (int)$row['ID'];
										$offerLinks[$id]['CATALOG_AVAILABLE'] = $row['AVAILABLE'];
										if ($vatExport)
										{
											$row['VAT_ID'] = (int)$row['VAT_ID'];
											$offerLinks[$id]['CATALOG_VAT_ID'] = ($row['VAT_ID'] > 0 ? $row['VAT_ID'] : $offersCatalog['VAT_ID']);
											$offerLinks[$id]['CATALOG_VAT_INCLUDED'] = $row['VAT_INCLUDED'];
										}
									}
									unset($id, $row, $iterator);
								}
								else
								{
									$iterator = CCatalogProduct::GetList(
										array(),
										array('@ID' => $pageIds),
										false,
										false,
										($vatExport ? array('ID', 'AVAILABLE', 'VAT_ID', 'VAT_INCLUDED') : array('ID', 'AVAILABLE'))
									);
									while ($row = $iterator->Fetch())
									{
										$id = (int)$row['ID'];
										$offerLinks[$id]['CATALOG_AVAILABLE'] = $row['AVAILABLE'];
										if ($vatExport)
										{
											$row['VAT_ID'] = (int)$row['VAT_ID'];
											$offerLinks[$id]['CATALOG_VAT_ID'] = ($row['VAT_ID'] > 0 ? $row['VAT_ID'] : $offersCatalog['VAT_ID']);
											$offerLinks[$id]['CATALOG_VAT_INCLUDED'] = $row['VAT_INCLUDED'];
										}
									}
									unset($id, $row, $iterator);
								}
							}

							// load vat cache
							/* $vatList = CCatalogProduct::GetVATDataByIDList($pageIds);
							unset($vatList); */

							$priceFilter = [
								'@PRODUCT_ID' => $pageIds,
								[
									'LOGIC' => 'OR',
									'<=QUANTITY_FROM' => 1,
									'=QUANTITY_FROM' => null
								],
								[
									'LOGIC' => 'OR',
									'>=QUANTITY_TO' => 1,
									'=QUANTITY_TO' => null
								]
							];
							if ($selectedPriceType > 0)
								$priceFilter['=CATALOG_GROUP_ID'] = $selectedPriceType;
							else
								$priceFilter['@CATALOG_GROUP_ID'] = $priceTypeList;
							
							$arPriceSelect = array('ID', 'PRODUCT_ID', 'CATALOG_GROUP_ID', 'PRICE', 'CURRENCY');
							
							if($moduleWorker->checkModule('catalog', '17.0.0'))
							{
								$iterator = Catalog\PriceTable::getList([
									'select' => $arPriceSelect,
									'filter' => $priceFilter
								]);

								while ($price = $iterator->fetch())
								{
									$id = (int)$price['PRODUCT_ID'];
									$priceTypeId = (int)$price['CATALOG_GROUP_ID'];
									$offerLinks[$id]['PRICES'][$priceTypeId] = $price;
									unset($priceTypeId, $id);
								}
								unset($price, $iterator);
							}
							else
							{
								$db_res = CPrice::GetList(array(), $priceFilter, false, false, $arPriceSelect);
								while ($price = $db_res->Fetch())
								{
									$id = (int)$price['PRODUCT_ID'];
									$priceTypeId = (int)$price['CATALOG_GROUP_ID'];
									$offerLinks[$id]['PRICES'][$priceTypeId] = $price;
									unset($priceTypeId, $id);
								}
								unset($price, $db_res);
							}

							if ($saleDiscountOnly)
							{
								Catalog\Discount\DiscountManager::preloadPriceData(
									$pageIds,
									($selectedPriceType > 0 ? [$selectedPriceType] : $priceTypeList)
								);
							}
						}
						unset($pageIds);
					}
					unset($parentsUrl, $offerIdsList, $offerLinks);
				}
				unset($offers);

				if (!empty($skuIdsList) && $arUserParams["ONE_CATALOG_TYPE"] != 'Y')
				{
					foreach ($skuIdsList as $id)
					{
						unset($items[$id]);
						unset($itemIdsList[$id]);
					}
					unset($id);
				}
			}

			if (!empty($simpleIdsList))
			{
				foreach (array_chunk($simpleIdsList, 500) as $pageIds)
				{
					// load vat cache
					/* $vatList = CCatalogProduct::GetVATDataByIDList($pageIds);
					unset($vatList); */

					$priceFilter = [
						'@PRODUCT_ID' => $pageIds,
						[
							'LOGIC' => 'OR',
							'<=QUANTITY_FROM' => 1,
							'=QUANTITY_FROM' => null
						],
						[
							'LOGIC' => 'OR',
							'>=QUANTITY_TO' => 1,
							'=QUANTITY_TO' => null
						]
					];
					if ($selectedPriceType > 0)
						$priceFilter['=CATALOG_GROUP_ID'] = $selectedPriceType;
					else
						$priceFilter['@CATALOG_GROUP_ID'] = $priceTypeList;

					$arPriceSelect = array('ID', 'PRODUCT_ID', 'CATALOG_GROUP_ID', 'PRICE', 'CURRENCY');
							
					if($moduleWorker->checkModule('catalog', '17.0.0'))
					{
						$iterator = Catalog\PriceTable::getList([
							'select' => $arPriceSelect,
							'filter' => $priceFilter
						]);

						while ($price = $iterator->fetch())
						{
							$id = (int)$price['PRODUCT_ID'];
							$priceTypeId = (int)$price['CATALOG_GROUP_ID'];
							$items[$id]['PRICES'][$priceTypeId] = $price;
							unset($priceTypeId, $id);
						}
						unset($price, $iterator);
					}
					else
					{
						$db_res = CPrice::GetList(array(), $priceFilter, false, false, $arPriceSelect);
						while ($price = $db_res->Fetch())
						{
							$id = (int)$price['PRODUCT_ID'];
							$priceTypeId = (int)$price['CATALOG_GROUP_ID'];
							$items[$id]['PRICES'][$priceTypeId] = $price;
							unset($priceTypeId, $id);
						}
						unset($price, $db_res);
					}

					if ($saleDiscountOnly)
					{
						Catalog\Discount\DiscountManager::preloadPriceData(
							$pageIds,
							($selectedPriceType > 0 ? [$selectedPriceType] : $priceTypeList)
						);
					}
				}
				unset($pageIds);
			}
		}
		
		$itemsContent = '';
		if (!empty($items))
		{
			foreach ($itemIdsList as $id)
			{
				$CUR_ELEMENT_ID = $id;

				$row = $items[$id];
				$row["IS_MAIN"] = 'Y';
				
				/* if (!empty($row['SECTIONS']))
				{
					foreach ($row['SECTIONS'] as $sectionId)
					{
						if (!isset($arAvailGroups[$sectionId]))
							continue;
						$row['CATEGORY_ID'] = $sectionId;
					}
					unset($sectionId);
				}
				else
				{
					$row['CATEGORY_ID'] = $intMaxSectionID;
				}
				if (!isset($row['CATEGORY_ID']))
					continue; */
				
				// echo '<pre>'; print_r($row); echo '</pre>';
				
				if($arUserParams["PROPS_SETTING"]["GET_SEO_FIELDS"])
				{
					$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($row["IBLOCK_ID"], $row["ID"]);
					$tmp = $ipropValues->getValues();
					if(!empty($tmp)){
						foreach($tmp as $k=>$v){
							$row[$k] = $v;
						}
					}
					unset($tmp);
					unset($ipropValues);
					// echo '<pre>'; print_r($row); echo '</pre>';

				}
				
				if($row["IBLOCK_SECTION_ID"])
					$row["IBLOCK_SECTION_NAME"] = $moduleWorker->getSectionName($row["IBLOCK_SECTION_ID"]);
				
				
				if (($row['CATALOG_TYPE'] == $arProductTypes["TYPE_SKU"] || $arUserParams["ONE_CATALOG_TYPE"] == 'Y') && !empty($row['OFFERS']))
				{
					$minOfferId = null;
					$minOfferPrice = null;

					foreach (array_keys($row['OFFERS']) as $offerId)
					{
						if (empty($row['OFFERS'][$offerId]['PRICES']))
						{
							unset($row['OFFERS'][$offerId]);
							continue;
						}
						
						$fullPrice = 0;
						$minPrice = 0;
						$minPriceCurrency = '';

						$calculatePrice = CCatalogProduct::GetOptimalPrice(
							$row['OFFERS'][$offerId]['ID'],
							1,
							array(2),
							'N',
							$row['OFFERS'][$offerId]['PRICES'],
							$site['LID'],
							array()
						);
						
						if (!empty($calculatePrice))
						{
							$minPrice = $calculatePrice['RESULT_PRICE']['DISCOUNT_PRICE'];
							$fullPrice = $calculatePrice['RESULT_PRICE']['BASE_PRICE'];
							$minPriceCurrency = $calculatePrice['RESULT_PRICE']['CURRENCY'];
							
							$timePrice = ($calculatePrice["DISCOUNT"]["ACTIVE_FROM"] && $calculatePrice["DISCOUNT"]["ACTIVE_TO"]) ? date("Y-m-d\TH:iO", strtotime($calculatePrice["DISCOUNT"]["ACTIVE_FROM"])).'/'.date("Y-m-d\TH:iO", strtotime($calculatePrice["DISCOUNT"]["ACTIVE_TO"])) : '';
						}
						unset($calculatePrice);
						
						if($oldPriceType){
							$db_res_price = CPrice::GetList(array(), array("PRODUCT_ID" => $row['OFFERS'][$offerId]['ID'], "CATALOG_GROUP_ID" => $oldPriceType), false, false, array());
							while ($arOldPrice = $db_res_price->Fetch())
							{
								if(!$arOldPrice["PRICE"]) continue;
								
								if($arOldPrice["CURRENCY"] != $minPriceCurrency){
									$priceVal = CCurrencyRates::ConvertCurrency($arOldPrice["PRICE"], $arOldPrice["CURRENCY"], $minPriceCurrency)*1;
								}else{
									$priceVal = $arOldPrice["PRICE"]*1;
								}
								
								if($priceVal > $minPrice){
									$fullPrice = $priceVal;
								}
								/* elseif($priceVal < $minPrice){
									$minPrice = $priceVal;
								} */
							}
							unset($db_res_price);
						}elseif(count($oldPriceProp) > 0){
							$priceVal = 0;
							if($oldPriceProp[$row['OFFERS'][$offerId]["IBLOCK_ID"]]){
								$priceVal = $row['OFFERS'][$offerId]["PROPERTIES"][$oldPriceProp[$row['OFFERS'][$offerId]["IBLOCK_ID"]]]["VALUE"] * 1;
								if($priceVal > 0 && $priceVal > $minPrice){
									$fullPrice = $priceVal;
								}
							}
							if(!$priceVal){
								if($oldPriceProp[$row["IBLOCK_ID"]]){
									$priceVal = $row["PROPERTIES"][$oldPriceProp[$row["IBLOCK_ID"]]]["VALUE"] * 1;
									if($priceVal > 0 && $priceVal > $minPrice){
										$fullPrice = $priceVal;
									}
								}
							}
						}
						
						
						if ($minPrice <= 0)
						{
							unset($row['OFFERS'][$offerId]);
							continue;
						}
						$row['OFFERS'][$offerId]['RESULT_PRICE'] = array(
							'MIN_PRICE' => $minPrice,
							'FULL_PRICE' => $fullPrice,
							'CURRENCY' => $minPriceCurrency,
							'TIME_PRICE' => $timePrice,
						);
						if ($minOfferPrice === null || $minOfferPrice > $minPrice)
						{
							$minOfferId = $offerId;
							$minOfferPrice = $minPrice;
						}
					}
					unset($offerId);

					if ($arSKUExport['SKU_EXPORT_COND'] == YANDEX_SKU_EXPORT_MIN_PRICE)
					{
						if ($minOfferId === null)
							$row['OFFERS'] = array();
						else
							$row['OFFERS'] = array($minOfferId => $row['OFFERS'][$minOfferId]);
					}
					if (empty($row['OFFERS']))
						continue;
					
					foreach ($row['OFFERS'] as $offer)
					{
						$need_return_row_props = false;
						
						$offer["CALCULATED"] = array();
						$offer["IS_OFFER"] = 'Y';
						
						$offer["CALCULATED"]["PICTURE"] = (!empty($offer['PICTURE']) ? $offer['PICTURE'] : $row['PICTURE']);
						
						// get Main Picture from properties
						$pid = $fields["additional_image_link_sku"];
						if(empty($offer["CALCULATED"]["PICTURE"]) && $pid)
						{
							if(!empty($offer["PROPERTIES"][$pid]["VALUE"]))
							{
								if(!is_array($offer["PROPERTIES"][$pid]["VALUE"])) $offer["PROPERTIES"][$pid]["VALUE"] = array($offer["PROPERTIES"][$pid]["VALUE"]);
								
								foreach($offer["PROPERTIES"][$pid]["VALUE"] as $addImageKey=>$addImageID)
								{
									if($offer["PROPERTIES"][$pid]["PROPERTY_TYPE"] == 'F')
									{
										$pictureFile = CFile::GetFileArray($addImageID);
										if (!empty($pictureFile))
										{
											$offer["CALCULATED"]["PICTURE"] = $moduleWorker->prepareImageLink($pictureFile['SRC'], $usedProtocol, $site['SERVER_NAME']);

											unset($offer["PROPERTIES"][$pid]["VALUE"][$addImageKey]); unset($pictureFile);
											break;
										}
									}
									else
									{
										$offer["CALCULATED"]["PICTURE"] = $moduleWorker->prepareImageLink($addImageID, $usedProtocol, $site['SERVER_NAME']);
										
										unset($offer["PROPERTIES"][$pid]["VALUE"][$addImageKey]);
										break;
									}
								}
							}
							
							if(empty($offer["CALCULATED"]["PICTURE"]))
							{
								if(!empty($row["PROPERTIES"][$pid]["VALUE"]))
								{
									$need_return_row_props = $row["PROPERTIES"];
									
									if(!is_array($row["PROPERTIES"][$pid]["VALUE"])) $row["PROPERTIES"][$pid]["VALUE"] = array($row["PROPERTIES"][$pid]["VALUE"]);
									
									foreach($row["PROPERTIES"][$pid]["VALUE"] as $addImageKey=>$addImageID)
									{
										if($row["PROPERTIES"][$pid]["PROPERTY_TYPE"] == 'F')
										{
											$pictureFile = CFile::GetFileArray($addImageID);
											if (!empty($pictureFile))
											{
												$offer["CALCULATED"]["PICTURE"] = $moduleWorker->prepareImageLink($pictureFile['SRC'], $usedProtocol, $site['SERVER_NAME']);
											
												unset($row["PROPERTIES"][$pid]["VALUE"][$addImageKey]); unset($pictureFile);
												break;
											}
										}
										else
										{
											$offer["CALCULATED"]["PICTURE"] = $moduleWorker->prepareImageLink($addImageID, $usedProtocol, $site['SERVER_NAME']);
											
											unset($row["PROPERTIES"][$pid]["VALUE"][$addImageKey]);
											break;	
										}
									}
								}
							}
						}
						// end get Main Picture from properties
						
						$offer["CALCULATED"]["UTM"] = '';
						foreach($arUserParams['arUtmParams'] as $utm_item)
						{
							unset($value);
							if($fields[$utm_item])
							{
								$value = trim($moduleWorker->getParam(
									$offer,
									$utm_item,
									$fields[$utm_item],
									$arProperties,
									$arUserTypeFormat,
									$usedProtocol,
									$getClearValue = true
								));
								if ($value == '')
								{
									$value = trim($moduleWorker->getParam(
										$row,
										$utm_item,
										$fields[$utm_item],
										$arProperties,
										$arUserTypeFormat,
										$usedProtocol,
										$getClearValue = true
									));
								}
								
								if($value)
									$offer["CALCULATED"]["UTM"] .= (($offer["CALCULATED"]["UTM"]) ? '&' : '') . $utm_item . '='.$value;
							}
						}
						unset($value);
						
						$offer["CALCULATED"]["DESCRIPTION"] = trim($offer['DESCRIPTION'] !== '' ? $offer['DESCRIPTION'] : $row['DESCRIPTION']);
						$key = 'description_sku';
						if($fields[$key])
						{
							$offer["CALCULATED"]["DESCRIPTION"] = trim($moduleWorker->getParam(
								$offer,
								$key,
								$fields[$key],
								$arProperties,
								$arUserTypeFormat,
								$usedProtocol,
								$getClearValue = true
							));
							if ($offer["CALCULATED"]["DESCRIPTION"] == '')
							{
								$offer["CALCULATED"]["DESCRIPTION"] = trim($moduleWorker->getParam(
									$row,
									$key,
									$fields[$key],
									$arProperties,
									$arUserTypeFormat,
									$usedProtocol,
									$getClearValue = true
								));
							}
						}
						unset($key);
						
						if($offer["CALCULATED"]["DESCRIPTION"])
							$offer["CALCULATED"]["DESCRIPTION"] = $moduleWorker->prepareDescription($offer["CALCULATED"]["DESCRIPTION"], 'html', $itemOptions['MAX_DESCRIPTION_LENGTH'], $itemOptions['DESCRIPTION_TAGS']);
						
						$minPrice = $offer['RESULT_PRICE']['MIN_PRICE'];
						$fullPrice = $offer['RESULT_PRICE']['FULL_PRICE'];
						$timePrice = $offer['RESULT_PRICE']['TIME_PRICE'];
						
						if($minPrice <= 0) continue;
					
						if($arUserParams["FILTER_PRICE"]["FROM"] > 0 && $minPrice < $arUserParams["FILTER_PRICE"]["FROM"]) continue;
						
						if($arUserParams["FILTER_PRICE"]["TO"] > 0 && $minPrice > $arUserParams["FILTER_PRICE"]["TO"]) continue;
						
						if($arUserParams["HIDE_ELEMENTS"]["QUANTITY_ZERO"] && $offer["CATALOG_QUANTITY"] <= 0) continue;
						
						if($arUserParams["HIDE_ELEMENTS"]["EMPTY_DESCRIPTION"] && $offer["CALCULATED"]["DESCRIPTION"] == '') continue;
						
						if($arUserParams["HIDE_ELEMENTS"]["EMPTY_PICTURE"] && empty($offer["CALCULATED"]["PICTURE"])) continue;
						
						$itemsContent .= "<item>\n";
							if(!empty($directoryMeasure) && $offer["CATALOG_MEASURE"])
								$offer["CATALOG_MEASURE"] = $directoryMeasure[$offer["CATALOG_MEASURE"]]["SYMBOL_INTL"];
							
							if($offer["CATALOG_PURCHASING_PRICE"]){
								if($offer["CATALOG_PURCHASING_CURRENCY"] != $offer['RESULT_PRICE']['CURRENCY']){
									$offer["CATALOG_PURCHASING_PRICE"] = sprintf("%.2f", CCurrencyRates::ConvertCurrency($offer["CATALOG_PURCHASING_PRICE"], $offer["CATALOG_PURCHASING_CURRENCY"], $offer['RESULT_PRICE']['CURRENCY']));
									
									$offer["CATALOG_PURCHASING_CURRENCY"] = $offer['RESULT_PRICE']['CURRENCY'];
								}
								
								$offer["CATALOG_PURCHASING_PRICE_FORMAT"] = $offer["CATALOG_PURCHASING_PRICE"].' '.$offer["CATALOG_PURCHASING_CURRENCY"];
							}
							
							if($offer["CALCULATED"]["UTM"])
							{
								$utm_param = (strstr($offer['DETAIL_PAGE_URL'], '?') === false ? '?' : '&') . $moduleWorker->text2xml($offer["CALCULATED"]["UTM"]);
								$itemsContent .= "<link>".$usedProtocol.$site['SERVER_NAME'].htmlspecialcharsbx($offer['DETAIL_PAGE_URL'].$utm_param)."</link>\n";
							}
							else
								$itemsContent .= "<link>".$usedProtocol.$site['SERVER_NAME'].htmlspecialcharsbx($offer['DETAIL_PAGE_URL'])."</link>\n";
							
							if($offer["CALCULATED"]["DESCRIPTION"])
								$itemsContent .= "<g:description><![CDATA[".$offer["CALCULATED"]["DESCRIPTION"]."]]></g:description>\n";
							else
								$itemsContent .= "<g:description></g:description>\n";
							
							$itemsContent .= "<g:item_group_id>".$row["ID"]."</g:item_group_id>\n";
							
							if ($minPrice < $fullPrice && !$arUserParams["PROPS_SETTING"]["NO_USE_SALE_PRICE"]){
								$itemsContent .= "<g:price>".sprintf("%.2f", $fullPrice)." ".$offer['RESULT_PRICE']['CURRENCY']."</g:price>\n";
								$itemsContent .= "<g:sale_price>".sprintf("%.2f", $minPrice)." ".$offer['RESULT_PRICE']['CURRENCY']."</g:sale_price>\n";
							
								if($timePrice)
									$itemsContent .= "<g:sale_price_effective_date>".$timePrice."</g:sale_price_effective_date>\n";
							}else{
								$itemsContent .= "<g:price>".sprintf("%.2f", $minPrice)." ".$offer['RESULT_PRICE']['CURRENCY']."</g:price>\n";
							}
							
							if (!empty($offer["CALCULATED"]["PICTURE"]))
								$itemsContent .= "<g:image_link>".$offer["CALCULATED"]["PICTURE"]."</g:image_link>\n";
							
							
							$identifier_exists = 0;
							foreach ($formatList["google"] as $key)
							{
								$needSet = 1;
								
								if(in_array($key, array("color_sku"))){
									$prodKey = str_replace('_sku', '', $key);
									if(!$fields[$key] && $fields[$prodKey]){
										if($fields[$prodKey] == 'TEXT_FIELD'){
											$pkey = CArturgolubevGmerchant::getStorage("property_textfield_value", $prodKey);
											CArturgolubevGmerchant::setStorage("property_textfield_value", $key, $pkey);
										}
										
										$fields[$key] = $fields[$prodKey];
									}
								}
								
								switch ($key)
								{
									case 'description': break;
									case 'description_sku': break;
									
									case 'id': break;
									case 'color': break;
									case 'title': break;
									case 'gtin': break;
									case 'mpn': break;
									case 'additional_image_link': break;
									
									case 'id_sku':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = trim($moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											));
											if ($value == '')
											{
												$value = trim($moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												));
											}
											if ($value != '')
											{
												$needSet = 0;
												$itemsContent .= "<g:id>".$moduleWorker->text2xml($value, true)."</g:id>\n";
											}
											
											unset($value);
										}
										
										if($needSet)
											$itemsContent .= "<g:id>".$moduleWorker->text2xml($offer['ID'], true)."</g:id>\n";
									break;
									
									case 'title_sku':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = trim($moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											));
											if ($value == '')
											{
												$value = trim($moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												));
											}
											if ($value != '')
											{
												$needSet = 0;
												$itemsContent .= "<title>".$moduleWorker->prepareTitle($moduleWorker->text2xml($value, true))."</title>\n";
											}
											
											unset($value);
										}
										
										if($needSet)
											$itemsContent .= "<title>".$moduleWorker->prepareTitle($moduleWorker->text2xml(trim($offer['NAME']), true))."</title>\n";
									break;
									
									case 'availability':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
											}
											
											if ($value != ''){
												$needSet = 0;
												
												if($moduleWorker->isInt($value)){
													$itemsContent .= "<g:availability>".(IntVal($value) > 0 ? 'in stock' : 'out of stock')."</g:availability>\n";
												}else{
													$itemsContent .= "<g:availability>".$moduleWorker->text2xml($value, true)."</g:availability>\n";
												}
											}
											
											unset($value);
										}
										
										if($needSet)
											$itemsContent .= "<g:availability>".($offer['CATALOG_AVAILABLE'] == 'Y' ? 'in stock' : 'out of stock')."</g:availability>\n";
									break;
									
									case 'size':
										$arPropsCheck = array('size', 'size_alternative_1', 'size_alternative_2', 'size_alternative_3', 'size_alternative_4');
										foreach($arPropsCheck as $propkey){
											if ($fieldsExist && isset($fields[$propkey]))
											{
												$value = $moduleWorker->getParam(
													$offer,
													$propkey,
													$fields[$propkey],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
												if ($value == '')
												{
													$value = $moduleWorker->getParam(
														$row,
														$propkey,
														$fields[$propkey],
														$arProperties,
														$arUserTypeFormat,
														$usedProtocol,
														$getClearValue = true
													);
												}
												if ($value != '')
												{
													$itemsContent .= "<g:size>".$moduleWorker->text2xml($value, true)."</g:size>\n";
													break;
												}
											}
										}
										unset($value);
									break;
									
									case 'gtin_sku':
										$arPropsCheck = array('gtin_sku', 'gtin');
										foreach($arPropsCheck as $propkey){
											if ($fieldsExist && isset($fields[$propkey]))
											{
												$value = $moduleWorker->getParam(
													$offer,
													$propkey,
													$fields[$propkey],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
												if ($value == '')
												{
													$value = $moduleWorker->getParam(
														$row,
														$propkey,
														$fields[$propkey],
														$arProperties,
														$arUserTypeFormat,
														$usedProtocol,
														$getClearValue = true
													);
												}
												if ($value != '')
												{
													$identifier_exists = 1;
													$itemsContent .= "<g:gtin>".$moduleWorker->text2xml($value, true)."</g:gtin>\n";
													break;
												}
											}
										}
										unset($value);
									break;
									
									case 'google_product_category':
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);

										if(!$value && $row["IBLOCK_SECTION_ID"] && $arUserParams["PROPS_SETTING"]["SECTION_HAS_GPC"])
										{
											$value = trim($moduleWorker->getSectionCategory($row["IBLOCK_ID"], $row["IBLOCK_SECTION_ID"]));
										}
										
										if ($value != '')
										{
											$itemsContent .= "<g:google_product_category>".$moduleWorker->text2xml($value, true)."</g:google_product_category>\n";
										}
										unset($value);
									break;
									
									case 'fb_product_category':
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);

										if(!$value && $row["IBLOCK_SECTION_ID"] && $arUserParams["PROPS_SETTING"]["SECTION_HAS_FPC"])
										{
											$value = trim($moduleWorker->getSectionCategoryFb($row["IBLOCK_ID"], $row["IBLOCK_SECTION_ID"]));
										}
										
										if ($value != '')
										{
											$itemsContent .= "<fb_product_category>".$moduleWorker->text2xml($value, true)."</fb_product_category>\n";
										}
										unset($value);
									break;
									
									case 'product_type':
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if(!$value && $row["IBLOCK_SECTION_ID"])
										{
											$value = trim(GetMessage("GOOGLE_PRODUCT_TYPE_MAIL_PAGE").$moduleWorker->getSectionPath($row["IBLOCK_SECTION_ID"]));
										}
										
										if ($value != '')
										{
											$value = str_replace('&gt;','>', $moduleWorker->text2xml($value, true));
											$itemsContent .= "<g:product_type>".$value."</g:product_type>\n";
										}
										
										unset($value);
									break;
									
									case 'cost_of_goods_sold':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
											}
											if ($value != ''){
												if($fields[$key] == 'CATALOG_PURCHASING_PRICE_FORMAT'){
													$itemsContent .= "<g:cost_of_goods_sold>".$moduleWorker->text2xml($value, true)."</g:cost_of_goods_sold>\n";
												}else{
													$itemsContent .= "<g:cost_of_goods_sold>".$moduleWorker->text2xml($value, true)." ".$minPriceCurrency."</g:cost_of_goods_sold>\n";
												}
											}
											
											unset($value);
										}
									break;
									case 'additional_image_link_sku':
										if ($fieldsExist && isset($fields[$key]))
										{
											if($arProperties[$fields[$key]]["PROPERTY_TYPE"] == 'F' || true)
											{
												$value = $moduleWorker->getParam(
													$offer,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol
												);
												if ($value == '')
												{
													$value = $moduleWorker->getParam(
														$row,
														$key,
														$fields[$key],
														$arProperties,
														$arUserTypeFormat,
														$usedProtocol
													);
												}
												if ($value != '')
												{
													$itemsContent .= str_replace("additional_image_link_sku", "additional_image_link", $value);
												}
												unset($value);
											}
										}
									break;
									case 'condition':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol
												);
											}
												// echo '<pre>'; var_dump($value); echo '</pre>';
											if ($value != '')
											{
												$needSet = 0;
												$itemsContent .= $value."\n";
											}
											
											unset($value);
										}
										
										if($needSet)
											$itemsContent .= "<g:condition>new</g:condition>\n";
									break;
									
									case 'shipping_block':
										$valueFull = '';
										
										$keyNew = 'shipping_price';
										if ($fieldsExist && isset($fields[$keyNew]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$keyNew,
												$fields[$keyNew],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$keyNew,
													$fields[$keyNew],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
											}
											
											if ($value != '')
											{
												$valueFull .= "<g:price>".$value."</g:price>\n";
											}
											unset($value);
										}
										
										$keyNew = 'shipping_country';
										if ($fieldsExist && isset($fields[$keyNew]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$keyNew,
												$fields[$keyNew],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$keyNew,
													$fields[$keyNew],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
											}
											
											if ($value != '')
											{
												$valueFull .= "<g:country>".$value."</g:country>\n";
											}
											unset($value);
										}
										
										if($valueFull){
											$itemsContent .= "<g:shipping>".$valueFull."</g:shipping>\n";
										}
										unset($keyNew);
										unset($valueFull);
									break;
									
									case 'shipping_length':
									case 'shipping_width':
									case 'shipping_height':
									case 'product_length':
									case 'product_width':
									case 'product_height':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
											}
											
											if ($value != ''){
												$value = trim($value);
												if($moduleWorker->isInt($value)){
													$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)." cm</g:".$key.">\n";
												}else{
													$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)."</g:".$key.">\n";
												}
											}
											unset($value);
										}
									break;

									case 'product_weight':
									case 'shipping_weight':
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol,
													$getClearValue = true
												);
											}
											
											if ($value != ''){
												$value = trim($value);
												if($moduleWorker->isInt($value)){
													$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)." g</g:".$key.">\n";
												}else{
													$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)."</g:".$key.">\n";
												}
											}
											unset($value);
										}
									break;
									
									default:
										if ($fieldsExist && isset($fields[$key]))
										{
											$value = $moduleWorker->getParam(
												$offer,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol
											);
											if ($value == '')
											{
												$value = $moduleWorker->getParam(
													$row,
													$key,
													$fields[$key],
													$arProperties,
													$arUserTypeFormat,
													$usedProtocol
												);
											}
											if ($value != '')
											{
												if($key == 'mpn_sku')
													$identifier_exists = 1;
													
												$itemsContent .= $value."\n";
											}
											unset($value);
										}
								}
							}
							
							if(!$identifier_exists)
								$itemsContent .= "<g:identifier_exists>no</g:identifier_exists>\n";
								
							
						$itemsContent .= '</item>'."\n";
						
						if(is_array($need_return_row_props) && !empty($need_return_row_props)){
							$row["PROPERTIES"] = $need_return_row_props;
						}
					}
					unset($offer);
				}
				elseif (isset($simpleIdsList[$id]) && !empty($row['PRICES']))
				{
					$row["CALCULATED"] = array();
					
					$row['CATALOG_VAT_ID'] = (int)$row['CATALOG_VAT_ID'];
					if ($row['CATALOG_VAT_ID'] == 0)
						$row['CATALOG_VAT_ID'] = $arCatalog['VAT_ID'];
					
					$fullPrice = 0;
					$minPrice = 0;
					$minPriceCurrency = '';

					$calculatePrice = CCatalogProduct::GetOptimalPrice(
						$row['ID'],
						1,
						array(2),
						'N',
						$row['PRICES'],
						$site['LID'],
						array()
					);

					if (!empty($calculatePrice))
					{
						$minPrice = $calculatePrice['RESULT_PRICE']['DISCOUNT_PRICE'];
						$fullPrice = $calculatePrice['RESULT_PRICE']['BASE_PRICE'];
						$minPriceCurrency = $calculatePrice['RESULT_PRICE']['CURRENCY'];
						
						$timePrice = ($calculatePrice["DISCOUNT"]["ACTIVE_FROM"] && $calculatePrice["DISCOUNT"]["ACTIVE_TO"]) ? date("Y-m-d\TH:iO", strtotime($calculatePrice["DISCOUNT"]["ACTIVE_FROM"])).'/'.date("Y-m-d\TH:iO", strtotime($calculatePrice["DISCOUNT"]["ACTIVE_TO"])) : '';
					}
					unset($calculatePrice);
					
					
					if($oldPriceType){
						$db_res_price = CPrice::GetList(array(), array("PRODUCT_ID" => $row["ID"], "CATALOG_GROUP_ID" => $oldPriceType), false, false, array());
						while ($arOldPrice = $db_res_price->Fetch())
						{
							if(!$arOldPrice["PRICE"]) continue;
							
							if($arOldPrice["CURRENCY"] != $minPriceCurrency){
								$priceVal = CCurrencyRates::ConvertCurrency($arOldPrice["PRICE"], $arOldPrice["CURRENCY"], $minPriceCurrency)*1;
							}else{
								$priceVal = $arOldPrice["PRICE"]*1;
							}
							
							if($priceVal > $minPrice){
								$fullPrice = $priceVal;
							}
							/* elseif($priceVal < $minPrice){
								$minPrice = $priceVal;
							} */
						}
						unset($db_res_price);
					}elseif(count($oldPriceProp) > 0){
						if($oldPriceProp[$row["IBLOCK_ID"]]){
							$priceVal = $row["PROPERTIES"][$oldPriceProp[$row["IBLOCK_ID"]]]["VALUE"] * 1;
							if($priceVal > 0 && $priceVal > $minPrice){
								$fullPrice = $priceVal;
							}
						}
					}
					
					// get Main Picture from properties
					$pid = $fields["additional_image_link"];
					if(empty($row['PICTURE']) && $pid)
					{
						if(!empty($row["PROPERTIES"][$pid]["VALUE"]))
						{
							if(!is_array($row["PROPERTIES"][$pid]["VALUE"])) $row["PROPERTIES"][$pid]["VALUE"] = array($row["PROPERTIES"][$pid]["VALUE"]);
							
							foreach($row["PROPERTIES"][$pid]["VALUE"] as $addImageKey=>$addImageID)
							{
								if($row["PROPERTIES"][$pid]["PROPERTY_TYPE"] == 'F')
								{
									$pictureFile = CFile::GetFileArray($addImageID);
									if (!empty($pictureFile))
									{
										$row['PICTURE'] = $moduleWorker->prepareImageLink($pictureFile['SRC'], $usedProtocol, $site['SERVER_NAME']);
										
										unset($row["PROPERTIES"][$pid]["VALUE"][$addImageKey]); unset($pictureFile);
										break;
									}
								}
								else
								{
									$row['PICTURE'] = $moduleWorker->prepareImageLink($addImageID, $usedProtocol, $site['SERVER_NAME']);
									unset($row["PROPERTIES"][$pid]["VALUE"][$addImageKey]);
									break;
								}
							}
						}
					}
					// end get Main Picture from properties
					
					$row["CALCULATED"]["UTM"] = '';
					foreach($arUserParams['arUtmParams'] as $utm_item)
					{
						if($fields[$utm_item])
						{
							unset($value);
							
							$value = trim($moduleWorker->getParam(
								$row,
								$utm_item,
								$fields[$utm_item],
								$arProperties,
								$arUserTypeFormat,
								$usedProtocol,
								$getClearValue = true
							));
						
							if($value)
								$row["CALCULATED"]["UTM"] .= (($row["CALCULATED"]["UTM"]) ? '&' : '') . $utm_item . '='.$value;
						}
					}
					unset($value);
					
					$row["CALCULATED"]["DESCRIPTION"] = trim($row['DESCRIPTION']);
					$key = 'description';
					if($fields[$key])
					{
						$row["CALCULATED"]["DESCRIPTION"] = trim($moduleWorker->getParam(
							$row,
							$key,
							$fields[$key],
							$arProperties,
							$arUserTypeFormat,
							$usedProtocol,
							$getClearValue = true
						));
					}
					unset($key);
					
					if($row["CALCULATED"]["DESCRIPTION"])
						$row["CALCULATED"]["DESCRIPTION"] = $moduleWorker->prepareDescription($row["CALCULATED"]["DESCRIPTION"], 'html', $itemOptions['MAX_DESCRIPTION_LENGTH'], $itemOptions['DESCRIPTION_TAGS']);
						
					if($minPrice <= 0) continue;
					
					if($arUserParams["FILTER_PRICE"]["FROM"] > 0 && $minPrice < $arUserParams["FILTER_PRICE"]["FROM"]) continue;
					
					if($arUserParams["FILTER_PRICE"]["TO"] > 0 && $minPrice > $arUserParams["FILTER_PRICE"]["TO"]) continue;
					
					if($arUserParams["HIDE_ELEMENTS"]["QUANTITY_ZERO"] && $row["CATALOG_QUANTITY"] <= 0) continue;
					
					if($arUserParams["HIDE_ELEMENTS"]["EMPTY_DESCRIPTION"] && $row["CALCULATED"]["DESCRIPTION"] == '') continue;
					
					if($arUserParams["HIDE_ELEMENTS"]["EMPTY_PICTURE"] && empty($row['PICTURE'])) continue;
					
					$itemsContent .= "<item>\n";
						if(!empty($directoryMeasure) && $row["CATALOG_MEASURE"])
							$row["CATALOG_MEASURE"] = $directoryMeasure[$row["CATALOG_MEASURE"]]["SYMBOL_INTL"];
						
						if($row["CATALOG_PURCHASING_PRICE"]){
							if($row["CATALOG_PURCHASING_CURRENCY"] != $minPriceCurrency){
								$row["CATALOG_PURCHASING_PRICE"] = sprintf("%.2f", CCurrencyRates::ConvertCurrency($row["CATALOG_PURCHASING_PRICE"], $row["CATALOG_PURCHASING_CURRENCY"], $minPriceCurrency));
								$row["CATALOG_PURCHASING_CURRENCY"] = $minPriceCurrency;
							}
							
							$row["CATALOG_PURCHASING_PRICE_FORMAT"] = $row["CATALOG_PURCHASING_PRICE"].' '.$row["CATALOG_PURCHASING_CURRENCY"];
						}
					
						if($row["CALCULATED"]["UTM"])
						{
							$utm_param = (strstr($row['DETAIL_PAGE_URL'], '?') === false ? '?' : '&') . $moduleWorker->text2xml($row["CALCULATED"]["UTM"]);
							$itemsContent .= "<link>".$usedProtocol.$site['SERVER_NAME'].htmlspecialcharsbx($row['DETAIL_PAGE_URL'].$utm_param)."</link>\n";
						}
						else
							$itemsContent .= "<link>".$usedProtocol.$site['SERVER_NAME'].htmlspecialcharsbx($row['DETAIL_PAGE_URL'])."</link>\n";
						
						if($row["CALCULATED"]["DESCRIPTION"])
							$itemsContent .= "<g:description><![CDATA[".$row["CALCULATED"]["DESCRIPTION"]."]]></g:description>\n";
						else
							$itemsContent .= "<g:description></g:description>\n";
						
						
						if ($minPrice < $fullPrice && !$arUserParams["PROPS_SETTING"]["NO_USE_SALE_PRICE"]){
							$itemsContent .= "<g:price>".sprintf("%.2f", $fullPrice)." ".$minPriceCurrency."</g:price>\n";
							$itemsContent .= "<g:sale_price>".sprintf("%.2f", $minPrice)." ".$minPriceCurrency."</g:sale_price>\n";
							
							if($timePrice)
								$itemsContent .= "<g:sale_price_effective_date>".$timePrice."</g:sale_price_effective_date>\n";
						}else{
							$itemsContent .= "<g:price>".sprintf("%.2f", $minPrice)." ".$minPriceCurrency."</g:price>\n";
						}
						
						if (!empty($row['PICTURE']))
							$itemsContent .= "<g:image_link>".$row['PICTURE']."</g:image_link>\n";
						
						$identifier_exists = 0;
						foreach ($formatList["google"] as $key)
						{
							$needSet = 1;
							
							switch ($key)
							{
								case 'description': break;
								case 'description_sku': break;
								
								case 'id_sku': break;
								case 'color_sku': break;
								case 'title_sku': break;
								case 'gtin_sku': break;
								case 'mpn_sku': break;
								case 'additional_image_link_sku': break;
														
								case 'id':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = trim($moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										));
										
										if ($value != '')
										{
											$needSet = 0;
											$itemsContent .= "<g:id>".$moduleWorker->text2xml($value, true)."</g:id>\n";
										}
										unset($value);
									}
									
									if($needSet)
										$itemsContent .= "<g:id>".$moduleWorker->text2xml($row['ID'], true)."</g:id>\n";
								break;
								
								case 'title':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = trim($moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										));
										
										if ($value != '')
										{
											$needSet = 0;
											$itemsContent .= "<title>".$moduleWorker->prepareTitle($moduleWorker->text2xml($value, true))."</title>\n";
										}
										unset($value);
									}
									
									if($needSet)
										$itemsContent .= "<title>".$moduleWorker->prepareTitle($moduleWorker->text2xml(trim($row['NAME']), true))."</title>\n";
								break;
						
								case 'availability':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if ($value != '')
										{
											$needSet = 0;
											
											if($moduleWorker->isInt($value)){
												$itemsContent .= "<g:availability>".(IntVal($value) > 0 ? 'in stock' : 'out of stock')."</g:availability>\n";
											}else{
												$itemsContent .= "<g:availability>".$moduleWorker->text2xml($value, true)."</g:availability>\n";
											}
											
										}
										
										unset($value);
									}
									
									if($needSet)
										$itemsContent .= "<g:availability>".($row['CATALOG_AVAILABLE'] == 'Y' ? 'in stock' : 'out of stock')."</g:availability>\n";
								break;
								
								case 'size':
									$arPropsCheck = array('size', 'size_alternative_1', 'size_alternative_2', 'size_alternative_3', 'size_alternative_4');
									foreach($arPropsCheck as $propkey){
										if ($fieldsExist && isset($fields[$propkey]))
										{
											$value = $moduleWorker->getParam(
												$row,
												$propkey,
												$fields[$propkey],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol,
												$getClearValue = true
											);
											
											if ($value != '')
											{
												$itemsContent .= "<g:size>".$moduleWorker->text2xml($value, true)."</g:size>\n";
												break;
											}
										}
									}
									unset($value);
								break;
								
								case 'google_product_category':
									$value = $moduleWorker->getParam(
										$row,
										$key,
										$fields[$key],
										$arProperties,
										$arUserTypeFormat,
										$usedProtocol,
										$getClearValue = true
									);

									if(!$value && $row["IBLOCK_SECTION_ID"] && $arUserParams["PROPS_SETTING"]["SECTION_HAS_GPC"])
									{
										$value = trim($moduleWorker->getSectionCategory($row["IBLOCK_ID"], $row["IBLOCK_SECTION_ID"]));
									}
									
									if ($value != '')
									{
										$itemsContent .= "<g:google_product_category>".$moduleWorker->text2xml($value, true)."</g:google_product_category>\n";
									}
									unset($value);
								break;
								
								case 'fb_product_category':
									$value = $moduleWorker->getParam(
										$row,
										$key,
										$fields[$key],
										$arProperties,
										$arUserTypeFormat,
										$usedProtocol,
										$getClearValue = true
									);

									if(!$value && $row["IBLOCK_SECTION_ID"] && $arUserParams["PROPS_SETTING"]["SECTION_HAS_FPC"])
									{
										$value = trim($moduleWorker->getSectionCategoryFb($row["IBLOCK_ID"], $row["IBLOCK_SECTION_ID"]));
									}
									
									if ($value != '')
									{
										$itemsContent .= "<fb_product_category>".$moduleWorker->text2xml($value, true)."</fb_product_category>\n";
									}
									unset($value);
								break;
								
								case 'product_type':
									$value = $moduleWorker->getParam(
										$row,
										$key,
										$fields[$key],
										$arProperties,
										$arUserTypeFormat,
										$usedProtocol,
										$getClearValue = true
									);
									
									if(!$value && $row["IBLOCK_SECTION_ID"])
									{
										$value = trim(GetMessage("GOOGLE_PRODUCT_TYPE_MAIL_PAGE").$moduleWorker->getSectionPath($row["IBLOCK_SECTION_ID"]));	
									}
									
									if ($value != '')
									{
										$value = str_replace('&gt;','>', $moduleWorker->text2xml($value, true));
										$itemsContent .= "<g:product_type>".$value."</g:product_type>\n";
									}
									unset($value);
								break;
								
								case 'cost_of_goods_sold':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if ($value != ''){
											if($fields[$key] == 'CATALOG_PURCHASING_PRICE_FORMAT'){
												$itemsContent .= "<g:cost_of_goods_sold>".$moduleWorker->text2xml($value, true)."</g:cost_of_goods_sold>\n";
											}else{
												$itemsContent .= "<g:cost_of_goods_sold>".$moduleWorker->text2xml($value, true)." ".$minPriceCurrency."</g:cost_of_goods_sold>\n";
											}
										}
										
										unset($value);
									}
								break;
								case 'additional_image_link':
									if ($fieldsExist && isset($fields[$key]))
									{
										if($arProperties[$fields[$key]]["PROPERTY_TYPE"] == 'F' || true)
										{
											$value = $moduleWorker->getParam(
												$row,
												$key,
												$fields[$key],
												$arProperties,
												$arUserTypeFormat,
												$usedProtocol
											);
											if ($value != '')
												$itemsContent .= $value;
											unset($value);
										}
									}
								break;
								case 'condition':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol
										);
										// echo '<pre>'; var_dump($value); echo '</pre>';
										
										if ($value != '')
										{
											$needSet = 0;
											$itemsContent .= $value."\n";
										}
										
										unset($value);
									}
									
									if($needSet)
										$itemsContent .= "<g:condition>new</g:condition>\n";
								break;
								
								case 'shipping_block':
									$valueFull = '';
									
									$keyNew = 'shipping_price';
									if ($fieldsExist && isset($fields[$keyNew]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$keyNew,
											$fields[$keyNew],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if ($value != '')
										{
											$valueFull .= "<g:price>".$value."</g:price>\n";
										}
										unset($value);
									}
									
									$keyNew = 'shipping_country';
									if ($fieldsExist && isset($fields[$keyNew]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$keyNew,
											$fields[$keyNew],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if ($value != '')
										{
											$valueFull .= "<g:country>".$value."</g:country>\n";
										}
										unset($value);
									}
									
									if($valueFull){
										$itemsContent .= "<g:shipping>".$valueFull."</g:shipping>\n";
									}
									
									unset($keyNew);
									unset($valueFull);
								break;
								
								case 'shipping_length':
								case 'shipping_width':
								case 'shipping_height':
								case 'product_length':
								case 'product_width':
								case 'product_height':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if ($value != ''){
											$value = trim($value);
											if($moduleWorker->isInt($value)){
												$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)." cm</g:".$key.">\n";
											}else{
												$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)."</g:".$key.">\n";
											}
										}
										unset($value);
									}
								break;
								
								case 'product_weight':
								case 'shipping_weight':
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol,
											$getClearValue = true
										);
										
										if ($value != ''){
											$value = trim($value);
											if($moduleWorker->isInt($value)){
												$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)." g</g:".$key.">\n";
											}else{
												$itemsContent .= "<g:".$key.">".$moduleWorker->text2xml($value, true)."</g:".$key.">\n";
											}
										}
										unset($value);
									}
								break;
								
								default:
									if ($fieldsExist && isset($fields[$key]))
									{
										$value = $moduleWorker->getParam(
											$row,
											$key,
											$fields[$key],
											$arProperties,
											$arUserTypeFormat,
											$usedProtocol
										);
										if ($value != '')
										{
											if($key == 'gtin' || $key == 'mpn')
												$identifier_exists = 1;
											$itemsContent .= $value."\n";
										}
										unset($value);
									}
							}
						}
						
						if(!$identifier_exists)
							$itemsContent .= "<g:identifier_exists>no</g:identifier_exists>\n";
						
					$itemsContent .= "</item>\n";
				}

				unset($row);

				if ($MAX_EXECUTION_TIME > 0 && (getmicrotime() - START_EXEC_TIME) >= $MAX_EXECUTION_TIME)
					break;
			}
			unset($id);

			\CCatalogDiscount::ClearDiscountCache(array(
				'PRODUCT' => true,
				'SECTIONS' => true,
				'SECTION_CHAINS' => true,
				'PROPERTIES' => true
			));
			\CCatalogProduct::ClearCache();
		}

		if ($itemsContent !== '')
			fwrite($itemsFile, $itemsContent);
		unset($itemsContent);

		unset($simpleIdsList, $skuIdsList);
		unset($items, $itemIdsList);
	}
	while ($MAX_EXECUTION_TIME == 0 && $existItems);
}

if (empty($arRunErrors))
{
	if (is_resource($itemsFile))
		@fclose($itemsFile);
	unset($itemsFile);
}

if (empty($arRunErrors))
{
	if ($MAX_EXECUTION_TIME == 0)
		$finalExport = true;
	if ($finalExport)
	{
		$process = true;
		$content = '';

		$items = file_get_contents($_SERVER["DOCUMENT_ROOT"].$itemFileName);
		if ($items === false)
		{
			$arRunErrors[] = GetMessage('YANDEX_STEP_ERR_DATA_FILE_NOT_READ');
			$process = false;
		}

		if ($process)
		{
			$content .= $items;
			unset($items);
			$content .= "</channel>\n"."</rss>\n";

			if (file_put_contents($_SERVER["DOCUMENT_ROOT"].$sectionFileName, $content, FILE_APPEND) === false)
			{
				$arRunErrors[] = str_replace('#FILE#', $sectionFileName, GetMessage('YANDEX_ERR_SETUP_FILE_WRITE'));
				$process = false;
			}
		}
		if ($process)
		{
			unlink($_SERVER["DOCUMENT_ROOT"].$itemFileName);

			if (file_exists($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME))
			{
				if (!unlink($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME))
				{
					$arRunErrors[] = str_replace('#FILE#', $SETUP_FILE_NAME, GetMessage('BX_CATALOG_EXPORT_YANDEX_ERR_UNLINK_FILE'));
					$process = false;
				}
			}
		}
		if ($process)
		{
			if (!rename($_SERVER["DOCUMENT_ROOT"].$sectionFileName, $_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME))
			{
				$arRunErrors[] = str_replace('#FILE#', $sectionFileName, GetMessage('BX_CATALOG_EXPORT_YANDEX_ERR_UNLINK_FILE'));
			}
		}
		unset($process);
	}
}

CCatalogDiscountSave::Enable();


if(empty($arRunErrors))
{
	if ($saleIncluded && $moduleWorker->checkModule('sale', '16.5.0'))
		Sale\DiscountCouponsManager::unFreezeCouponStorage();
}

if (!empty($arRunErrors))
	$strExportErrorMessage = implode('<br />',$arRunErrors);

if ($bTmpUserCreated)
{
	if (isset($USER_TMP))
	{
		$USER = $USER_TMP;
		unset($USER_TMP);
	}
}

// $cache = CArturgolubevGmerchant::$storage;
// echo '<pre>'; print_r($cache); echo '</pre>';
// echo '<pre>'; print_r($fields); echo '</pre>';
// die();