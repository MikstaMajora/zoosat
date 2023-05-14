<?php
IncludeModuleLangFile(__FILE__);

Class ooopaykeeperprocessing_paykeeperpayment extends CModule
{
    var $MODULE_ID = "ooopaykeeperprocessing.paykeeperpayment";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;

    function ooopaykeeperprocessing_paykeeperpayment()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = GetMessage("PAYKEEPER_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("PAYKEEPER_MODULE_DESC");

        $this->PARTNER_NAME = "PayKeeper";
        $this->PARTNER_URI = "https://paykeeper.ru";
    }
    function InstallDB()
    {
        try {
            RegisterModule($this->MODULE_ID);
            return true;
        } catch (\Exception $e) {
            global $APPLICATION;
            $APPLICATION->ResetException();
            $APPLICATION->ThrowException(Loc::getMessage('DB_INSTALLATION_ERROR', [
                'ERROR' => $e->getMessage()
            ]));
            return false;
        }
    }
    function UnInstallDB()
    {
        UnRegisterModule($this->MODULE_ID);
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
    function InstallFiles()
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/ooopaykeeperprocessing.paykeeperpayment/install/bitrix",
                     $_SERVER["DOCUMENT_ROOT"]."/bitrix", true, true);
        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/bitrix/modules/sale/handlers/paysystem/paykeeper");
        DeleteDirFilesEx("/bitrix/modules/sale/payment/paykeeper");
        return true;
    }
    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
           if (!$this->InstallDB()) {
                return false;
            }
    
            if (!$this->InstallEvents()) {
                $this->UninstallDB();
                return false;
            }
    
            if (!$this->InstallFiles()) {
                $this->UninstallDB();
                $this->UninstallFiles();
                return false;
            }
    
            return true;
            /*
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
            $APPLICATION->IncludeAdminFile(GetMessage("PAYKEEPER_INSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/ooopaykeeperprocessing.paykeeperpayment/install/step.php");
            return true;
            */
        
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        $APPLICATION->IncludeAdminFile(GetMessage("PAYKEEPER_UNINSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/ooopaykeeperprocessing.paykeeperpayment/install/unstep.php");
        return true;
    }
}
?>
