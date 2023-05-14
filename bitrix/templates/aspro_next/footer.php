						<?CNext::checkRestartBuffer();?>
						<?IncludeTemplateLangFile(__FILE__);?>
							<?if(!$isIndex):?>
								<?if($isBlog):?>
									</div> <?// class=col-md-9 col-sm-9 col-xs-8 content-md?>
									<div class="col-md-3 col-sm-3 hidden-xs hidden-sm right-menu-md">
										<div class="sidearea">
											<?$APPLICATION->ShowViewContent('under_sidebar_content');?>
											<?CNext::get_banners_position('SIDE', 'Y');?>
											<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "sidebar", "AREA_FILE_RECURSIVE" => "Y"), false);?>
										</div>
									</div>
								</div><?endif;?>
								<?if($isHideLeftBlock && !$isWidePage):?>
									</div> <?// .maxwidth-theme?>
								<?endif;?>
								</div> <?// .container?>
							<?else:?>
								<?CNext::ShowPageType('indexblocks');?>
							<?endif;?>
							<?CNext::get_banners_position('CONTENT_BOTTOM');?>
						</div> <?// .middle?>
					<?//if(!$isHideLeftBlock && !$isBlog):?>
					<?if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
						</div> <?// .right_block?>				
						<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
							<div class="left_block">
								<?CNext::ShowPageType('left_block');?>
							</div>
						<?endif;?>
					<?endif;?>
				<?if($isIndex):?>
					</div>
				<?elseif(!$isWidePage):?>
					</div> <?// .wrapper_inner?>				
				<?endif;?>
			</div> <?// #content?>
			<?CNext::get_banners_position('FOOTER');?>
		</div><?// .wrapper?>
		<footer id="footer">
			<?if($APPLICATION->GetProperty("viewed_show") == "Y" || $is404):?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include", 
					"basket", 
					array(
						"COMPONENT_TEMPLATE" => "basket",
						"PATH" => SITE_DIR."include/footer/comp_viewed.php",
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"AREA_FILE_RECURSIVE" => "Y",
						"EDIT_TEMPLATE" => "standard.php",
						"PRICE_CODE" => array(
							0 => "BASE",
						),
						"STORES" => array(
							0 => "",
							1 => "",
						),
						"BIG_DATA_RCM_TYPE" => "bestsell"
					),
					false
				);?>					
			<?endif;?>
			<?CNext::ShowPageType('footer');?>
		</footer>
		<div class="bx_areas">
			<?CNext::ShowPageType('bottom_counter');?>
		</div>
		<?CNext::ShowPageType('search_title_component');?>
		<?CNext::setFooterTitle();
		CNext::showFooterBasket();?>


        <?php /*

        <style>
            .container-exit-site{
                border: 5px dashed #2585E5;
                padding: 15px;
                position: fixed;
                top: 160px;
                left: 800px;
                background-color: white;
                opacity: 1;
                z-index: 999999;
            }
            .form-exit-site{

            }

            .none{
                display: none;
            }
        </style>
        <div class="container-exit-site none" id="container-exit-site">

            <form class="form-exit-site">
                <div><h2>Почему Вы покидаете наш сайт?</h2></div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="">
                        Высокие цены
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="">
                        Не нашёл нужный товар
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="">
                        Не подходят условия доставки
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="">
                        Сложный процесс оформления заказа
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="">
                        Другое
                    </label>
                </div>

                <button class="btn btn-default">ОК</button>

            </form>


        </div>



        <?php
        global $USER;
        ?>

        <script>
        var loginUserID = "<?php  echo $USER->GetID();  ?>";

        if(loginUserID == 1){
            console.log(loginUserID);
            const containerExitSite = document.querySelector('#container-exit-site');

            containerExitSite.classList.remove('none');
        }
        </script>

 */ ?>

	</body>
</html>