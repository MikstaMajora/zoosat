<?
if(IsModuleInstalled('ipol.sdek'))
{
	if (is_dir(dirname(__FILE__).'/install/js'))
		$updater->CopyFiles("install/js", "js/ipol.sdek/");

	$GLOBALS['DB']->Query("ALTER TABLE ipol_sdek ADD SDEK_UID VARCHAR(36)");

	if(\sdekHelper::isLogged()){
		\CAgent::AddAgent("\Ipolh\SDEK\AgentHandler::getSendedOrdersState();",'ipol.sdek',"N",1800);
	}
}
?>