<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<h1>Зоомагазин в Новосибирске ЗооСАТ</h1>
<?global $isShowTopAdvBottomBanner;?>
<?if($isShowTopAdvBottomBanner):?>
	<?$APPLICATION->IncludeComponent(
	"aspro:com.banners.next",
	"adv_top",
	Array(
		"BANNER_TYPE_THEME" => "UNDER_MAIN_BANNER",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"IBLOCK_ID" => "37",
		"IBLOCK_TYPE" => "zoosat_adv",
		"NEWS_COUNT" => "10",
		"PROPERTY_CODE" => array(0=>"URL",1=>"",),
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"TYPE_BANNERS_IBLOCK_ID" => "1"
	)
);?>
<?endif;?>