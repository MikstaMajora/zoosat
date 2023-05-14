<?
IncludeModuleLangFile(__FILE__);
include_once $_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/arturgolubev.gmerchant/lib/installation.php';

Class arturgolubev_gmerchant extends CModule
{
	const MODULE_ID = 'arturgolubev.gmerchant';
	var $MODULE_ID = 'arturgolubev.gmerchant'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("arturgolubev.gmerchant_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("arturgolubev.gmerchant_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("arturgolubev.gmerchant_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("arturgolubev.gmerchant_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		return true;
	}

	function InstallEvents()
	{
		
		return true;
	}

	function UnInstallEvents()
	{
		
		return true;
	}

	function InstallFiles($arParams = array())
	{
		$mPath = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/";
		
		CopyDirFiles($mPath.$this->MODULE_ID."/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js",true,true);
		CopyDirFiles($mPath.$this->MODULE_ID."/install/tools", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools",true,true);
		CopyDirFiles($mPath.$this->MODULE_ID."/install/gadgets", $_SERVER["DOCUMENT_ROOT"]."/bitrix/gadgets",true,true);
		
		CopyDirFiles($mPath.$this->MODULE_ID."/install/catalog_export/googlemerchant_detail.php", $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/catalog_export/merchantgl_detail.php");
		CopyDirFiles($mPath.$this->MODULE_ID."/install/catalog_export/googlemerchant_run.php", $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/catalog_export/merchantgl_run.php");
		CopyDirFiles($mPath.$this->MODULE_ID."/install/catalog_export/googlemerchant_setup.php", $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/catalog_export/merchantgl_setup.php");
		CopyDirFiles($mPath.$this->MODULE_ID."/install/catalog_export/googlemerchant_util.php", $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/catalog_export/merchantgl_util.php");
		
		if(class_exists('agInstaHelperGmerchant')){
			agInstaHelperGmerchant::addGadgetToDesctop("WATCHER");
		}
		
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/js/".self::MODULE_ID);
		DeleteDirFilesEx("/bitrix/tools/".self::MODULE_ID);
		
		DeleteDirFilesEx("/bitrix/php_interface/include/catalog_export/merchantgl_detail.php");
		DeleteDirFilesEx("/bitrix/php_interface/include/catalog_export/merchantgl_run.php");
		DeleteDirFilesEx("/bitrix/php_interface/include/catalog_export/merchantgl_setup.php");
		DeleteDirFilesEx("/bitrix/php_interface/include/catalog_export/merchantgl_util.php");
		
		return true;
	}

	function DoInstall()
	{
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
		
		if(class_exists('agInstaHelperGmerchant')){
			agInstaHelperGmerchant::IncludeAdminFile(GetMessage("MOD_INST_OK"), "/bitrix/modules/".self::MODULE_ID."/install/success_install.php");
		}
	}

	function DoUninstall()
	{
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
