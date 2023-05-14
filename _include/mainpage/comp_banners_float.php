<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

 <?global $isShowFloatBanner;?> <?if($isShowFloatBanner):?>
<div class="wrapper_inner1 wides float_banners">
	 <?$APPLICATION->IncludeComponent(
	"aspro:com.banners.next",
	"zoosat_next",
	Array(
		"BANNER_TYPE_THEME" => "FLOAT",
		"BANNER_TYPE_THEME_CHILD" => "20",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CATALOG" => "/catalog/",
		"CHECK_DATES" => "Y",
		"FILTER_NAME" => "arRegionLink",
		"IBLOCK_ID" => "38",
		"IBLOCK_TYPE" => "zoosat_adv",
		"NEWS_COUNT" => "6",
		"NEWS_COUNT2" => "20",
		"PROPERTY_CODE" => array("TEXT_POSITION","URL_STRING","BUTTON2LINK","TARGETS","TEXTCOLOR",""),
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"TYPE_BANNERS_IBLOCK_ID" => "36"
	)
);?>
</div>
<div class="clearfix">
</div>


<?endif;?>