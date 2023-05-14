<?
use \Arturgolubev\Gmerchant\Encoding as Enc;

CJSCore::RegisterExt("aggm_select2", Array(
	"js" => array("/bitrix/js/arturgolubev.gmerchant/select2/select2.js"),
	"css" => array("/bitrix/js/arturgolubev.gmerchant/select2/select2.css"),
	"rel" => array('jquery2')
));

include 'autoload.php';

Class CArturgolubevGmerchant 
{
	const MODULE_ID = 'arturgolubev.gmerchant';
	var $MODULE_ID = 'arturgolubev.gmerchant'; 
	
	public static $storage = array();
	public static function setStorage($type, $name, $value){ self::$storage[$type][$name] = $value;}
	public static function getStorage($type, $name){ return self::$storage[$type][$name];}

	//
	static function isInt($v){
		$iv = strval(intval($v));
		return ($v == $iv && Enc::exStrlen($v) == Enc::exStrlen($iv));
	}

	//
	static function prepareProductFilter($filter, $userFilterData, $mainOptions){
		$userFilter = self::getSubFilter($userFilterData);
		$filter = array_merge($filter, $userFilter);
		
		foreach (GetModuleEvents(self::MODULE_ID, "onAfterPrepareProductFilter", true) as $arEvent)
			ExecuteModuleEventEx($arEvent, array(&$filter, $mainOptions));
		
		return $filter;
	}
	static function prepareSkuFilter($filter, $userFilterData, $mainOptions){
		$userFilter = self::getSkuSubFilter($userFilterData);
		$filter = array_merge($filter, $userFilter);
		
		foreach (GetModuleEvents(self::MODULE_ID, "onAfterPrepareSkuFilter", true) as $arEvent)
			ExecuteModuleEventEx($arEvent, array(&$filter, $mainOptions));
			
		return $filter;
	}

	//
	static function getProductTypes(){
		if(self::checkModule('catalog', '17.0.0'))
		{
			$types = array(
				"TYPE_PRODUCT" => \Bitrix\Catalog\ProductTable::TYPE_PRODUCT,
				"TYPE_SET" => \Bitrix\Catalog\ProductTable::TYPE_SET,
				"TYPE_SKU" => \Bitrix\Catalog\ProductTable::TYPE_SKU,
				"TYPE_OFFER" => \Bitrix\Catalog\ProductTable::TYPE_OFFER,
				"TYPE_FREE_OFFER" => 5,
				"TYPE_EMPTY_SKU" => 6,
			);
		}
		else
		{
			$types = array(
				"TYPE_PRODUCT" => 1,
				"TYPE_SET" => 2,
				"TYPE_SKU" => 3,
				"TYPE_OFFER" => 4,
				"TYPE_FREE_OFFER" => 5,
				"TYPE_EMPTY_SKU" => 6,
			);
		}
		
		return $types;
	}
	
	static function checkModule($module, $version)
	{
		$saleModuleInfo = CModule::CreateModuleObject($module);
		return CheckVersion($saleModuleInfo->MODULE_VERSION, $version);
	}
	
	static function _getFilterParams($s, $k, $v){
		switch($s){
			case 'like':
				$result = array("k" => "?".$k, "v" => $v);
			break;
			case 'noequally':
				$result = array("k" => "!".$k, "v" => $v);
			break;
			case 'empty':
				$result = array("k" => $k, "v" => false);
			break;
			case 'noempty':
				$result = array("k" => "!".$k, "v" => false);
			break;
			case 'more':
				$result = array("k" => ">".$k, "v" => $v[0]);
			break;
			case 'less':
				$result = array("k" => "<".$k, "v" => $v[0]);
			break;
			default:
				$result = array("k" => $k, "v" => $v);
			break;
		}
		
		return $result;
	}
	
	
	static function getSkuSubFilter($fields){
		$filter = array();
		foreach($fields as $field)
		{
			$tmp = explode('|', $field);
			
			$code = $tmp[0];
			$symbol = $tmp[1];
			$value = $tmp[2];
			$valueExp = array_values(array_diff(explode(';', $value), array('')));
			
			if(count($valueExp) == 0 && !strstr($symbol, 'empty')) continue;
						
			if($code == 'CATALOG_QUANTITY' || strstr($code, 'CATALOG_STORE_AMOUNT')){
				$e_param = self::_getFilterParams($symbol, $code, $valueExp);
				$filter[$e_param['k']] = $e_param['v'];
			}
		}
		
		return $filter;
	}
	
	static function getSubFilter($fields){
		CModule::IncludeModule('iblock');
		$filter = array();
		
		foreach($fields as $field)
		{
			$tmp = explode('|', $field);
			
			$code = $tmp[0];
			$symbol = $tmp[1];
			$value = $tmp[2];
			$valueExp = array_values(array_diff(explode(';', $value), array('')));
			
			if(count($valueExp) == 0 && !strstr($symbol, 'empty')) continue;
			
			if(IntVal($code) > 0) // its property
			{
				$prop_code = '';
				$prop_propname = '';
				$resProp = CIBlockProperty::GetByID($code);
				if($arResProp = $resProp->GetNext())
				{
					$prop_code = $arResProp["CODE"];
					
					if($arResProp["PROPERTY_TYPE"] == 'L')
						$prop_propname = '_VALUE';
					if($arResProp["PROPERTY_TYPE"] == 'E')
						$prop_propname = '.NAME';
				}
				
				$filter_subcode = 'PROPERTY_';
				$filter_subcode .= ($prop_code) ? $prop_code : $code;
				$filter_subcode .= $prop_propname;
				
				$code = $filter_subcode;
			}
			
			if($code == 'CATALOG_QUANTITY' || strstr($code, 'CATALOG_STORE_AMOUNT')){
				$arProductTypes = self::getProductTypes();
				$e_param = self::_getFilterParams($symbol, $code, $valueExp);
				
				$tmpf = array("CATALOG_TYPE" => array($arProductTypes["TYPE_PRODUCT"], $arProductTypes["TYPE_SET"]), $e_param['k'] => $e_param['v']);
				
				$filter[] = array(
					"LOGIC" => "OR",
					$tmpf,
					array("CATALOG_TYPE" => $arProductTypes["TYPE_SKU"]),
				);
			}
			else
			{
				$e_param = self::_getFilterParams($symbol, $code, $valueExp);
				$filter[$e_param['k']] = $e_param['v'];
			}
		}
		
		return $filter;
	}
	
	static function getSectionName($sectionID){
		$ctype = 'sname_by_id';
		
		$name = self::getStorage($ctype, $sectionID);
		if(!$name)
		{
			if(CModule::IncludeModule("iblock") && $sectionID)
			{
				$db_list = CIBlockSection::GetList(Array($by=>$order), array("ID"=>$sectionID), false, array("ID", "NAME"));
				while($ar_result = $db_list->GetNext())
				{
					$name = trim($ar_result['NAME']);
					self::setStorage($ctype, $sectionID, $name);
				}
			}
		}
		
		return $name;
	}
	
	static function getSectionCategory($IBLOCK_ID, $sectionID){		
		$ctype = 'gpc_by_id';
		
		$gpc = self::getStorage($ctype, $sectionID);
		if(!$gpc){
			if(CModule::IncludeModule("iblock") && $sectionID)
			{
				$db_list = CIBlockSection::GetList(Array("ID"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID, "ID"=>$sectionID), false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "UF_GM_PCATEGORY"));
				while($ar_result = $db_list->GetNext())
				{					
					if($ar_result["UF_GM_PCATEGORY"])
					{
						$gpc = $ar_result["UF_GM_PCATEGORY"];
					}
					elseif($ar_result["IBLOCK_SECTION_ID"])
					{
						$gpc = self::getSectionCategory($IBLOCK_ID, $ar_result["IBLOCK_SECTION_ID"]);
					}
				}
				
				$gpc = trim($gpc);
				self::setStorage($ctype, $sectionID, $gpc);
			}
		}
		
		return $gpc;
	}
	
	static function getSectionCategoryFb($IBLOCK_ID, $sectionID){		
		$ctype = 'fpc_by_id';
		
		$gpc = self::getStorage($ctype, $sectionID);
		if(!$gpc){
			if(CModule::IncludeModule("iblock") && $sectionID)
			{
				$db_list = CIBlockSection::GetList(Array("ID"=>"ASC"), array("IBLOCK_ID"=>$IBLOCK_ID, "ID"=>$sectionID), false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "UF_GM_FPCATEGORY"));
				while($ar_result = $db_list->GetNext())
				{					
					if($ar_result["UF_GM_FPCATEGORY"])
					{
						$gpc = $ar_result["UF_GM_FPCATEGORY"];
					}
					elseif($ar_result["IBLOCK_SECTION_ID"])
					{
						$gpc = self::getSectionCategoryFb($IBLOCK_ID, $ar_result["IBLOCK_SECTION_ID"]);
					}
				}
				
				$gpc = trim($gpc);
				self::setStorage($ctype, $sectionID, $gpc);
			}
		}
		
		return $gpc;
	}
	
	static function getSectionPath($sectionID){
		$ctype = 'spath_by_id';
		
		$path = self::getStorage($ctype, $sectionID);
		if(!$path){
			if(CModule::IncludeModule("iblock") && $sectionID)
			{
				$nav = CIBlockSection::GetNavChain(false, $sectionID, array("ID", "NAME"));
				while($pathFields = $nav->Fetch()){
					if($path != '') $path .= ' > ';
					
					$path .= trim($pathFields["NAME"]);
				}
				
				$path = trim($path);
				self::setStorage($ctype, $sectionID, $path);
			}
		}
		
		return $path;
	}
	
	static function text2xml($text = '', $bHSC = false, $bDblQuote = false)
	{
        if (!CModule::IncludeModule(self::MODULE_ID))
            return false;
		
		$bHSC = (true == $bHSC ? true : false);
		$bDblQuote = (true == $bDblQuote ? true: false);

		if ($bHSC)
		{
			$text = htmlspecialcharsbx($text);
			if ($bDblQuote)
				$text = str_replace('&quot;', '"', $text);
		}
		$text = preg_replace("/[\x1-\x8\xB-\xC\xE-\x1F]/", "", $text);
		$text = str_replace("'", "&apos;", $text);
		$text = \Arturgolubev\Gmerchant\Tools::ConvertCharset($text, LANG_CHARSET, 'utf-8');
		
		return $text;
	}
	
	static function PrepareProducts(array &$list, array $parents, array $options)
	{
        if (!CModule::IncludeModule(self::MODULE_ID))
            return false;
		
		foreach (array_keys($list) as $index)
		{
			$row = &$list[$index];

			$row['DETAIL_PAGE_URL'] = (string)$row['DETAIL_PAGE_URL'];
			if ($row['DETAIL_PAGE_URL'] !== '')
			{
				$safeRow = array();
				foreach ($row as $field => $value)
				{
					if ($field == 'PREVIEW_TEXT' || $field == 'DETAIL_TEXT')
						continue;
					if (strncmp($field, 'CATALOG_', 8) == 0)
						continue;
					if (is_array($value))
						continue;
					if (preg_match("/[;&<>\"]/", $value))
						$safeRow[$field] = htmlspecialcharsEx($value);
					else
						$safeRow[$field] = $value;
					$safeRow['~'.$field] = $value;
				}
				unset($field, $value);

				if (isset($row['PARENT_ID']) && isset($parents[$row['PARENT_ID']]))
				{
					$safeRow['~DETAIL_PAGE_URL'] = str_replace(
						array('#SERVER_NAME#', '#SITE_DIR#', '#PRODUCT_URL#'),
						array($options['SITE_NAME'], $options['SITE_DIR'], $parents[$row['PARENT_ID']]),
						$safeRow['~DETAIL_PAGE_URL']
					);
				}
				else
				{
					$safeRow['~DETAIL_PAGE_URL'] = str_replace(
						array('#SERVER_NAME#', '#SITE_DIR#'),
						array($options['SITE_NAME'], $options['SITE_DIR']),
						$safeRow['~DETAIL_PAGE_URL']
					);
				}
				$row['DETAIL_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($safeRow['~DETAIL_PAGE_URL'], $safeRow, false, 'E');
				unset($safeRow);
			}

			if ($row['DETAIL_PAGE_URL'] == '')
				$row['DETAIL_PAGE_URL'] = '/';
			else
				$row['DETAIL_PAGE_URL'] = str_replace(' ', '%20', $row['DETAIL_PAGE_URL']);

			$row['PICTURE'] = false;
			
			if($options["NO_USE_STANDART_PICTURES"] != 'Y')
			{
				$row['DETAIL_PICTURE'] = (int)$row['DETAIL_PICTURE'];
				$row['PREVIEW_PICTURE'] = (int)$row['PREVIEW_PICTURE'];
				if ($row['DETAIL_PICTURE'] > 0 || $row['PREVIEW_PICTURE'] > 0)
				{
					$pictureFile = CFile::GetFileArray($row['DETAIL_PICTURE'] > 0 ? $row['DETAIL_PICTURE'] : $row['PREVIEW_PICTURE']);
					if (!empty($pictureFile))
					{
						if (strncmp($pictureFile['SRC'], '/', 1) == 0)
							$picturePath = $options['PROTOCOL'].$options['SITE_NAME'].CHTTP::urnEncode($pictureFile['SRC'], 'utf-8');
						else
							$picturePath = $pictureFile['SRC'];
						$row['PICTURE'] = $picturePath;
						unset($picturePath);
					}
					unset($pictureFile);
				}
			}
			
			$row['DETAIL_TEXT'] = trim($row['DETAIL_TEXT']);
			$row['PREVIEW_TEXT'] = trim($row['PREVIEW_TEXT']);

			$row['DESCRIPTION'] = '';
			
			if ($row['DETAIL_TEXT']){
				$row['DESCRIPTION'] = $row['DETAIL_TEXT'];
			}elseif($row['PREVIEW_TEXT']){
				$row['DESCRIPTION'] = $row['PREVIEW_TEXT'];
			}

			unset($row);
		}
		unset($index);
	}
	
	static function prepareDescription($text, $type = 'text', $maxLength = 4750, $tags = ''){
		$text = str_replace(array(chr(13), chr(10), chr(9)), ' ', $text);
		
		if($type == 'html')
		{
			$text = strip_tags(preg_replace_callback("'&[^;]*;'", 'yandex_replace_special', $text), $tags);
		}
		else
		{
			$text = preg_replace_callback("'&[^;]*;'", 'yandex_replace_special', $text);
		}
		
		$text = TruncateText($text, $maxLength);
		
		$text = self::text2xml($text, (!$tags));
		
		return $text;
	}
	
	static function prepareTitle($text){
		$limit = 151;
		
		if(Enc::exStrlen($text) > $limit){
			$text = Enc::exSubstr($text, 0, $limit);
			$text = Enc::exSubstr($text, 0, Enc::exStrrpos($text, ' '));
		}
		
		return $text;
	}
	
	static function getParam($arOffer, $param, $PROPERTY, $arProperties, $arUserTypeFormat, $usedProtocol, $getClearValue = false)
	{
        if(!CModule::IncludeModule(self::MODULE_ID)) return false;
		
		$iblockServerName = \Arturgolubev\Gmerchant\Tools::getServerName();
		
		$param_h = self::text2xml(str_replace('_sku','',$param), true);
		
		if($PROPERTY == 'TEXT_FIELD')
		{
			$textValue = self::getStorage('property_textfield_value', $param);
			
			if(!$getClearValue) 
				$textValue = '<g:'.$param_h.'>'.self::text2xml($textValue, true).'</g:'.$param_h.'>';
			
			return $textValue;
		}
		
		if($arOffer["IS_OFFER"] == 'Y') $PROPERTY = str_replace('_SKU', '', $PROPERTY);
		if($arOffer["IS_MAIN"] == 'Y') $PROPERTY = str_replace('_MAIN', '', $PROPERTY);
		
		$strProperty = '';
		if (isset($arProperties[$PROPERTY]) && !empty($arProperties[$PROPERTY]))
		{
			$iblockProperty = $arProperties[$PROPERTY];
			$PROPERTY_CODE = $iblockProperty['CODE'];
			if (!isset($arOffer['PROPERTIES'][$PROPERTY_CODE]) && !isset($arOffer['PROPERTIES'][$PROPERTY]))
				return $strProperty;
			$arProperty = (
				isset($arOffer['PROPERTIES'][$PROPERTY_CODE])
				? $arOffer['PROPERTIES'][$PROPERTY_CODE]
				: $arOffer['PROPERTIES'][$PROPERTY]
			);
			if ($arProperty['ID'] != $PROPERTY)
				return $strProperty;
			
			$value = '';
			$description = '';
			
			$returnMultiple = ($param == 'product_highlight') ? 1 : 0;
			if($returnMultiple) $value_show_array = array();
			
			
			switch ($iblockProperty['PROPERTY_TYPE'])
			{
				case 'USER_TYPE':
					if ($iblockProperty['MULTIPLE'] == 'Y')
					{
						if (!empty($arProperty['~VALUE']))
						{
							$arValues = array();
							foreach($arProperty["~VALUE"] as $oneValue)
							{
								$isArray = is_array($oneValue);
								if (
									($isArray && !empty($oneValue))
									|| (!$isArray && $oneValue != '')
								)
								{
									$arValues[] = call_user_func_array($arUserTypeFormat[$PROPERTY],
										array(
											$iblockProperty,
											array("VALUE" => $oneValue),
											array('MODE' => 'SIMPLE_TEXT'),
										)
									);
								}
							}
							$value = implode(', ', $arValues);
							if($returnMultiple) $value_show_array = $arValues;
						}
					}
					else
					{
						$isArray = is_array($arProperty['~VALUE']);
						if (
							($isArray && !empty($arProperty['~VALUE']))
							|| (!$isArray && $arProperty['~VALUE'] != '')
						)
						{
							$value = call_user_func_array($arUserTypeFormat[$PROPERTY],
								array(
									$iblockProperty,
									array("VALUE" => $arProperty["~VALUE"]),
									array('MODE' => ($param == 'description') ? 'HTML' : 'SIMPLE_TEXT'),
								)
							);
						}
					}
					break;
				case \Bitrix\Iblock\PropertyTable::TYPE_ELEMENT:
					if (!empty($arProperty['VALUE']))
					{
						$arCheckValue = array();
						if (!is_array($arProperty['VALUE']))
						{
							$arProperty['VALUE'] = (int)$arProperty['VALUE'];
							if ($arProperty['VALUE'] > 0)
								$arCheckValue[] = $arProperty['VALUE'];
						}
						else
						{
							foreach ($arProperty['VALUE'] as $intValue)
							{
								$intValue = (int)$intValue;
								if ($intValue > 0)
									$arCheckValue[] = $intValue;
							}
							unset($intValue);
						}
						if (!empty($arCheckValue))
						{
							$filter = array(
								'@ID' => $arCheckValue
							);
							if ($iblockProperty['LINK_IBLOCK_ID'] > 0)
								$filter['=IBLOCK_ID'] = $iblockProperty['LINK_IBLOCK_ID'];

							$iterator = \Bitrix\Iblock\ElementTable::getList(array(
								'select' => array('ID', 'NAME'),
								'filter' => array($filter)
							));
							while ($row = $iterator->fetch())
							{
								$value .= ($value ? ', ' : '').$row['NAME'];
								if($returnMultiple) $value_show_array[] = $row['NAME'];
							}
							unset($row, $iterator);
						}
					}
					break;
				case \Bitrix\Iblock\PropertyTable::TYPE_SECTION:
					if (!empty($arProperty['VALUE']))
					{
						$arCheckValue = array();
						if (!is_array($arProperty['VALUE']))
						{
							$arProperty['VALUE'] = (int)$arProperty['VALUE'];
							if ($arProperty['VALUE'] > 0)
								$arCheckValue[] = $arProperty['VALUE'];
						}
						else
						{
							foreach ($arProperty['VALUE'] as $intValue)
							{
								$intValue = (int)$intValue;
								if ($intValue > 0)
									$arCheckValue[] = $intValue;
							}
							unset($intValue);
						}
						if (!empty($arCheckValue))
						{
							$filter = array(
								'@ID' => $arCheckValue
							);
							if ($iblockProperty['LINK_IBLOCK_ID'] > 0)
								$filter['=IBLOCK_ID'] = $iblockProperty['LINK_IBLOCK_ID'];

							$iterator = \Bitrix\Iblock\SectionTable::getList(array(
								'select' => array('ID', 'NAME'),
								'filter' => array($filter)
							));
							while ($row = $iterator->fetch())
							{
								$value .= ($value ? ', ' : '').$row['NAME'];
								if($returnMultiple) $value_show_array[] = $row['NAME'];
							}
							unset($row, $iterator);
						}
					}
					break;
				case \Bitrix\Iblock\PropertyTable::TYPE_LIST:
					if (!empty($arProperty['~VALUE']))
					{
						if (is_array($arProperty['~VALUE']))
						{
							$value .= implode(', ', $arProperty['~VALUE']);
							if($returnMultiple) $value_show_array = $arProperty['~VALUE'];
						}
						else
							$value .= $arProperty['~VALUE'];
					}
					break;
				case \Bitrix\Iblock\PropertyTable::TYPE_FILE:
					if (!empty($arProperty['VALUE']))
					{
						if (is_array($arProperty['VALUE']))
						{
							foreach ($arProperty['VALUE'] as $intValue)
							{
								$intValue = (int)$intValue;
								if ($intValue > 0)
								{
									if ($ar_file = CFile::GetFileArray($intValue))
									{
										if(substr($ar_file["SRC"], 0, 1) == "/")
											$strFile = $usedProtocol.$iblockServerName.CHTTP::urnEncode($ar_file['SRC'], 'utf-8');
										else
											$strFile = $ar_file["SRC"];
										
										$value_show_array[] = $strFile;
										
										$value .= ($value ? ', ' : '').$strFile;
									}
								}
							}
							unset($intValue);
						}
						else
						{
							$arProperty['VALUE'] = (int)$arProperty['VALUE'];
							if ($arProperty['VALUE'] > 0)
							{
								if ($ar_file = CFile::GetFileArray($arProperty['VALUE']))
								{
									if(substr($ar_file["SRC"], 0, 1) == "/")
										$strFile = $usedProtocol.$iblockServerName.CHTTP::urnEncode($ar_file['SRC'], 'utf-8');
									else
										$strFile = $ar_file["SRC"];
									$value = $strFile;
								}
							}
						}
						
					}
					break;
				default:
					if (true)
					{
						if($param == 'additional_image_link' || $param == 'additional_image_link_sku')
						{
							if (is_array($arProperty['VALUE']))
							{
								foreach ($arProperty['VALUE'] as $vl)
								{
									$strFile = self::prepareImageLink($vl, $usedProtocol, $iblockServerName);
									$value_show_array[] = $strFile;
									$value .= ($value ? ', ' : '').$strFile;
								}
							}
							else
							{
								$value = self::prepareImageLink($arProperty["VALUE"], $usedProtocol, $iblockServerName);
							}
						}
						else
						{
							$value = is_array($arProperty['~VALUE']) ? implode(', ', $arProperty['~VALUE']) : $arProperty['~VALUE'];
							if($returnMultiple && is_array($arProperty['~VALUE'])) $value_show_array = $arProperty['~VALUE'];
						}
					}
			}
			
			if($getClearValue) return $value;
			
			if(is_array($value_show_array) && !empty($value_show_array))
			{
				foreach($value_show_array as $value_show_key=>$value_show)
				{
					if(($param == 'additional_image_link' || $param == 'additional_image_link_sku') && $value_show_key>9) continue;
					
					if($value_show)
						$strProperty .= '<g:'.$param_h.'>'.self::text2xml($value_show, true).'</g:'.$param_h.'>';
				}
			}
			else
			{
				if($value)
					$strProperty .= '<g:'.$param_h.'>'.self::text2xml($value, true).'</g:'.$param_h.'>';
			}

			unset($iblockProperty);
		}
			
		if(IntVal($PROPERTY) <= 0 && $arOffer[$PROPERTY])
		{	
			if($PROPERTY == 'CATALOG_WEIGHT'){
				$arOffer[$PROPERTY] = $arOffer[$PROPERTY].' g';
			}elseif($PROPERTY == 'CATALOG_LENGTH' || $PROPERTY == 'CATALOG_HEIGHT' || $PROPERTY == 'CATALOG_WIDTH'){
				$arOffer[$PROPERTY] = ($arOffer[$PROPERTY] / 10).' cm';
			}
	
			if($getClearValue) return $arOffer[$PROPERTY];
			
			$strProperty .= '<g:'.$param_h.'>'.self::text2xml($arOffer[$PROPERTY], true).'</g:'.$param_h.'>';
		}

		return $strProperty;
	}
	
	static function prepareImageLink($src, $usedProtocol, $iblockServerName){
		if(substr($src, 0, 1) == "/")
			$strFile = $usedProtocol.$iblockServerName.CHTTP::urnEncode($src, 'utf-8');
		else
			$strFile = $src;
		
		return $strFile;
	}
}
?>