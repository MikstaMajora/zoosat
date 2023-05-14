<?
namespace Arturgolubev\Gmerchant;

class Tools {
	static function getServerName(){
		global $iblockServerName;
		return $iblockServerName;
	}
	
	static function ConvertCharset($t, $ci, $co){
		global $APPLICATION;
		return $APPLICATION->ConvertCharset($t, $ci, $co);
	}
	
	static function getCurrencyList(){
		\CModule::IncludeModule('currency');
		
		$arCurrencyList = array();
		$arCurrencyAllowed = array('RUR', 'RUB', 'USD', 'EUR', 'UAH', 'BYR', 'BYN', 'KZT');
		$dbRes = \CCurrency::GetList($by = 'sort', $order = 'asc');
		while ($arRes = $dbRes->GetNext())
		{
			if (in_array($arRes['CURRENCY'], $arCurrencyAllowed))
				$arCurrencyList[$arRes['CURRENCY']] = $arRes['FULL_NAME'];
		}
		
		return $arCurrencyList;
	}
}