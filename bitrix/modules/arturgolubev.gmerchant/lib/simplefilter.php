<?
namespace Arturgolubev\Gmerchant;

class Simplefilter {
	static function preInit(){
		\CJSCore::Init(['core_condtree']);
		echo '<script src="/bitrix/components/bitrix/catalog.section/settings/filter_conditions/script.js"></script>';
		echo 'dev';
	}
}