<?
use \Arturgolubev\Smartsearch\Tools as Tools;
use \Arturgolubev\Smartsearch\Unitools as UTools;
use \Arturgolubev\Smartsearch\Encoding;

CModule::AddAutoloadClasses(
	"arturgolubev.smartsearch",
	array(
		"CSearchTitleExt" => "classes/mysql/title.php",
		"CSearchExt" => "classes/mysql/search.php",
	)
);

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/arturgolubev.smartsearch/include.php");

Class CArturgolubevSmartsearch 
{
	const MODULE_ID = 'arturgolubev.smartsearch';
	public $MODULE_ID = 'arturgolubev.smartsearch'; 

	const RULES_FILE = '/bitrix/tools/arturgolubev.smartsearch/rules.txt';
	
	const CACHE_TIME = 86400;
	const CACHE_VERSION = 'v324';
	
	/* handlers */
	static function iblockLinkPropHandler($arFields, $intIndexIblockId, $arIndexProperty){
		if($arFields["MODULE_ID"] == 'iblock' && $arFields["TITLE"] && $arFields["ITEM_ID"]){
			if($arFields["PARAM2"] == $intIndexIblockId && !empty($arIndexProperty) && Encoding::exSubstr($arFields["ITEM_ID"], 0, 1) != "S" && CModule::IncludeModule("iblock")){
				foreach($arIndexProperty as $pid)
				{
					$db_props = CIBlockElement::GetProperty($arFields["PARAM2"], $arFields["ITEM_ID"], array("sort" => "asc"), Array("ID"=>$pid));
					while($ar_props = $db_props->Fetch()){
						if($ar_props["PROPERTY_TYPE"] == 'E' && $ar_props["VALUE"]){
							$res = CIBlockElement::GetList(array(), array("ID"=>$ar_props["VALUE"]), false, array("nPageSize"=>1), array("ID", "NAME"));
							while($arFields2 = $res->Fetch()){
								$arFields["TITLE"] .= ' '.$arFields2["NAME"];
							}
						}
						
						if($ar_props["USER_TYPE"] == 'ElementXmlID' && $ar_props["VALUE"]){
							$res = CIBlockElement::GetList(array(), array("XML_ID"=>$ar_props["VALUE"]), false, array("nPageSize"=>1), array("ID", "NAME"));
							while($arFields2 = $res->Fetch()){
								$arFields["TITLE"] .= ' '.$arFields2["NAME"];
							}
						}
					}
				}
			}
		}
		
		return $arFields;
	}
	
	static function onProductChange(\Bitrix\Main\Entity\Event $event)
	{
		$product_id = $event->getParameter("id");
		if(CModule::IncludeModule("iblock") && CModule::IncludeModule(self::MODULE_ID) && IntVal($product_id["ID"]) > 0){
			// if(UTools::getSetting("sort_available_first") == 'Y'){
				CIBlockElement::UpdateSearch($product_id["ID"], true);
			// }
		}
	}
	
	static function onIndexHandler($arFields){
		if($arFields["MODULE_ID"] == "iblock" && $arFields["TITLE"] && $arFields["ITEM_ID"])
		{
			$arFields["CUSTOM_RANK"] = 0;
			
			$sett = array(
				"is_section" => (Encoding::exSubstr($arFields["ITEM_ID"], 0, 1) == 'S'),
				
				'cache' => (UTools::getSetting("disable_cache") != 'Y'),
				"tags" => (UTools::getSetting("use_title_tag_search") == "Y" ? 1 : 0),
				"props" => (UTools::getSetting("use_title_prop_search") == "Y" ? 1 : 0),
				"id_include" => (UTools::getSetting("use_title_id") == "Y" ? 1 : 0),
				"sname_include" => (UTools::getSetting("use_title_sname") == "Y" ? 1 : 0),
				"page_stop_body" => (UTools::getSetting("use_page_text_nosearch") == "Y" ? 1 : 0),
				
				"section_first" => (UTools::getSetting("sort_secton_first") == "Y" ? 1 : 0),
				"available_first" => (UTools::getSetting("sort_available_first") == "Y" ? 1 : 0),
				"available_qt_first" => (UTools::getSetting("sort_available_qt_first") == "Y" ? 1 : 0),
			);
			
			$info = $arFields["TITLE"];
			
			if($sett["is_section"])
			{
				if($sett["id_include"]){
					$info .= ' '.Encoding::exSubstr($arFields["ITEM_ID"], 1);
				}
				
				if($sett["props"]){
					$arSearchableFields = UTools::getStorage('reindex_cache', 'searchable_fields_'.$arFields["PARAM2"]);
					if(!is_array($arSearchableFields)){
						$arSearchableFields = array();
						$rsData = CUserTypeEntity::GetList(array("FIELD_NAME"=>"ASC"), array("ENTITY_ID" => "IBLOCK_".$arFields["PARAM2"]."_SECTION", "IS_SEARCHABLE" => "Y"));
						while($arRes = $rsData->Fetch()){
							$arSearchableFields[] = $arRes["FIELD_NAME"];
						}

						UTools::setStorage('reindex_cache', 'searchable_fields_'.$arFields["PARAM2"], $arSearchableFields);
					}
					
					if(!empty($arSearchableFields)){
						$arFilterSection = Array('IBLOCK_ID'=>$arFields["PARAM2"], 'ID'=>Encoding::exSubstr($arFields["ITEM_ID"], 1));
						$dbTmpList = CIBlockSection::GetList(Array($by=>$order), $arFilterSection, false, array_merge($arSearchableFields, array("ID", "NAME", "IBLOCK_ID")));
						while($arTmpFields = $dbTmpList->GetNext()){
							foreach($arSearchableFields as $v){
								if($arTmpFields[$v]){
									$info .= ' '.$arTmpFields[$v];
								}
							}
						}
					}
				}
				
				if($sett["section_first"]){
					$arFields["CUSTOM_RANK"] = 150;
				}
			}
			else
			{
				if($sett["id_include"]){
					$info .= ' '.$arFields["ITEM_ID"];
				}
				
				if($sett["tags"] && $arFields["TAGS"] != ''){
					$info .= ' '.$arFields["TAGS"];
				}
				
				if($sett["props"])
				{
					$arSearchProps = UTools::getStorage('reindex_cache', 'searchable_props_'.$arFields["PARAM2"]);
					if(!is_array($arSearchProps)){
						$arSearchProps = array();
						$properties = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "SEARCHABLE"=>"Y", "IBLOCK_ID"=>$arFields["PARAM2"]));
						while ($prop_fields = $properties->GetNext()){
							$arSearchProps[] = $prop_fields;
						}
						// AddMessage2Log($arSearchProps, 'searchable_props_'.$arFields["PARAM2"], 0);
						UTools::setStorage('reindex_cache', 'searchable_props_'.$arFields["PARAM2"], $arSearchProps);
					}
					
					if(count($arSearchProps)){
						$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>$arFields["PARAM2"], "ID"=>$arFields["ITEM_ID"]), false, Array("nPageSize"=>1), Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*"));
						if($ob = $res->GetNextElement()){
							$arElement = $ob->GetFields();  
							$arProps = $ob->GetProperties();
							
							foreach($arSearchProps as $sProp){
								$itemProp = $arProps[$sProp["CODE"]];
								
								if(($sProp["PROPERTY_TYPE"] == 'S' || $sProp["PROPERTY_TYPE"] == 'L' || $sProp["PROPERTY_TYPE"] == 'N') && !$sProp["USER_TYPE"])
								{
									if(is_array($itemProp["VALUE"]) && !empty($itemProp["VALUE"])){
										$info .= ' '.implode(' ', $itemProp["VALUE"]);
									}elseif($itemProp["VALUE"] != ''){
										$info .= ' '.$itemProp["VALUE"];
									}
								}
								elseif($sProp["PROPERTY_TYPE"] == 'S' && $sProp["USER_TYPE"] == 'directory'){
									$arVal = (is_array($itemProp["VALUE"])) ? $itemProp["VALUE"] : array($itemProp["VALUE"]);
									
									if(!empty($arVal) && $sProp["USER_TYPE_SETTINGS"]["TABLE_NAME"] && CModule::IncludeModule('highloadblock')){
										$hlblockDB = \Bitrix\Highloadblock\HighloadBlockTable::getList(
											array("filter" => array(
												'TABLE_NAME' => $sProp["USER_TYPE_SETTINGS"]["TABLE_NAME"]
											))
										);
										if($hlblock = $hlblockDB->fetch()){	
											$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
											$entity_data_class = $entity->getDataClass();
											
											$res = $entity_data_class::getList(array('filter'=>array('UF_XML_ID' => $arVal)));
											while($item = $res->fetch())
											{
												if($item["UF_NAME"])
												{
													$info .= ' '.$item["UF_NAME"];
												}
											}
										}
									}
								}
								else
								{
									// echo '<pre>'; print_r($sProp); echo '</pre>';
									// echo '<pre>'; print_r($itemProp); echo '</pre>';
									// echo '<pre>'; print_r('=============================='); echo '</pre>';
								}
							}
						}
					}
					
					// echo 'arSearchProps<pre>'; print_r($arSearchProps); echo '</pre>';
					// echo 'info <pre>'; print_r($info); echo '</pre>';
					// die();
				}
			}
			
			if($sett["sname_include"]){
				$dbElementGroups = CIBlockElement::GetElementGroups($arFields["ITEM_ID"], true, array("ID", "NAME"));
				while($arElementGroups = $dbElementGroups->Fetch()){
					$info .= ' '.$arElementGroups["NAME"];
				}
			}
			
			$arFields["TITLE"] = strip_tags(htmlspecialchars_decode($info));
			
			$arFields["TITLE"] = self::checkReplaceSymbols($arFields["TITLE"]);
			
			$arFields["TITLE"] = self::checkReplaceRules($arFields["TITLE"]);
			$arFields["TITLE"] = self::prepareQuery($arFields["TITLE"]);
			$arFields["TITLE"] = self::clearExceptionsWords($arFields["TITLE"]);
			
			if($sett["page_stop_body"]){
				$arFields["BODY"] = '';
			}else{
				$arFields["BODY"] = self::prepareQuery($arFields["BODY"]);
				$arFields["BODY"] = self::clearExceptionsWords($arFields["BODY"]);
			}
			
			
			if(CModule::IncludeModule("iblock") && CModule::IncludeModule("catalog") && !$sett["is_section"]){
				$res = CIBlockElement::GetList(Array(), array("ID" => $arFields["ITEM_ID"]), false, false, Array("ID", "NAME", "CATALOG_AVAILABLE", "CATALOG_QUANTITY"));
				while($arIbInfo = $res->Fetch())
				{
					// echo '<pre>'; print_r($arIbInfo); echo '</pre>';
					
					if($arIbInfo["CATALOG_AVAILABLE"] == 'Y'){
						if($sett["available_qt_first"]){
							if($arIbInfo["CATALOG_QUANTITY"] > 0){
								$arFields["CUSTOM_RANK"] = 100;
							}else{
								$arFields["CUSTOM_RANK"] = 50;
							}
						}else{
							if($sett["available_first"]){
								$arFields["CUSTOM_RANK"] = 100;
							}
						}
						
						$arFields["PARAMS"]["catalog_available"] = 'Y';
					}else{
						$arFields["PARAMS"]["catalog_available"] = 'N';
					}
				}
			}
		}
		
		// echo '<pre>'; print_r($sett); echo '</pre>';
		// echo '<pre>'; print_r($arFields); echo '</pre>';
		// die();
		
		return $arFields;
	}
	
	/* system helpers */
	static function getProductIdByMixed($ids = array()){return Tools::getProductIdByMixed($ids);}
	
	static function getRealElementsName($arMixedIDs){
		$result = array();
		
		if(!CModule::IncludeModule("iblock") || empty($arMixedIDs)) return $result;
		
		$tmpElementIDs = array();
		$tmpSectionIDs = array();
		foreach($arMixedIDs as $id){
			if(Encoding::exStrstr($id, 'S'))
				$tmpSectionIDs[] = str_replace('S', '', $id);
			else
				$tmpElementIDs[] = str_replace('S', '', $id);
		}
		
		if(!empty($tmpElementIDs)){
			$rsElements = CIBlockElement::GetList(array(), array("ID" => $tmpElementIDs), false, false, array("ID", "NAME"));
			while($arElement = $rsElements->Fetch())
			{
				$result[$arElement["ID"]] = array(
					"ID" => $arElement["ID"],
					"NAME" => htmlspecialcharsbx($arElement["NAME"]),
				);
			}
		}
		
		if(!empty($tmpSectionIDs)){
			$db_list = CIBlockSection::GetList(Array($by=>$order), array("ID"=>$tmpSectionIDs), false, array("ID", "NAME"));
			while($ar_result = $db_list->GetNext())
			{
				$result["S".$ar_result["ID"]] = array(
					"ID" => $ar_result["ID"],
					"NAME" => htmlspecialcharsbx($ar_result["NAME"]),
				);
			}
		}
		
		return $result;
	}
	
	static function formatElementName($oldName, $newName){
		preg_match_all('/\<b\>(.*)\<\/b\>/Usi', $oldName, $matches);
		if(!empty($matches[1])){
			$rSearch = array();
			$rReplace = array();
			
			$nnE = explode(' ', $newName);
			if(count($nnE)>0){
				foreach($nnE as $v){
					if(!trim($v)) continue;
					
					foreach($matches[1] as $vm){
						if(Encoding::exStrstr(self::prepareQuery($v), $vm)){
							$rSearch[] = $v;
							$rReplace[] = '<b>'.$v.'</b>';
						}
					}
				}
				
				
				// echo '<pre>'; print_r($rSearch); echo '</pre>';
				// echo '<pre>'; print_r($rReplace); echo '</pre>';
				
				if(count($rSearch)>0)
				{
					$newName = str_replace($rSearch, $rReplace, $newName);
				}
			}
		}
		
		return $newName;
	}

	/* workers; work register - lower */
	static function checkReplaceSymbols($q){
		$splits = UTools::getSetting('break_letters');
		if($splits){
			$arReplace = preg_split('##'.BX_UTF_PCRE_MODIFIER, $splits, -1, PREG_SPLIT_NO_EMPTY);
			
			$arq = explode(' ', ToLower($q));
			
			foreach($arq as $qk=>$qw){
				$tmp = str_replace($arReplace, ' ', $qw);
				if($tmp != $qw){
					$arq[$qk] = $qw . ' '. $tmp;
				}
			}
			return implode(' ', $arq);
		}else{
			return $q;
		}
	}
	static function checkReplaceRules($q){
		$rules = self::_getReplaceRules();
		
		$arq = explode(' ', ToLower($q));
		
		if(count($rules['w'])){
			foreach($arq as $qk=>$qw){
				foreach($rules['w'] as $rk=>$rw){
					if(preg_match('/^'.$rk.'$/', $qw))
					{
						$arq[$qk] = $rw;
						break;
					}
				}
			}
		}
		
		if(count($rules['p'])){
			foreach($rules['p'] as $rk=>$rw){
				$find = array();
				$arRuleWord = explode(' ', $rk);
				
				foreach($arRuleWord as $rule_word){
					foreach($arq as $qk=>$qw){
						if(preg_match('/^'.$rule_word.'$/', $qw)){
							$find[] = $qk;
						}
					}
				}
				
				if(count($arRuleWord) == count($find)){
					foreach($find as $qk){
						unset($arq[$qk]);
					}
					
					$arq[] = $rw;
				}
			}
		}
		
		return implode(' ', $arq);
	}
		static function _getReplaceRules(){
			$rules = array('p'=>array(), 'w'=>array());
			
			$file = $_SERVER["DOCUMENT_ROOT"].self::RULES_FILE;
			if(file_exists($file)){
				$obCache = new CPHPCache();
				$cacheId = md5("ag_smartsearch_rules_".filemtime($file));
				$cachePath = '/'.SITE_ID.'/ag_smartsearch_'.self::CACHE_VERSION.'/rules';	
				
				if($obCache->InitCache(self::CACHE_TIME, $cacheId, $cachePath)){
					$vars = $obCache->GetVars();
					$rules = $vars['rules'];
				}elseif($obCache->StartDataCache()){
					$arFileContent = explode(PHP_EOL, file_get_contents($file));
					
					if(is_array($arFileContent))
					{
						$sym1 = (Encoding::exStrstr($arFileContent[0], '||')) ? '||' : ';';
						$sym2 = (Encoding::exStrstr($arFileContent[0], '||')) ? '|' : ',';
						
						foreach($arFileContent as $fileLine){
							$fileLine = trim($fileLine);
							if(!$fileLine) continue;
							
							$arLine = explode($sym1, $fileLine);
							if(!$arLine[0] || !$arLine[1]) continue;
							
							$to = ToLower(trim($arLine[0]));
							
							$arFrom = explode($sym2, $arLine[1]);
							foreach($arFrom as $from){
								$from = trim($from);
								if($from){
									$from = str_replace('.', '\.', ToLower($from));
									$from = str_replace('*', '.*', ToLower($from));
									
									if(Encoding::exStrpos($from, ' ')){
										$rules['p'][$from] = $to;
									}else{
										$rules['w'][$from] = $to;
									}
								}
							}
						}
					}
					
					$obCache->EndDataCache(array('rules' => $rules));
				}
			}
			
			return $rules;
		}
	
	static function prepareQuery($query){
		if(defined("SMARTSEARCH_REPLACE_REGULAR")){
			$replace = SMARTSEARCH_REPLACE_REGULAR;
		}else{
			$replace = (defined("BX_UTF")) ? '/[^\w\d]/ui' : '/[\'\"?!:^~|@$=+*&.,;()\-_#\[\]\<\>\/]/i';
		}
		
		$query = preg_replace('/(\s+)/i', ' ', ToLower($query));
		
		if(GetMessage("ARTURGOLUBEV_SMARTSEARCH_E_REPLACE"))
			$query = str_replace(GetMessage("ARTURGOLUBEV_SMARTSEARCH_E_REPLACE"), GetMessage("ARTURGOLUBEV_SMARTSEARCH_E_REPLACE_S"), $query);
		
		$tmp = explode(' ', $query);
		$arQuery = array();
		
		foreach($tmp as $word)
		{
			$word = preg_replace($replace, '', $word);
			if($word && !in_array($word, $arQuery, true)){
				$arQuery[] = $word;
			}
		}

		return trim(implode(' ', $arQuery));
	}
	
	static function clearExceptionsWords($query){
		$arExc = self::_getExceptionsWords();
		if(is_array($arExc) && !empty($arExc)){
			$tmp = explode(' ', $query);
			$arQuery = array();
			foreach($tmp as $word)
			{
				if(in_array($word, $arExc)){
					continue;
				}
				
				if($word && !in_array($word, $arQuery, true)){
					$arQuery[] = $word;
				}
			}
			
			$query = implode(' ', $arQuery);
		}
		
		return $query;
	}
		static function _getExceptionsWords(){
			$st = UTools::getStorage('page_cache', 'exception_words');
			if(is_array($st)){
				$r = $st;
			}else{
				$r = array();
				$dbW = UTools::getSetting('exception_words_list');
				if($dbW){
					$r = array();
					$arW = explode(',', $dbW);
					foreach($arW as $k=>$v){
						$r[$k] = ToLower(trim($v));
					}
				}
				
				UTools::setStorage('page_cache', 'exception_words', $r);
			}
			
			return $r;
		}
	
	
	static function prepareQueryWords($q){
		$result = array();
		$aw = explode(' ', $q);
		
		$replace = Tools::getReplaceParams();
		$min_length = Tools::getMinWordLenght();
		
		foreach($aw as $sWord){
			if(Encoding::exStrlen($sWord) < $min_length) continue;
			
			if(preg_match('/[\d]+/i', $sWord)){
				$tmpWord = Tools::num_translit($sWord, "ru", $replace);
			}else{
				$tmpWord = Tools::ex_translit($sWord, "ru", $replace);
			}
			
			if($tmpWord && !in_array($tmpWord, $result))
				$result[$tmpWord] = $sWord;
		}
		
		return $result;
	}
	
	
	static function getWordsListFromDb(){
		$obCache = new CPHPCache();
		$cacheId = md5("base_cache_smart_search");
		$cachePath = '/'.SITE_ID.'/ag_smartsearch_'.self::CACHE_VERSION.'/bd';	
		
		if($obCache->InitCache(self::CACHE_TIME, $cacheId, $cachePath)){
			$vars = $obCache->GetVars();
			$result = $vars['result'];
		}elseif($obCache->StartDataCache()){
			$result = self::_getWordsListFromDb();
			$obCache->EndDataCache(array('result' => $result));
		}
		
		return $result;
	}
	static function getClearWordsListDB(){
		$obCache = new CPHPCache();
		$cacheId = md5("cache_words_clear");
		$cachePath = '/'.SITE_ID.'/ag_smartsearch_'.self::CACHE_VERSION.'/bd';	
		
		if($obCache->InitCache(self::CACHE_TIME, $cacheId, $cachePath)){
			$vars = $obCache->GetVars();
			$result = $vars['result'];
		}elseif($obCache->StartDataCache()){
			$result = array_keys(self::_getWordsListFromDb());
			$obCache->EndDataCache(array('result' => $result));
		}
		
		return $result;
	}
		static function _getWordsListFromDb(){
			$result = array();
			
			$replace = Tools::getReplaceParams();
			$min_length = Tools::getMinWordLenght();
			
			$res = Tools::dbQuery("SELECT DISTINCT WORD FROM b_search_content_title WHERE SITE_ID = '".SITE_ID."'");
			while ($arFields = $res->Fetch()) {
				$arFields["WORD"] = self::prepareQuery($arFields["WORD"]);
				if(Encoding::exStrlen($arFields["WORD"]) < $min_length) continue;
				
				if(preg_match('/[\d]+/i', $arFields["WORD"])){
					$tmpWord = Tools::num_translit($arFields["WORD"], "ru", $replace);
				}else{
					$tmpWord = Tools::ex_translit($arFields["WORD"], "ru", $replace);
				}
				
				if($tmpWord)
					$result[$arFields["WORD"]] = $tmpWord;
			}
			
			// echo '<pre>'; print_r($result); echo '</pre>';

			return $result;
		}
		
	
	static function getSimilarWordsList($query, $type = 'full'){
		$start = microtime(true);
		
		if(!is_array($query)){
			$queryWordsList = self::prepareQueryWords($query);
		}else{
			$queryWordsList = $query;
		}
		
		if(count($queryWordsList) < 1) return array();
		
		$options = array(
			'cache' => (UTools::getSetting("disable_cache") != 'Y')
		);
		
		$obCache = new CPHPCache();
		$cacheId = md5(implode('_', $queryWordsList));
		$cachePath = '/'.SITE_ID.'/ag_smartsearch_'.self::CACHE_VERSION.'/combinations_'.$type.'/'. Encoding::exSubstr(implode('_', array_keys($queryWordsList)), 0, 40);	
		
		if($options['cache'] && $obCache->InitCache(self::CACHE_TIME, $cacheId, $cachePath)){
			$from = 'cache';
			$vars = $obCache->GetVars();
			$result = $vars['result'];
		}elseif($obCache->StartDataCache()){
			$from = 'get';
			$result = self::_getSimilarWordsList($queryWordsList, $type);
			$obCache->EndDataCache(array('result' => $result));
		}
		
		// echo '<pre>'; print_r($from); echo '</pre>';
		
		if(UTools::getSetting("debug") == 'Y')
		{
			$finish = microtime(true);
			$delta = round($finish - $start, 3);
			AddMessage2Log("Similarity Words " . $from . " " .$delta, self::MODULE_ID, 0);
		}
		
		return $result;
	}
		static function _getSimilarWordsList($queryWordsList, $type){
			$result = array();
			
			$dbWordsList = self::getWordsListFromDb();
			
			$preCountVariation = 0;
			foreach ($queryWordsList as $translated => $queryWord) {
				$settings = array(
					"cache" => (UTools::getSetting("disable_cache") != 'Y'),
					"word" => $queryWord,
					"trans" => $translated,
					"type" => $type,
					"wordscount" => count($queryWordsList),
				);
				
				$arWords = self::getSimilarQueryWord($dbWordsList, $settings);			
				if(!empty($arWords))
				{
					$arFindedWords[] = $arWords;
					$preCountVariation += ($preCountVariation+1)*count($arWords);
				}
			}	
			unset($dbWordsList); 
			
			$cutCount = 200;
			
			if(!empty($arFindedWords))
			{
				if($preCountVariation < $cutCount){
					$wordMatrix = self::generateVariation($arFindedWords);
					$variation = self::generateVariants($arFindedWords);
					
					foreach(array_merge($wordMatrix, $variation) as $wordAr){
						$result[count($wordAr)][] = implode(' ', $wordAr);
					}
					unset($wordMatrix); unset($variation);
				}
				else
				{
					$wordMatrix = self::generateVariation($arFindedWords);
					if(count($wordMatrix) < $cutCount)
					{
						foreach($wordMatrix as $wordAr){
							$result[count($wordAr)][] = implode(' ', $wordAr);
						}
					}
					
					$result[1] = array();
					foreach($arFindedWords as $k=>$v){
						foreach($v as $kk=>$vv)
						{
							$result[1][] = $vv;
						}
					}
				}
				
				foreach($result as $key=>$arVals){
					$result[$key] = array_values(array_unique($arVals));
				}
			}
			
			// echo '<pre>'; print_r($arFindedWords); echo '</pre>';
			// echo '<pre>'; print_r($preCountVariation); echo '</pre>';
			// echo '<pre>'; print_r($result); echo '</pre>';
			
			return $result;
		}
	
	static function getSimilarQueryWord($dbWordsList, $settings){
		$results = array();
		
		$obCache = new CPHPCache();
		$cacheId = md5($settings["type"].'_'.$settings["word"]);
		$cachePath = '/'.SITE_ID.'/ag_smartsearch_'.self::CACHE_VERSION.'/words_'.$settings["type"].'/'.$settings["trans"];	
		
		if($settings["cache"] && $obCache->InitCache(self::CACHE_TIME, $cacheId, $cachePath))
		{
			$settings["from"] = 'cache';
			
			$vars = $obCache->GetVars();
			$results = $vars['results'];
		}
		elseif($obCache->StartDataCache())
		{
			$settings["from"] = 'get';
			
			$settings["extended_mode"] = ((($settings["type"] == 'title') ? UTools::getSetting("mode_stitle") : UTools::getSetting("mode_spage"))  != 'standart');
			$settings["metaphone_mode"] = (UTools::getSetting("mode_metaphone") != 'N');
			$settings["stripos_mode"] = ($settings["extended_mode"] || $settings["type"] == 'full');
			
			$settings["is_num"] = preg_match('/[\d]+/i', $settings["trans"]);
			
			if(!$settings["is_num"] && $settings["extended_mode"] && function_exists("stemming")){
				$settings["stemming_full"] = stemming($settings["word"]);
				if(!empty($settings["stemming_full"])){
					foreach($settings["stemming_full"] as $k=>$v){
						if($k) $settings["word_stemming"] = $k;
						break;
					}
				}
			}
			
			$settings["word_len"] = min(Encoding::exStrlen($settings["trans"]), Encoding::exStrlen($settings["word"]));
			if($settings["word_len"] <= 5){
				$settings["word_len_check"] = 1;
			}elseif($settings["word_len"] >= 9){
				$settings["word_len_check"] = 3;
			}else{
				$settings["word_len_check"] = 2;
			}
			
			$as = array_search($settings["trans"], $dbWordsList);
			if($as)
			{
				unset($dbWordsList[$as]);
				
				if($settings["word_stemming"] && $settings["wordscount"] > 1)
				{
					$as = $settings["word_stemming"];
				}
				
				if($settings["type"] == 'title' || ($settings["type"] == 'full' && !$settings["extended_mode"])){
					$results[] = $as;
				}else{
					$results[] = '"'.$as.'"';
				}
				
				$settings["metaphone_mode"] = 0;
				$settings["stripos_mode"] = 0;
			}
			
			if($settings["stripos_mode"])
			{
				$settings["stripos_stemming"] = ($settings["word_stemming"]) ? $settings["word_stemming"] : $settings["word"];
				
				foreach($dbWordsList as $rus=>$trans){
					$stpos = Encoding::exStripos($rus, $settings["stripos_stemming"]);
					
					if(($settings["extended_mode"] && $stpos !== false) || (!$settings["extended_mode"] && $stpos === 0)){
						if($settings["type"] == 'title'){
							$results[] = $settings["stripos_stemming"];
						}else{
							$results[] = '"'.$settings["stripos_stemming"].'"';
						}
						
						unset($dbWordsList[$rus]);
					}
				}
				
				if(!empty($results))
					$results = array_unique($results);
			}
			
			if(!$settings["is_num"] && $settings["metaphone_mode"])
			{
				$tmpResults = array();
				
				foreach ($dbWordsList as $rus => $trans) {
					if(preg_match('/[\d]+/i', $trans)) continue;
					
					$lvs = levenshtein($settings["trans"], $trans);
					if ($lvs <= $settings["word_len_check"]) {
						similar_text($settings["word"], $rus, $lvs2);
						$lvs3 = levenshtein($settings["word"], $rus);
						
						$tmpResults[] = array(
							"word" => array($rus => $trans),
							"similarity" => $lvs,
							"similarity_r" => $lvs2,
							"similarity_rl" => $lvs3,
						);
					}
				}
				
				if(!empty($tmpResults))
				{
					usort($tmpResults, array("CArturgolubevSmartsearch", "cmpSimilaritySort"));
				}
				
				foreach($tmpResults as $tmpResult)
				{
					foreach($tmpResult["word"] as $k=>$v)
						$results[] = $k;
				}
			}
			
			// echo '<pre>'; print_r($settings); echo '</pre>';
			
			$obCache->EndDataCache(array('results' => $results));
		}
	
		// echo 'settings <pre>'; print_r($tmpResults); echo '</pre>';
		// echo 'settings <pre>'; print_r($settings); echo '</pre>';
		// echo 'results <pre>'; print_r($results); echo '</pre>';
		
		return $results;
	}
	
	static function guessLanguage($text){
		if(!$text) return 0;
		
		// $start = microtime(true);
		
		$obCache = new CPHPCache();
		
		$result = array(
			'result' => array(),
			'variants' => array(),
			'error' => 0,
			'cicle' => 0,
		);
		
		$result['main_arr'] = explode(' ', preg_replace('/(\s+)/i', ' ', trim($text)));
		
		$replace = Tools::getReplaceParams();
		$dbWordsList = self::getClearWordsListDB();
		
		foreach($result['main_arr'] as $k=>$word){
			$tmp = CSearchLanguage::ConvertKeyboardLayout($word, 'en', 'ru');
			$tmp = CArturgolubevSmartsearch::checkReplaceRules($tmp);
			$tmp = CArturgolubevSmartsearch::prepareQuery($tmp);
			$tmp = CArturgolubevSmartsearch::clearExceptionsWords($tmp);
			$result['variants']["ru"][] = $tmp;
			
			$tmp = CSearchLanguage::ConvertKeyboardLayout($word, 'ru', 'en');
			$tmp = CArturgolubevSmartsearch::checkReplaceRules($tmp);
			$tmp = CArturgolubevSmartsearch::prepareQuery($tmp);
			$tmp = CArturgolubevSmartsearch::clearExceptionsWords($tmp);
			$result['variants']["en"][] = $tmp;
		}
		
		foreach($result['variants']["ru"] as $k=>$word){
			$eWord = $result['variants']["en"][$k];
			$wTrans = Tools::ex_translit($word.$eWord, "ru", $replace);
			
			$cachePath = '/'.SITE_ID.'/ag_smartsearch_'.self::CACHE_VERSION.'/guess_word/'.$wTrans;	
			if($obCache->InitCache(self::CACHE_TIME, $wTrans, $cachePath))
			{
				$vars = $obCache->GetVars();
				$find = $vars['find'];
			}
			elseif($obCache->StartDataCache())
			{
				$find = 0;
				$result['cicle']++;
				foreach($dbWordsList as $rus){
					$stpos = Encoding::exStripos($rus, $word);
					if($stpos !== false){
						$find = 1;
						break;
					}
				}
				if(!$find){
					$result['cicle']++;
					foreach($dbWordsList as $rus){
						$stpos = Encoding::exStripos($rus, $eWord);
						if($stpos !== false){
							$find = 2;
							break;
						}
					}
				}
				
				$obCache->EndDataCache(array('find' => $find));
			}
			
			if(!$find){
				return 0;
			}elseif($find == 2){
				$result["result"][] = $eWord;
			}elseif($find){
				$result["result"][] = $word;
			}
		}
		
		// $finish = microtime(true);
		// $delta = round($finish - $start, 3);
		// echo '<pre>'; print_r($delta); echo '</pre>';
		// echo '<pre>'; print_r($result); echo '</pre>';
		
		if(count($result["result"])){
			return implode(' ', $result["result"]);
		}
		
		return 0;
	}
	
	
	static function generateVariation($A, $i = 0){
		// echo '<pre>'; print_r('generateVariation'); echo '</pre>';
		$result = array();
		
		if ($i < count($A)){
			$variations = self::generateVariation($A, $i + 1);
			for ($j = 0; $j < count($A[$i]); $j++){
				if ($variations){
					foreach ($variations as $variation){
						$result[] = array_merge(array($A[$i][$j]), $variation);
					}
				}else{
					$result[] = array($A[$i][$j]);
				}
			}
		}
		
		return $result;
	}
	static function generateVariants($ar){		
		$result = array();
		if(count($ar)>1)
		{
			for($i=count($ar);$i>0;$i--){
				$arCopy = $ar;
				
				unset($arCopy[($i-1)]);
				$arCopy = array_values($arCopy);
				
				// $tmpVariation = self::generateVariation($arCopy);
				// foreach($tmpVariation as $variation) $result[] = $variation;
				
				$result = array_merge($result, self::generateVariation($arCopy)); 
				
				if(count($arCopy)>1){
					// $result2 = self::generateVariants($arCopy);
					// foreach($result2 as $v) $result[] = $v;
					
					$result = array_merge($result, self::generateVariants($arCopy));
				}
			}
		}
		
		return $result;
	}
	static function cmpSimilaritySort($a, $b){
		if ($a["similarity"] == $b["similarity"]){
			if($a["similarity_rl"] == $b["similarity_rl"]){
				return 0;
			}
			return ($a["similarity_rl"] < $b["similarity_rl"]) ? -1 : 1;
		}
		
		return ($a["similarity"] < $b["similarity"]) ? -1 : 1;
	}
}
?>