<?php
use Bitrix\Main\Application,
    Bitrix\Main\Web\Uri,
    \Bitrix\Main\Page\Asset;
?>

<?php
Asset::getInstance()
    ->addString("<link href='https://pro.fontawesome.com/releases/v5.10.0/css/all.css' rel='stylesheet'/>");
?>




<?if($arSeoItem):?>
	<div class="seo_block">
		<?if($arSeoItem["DETAIL_PICTURE"]):?>
			<img src="<?=CFile::GetPath($arSeoItem["DETAIL_PICTURE"]);?>" alt="" title="" class="img-responsive"/>
		<?endif;?>

		<?ob_start();?>
		<?if($arSeoItem["PREVIEW_TEXT"]):?>
			<?=$arSeoItem["PREVIEW_TEXT"]?>
		<?endif;?>
		<?
		$html = ob_get_clean();
		$APPLICATION->AddViewContent('top_desc', $html);
		$APPLICATION->ShowViewContent('top_desc');
		$APPLICATION->ShowViewContent('sotbit_seometa_top_desc');
		?>

		<?if($arSeoItem["PROPERTY_FORM_QUESTION_VALUE"]):?>
			<table class="order-block noicons">
				<tbody>
					<tr>
						<td class="col-md-9 col-sm-8 col-xs-7 valign">
							<div class="text">
								<?$APPLICATION->IncludeComponent(
									 'bitrix:main.include',
									 '',
									 Array(
										  'AREA_FILE_SHOW' => 'page',
										  'AREA_FILE_SUFFIX' => 'ask',
										  'EDIT_TEMPLATE' => ''
									 )
								);?>
							</div>
						</td>
						<td class="col-md-3 col-sm-4 col-xs-5 valign">
							<div class="btns">
								<span><span class="btn btn-default btn-lg white transparent animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question"><span><?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : GetMessage('S_ASK_QUESTION'))?></span></span></span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		<?endif;?>
		<?if($arSeoItem["PROPERTY_TIZERS_VALUE"]):?>
			<?$GLOBALS["arLandingTizers"] = array("ID" => $arSeoItem["PROPERTY_TIZERS_VALUE"]);?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"next",
				array(
					"IBLOCK_TYPE" => "aspro_next_content",
					"IBLOCK_ID" => CNextCache::$arIBlocks[SITE_ID]["aspro_next_content"]["aspro_next_tizers"][0],
					"NEWS_COUNT" => "4",
					"SORT_BY1" => "SORT",
					"SORT_ORDER1" => "ASC",
					"SORT_BY2" => "ID",
					"SORT_ORDER2" => "DESC",
					"FILTER_NAME" => "arLandingTizers",
					"FIELD_CODE" => array(
						0 => "",
						1 => "",
					),
					"PROPERTY_CODE" => array(
						0 => "LINK",
						1 => "",
					),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" =>$arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "N",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "j F Y",
					"SET_TITLE" => "N",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"INCLUDE_SUBSECTIONS" => "Y",
					"PAGER_TEMPLATE" => "",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"PAGER_TITLE" => "",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"COMPONENT_TEMPLATE" => "next",
					"SET_BROWSER_TITLE" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_LAST_MODIFIED" => "N",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"SHOW_404" => "N",
					"MESSAGE_404" => ""
				),
				false, array("HIDE_ICONS" => "Y")
			);?>
		<?endif;?>
		<?$APPLICATION->ShowViewContent('sotbit_seometa_add_desc');?>
	</div>
<?endif;?>

<?if($iSectionsCount):?>
	<div class="section_block">
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"front_sections_only",
			Array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"COUNT_ELEMENTS" => "N",
				"ADD_SECTIONS_CHAIN" => ((!$iSectionsCount || $arParams['INCLUDE_SUBSECTIONS'] !== "N") ? 'N' : 'Y'),
				"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_PICTURES"],
				"TOP_DEPTH" => "1",
				"FILTER_NAME" => "arSubSectionFilter",
				"CACHE_FILTER" => "Y",
			),
			$component, array('HIDE_ICONS' => 'Y')
		);?>
	</div>
<?endif;?>
<?global $arTheme;?>
<?$isAjax="N";?>
<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"  && isset($_GET["ajax_get"]) && $_GET["ajax_get"] == "Y" || (isset($_GET["ajax_basket"]) && $_GET["ajax_basket"]=="Y")){
	$isAjax="Y";
}?>
<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && isset($_GET["ajax_get_filter"]) && $_GET["ajax_get_filter"] == "Y" ){
	$isAjaxFilter="Y";
}
if($isAjaxFilter == "Y")
	$isAjax="N";?>
<?$section_pos_top = \Bitrix\Main\Config\Option::get("aspro.next", "TOP_SECTION_DESCRIPTION_POSITION", "UF_SECTION_DESCR", SITE_ID );?>
<?$section_pos_bottom = \Bitrix\Main\Config\Option::get("aspro.next", "BOTTOM_SECTION_DESCRIPTION_POSITION", "DESCRIPTION", SITE_ID );?>
<?if($itemsCnt):?>
	<?
	//sort
	ob_start();
	include_once(__DIR__."/../sort.php");
	$sortHtml = ob_get_clean();
	$listElementsTemplate = $template;
	?>

	<?// sliceheight for ajax mode?>
	<?if($arParams['AJAX_MODE'] == 'Y' && strpos($_SERVER['REQUEST_URI'], 'bxajaxid') !== false):?>
		<script type="text/javascript">
			setTimeout(function(){
				$('.ajax_load .catalog_block .catalog_item_wrapp .catalog_item .item-title').sliceHeight({resize: false});
				$('.ajax_load .catalog_block .catalog_item_wrapp .catalog_item .cost').sliceHeight({resize: false});
				$('.ajax_load .catalog_block .catalog_item_wrapp .item_info').sliceHeight({resize: false});
				$('.ajax_load .catalog_block .catalog_item_wrapp').sliceHeight({classNull: '.footer_button', resize: false});
			}, 100);
			setStatusButton();
		</script>
	<?endif;?>

	<?// filer?>
	<?if($arTheme["FILTER_VIEW"]["VALUE"] === "VERTICAL"):?>
		<?//add filter with ajax?>
		<?if($arParams['AJAX_MODE'] == 'Y' && strpos($_SERVER['REQUEST_URI'], 'bxajaxid') !== false):?>
			<div class="filter_tmp swipeignore">
				<?include_once(__DIR__."/../filter.php")?>
			</div>
			<script type="text/javascript">
				if(typeof window['trackBarOptions'] !== 'undefined'){
					window['trackBarValues'] = {}
					for(key in window['trackBarOptions']){
						window['trackBarValues'][key] = {
							'leftPercent': window['trackBar' + key].leftPercent,
							'leftValue': window['trackBar' + key].minInput.value,
							'rightPercent': window['trackBar' + key].rightPercent,
							'rightValue': window['trackBar' + key].maxInput.value,
						}
					}
				}

				if($('.filter_wrapper_ajax').length)
					$('.filter_wrapper_ajax').remove();
				var filter_node = $('.left_block .bx_filter.bx_filter_vertical'),
					new_filter_node = $('<div class="filter_wrapper_ajax"></div>'),
					left_block_node = $('#content .left_block');
				if(!filter_node.length)
				{
					if(left_block_node.find('.menu_top_block').length)
						new_filter_node.insertAfter(left_block_node.find('.menu_top_block'));
				}
				else
				{
					new_filter_node.insertBefore(filter_node);
					filter_node.remove();
				}
				$('.filter_tmp').appendTo($('.filter_wrapper_ajax'));

				if(typeof window['trackBarOptions'] !== 'undefined'){
					for(key in window['trackBarOptions']){
						window['trackBarOptions'][key].leftPercent = window['trackBarValues'][key].leftPercent;
						window['trackBarOptions'][key].rightPercent = window['trackBarValues'][key].rightPercent;
						window['trackBarOptions'][key].curMinPrice = window['trackBarValues'][key].leftValue;
						window['trackBarOptions'][key].curMaxPrice = window['trackBarValues'][key].rightValue;
						window['trackBar' + key] = new BX.Iblock.SmartFilter(window['trackBarOptions'][key]);
						window['trackBar' + key].minInput.value = window['trackBarValues'][key].leftValue;
						window['trackBar' + key].maxInput.value = window['trackBarValues'][key].rightValue;
					}
				}

			</script>
		<?endif;?>
		<?ob_start();?>
			<?include_once(__DIR__."/../filter.php")?>
			<script>
				$('#content > .wrapper_inner > .left_block').addClass('filter_ajax filter_visible');
			</script>
		<?$html = ob_get_clean();?>
		<?$APPLICATION->AddViewContent('left_menu', $html);?>
	<?endif;?>
	<?if(isset($arParams['LANDING_POSITION']) && $arParams['LANDING_POSITION'] === 'BEFORE_PRODUCTS'):?>
	    <div class="<?=($arParams["LANDING_TYPE_VIEW"] ? $arParams["LANDING_TYPE_VIEW"] : "landing_1" );?>" >
		    <?@include_once(($arParams["LANDING_TYPE_VIEW"] ? $arParams["LANDING_TYPE_VIEW"] : "landing_1").'.php');?>
	    </div>
	<?endif;?>
	<div class="right_block1 clearfix catalog <?=strtolower($arTheme["FILTER_VIEW"]["VALUE"]);?>" id="right_block_ajax">
		<?if($arTheme["FILTER_VIEW"]["VALUE"] === "HORIZONTAL" || $arTheme["FILTER_VIEW"]["VALUE"] === "COMPACT"){?>
			<div class="<?=($arTheme["FILTER_VIEW"]["VALUE"]=="HORIZONTAL" ? 'filter_horizontal' : '');?><?=($arTheme["FILTER_VIEW"]["VALUE"]=="COMPACT" ? ' filter_compact' : '');?> swipeignore">
				<?include_once(__DIR__."/../filter.php")?>
			</div>
		<?}/*else{?>
			<div class="js_filter filter_horizontal">
				<?if($isAjaxFilter == "Y"):?>
					<?include(__DIR__."/../filter.php")?>
				<?else:?>
					<div class="bx_filter bx_filter_vertical"></div>
				<?endif;?>
			</div>
		<?}*/?>
		<div class="inner_wrapper">
<?endif;?>
			<?if(!$arSeoItem):?>
				<?if($arParams["SHOW_SECTION_DESC"] != 'N' && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
					<?ob_start();?>
					<?if($posSectionDescr === "BOTH"):?>
						<?if ($arSection[$section_pos_top]):?>
							<div class="group_description_block top">
								<div><?=$arSection[$section_pos_top]?></div>
							</div>
						<?endif;?>
					<?elseif($posSectionDescr === "TOP"):?>
						<?if($arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]):?>
							<div class="group_description_block top">
								<div><?=$arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]?></div>
							</div>
						<?elseif($arSection["DESCRIPTION"]):?>
							<div class="group_description_block top">
								<div><?=$arSection["DESCRIPTION"]?></div>
							</div>
						<?elseif($arSection["UF_SECTION_DESCR"]):?>
							<div class="group_description_block top">
								<div><?=$arSection["UF_SECTION_DESCR"]?></div>
							</div>
						<?endif;?>
					<?endif;?>
					<?
					$html = ob_get_clean();
					$APPLICATION->AddViewContent('top_desc', $html);
					$APPLICATION->ShowViewContent('sotbit_seometa_top_desc');
					$APPLICATION->ShowViewContent('top_desc');
					?>
				<?endif;?>
			<?endif;?>


<?php /*
            <?php echo '1111111111111111111111111111111111111'; ?>

<?if($itemsCnt):?>
			<?if('Y' === $arParams['USE_FILTER']):?>
				<?
			    $matchesFilter = array();
			    if(isset($arParams["SEF_URL_TEMPLATES"]['smart_filter']) && strripos($arParams["SEF_URL_TEMPLATES"]['smart_filter'], "#SMART_FILTER_PATH#")) {
				$isSmartFilter = str_replace("#SMART_FILTER_PATH#", "(.*?)", $arParams["SEF_URL_TEMPLATES"]['smart_filter']);
				$isSmartFilter = preg_replace('/^#[a-zA-Z_]+#/i', "", $isSmartFilter);
				$isSmartFilter = str_replace("/", "\/", $isSmartFilter);
				preg_match("/".$isSmartFilter."/i", $APPLICATION->GetCurPage(), $matchesFilter);
			    }
				?>
				<div class="adaptive_filter">
					<a class="filter_opener<?=($_REQUEST['set_filter'] === 'y' ? ' active num' : '')?><?=(($_REQUEST['set_filter'] === 'y' || (count($matchesFilter)>1 && $matchesFilter[1] != 'clear')) ? ' active num' : '')?>"><i></i><span><?=GetMessage("CATALOG_SMART_FILTER_TITLE")?></span></a>
				</div>
			<?endif;?>

			<?if($isAjax=="N"){
				$frame = new \Bitrix\Main\Page\FrameHelper("viewtype-block");
				$frame->begin();?>
			<?}?>

			<?// sort?>
			<?=$sortHtml;?>

			<?if($isAjax === 'Y'){
				$APPLICATION->RestartBuffer();
			}?>

			<?$show = $arParams["PAGE_ELEMENT_COUNT"];?>

			<?if($isAjax === 'N'){?>
				<div class="ajax_load <?=$display;?>">
			<?}?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					$listElementsTemplate,
					Array(
						"USE_REGION" => ($arRegion ? "Y" : "N"),
						"STORES" => $arParams['STORES'],
						"SHOW_UNABLE_SKU_PROPS"=>$arParams["SHOW_UNABLE_SKU_PROPS"],
						"ALT_TITLE_GET" => $arParams["ALT_TITLE_GET"],
						"SEF_URL_TEMPLATES" => $arParams["SEF_URL_TEMPLATES"],
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
						"AJAX_REQUEST" => $isAjax,
						"ELEMENT_SORT_FIELD" => $sort,
						"ELEMENT_SORT_ORDER" => $sort_order,
						"SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
						"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
						"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
						"FILTER_NAME" => $arParams["FILTER_NAME"],
						"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
						"PAGE_ELEMENT_COUNT" => $show,
						"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
						"DISPLAY_TYPE" => $display,
						"TYPE_SKU" => ($typeSKU ? $typeSKU : $arTheme["TYPE_SKU"]["VALUE"]),
						"SET_SKU_TITLE" => ((($typeSKU == "TYPE_1" || $arTheme["TYPE_SKU"]["VALUE"] == "TYPE_1") && $arTheme["CHANGE_TITLE_ITEM"]["VALUE"] == "Y") ? "Y" : ""),
						"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
						"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
						"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
						"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
						'OFFER_SHOW_PREVIEW_PICTURE_PROPS' => $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS'],
						"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
						"AJAX_MODE" => $arParams["AJAX_MODE"],
						"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
						"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
						"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"CACHE_FILTER" => "Y",
						"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
						"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
						"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
						"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
						"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
						'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
						"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
						"SET_TITLE" => $arParams["SET_TITLE"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"SHOW_404" => $arParams["SHOW_404"],
						"MESSAGE_404" => $arParams["MESSAGE_404"],
						"FILE_404" => $arParams["FILE_404"],
						"PRICE_CODE" => $arParams['PRICE_CODE'],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
						"AJAX_OPTION_ADDITIONAL" => "",
						"ADD_CHAIN_ITEM" => "N",
						"SHOW_QUANTITY" => $arParams["SHOW_QUANTITY"],
						"SHOW_QUANTITY_COUNT" => $arParams["SHOW_QUANTITY_COUNT"],
						"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
						"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
						"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
						"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
						"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
						"CURRENCY_ID" => $arParams["CURRENCY_ID"],
						"USE_STORE" => $arParams["USE_STORE"],
						"MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
						"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
						"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
						"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
						"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
						"LIST_DISPLAY_POPUP_IMAGE" => $arParams["LIST_DISPLAY_POPUP_IMAGE"],
						"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
						"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
						"SHOW_HINTS" => $arParams["SHOW_HINTS"],
						"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
						"SHOW_SECTIONS_LIST_PREVIEW" => $arParams["SHOW_SECTIONS_LIST_PREVIEW"],
						"SECTIONS_LIST_PREVIEW_PROPERTY" => $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"],
						"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_LIST_PICTURES"],
						"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"SALE_STIKER" => $arParams["SALE_STIKER"],
						"STIKERS_PROP" => $arParams["STIKERS_PROP"],
						"SHOW_RATING" => $arParams["SHOW_RATING"],
						"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
						"IBINHERIT_TEMPLATES" => $arSeoItem ? $arIBInheritTemplates : array(),
					), $component, array("HIDE_ICONS" => $isAjax)
				);?>
			<?if($isAjax !== 'Y'){?>
				</div>
				<?$frame->end();?>
			<?}?>
<?endif;?>
			<?if($isAjax === 'N'){?>
				<?if(!$arSeoItem):?>
					<?if($arParams["SHOW_SECTION_DESC"] != 'N' && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
						<?ob_start();?>
						<?if($posSectionDescr === "BOTH"):?>
							<?if($arSection[$section_pos_bottom]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection[$section_pos_bottom]?></div>
								</div>
							<?endif;?>
						<?elseif($posSectionDescr === "BOTTOM"):?>
							<?if($arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]?></div>
								</div>
							<?elseif ($arSection["DESCRIPTION"]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection["DESCRIPTION"]?></div>
								</div>
							<?elseif($arSection["UF_SECTION_DESCR"]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection["UF_SECTION_DESCR"]?></div>
								</div>
							<?endif;?>
						<?endif;?>
						<?
						$html = ob_get_clean();
						$APPLICATION->AddViewContent('bottom_desc', $html);
						$APPLICATION->ShowViewContent('bottom_desc');
						$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');
						$APPLICATION->ShowViewContent('sotbit_seometa_add_desc');
						?>
					<?endif;?>
				<?else:?>
					<?ob_start();?>
					<?if($arSeoItem["DETAIL_TEXT"]):?>
						<?=$arSeoItem["DETAIL_TEXT"];?>
					<?endif;?>
					<?
					$html = ob_get_clean();
					$APPLICATION->AddViewContent('bottom_desc', $html);
					$APPLICATION->ShowViewContent('bottom_desc');
					$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');
					?>
				<?endif;?>
				<?if(!isset($arParams['LANDING_POSITION']) || $arParams['LANDING_POSITION'] === 'AFTER_PRODUCTS'):?>
					<div class="<?=($arParams["LANDING_TYPE_VIEW"] ? $arParams["LANDING_TYPE_VIEW"] : "landing_1" );?>" >
						<?@include_once(($arParams["LANDING_TYPE_VIEW"] ? $arParams["LANDING_TYPE_VIEW"] : "landing_1" ).'.php');?>
					</div>
				<?endif;?>

				<?if($itemsCnt):?>
					<div class="clear"></div>
					<?//</div> //.ajax_load?>
				<?endif;?>
			<?}?>

            <?php echo '2222222222222222222222222222222'; ?>
*/ ?>


<?
global $arSite, $arTheme;
$postfix = "";
$bBitrixAjax = (strpos($_SERVER["QUERY_STRING"], "bxajaxid") !== false);
if($arTheme["HIDE_SITE_NAME_TITLE"]["VALUE"] == "N" && ($bBitrixAjax || $isAjaxFilter))
{
	$postfix = " - ".$arSite["NAME"];
}
?>



<?if($itemsCnt):?>
			<?if($isAjax == 'Y'){
				die();
			}?>
		</div>
	</div>
	<?if($bBitrixAjax)
	{
		$page_title = $arValues['SECTION_META_TITLE'] ? $arValues['SECTION_META_TITLE'] : $arSection["NAME"];
		if($page_title){
			$APPLICATION->SetPageProperty("title", $page_title.$postfix);
		}
	}?>
<?else:?>
	<?if(!$section):?>
		<?\Bitrix\Iblock\Component\Tools::process404(
			trim($arParams["MESSAGE_404"]) ?: GetMessage("T_NEWS_NEWS_NA")
			,true
			,$arParams["SET_STATUS_404"] === "Y"
			,$arParams["SHOW_404"] === "Y"
			,$arParams["FILE_404"]
		);?>
	<?else:?>
        <?php /*
		<?if(!$iSectionsCount):?>
			<div class="no_goods">
				<div class="no_products">
					<div class="wrap_text_empty">
						<?if($_REQUEST["set_filter"]){?>
							<?$APPLICATION->IncludeFile(SITE_DIR."include/section_no_products_filter.php", Array(), Array("MODE" => "html",  "NAME" => GetMessage('EMPTY_CATALOG_DESCR')));?>
						<?}else{?>
							<?$APPLICATION->IncludeFile(SITE_DIR."include/section_no_products.php", Array(), Array("MODE" => "html",  "NAME" => GetMessage('EMPTY_CATALOG_DESCR')));?>
						<?}?>
					</div>
				</div>
			</div>
		<?endif;?>
       */ ?>


		<?
		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], IntVal($arSection["ID"]));
		$arValues = $ipropValues->getValues();
		if($arParams["SET_TITLE"] !== 'N'){
			$page_h1 = $arValues['SECTION_PAGE_TITLE'] ? $arValues['SECTION_PAGE_TITLE'] : $arSection["NAME"];
			if($page_h1){
				$APPLICATION->SetTitle($page_h1);
			}
			else{
				$APPLICATION->SetTitle($arSection["NAME"]);
			}
		}
		$page_title = $arValues['SECTION_META_TITLE'] ? $arValues['SECTION_META_TITLE'] : $arSection["NAME"];
		if($page_title){
			$APPLICATION->SetPageProperty("title", $page_title.$postfix);
		}
		if($arValues['SECTION_META_DESCRIPTION']){
			$APPLICATION->SetPageProperty("description", $arValues['SECTION_META_DESCRIPTION']);
		}
		if($arValues['SECTION_META_KEYWORDS']){
			$APPLICATION->SetPageProperty("keywords", $arValues['SECTION_META_KEYWORDS']);
		}
		?>
	<?endif;?>
<?endif;?>
<?
if($arSeoItem)
{
	$langing_seo_h1 = ($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != "" ? $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arSeoItem["NAME"]);

	$APPLICATION->SetTitle($langing_seo_h1);

	if($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"])
		$APPLICATION->SetPageProperty("title", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]);
	else
		$APPLICATION->SetPageProperty("title", $arSeoItem["NAME"].$postfix);

	if($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"])
		$APPLICATION->SetPageProperty("description", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]);

	if($arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS'])
		$APPLICATION->SetPageProperty("keywords", $arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS']);
	?>
<?}?>




<?if($isAjaxFilter):?>
	<?global $APPLICATION;?>
	<?$arAdditionalData['TITLE'] = htmlspecialcharsback($APPLICATION->GetTitle());
	if($arSeoItem)
	{
		$postfix = '';
	}
	$arAdditionalData['WINDOW_TITLE'] = htmlspecialcharsback($APPLICATION->GetTitle('title').$postfix);?>
	<script type="text/javascript">
		BX.removeCustomEvent("onAjaxSuccessFilter", function tt(e){});
		BX.addCustomEvent("onAjaxSuccessFilter", function tt(e){
			var arAjaxPageData = <?=CUtil::PhpToJSObject($arAdditionalData);?>;
			if (arAjaxPageData.TITLE)
				BX.ajax.UpdatePageTitle(arAjaxPageData.TITLE);
			if (arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE)
				BX.ajax.UpdateWindowTitle(arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE);
		});
	</script>
<?endif;?>

<?php
// Получаем параметр GET
$setArrFilter = false;

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$requestQueryList = $request->getQueryList();

$arrRequestQueryList = $requestQueryList->toArray();

//debug( $arrRequestQueryList );

$pattern = "(arrFilter_325_*)";

foreach($arrRequestQueryList as $key => $arrRequestQuery){
    preg_match($pattern, $key, $matches, PREG_OFFSET_CAPTURE);
    if($matches) $setArrFilter = true;
}


$paramTMarkaCode = strtolower( $requestQueryList->get('TMarka') );
$paramSetFilter = strtolower( $requestQueryList->get('set_filter'));

if( $paramSetFilter == 'y'  ){
//    $uriString = $request->getRequestUri();
//    debug( $uriString );
//    $uri = new Uri($uriString);
//
//    $uri->deleteParams(array("TMarka"));
//
//    $redirect = $uri->getUri();
//    //LocalRedirect($redirect);
//
//    debug($redirect);
}

?>
<?php
//TODO:Формируем разделы производителей loval/dev в админке с символьным кодом

$paramSectionID = $arResult['VARIABLES']['SECTION_ID'];

CModule::IncludeModule("iblock");

//Из массива разделов получаем символьный код производителя
function getSection( $paramSectionID ){
    $result = CIBlockSection::GetList(
            array("SORT" => "ASC"),
            array("IBLOCK_ID" => 30, "ID" => $paramSectionID ),
            false,
            ["ID", "NAME", "PICTURE", "DESCRIPTION", "DETAIL_PICTURE", "CODE", "UF_*"],
            false
    );
        while($rsSection = $result->GetNext()){
            $rsSection['FILE'] = CFile::GetFileArray($rsSection['PICTURE']);
            $arSection[] = $rsSection;

        }
        return $arSection[0];
}

$arSection = getSection($paramSectionID);


//Из свойства Производитель получаем массив значений
function getArrSection($arSection){
    $db_enum_list = CIBlockProperty::GetPropertyEnum(
        "CML2_MANUFACTURER",
        Array(),
        Array("IBLOCK_ID"=>28, "XML_ID"=>$arSection['CODE']));
    while($obj = $db_enum_list->Fetch() ){
        //$ar_enum_list = $obj->GetFields();
       return $obj;
    }

}
$arEnumValueSection = getArrSection($arSection);
//    debug( $arEnumValueSection  );


//Выборка элементов по свойству Производитель
function getElementsByManufactProper($arEnumValueSection){
    $arSelect = ["ID", "IBLOCK_ID", "NAME",   "PROPERTY_CML2_MANUFACTURER"  ];
    $arFilter = ["IBLOCK_ID" => 28,     "ACTIVE"=>"Y",   "PROPERTY_CML2_MANUFACTURER_VALUE" => $arEnumValueSection['VALUE'] ];
    //$arFilter = ["IBLOCK_ID" => 24,    "ACTIVE"=>"Y",       "PROPERTY_CML2_MANUFACTURER" => "41d4c351-0f5d-11ea-80c9-cb4ec39ec3cd" ];
    $result = CIBlockElement::GetList(
        [  "NAME" => "DESC"],
        $arFilter,
        false, //Группировка
        ["nPageSize" => 1000], //Постраничная навигация. по 2эл-та на страницу
        $arSelect
    );

    while($obj = $result->Fetch()){
        //$arItem = $obj->GetFields();
        //$arItem['PROPERTIES'] = $obj->GetProperties();
            $arElements[] = $obj['ID'];
    }
    if( empty($arElements) ){
        $arElements = ["11111" => 000000 ];
    }

    return $arElements;
}
$arElements = getElementsByManufactProper($arEnumValueSection);
    //debug($arElements);


//Формируем список торговых марок с символьным кодом из этих элементов
function getTMarks($arElements){
    $arSelect = ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_TORGOVAYA_MARKA"];
    $arFilter = ["IBLOCK_ID" => 28, "ACTIVE"=>"Y", "ID" => $arElements ];
    $result = CIBlockElement::GetList(
        ["NAME" => "ASC"],
        $arFilter,
        false, //Группировка
        ["nPageSize" => 10000], //Постраничная навигация. по 2эл-та на страницу
        $arSelect
    );

    $arProps = [];
    while($obj = $result->GetNextElement()){
        //$arItem = $obj->GetFields(); //Получаем из объекта поля
        $arProperty['PROPERTIES'] = $obj->GetProperties();
        if( $arProperty['PROPERTIES']['TORGOVAYA_MARKA']['VALUE']  )
            $arProps[$arProperty['PROPERTIES']['TORGOVAYA_MARKA']['VALUE_XML_ID']] = $arProperty['PROPERTIES']['TORGOVAYA_MARKA'];
    }

     return super_unique($arProps);
}
$uniqTMarka = getTMarks($arElements);
    //debug($uniqTMarka);


// Вычисляем в каких разделах находятся товары
function getGroupsByElements($arElements){
    $db_old_groups = CIBlockElement::GetElementGroups(
            $arElements,
            true
    );

    while($ar_group = $db_old_groups->Fetch()){
        //$arGroups[$ar_group['ID']] = $ar_group;
        $arGroups[] = $ar_group;
    }
    return $arGroups;
}
$arGroups = getGroupsByElements($arElements);
//debug($arGroups);




//Вычисляем кол-во элементов в этих разделах
function getGroupsCountElements($arGroups, $arElements){
    //TODO::Подсчитать кол-во элементов в активных разделах по фильтру производителя

    foreach($arGroups as $group){
            $active[$group['ID']][] = $group['IBLOCK_ELEMENT_ID'];
    }

    foreach($arGroups as $group){
        $group['COUNT'] = $active[$group['ID']];
        $new[] = $group;
    }

    foreach($new as $item){
        $modif[$item['ID']] = $item;
    }

    return $modif;
}

$groupsCountElements = getGroupsCountElements($arGroups, $arElements);
//debug($groupsCountElements);


$modifiedSearch = $arEnumValueSection['VALUE'];
function modifyBeforeSearch( $modifiedSearch ){
    //TODO: Обработать запрос перед поиском
    return $modifiedSearch;
}

$modifiedSeachQuery = modifyBeforeSearch( $modifiedSearch );

$valueTMarka = "";
if( !empty($paramTMarkaCode) ){

    function getArrTMarka($paramTMarkaCode){
        $db_enum_list = CIBlockProperty::GetPropertyEnum(
            "TORGOVAYA_MARKA",
            Array(),
            Array("IBLOCK_ID"=>28, "XML_ID"=>$paramTMarkaCode));
        if($ar_enum_list = $db_enum_list->GetNext())
            return $ar_enum_list;
    }

    $arrTMarka  = getArrTMarka($paramTMarkaCode);
    //debug($arrTMarka);

    function getElementsByTMarka($arrTMarka){

            $arSelect = ["ID", "IBLOCK_ID", "NAME", "PROPERTY_TORGOVAYA_MARKA"];
            $arFilter = ["IBLOCK_ID" => 28, "ACTIVE"=>"Y", "PROPERTY_TORGOVAYA_MARKA_VALUE" => $arrTMarka['VALUE'], ];
            $result = CIBlockElement::GetList(
                ["NAME" => "ASC"],
                $arFilter,
                false, //Группировка
                ["nPageSize" => 10000], //Постраничная навигация. по 2эл-та на страницу
                $arSelect
            );

            $arProps = [];
            while($obj = $result->GetNextElement()) {
                //debug($obj);
                $arMarka = $obj->GetFields();
                $arElements[] = $arMarka['ID'];
            }
            return $arElements;

    }

    $arElements = getElementsByTMarka($arrTMarka);
    $valueTMarka =  $arrTMarka['VALUE'];
    //debug($valueTMarka);

}

$GLOBALS['smartPreFilter'] = array(
    'ID' => $arElements,
    'PROPERTY_TORGOVAYA_MARKA_VALUE' => $valueTMarka
);

?>

<style>
    .uf-website-manufact{
        text-align: center;
        padding: 0 0 15px 0;
    }
    .tmarka{
        display: flex;
        vertical-align: middle;
        align-items: center;
        justify-content: center;
        height: 7rem;
        zoom: 1;
        border: 1px solid #f2f2f2;
        transition: box-shadow ease 0.2s, border ease-out 0.2s;
    }

    .tmarka:hover{
        box-shadow: 0px 0px 30px rgb(0 0 0 / 10%);
        border-color: #F2F2F2;
    }

    .section-find{
        border: 1px solid #f2f2f2;
        background: #f9f9f9;
        border-radius: 2px;
        margin: 0px 0px 30px;
    }

    .title-find{
        font-weight: bold;
        padding-right: 0px;
    }

    .block-title-find{
        padding: 13px 19px 14px;
        border-bottom: 1px solid #f2f2f2;
        font-size: 14px;
        display: block;

        color: #333;
    }

    .general-block-items-find{
        padding: 16px;
        background: #fff;

    }

    .uniq-block-items-ul{
        font-size: 14px;
    }

    .hidden-sections-manufact{
        display: none;
    }

    .hidden-tmarks{
        display: none;
    }

    #show-sections-manufact{
        margin-top: 10px;
        display: block;
    }

</style>

<?php

//debug( $requestQueryList );
?>
<div class="row">
    <div class="col-md-3">
        <a href="/manufacturers/?SECTION_ID=<?=$arSection['ID'];?>" class="thumbnail">
            <?php if( $arSection['FILE']['SRC'] ){ ?>
            <img src="<?=$arSection['FILE']['SRC'];?>" alt="...">
            <?php } else {  ?>
            <img src="/bitrix/templates/aspro_next/images/no_photo_medium.png" alt="...">
            <?php } ?>

        </a>
        <div class = "uf-website-manufact">
        <?php if(!empty($arSection['UF_WEBSITE'])): ?>
            <span> <b>Сайт:</b> </span> <a href = "<?=$arSection['UF_WEBSITE'];?>" target = "_blank"><?=$arSection['NAME'];?></a>
        <?php endif; ?>
        </div>
    </div>
    <div class="col-md-9">
        <?=$arSection['DESCRIPTION'];?>
    </div>
</div>

<div class="row">
    <div class="col-md-3 ">
        <div class = "section-find">
            <div class = "block-title-find">
                <span class = "title-find">Производитель найден в разделах: </span>
            </div>

            <div class = "row general-block-items-find">

                <ul class = "uniq-block-items-ul" >

                <?php
                $i =0;
                foreach($groupsCountElements as $key => $arGroup): ?>

                <li class = "uniq-block-items-li">
                            <a target = "_blank" href = "/catalogzoo/?section_id=<?=$arGroup['ID'];?>&q=<?=$modifiedSeachQuery;?>&s='Найти'">
                            <?=$arGroup['NAME'];?></span><span>(<?=count($arGroup['COUNT']);?>)
                            </a>
                </li>
                <?php if( $i == 10): ?>

                    <a href = "#" id = "show-sections-manufact"> <i class="fas fa-caret-down black"></i> <b> Остальные разделы </b> </a>
                    <div class = "hidden-sections-manufact" id = "hidden-sections">
                <?php endif; ?>

                <?php
                $i++;
                endforeach;
                ?>

                <?php if( $i == 10): ?>
                    </div>
                <?php endif; ?>

                </ul>

            </div>
        </div>

        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "inherit_sibagro",
            Array(
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "CONVERT_CURRENCY" => "N",
                "DISPLAY_ELEMENT_COUNT" => "Y",
                "FILTER_NAME" => "arrFilter",
                "FILTER_VIEW_MODE" => "vertical",
                "HIDE_NOT_AVAILABLE" => "N",
                "IBLOCK_ID" => "28",
                "IBLOCK_TYPE" => "catalog_1c",
                "PAGER_PARAMS_NAME" => "arrPager",
                "POPUP_POSITION" => "left",
                "PREFILTER_NAME" => "smartPreFilter",
                "PRICE_CODE" => array(),
                "SAVE_IN_SESSION" => "N",
                "SECTION_CODE" => "",
                "SECTION_DESCRIPTION" => "-",
                //"SECTION_ID" => $_REQUEST["SECTION_ID"],
                "SECTION_TITLE" => "-",
                "SEF_MODE" => "N",
                "TEMPLATE_THEME" => "blue",
                "XML_EXPORT" => "N"
            )
        );?>

    </div>
    <div class="col-md-9">
        <div class="row">

            <?php if($uniqTMarka):?>
            <div class="row">
                <div class="col-md-12 tmarka-row" id = "tmarka-row">
                    <?php $i = 0; ?>
                    <?php foreach($uniqTMarka as $marka): ?>
                        <?php //debug($marka); ?>
                        <div class="col-sm-6 col-md-3 tmarka item <?php echo ($i >= 15)? "hidden-tmarks" : "show-tmarks";  ?>">
                            <a href = "?SECTION_ID=<?=$paramSectionID;?>&TMarka=<?=$marka['VALUE_XML_ID'];?>"><?=$marka['VALUE'];?></a>
                        </div>

                        <?php if( $i == 15): ?>

                            <div class = "col-md-3 tmarka item show-tmarks" id = "show-tmarks">
                                <a href = "#" > <i class="fas fa-caret-down black"></i> <b> Показать все</b> </a>
                            </div>

                        <?php endif; ?>

                        <?php $i++; ?>
                        <?php endforeach; ?>

                </div>


            </div>
            <?php endif; ?>





            <div class="col-md-12">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    //"catalog_table",
                    "catalog_block_custom_manufacturers",
                    Array(
                        "ACTION_VARIABLE" => "action",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "ADD_TO_BASKET_ACTION" => "ADD",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "BACKGROUND_IMAGE" => "-",
                        "BASKET_URL" => "/personal/basket.php",
                        "BROWSER_TITLE" => "-",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPATIBLE_MODE" => "Y",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "CONVERT_CURRENCY" => "N",
                        "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                        "DETAIL_URL" => "",
                        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "DISPLAY_COMPARE" => "N",
                        "DISPLAY_TOP_PAGER" => "N",
                        "ELEMENT_SORT_FIELD" => "sort",
                        "ELEMENT_SORT_FIELD2" => "id",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "ELEMENT_SORT_ORDER2" => "desc",
                        "ENLARGE_PRODUCT" => "STRICT",
                        "FILTER_NAME" => "arrFilter",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                        "IBLOCK_ID" => "28",
                        "IBLOCK_TYPE" => "catalog_1c",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "LAZY_LOAD" => "N",
                        "LINE_ELEMENT_COUNT" => "4",
                        "LOAD_ON_SCROLL" => "N",
                        "MESSAGE_404" => "",
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                        "MESS_BTN_BUY" => "Купить",
                        "MESS_BTN_DETAIL" => "Подробнее",
                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                        "META_DESCRIPTION" => "-",
                        "META_KEYWORDS" => "-",
                        "OFFERS_LIMIT" => "4",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Товары",
                        "PAGE_ELEMENT_COUNT" => "20",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "PRICE_CODE" => array(
                            0 => "Оптовая",
                            1 => "BASE",

                        ),
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRODUCT_PROPERTIES" => array(),
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                        "PRODUCT_SUBSCRIPTION" => "Y",
                        "PROPERTY_CODE" => array("",""),
                        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                        "RCM_TYPE" => "personal",
                        "SECTION_CODE" => "",
                        //"SECTION_ID" => $_REQUEST["SECTION_ID"],
                        //"SECTION_ID" => 253,
                        // в компоненте ={$_REQUEST["SECTION_ID"]}

                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => array("",""),
                        "SEF_MODE" => "N",
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "Y",
                        "SHOW_404" => "N",
                        "SHOW_ALL_WO_SECTION" => "N",
                        "SHOW_CLOSE_POPUP" => "N",
                        "SHOW_DISCOUNT_PERCENT" => "N",
                        "SHOW_FROM_SECTION" => "N",
                        "SHOW_MAX_QUANTITY" => "N",
                        "SHOW_OLD_PRICE" => "N",
                        "SHOW_PRICE_COUNT" => "1",
                        "SHOW_SLIDER" => "Y",
                        "TEMPLATE_THEME" => "blue",
                        "USE_ENHANCED_ECOMMERCE" => "N",
                        "USE_MAIN_ELEMENT_SECTION" => "N",
                        "USE_PRICE_COUNT" => "Y",
                        "USE_PRODUCT_QUANTITY" => "N"
                    )
                );?>
            </div>
        </div>

    </div>
</div>



