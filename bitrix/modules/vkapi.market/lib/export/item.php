<?php

namespace VKapi\Market\Export;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

class Item
{
    private $exportId = null;
    private $previewMode = false;
    private $arExportData = null;
    private $oConnection = null;
    public function __construct($uel9fed3juvyq3q89i = 0)
    {
        $this->exportId = intval($uel9fed3juvyq3q89i);
    }
    public function getId()
    {
        return (int) $this->exportId;
    }
    public function getMessage($sdjwaifwsce7nl01karv9zpd9mwvgm5sli1, $h9mxa9r990 = [])
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\x56\113\x41\x50\111\x2e\x4d\x41\x52\x4b\x45\x54\56\105\130\120\117\122\x54\56\111\124\x45\115\56" . $sdjwaifwsce7nl01karv9zpd9mwvgm5sli1, $h9mxa9r990);
    }
    public function load()
    {
        if (is_null($this->arExportData)) {
            $giz0sksk2gi592 = \VKapi\Market\ExportTable::getById($this->getId())->fetch();
            if (!$giz0sksk2gi592) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\122\117\122\137\105\x58\120\x4f\122\x54\x5f\116\117\124\x5f\x46\117\125\x4e\104"), "\x45\122\x52\x4f\x52\137\x45\130\x50\117\122\124\137\x4e\x4f\124\x5f\106\x4f\125\x4e\104");
            }
            $this->arExportData = $giz0sksk2gi592;
        }
    }
    
    public function getData()
    {
        return $this->arExportData;
    }
    
    public function setData($rtpzktggo7egq069lyzuavdzl8l2)
    {
        $this->arExportData = $rtpzktggo7egq069lyzuavdzl8l2;
    }
    
    public function connection()
    {
        if (is_null($this->oConnection)) {
            $this->oConnection = new \VKapi\Market\Connect();
            $uqgp4kghc8zzql5yo1m49c5wyf2j3mw = $this->oConnection->initAccountId($this->getAccountId());
            if (!$uqgp4kghc8zzql5yo1m49c5wyf2j3mw->isSuccess()) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\122\x4f\122\x5f\111\x4e\111\124\137\x43\x4f\x4e\x4e\x45\103\124\111\x4f\116", ["\x23\115\123\x47\43" => $uqgp4kghc8zzql5yo1m49c5wyf2j3mw->getFirstErrorMessage(), "\43\103\117\x44\105\43" => $uqgp4kghc8zzql5yo1m49c5wyf2j3mw->getFirstErrorCode()]), "\x45\122\x52\x4f\x52\137\111\x4e\111\x54\x5f\x43\117\x4e\116\x45\x43\124\111\117\x4e");
            }
        }
        return $this->oConnection;
    }
    
    public function checkApiAccess()
    {
        $uqgp4kghc8zzql5yo1m49c5wyf2j3mw = $this->connection()->method("\x6d\141\162\153\145\164\x2e\x67\x65\164", ["\157\167\x6e\145\x72\x5f\151\x64" => "\x2d" . $this->getGroupId(), "\x6f\x66\x66\163\145\x74" => 0, "\143\x6f\x75\156\x74" => 1]);
        if (!$uqgp4kghc8zzql5yo1m49c5wyf2j3mw->isSuccess()) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x45\x52\122\x4f\x52\x5f\x43\x48\105\103\x4b\x5f\103\x4f\116\x4e\105\x43\x54\x49\117\x4e\x5f\101\x43\x43\x45\x53\x53", ["\43\x4d\x53\x47\x23" => $uqgp4kghc8zzql5yo1m49c5wyf2j3mw->getFirstErrorMessage(), "\x23\x43\117\104\105\43" => $uqgp4kghc8zzql5yo1m49c5wyf2j3mw->getFirstErrorCode()]), "\105\122\122\117\x52\137\x43\x48\x45\103\x4b\137\103\x4f\116\x4e\x45\103\124\111\117\x4e\137\x41\x43\103\x45\x53\123");
        }
    }
    
    public function setPreviewMode($x0b3vpbftyuvsw6redz35xdaqug)
    {
        $this->previewMode = (bool) $x0b3vpbftyuvsw6redz35xdaqug;
    }
    
    public function isPreviewMode()
    {
        return $this->previewMode;
    }
    
    public function getGroupId()
    {
        return (int) $this->arExportData["\x47\122\117\125\x50\137\111\x44"];
    }
    
    public function getSiteId()
    {
        return $this->arExportData["\123\x49\124\105\x5f\x49\104"];
    }
    
    public function getAccountId()
    {
        return (int) $this->arExportData["\101\x43\x43\117\x55\x4e\x54\x5f\111\x44"];
    }
    
    public function getCategoryId()
    {
        return (int) $this->arExportData["\x50\x41\122\101\x4d\x53"]["\103\x41\x54\105\107\117\x52\x59\x5f\111\x44"];
    }
    
    public function getAlbumIds()
    {
        $gk4hs = array_slice((array) $this->arExportData["\x41\114\x42\125\x4d\x53"], 0, 2);
        if (\Bitrix\Main\Loader::includeSharewareModule("\166" . "\x6b\x61\160\x69\56\x6d\141\162\153\145\164") == constant("\x4d\117" . "\104\125\x4c" . "" . "\105\x5f" . "\x44" . "\x45\x4d\x4f")) {
            return $gk4hs;
        }
        return $this->arExportData["\101\x4c\102\125\115\x53"];
    }
    
    public function getDescriptionDeleteRules()
    {
        return (array) $this->arExportData["\x50\x41\x52\x41\x4d\123"]["\x44\x45\123\103\122\x49\120\124\x49\117\116\x5f\x44\x45\x4c\105\x54\105"];
    }
    
    public function getWatermark()
    {
        return (int) $this->arExportData["\x50\101\x52\x41\115\x53"]["\x57\x41\x54\105\122\115\x41\122\x4b"];
    }
    
    public function getWatermarkOpacity()
    {
        return max(0, min(100, (int) $this->arExportData["\120\101\x52\x41\115\x53"]["\127\x41\124\x45\122\x4d\101\122\x4b\x5f\x4f\x50\x41\x43\x49\x54\x59"]));
    }
    
    public function getWatermarkCoefficient()
    {
        return $this->arExportData["\120\x41\x52\101\x4d\x53"]["\127\101\124\x45\122\115\x41\x52\113\137\x43\x4f\x45\106\x46\111\103\111\105\116\x54"];
    }
    
    public function getWatermarkPosition()
    {
        return $this->arExportData["\120\101\x52\101\115\123"]["\x57\101\x54\105\x52\115\x41\x52\113\137\120\x4f\x53\111\124\x49\117\x4e"];
    }
    
    public function getPropertyIds()
    {
        if (isset($this->arExportData["\120\x41\x52\101\x4d\x53"]["\120\122\117\x50\x45\122\x54\x49\105\x53"])) {
            return $this->arExportData["\120\101\x52\x41\x4d\123"]["\x50\122\117\120\105\x52\x54\111\105\x53"];
        }
        return [];
    }
    
    public function getProductIdForPreview()
    {
        return (int) $this->arExportData["\x50\x41\x52\x41\115\123"]["\120\122\x45\x56\111\105\x57\137\x49\x4e\137\x56\113\x5f\x50\122\x4f\x44\x55\103\x54\x5f\111\104"];
    }
    
    public function getOfferIdForPreview()
    {
        return (int) $this->arExportData["\120\101\x52\x41\115\x53"]["\120\x52\x45\x56\111\x45\127\137\x49\116\137\126\113\137\117\x46\x46\105\x52\x5f\111\x44"];
    }
    
    public function getProductIblockId()
    {
        return (int) $this->arExportData["\120\101\x52\101\115\123"]["\x43\101\124\101\x4c\117\107\137\111\102\x4c\117\103\113\137\111\104"];
    }
    
    public function getOfferIblockId()
    {
        return (int) $this->arExportData["\120\x41\x52\101\115\x53"]["\x4f\106\106\105\122\137\111\x42\x4c\x4f\x43\113\x5f\111\x44"];
    }
    
    public function getLinkPropertyId()
    {
        return (int) $this->arExportData["\x50\x41\x52\101\115\123"]["\x4c\111\x4e\x4b\137\120\122\x4f\120\x45\122\124\x59\137\x49\x44"];
    }
    
    public function getCurrencyId()
    {
        return $this->arExportData["\120\x41\x52\x41\115\x53"]["\x43\x55\122\x52\105\116\x43\131\x5f\x49\104"] ?? "\x52\125\102";
    }
    
    public function getConditions()
    {
        return $this->arExportData["\120\x41\x52\101\115\123"]["\103\x4f\x4e\104\x49\124\111\x4f\116\x53"];
    }
    
    public function getProductName()
    {
        return $this->arExportData["\x50\101\122\101\115\123"]["\120\x52\117\104\125\103\x54\137\x4e\101\x4d\105"];
    }
    
    public function getProductPhoto()
    {
        return $this->arExportData["\120\x41\122\101\x4d\x53"]["\120\x52\x4f\104\125\103\x54\x5f\x50\x49\103\x54\125\122\105"];
    }
    
    public function getProductMorePhoto()
    {
        return $this->arExportData["\120\101\122\101\115\123"]["\x50\x52\x4f\104\x55\x43\x54\x5f\120\111\x43\124\125\122\x45\x5f\115\x4f\x52\105"];
    }
    
    public function getProductPrice()
    {
        return $this->arExportData["\120\101\x52\101\x4d\123"]["\x50\122\x4f\x44\x55\x43\x54\137\x50\x52\x49\103\105"];
    }
    
    public function getProductPriceOld()
    {
        return $this->arExportData["\120\101\122\x41\x4d\123"]["\x50\x52\x4f\x44\x55\103\x54\x5f\120\122\111\103\x45\137\117\114\x44"];
    }
    
    public function getProductWeight()
    {
        return $this->arExportData["\120\x41\122\101\x4d\123"]["\x50\x52\117\x44\125\103\124\137\x57\x45\111\107\x48\x54"];
    }
    
    public function getProductQuantity()
    {
        return $this->arExportData["\x50\x41\x52\x41\115\123"]["\120\x52\117\x44\x55\103\x54\x5f\x51\125\101\116\124\111\x54\131"];
    }
    
    public function getProductLength()
    {
        return $this->arExportData["\x50\101\122\101\x4d\123"]["\120\x52\117\104\x55\103\124\x5f\x4c\105\116\107\x54\110"];
    }
    
    public function getProductHeight()
    {
        return $this->arExportData["\120\101\122\101\x4d\123"]["\120\122\x4f\104\x55\103\124\137\x48\x45\x49\107\110\124"];
    }
    
    public function getProductWidth()
    {
        return $this->arExportData["\x50\101\122\101\x4d\x53"]["\120\122\x4f\x44\x55\x43\x54\x5f\x57\111\104\x54\110"];
    }
    
    public function getProductSku()
    {
        return $this->arExportData["\x50\x41\122\101\x4d\x53"]["\120\122\117\104\x55\x43\124\137\x53\x4b\125"];
    }
    
    public function getProductDefaultText()
    {
        return $this->arExportData["\120\x41\x52\x41\115\x53"]["\x50\x52\x4f\x44\125\103\x54\x5f\104\105\106\101\x55\114\124\x5f\124\105\x58\x54"];
    }
    
    public function getProductTemplate()
    {
        return $this->arExportData["\120\101\122\101\115\x53"]["\120\x52\117\104\125\103\x54\x5f\124\x45\115\x50\x4c\101\124\x45"];
    }
    
    public function getOfferName()
    {
        return $this->arExportData["\120\101\122\x41\x4d\x53"]["\117\x46\x46\x45\122\137\x4e\x41\x4d\x45"];
    }
    
    public function getOfferPhoto()
    {
        return $this->arExportData["\x50\x41\x52\101\x4d\123"]["\x4f\106\106\x45\122\x5f\120\x49\103\x54\125\x52\x45"];
    }
    
    public function getOfferMorePhoto()
    {
        return $this->arExportData["\x50\x41\x52\101\115\x53"]["\x4f\106\106\105\122\x5f\120\111\103\124\x55\122\x45\137\115\117\x52\105"];
    }
    
    public function getOfferPrice()
    {
        return $this->arExportData["\x50\101\122\x41\x4d\x53"]["\117\106\x46\105\122\137\x50\x52\x49\103\x45"];
    }
    
    public function getOfferPriceOld()
    {
        return $this->arExportData["\120\x41\x52\x41\115\123"]["\117\x46\x46\105\x52\x5f\x50\x52\111\x43\x45\x5f\117\x4c\104"];
    }
    
    public function getOfferWeight()
    {
        return $this->arExportData["\120\101\x52\101\115\x53"]["\117\x46\106\x45\x52\137\127\105\x49\107\x48\124"];
    }
    
    public function getOfferQuantity()
    {
        return $this->arExportData["\120\x41\122\101\115\123"]["\117\x46\x46\105\122\x5f\121\125\x41\x4e\x54\x49\x54\x59"];
    }
    
    public function getOfferLength()
    {
        return $this->arExportData["\120\101\122\x41\x4d\123"]["\117\106\x46\x45\122\x5f\114\105\116\x47\x54\x48"];
    }
    
    public function getOfferHeight()
    {
        return $this->arExportData["\x50\x41\122\x41\x4d\x53"]["\x4f\106\x46\x45\x52\x5f\x48\105\111\107\x48\124"];
    }
    
    public function getOfferWidth()
    {
        return $this->arExportData["\120\x41\122\x41\x4d\123"]["\117\106\x46\105\x52\x5f\x57\x49\104\124\110"];
    }
    
    public function getOfferSku()
    {
        return $this->arExportData["\120\101\x52\101\115\123"]["\x4f\x46\x46\x45\122\137\123\113\125"];
    }
    
    public function getOfferDefaultText()
    {
        return $this->arExportData["\120\101\x52\x41\115\x53"]["\x4f\106\x46\105\122\x5f\x44\105\x46\101\x55\x4c\x54\x5f\124\105\x58\124"];
    }
    
    public function getOfferTemplate()
    {
        return (string) $this->arExportData["\120\101\122\101\115\x53"]["\x4f\106\x46\x45\122\x5f\124\105\115\x50\114\101\124\x45"];
    }
    
    public function getOfferTemplateBefore()
    {
        return (string) $this->arExportData["\120\x41\122\x41\x4d\x53"]["\117\x46\x46\x45\122\137\x54\105\115\120\114\101\124\105\137\102\x45\106\117\122\105"];
    }
    
    public function getOfferTemplateAfter()
    {
        return (string) $this->arExportData["\x50\x41\x52\101\115\123"]["\x4f\x46\106\105\x52\x5f\124\105\115\120\114\x41\x54\105\x5f\x41\106\x54\105\x52"];
    }
    
    public function isDisabledOldItemDeleting()
    {
        return (bool) $this->arExportData["\x50\x41\x52\101\115\123"]["\x44\111\123\101\x42\114\105\x44\137\x4f\x4c\104\x5f\x49\124\x45\x4d\137\104\105\114\105\124\111\x4e\x47"];
    }
    
    public function isDisabledOldAlbumDeleting()
    {
        return (bool) $this->arExportData["\120\101\122\x41\x4d\x53"]["\x44\111\123\101\x42\114\105\104\x5f\117\x4c\104\137\101\114\102\x55\x4d\137\x44\x45\x4c\105\x54\x49\x4e\107"];
    }
    
    public function isEnabledImageToSquare()
    {
        return (bool) $this->arExportData["\120\101\122\101\x4d\x53"]["\111\115\x41\107\x45\x5f\x54\x4f\137\x53\x51\x55\x41\122\105"];
    }
    
    public function isEnabledExtendedGoods()
    {
        return (bool) $this->arExportData["\x50\x41\x52\101\x4d\x53"]["\x45\130\x54\105\x4e\104\105\104\137\107\x4f\x4f\104\123"];
    }
    
    public function isEnabledOfferCombine()
    {
        return (bool) $this->arExportData["\x50\101\122\101\115\123"]["\x4f\x46\x46\105\x52\x5f\103\117\x4d\x42\x49\116\x45"];
    }
    
    public function hasOffers()
    {
        return $this->getOfferIblockId() && $this->getLinkPropertyId();
    }
}
?>