<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>






<?php /*
<?global $arTheme, $isShowCatalogSections;?>
<?if($isShowCatalogSections):?>
	<?$APPLICATION->IncludeComponent(
	"aspro:catalog.section.list.next",
	"front_sections_theme",
	Array(
		"ADD_SECTIONS_CHAIN" => "N",
		"ALL_URL" => "catalogzoo/",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPACT_VIEW_MOBILE" => $arTheme["MOBILE_CATALOG_LIST_SECTIONS_COMPACT"]["VALUE"],
		"COUNT_ELEMENTS" => "N",
		"DISPLAY_PANEL" => "N",
		"FILTER_NAME" => "arrPopularSections",
		"HIDE_SECTION_NAME" => "N",
		"IBLOCK_ID" => "28",
		"IBLOCK_TYPE" => "1c_catalog",
		"SECTIONS_LIST_PREVIEW_DESCRIPTION" => "N",
		"SECTIONS_LIST_PREVIEW_PROPERTY" => "N",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array("",""),
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SHOW_PARENT_NAME" => "N",
		"SHOW_SECTIONS_LIST_PREVIEW" => "N",
		"SHOW_SECTION_LIST_PICTURES" => "Y",
		"TEMPLATE" => $arTheme["FRONT_PAGE_SECTIONS"]["VALUE"],
		"TITLE_BLOCK" => "Популярные категории",
		"TITLE_BLOCK_ALL" => "Весь каталог",
		"TOP_DEPTH" => "",
		"VIEW_MODE" => ""
	)
);?>


<?endif;?>

*/ ?>



	<div class="sections_wrapper compact-view-mobile">
		<div class="top_block">
			<h3 class="title_block">Популярные категории</h3>
			<a href="/catalogzoo/">Весь каталог</a>
		</div>
		<div class="list items">
			<div class="row margin0 flexbox">
				<div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
					<div class="item" >
						<div class="img shine">
							<a href="/catalogzoo/zootovary/kormlenie_i_gigiena_koshek_i_sobak/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/1Kormlen_gigiena.png"
                                     data-src="/images/main_categories/1Kormlen_gigiena.png" alt="Кормление и гигиена" title="Кормление и гигиена"></a>
						</div>
						<div class="name">
							<a href="/catalogzoo/zootovary/kormlenie_i_gigiena_koshek_i_sobak/" class="dark_link">Кормление и гигиена</a>
						</div>
					</div>
				</div>
                <div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
                    <div class="item" >
                        <div class="img shine">
                            <a href="/catalogzoo/korma_i_lakomstva_dlya_koshek/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/8korm_koshka.png"
                                     data-src="/images/main_categories/8korm_koshka.png" alt="Корма и лакомства для кошек" title="Корма и лакомства для кошек"></a>
                        </div>
                        <div class="name">
                            <a href="/catalogzoo/korma_i_lakomstva_dlya_koshek/" class="dark_link">Корма и лакомства для кошек</a>
                        </div>
                    </div>
                </div>
                <div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
                    <div class="item" >
                        <div class="img shine">
                            <a href="/catalogzoo/korma_i_lakomstva_dlya_sobak/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/9korm_sobaka.png"
                                     data-src="/images/main_categories/9korm_sobaka.png" alt="Корма и лакомства для собак" title="Корма и лакомства для собак"></a>
                        </div>
                        <div class="name">
                            <a href="/catalogzoo/korma_i_lakomstva_dlya_sobak/" class="dark_link">Корма и лакомства для собак</a>
                        </div>
                    </div>
                </div>
                <div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
                    <div class="item">
                        <div class="img shine">
                            <a href="/catalogzoo/preparaty_dlya_mdzh/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/7preparaty_mdg.png"
                                     data-src="/images/main_categories/7preparaty_mdg.png" alt="Препараты для МДЖ" title="Препараты для МДЖ"></a>
                        </div>
                        <div class="name">
                            <a href="/catalogzoo/preparaty_dlya_mdzh/" class="dark_link">Препараты для МДЖ</a>
                        </div>
                    </div>
                </div>
                <div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
                    <div class="item">
                        <div class="img shine">
                            <a href="/catalogzoo/preparaty_dlya_s_kh_zhivotnykh/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/10preparaty_givot.png"
                                     data-src="/images/main_categories/10preparaty_givot.png" alt="Препараты для сх животных" title="Препараты для с/х животных"></a>
                        </div>
                        <div class="name">
                            <a href="/catalogzoo/preparaty_dlya_s_kh_zhivotnykh/" class="dark_link">Препараты для с/х животных</a>
                        </div>
                    </div>
                </div>
                <div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
                    <div class="item">
                        <div class="img shine">
                            <a href="/catalogzoo/zootovary/odezhda_i_obuv_dlya_zhivotnykh/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/6Odegda.png"
                                     data-src="/images/main_categories/6Odegda.png" alt="Одежда" title="Одежда"></a>
                        </div>
                        <div class="name">
                            <a href="/catalogzoo/zootovary/odezhda_i_obuv_dlya_zhivotnykh/" class="dark_link">Одежда</a>
                        </div>
                    </div>
                </div>
				<div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
					<div class="item"  ">
						<div class="img shine">
							<a href="/catalogzoo/zootovary/amunitsiya/" class="thumb"><img data-lazyload="" class=" lazyloaded"
                             src="/images/main_categories/2Amunition.png"
                             data-src="/images/main_categories/2Amunition.png" alt="Амуниция" title="Амуниция"></a>
						</div>
						<div class="name">
							<a href="/catalogzoo/zootovary/amunitsiya/" class="dark_link">Амуниция</a>
						</div>
					</div>
				</div>
				<div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
					<div class="item"  ">
						<div class="img shine">
							<a href="/catalogzoo/zootovary/doma_lezhanki_kogtetochki/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/3DomaLeganki.png"
                                     data-src="/images/main_categories/3DomaLeganki.png" alt="Дома лежанки когтеточки" title="Дома лежанки когтеточки"></a>
						</div>
						<div class="name">
							<a href="/catalogzoo/zootovary/doma_lezhanki_kogtetochki/" class="dark_link">Дома лежанки когтеточки</a>
						</div>
					</div>
				</div>
				<div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
					<div class="item" >
						<div class="img shine">
							<a href="/catalogzoo/zootovary/igrushki/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/4Igrushki.png"
                                     data-src="/images/main_categories/4Igrushki.png" alt="Игрушки" title="Игрушки"></a>
						</div>
						<div class="name">
							<a href="/catalogzoo/zootovary/igrushki/" class="dark_link">Игрушки</a>
						</div>
					</div>
				</div>
				<div class="col-m-20 col-md-3 col-sm-4 col-xs-12">
					<div class="item" >
						<div class="img shine">
							<a href="/catalogzoo/zootovary/grumming_domashnikh_zhivotnykh/" class="thumb">
                                <img data-lazyload="" class=" lazyloaded" src="/images/main_categories/5Gruming.png" data-src="/images/main_categories/5Gruming.png"
                                     alt="Груминг домашних животных" title="Груминг домашних животных"></a>
						</div>
						<div class="name">
							<a href="/catalogzoo/zootovary/grumming_domashnikh_zhivotnykh/" class="dark_link">Груминг домашних животных</a>
						</div>
					</div>
				</div>



				<div class="visible-xs col-xs-12">
					<div class="item">
						<div class="name no-img">
							<a href="/catalogzoo/" class="dark_link">Весь каталог</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>