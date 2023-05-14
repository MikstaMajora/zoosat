<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>



<?global $SITE_THEME, $TEMPLATE_OPTIONS;?>



<?$APPLICATION->IncludeComponent(
	"aspro:com.banners.next",
	"top_slider_banners",
	Array(
		"BANNER_TYPE_THEME" => "TOP",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"IBLOCK_ID" => "38",
		"IBLOCK_TYPE" => "zoosat_adv",
		"NEWS_COUNT" => "10",
		"PROPERTY_CODE" => array(0=>"TEXT_POSITION",1=>"TARGETS",2=>"TEXTCOLOR",3=>"URL_STRING",4=>"BUTTON1TEXT",5=>"BUTTON1LINK",6=>"BUTTON2TEXT",7=>"BUTTON2LINK",8=>"",),
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"TYPE_BANNERS_IBLOCK_ID" => "36"
	)
);?>