<?
use \Arturgolubev\Smartsearch\Settings as SET;

$module_id = 'arturgolubev.smartsearch';
$module_name = str_replace('.', '_', $module_id);
$MODULE_NAME = strtoupper($module_name);

if(!CModule::IncludeModule($module_id)){CModule::AddAutoloadClasses($module_id, array('\Arturgolubev\Smartsearch\Settings' => 'lib/settings.php'));}
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/options.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/options.php");

global $USER, $APPLICATION;
if (!$USER->IsAdmin()) return;

// echo '<pre>'; print_r($MODULE_NAME); echo '</pre>';

$aMenu = array();

$aMenu[] = array(
	"TEXT"=>GetMessage($MODULE_NAME . "_SEARCH_OPTIONS_REINDEX"),
	"LINK"=>"search_reindex.php?lang=".LANGUAGE_ID,
	"TITLE"=>GetMessage($MODULE_NAME . "_SEARCH_OPTIONS_REINDEX"),
	"LINK_PARAM"=>" target='_blank'",
);

if(COption::GetOptionString("search", "stat_phrase") == "Y"){
	$aMenu[] = array(
		"TEXT"=>GetMessage($MODULE_NAME . "_STATISTIC_LINKS"),
		"TITLE"=>GetMessage($MODULE_NAME . "_STATISTIC_LINKS"),
		"LINK_PARAM"=>" target='_blank'",
		"MENU" => array(
			array(
				"TEXT"=>GetMessage($MODULE_NAME . "_STATISTIC_QUERY_LIST"),
				"LINK"=>"search_phrase_stat.php?lang=".LANGUAGE_ID,
				"TITLE"=>GetMessage($MODULE_NAME . "_STATISTIC_QUERY_LIST"),
				"LINK_PARAM"=>" target='_blank'",
			),
			array(
				"TEXT"=>GetMessage($MODULE_NAME . "_STATISTIC_PAGE_OPEN"),
				"LINK"=>"search_phrase_list.php?lang=".LANGUAGE_ID,
				"TITLE"=>GetMessage($MODULE_NAME . "_STATISTIC_PAGE_OPEN"),
				"LINK_PARAM"=>" target='_blank'",
			)
		),
	);
}

$aMenu[] = array(
	"TEXT"=>GetMessage($MODULE_NAME . "_FAST_HREFS"),
	"TITLE"=>GetMessage($MODULE_NAME . "_FAST_HREFS"),
	"LINK_PARAM"=>" target='_blank'",
	"MENU" => array(
		array(
			"TEXT"=>GetMessage($MODULE_NAME . "_BX_MODULE_SEARCH"),
			"LINK"=>"/bitrix/admin/settings.php?lang=".LANGUAGE_ID."&mid=search",
			"TITLE"=>GetMessage($MODULE_NAME . "_BX_MODULE_SEARCH"),
			"LINK_PARAM"=>" target='_blank'",
		),
		array(
			"TEXT"=>GetMessage($MODULE_NAME . "_BX_SEARCH_TABLE"),
			"LINK"=>"/bitrix/admin/perfmon_table.php?lang=".LANGUAGE_ID."&table_name=b_search_content",
			"TITLE"=>GetMessage($MODULE_NAME . "_BX_SEARCH_TABLE"),
			"LINK_PARAM"=>" target='_blank'",
		)
	),
);


$context = new CAdminContextMenu($aMenu);
$context->Show();

$themes = array(
	"blue" => GetMessage($MODULE_NAME . "_COLOR_THEME_BLUE"),
	"black" => GetMessage($MODULE_NAME . "_COLOR_THEME_BLACK"),
	"yellow" => GetMessage($MODULE_NAME . "_COLOR_THEME_YELLOW"),
	"green" => GetMessage($MODULE_NAME . "_COLOR_THEME_GREEN"),
	"red" => GetMessage($MODULE_NAME . "_COLOR_THEME_RED"),
);

$arOptions = array(
	"visual" => array(
		array("color_theme", GetMessage($MODULE_NAME . "_COLOR_THEME"), "blue", array("selectbox", $themes)),
		array("my_color_theme", GetMessage($MODULE_NAME . "_MY_COLOR_THEME"), "", array("colorbox")),
		array("clarify_section", GetMessage($MODULE_NAME . "_CLARIFY_SECTION"), "N", array("checkbox")),
		array("input_search_placeholder", GetMessage($MODULE_NAME . "_INPUT_SEARCH_PLACEHOLDER"), GetMessage($MODULE_NAME . "_INPUT_SEARCH_PLACEHOLDER_MOVED"), array("statictext")),
		array("show_section_picture", GetMessage($MODULE_NAME . "_SHOW_SECTION_PICTURE"), GetMessage($MODULE_NAME . "_SHOW_SECTION_PICTURE_MOVED"), array("statictext")),
		array("show_preloader", GetMessage($MODULE_NAME . "_SHOW_PRELOADER"), GetMessage($MODULE_NAME . "_SHOW_PRELOADER_MOVED"), array("statictext")),
	),
	"search" => array(),
	"terms" => array(),
    "main" => array(
		// GetMessage($MODULE_NAME . "_DEBUG_SETTING"),
        // array("title_max_count", GetMessage($MODULE_NAME . "_TITLE_MAX_COUNT"), "", array("text")),
        // array("search_max_count", GetMessage($MODULE_NAME . "_SEARCH_MAX_COUNT"), "", array("text")),
		array("disable_cache", GetMessage($MODULE_NAME . "_DISABLE_CACHE"), "N", array("checkbox")),
		array("debug", GetMessage($MODULE_NAME . "_DEBUG"), "N", array("checkbox")),
    )
);
$arOptions["visual"][] = array("note" => GetMessage($MODULE_NAME . "_VISUAL_EXTENDED_NOTE"));

$arMode = array(
	"extended" => GetMessage($MODULE_NAME . "_MODE_EXTENDED"),
	"standart" => GetMessage($MODULE_NAME . "_MODE_STANDART"),
);

$arOptions["search"][] = GetMessage($MODULE_NAME . "_SEARCH_ALGORITMS");
$arOptions["search"][] = array("mode_metaphone", GetMessage($MODULE_NAME . "_METAPHONE_MODE"), "", array("checkbox"));
$arOptions["search"][] = array("min_length", GetMessage($MODULE_NAME . "_MIN_LENGTH"), "4", array("text"));
$arOptions["search"][] = array("break_letters", GetMessage($MODULE_NAME . "_BREAK_LETTERS"), "", array("text"));
// $arOptions["search"][] = array("max_words_count", GetMessage($MODULE_NAME . "_MAX_WORDS_COUNT"), "", array("text"));
$arOptions["search"][] = array("mode_stitle", GetMessage($MODULE_NAME . "_STITLE_MODE"), "", array("selectbox", $arMode), "N", GetMessage($MODULE_NAME . "_SEARCH_MODE_DOP"));
$arOptions["search"][] = array("mode_spage", GetMessage($MODULE_NAME . "_SPAGE_MODE"), "", array("selectbox", $arMode), "N", GetMessage($MODULE_NAME . "_SEARCH_MODE_DOP"));
$arOptions["search"][] = array("mode_guessplus", GetMessage($MODULE_NAME . "_GUESSPLUS_MODE"), "", array("checkbox"));

// if(COption::GetOptionString("search", "use_stemming") == "Y"){
	// $arOptions["search"][] = array("mode_title_stemming", GetMessage($MODULE_NAME . "_TITLE_STEMMING"), "", array("checkbox"));
// }

$arOptions["search"][] = GetMessage($MODULE_NAME . "_DOP_SORTING");
$arOptions["search"][] = array("sort_secton_first", GetMessage($MODULE_NAME . "_SORT_SECTION_FIRST"), "", array("checkbox"));
if(CModule::IncludeModule("catalog")){
	$arOptions["search"][] = array("sort_available_first", GetMessage($MODULE_NAME . "_SORT_AVAILABLE_FIRST"), "", array("checkbox"));
	$arOptions["search"][] = array("sort_available_qt_first", GetMessage($MODULE_NAME . "_SORT_AVAILABLE_QT_FIRST"), "", array("checkbox"));
}

$arOptions["search"][] = GetMessage($MODULE_NAME . "_SEARCH_EXTENDED");
$arOptions["search"][] = array("use_title_tag_search", GetMessage($MODULE_NAME . "_USE_TITLE_TAG_SEARCH"), "Y", array("checkbox"));
$arOptions["search"][] = array("use_title_prop_search", GetMessage($MODULE_NAME . "_USE_TITLE_PROP_SEARCH"), "Y", array("checkbox"));
$arOptions["search"][] = array("use_title_id", GetMessage($MODULE_NAME . "_USE_TITLE_ID"), "N", array("checkbox"));
$arOptions["search"][] = array("use_title_sname", GetMessage($MODULE_NAME . "_USE_TITLE_SECTION_NAME"), "N", array("checkbox"));
$arOptions["search"][] = array("use_page_text_nosearch", GetMessage($MODULE_NAME . "_USE_PAGE_STOP_TEXT"), "Y", array("checkbox"));
$arOptions["search"][] = array("exception_words_list", GetMessage($MODULE_NAME . "_EXCEPTIONS_WORDS_LIST"), GetMessage($MODULE_NAME . "_EXCEPTIONS_WORDS_LIST_DEF"), array("textarea"));
$arOptions["search"][] = array("note" => GetMessage($MODULE_NAME . "_SEARCH_EXTENDED_NOTE"));


$show = (COption::GetOptionString($module_id, "use_with_standart") == 'Y' || COption::GetOptionString($module_id, "use_with_standart_title") == 'Y' || COption::GetOptionString($module_id, "use_with_standart_page") == 'Y');
if($show){
	$arOptions["search"][] = GetMessage($MODULE_NAME . "_SEARCH_DOP_SETTING");
	$arOptions["search"][] = array("use_with_standart", GetMessage($MODULE_NAME . "_USE_WITH_STANDART"), "N", array("checkbox"));
	$arOptions["search"][] = array("use_with_standart_title", GetMessage($MODULE_NAME . "_USE_WITH_STANDART_TITLE"), "N", array("checkbox"));
	$arOptions["search"][] = array("use_with_standart_page", GetMessage($MODULE_NAME . "_USE_WITH_STANDART_PAGE"), "N", array("checkbox"));
}


$file = new \Bitrix\Main\IO\File($_SERVER["DOCUMENT_ROOT"].CArturgolubevSmartsearch::RULES_FILE);
if(!$file->isExists()){
	$file->putContents('');
}

if(file_exists($_SERVER["DOCUMENT_ROOT"].CArturgolubevSmartsearch::RULES_FILE)){
	$arOptions["terms"][] = array("terms_file", GetMessage($MODULE_NAME . "_TERMS_FILE_TITLE"), GetMessage($MODULE_NAME . "_TERMS_FILE_VALUE"), array("statictext"), false, GetMessage($MODULE_NAME . "_TERMS_INFO_TITLE"));
}else{
	$arOptions["terms"][] = array("terms_file", GetMessage($MODULE_NAME . "_TERMS_FILE_TITLE"), GetMessage($MODULE_NAME . "_TERMS_NOFILE_VALUE"), array("statictext"));
}

$arOptions["help"][] = array("help_faq", GetMessage($MODULE_NAME . "_CARD_TEXT"), GetMessage($MODULE_NAME . "_CARD_TEXT_VALUE"), array("statictext"));
$arOptions["help"][] = array("help_faq", GetMessage($MODULE_NAME . "_INSTALL_TEXT"), GetMessage($MODULE_NAME . "_INSTALL_TEXT_VALUE"), array("statictext"));
$arOptions["help"][] = array("help_faq", GetMessage($MODULE_NAME . "_INSTRUCTION_TEXT"), GetMessage($MODULE_NAME . "_INSTRUCTION_TEXT_VALUE"), array("statictext"));
$arOptions["help"][] = array("help_faq", GetMessage($MODULE_NAME . "_INSTRUCTION_VIDEO"), GetMessage($MODULE_NAME . "_INSTRUCTION_VIDEO_VALUE"), array("statictext"));
$arOptions["help"][] = array("help_faq", GetMessage($MODULE_NAME . "_FAQ_TEXT"), GetMessage($MODULE_NAME . "_FAQ_TEXT_VALUE"), array("statictext"));
$arOptions["help"][] = array("help_faq", GetMessage($MODULE_NAME . "_FAQ_MAIN_TEXT"), GetMessage($MODULE_NAME . "_FAQ_MAIN_TEXT_VALUE"), array("statictext"));


$arTabs = array(
    array("DIV" => "visual_smartsearch_tab", "TAB" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_VISUAL_TAB_NAME"), "TITLE" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_VISUAL_TAB_TITLE"), "OPTIONS"=>"visual"),
    array("DIV" => "search_smartsearch_tab", "TAB" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_SEARCH_TAB_NAME"), "TITLE" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_SEARCH_TAB_TITLE"), "OPTIONS"=>"search"),
    array("DIV" => "terms_smartsearch_tab", "TAB" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_TERMS_TAB_NAME"), "TITLE" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_TERMS_TAB_TITLE"), "OPTIONS"=>"terms"),
    array("DIV" => "system_smartsearch_tab", "TAB" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_SYSTEM_TAB_NAME"), "TITLE" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_SYSTEM_TAB_TITLE"), "OPTIONS"=>"main"),
    array("DIV" => "help_smartsearch_tab", "TAB" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_HELP_TAB_NAME"), "TITLE" => GetMessage("ARTURGOLUBEV_SMARTSEARCH_HELP_TAB_TITLE"), "OPTIONS"=>"help"),
);
$tabControl = new CAdminTabControl("tabControl", $arTabs);

// ****** SaveBlock
if($REQUEST_METHOD=="POST" && strlen($Update.$Apply)>0 && check_bitrix_sessid())
{
	foreach ($arOptions as $aOptGroup) {
		foreach ($aOptGroup as $option) {
			__AdmSettingsSaveOption($module_id, $option);
		}
	}
	
    if (strlen($Update) > 0 && strlen($_REQUEST["back_url_settings"]) > 0)
        LocalRedirect($_REQUEST["back_url_settings"]);
    else
        LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . urlencode($mid) . "&lang=" . urlencode(LANGUAGE_ID) . "&back_url_settings=" . urlencode($_REQUEST["back_url_settings"]) . "&" . $tabControl->ActiveTabParam());
}


$arSearchNoteSettings = array();

if(intVal(COption::GetOptionString('search', "max_file_size")) < 1)
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_SIZE");

if(intVal(COption::GetOptionString('search', "max_result_size")) > 500)
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_CNT");

if(COption::GetOptionString('search', "use_tf_cache") != "Y")
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_FAST");

if(COption::GetOptionString('search', "full_text_engine") != "bitrix")
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_ENGINE");

if(COption::GetOptionString('search', "use_word_distance") == "Y")
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_USE_WORD_DISTANCE");

if(COption::GetOptionString('search', "use_social_rating") == "Y")
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_USE_SOCIAL_RATING");

if(COption::GetOptionString('search', "agent_stemming") == "Y")
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_AGENT_STEMMING");

if(strstr(COption::GetOptionString('search', "letters"), ' '))
	$arSearchNoteSettings[] = GetMessage($MODULE_NAME . "_ERROS_SETTING_LETTERS");

// echo '<pre>'; print_r($arSearchNoteSettings); echo '</pre>';
?>

<?
if(count($arSearchNoteSettings)>0)
{
	CAdminMessage::ShowMessage(array("DETAILS"=>GetMessage($MODULE_NAME . "_ERROS_SETTING_MESSAGE_START").implode('<br>', $arSearchNoteSettings), "1MESSAGE" => GetMessage($MODULE_NAME . "_ERROS_SETTING_TITLE"), "HTML"=>true));
}

if(!CModule::IncludeModule($module_id)){
	CAdminMessage::ShowMessage(array("DETAILS"=>GetMessage("ARTURGOLUBEV_SMARTSEARCH_DEMO_IS_EXPIRED"), "HTML"=>true));
}
?>

<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>">
	<?$tabControl->Begin();?>
	
	<?foreach($arTabs as $key=>$tab):
		$tabControl->BeginNextTab();
			SET::showSettingsList($module_id, $arOptions, $tab);
	endforeach;?>
	
	<?$tabControl->Buttons();?>
		<input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>">
		
		<input type="submit" name="Apply" value="<?=GetMessage("MAIN_OPT_APPLY")?>" title="<?=GetMessage("MAIN_OPT_APPLY_TITLE")?>">
		
		<?if(strlen($_REQUEST["back_url_settings"])>0):?>
			<input type="hidden" name="back_url_settings" value="<?=htmlspecialchars($_REQUEST["back_url_settings"])?>">
		<?endif?>
		
		<?=bitrix_sessid_post();?>
	<?$tabControl->End();?>
</form>

<?if($_GET["dev"]):?>
	<?if(CModule::IncludeModule("iblock")):?>
		<?
		$arIblockInIndex = array();
		$arTableCheck = array();
		
		$res = CIBlock::GetList(
			Array(), 
			Array(
				'ACTIVE'=>'Y', "CHECK_PERMISSIONS" => "N"
			), true
		);
		while($ar_res = $res->Fetch()){
			if($ar_res["INDEX_ELEMENT"] == 'Y' || $ar_res["INDEX_SECTION"] == 'Y'){
				$arIblockInIndex[] = $ar_res;
			}
		}
		
		$connection = Bitrix\Main\Application::getConnection();
		$sqlHelper = $connection->getSqlHelper();
		$sql = 'SELECT `MODULE_ID`, COUNT(*) as `CNT` FROM b_search_content GROUP BY `MODULE_ID`;';
		$recordset = $connection->query($sql);
		while ($record = $recordset->fetch())
		{
			$arTableCheck[] = $record;
		}
		?>

		<?=BeginNote();?>
			<div style="color: #000; font-size: 14px;">
				<b><?=GetMessage($MODULE_NAME . "_IBLOCKS_IN_INDEX")?></b><br/>
				<?if(count($arIblockInIndex)):?>
					<ul>
					<?foreach($arIblockInIndex as $v):?>
						<li style="margin: 5px 0;"><?=$v["NAME"]?> [<?=$v["ELEMENT_CNT"]?>; <?=$v["INDEX_ELEMENT"]?> / <?=$v["INDEX_SECTION"]?>] <a href="/bitrix/admin/iblock_edit.php?type=<?=$v["IBLOCK_TYPE_ID"]?>&lang=<?=LANGUAGE_ID?>&ID=<?=$v["ID"]?>&admin=Y" target="_blank"><?=GetMessage($MODULE_NAME . "_IBLOCKS_IN_INDEX_SETTINGS")?></a> <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$v["ID"]?>&type=<?=$v["IBLOCK_TYPE_ID"]?>&lang=<?=LANGUAGE_ID?>&find_section_section=0" target="_blank"><?=GetMessage($MODULE_NAME . "_IBLOCKS_IN_INDEX_VIEW")?></a></li>
					<?endforeach;?>
					</ul>
				<?else:?>
					<?=GetMessage($MODULE_NAME . "_IBLOCKS_IN_INDEX_EMPTY")?>
				<?endif;?>
				
				<b><?=GetMessage($MODULE_NAME . "_TABLE_SCAN")?></b><br/>
				<?if(count($arTableCheck)):?>
					<ul>
					<?foreach($arTableCheck as $v):?>
						<li style="margin: 5px 0;"><?=$v["MODULE_ID"]?>: <?=$v["CNT"]?></li>
					<?endforeach;?>
					</ul>
				<?endif;?>
			</div>
		<?=EndNote();?>
	<?endif;?>
<?endif?>

<?SET::showInitUI();?>