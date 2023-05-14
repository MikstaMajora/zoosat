<?php

namespace VKapi\Market\Good;

use Bitrix\Main\Localization\Loc;
use VKapi\Market\Api;
use VKapi\Market\Exception\ApiResponseException;
use VKapi\Market\Exception\BaseException;
use VKapi\Market\Exception\GoodLimitException;
use VKapi\Market\Exception\TimeoutException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Export
{
    const PRODUCT_TYPE_SIMPLE = 1;
    
    const PRODUCT_TYPE_HAS_OFFERS = 2;
    
    const PROPERTY_TYPE_L = "\x4c";
    
    const PROPERTY_TYPE_S = "\x53";
    
    const PROPERTY_TYPE_N = "\116";
    
    const PROPERTY_TYPE_F = "\106";
    
    const PROPERTY_TYPE_G = "\x47";
    
    const PROPERTY_TYPE_E = "\x45";
    
    protected $oExportItem = null;
    
    private $oGoodExportTable = null;
    
    protected $oAlbumExport = null;
    
    protected $oAlbumItem = null;
    
    protected $oPhoto = null;
    
    protected $oLog = null;
    
    protected $oState = null;
    
    protected $oIblockElementOld = null;
    
    protected $arPrepiredPropValue = [];
    
    protected $arAlbumsInVk = null;
    
    public function __construct(\VKapi\Market\Export\Item $oe93d2dj51j6cx378tlsngku2ch3)
    {
        $this->oExportItem = $oe93d2dj51j6cx378tlsngku2ch3;
        if (!\VKapi\Market\Manager::getInstance()->isInstalledIblockModule()) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x4d\x4f\x44\x55\x4c\x45\137\x49\x42\114\x4f\103\113\137\111\x53\137\116\117\124\137\111\116\123\124\x41\114\114\x45\x44"), "\115\x4f\x44\125\114\105\x5f\x4e\x4f\124\x5f\x49\116\x53\x54\x41\114\x4c\x45\104");
        }
    }
    
    public function getMessage($t677hu00, $czl91rrbmpquk7j1m23i5oa0dvzanau7l = null)
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\x56\113\101\120\x49\x2e\x4d\x41\x52\113\105\124\x2e\x47\117\x4f\104\x2e\x45\130\x50\x4f\x52\124\56" . $t677hu00, $czl91rrbmpquk7j1m23i5oa0dvzanau7l);
    }
    
    public function goodExportTable()
    {
        if (is_null($this->oGoodExportTable)) {
            $this->oGoodExportTable = new \VKapi\Market\Good\ExportTable();
        }
        return $this->oGoodExportTable;
    }
    
    public function goodReferenceExport()
    {
        return \VKapi\Market\Good\Reference\Export::getInstance();
    }
    public function goodReferenceExportTable()
    {
        return \VKapi\Market\Good\Reference\Export::getInstance();
    }
    
    public function goodReferenceAlbum()
    {
        return \VKapi\Market\Good\Reference\Album::getInstance();
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    public function log()
    {
        if (is_null($this->oLog)) {
            $this->oLog = new \VKapi\Market\Export\Log($this->manager()->getLogLevel());
            $this->oLog->setExportId($this->exportItem()->getId());
        }
        return $this->oLog;
    }
    
    public function state()
    {
        if (is_null($this->oState)) {
            $this->oState = new \VKapi\Market\State("\145\x78\x70\157\162\x74\x5f" . intval($this->exportItem()->getId()), "\57\147\157\157\x64");
        }
        return $this->oState;
    }
    
    public function limit()
    {
        if (is_null($this->oLimit)) {
            $this->oLimit = new \VKapi\Market\Export\Limit\Good($this->exportItem());
        }
        return $this->oLimit;
    }
    
    public function history()
    {
        if (is_null($this->oHistory)) {
            $this->oHistory = new \VKapi\Market\Export\History\Good($this->exportItem());
        }
        return $this->oHistory;
    }
    
    public function albumExport()
    {
        if (is_null($this->oAlbumExport)) {
            $this->oAlbumExport = new \VKapi\Market\Album\Export($this->exportItem());
        }
        return $this->oAlbumExport;
    }
    
    public function albumItem()
    {
        if (is_null($this->oAlbumItem)) {
            $this->oAlbumItem = new \VKapi\Market\Album\Item();
        }
        return $this->oAlbumItem;
    }
    
    public function photo()
    {
        if (is_null($this->oPhoto)) {
            $this->oPhoto = new \VKapi\Market\Export\Photo();
            $this->oPhoto->setExportItem($this->exportItem());
        }
        return $this->oPhoto;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function iblockElementOld()
    {
        if (is_null($this->oIblockElementOld)) {
            $this->oIblockElementOld = new \CIBlockElement();
        }
        return $this->oIblockElementOld;
    }
    
    public function getHash($f945acoojatz1afy55womgn0bjwxjya, $wrgjqsgha2bi99)
    {
        ksort($f945acoojatz1afy55womgn0bjwxjya);
        ksort($wrgjqsgha2bi99);
        return md5(serialize([$f945acoojatz1afy55womgn0bjwxjya, $wrgjqsgha2bi99]));
    }
    
    public function exportRun()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $eolxh = $this->state()->get();
        
        if (!empty($eolxh) && $eolxh["\x72\x75\x6e"] && $eolxh["\x74\x69\155\145\x53\164\x61\x72\x74"] > time() - 60 * 3) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\127\101\111\124\137\x46\111\116\111\123\110"), "\127\x41\x49\124\137\x46\111\116\111\x53\110");
        }
        
        if (empty($eolxh) || !isset($eolxh["\163\164\x65\160"]) || $eolxh["\x63\157\155\x70\x6c\x65\164\145"]) {
            $this->state()->set(["\x63\x6f\155\x70\x6c\145\164\x65" => false, "\160\145\162\x63\145\156\x74" => 0, "\x73\x74\145\160" => 1, "\x73\x74\x65\160\163" => [
                //все шаги, которые есть, в процессе работы, могут меняться сообщения, например обработано 2 из 10
                1 => ["\x6e\x61\x6d\x65" => $this->getMessage("\123\x54\105\x50\x31"), "\x70\x65\162\x63\x65\x6e\164" => 0, "\145\162\162\x6f\162" => false],
                2 => ["\x6e\141\x6d\145" => $this->getMessage("\123\x54\x45\x50\62"), "\160\x65\162\x63\145\x6e\164" => 0, "\x65\x72\162\157\162" => false],
                3 => ["\x6e\x61\x6d\145" => $this->getMessage("\123\x54\105\x50\x33"), "\x70\x65\162\x63\145\156\164" => 0, "\145\x72\x72\x6f\162" => false],
                4 => ["\x6e\141\155\x65" => $this->getMessage("\123\124\105\x50\64"), "\160\x65\162\143\145\x6e\x74" => 0, "\x65\162\x72\157\162" => false],
                5 => ["\x6e\x61\155\x65" => $this->getMessage("\123\x54\x45\120\x35"), "\160\x65\x72\143\145\x6e\164" => 0, "\x65\162\162\x6f\162" => false],
                6 => ["\x6e\x61\155\145" => $this->getMessage("\123\x54\105\x50\66"), "\x70\145\x72\143\145\156\164" => 0, "\145\162\162\x6f\162" => false],
                7 => ["\156\141\155\145" => $this->getMessage("\123\x54\x45\x50\x37"), "\160\145\162\x63\x65\x6e\164" => 0, "\x65\162\162\157\x72" => false],
                8 => ["\156\x61\155\x65" => $this->getMessage("\123\124\x45\120\70"), "\x70\x65\x72\x63\145\x6e\x74" => 0, "\145\x72\x72\x6f\x72" => false],
                9 => ["\156\141\155\x65" => $this->getMessage("\123\124\105\x50\x39"), "\160\x65\x72\x63\145\156\x74" => 0, "\145\162\162\157\162" => false],
            ]]);
            $eolxh = $this->state()->get();
            $this->log()->notice($this->getMessage("\x45\130\x50\117\122\x54\137\107\117\117\104\x53\56\123\124\x41\122\x54"));
        }
        
        $this->state()->set(["\x72\x75\156" => true, "\164\x69\x6d\145\x53\164\x61\x72\164" => time()])->save();
        try {
            if (\Bitrix\Main\Loader::includeSharewareModule("\166\153\x61\160\151\56\x6d\x61\162\153" . "\x65" . "" . "\x74") === constant("\115\x4f\x44\x55\x4c\105\x5f\104\105\115\x4f\137\105\x58\120" . "\x49" . "\x52" . "\x45" . "\104")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\x41\x50\x49\56\x4d\x41\122\113\x45\x54\x2e\104\105\x4d\x4f\137\105" . "\130\120\x49" . "\x52\105\x44"), "\x42\x58\x4d\x41\x4b\105\x52\x5f\x44\105\x4d\x4f\x5f\x45\x58" . "\x50\x49\122\x45" . "\x44");
            }
            switch ($eolxh["\x73\x74\x65\x70"]) {
                case 1:
                    $this->exportItem()->checkApiAccess();
                    $eolxh["\x73\x74\145\x70"]++;
                    $eolxh["\x73\x74\x65\x70\163"][1]["\x70\x65\162\143\x65\156\x74"] = 100;
                    $this->log()->notice($this->getMessage("\x45\130\120\117\122\x54\137\107\117\117\x44\x53\x2e\123\x54\x45\120\56\117\x4b", ["\x23\x53\x54\x45\120\x23" => 1, "\43\123\124\x45\120\137\116\101\115\105\x23" => $eolxh["\163\164\x65\160\x73"][1]["\156\x61\155\145"]]));
                    break;
                case 2:
                    
                    $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunPrepareList();
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x63\x6f\155\160\x6c\145\164\x65")) {
                        $eolxh["\163\164\145\x70"]++;
                        $eolxh["\x73\x74\x65\160\x73"][2]["\x70\145\x72\x63\x65\156\164"] = 100;
                        $eolxh["\163\x74\145\x70\163"][2]["\x6e\141\x6d\x65"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x6d\145\163\163\x61\147\145");
                        $this->log()->notice($this->getMessage("\105\x58\x50\x4f\x52\x54\137\x47\117\x4f\104\123\56\x53\124\105\x50\x2e\x4f\113", ["\43\123\x54\x45\x50\x23" => 2, "\x23\x53\x54\x45\120\x5f\116\101\x4d\105\x23" => $eolxh["\x73\x74\145\x70\x73"][2]["\x6e\x61\155\x65"]]));
                    } else {
                        $eolxh["\x73\164\x65\x70\163"][2]["\x6e\x61\x6d\145"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\x65\163\x73\141\x67\145");
                        $eolxh["\163\164\x65\x70\x73"][2]["\160\145\x72\x63\x65\x6e\164"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\160\145\x72\x63\145\156\x74");
                        $this->log()->notice($this->getMessage("\x45\x58\x50\117\122\124\x5f\x47\x4f\x4f\x44\x53\x2e\123\x54\105\120\56\120\x52\117\x43\105\x53\x53", ["\x23\x53\x54\x45\x50\43" => 2, "\43\123\x54\x45\120\x5f\116\x41\115\x45\x23" => $eolxh["\163\x74\x65\160\x73"][2]["\156\x61\155\x65"], "\43\120\105\122\103\x45\x4e\124\x23" => $eolxh["\x73\x74\x65\160\x73"][2]["\x70\x65\162\143\x65\156\x74"]]));
                    }
                    break;
                case 3:
                    
                    $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunCheckExistsInVk();
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x63\x6f\x6d\x70\x6c\x65\164\145")) {
                        $eolxh["\163\x74\145\x70"]++;
                        $eolxh["\x73\164\145\x70\163"][3]["\x70\145\162\143\145\156\x74"] = 100;
                        $eolxh["\163\164\x65\160\163"][3]["\156\141\x6d\x65"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\145\163\x73\x61\x67\x65");
                        $this->log()->notice($this->getMessage("\105\130\120\x4f\x52\x54\137\x47\117\117\x44\x53\x2e\123\124\x45\120\56\117\x4b", ["\x23\x53\x54\x45\120\x23" => 3, "\43\123\124\105\x50\137\x4e\101\x4d\105\43" => $eolxh["\x73\164\x65\x70\x73"][3]["\156\x61\155\145"]]));
                    } else {
                        $eolxh["\163\x74\x65\160\x73"][3]["\156\141\155\145"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\145\163\x73\x61\x67\145");
                        $eolxh["\163\x74\145\x70\163"][3]["\x70\145\162\143\145\156\164"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x70\x65\x72\x63\x65\x6e\164");
                        $this->log()->notice($this->getMessage("\105\x58\120\x4f\x52\x54\x5f\x47\x4f\x4f\104\123\56\123\124\x45\120\56\x50\x52\x4f\x43\x45\123\123", ["\x23\123\124\x45\x50\x23" => 3, "\43\x53\x54\x45\120\x5f\116\101\115\105\x23" => $eolxh["\x73\x74\145\160\x73"][3]["\x6e\x61\x6d\145"], "\x23\120\x45\122\x43\x45\116\124\43" => $eolxh["\163\x74\145\x70\x73"][3]["\160\x65\162\x63\x65\x6e\164"]]));
                    }
                    break;
                case 4:
                    
                    if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
                        
                        $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunUpdateInVkBaseMode();
                    } else {
                        $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunUpdateInVk();
                    }
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\143\157\155\x70\x6c\145\164\145")) {
                        $eolxh["\x73\164\x65\x70"]++;
                        $eolxh["\x73\164\x65\160\163"][4]["\160\145\x72\143\145\x6e\164"] = 100;
                        $eolxh["\163\164\x65\160\x73"][4]["\156\x61\155\x65"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\145\163\x73\x61\x67\145");
                        $this->log()->notice($this->getMessage("\105\x58\x50\x4f\122\x54\137\107\117\x4f\x44\x53\56\123\124\105\120\56\x4f\x4b", ["\43\x53\124\x45\x50\x23" => 4, "\x23\x53\124\105\120\137\x4e\x41\x4d\x45\43" => $eolxh["\x73\x74\x65\x70\163"][4]["\156\x61\x6d\x65"]]));
                    } else {
                        $eolxh["\163\164\x65\160\x73"][4]["\x6e\x61\x6d\145"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\145\163\x73\141\x67\145");
                        $eolxh["\163\164\145\x70\x73"][4]["\160\x65\x72\143\x65\156\x74"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x70\x65\x72\x63\x65\156\x74");
                        $this->log()->notice($this->getMessage("\x45\130\120\x4f\122\124\x5f\x47\x4f\x4f\x44\x53\x2e\x53\x54\x45\120\x2e\x50\x52\117\103\105\x53\x53", ["\x23\x53\124\x45\x50\43" => 4, "\x23\x53\124\x45\x50\137\116\101\x4d\x45\x23" => $eolxh["\x73\x74\x65\160\163"][4]["\x6e\141\155\145"], "\x23\120\105\x52\x43\x45\116\124\x23" => $eolxh["\x73\x74\x65\160\x73"][4]["\160\145\x72\x63\x65\x6e\164"]]));
                    }
                    break;
                case 5:
                    
                    if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
                        
                        $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunDeleteOldFromVKBaseMode();
                    } else {
                        $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunDeleteOldFromVK();
                    }
                    $eolxh["\x73\x74\145\160\163"][5]["\x6e\x61\x6d\x65"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x6d\145\x73\163\x61\147\145");
                    $eolxh["\163\164\145\160\163"][5]["\160\x65\162\143\x65\x6e\x74"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\160\145\162\143\x65\x6e\164");
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x63\157\x6d\160\x6c\145\x74\145")) {
                        $eolxh["\163\x74\x65\x70"]++;
                        $this->log()->notice($this->getMessage("\x45\130\120\117\x52\124\137\x47\117\x4f\x44\123\56\x53\124\x45\x50\56\x4f\113", ["\x23\x53\x54\x45\120\43" => 5, "\x23\123\124\x45\120\x5f\x4e\x41\115\x45\43" => $eolxh["\163\164\145\x70\163"][5]["\x6e\141\x6d\145"]]));
                    } else {
                        $this->log()->notice($this->getMessage("\x45\130\x50\117\x52\124\137\x47\117\x4f\x44\x53\56\123\124\x45\x50\56\x50\122\117\103\105\x53\123", ["\43\x53\124\x45\x50\x23" => 5, "\43\123\x54\105\120\x5f\x4e\101\115\105\43" => $eolxh["\163\164\145\x70\x73"][5]["\x6e\x61\x6d\x65"], "\x23\120\105\122\x43\105\x4e\x54\43" => $eolxh["\x73\164\x65\x70\x73"][5]["\x70\145\162\x63\145\156\x74"]]));
                    }
                    break;
                case 6:
                    
                    $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunDeleteLocalDoublesFormVK();
                    $eolxh["\163\164\x65\160\163"][6]["\156\x61\x6d\145"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x6d\145\x73\163\141\x67\145");
                    $eolxh["\x73\x74\145\x70\163"][6]["\x70\145\x72\x63\x65\156\x74"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\160\145\x72\x63\145\x6e\164");
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\143\x6f\155\160\154\145\164\x65")) {
                        $eolxh["\163\164\145\160"]++;
                        $this->log()->notice($this->getMessage("\105\130\x50\117\x52\124\x5f\x47\117\x4f\104\x53\x2e\x53\124\105\120\56\x4f\113", ["\43\123\124\105\x50\43" => 6, "\43\123\124\105\x50\x5f\116\x41\115\x45\x23" => $eolxh["\163\164\145\x70\163"][6]["\156\141\x6d\x65"]]));
                    } else {
                        $this->log()->notice($this->getMessage("\x45\130\120\117\122\124\137\107\x4f\117\104\x53\56\x53\124\105\120\x2e\x50\122\x4f\103\x45\x53\123", ["\x23\x53\124\105\x50\x23" => 6, "\43\x53\x54\x45\x50\x5f\x4e\101\115\105\43" => $eolxh["\x73\164\x65\x70\x73"][6]["\x6e\141\155\x65"], "\x23\120\x45\122\x43\105\x4e\124\x23" => $eolxh["\x73\x74\x65\160\x73"][6]["\160\145\x72\x63\145\156\164"]]));
                    }
                    break;
                case 7:
                    
                    if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
                        
                        $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunAddToVkBaseMode();
                    } else {
                        $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunAddToVk();
                    }
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\143\x6f\155\160\x6c\x65\x74\145")) {
                        $eolxh["\163\x74\145\160"]++;
                        $eolxh["\163\164\x65\160\x73"][7]["\x70\x65\x72\143\x65\156\x74"] = 100;
                        $eolxh["\163\x74\145\160\x73"][7]["\156\141\x6d\x65"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x6d\x65\x73\x73\141\147\145");
                        $this->log()->notice($this->getMessage("\105\x58\120\x4f\x52\124\x5f\x47\x4f\x4f\104\123\56\123\124\x45\x50\56\117\x4b", ["\43\x53\124\x45\120\43" => 7, "\x23\123\x54\105\x50\137\116\x41\x4d\x45\x23" => $eolxh["\x73\x74\x65\x70\163"][6]["\x6e\141\x6d\145"]]));
                    } else {
                        $eolxh["\x73\x74\145\x70\163"][7]["\156\x61\155\145"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\x65\163\x73\141\147\x65");
                        $eolxh["\x73\x74\145\160\163"][7]["\160\145\162\x63\x65\156\x74"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\160\x65\x72\x63\145\156\164");
                        $this->log()->notice($this->getMessage("\x45\x58\x50\117\122\124\x5f\107\117\x4f\104\123\56\123\124\105\120\56\120\122\x4f\x43\x45\x53\x53", ["\x23\x53\124\x45\x50\43" => 7, "\x23\x53\x54\105\120\x5f\116\x41\115\105\x23" => $eolxh["\163\x74\x65\160\x73"][7]["\156\141\x6d\x65"], "\x23\x50\x45\x52\x43\x45\x4e\124\43" => $eolxh["\163\164\x65\x70\163"][7]["\x70\145\x72\x63\x65\156\164"]]));
                    }
                    break;
                case 8:
                    
                    $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunDeleteUnknownInVK();
                    $eolxh["\163\x74\x65\x70\163"][8]["\156\x61\x6d\145"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x6d\x65\x73\163\x61\x67\145");
                    $eolxh["\163\164\145\x70\163"][8]["\160\145\x72\x63\x65\x6e\x74"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\160\x65\162\143\145\156\x74");
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x63\157\x6d\x70\154\x65\x74\x65")) {
                        $eolxh["\163\164\145\x70"]++;
                        $this->log()->notice($this->getMessage("\105\x58\x50\117\122\x54\137\107\x4f\x4f\104\123\x2e\123\x54\x45\x50\x2e\117\x4b", ["\43\123\x54\x45\120\43" => 8, "\x23\x53\x54\x45\x50\x5f\116\x41\x4d\105\x23" => $eolxh["\x73\x74\x65\x70\x73"][8]["\156\x61\155\145"]]));
                    } else {
                        $this->log()->notice($this->getMessage("\x45\130\120\117\122\x54\x5f\x47\117\117\104\x53\x2e\x53\x54\105\x50\x2e\x50\x52\117\x43\105\123\x53", ["\43\x53\x54\x45\x50\43" => 8, "\43\123\124\x45\120\137\116\x41\115\105\x23" => $eolxh["\163\164\x65\x70\x73"][8]["\156\x61\x6d\145"], "\x23\120\105\x52\103\x45\x4e\x54\43" => $eolxh["\x73\164\145\x70\x73"][8]["\160\x65\162\x63\145\x6e\164"]]));
                    }
                    break;
                case 9:
                    
                    $p95izz9hrn2e0mubcrw2si0abhbgb9otq = $this->exportRunGroupUngroupItem();
                    $eolxh["\x73\x74\145\x70\x73"][9]["\x6e\x61\155\x65"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\155\x65\163\x73\x61\x67\145");
                    $eolxh["\163\x74\145\160\163"][9]["\160\145\162\x63\145\156\164"] = $p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\x70\x65\162\x63\x65\156\x74");
                    
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq->getData("\143\x6f\155\x70\154\x65\x74\x65")) {
                        $eolxh["\x73\x74\x65\x70"]++;
                        $this->log()->notice($this->getMessage("\x45\130\x50\117\122\124\137\107\117\117\104\123\x2e\123\x54\105\x50\x2e\117\x4b", ["\x23\123\124\x45\120\x23" => 9, "\x23\123\x54\x45\120\137\116\x41\115\x45\x23" => $eolxh["\x73\164\x65\160\163"][9]["\x6e\141\155\x65"]]));
                    } else {
                        $this->log()->notice($this->getMessage("\x45\130\x50\x4f\122\124\x5f\107\x4f\117\x44\x53\56\x53\x54\105\120\x2e\120\122\117\x43\x45\x53\123", ["\43\x53\124\x45\x50\43" => 9, "\43\123\124\x45\120\x5f\116\101\115\105\x23" => $eolxh["\163\x74\x65\160\x73"][9]["\x6e\x61\x6d\x65"], "\43\x50\105\x52\103\x45\116\x54\43" => $eolxh["\x73\164\145\160\163"][9]["\x70\x65\162\x63\145\156\x74"]]));
                    }
                    break;
            }
        } catch (\VKapi\Market\Exception\BaseException $cmj8mgh2gmnbrt9hhcjrr) {
            $this->log()->error($cmj8mgh2gmnbrt9hhcjrr->getMessage(), $cmj8mgh2gmnbrt9hhcjrr->getCustomData());
        }
        
        $eolxh["\x70\x65\162\143\145\x6e\164"] = $this->state()->calcPercentByData($eolxh);
        if ($eolxh["\x70\145\162\x63\145\x6e\x74"] == 100) {
            $eolxh["\x63\157\155\x70\x6c\145\164\x65"] = true;
            $this->log()->notice($this->getMessage("\105\x58\x50\x4f\122\x54\x5f\x47\x4f\117\104\123\x2e\x53\124\117\120"));
        }
        
        $this->state()->set(["\x72\x75\x6e" => false, "\x73\x74\x65\160" => $eolxh["\163\x74\x65\x70"], "\163\164\145\160\163" => $eolxh["\x73\164\x65\160\x73"], "\x63\x6f\155\x70\154\x65\164\x65" => $eolxh["\143\x6f\155\160\x6c\x65\164\x65"], "\x70\145\162\x63\x65\x6e\164" => $eolxh["\x70\145\x72\143\145\156\x74"]]);
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray($this->state()->get());
        if ($xsv2da4i3y9tmqlf3p7l7pp2np->isSuccess()) {
            $this->state()->save();
        } else {
            $this->state()->clean();
        }
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunPrepareList()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\x65\170\x70\157\162\x74\122\165\x6e\x50\x72\x65\x70\x61\162\x65\114\151\x73\x74";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\x63\157\x6d\160\x6c\145\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\x63\157\x6d\160\x6c\x65\x74\145" => false,
                //процент выполнения
                "\160\145\162\x63\145\156\x74" => 0,
                "\x63\x6f\165\x6e\x74" => 0,
                "\157\x66\x66\x73\145\164" => 0,
                // лимит на итерацию
                "\154\x69\155\x69\x74" => 10,
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
            
            $this->goodReferenceExport()->getTable()->setMarkForAllByExportId($this->exportItem()->getId());
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        
        $b9uybyzcqvto9rd = $this->exportItem()->getAlbumIds();
        
        $wrgjqsgha2bi99 = $this->albumItem()->getItemsById($b9uybyzcqvto9rd);
        
        \VKapi\Market\Good\Reference\AlbumTable::deleteNotExistsYet($b9uybyzcqvto9rd, $this->exportItem()->getProductIblockId(), $this->exportItem()->getOfferIblockId());
        
        \VKapi\Market\Good\Reference\ExportTable::deleteNotExistsYet($this->exportItem()->getId(), $this->exportItem()->getProductIblockId(), $this->exportItem()->getOfferIblockId());
        if (\CModule::IncludeModuleEx("\166\153\141\x70\x69\56" . "\x6d\x61" . "\162" . "\x6b" . "" . "\x65" . "" . "" . "\164") == constant("\x4d\117\104\125\114\x45\137\x44\105\x4d\117\x5f\105\130\120\111\x52" . "\x45\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\x41\x50\x49\x2e\115\101\x52\x4b\x45\124\56\104\105\x4d\x4f\x5f\x45\130\x50\x49\122\x45\104"), "\x42\x58\x4d\101\113" . "\x45\122\137\x44\105\x4d\x4f\x5f\x45\x58\x50\111\122\x45\104");
        }
        
        $rqc2ek2fuwdp2qgr9nb8c = $this->exportRunPrepareListActionGetFilter();
        \Bitrix\Main\Application::getConnection()->startTracker();
        $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\x6e\164"] = \Bitrix\Iblock\ElementTable::getCount($rqc2ek2fuwdp2qgr9nb8c);
        $mi5b98b22d73gqj8l84eza59 = \Bitrix\Main\Application::getConnection()->getTracker()->getQueries();
        \Bitrix\Main\Application::getConnection()->stopTracker();
        try {
            
            while ($qgz907efrkxvvn7bff00yy4["\143\157\x75\156\x74"] > $qgz907efrkxvvn7bff00yy4["\157\146\146\x73\x65\164"]) {
                $this->manager()->checkTime();
                $vnhsq49hfv6hwhzph1c1z = \Bitrix\Iblock\ElementTable::getList(["\x6f\162\x64\x65\162" => ["\x49\x44" => "\x41\123\103"], "\146\x69\x6c\164\x65\162" => $rqc2ek2fuwdp2qgr9nb8c, "\163\x65\x6c\x65\143\164" => ["\x49\104"], "\154\x69\x6d\151\164" => $qgz907efrkxvvn7bff00yy4["\x6c\x69\155\151\164"], "\x6f\146\146\163\145\164" => $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\x73\145\164"]]);
                while ($snjbmya3o9k9qh73 = $vnhsq49hfv6hwhzph1c1z->fetch()) {
                    $this->manager()->checkTime();
                    if ($this->exportRunPrepareListActionCheckElement($snjbmya3o9k9qh73["\x49\104"], $wrgjqsgha2bi99)) {
                        $qgz907efrkxvvn7bff00yy4["\x6f\146\146\x73\x65\164"] += 1;
                    }
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        $qgz907efrkxvvn7bff00yy4["\160\x65\162\x63\145\156\x74"] = $this->state()->calcPercent($qgz907efrkxvvn7bff00yy4["\143\x6f\165\156\164"], $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\x73\x65\x74"]);
        if ($qgz907efrkxvvn7bff00yy4["\x70\x65\162\143\x65\156\x74"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\x70\x6c\x65\x74\x65"] = true;
            
            $this->goodReferenceExport()->getTable()->deleteAllMarkedByExportId($this->exportItem()->getId());
        }
        $o3sk53hoi6x8m6x = $this->goodReferenceExport()->getTable()->getList(["\163\x65\x6c\145\x63\164" => ["\x43\x4e\x54\137\x44\x49\123\x54\111\x4e\103\x54\x5f\x50\x52\x4f\x44\x55\103\x54\137\x49\104"], "\146\x69\154\164\145\162" => ["\105\x58\120\117\x52\x54\137\111\x44" => $this->exportItem()->getId()]])->fetch();
        $qgz907efrkxvvn7bff00yy4["\166\141\x6c\151\144\120\162\x6f\x64\165\143\164"] = $o3sk53hoi6x8m6x["\103\116\x54\137\104\111\123\x54\x49\x4e\x43\124\137\120\x52\117\104\x55\103\x54\137\x49\x44"] ?? 0;
        $qgz907efrkxvvn7bff00yy4["\166\141\x6c\x69\x64"] = $this->goodReferenceExport()->getTable()->getCount(["\x45\130\120\117\x52\124\x5f\x49\x44" => $this->exportItem()->getId()]);
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray([
            "\x63\x6f\165\156\x74" => $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\x73\145\x74"],
            // пройдено
            "\x61\154\x6c" => $qgz907efrkxvvn7bff00yy4["\143\x6f\165\156\164"],
            // всего
            "\x63\157\x6d\160\154\145\164\x65" => $qgz907efrkxvvn7bff00yy4["\143\157\155\160\x6c\x65\164\x65"],
            // флаг завершения цикла
            "\x70\x65\x72\x63\145\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\160\x65\x72\x63\x65\x6e\164"],
            //сообщение
            "\155\145\x73\x73\141\147\145" => $this->getMessage("\120\x52\x45\x50\101\x52\105\x5f\114\x49\123\x54", ["\43\103\117\x55\116\x54\43" => $qgz907efrkxvvn7bff00yy4["\157\x66\x66\x73\145\x74"], "\x23\x41\114\114\x23" => $qgz907efrkxvvn7bff00yy4["\x63\157\165\156\164"], "\43\126\x41\114\111\x44\43" => $qgz907efrkxvvn7bff00yy4["\166\141\x6c\151\x64"], "\x23\126\x41\x4c\111\104\137\120\122\x4f\x44\x55\103\124\43" => $qgz907efrkxvvn7bff00yy4["\x76\x61\154\151\144\x50\162\157\x64\x75\143\164"]]),
        ]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunPrepareListActionGetFilter()
    {
        $pwy8mbh8ep72yxm5yrsh8otfet4yl = \Bitrix\Main\ORM\Query\Query::filter();
        $pwy8mbh8ep72yxm5yrsh8otfet4yl->logic(\Bitrix\Main\ORM\Query\Filter\ConditionTree::LOGIC_AND);
        $pwy8mbh8ep72yxm5yrsh8otfet4yl->where("\111\x42\114\117\x43\113\x5f\x49\x44", "\x3d", $this->exportItem()->getProductIblockId());
        $pwy8mbh8ep72yxm5yrsh8otfet4yl->where(\Bitrix\Main\ORM\Query\Query::filter()->logic(\Bitrix\Main\ORM\Query\Filter\ConditionTree::LOGIC_OR)->whereNull("\127\x46\137\120\101\122\105\116\x54\137\105\x4c\x45\115\x45\116\x54\137\111\x44")->where("\x57\106\137\120\101\x52\105\x4e\x54\137\105\x4c\x45\115\x45\x4e\x54\x5f\x49\104", "\x3d", 0));
        $bldu5aerje1iemn32f7h37q7lzisfvs9c = new \VKapi\Market\Condition\Manager();
        $jjw6f = $this->exportItem()->getConditions();
        $sm37woycv7qcv0le3n16i5053k6x = $bldu5aerje1iemn32f7h37q7lzisfvs9c->parseBaseFilter($jjw6f, $this->exportItem()->getProductIblockId());
        $pwy8mbh8ep72yxm5yrsh8otfet4yl->where($sm37woycv7qcv0le3n16i5053k6x);
        [$qp5a963vfi3fjefhnco5ag] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_GET_FILTER_FOR_PREPARE_LIST, ["\146\x69\x6c\164\x65\x72" => $pwy8mbh8ep72yxm5yrsh8otfet4yl, "\x61\x72\105\x78\x70\x6f\x72\164\x44\141\x74\141" => $this->exportItem()->getData()], true);
        if (isset($qp5a963vfi3fjefhnco5ag) && $qp5a963vfi3fjefhnco5ag instanceof \Bitrix\Main\ORM\Query\Filter\ConditionTree) {
            return $qp5a963vfi3fjefhnco5ag;
        }
        return $pwy8mbh8ep72yxm5yrsh8otfet4yl;
    }
    
    public function exportRunPrepareListActionGetAllCount()
    {
        
        $jy7cb66b235j13lkvw2nlwdaj = \Bitrix\Iblock\ElementTable::getCount($this->exportRunPrepareListActionGetFilter());
        
        if ($this->exportItem()->hasOffers()) {
            $ls1msq = $this->iblockElementOld()->getList(["\x63\x6e\x74" => "\143\x6e\164"], ["\111\x42\x4c\117\103\113\137\x49\104" => $this->exportItem()->getOfferIblockId(), "\127\x46\x5f\x50\101\x52\x45\x4e\x54\137\105\x4c\x45\x4d\105\x4e\124\137\111\x44" => false, "\x50\122\x4f\120\x45\122\124\x59\x5f" . $this->exportItem()->getLinkPropertyId() . "\56\111\102\114\x4f\103\113\x5f\111\x44" => $this->exportItem()->getProductIblockId()], ["\111\x42\114\x4f\103\113\x5f\x49\104"])->fetch();
            $jy7cb66b235j13lkvw2nlwdaj += $ls1msq["\103\x4e\124"];
            
            $ko65td = $this->iblockElementOld()->getList(["\143\156\x74" => "\143\x6e\x74"], ["\111\x42\x4c\x4f\103\x4b\x5f\x49\x44" => $this->exportItem()->getProductIblockId(), "\127\106\137\120\x41\122\105\116\x54\137\105\114\105\x4d\x45\116\124\x5f\111\x44" => false, ["\111\x44" => $this->iblockElementOld()->SubQuery("\120\122\x4f\x50\105\122\124\x59\137" . $this->exportItem()->getLinkPropertyId(), ["\x49\x42\114\x4f\103\x4b\x5f\x49\x44" => $this->exportItem()->getOfferIblockId(), "\127\106\x5f\120\101\x52\x45\x4e\124\137\105\x4c\x45\x4d\x45\x4e\124\137\x49\x44" => false])]], ["\111\102\x4c\x4f\x43\x4b\137\x49\x44"])->fetch();
            $jy7cb66b235j13lkvw2nlwdaj -= $ko65td["\x43\116\124"];
        }
        return $jy7cb66b235j13lkvw2nlwdaj;
    }
    
    public function exportRunPrepareListActionCheckElement($frnr2p1y3qq, $wrgjqsgha2bi99)
    {
        $bldu5aerje1iemn32f7h37q7lzisfvs9c = new \VKapi\Market\Condition\Manager();
        
        $u18290glf = $bldu5aerje1iemn32f7h37q7lzisfvs9c->getPreparedElementFieldsById([$frnr2p1y3qq]);
        $snjbmya3o9k9qh73 = $u18290glf[$frnr2p1y3qq];
        
        $oovqciwja05wsukjreelanck = [];
        $dwilc36kvxbca01xyoasx59skp68zc = [];
        
        if (count($wrgjqsgha2bi99)) {
            $oovqciwja05wsukjreelanck[$frnr2p1y3qq][0] = [];
            
            foreach ($wrgjqsgha2bi99 as $k8ez17woodsz778yu32 => $qa7o2q72sza6xl6tt1q8erdjpyn5) {
                if ($bldu5aerje1iemn32f7h37q7lzisfvs9c->isMatchCondition($qa7o2q72sza6xl6tt1q8erdjpyn5["\120\101\x52\101\x4d\123"]["\103\117\x4e\x44\x49\x54\x49\117\x4e\123"], $snjbmya3o9k9qh73)) {
                    $oovqciwja05wsukjreelanck[$frnr2p1y3qq][0][$k8ez17woodsz778yu32] = $k8ez17woodsz778yu32;
                }
            }
        }
        
        $dwilc36kvxbca01xyoasx59skp68zc[$frnr2p1y3qq][0] = [];
        if ($bldu5aerje1iemn32f7h37q7lzisfvs9c->isMatchCondition($this->exportItem()->getConditions(), $snjbmya3o9k9qh73)) {
            $dwilc36kvxbca01xyoasx59skp68zc[$frnr2p1y3qq][0][$this->exportItem()->getId()] = $this->exportItem()->getId();
        }
        
        if ($this->exportItem()->hasOffers()) {
            $km9gq1y3a3uo8f1iq310js4x55z045jj = [];
            $we2xgm0wcb9cgds0yygjzajx4rd = \CIBlockElement::getList(["\111\x44" => "\101\x53\103"], ["\x49\x42\x4c\x4f\103\x4b\x5f\x49\104" => $this->exportItem()->getOfferIblockId(), "\x57\x46\x5f\x50\x41\122\105\x4e\x54\x5f\x45\114\x45\x4d\x45\x4e\124\x5f\x49\x44" => false, "\120\122\x4f\120\105\122\124\x59\x5f" . $this->exportItem()->getLinkPropertyId() => $frnr2p1y3qq], false, false, ["\111\104", "\120\x52\117\120\x45\122\124\131\x5f" . $this->exportItem()->getLinkPropertyId()]);
            while ($gw8f0m8qc91lg0o72791w1ryni42n = $we2xgm0wcb9cgds0yygjzajx4rd->fetch()) {
                $km9gq1y3a3uo8f1iq310js4x55z045jj[$gw8f0m8qc91lg0o72791w1ryni42n["\111\104"]] = [];
            }
            if (count($km9gq1y3a3uo8f1iq310js4x55z045jj)) {
                unset($oovqciwja05wsukjreelanck[$frnr2p1y3qq][0]);
                unset($dwilc36kvxbca01xyoasx59skp68zc[$frnr2p1y3qq][0]);
                
                $tkmlzv42n2waj4cog6i = $bldu5aerje1iemn32f7h37q7lzisfvs9c->getPreparedElementFieldsById(array_keys($km9gq1y3a3uo8f1iq310js4x55z045jj), true);
                foreach ($tkmlzv42n2waj4cog6i as $xip4druw2fxklyfu7h02opev => $vjirbgwzfqdmrbs84virrhci9mm5qk9c) {
                    $km9gq1y3a3uo8f1iq310js4x55z045jj[$xip4druw2fxklyfu7h02opev] = array_replace($snjbmya3o9k9qh73, $vjirbgwzfqdmrbs84virrhci9mm5qk9c);
                }
                
                foreach ($km9gq1y3a3uo8f1iq310js4x55z045jj as $xip4druw2fxklyfu7h02opev => $gw8f0m8qc91lg0o72791w1ryni42n) {
                    
                    if (count($wrgjqsgha2bi99)) {
                        $oovqciwja05wsukjreelanck[$frnr2p1y3qq][$xip4druw2fxklyfu7h02opev] = [];
                        foreach ($wrgjqsgha2bi99 as $k8ez17woodsz778yu32 => $qa7o2q72sza6xl6tt1q8erdjpyn5) {
                            if ($bldu5aerje1iemn32f7h37q7lzisfvs9c->isMatchCondition($qa7o2q72sza6xl6tt1q8erdjpyn5["\x50\101\122\101\115\x53"]["\103\x4f\x4e\x44\x49\124\111\x4f\116\123"], $gw8f0m8qc91lg0o72791w1ryni42n)) {
                                $oovqciwja05wsukjreelanck[$frnr2p1y3qq][$xip4druw2fxklyfu7h02opev][$k8ez17woodsz778yu32] = $k8ez17woodsz778yu32;
                            }
                        }
                    }
                    
                    $dwilc36kvxbca01xyoasx59skp68zc[$frnr2p1y3qq][$xip4druw2fxklyfu7h02opev] = [];
                    if ($bldu5aerje1iemn32f7h37q7lzisfvs9c->isMatchCondition($this->exportItem()->getConditions(), $gw8f0m8qc91lg0o72791w1ryni42n)) {
                        $dwilc36kvxbca01xyoasx59skp68zc[$frnr2p1y3qq][$xip4druw2fxklyfu7h02opev][$this->exportItem()->getId()] = $this->exportItem()->getId();
                    }
                }
            }
        }
        
        if (count($wrgjqsgha2bi99)) {
            $this->goodReferenceAlbum()->updateElementReferenceList($oovqciwja05wsukjreelanck, array_keys($wrgjqsgha2bi99));
        }
        
        $this->goodReferenceExport()->updateElementReferenceList($dwilc36kvxbca01xyoasx59skp68zc, [$this->exportItem()->getId()]);
        return true;
    }
    
    public function exportRunCheckExistsInVk()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\145\170\160\157\162\x74\122\165\x6e\103\150\145\x63\x6b\x45\170\x69\163\x74\x73\x49\156\x56\153";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\x63\x6f\x6d\160\x6c\x65\164\x65"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\x63\157\x6d\160\154\145\x74\145" => false,
                //процент выполнения
                "\160\x65\162\x63\x65\156\x74" => 0,
                // всего
                "\143\x6f\165\156\x74" => 0,
                // отступ
                "\157\146\146\x73\x65\x74" => 0,
                // лимит на итерацию
                "\x6c\151\155\x69\x74" => 250,
                //отсутствуют
                "\x6c\x6f\x73\x74\145\144" => 0,
                "\166\x6b\111\164\145\x6d\163" => [],
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        try {
            
            $qgz907efrkxvvn7bff00yy4["\x63\157\x75\156\164"] = $this->goodExportTable()->getCount(["\x47\122\x4f\x55\120\137\111\104" => $this->exportItem()->getGroupId()]);
            
            $gmuc6nrrdhndel7py4o1ykac9 = $this->getVkItemIdList($qgz907efrkxvvn7bff00yy4["\x76\153\111\x74\145\x6d\x73"]);
            $gmuc6nrrdhndel7py4o1ykac9 = array_combine($gmuc6nrrdhndel7py4o1ykac9, $gmuc6nrrdhndel7py4o1ykac9);
            if (\Bitrix\Main\Loader::includeSharewareModule("\166\x6b\x61\x70\151" . "\56\155\x61\x72\153\145" . "\x74") == constant("\115\x4f\x44\x55\x4c" . "\105\x5f\x44\105\x4d\117\137\x45\x58\x50\x49\122\x45\x44")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\x41\120\111\56\115\x41\122\x4b\105\x54\x2e\x44\105\115\x4f\137\105\x58" . "\120\x49\122\x45" . "\104"), "\102\130\115\x41\x4b\x45\x52\x5f\x44\x45\x4d\x4f\137\105\x58\120\111\122" . "" . "" . "" . "" . "\105" . "\x44");
            }
            while ($qgz907efrkxvvn7bff00yy4["\143\157\x75\x6e\164"] > $qgz907efrkxvvn7bff00yy4["\157\x66\146\x73\145\x74"]) {
                $this->manager()->checkTime();
                
                $i3jdo5ebyo1 = $this->goodExportTable()->getList(["\157\x72\x64\x65\x72" => ["\111\x44" => "\101\x53\103"], "\x66\x69\x6c\164\145\162" => ["\107\x52\x4f\125\120\x5f\111\104" => $this->exportItem()->getGroupId()], "\163\145\x6c\145\143\x74" => ["\x49\x44", "\x56\113\x5f\x49\x44", "\120\x52\x4f\104\125\103\124\137\x49\104", "\x4f\x46\106\x45\122\137\x49\104"], "\154\151\155\x69\164" => $qgz907efrkxvvn7bff00yy4["\154\151\155\151\x74"], "\157\146\x66\x73\x65\164" => $qgz907efrkxvvn7bff00yy4["\157\146\x66\x73\x65\164"]]);
                while ($m5fuff1swjsnadwe0c6vnotetlwfapxrr = $i3jdo5ebyo1->fetch()) {
                    $this->manager()->checkTime();
                    if (isset($gmuc6nrrdhndel7py4o1ykac9[$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\126\113\x5f\111\x44"]])) {
                        $qgz907efrkxvvn7bff00yy4["\x6f\146\146\x73\x65\164"]++;
                    } else {
                        $qgz907efrkxvvn7bff00yy4["\x63\x6f\x75\156\x74"]--;
                        $qgz907efrkxvvn7bff00yy4["\x6c\157\163\164\x65\x64"]++;
                        $this->goodExportTable()->delete($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\111\104"]);
                        
                        $this->photo()->getTable()->deleteByProduct($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\x52\x4f\104\x55\103\x54\x5f\x49\x44"], $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\117\x46\x46\x45\x52\x5f\111\104"], $this->exportItem()->getGroupId());
                        if ($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\117\106\x46\105\122\137\111\104"] > 0) {
                            $this->log()->notice($this->getMessage("\x43\x48\105\x43\x4b\137\x45\130\111\x53\124\x53\x5f\111\116\x5f\126\x4b\x5f\x44\105\x4c\x45\x54\105\x5f\x4f\x46\106\105\122", ["\x23\x50\122\117\104\125\103\124\137\x49\104\43" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\122\x4f\x44\x55\103\x54\x5f\x49\104"], "\x23\x4f\106\106\x45\x52\137\x49\104\43" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\117\x46\106\x45\122\137\x49\104"]]));
                        } else {
                            $this->log()->notice($this->getMessage("\103\x48\x45\x43\x4b\x5f\x45\x58\111\x53\124\123\x5f\111\116\x5f\126\x4b\137\x44\x45\x4c\x45\124\x45\137\120\122\x4f\x44\x55\103\124", ["\43\120\122\x4f\104\x55\x43\x54\x5f\111\104\x23" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\122\x4f\x44\x55\103\124\137\111\x44"]]));
                        }
                    }
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        $qgz907efrkxvvn7bff00yy4["\160\x65\162\x63\145\x6e\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\160\145\162\x63\x65\x6e\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\143\x6f\x6d\160\154\x65\x74\145"] = true;
            unset($qgz907efrkxvvn7bff00yy4["\x76\153\x49\x74\145\155\163"]);
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\157\x66\x66\163\x65\164" => $qgz907efrkxvvn7bff00yy4["\157\146\146\163\x65\164"] + $qgz907efrkxvvn7bff00yy4["\154\157\163\x74\145\144"], "\x63\x6f\165\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\x63\157\165\x6e\x74"] + $qgz907efrkxvvn7bff00yy4["\154\x6f\x73\164\145\144"], "\x63\x6f\155\x70\x6c\x65\164\x65" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x6d\x70\154\145\x74\x65"], "\160\145\162\x63\x65\156\164" => $qgz907efrkxvvn7bff00yy4["\160\145\162\143\x65\156\164"], "\155\145\163\x73\x61\x67\145" => $this->getMessage("\103\110\x45\x43\x4b\x5f\105\130\111\123\x54\123\137\x49\116\x5f\x56\x4b", ["\43\x4f\x46\x46\123\x45\124\x23" => $qgz907efrkxvvn7bff00yy4["\157\146\146\x73\145\x74"] + $qgz907efrkxvvn7bff00yy4["\154\157\163\x74\145\x64"], "\x23\103\117\125\x4e\124\x23" => $qgz907efrkxvvn7bff00yy4["\143\x6f\x75\x6e\x74"] + $qgz907efrkxvvn7bff00yy4["\x6c\157\163\164\x65\144"], "\43\114\x4f\x53\x54\105\x44\43" => $qgz907efrkxvvn7bff00yy4["\154\157\x73\x74\x65\144"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function getVkItemIdList(&$qgz907efrkxvvn7bff00yy4)
    {
        
        $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\155\141\x72\153\x65\x74\56\x67\x65\164", ["\x6f\167\156\x65\x72\137\151\x64" => "\55" . $this->exportItem()->getGroupId(), "\143\x6f\x75\x6e\x74" => 1, "\x65\x78\164\x65\x6e\x64\145\144" => 1, "\167\151\x74\x68\137\x64\151\x73\x61\x62\154\145\144" => 1]);
        $a7rypydp3yan8yj = $j5iunqjq99s53lvcg0x6buywgec0zf->getData("\x72\145\163\x70\x6f\x6e\163\145");
        $jy7cb66b235j13lkvw2nlwdaj = $a7rypydp3yan8yj["\x63\157\x75\156\x74"];
        if (empty($qgz907efrkxvvn7bff00yy4)) {
            $qgz907efrkxvvn7bff00yy4 = ["\x6c\151\155\151\x74" => 100, "\x6f\x66\146\163\145\x74" => 0, "\x72\145\160\x65\141\164" => 7, "\x69\x74\145\x6d\x73" => []];
        }
        if ($jy7cb66b235j13lkvw2nlwdaj) {
            while ($qgz907efrkxvvn7bff00yy4["\157\x66\x66\x73\145\x74"] < $jy7cb66b235j13lkvw2nlwdaj) {
                $this->manager()->checkTime();
                $j0zw202vtem5oi = "\xa\x20\40\40\x20\x20\40\40\40\40\x20\40\40\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\x76\x61\162\40\151\x74\x65\x6d\x73\x20\x3d\x20\x5b\135\x3b\xa\40\40\40\40\40\40\40\x20\x20\40\40\40\x20\40\x20\40\x20\x20\40\40\x20\40\40\40\x76\141\x72\x20\x6f\x77\156\x65\162\111\144\x20\x20\75\x20\x2d" . $this->exportItem()->getGroupId() . "\x3b\12\40\x20\40\x20\x20\40\x20\x20\40\x20\40\40\x20\x20\x20\x20\40\40\x20\40\40\40\40\x20\x76\x61\162\x20\x6c\x69\x6d\x69\164\40\x3d\40" . $qgz907efrkxvvn7bff00yy4["\x6c\151\x6d\151\x74"] . "\73\xa\40\40\x20\40\x20\40\40\40\40\40\x20\x20\40\40\40\x20\40\40\x20\x20\40\x20\40\x20\166\141\162\40\x6f\x66\146\163\145\164\x20\75\40" . $qgz907efrkxvvn7bff00yy4["\157\146\146\163\x65\164"] . "\x3b\xa\x20\40\x20\40\x20\x20\x20\x20\40\40\x20\40\40\40\40\x20\x20\x20\x20\x20\40\40\40\40\166\x61\x72\40\151\x20\x3d\x20" . $qgz907efrkxvvn7bff00yy4["\x72\145\160\145\x61\x74"] . "\x3b\12\40\40\x20\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\40\x20\166\x61\162\x20\x76\141\162\151\x61\156\x74\163\x20\x3d\40\x5b\135\73\12\40\40\40\x20\x20\40\x20\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\40\x20\40\x20\x20\x76\141\162\x20\166\141\x72\151\141\156\164\163\x49\164\145\x6d\40\x3d\40\146\141\154\163\x65\x3b\xa\x20\x20\40\x20\x20\40\40\40\40\x20\40\40\x20\x20\40\40\40\x20\x20\40\40\x20\40\x20\x76\141\162\x20\162\145\x73\x20\75\40\146\x61\154\163\145\x3b\xa\40\40\40\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\167\x68\151\x6c\145\x28\x69\x20\x3e\x20\60\x29\173\xa\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\40\x20\40\x20\x20\40\40\40\x20\40\x20\x20\40\x20\x72\x65\163\x20\75\x20\101\x50\x49\x2e\x6d\141\162\153\x65\x74\56\147\x65\x74\x28\x7b\x20\x22\x6f\x77\x6e\x65\162\x5f\151\x64\42\x3a\40\x6f\x77\x6e\145\162\111\x64\x2c\40\x22\x63\157\x75\156\x74\42\x20\x3a\40\154\151\x6d\151\164\x2c\40\x22\x6f\x66\x66\x73\x65\164\42\40\72\40\x6f\x66\x66\x73\145\x74\x2c\40\42\145\170\x74\x65\156\x64\145\x64\x22\40\72\x20\61\x2c\x22\156\x65\145\144\x5f\166\141\x72\151\141\156\x74\163\42\x20\72\40\x31\54\x20\x22\x77\x69\x74\x68\137\x64\x69\x73\141\142\154\145\x64\42\40\x3a\x20\x31\175\x29\73\12\40\40\40\40\40\40\x20\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\151\x20\x3d\40\151\x2d\61\x3b\12\x20\x20\40\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\157\146\x66\163\145\x74\40\x3d\x20\x6f\146\x66\163\145\164\40\53\40\154\151\155\151\164\73\12\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\40\40\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\x69\164\x65\x6d\163\40\x3d\x20\x69\164\145\155\x73\x20\x2b\x20\x20\x72\145\x73\56\x69\164\145\155\x73\x40\56\x69\144\73\xa\x20\x20\40\x20\40\40\x20\40\x20\x20\40\x20\40\40\x20\x20\40\x20\40\x20\x20\x20\40\40\40\x20\40\x20\xa\x20\40\x20\40\40\x20\x20\40\x20\40\x20\40\40\x20\40\40\40\40\40\40\x20\40\40\40\40\x20\40\x20\166\141\x72\x69\141\x6e\x74\x73\40\x3d\40\162\x65\163\x2e\x69\x74\145\155\163\x40\56\x76\x61\162\x69\x61\156\164\163\73\12\x20\40\40\40\40\40\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\x20\x69\x66\50\166\141\162\151\141\x6e\164\x73\x2e\154\145\156\x67\164\150\51\xa\40\x20\x20\40\40\40\40\40\x20\x20\40\40\40\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x7b\xa\x20\40\x20\40\x20\x20\40\40\40\40\x20\x20\x20\40\40\x20\40\40\40\40\x20\x20\40\40\x20\40\x20\40\40\40\x20\x20\x77\x68\x69\154\145\x28\166\141\x72\151\x61\156\164\x73\56\154\145\x6e\147\164\x68\x20\76\x20\x30\x29\xa\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\x20\x20\x20\x20\x20\40\40\40\x7b\xa\x20\40\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\x20\40\40\40\40\x20\x20\40\x20\40\x20\40\40\x20\40\x20\40\40\40\x20\x20\40\40\40\166\x61\162\x69\141\x6e\x74\163\111\x74\x65\155\x20\75\x20\166\141\x72\151\141\156\164\163\x2e\x70\157\x70\x28\51\73\12\40\40\x20\40\x20\40\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\40\x20\x20\40\40\x20\x20\x20\x20\40\40\40\40\x69\146\x28\166\x61\162\151\x61\156\x74\163\x49\164\x65\155\x29\xa\x20\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\40\40\40\40\40\40\40\x20\x20\40\40\40\x20\40\40\x20\173\12\40\40\x20\x20\x20\40\x20\40\40\x20\x20\40\40\40\x20\x20\40\40\40\x20\x20\40\40\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\x20\x20\x69\x74\145\x6d\163\x20\x3d\40\151\164\145\x6d\x73\40\53\40\166\141\162\x69\141\x6e\x74\x73\x49\x74\x65\155\x40\56\x69\164\145\155\x5f\x69\x64\73\xa\40\x20\x20\x20\x20\x20\x20\x20\40\40\40\40\40\40\40\x20\40\x20\40\40\x20\x20\x20\40\40\40\x20\40\40\x20\x20\x20\40\40\40\40\x7d\xa\x20\40\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\x20\40\40\x20\40\40\40\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x7d\xa\40\40\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\40\x20\40\40\40\x20\40\40\40\x20\40\x20\40\x20\40\175\12\x20\40\40\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\x20\40\x20\x20\40\x20\40\x20\40\x20\175\12\x20\40\40\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\x20\x20\40\x20\40\40\40\40\40\x72\x65\x74\x75\162\x6e\40\x69\164\x65\x6d\x73\73";
                $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\145\x78\x65\x63\x75\x74\145", ["\x63\157\x64\x65" => $j0zw202vtem5oi]);
                $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\x73\x65\164"] += $qgz907efrkxvvn7bff00yy4["\x6c\151\155\151\164"] * $qgz907efrkxvvn7bff00yy4["\162\x65\x70\x65\141\x74"];
                $a7rypydp3yan8yj = $j5iunqjq99s53lvcg0x6buywgec0zf->getData("\x72\145\163\160\157\x6e\x73\x65");
                $qgz907efrkxvvn7bff00yy4["\151\x74\145\155\163"] = array_merge($qgz907efrkxvvn7bff00yy4["\x69\164\145\x6d\x73"], $a7rypydp3yan8yj);
                $qgz907efrkxvvn7bff00yy4["\151\164\x65\155\x73"] = array_values(array_unique($qgz907efrkxvvn7bff00yy4["\151\x74\x65\155\x73"]));
            }
        }
        return $qgz907efrkxvvn7bff00yy4["\x69\x74\145\155\163"];
    }
    
    public function exportRunUpdateInVk()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\x65\x78\x70\157\x72\164\122\x75\156\125\x70\x64\141\x74\145\111\x6e\126\x6b";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\143\157\x6d\x70\x6c\x65\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\x63\157\x6d\160\x6c\x65\x74\x65" => false,
                //процент выполнения
                "\x70\x65\x72\143\x65\156\164" => 0,
                // всего
                "\143\157\165\x6e\x74" => 0,
                // отступ
                "\x6f\x66\x66\x73\x65\164" => 0,
                // лимит на итерацию
                "\x6c\151\x6d\x69\164" => $this->manager()->getExportPackLimit(),
                "\x75\x70\x64\x61\x74\145\144" => 0,
                "\163\x6b\x69\160\160\x65\x64" => 0,
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        $qgz907efrkxvvn7bff00yy4["\154\151\155\x69\164"] = $this->manager()->getExportPackLimit();
        try {
            if ($this->exportItem()->isEnabledExtendedGoods() || !$this->exportItem()->isEnabledOfferCombine()) {
                
                $this->goodExportTable()->deleteDoublesVkIdByGroupId($this->exportItem()->getGroupId());
            }
            
            $qgz907efrkxvvn7bff00yy4["\143\157\x75\156\164"] = $this->exportRunUpdateInVkActionGetCount();
            while ($qgz907efrkxvvn7bff00yy4["\157\146\146\x73\x65\x74"] < $qgz907efrkxvvn7bff00yy4["\143\x6f\x75\156\x74"]) {
                $this->manager()->checkTime();
                
                $i3jdo5ebyo1 = $this->goodReferenceExport()->getTable()->getList(["\157\x72\144\x65\x72" => ["\111\x44" => "\x41\x53\103"], "\163\x65\x6c\145\143\x74" => ["\x2a"], "\146\x69\x6c\164\145\x72" => ["\105\130\120\x4f\x52\x54\x5f\111\104" => $this->exportItem()->getId(), "\x21\75\x47\x4f\x4f\x44\137\x45\130\120\x4f\122\x54\56\x56\113\137\111\x44" => null], "\154\x69\155\151\164" => $qgz907efrkxvvn7bff00yy4["\x6c\x69\155\x69\164"], "\x6f\x66\x66\163\x65\x74" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\x73\x65\x74"], "\x72\x75\x6e\164\x69\155\x65" => [new \Bitrix\Main\Entity\ReferenceField("\x47\x4f\x4f\104\137\x45\x58\x50\117\122\124", "\134\x56\x4b\141\x70\151\134\115\x61\x72\x6b\145\164\x5c\107\x6f\x6f\144\134\x45\x78\160\x6f\x72\164\x54\x61\142\154\x65", ["\x3d\x74\x68\x69\163\x2e\x50\122\x4f\104\x55\103\x54\x5f\x49\104" => "\x72\x65\146\x2e\120\122\x4f\104\x55\103\x54\137\111\x44", "\x3d\164\x68\151\163\56\x4f\x46\x46\x45\122\x5f\111\104" => "\162\x65\x66\x2e\x4f\106\x46\105\x52\x5f\x49\104", "\x3d\162\145\x66\56\107\122\x4f\125\120\x5f\x49\x44" => new \Bitrix\Main\DB\SqlExpression("\77\151", $this->exportItem()->getGroupId())], ["\152\157\151\156\137\x74\171\160\x65" => "\114\x45\x46\124"])]]);
                while ($m5fuff1swjsnadwe0c6vnotetlwfapxrr = $i3jdo5ebyo1->fetch()) {
                    if ($this->exportRunUpdateInVkActionPrepareItem($m5fuff1swjsnadwe0c6vnotetlwfapxrr)) {
                        $qgz907efrkxvvn7bff00yy4["\x75\x70\144\141\x74\145\x64"]++;
                    } else {
                        $qgz907efrkxvvn7bff00yy4["\x73\x6b\151\160\x70\145\x64"]++;
                    }
                    $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\163\145\164"]++;
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        
        $this->photo()->deleteTemporaryDirectories();
        $qgz907efrkxvvn7bff00yy4["\x70\x65\162\143\145\x6e\164"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\145\x72\x63\x65\x6e\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\x70\x6c\145\164\145"] = true;
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        if (\CModule::IncludeModuleEx("\x76\153\x61\x70" . "\151\x2e\x6d\141\x72\153\145" . "" . "" . "\164") == constant("\115\117\x44\125\x4c\x45\x5f\104" . "" . "\x45\x4d\x4f" . "\x5f\x45\130\120\x49\122\105" . "\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126" . "\x4b\x41\x50\x49\56\115\101\122\113\105\x54\x2e\104\x45\115\x4f\x5f\x45\130\x50\x49\122" . "\x45" . "\104"), "\102\x58\x4d\x41\x4b\x45\122\137\104\x45\x4d\x4f\137\x45\130\120\x49\x52" . "\105\104");
        }
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\157\x66\x66\163\145\164" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\163\145\x74"], "\x63\x6f\165\156\164" => $qgz907efrkxvvn7bff00yy4["\143\x6f\x75\x6e\164"], "\143\x6f\155\x70\154\x65\x74\145" => $qgz907efrkxvvn7bff00yy4["\143\x6f\x6d\160\154\x65\x74\x65"], "\160\x65\162\143\x65\156\x74" => $qgz907efrkxvvn7bff00yy4["\x70\x65\162\143\x65\156\164"], "\x6d\x65\x73\x73\x61\x67\145" => $this->getMessage("\x45\x58\x50\x4f\x52\x54\137\122\125\x4e\137\125\120\x44\101\x54\105\x5f\111\x4e\x5f\126\113", ["\43\117\x46\106\x53\x45\x54\43" => $qgz907efrkxvvn7bff00yy4["\157\x66\x66\163\145\x74"], "\43\x43\117\125\x4e\x54\43" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x75\156\164"], "\43\125\120\104\x41\x54\105\x44\43" => $qgz907efrkxvvn7bff00yy4["\165\160\x64\141\x74\145\x64"], "\43\x53\113\x49\x50\x50\x45\104\43" => $qgz907efrkxvvn7bff00yy4["\163\x6b\x69\x70\160\x65\144"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunUpdateInVkActionGetCount()
    {
        $f7o20nwm9xr0sq = $this->goodReferenceExport()->getTable()->getList(["\x73\145\154\x65\143\x74" => ["\x43\x4f\x55\116\124" => "\103\x4e\124"], "\146\x69\154\164\x65\162" => ["\x45\130\x50\x4f\x52\124\x5f\x49\x44" => $this->exportItem()->getId(), "\41\x3d\107\x4f\x4f\104\x5f\x45\x58\120\117\x52\x54\56\x56\113\137\111\x44" => null], "\162\165\156\164\x69\x6d\x65" => [new \Bitrix\Main\Entity\ReferenceField("\107\x4f\117\104\137\x45\130\x50\117\x52\124", "\x5c\x56\x4b\141\x70\x69\x5c\x4d\141\x72\x6b\145\x74\134\x47\157\x6f\144\134\x45\x78\160\157\162\x74\124\x61\142\154\145", ["\75\x74\150\151\x73\56\120\122\x4f\104\125\103\x54\137\x49\x44" => "\x72\x65\146\56\120\122\x4f\x44\x55\x43\124\137\111\104", "\x3d\x74\x68\x69\x73\56\x4f\x46\106\x45\x52\x5f\x49\104" => "\x72\x65\x66\x2e\x4f\106\106\105\122\137\111\104", "\75\x72\145\x66\x2e\x47\122\x4f\x55\120\x5f\111\x44" => new \Bitrix\Main\DB\SqlExpression("\77\x69", $this->exportItem()->getGroupId())], ["\x6a\157\x69\x6e\x5f\164\x79\x70\145" => "\x4c\105\x46\x54"])]]);
        if ($dwnyyuqsgsg10a65hflvj40c5 = $f7o20nwm9xr0sq->fetch()) {
            return $dwnyyuqsgsg10a65hflvj40c5["\x43\x4f\x55\116\x54"];
        }
        return 0;
    }
    
    public function exportRunUpdateInVkActionPrepareItem($m5fuff1swjsnadwe0c6vnotetlwfapxrr)
    {
        
        $zn1t1hd2qixbm1rqzw0qp = $this->getPreparedItem($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\x52\x4f\x44\x55\103\124\x5f\x49\x44"], (array) $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\117\106\106\x45\x52\137\x49\x44"]);
        try {
            $f945acoojatz1afy55womgn0bjwxjya = $zn1t1hd2qixbm1rqzw0qp->getFields();
            $dmop7jw1 = $zn1t1hd2qixbm1rqzw0qp->getAlbumsVkIds();
            
            $x1ue6tvjc4lf0qlplh = $this->goodExportTable()->getList(["\146\x69\154\164\145\162" => ["\107\x52\117\125\x50\137\x49\x44" => $this->exportItem()->getGroupId(), "\x50\122\117\104\x55\x43\x54\x5f\x49\104" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\117\106\106\x45\122\x5f\x49\104" => $zn1t1hd2qixbm1rqzw0qp->getOfferIds()], "\154\x69\155\x69\164" => 1])->fetch();
            
            $hmvivep = $this->goodReferenceExport()->getTable()->getList(["\x6f\162\x64\x65\162" => ["\111\104" => "\x41\123\x43"], "\x73\145\x6c\145\x63\x74" => ["\111\104", "\120\122\117\x44\x55\103\124\137\111\104", "\x4f\x46\106\x45\122\x5f\x49\104", "\x46\114\x41\107"], "\146\x69\x6c\164\145\x72" => ["\105\x58\x50\117\x52\124\x5f\x49\x44" => $this->exportItem()->getId(), "\120\x52\x4f\104\x55\103\x54\137\x49\x44" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x4f\106\x46\x45\122\137\111\104" => $zn1t1hd2qixbm1rqzw0qp->getOfferIds()], "\x6c\x69\x6d\x69\164" => 1])->fetch();
            
            $this->history()->append($zn1t1hd2qixbm1rqzw0qp, $x1ue6tvjc4lf0qlplh["\126\113\x5f\111\x44"]);
            if ($f945acoojatz1afy55womgn0bjwxjya["\160\x72\x69\x63\145"] < 0.01) {
                $this->log()->error($this->getMessage("\105\130\x50\117\122\x54\137\122\125\116\137\x55\x50\104\x41\x54\105\x5f\111\116\137\x56\113\56\x50\122\111\103\105\x5f\x45\115\120\x54\131", ["\43\120\122\117\x44\x55\x43\x54\137\111\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\106\x46\x45\122\137\x49\104\x23" => implode("\x2c\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            if (!intval($f945acoojatz1afy55womgn0bjwxjya["\155\x61\151\x6e\x5f\x70\150\x6f\x74\x6f\137\x69\x64"])) {
                $this->log()->error($this->getMessage("\x45\130\x50\117\122\124\137\122\125\116\137\125\x50\104\x41\124\105\137\111\116\x5f\126\113\x2e\115\x41\x49\116\x5f\x50\110\x4f\124\117\x5f\x49\104\x5f\x45\x4d\120\x54\x59", ["\43\x50\122\x4f\x44\x55\103\124\x5f\111\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\117\106\x46\x45\x52\137\x49\x44\43" => implode("\54\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            if ($x1ue6tvjc4lf0qlplh["\x48\x41\123\110"] == $this->getHash($f945acoojatz1afy55womgn0bjwxjya, $dmop7jw1)) {
                $this->log()->notice($this->getMessage("\x45\130\x50\x4f\122\124\x5f\x52\x55\x4e\x5f\x55\120\x44\101\x54\105\137\x49\116\137\126\x4b\56\116\x4f\x54\x5f\103\110\101\x4e\x47\x45\x44", ["\43\120\x52\x4f\104\x55\x43\124\x5f\111\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\x46\x46\x45\122\137\x49\x44\x23" => implode("\54\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\155\141\162\153\145\x74\x2e\145\144\151\x74", array_merge($f945acoojatz1afy55womgn0bjwxjya, ["\151\x74\x65\x6d\137\x69\144" => $x1ue6tvjc4lf0qlplh["\x56\x4b\137\x49\x44"]]));
            $a7rypydp3yan8yj = $bgc2t2kjmh35of->getData("\162\x65\163\160\x6f\x6e\163\145");
            
            $cb766oj3f7aejy74obggj0h34zjp8ceslq7 = $this->goodExportTable()->update($x1ue6tvjc4lf0qlplh["\x49\104"], ["\x48\x41\123\x48" => $this->getHash($f945acoojatz1afy55womgn0bjwxjya, $dmop7jw1)]);
            $this->log()->ok($this->getMessage("\x45\x58\120\x4f\x52\x54\137\x52\x55\x4e\137\x55\x50\104\101\x54\x45\137\111\x4e\137\126\x4b\x2e\x55\120\x44\101\x54\105\x44", ["\x23\120\x52\x4f\104\125\x43\124\x5f\x49\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\x4f\x46\106\x45\122\137\x49\x44\x23" => implode("\54\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
            
            $this->deleteVkItemIdFromNotAlbums($x1ue6tvjc4lf0qlplh["\x56\x4b\137\x49\x44"], $dmop7jw1);
            $this->addVkItemIdToVkAlbums($x1ue6tvjc4lf0qlplh["\x56\x4b\137\111\104"], $dmop7jw1);
        } catch (\VKapi\Market\Exception\ApiResponseException $sfm8797cchactbca) {
            if ($sfm8797cchactbca->is(\VKapi\Market\Api::ERROR_100) && preg_match("\57\x5c\72\134\x73\x2b\x70\x68\157\164\x6f\134\x73\53\57", $sfm8797cchactbca->getMessage()) && isset($f945acoojatz1afy55womgn0bjwxjya)) {
                $tveavmh25iy6 = (array) $f945acoojatz1afy55womgn0bjwxjya["\x6d\x61\x69\x6e\137\160\x68\157\164\x6f\137\151\x64"];
                $tveavmh25iy6 = array_merge($tveavmh25iy6, explode("\x2c", $f945acoojatz1afy55womgn0bjwxjya["\160\150\157\164\157\137\x69\144\x73"]));
                $this->photo()->deleteByPhotoId($tveavmh25iy6, $this->exportItem()->getGroupId());
            }
            $this->log()->error($this->getMessage("\x45\x58\120\x4f\122\x54\x5f\x52\x55\116\137\x55\120\x44\x41\x54\105\137\111\x4e\137\126\x4b\56\105\122\122\x4f\x52", ["\43\120\x52\117\x44\x55\x43\124\137\111\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\x4f\x46\x46\x45\122\137\111\104\43" => implode("\54", $zn1t1hd2qixbm1rqzw0qp->getOfferIds()), "\43\115\x53\107\43" => $sfm8797cchactbca->getMessage()]));
            return false;
        }
        return true;
    }
    
    public function exportRunUpdateInVkBaseMode()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\145\170\x70\x6f\162\x74\122\x75\156\125\x70\144\x61\x74\145\x49\156\126\x6b\102\141\x73\145\115\157\x64\145";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\x63\x6f\155\160\x6c\145\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\143\x6f\155\160\154\x65\x74\145" => false,
                //процент выполнения
                "\160\x65\162\143\x65\x6e\164" => 0,
                // всего
                "\143\157\x75\156\164" => 0,
                // отступ
                "\157\x66\146\x73\145\x74" => 0,
                // лимит на итерацию
                "\x6c\x69\155\151\164" => 25,
                "\165\160\x64\141\164\145\x64" => 0,
                "\163\x6b\151\160\160\145\x64" => 0,
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        $eolxh["\154\x69\x6d\x69\164"] = $this->manager()->getExportPackLimit();
        try {
            
            $qgz907efrkxvvn7bff00yy4["\143\157\x75\156\x74"] = $this->exportRunUpdateInVkBaseModeActionGetCount();
            while ($frnr2p1y3qq = $this->exportRunUpdateInVkBaseModeActionGetNext($qgz907efrkxvvn7bff00yy4["\x6f\146\x66\x73\x65\x74"])) {
                $this->manager()->checkTime();
                if ($this->exportRunUpdateInVkBaseModeActionUpdate($frnr2p1y3qq)) {
                    $qgz907efrkxvvn7bff00yy4["\165\160\144\x61\x74\145\x64"]++;
                } else {
                    $qgz907efrkxvvn7bff00yy4["\163\153\x69\x70\x70\x65\144"]++;
                }
                $qgz907efrkxvvn7bff00yy4["\157\x66\146\x73\x65\x74"]++;
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        
        $this->photo()->deleteTemporaryDirectories();
        $qgz907efrkxvvn7bff00yy4["\160\145\162\143\145\x6e\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\x65\162\x63\x65\x6e\x74"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\143\157\155\x70\154\145\164\x65"] = true;
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        if (\Bitrix\Main\Loader::includeSharewareModule("\166\x6b" . "\141\x70\151" . "\x2e\155\x61" . "\162\153\x65" . "" . "" . "\164") === constant("\x4d\x4f\x44\x55\114\x45\137\x44\105\x4d\117\137\x45\x58" . "\120" . "" . "\111\122\105\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\x50\x49\x2e\115\101\x52\113\105\x54" . "" . "\x2e\x44\105\x4d\117\137" . "\x45\130\120\x49\x52\x45\104"), "\x42\x58\115\101\x4b\x45\x52\x5f\104\105" . "" . "\x4d" . "\x4f\x5f\105\x58\120\x49\122" . "" . "" . "" . "" . "\x45" . "" . "" . "\x44");
        }
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\x66\146\163\x65\164" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\163\145\164"], "\x63\157\x75\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\x63\157\x75\156\x74"], "\143\157\x6d\x70\154\145\x74\x65" => $qgz907efrkxvvn7bff00yy4["\x63\157\155\160\x6c\x65\x74\x65"], "\160\x65\x72\x63\145\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\160\x65\162\143\x65\x6e\x74"], "\x6d\145\163\x73\x61\x67\145" => $this->getMessage("\x45\130\x50\x4f\x52\x54\137\122\125\x4e\x5f\125\x50\x44\x41\124\105\137\111\x4e\x5f\126\113", ["\43\117\106\106\123\105\124\43" => $qgz907efrkxvvn7bff00yy4["\x6f\146\x66\x73\x65\x74"], "\x23\103\117\125\116\x54\43" => $qgz907efrkxvvn7bff00yy4["\143\157\x75\x6e\164"], "\x23\125\120\104\x41\124\105\x44\43" => $qgz907efrkxvvn7bff00yy4["\x75\160\144\x61\164\145\144"], "\x23\123\x4b\x49\120\x50\105\x44\x23" => $qgz907efrkxvvn7bff00yy4["\x73\x6b\151\160\x70\145\144"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunUpdateInVkBaseModeActionGetCount()
    {
        $jy7cb66b235j13lkvw2nlwdaj = 0;
        $k43ik = $this->goodReferenceExport()->getTable()->getList(["\x73\x65\x6c\x65\x63\164" => [new \Bitrix\Main\ORM\Fields\ExpressionField("\x43\117\x55\116\x54", "\103\117\125\116\x54\50\x44\111\123\x54\x49\x4e\x43\124\x28\45\x73\x29\51", ["\120\122\117\104\x55\x43\124\x5f\x49\104"])], "\146\x69\x6c\164\x65\162" => ["\105\130\x50\x4f\122\124\137\111\104" => $this->exportItem()->getId(), "\x21\x3d\x47\x4f\x4f\104\x5f\x45\130\x50\117\x52\124\56\126\x4b\x5f\x49\x44" => null], "\162\x75\156\x74\151\x6d\145" => [new \Bitrix\Main\Entity\ReferenceField("\x47\x4f\x4f\104\x5f\105\x58\x50\117\x52\124", "\x5c\x56\x4b\x61\x70\151\134\x4d\141\162\x6b\x65\164\x5c\107\x6f\157\144\x5c\105\170\160\x6f\x72\164\124\x61\x62\154\x65", ["\75\164\150\151\163\x2e\120\x52\117\104\125\x43\124\x5f\111\104" => "\162\x65\146\56\x50\122\x4f\x44\125\103\x54\137\111\x44", "\75\164\150\x69\x73\x2e\117\106\x46\105\x52\137\x49\x44" => "\x72\x65\x66\x2e\x4f\106\106\x45\x52\137\x49\104", "\x3d\x72\145\146\x2e\107\122\117\x55\x50\x5f\x49\x44" => new \Bitrix\Main\DB\SqlExpression("\x3f\x69", $this->exportItem()->getGroupId())], ["\x6a\x6f\151\156\x5f\x74\x79\x70\x65" => "\114\105\x46\124"])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $jy7cb66b235j13lkvw2nlwdaj = $ls4lkqztkohkucjlphkh243kf["\x43\117\x55\x4e\x54"];
        }
        return (int) $jy7cb66b235j13lkvw2nlwdaj;
    }
    
    public function exportRunUpdateInVkBaseModeActionGetNext($rtrmvhgvbfo32o999iagp)
    {
        $frnr2p1y3qq = null;
        $k43ik = $this->goodReferenceExport()->getTable()->getList(["\163\x65\x6c\x65\143\164" => ["\120\x52\117\x44\125\103\124\137\x49\x44"], "\146\151\154\164\145\162" => ["\x45\130\120\117\x52\x54\x5f\111\104" => $this->exportItem()->getId(), "\41\75\x47\x4f\117\x44\137\105\130\x50\x4f\x52\x54\56\126\113\137\111\x44" => null], "\154\151\155\151\x74" => 1, "\157\x66\146\163\x65\164" => $rtrmvhgvbfo32o999iagp, "\147\162\157\x75\160" => ["\x50\x52\x4f\104\125\103\124\137\x49\x44"], "\162\165\x6e\x74\151\x6d\145" => [new \Bitrix\Main\Entity\ReferenceField("\107\117\117\104\x5f\105\130\120\x4f\x52\124", "\x5c\x56\x4b\141\x70\x69\134\x4d\141\162\x6b\x65\164\134\x47\157\157\144\x5c\x45\x78\x70\x6f\x72\x74\x54\x61\x62\x6c\x65", ["\75\164\x68\x69\x73\56\x50\x52\x4f\104\125\x43\x54\137\x49\104" => "\162\145\x66\56\x50\122\x4f\104\x55\103\124\x5f\x49\104", "\x3d\164\150\151\x73\x2e\117\x46\106\105\x52\137\x49\x44" => "\162\145\146\x2e\117\x46\x46\105\x52\137\111\104", "\75\162\x65\146\56\x47\x52\x4f\x55\x50\137\x49\104" => new \Bitrix\Main\DB\SqlExpression("\x3f\x69", $this->exportItem()->getGroupId())], ["\x6a\157\151\x6e\x5f\x74\x79\x70\x65" => "\114\105\106\x54"])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $frnr2p1y3qq = $ls4lkqztkohkucjlphkh243kf["\120\122\117\104\125\x43\124\x5f\x49\x44"];
        }
        return $frnr2p1y3qq;
    }
    
    public function exportRunUpdateInVkBaseModeActionUpdate($frnr2p1y3qq)
    {
        
        $n6y3t673zfh3ejiq95hhnajv = $this->exportRunAddToVkBaseModeActionAddGetRows($frnr2p1y3qq);
        if (empty($n6y3t673zfh3ejiq95hhnajv)) {
            $this->log()->error($this->getMessage("\105\130\120\x4f\x52\124\137\x52\x55\116\x5f\x55\120\x44\101\124\x45\137\111\x4e\137\126\113\56\122\105\x46\105\122\x45\x4e\103\105\137\x50\122\117\104\125\x43\x54\x5f\x49\124\105\x4d\123\x5f\116\117\x54\x5f\106\x4f\125\116\104", ["\43\111\104\x23" => $frnr2p1y3qq]));
            return false;
        }
        
        $this->exportRunUpdateInVkBaseModeActionCreateExportedRow($n6y3t673zfh3ejiq95hhnajv);
        
        $oyuavn814c9evdh09cz1h018nrjn31hg = array_column($n6y3t673zfh3ejiq95hhnajv, "\x4f\x46\106\x45\122\x5f\x49\x44");
        $zn1t1hd2qixbm1rqzw0qp = $this->getPreparedItem($frnr2p1y3qq, $oyuavn814c9evdh09cz1h018nrjn31hg);
        try {
            $f945acoojatz1afy55womgn0bjwxjya = $zn1t1hd2qixbm1rqzw0qp->getFields();
            $dmop7jw1 = $zn1t1hd2qixbm1rqzw0qp->getAlbumsVkIds();
            
            $x1ue6tvjc4lf0qlplh = $this->goodExportTable()->getList(["\x66\x69\x6c\164\145\162" => ["\107\x52\x4f\x55\x50\137\111\104" => $this->exportItem()->getGroupId(), "\120\122\117\x44\125\103\x54\137\111\104" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\117\106\x46\x45\122\x5f\x49\104" => $zn1t1hd2qixbm1rqzw0qp->getOfferIds()], "\154\151\155\x69\164" => 1])->fetch();
            
            $this->history()->append($zn1t1hd2qixbm1rqzw0qp, $x1ue6tvjc4lf0qlplh["\126\x4b\x5f\x49\104"]);
            if ($f945acoojatz1afy55womgn0bjwxjya["\160\162\151\x63\x65"] < 0.01) {
                $this->log()->error($this->getMessage("\x45\130\x50\117\122\124\137\x52\x55\x4e\x5f\125\x50\104\x41\x54\105\x5f\111\116\137\x56\x4b\56\x50\x52\111\103\x45\137\x45\115\120\124\131", ["\43\120\x52\117\104\x55\x43\x54\137\x49\104\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\x46\x46\105\122\x5f\111\104\x23" => implode("\54\x20", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            if (!(int) $f945acoojatz1afy55womgn0bjwxjya["\155\x61\151\156\137\160\x68\157\x74\x6f\137\x69\144"]) {
                $this->log()->error($this->getMessage("\x45\x58\x50\117\122\124\137\x52\x55\x4e\137\125\120\x44\101\124\105\137\111\116\137\126\x4b\x2e\x4d\101\x49\x4e\x5f\120\110\117\124\117\137\111\104\137\105\115\120\124\131", ["\43\120\x52\x4f\x44\x55\x43\x54\x5f\x49\104\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\x4f\x46\106\x45\x52\137\x49\x44\x23" => implode("\x2c\x20", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            if ($x1ue6tvjc4lf0qlplh["\x48\x41\x53\110"] == $this->getHash($f945acoojatz1afy55womgn0bjwxjya, $dmop7jw1)) {
                $this->log()->notice($this->getMessage("\105\x58\x50\117\x52\x54\x5f\x52\125\116\x5f\x55\x50\104\x41\124\x45\137\x49\116\137\x56\x4b\56\x4e\117\x54\137\103\110\x41\116\x47\105\x44", ["\43\x50\x52\117\x44\x55\x43\x54\137\x49\x44\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\117\x46\106\105\122\137\111\104\43" => implode("\x2c\x20", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\x6d\x61\x72\x6b\145\x74\56\x65\144\x69\164", array_merge($f945acoojatz1afy55womgn0bjwxjya, ["\x69\164\145\x6d\137\151\144" => $x1ue6tvjc4lf0qlplh["\x56\x4b\137\x49\x44"]]));
            $a7rypydp3yan8yj = $bgc2t2kjmh35of->getData("\162\x65\163\160\x6f\x6e\163\145");
            
            $this->goodExportTable()->updateByGroupIdProductId($this->exportItem()->getGroupId(), $zn1t1hd2qixbm1rqzw0qp->getProductId(), ["\110\x41\123\x48" => $this->getHash($f945acoojatz1afy55womgn0bjwxjya, $dmop7jw1), "\126\113\137\x49\104" => $x1ue6tvjc4lf0qlplh["\x56\x4b\137\111\104"]]);
            $this->log()->ok($this->getMessage("\105\130\120\117\x52\124\137\x52\125\x4e\137\x55\120\104\x41\124\105\137\x49\x4e\x5f\x56\x4b\56\x55\x50\104\x41\x54\x45\104", ["\x23\120\x52\x4f\x44\125\x43\x54\x5f\111\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\106\x46\105\122\x5f\111\104\x23" => implode("\54\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
            
            $this->deleteVkItemIdFromNotAlbums($x1ue6tvjc4lf0qlplh["\126\x4b\x5f\x49\x44"], $dmop7jw1);
            $this->addVkItemIdToVkAlbums($x1ue6tvjc4lf0qlplh["\126\113\x5f\111\x44"], $dmop7jw1);
        } catch (\VKapi\Market\Exception\ApiResponseException $sfm8797cchactbca) {
            if ($sfm8797cchactbca->is(\VKapi\Market\Api::ERROR_100) && preg_match("\x2f\134\x3a\134\163\x2b\x70\x68\x6f\x74\x6f\x5c\163\x2b\x2f", $sfm8797cchactbca->getMessage()) && isset($f945acoojatz1afy55womgn0bjwxjya)) {
                $tveavmh25iy6 = (array) $f945acoojatz1afy55womgn0bjwxjya["\x6d\x61\x69\156\137\160\x68\x6f\164\x6f\x5f\151\x64"];
                $tveavmh25iy6 = array_merge($tveavmh25iy6, explode("\x2c", $f945acoojatz1afy55womgn0bjwxjya["\160\150\157\164\157\x5f\x69\144\163"]));
                $this->photo()->deleteByPhotoId($tveavmh25iy6, $this->exportItem()->getGroupId());
            }
            $this->log()->error($this->getMessage("\105\130\x50\117\x52\x54\137\x52\125\x4e\137\125\120\104\101\124\105\x5f\111\116\x5f\x56\x4b\56\101\x50\111\137\x45\x52\x52\117\122", ["\x23\x50\x52\x4f\x44\x55\103\x54\x5f\x49\104\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\117\106\x46\105\122\x5f\111\x44\43" => implode("\x2c", $zn1t1hd2qixbm1rqzw0qp->getOfferIds()), "\x23\x4d\x53\107\43" => $sfm8797cchactbca->getMessage()]));
            return false;
        }
        return true;
    }
    
    public function exportRunUpdateInVkBaseModeActionCreateExportedRow($n6y3t673zfh3ejiq95hhnajv)
    {
        $ylxjiu0hhrl2ja3v663uv9i1q = array_filter($n6y3t673zfh3ejiq95hhnajv, function ($h746kk1yl3sexk9ii5ngsoc2x5x566m3r) {
            return !is_null($h746kk1yl3sexk9ii5ngsoc2x5x566m3r["\x56\113\137\111\104"]);
        });
        if (empty($ylxjiu0hhrl2ja3v663uv9i1q)) {
            return false;
        }
        $vcwcwbo6l2pbe = reset($ylxjiu0hhrl2ja3v663uv9i1q);
        
        $nh5960cwvc8aosmoa0mm6pnhee = array_filter($n6y3t673zfh3ejiq95hhnajv, function ($h746kk1yl3sexk9ii5ngsoc2x5x566m3r) {
            return is_null($h746kk1yl3sexk9ii5ngsoc2x5x566m3r["\126\113\x5f\x49\x44"]);
        });
        if (empty($nh5960cwvc8aosmoa0mm6pnhee)) {
            return false;
        }
        foreach ($nh5960cwvc8aosmoa0mm6pnhee as $m60pbw) {
            $this->goodExportTable()->add(["\x47\122\x4f\125\x50\137\111\104" => $this->exportItem()->getGroupId(), "\120\x52\117\x44\x55\x43\124\x5f\x49\x44" => $m60pbw["\120\122\x4f\104\x55\x43\x54\137\x49\x44"], "\117\106\x46\105\122\x5f\x49\104" => $m60pbw["\117\106\x46\x45\x52\137\x49\104"], "\x56\113\137\111\104" => $vcwcwbo6l2pbe["\126\113\137\111\x44"], "\110\x41\123\x48" => $vcwcwbo6l2pbe["\x48\101\x53\110"]]);
        }
    }
    
    public function exportRunAddToVk()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\x65\x78\160\157\162\x74\122\x75\x6e\101\x64\144\x54\157\126\153";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\x63\157\x6d\x70\154\x65\164\x65"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\x63\157\x6d\x70\154\145\x74\145" => false,
                //процент выполнения
                "\160\145\x72\143\x65\156\164" => 0,
                // всего
                "\143\x6f\x75\156\x74" => 0,
                // отступ
                "\157\x66\146\x73\145\x74" => 0,
                // лимит на итерацию
                "\x6c\151\155\x69\164" => 25,
                "\141\x64\x64\145\144" => 0,
                "\x73\153\x69\160\160\145\x64" => 0,
                "\x61\x72\111\144" => null,
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        $qgz907efrkxvvn7bff00yy4["\154\x69\155\x69\164"] = $this->manager()->getExportPackLimit();
        $iabif2h400l4i9l7gxo = false;
        try {
            
            if (is_null($qgz907efrkxvvn7bff00yy4["\x61\x72\x49\144"])) {
                $qgz907efrkxvvn7bff00yy4["\141\162\111\x64"] = $this->exportRunAddToVkActionGetIds();
                $qgz907efrkxvvn7bff00yy4["\x63\157\x75\x6e\164"] = count($qgz907efrkxvvn7bff00yy4["\x61\x72\111\x64"]);
            }
            if (\CModule::IncludeModuleEx("\x76\153\141\160" . "\151\x2e\155" . "\x61\x72\x6b\x65" . "\x74") === constant("\x4d\x4f\x44\x55\x4c\x45\x5f\x44\105\x4d\117\137\x45\130" . "\x50\x49" . "" . "" . "" . "\122" . "" . "\105" . "\104")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\101\120\111\x2e" . "\x4d\101\122\x4b\x45\x54\56" . "\x44\105\115\x4f\137\105\x58\x50\111" . "\x52\x45" . "\x44"), "\x42\130\x4d\101\113\x45\122\137\x44\105\115\117\137\x45\x58\120" . "\111\x52\x45" . "" . "" . "\104");
            }
            while (count($qgz907efrkxvvn7bff00yy4["\141\162\111\x64"])) {
                $this->manager()->checkTime();
                $this->limit()->check();
                $ecp3xh5alb2217e7ksqxq5b1c5jwo = $qgz907efrkxvvn7bff00yy4["\x61\162\111\144"][0];
                $bhnnc3 = $this->goodExportTable()->getCount();
                if (\CModule::IncludeModuleEx("\166\153\141\160\x69\56\x6d\141\x72" . "\x6b\145\x74") == constant("\115\117" . "\x44\125" . "\114" . "\x45\x5f\104\x45\x4d\117")) {
                    if ($bhnnc3 >= 50) {
                        break;
                    }
                }
                
                $this->goodReferenceExport()->getTable()->update($ecp3xh5alb2217e7ksqxq5b1c5jwo, ["\106\114\101\x47" => \VKapi\Market\Good\Reference\Export::FLAG_NEED_SKIP]);
                if ($this->exportRunAddToVkActionAddByRefId($ecp3xh5alb2217e7ksqxq5b1c5jwo)) {
                    $qgz907efrkxvvn7bff00yy4["\141\144\x64\x65\144"]++;
                } else {
                    $qgz907efrkxvvn7bff00yy4["\163\x6b\151\x70\160\145\144"]++;
                }
                
                array_shift($qgz907efrkxvvn7bff00yy4["\141\x72\111\x64"]);
                $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\163\x65\x74"]++;
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        } catch (\VKapi\Market\Exception\GoodLimitException $w3ctkdmgm697x) {
            $iabif2h400l4i9l7gxo = true;
        }
        
        $this->photo()->deleteTemporaryDirectories();
        $qgz907efrkxvvn7bff00yy4["\x70\145\x72\x63\x65\x6e\164"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\145\x72\x63\x65\x6e\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\160\154\145\164\x65"] = true;
        }
        if ($iabif2h400l4i9l7gxo) {
            $qgz907efrkxvvn7bff00yy4["\143\157\155\x70\x6c\x65\164\145"] = true;
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $tnddwx18uf1ah = ["\x6f\x66\x66\163\145\164" => $qgz907efrkxvvn7bff00yy4["\157\146\146\x73\145\x74"], "\143\157\165\156\164" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\x6e\164"], "\x63\157\155\160\154\x65\164\145" => $qgz907efrkxvvn7bff00yy4["\x63\157\155\160\x6c\145\164\x65"], "\160\145\162\143\145\156\x74" => $qgz907efrkxvvn7bff00yy4["\160\145\x72\x63\x65\x6e\164"], "\155\145\x73\163\141\147\145" => $this->getMessage("\x45\130\120\x4f\x52\x54\x5f\122\125\x4e\137\x41\x44\x44\137\124\117\x5f\x56\x4b\56\123\x54\x41\124\x55\123", ["\x23\117\x46\106\123\x45\x54\43" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\163\145\x74"], "\x23\x43\117\x55\116\x54\43" => $qgz907efrkxvvn7bff00yy4["\x63\157\165\156\x74"], "\x23\101\104\x44\x45\x44\x23" => $qgz907efrkxvvn7bff00yy4["\x61\144\x64\x65\x64"], "\43\x53\x4b\x49\x50\120\x45\x44\43" => $qgz907efrkxvvn7bff00yy4["\x73\x6b\x69\x70\160\x65\x64"]])];
        if ($iabif2h400l4i9l7gxo) {
            $tnddwx18uf1ah["\155\x65\163\163\141\x67\x65"] = $this->getMessage("\105\130\x50\117\x52\124\x5f\x52\x55\x4e\x5f\x41\x44\104\x5f\124\x4f\x5f\x56\x4b\x5f\114\111\x4d\111\x54\56\123\124\x41\124\125\123", ["\43\117\106\x46\123\105\x54\x23" => $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\163\x65\164"], "\x23\103\117\125\116\124\x23" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x75\x6e\x74"], "\x23\x41\104\x44\x45\104\43" => $qgz907efrkxvvn7bff00yy4["\x61\144\144\x65\144"], "\43\x53\113\x49\120\x50\x45\104\x23" => $qgz907efrkxvvn7bff00yy4["\163\x6b\x69\160\x70\145\144"]]);
        }
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray($tnddwx18uf1ah);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunAddToVkActionGetIds()
    {
        $tnddwx18uf1ah = [];
        $k43ik = $this->goodReferenceExport()->getTable()->getList(["\163\x65\154\x65\143\x74" => ["\x49\104"], "\146\x69\154\x74\145\x72" => ["\105\x58\120\x4f\x52\124\x5f\111\x44" => $this->exportItem()->getId(), "\x47\x4f\117\104\137\x49\x54\105\x4d\56\111\104" => null], "\x72\165\x6e\x74\151\x6d\145" => [new \Bitrix\Main\Entity\ReferenceField("\107\x4f\117\104\x5f\111\x54\105\115", "\134\x56\x4b\x61\160\x69\134\115\x61\x72\153\x65\x74\x5c\x47\x6f\157\x64\134\105\x78\160\x6f\x72\164\124\141\142\x6c\145", ["\75\x74\x68\151\163\56\x50\122\x4f\104\x55\x43\x54\137\111\x44" => "\162\145\146\x2e\120\122\117\x44\125\x43\x54\x5f\x49\104", "\x3d\x74\150\x69\163\56\117\106\106\105\x52\x5f\x49\x44" => "\162\145\x66\56\x4f\106\x46\105\122\x5f\x49\104", "\x3d\162\x65\146\56\107\x52\117\125\120\x5f\111\x44" => new \Bitrix\Main\DB\SqlExpression("\x3f\151", $this->exportItem()->getGroupId())], ["\x6a\x6f\x69\156\137\x74\x79\x70\145" => "\114\x45\106\124"])]]);
        while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $tnddwx18uf1ah[] = $ls4lkqztkohkucjlphkh243kf["\111\x44"];
        }
        return $tnddwx18uf1ah;
    }
    
    public function exportRunAddToVkActionAddByRefId($ecp3xh5alb2217e7ksqxq5b1c5jwo)
    {
        $wu99kk4gfj0yobx5g = $this->goodReferenceExport()->getTable()->getById($ecp3xh5alb2217e7ksqxq5b1c5jwo)->fetch();
        if (!$wu99kk4gfj0yobx5g) {
            $this->log()->error($this->getMessage("\x45\130\120\117\122\x54\x5f\x52\x55\x4e\137\x41\x44\104\x5f\x54\x4f\x5f\126\113\x2e\122\105\106\x45\122\105\116\103\105\x5f\111\x54\x45\x4d\137\x4e\x4f\124\137\x46\117\x55\116\104", ["\x23\x49\104\43" => $ecp3xh5alb2217e7ksqxq5b1c5jwo]));
            return true;
        }
        $zn1t1hd2qixbm1rqzw0qp = $this->getPreparedItem($wu99kk4gfj0yobx5g["\120\122\117\104\x55\x43\x54\137\111\x44"], (array) $wu99kk4gfj0yobx5g["\117\106\106\x45\x52\x5f\111\104"]);
        try {
            $f945acoojatz1afy55womgn0bjwxjya = $zn1t1hd2qixbm1rqzw0qp->getFields();
            if ($f945acoojatz1afy55womgn0bjwxjya["\x70\162\x69\x63\145"] < 0.01) {
                $this->log()->error($this->getMessage("\x45\x58\x50\117\122\x54\x5f\122\125\x4e\x5f\101\104\x44\x5f\124\117\137\126\x4b\56\120\122\x49\x43\105\137\105\115\120\124\131", ["\43\x50\x52\x4f\x44\125\103\x54\137\111\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\117\x46\106\105\x52\x5f\x49\104\x23" => implode("\54\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            if (!intval($f945acoojatz1afy55womgn0bjwxjya["\x6d\x61\x69\156\137\x70\150\x6f\164\x6f\x5f\151\144"])) {
                $this->log()->error($this->getMessage("\x45\130\120\117\122\124\137\122\x55\x4e\x5f\101\104\x44\x5f\124\117\137\126\x4b\x2e\x4d\101\111\x4e\x5f\120\110\117\x54\x4f\137\111\104\x5f\x45\x4d\x50\x54\131", ["\43\x50\122\117\x44\x55\103\124\x5f\x49\104\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\x4f\x46\106\x45\122\x5f\111\104\43" => implode("\54\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\x6d\141\x72\x6b\x65\x74\x2e\x61\x64\x64", $f945acoojatz1afy55womgn0bjwxjya);
            $a7rypydp3yan8yj = $bgc2t2kjmh35of->getData("\x72\x65\163\x70\x6f\x6e\x73\145");
            $eer2z3wspd2via0wyklh7o = (int) $a7rypydp3yan8yj["\155\141\162\153\x65\x74\x5f\151\164\145\155\137\151\x64"];
            $dmop7jw1 = $zn1t1hd2qixbm1rqzw0qp->getAlbumsVkIds();
            
            $vsjcl858sff5x62jfrbt = $this->goodExportTable()->add(["\x47\x52\117\125\120\137\x49\x44" => $this->exportItem()->getGroupId(), "\x50\122\x4f\x44\125\103\x54\x5f\x49\104" => $wu99kk4gfj0yobx5g["\x50\x52\117\x44\125\x43\124\137\x49\x44"], "\x4f\x46\106\x45\x52\x5f\x49\104" => $wu99kk4gfj0yobx5g["\117\106\106\x45\122\137\x49\x44"], "\x56\113\x5f\x49\x44" => $eer2z3wspd2via0wyklh7o, "\x48\101\x53\x48" => $this->getHash($f945acoojatz1afy55womgn0bjwxjya, $dmop7jw1)]);
            $this->log()->ok($this->getMessage("\105\x58\x50\117\x52\124\137\122\x55\116\x5f\x41\104\x44\137\x54\x4f\x5f\x56\113\56\x41\x44\x44\x45\x44", ["\43\x50\122\x4f\x44\125\x43\124\x5f\111\x44\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\106\x46\x45\x52\x5f\111\x44\x23" => implode("\x2c\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
            
            $this->limit()->append($eer2z3wspd2via0wyklh7o);
            
            $this->history()->append($zn1t1hd2qixbm1rqzw0qp, $eer2z3wspd2via0wyklh7o);
            
            $this->deleteVkItemIdFromNotAlbums($eer2z3wspd2via0wyklh7o, $dmop7jw1);
            $this->addVkItemIdToVkAlbums($eer2z3wspd2via0wyklh7o, $dmop7jw1);
        } catch (\VKapi\Market\Exception\ApiResponseException $sfm8797cchactbca) {
            if ($sfm8797cchactbca->is(\VKapi\Market\Api::ERROR_100) && preg_match("\x2f\x5c\72\134\x73\x2b\160\x68\x6f\164\x6f\134\163\53\x2f", $sfm8797cchactbca->getMessage()) && isset($f945acoojatz1afy55womgn0bjwxjya)) {
                $tveavmh25iy6 = (array) $f945acoojatz1afy55womgn0bjwxjya["\155\x61\x69\x6e\137\160\x68\157\x74\x6f\x5f\x69\x64"];
                $tveavmh25iy6 = array_merge($tveavmh25iy6, explode("\54", $f945acoojatz1afy55womgn0bjwxjya["\160\x68\157\164\157\137\x69\144\x73"]));
                $this->photo()->deleteByPhotoId($tveavmh25iy6, $this->exportItem()->getGroupId());
            }
            $this->log()->error($this->getMessage("\105\x58\x50\x4f\x52\124\x5f\122\125\116\137\101\x44\104\x5f\x54\117\x5f\x56\x4b\56\101\120\x49\x5f\105\x52\122\x4f\122", ["\x23\120\x52\x4f\x44\125\x43\124\x5f\x49\104\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\106\106\105\x52\137\x49\104\43" => implode("\x2c\40", $zn1t1hd2qixbm1rqzw0qp->getOfferIds()), "\43\x4d\123\x47\x23" => $sfm8797cchactbca->getMessage()]));
            return false;
        }
        return true;
    }
    
    public function exportRunAddToVkBaseMode()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\x65\x78\160\157\162\164\122\x75\x6e\101\x64\144\124\157\x56\x6b\x42\x61\x73\x65\x4d\x6f\144\x65";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\143\x6f\155\160\x6c\x65\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\x63\x6f\155\160\x6c\145\x74\x65" => false,
                //процент выполнения
                "\x70\x65\x72\143\145\156\x74" => 0,
                // всего
                "\143\x6f\165\x6e\x74" => 0,
                // отступ
                "\x6f\146\146\x73\x65\164" => 0,
                // лимит на итерацию
                "\154\x69\x6d\151\164" => 25,
                "\141\x64\x64\x65\x64" => 0,
                "\163\153\x69\160\x70\x65\x64" => 0,
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        $iabif2h400l4i9l7gxo = false;
        try {
            $qgz907efrkxvvn7bff00yy4["\143\x6f\x75\x6e\164"] = $qgz907efrkxvvn7bff00yy4["\141\x64\x64\x65\144"] + $this->exportRunAddToVkBaseModeActionGetCount();
            if (\CModule::IncludeModuleEx("\x76\x6b\x61\160\x69\56\155\141\162\153\x65\x74") === constant("\x4d\117\x44\x55\x4c\x45\137\x44\105" . "" . "\115\x4f\x5f\105\x58\x50\x49\122" . "\105\104")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\101\x50\x49\56\115\101\122\x4b" . "\105\x54\x2e" . "\104\105\115\117\137\x45" . "" . "\x58" . "" . "\x50\111\x52\x45" . "" . "\104"), "\102\x58\x4d\x41\113\x45\122\x5f\x44\x45\115\117\x5f\105\x58\x50\x49" . "" . "\x52" . "\x45\104");
            }
            while ($frnr2p1y3qq = $this->exportRunAddToVkBaseModeActionGetNext($qgz907efrkxvvn7bff00yy4["\163\x6b\151\160\x70\145\x64"])) {
                $this->manager()->checkTime();
                $this->limit()->check();
                $bhnnc3 = $this->goodExportTable()->getCount();
                if (\Bitrix\Main\Loader::includeSharewareModule("\x76\153\x61\x70\151" . "\56\155\x61\x72" . "" . "\x6b\x65\164") == constant("\x4d\117\104\125\114\105\x5f" . "\104\x45" . "\115\x4f")) {
                    if ($bhnnc3 >= 50) {
                        break;
                    }
                }
                if ($this->exportRunAddToVkBaseModeActionAdd($frnr2p1y3qq)) {
                    $qgz907efrkxvvn7bff00yy4["\x61\144\x64\x65\144"]++;
                } else {
                    $qgz907efrkxvvn7bff00yy4["\163\x6b\x69\160\160\x65\144"]++;
                }
                
                $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\163\145\164"]++;
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        } catch (\VKapi\Market\Exception\GoodLimitException $w3ctkdmgm697x) {
            $iabif2h400l4i9l7gxo = true;
        }
        
        $this->photo()->deleteTemporaryDirectories();
        $qgz907efrkxvvn7bff00yy4["\x70\145\162\x63\x65\x6e\164"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\x65\x72\x63\x65\156\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\x63\157\x6d\x70\x6c\x65\164\145"] = true;
        }
        if ($iabif2h400l4i9l7gxo) {
            $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\160\x6c\x65\x74\x65"] = true;
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $kpy1byxzdzp8ucpiw1u = ["\157\x66\146\163\145\164" => $qgz907efrkxvvn7bff00yy4["\157\x66\146\163\145\x74"], "\x63\x6f\165\x6e\164" => $qgz907efrkxvvn7bff00yy4["\143\x6f\165\x6e\x74"], "\143\x6f\155\160\154\x65\x74\x65" => $qgz907efrkxvvn7bff00yy4["\143\x6f\155\x70\x6c\x65\x74\145"], "\x70\x65\x72\143\145\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\160\x65\x72\x63\x65\156\164"], "\x6d\x65\x73\163\141\147\145" => $this->getMessage("\x45\130\120\117\122\x54\137\122\x55\x4e\x5f\101\104\x44\137\x54\117\x5f\126\x4b\56\123\124\101\x54\x55\x53", ["\x23\117\106\x46\123\105\x54\43" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\x73\145\x74"], "\43\x43\x4f\x55\116\124\x23" => $qgz907efrkxvvn7bff00yy4["\x63\157\x75\x6e\164"], "\43\101\x44\104\x45\x44\43" => $qgz907efrkxvvn7bff00yy4["\x61\144\144\145\144"], "\43\x53\x4b\x49\120\120\x45\x44\43" => $qgz907efrkxvvn7bff00yy4["\163\153\x69\160\160\x65\x64"]])];
        if ($iabif2h400l4i9l7gxo) {
            $kpy1byxzdzp8ucpiw1u["\155\145\163\163\x61\147\x65"] = $this->getMessage("\105\x58\x50\117\x52\124\x5f\122\125\116\x5f\101\x44\x44\x5f\x54\117\x5f\126\113\x5f\x4c\x49\115\x49\x54\x2e\x53\x54\x41\x54\x55\123", ["\x23\117\106\106\x53\x45\124\x23" => $qgz907efrkxvvn7bff00yy4["\157\x66\146\x73\145\164"], "\43\x43\117\125\x4e\124\x23" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x75\x6e\x74"], "\x23\x41\104\x44\x45\104\43" => $qgz907efrkxvvn7bff00yy4["\x61\144\144\145\x64"], "\43\x53\x4b\111\x50\x50\x45\x44\43" => $qgz907efrkxvvn7bff00yy4["\x73\153\151\160\x70\145\x64"]]);
        }
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray($kpy1byxzdzp8ucpiw1u);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunAddToVkBaseModeActionGetCount()
    {
        $jy7cb66b235j13lkvw2nlwdaj = 0;
        $k43ik = $this->goodReferenceExport()->getTable()->getList(["\x73\145\x6c\145\x63\x74" => [new \Bitrix\Main\ORM\Fields\ExpressionField("\103\x4f\125\116\124", "\x43\x4f\125\116\x54\x28\x44\111\123\x54\x49\116\103\x54\50\x25\x73\x29\51", ["\120\x52\117\x44\x55\103\124\137\111\104"])], "\146\151\154\164\x65\x72" => ["\x45\x58\x50\x4f\x52\124\137\111\x44" => $this->exportItem()->getId(), "\107\117\117\x44\137\x49\x54\105\x4d\x2e\111\x44" => null], "\162\x75\x6e\x74\151\155\x65" => [new \Bitrix\Main\Entity\ReferenceField("\x47\117\117\x44\x5f\111\x54\105\x4d", "\134\x56\113\x61\x70\151\134\115\141\162\x6b\145\x74\x5c\x47\157\157\144\134\x45\x78\x70\x6f\162\164\124\x61\x62\154\x65", ["\x3d\164\x68\151\163\56\x50\x52\x4f\x44\x55\103\x54\137\111\104" => "\x72\145\x66\56\120\122\117\x44\125\103\x54\137\111\x44", "\75\164\150\x69\163\56\x4f\106\x46\x45\x52\x5f\x49\x44" => "\162\145\146\56\117\106\106\x45\x52\x5f\111\104", "\x3d\x72\x65\146\56\107\122\x4f\x55\x50\x5f\111\x44" => new \Bitrix\Main\DB\SqlExpression("\77\151", $this->exportItem()->getGroupId())], ["\152\x6f\151\x6e\137\x74\x79\x70\145" => "\x4c\x45\106\124"])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $jy7cb66b235j13lkvw2nlwdaj = $ls4lkqztkohkucjlphkh243kf["\103\x4f\x55\116\124"];
        }
        return $jy7cb66b235j13lkvw2nlwdaj;
    }
    
    public function exportRunAddToVkBaseModeActionGetNext($rtrmvhgvbfo32o999iagp)
    {
        $frnr2p1y3qq = null;
        \Bitrix\Main\Application::getConnection()->startTracker();
        $k43ik = $this->goodReferenceExport()->getTable()->getList(["\x73\145\x6c\145\143\164" => ["\120\122\117\x44\125\x43\x54\137\111\104"], "\x66\x69\x6c\x74\145\162" => ["\x45\x58\x50\117\x52\x54\137\111\104" => $this->exportItem()->getId(), "\107\117\117\x44\137\111\x54\x45\x4d\x2e\111\x44" => null], "\x67\162\x6f\165\x70" => ["\x50\122\x4f\x44\125\x43\124\137\111\104"], "\x6c\x69\155\x69\x74" => 1, "\157\146\146\x73\145\x74" => $rtrmvhgvbfo32o999iagp, "\x72\165\156\164\151\x6d\x65" => [new \Bitrix\Main\Entity\ReferenceField("\107\117\x4f\x44\137\111\x54\x45\x4d", "\134\126\113\141\x70\151\x5c\115\x61\162\153\x65\x74\134\107\x6f\157\x64\134\105\170\160\157\162\164\124\141\x62\154\x65", ["\75\164\x68\151\163\x2e\x50\122\x4f\104\125\x43\x54\137\x49\104" => "\x72\145\146\x2e\x50\122\117\104\x55\103\124\137\111\x44", "\75\164\150\151\x73\x2e\x4f\x46\x46\x45\122\x5f\x49\104" => "\162\x65\x66\x2e\x4f\106\106\x45\122\137\x49\x44", "\75\x72\x65\146\x2e\107\x52\x4f\125\x50\137\111\104" => new \Bitrix\Main\DB\SqlExpression("\77\151", $this->exportItem()->getGroupId())], ["\x6a\x6f\x69\156\x5f\164\x79\x70\145" => "\114\x45\106\124"])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $frnr2p1y3qq = $ls4lkqztkohkucjlphkh243kf["\x50\x52\117\104\125\103\x54\x5f\111\104"];
        }
        $am3qr35uhphfzwz4fur782nyw3sb = \Bitrix\Main\Application::getConnection()->getTracker()->getQueries();
        return $frnr2p1y3qq;
    }
    
    public function exportRunAddToVkBaseModeActionAdd($frnr2p1y3qq)
    {
        
        $n6y3t673zfh3ejiq95hhnajv = $this->exportRunAddToVkBaseModeActionAddGetRows($frnr2p1y3qq);
        if (empty($n6y3t673zfh3ejiq95hhnajv)) {
            $this->log()->error($this->getMessage("\105\130\120\x4f\122\x54\137\122\x55\x4e\137\x41\104\104\137\124\117\137\x56\113\x2e\x52\x45\106\x45\122\x45\116\103\105\x5f\120\x52\x4f\x44\x55\x43\x54\x5f\111\124\105\115\123\137\x4e\x4f\124\x5f\106\117\x55\x4e\104", ["\x23\111\x44\x23" => $frnr2p1y3qq]));
            return false;
        }
        
        $oyuavn814c9evdh09cz1h018nrjn31hg = array_column($n6y3t673zfh3ejiq95hhnajv, "\x4f\x46\x46\105\122\x5f\111\104");
        $zn1t1hd2qixbm1rqzw0qp = $this->getPreparedItem($frnr2p1y3qq, $oyuavn814c9evdh09cz1h018nrjn31hg);
        try {
            $f945acoojatz1afy55womgn0bjwxjya = $zn1t1hd2qixbm1rqzw0qp->getFields();
            if ($f945acoojatz1afy55womgn0bjwxjya["\x70\162\x69\143\145"] < 0.01) {
                $this->log()->error($this->getMessage("\105\x58\120\x4f\x52\x54\x5f\122\125\x4e\x5f\x41\x44\x44\x5f\x54\117\x5f\126\113\x2e\x50\122\x49\x43\x45\x5f\105\115\120\124\131", ["\43\120\x52\117\x44\125\103\124\137\x49\104\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\x4f\x46\x46\105\122\137\111\x44\x23" => implode("\54", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            if (!(int) $f945acoojatz1afy55womgn0bjwxjya["\x6d\x61\x69\156\x5f\160\150\x6f\x74\x6f\x5f\151\x64"]) {
                $this->log()->error($this->getMessage("\105\130\x50\117\122\x54\x5f\122\x55\116\x5f\x41\x44\104\137\124\x4f\137\126\113\56\115\101\111\116\x5f\x50\x48\117\x54\117\137\111\104\x5f\x45\115\120\124\x59", ["\x23\x50\x52\117\104\125\103\x54\137\x49\x44\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\106\106\105\122\x5f\111\x44\43" => implode("\x2c", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
                return false;
            }
            $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\x6d\x61\162\153\145\164\56\x61\x64\144", $f945acoojatz1afy55womgn0bjwxjya);
            $a7rypydp3yan8yj = $bgc2t2kjmh35of->getData("\x72\145\x73\160\x6f\x6e\x73\x65");
            $eer2z3wspd2via0wyklh7o = (int) $a7rypydp3yan8yj["\155\x61\162\153\145\164\137\151\x74\145\x6d\x5f\x69\144"];
            $dmop7jw1 = $zn1t1hd2qixbm1rqzw0qp->getAlbumsVkIds();
            
            foreach ($zn1t1hd2qixbm1rqzw0qp->getOfferIds() as $xip4druw2fxklyfu7h02opev) {
                $this->goodExportTable()->add(["\107\122\117\125\120\x5f\111\104" => $this->exportItem()->getGroupId(), "\120\122\117\x44\125\103\x54\137\111\104" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x4f\106\106\x45\x52\x5f\x49\104" => $xip4druw2fxklyfu7h02opev, "\126\x4b\137\x49\104" => $eer2z3wspd2via0wyklh7o, "\110\101\x53\x48" => $this->getHash($f945acoojatz1afy55womgn0bjwxjya, $dmop7jw1)]);
            }
            $this->log()->ok($this->getMessage("\x45\130\x50\x4f\x52\124\x5f\x52\125\x4e\137\x41\104\x44\x5f\x54\117\x5f\x56\113\56\101\x44\104\x45\104", ["\43\x50\x52\117\104\x55\103\x54\x5f\111\104\x23" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\43\x4f\x46\106\105\x52\137\111\104\43" => implode("\54", $zn1t1hd2qixbm1rqzw0qp->getOfferIds())]));
            
            $this->limit()->append($eer2z3wspd2via0wyklh7o);
            
            $this->history()->append($zn1t1hd2qixbm1rqzw0qp, $eer2z3wspd2via0wyklh7o);
            
            $this->deleteVkItemIdFromNotAlbums($eer2z3wspd2via0wyklh7o, $dmop7jw1);
            $this->addVkItemIdToVkAlbums($eer2z3wspd2via0wyklh7o, $dmop7jw1);
        } catch (\VKapi\Market\Exception\ApiResponseException $sfm8797cchactbca) {
            if ($sfm8797cchactbca->is(\VKapi\Market\Api::ERROR_100) && preg_match("\57\x5c\72\x5c\x73\53\160\150\x6f\x74\157\x5c\x73\53\x2f", $sfm8797cchactbca->getMessage()) && isset($f945acoojatz1afy55womgn0bjwxjya)) {
                $tveavmh25iy6 = (array) $f945acoojatz1afy55womgn0bjwxjya["\155\141\151\156\137\x70\x68\x6f\164\x6f\x5f\151\144"];
                $tveavmh25iy6 = array_merge($tveavmh25iy6, explode("\54", $f945acoojatz1afy55womgn0bjwxjya["\160\x68\157\x74\157\x5f\x69\x64\163"]));
                $this->photo()->deleteByPhotoId($tveavmh25iy6, $this->exportItem()->getGroupId());
            }
            $this->log()->error($this->getMessage("\x45\130\x50\x4f\x52\124\137\x52\x55\x4e\137\101\104\104\x5f\124\117\137\x56\x4b\x2e\x41\x50\111\x5f\105\x52\122\x4f\x52", ["\x23\120\x52\117\x44\x55\x43\124\137\x49\104\43" => $zn1t1hd2qixbm1rqzw0qp->getProductId(), "\x23\x4f\106\x46\x45\122\x5f\111\x44\x23" => implode("\54", $zn1t1hd2qixbm1rqzw0qp->getOfferIds()), "\x23\x4d\x53\x47\43" => $sfm8797cchactbca->getMessage()]));
            return false;
        }
        return true;
    }
    
    public function exportRunAddToVkBaseModeActionAddGetRows($frnr2p1y3qq)
    {
        $tnddwx18uf1ah = [];
        
        $k43ik = $this->goodReferenceExport()->getTable()->getList(["\x73\145\154\145\x63\x74" => ["\52", "\126\113\x5f\x49\x44" => "\107\117\x4f\x44\x5f\111\124\x45\115\x2e\x56\x4b\137\111\104", "\110\101\123\110" => "\107\117\117\x44\x5f\x49\124\105\x4d\56\x48\101\x53\110"], "\x66\x69\x6c\x74\x65\162" => ["\120\x52\x4f\104\x55\x43\x54\x5f\x49\x44" => $frnr2p1y3qq], "\162\x75\x6e\164\x69\x6d\145" => [new \Bitrix\Main\Entity\ReferenceField("\x47\x4f\117\x44\137\111\124\x45\x4d", "\x5c\126\x4b\141\160\x69\134\x4d\141\x72\153\x65\x74\134\x47\x6f\x6f\144\x5c\x45\x78\160\157\x72\x74\x54\x61\142\x6c\x65", ["\x3d\164\x68\151\163\56\120\x52\117\104\125\x43\124\137\111\x44" => "\162\x65\146\56\x50\122\117\x44\x55\x43\x54\137\111\104", "\75\x74\x68\x69\163\56\117\x46\106\x45\x52\x5f\111\x44" => "\x72\x65\x66\x2e\x4f\106\x46\105\x52\137\111\104", "\x3d\162\145\x66\56\x47\x52\117\x55\x50\x5f\x49\104" => new \Bitrix\Main\DB\SqlExpression("\77\151", $this->exportItem()->getGroupId())], ["\x6a\x6f\151\156\x5f\164\171\160\x65" => "\114\x45\x46\124"])]]);
        while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $tnddwx18uf1ah[] = $ls4lkqztkohkucjlphkh243kf;
        }
        return $tnddwx18uf1ah;
    }
    
    public function getPreparedItem($frnr2p1y3qq, $fk7zid)
    {
        $i2un9b = new \VKapi\Market\Good\Export\Item($frnr2p1y3qq, $fk7zid, $this->exportItem());
        return $i2un9b;
    }
    
    public function deleteVkItemIdFromNotAlbums($eer2z3wspd2via0wyklh7o, $u5us8ncjgluc)
    {
        $j0zw202vtem5oi = "";
        $j0zw202vtem5oi .= "\40\x76\141\x72\x20\156\145\x65\x64\111\144\x73\40\x3d\40\x5b" . implode("\54", $u5us8ncjgluc) . "\x5d\x3b\40";
        $j0zw202vtem5oi .= "\x20\x76\x61\x72\40\x69\x74\145\155\x20\75\x20\101\120\111\56\155\x61\162\x6b\145\x74\56\147\x65\x74\x42\171\111\144\50\x7b\x69\x74\x65\x6d\x5f\151\x64\163\72\40\x22\55" . $this->exportItem()->getGroupId() . "\x5f" . $eer2z3wspd2via0wyklh7o . "\42\x2c\40\x65\x78\x74\x65\156\144\x65\144\x20\72\40\x31\175\51\x3b\x20";
        $j0zw202vtem5oi .= "\40\x76\x61\x72\40\x61\154\142\x75\155\111\x64\163\40\75\40\x69\164\x65\155\x2e\x69\x74\145\155\x73\100\56\x61\x6c\142\x75\x6d\163\137\x69\x64\163\73\40";
        $j0zw202vtem5oi .= "\40\166\141\162\x20\151\x64\40\x3d\x20\x30\x3b\40";
        $j0zw202vtem5oi .= "\x20\x76\141\162\40\x64\145\154\145\x74\x65\101\x6c\x62\165\155\x49\144\163\40\75\x20\133\x5d\73\x20";
        $j0zw202vtem5oi .= "\40\x77\150\x69\x6c\145\50\x61\x6c\142\x75\155\111\x64\x73\56\x6c\145\156\147\x74\x68\x20\76\x20\60\51\173\40";
        $j0zw202vtem5oi .= "\40\x20\151\144\40\x3d\x20\141\x6c\142\x75\155\x49\144\163\56\160\x6f\x70\x28\51\73\x20";
        $j0zw202vtem5oi .= "\40\x20\151\146\50\x6e\x65\145\144\111\x64\x73\56\x69\156\144\x65\170\x4f\x66\x28\x69\144\51\x20\x3e\x20\55\61\x29\x7b\x20";
        $j0zw202vtem5oi .= "\40\x20\x20\x20\40\x64\145\154\x65\x74\145\x41\154\x62\165\x6d\x49\x64\x73\56\160\x75\163\x68\50\x69\144\x29\73\40\40";
        $j0zw202vtem5oi .= "\x20\x20\x7d\40";
        $j0zw202vtem5oi .= "\40\x7d";
        $j0zw202vtem5oi .= "\40\x41\x50\111\56\x6d\x61\x72\x6b\x65\164\56\162\145\155\x6f\166\x65\x46\x72\x6f\x6d\x41\154\142\x75\x6d\x28\173\x6f\167\156\x65\162\137\x69\x64\x3a\x20\x22\x2d" . $this->exportItem()->getGroupId() . "\42\54\40\151\164\145\155\137\x69\144\x20\x3a\40" . $eer2z3wspd2via0wyklh7o . "\x2c\40\141\x6c\x62\x75\x6d\137\151\x64\x73\x3a\40\144\x65\154\145\x74\145\101\x6c\142\165\x6d\x49\144\163\175\51\73\40";
        $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\145\x78\x65\143\x75\164\x65", ["\143\x6f\144\145" => $j0zw202vtem5oi]);
    }
    
    public function addVkItemIdToVkAlbums($eer2z3wspd2via0wyklh7o, $u5us8ncjgluc)
    {
        
        $y5zwe2arhvi4yrnpie6 = array_chunk($u5us8ncjgluc, 20, true);
        foreach ($y5zwe2arhvi4yrnpie6 as $t6akj3q6) {
            if (empty($t6akj3q6)) {
                continue;
            }
            
            $j0zw202vtem5oi = [];
            foreach ($t6akj3q6 as $tr079vyurzpw264epi4re3) {
                $j0zw202vtem5oi[] = "\x41\x50\x49\56\x6d\x61\x72\153\145\x74\x2e\141\x64\144\x54\157\x41\x6c\x62\x75\x6d\50\x7b\xa\40\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\x20\40\40\42\x6f\167\x6e\x65\x72\x5f\x69\x64\x22\x20\x3a\40\42\x2d" . $this->exportItem()->getGroupId() . "\x22\54\12\x20\x20\40\x20\40\40\x20\x20\40\x20\40\x20\40\40\x20\40\42\x69\164\x65\155\x5f\151\144\x22\40\72\40\42" . $eer2z3wspd2via0wyklh7o . "\42\x2c\xa\40\x20\40\x20\x20\40\40\40\40\x20\x20\40\x20\x20\40\40\x22\141\x6c\x62\x75\x6d\x5f\x69\x64\163\42\40\72\40\x22" . $tr079vyurzpw264epi4re3 . "\x22\175\51\x3b";
            }
            $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\x65\x78\x65\x63\x75\x74\145", ["\x63\x6f\144\x65" => implode("", $j0zw202vtem5oi)]);
        }
    }
    
    public function exportRunDeleteOldFromVK()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\145\170\x70\x6f\x72\x74\x52\x75\x6e\104\145\x6c\145\x74\145\x4f\x6c\144\x46\162\157\x6d\126\113";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\143\157\x6d\160\154\x65\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = ["\x63\157\x6d\x70\154\x65\164\x65" => false, "\x70\145\162\143\x65\156\164" => 0, "\143\157\x75\x6e\x74" => 0, "\x6f\x66\x66\163\x65\x74" => 0, "\154\x69\155\151\164" => 25, "\144\145\x6c\145\x74\x65\x64" => 0, "\x61\162\111\144" => []];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        
        if ($this->exportItem()->isDisabledOldItemDeleting()) {
            $qgz907efrkxvvn7bff00yy4["\x63\157\155\160\154\x65\164\145"] = true;
            $qgz907efrkxvvn7bff00yy4["\x70\x65\x72\143\145\156\164"] = 100;
            $qgz907efrkxvvn7bff00yy4["\x64\145\x6c\145\x74\x65\x64"] = 0;
            $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\163\x65\164"] = 0;
            
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
            
            $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\146\x66\163\145\164" => $qgz907efrkxvvn7bff00yy4["\157\x66\x66\x73\145\164"], "\143\x6f\x75\x6e\164" => $qgz907efrkxvvn7bff00yy4["\x63\157\165\x6e\164"], "\143\x6f\x6d\x70\154\145\164\x65" => $qgz907efrkxvvn7bff00yy4["\143\x6f\x6d\x70\x6c\145\x74\x65"], "\x70\x65\162\143\x65\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\x70\145\162\143\145\156\164"], "\155\145\163\163\141\147\x65" => $this->getMessage("\x45\130\x50\117\x52\124\x5f\x52\x55\x4e\x5f\104\x45\114\x45\124\105\137\117\114\104\137\106\x52\117\x4d\137\126\113\x2e\104\x49\123\101\102\114\x45\104")]);
            return $xsv2da4i3y9tmqlf3p7l7pp2np;
        }
        try {
            if (empty($qgz907efrkxvvn7bff00yy4["\141\x72\111\x64"])) {
                
                $qgz907efrkxvvn7bff00yy4["\x61\x72\x49\x64"] = $this->exportRunDeleteOldFromVKActionGetIdForDelete();
                $qgz907efrkxvvn7bff00yy4["\x63\157\x75\x6e\x74"] = count($qgz907efrkxvvn7bff00yy4["\x61\162\111\144"]);
                $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
            }
            if (\Bitrix\Main\Loader::includeSharewareModule("\x76\153\141\160\151\56\x6d\x61\x72" . "\x6b\145\x74") == constant("\x4d\117\104\125\x4c\x45\137\104\105\115\x4f\x5f\x45\x58\120\111\x52" . "\x45" . "\x44")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\x41" . "\x50\111\x2e\115\x41" . "\122\113\105\x54" . "\x2e\104\105\115\x4f\137\105\130\x50\111\122\x45" . "\x44"), "\x42\x58\x4d\x41\113\x45\x52\137\x44\105\115\117\x5f\105\x58\120\111\122" . "\x45\104");
            }
            
            while (count($qgz907efrkxvvn7bff00yy4["\141\x72\x49\x64"]) > 0) {
                $this->manager()->checkTime();
                $glf078 = array_slice($qgz907efrkxvvn7bff00yy4["\x61\x72\x49\144"], 0, $qgz907efrkxvvn7bff00yy4["\154\x69\x6d\151\164"]);
                $vjm73iu2f1ssgz8fkkn0cbz = [];
                $j0zw202vtem5oi = [];
                $k43ik = $this->goodExportTable()->getList(["\146\x69\154\164\145\x72" => ["\x49\104" => $glf078]]);
                while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
                    $vjm73iu2f1ssgz8fkkn0cbz[$ls4lkqztkohkucjlphkh243kf["\x49\104"]] = $ls4lkqztkohkucjlphkh243kf;
                    $j0zw202vtem5oi[] = "\42" . $ls4lkqztkohkucjlphkh243kf["\111\x44"] . "\42\x20\72\x20\101\120\x49\56\155\141\x72\153\145\x74\x2e\x64\x65\x6c\145\x74\145\x28\173\42\x6f\167\x6e\145\162\137\151\x64\x22\40\72\x20\55" . $this->exportItem()->getGroupId() . "\54\x22\151\164\145\155\x5f\x69\144\42\x20\72\40\x22" . $ls4lkqztkohkucjlphkh243kf["\126\x4b\137\111\x44"] . "\42\x7d\x29";
                }
                
                if (count($j0zw202vtem5oi)) {
                    $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\x65\x78\145\143\165\x74\145", ["\x63\x6f\x64\145" => "\162\145\164\x75\162\x6e\x20\173" . implode("\x2c", $j0zw202vtem5oi) . "\x7d\x3b"]);
                    $a7rypydp3yan8yj = $j5iunqjq99s53lvcg0x6buywgec0zf->getData("\162\x65\x73\160\157\156\x73\145");
                    foreach ($a7rypydp3yan8yj as $n4uqcvcuj3zs => $p95izz9hrn2e0mubcrw2si0abhbgb9otq) {
                        if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq == 1) {
                            if (isset($vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs])) {
                                
                                $this->goodExportTable()->delete($n4uqcvcuj3zs);
                                
                                $this->photo()->getTable()->deleteByProduct($vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\x50\122\117\104\125\x43\x54\137\x49\104"], $vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\117\x46\x46\105\122\137\111\x44"], $this->exportItem()->getGroupId());
                                $this->log()->ok($this->getMessage("\105\130\120\x4f\122\x54\137\122\125\116\x5f\x44\x45\x4c\105\124\105\x5f\x4f\x4c\104\137\x46\x52\117\115\x5f\126\x4b\56\x49\124\x45\x4d\137\x44\105\114\x45\124\x45\104", ["\x23\120\x52\x4f\x44\125\x43\124\137\111\104\x23" => $vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\120\122\117\x44\125\103\124\x5f\x49\x44"], "\43\x4f\106\x46\105\x52\137\x49\x44\x23" => $vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\117\x46\x46\x45\x52\137\111\x44"]]));
                                $qgz907efrkxvvn7bff00yy4["\x64\145\154\145\x74\x65\x64"]++;
                            }
                            unset($vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]);
                        }
                    }
                    
                    foreach ($vjm73iu2f1ssgz8fkkn0cbz as $m5fuff1swjsnadwe0c6vnotetlwfapxrr) {
                        
                        $this->goodExportTable()->delete($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x49\104"]);
                        
                        $this->photo()->getTable()->deleteByProduct($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x50\x52\x4f\104\x55\103\x54\137\x49\104"], $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\117\x46\x46\x45\x52\x5f\111\x44"], $this->exportItem()->getGroupId());
                        $this->log()->ok($this->getMessage("\105\130\120\117\122\x54\x5f\122\x55\x4e\137\x44\105\x4c\x45\x54\105\x5f\117\x4c\104\x5f\x46\122\117\115\x5f\x56\113\x2e\x49\x54\x45\x4d\x5f\104\105\114\105\x54\105\x44", ["\43\120\122\x4f\104\x55\x43\x54\x5f\111\104\x23" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x50\x52\117\104\125\103\124\x5f\111\x44"], "\x23\117\106\x46\x45\122\137\x49\104\43" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\117\x46\x46\x45\x52\x5f\x49\x44"]]));
                        $qgz907efrkxvvn7bff00yy4["\144\x65\x6c\145\164\x65\x64"]++;
                    }
                }
                
                $qgz907efrkxvvn7bff00yy4["\x6f\146\146\163\x65\x74"] += count($glf078);
                
                $qgz907efrkxvvn7bff00yy4["\x61\x72\111\x64"] = array_slice($qgz907efrkxvvn7bff00yy4["\x61\x72\x49\144"], $qgz907efrkxvvn7bff00yy4["\x6c\x69\x6d\151\164"]);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        $qgz907efrkxvvn7bff00yy4["\160\145\x72\x63\145\x6e\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\x65\x72\143\x65\156\x74"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\x63\157\155\x70\x6c\145\x74\x65"] = true;
            unset($qgz907efrkxvvn7bff00yy4["\x61\162\x49\144"]);
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\x66\146\163\145\x74" => $qgz907efrkxvvn7bff00yy4["\157\146\146\x73\x65\164"], "\x63\157\165\x6e\164" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\x6e\x74"], "\143\x6f\155\160\154\x65\164\145" => $qgz907efrkxvvn7bff00yy4["\143\x6f\155\x70\x6c\145\164\x65"], "\x70\145\162\x63\x65\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\160\x65\162\143\145\156\164"], "\x6d\145\x73\x73\x61\x67\145" => $this->getMessage("\x45\x58\x50\117\x52\124\x5f\x52\x55\116\x5f\104\x45\114\105\x54\x45\137\x4f\x4c\104\x5f\106\122\117\115\137\126\x4b", ["\43\117\x46\106\123\105\124\43" => $qgz907efrkxvvn7bff00yy4["\157\146\146\163\x65\x74"], "\43\103\x4f\x55\x4e\x54\x23" => $qgz907efrkxvvn7bff00yy4["\143\x6f\x75\x6e\x74"], "\43\104\105\114\105\124\x45\104\43" => $qgz907efrkxvvn7bff00yy4["\x64\145\154\x65\x74\x65\x64"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunDeleteOldFromVKActionGetIdForDelete()
    {
        
        $w84xi769qc5u3n7sd34js15d7r = $this->getActiveExportIds();
        $tnddwx18uf1ah = [];
        $k43ik = $this->goodExportTable()->getList(["\163\x65\x6c\x65\143\164" => ["\x49\104"], "\146\x69\154\x74\x65\162" => ["\x47\122\117\125\120\x5f\111\104" => $this->exportItem()->getGroupId(), "\105\130\120\x4f\x52\x54\137\x52\x45\x46\x45\122\x45\x4e\x43\105\56\x49\x44" => null], "\162\165\156\164\151\155\145" => [new \Bitrix\Main\Entity\ReferenceField("\105\130\x50\x4f\122\124\x5f\122\105\x46\x45\x52\x45\116\x43\x45", \VKapi\Market\Good\Reference\ExportTable::class, \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\x74\x68\151\163\x2e\120\122\x4f\104\125\x43\x54\x5f\x49\104", "\x72\x65\146\x2e\x50\x52\117\x44\125\103\x54\x5f\111\104")->whereColumn("\x74\x68\x69\x73\56\117\106\x46\x45\x52\137\x49\104", "\x72\145\x66\x2e\x4f\x46\x46\x45\122\137\x49\x44")->whereIn("\162\x65\146\x2e\105\130\x50\117\x52\124\x5f\x49\104", $w84xi769qc5u3n7sd34js15d7r), ["\152\157\x69\156\x5f\164\171\160\145" => \Bitrix\Main\ORM\Query\Join::TYPE_LEFT])]]);
        while ($dwnyyuqsgsg10a65hflvj40c5 = $k43ik->fetch()) {
            $tnddwx18uf1ah[] = $dwnyyuqsgsg10a65hflvj40c5["\x49\x44"];
        }
        return $tnddwx18uf1ah;
    }
    
    public function exportRunDeleteOldFromVKBaseMode()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\x65\x78\160\x6f\x72\164\122\165\156\104\145\154\145\164\x65\x4f\x6c\x64\106\162\x6f\x6d\x56\113\102\141\163\145\115\157\144\x65";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\143\x6f\155\160\154\145\x74\x65"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = ["\143\x6f\155\x70\154\145\164\x65" => false, "\x70\x65\x72\x63\x65\x6e\164" => 0, "\x63\157\x75\x6e\x74" => 0, "\157\146\x66\x73\x65\164" => 0, "\x6c\151\155\151\x74" => 25, "\x64\145\x6c\x65\x74\x65\144" => 0, "\141\x72\116\145\145\144\x44\x65\x6c\145\x74\145" => []];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        
        if ($this->exportItem()->isDisabledOldItemDeleting()) {
            $qgz907efrkxvvn7bff00yy4["\x63\157\x6d\160\154\x65\164\145"] = true;
            $qgz907efrkxvvn7bff00yy4["\160\145\162\143\x65\156\x74"] = 100;
            $qgz907efrkxvvn7bff00yy4["\144\145\154\145\x74\145\x64"] = 0;
            $qgz907efrkxvvn7bff00yy4["\157\x66\x66\163\x65\164"] = 0;
            
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
            
            $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\x66\x66\163\145\x74" => $qgz907efrkxvvn7bff00yy4["\157\146\x66\163\x65\164"], "\x63\x6f\165\156\x74" => $qgz907efrkxvvn7bff00yy4["\143\157\x75\x6e\x74"], "\x63\x6f\155\x70\154\x65\164\x65" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x6d\160\154\145\164\x65"], "\x70\145\x72\143\145\x6e\164" => $qgz907efrkxvvn7bff00yy4["\x70\145\x72\143\145\x6e\x74"], "\x6d\x65\163\163\x61\147\145" => $this->getMessage("\105\x58\120\117\x52\124\x5f\122\x55\x4e\x5f\x44\105\114\105\x54\x45\137\117\x4c\104\x5f\106\122\117\115\137\126\113\56\104\111\x53\x41\x42\114\x45\104")]);
            return $xsv2da4i3y9tmqlf3p7l7pp2np;
        }
        try {
            
            $w84xi769qc5u3n7sd34js15d7r = $this->getActiveExportIds();
            $qgz907efrkxvvn7bff00yy4["\143\157\x75\156\x74"] = $this->exportRunDeleteOldFromVKBaseModeActionGetCount($w84xi769qc5u3n7sd34js15d7r);
            if (\CModule::IncludeModuleEx("\x76\153\141\x70\x69\x2e\155" . "" . "" . "" . "\141\162" . "\x6b\x65" . "\x74") === constant("\x4d\x4f\104\125\x4c" . "\105\137\104\105\x4d" . "\x4f\137\105\x58" . "\120\x49\x52\x45" . "\x44")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\101\x50\x49\56\x4d\101" . "\122\x4b\x45\x54\x2e\104\x45\115\117\x5f\x45\x58\120\111\122" . "\105\104"), "\102\130\115\x41\113\105\x52\137\x44" . "\x45\115" . "\117\137\105\x58\x50\111\x52" . "" . "\x45\x44");
            }
            
            while ($ip19y494yuw4kkc5ek7ugbbr843ea = $this->exportRunDeleteOldFromVKBaseModeActionGetNext($w84xi769qc5u3n7sd34js15d7r)) {
                $this->manager()->checkTime();
                $g09u7o42vd1hfp2fm18v8edlg1u7sj = $this->exportRunDeleteOldFromVKBaseModeActionIsHashMore($ip19y494yuw4kkc5ek7ugbbr843ea["\x49\x44"], $ip19y494yuw4kkc5ek7ugbbr843ea["\126\x4b\137\x49\x44"], $w84xi769qc5u3n7sd34js15d7r);
                if (!$g09u7o42vd1hfp2fm18v8edlg1u7sj) {
                    $qgz907efrkxvvn7bff00yy4["\141\162\x4e\x65\145\x64\x44\145\x6c\x65\164\145"][$ip19y494yuw4kkc5ek7ugbbr843ea["\x56\113\137\111\104"]][] = $ip19y494yuw4kkc5ek7ugbbr843ea;
                }
                
                $this->goodExportTable()->delete($ip19y494yuw4kkc5ek7ugbbr843ea["\111\x44"]);
                
                $this->photo()->getTable()->deleteByProduct($ip19y494yuw4kkc5ek7ugbbr843ea["\x50\x52\x4f\x44\x55\103\x54\x5f\111\104"], 0, $this->exportItem()->getGroupId());
                
                $qgz907efrkxvvn7bff00yy4["\157\x66\x66\163\145\164"]++;
                if (count($qgz907efrkxvvn7bff00yy4["\x61\162\116\x65\x65\144\104\x65\154\145\x74\145"]) > 20) {
                    $qgz907efrkxvvn7bff00yy4["\144\x65\154\145\164\145\144"] += $this->exportRunDeleteOldFromVKBaseModeActionDeleteInVkIds($qgz907efrkxvvn7bff00yy4["\x61\162\116\145\145\x64\x44\145\x6c\145\164\x65"]);
                    $qgz907efrkxvvn7bff00yy4["\x61\x72\x4e\x65\x65\x64\104\x65\154\x65\164\x65"] = [];
                }
            }
            
            if (count($qgz907efrkxvvn7bff00yy4["\x61\162\116\x65\145\x64\x44\x65\x6c\145\x74\x65"]) > 0) {
                $qgz907efrkxvvn7bff00yy4["\144\145\x6c\x65\164\145\144"] += $this->exportRunDeleteOldFromVKBaseModeActionDeleteInVkIds($qgz907efrkxvvn7bff00yy4["\x61\x72\x4e\145\x65\144\104\x65\154\145\164\145"]);
                $qgz907efrkxvvn7bff00yy4["\x61\162\x4e\145\x65\x64\x44\145\x6c\145\x74\x65"] = [];
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        $qgz907efrkxvvn7bff00yy4["\x70\145\x72\143\145\156\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\145\x72\x63\145\156\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\160\x6c\x65\x74\x65"] = true;
            unset($qgz907efrkxvvn7bff00yy4["\141\162\x49\144"]);
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\x66\x66\163\x65\164" => $qgz907efrkxvvn7bff00yy4["\157\x66\146\163\145\164"], "\143\x6f\x75\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\x6e\164"], "\x63\157\155\x70\154\x65\164\145" => $qgz907efrkxvvn7bff00yy4["\143\x6f\155\160\154\145\164\x65"], "\x70\x65\162\143\x65\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\x70\145\x72\x63\x65\x6e\164"], "\x6d\145\x73\163\x61\x67\x65" => $this->getMessage("\105\130\120\117\122\124\x5f\122\x55\x4e\137\104\105\x4c\x45\124\105\x5f\117\x4c\104\x5f\x46\x52\x4f\x4d\137\x56\113", ["\x23\117\106\x46\x53\x45\x54\x23" => $qgz907efrkxvvn7bff00yy4["\157\146\x66\163\x65\164"], "\43\103\x4f\x55\x4e\x54\x23" => $qgz907efrkxvvn7bff00yy4["\143\157\x75\156\x74"], "\x23\x44\x45\x4c\105\x54\x45\x44\x23" => $qgz907efrkxvvn7bff00yy4["\144\145\x6c\x65\164\x65\x64"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunDeleteOldFromVKBaseModeActionGetCount($w84xi769qc5u3n7sd34js15d7r)
    {
        $jy7cb66b235j13lkvw2nlwdaj = 0;
        $k43ik = $this->goodExportTable()->getList(["\163\145\x6c\145\x63\x74" => ["\x43\x4e\124"], "\146\x69\154\164\145\x72" => ["\x47\x52\x4f\x55\120\x5f\111\104" => $this->exportItem()->getGroupId(), "\x45\x58\x50\117\122\x54\x5f\x52\105\x46\105\122\x45\x4e\x43\105\x2e\x49\x44" => null], "\162\165\156\164\x69\155\145" => [new \Bitrix\Main\Entity\ReferenceField("\x45\130\120\117\x52\124\x5f\122\x45\x46\x45\122\105\116\103\105", \VKapi\Market\Good\Reference\ExportTable::class, \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\164\150\x69\163\x2e\120\x52\117\104\x55\103\x54\137\x49\104", "\162\145\x66\56\x50\x52\117\104\125\103\124\x5f\111\104")->whereColumn("\164\x68\151\x73\56\x4f\106\x46\x45\x52\137\111\104", "\x72\145\x66\56\x4f\106\x46\105\122\x5f\111\104")->whereIn("\x72\x65\x66\56\105\x58\120\117\x52\124\x5f\111\104", $w84xi769qc5u3n7sd34js15d7r), ["\x6a\x6f\x69\x6e\137\164\171\160\x65" => \Bitrix\Main\ORM\Query\Join::TYPE_LEFT])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $jy7cb66b235j13lkvw2nlwdaj = $ls4lkqztkohkucjlphkh243kf["\x43\x4e\x54"];
        }
        return (int) $jy7cb66b235j13lkvw2nlwdaj;
    }
    
    public function exportRunDeleteOldFromVKBaseModeActionGetNext($w84xi769qc5u3n7sd34js15d7r)
    {
        $m5fuff1swjsnadwe0c6vnotetlwfapxrr = null;
        $k43ik = $this->goodExportTable()->getList(["\163\145\154\x65\x63\x74" => ["\52"], "\x66\x69\154\x74\x65\x72" => ["\x47\122\x4f\x55\120\137\x49\104" => $this->exportItem()->getGroupId(), "\105\130\120\117\x52\124\137\x52\x45\106\105\122\105\x4e\x43\x45\x2e\x49\104" => null], "\154\151\x6d\151\164" => 1, "\x72\165\156\x74\151\x6d\x65" => [new \Bitrix\Main\Entity\ReferenceField("\x45\130\120\x4f\x52\x54\137\x52\105\x46\x45\122\x45\x4e\103\105", \VKapi\Market\Good\Reference\ExportTable::class, \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\164\x68\x69\163\56\x50\122\x4f\104\125\103\x54\137\x49\104", "\162\x65\146\56\120\x52\x4f\x44\x55\x43\124\137\111\104")->whereColumn("\x74\150\151\163\56\x4f\x46\x46\105\122\x5f\111\x44", "\x72\145\x66\x2e\x4f\x46\x46\x45\122\x5f\x49\104")->whereIn("\162\145\x66\x2e\x45\x58\120\117\122\124\x5f\x49\x44", $w84xi769qc5u3n7sd34js15d7r), ["\152\x6f\x69\x6e\x5f\x74\x79\x70\145" => \Bitrix\Main\ORM\Query\Join::TYPE_LEFT])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $m5fuff1swjsnadwe0c6vnotetlwfapxrr = $ls4lkqztkohkucjlphkh243kf;
        }
        return $m5fuff1swjsnadwe0c6vnotetlwfapxrr;
    }
    
    public function exportRunDeleteOldFromVKBaseModeActionIsHashMore($tr079vyurzpw264epi4re3, $av36pxlrdkbf3v9yc8j26krl, $w84xi769qc5u3n7sd34js15d7r)
    {
        $gmdccf5pmjyh3lcct1dc = false;
        $k43ik = $this->goodExportTable()->getList(["\163\145\x6c\x65\143\164" => ["\x2a"], "\x66\x69\x6c\164\145\x72" => ["\107\122\x4f\x55\x50\137\111\x44" => $this->exportItem()->getGroupId(), "\126\113\137\x49\104" => $av36pxlrdkbf3v9yc8j26krl, "\41\111\104" => $tr079vyurzpw264epi4re3, "\41\x45\130\x50\117\122\124\137\x52\x45\x46\x45\122\x45\116\103\105\56\x49\104" => null], "\154\x69\155\151\x74" => 1, "\x72\x75\156\x74\x69\x6d\145" => [new \Bitrix\Main\Entity\ReferenceField("\x45\130\x50\x4f\x52\x54\137\x52\105\x46\x45\x52\105\116\103\x45", \VKapi\Market\Good\Reference\ExportTable::class, \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\164\150\151\x73\x2e\120\x52\117\x44\x55\x43\x54\x5f\111\x44", "\x72\x65\146\56\120\122\x4f\x44\125\x43\x54\x5f\x49\x44")->whereColumn("\164\x68\151\163\56\x4f\x46\106\105\122\137\111\x44", "\162\145\146\x2e\x4f\x46\106\x45\x52\137\x49\104")->whereIn("\162\x65\x66\56\105\x58\x50\x4f\x52\x54\137\111\x44", $w84xi769qc5u3n7sd34js15d7r), ["\152\157\151\156\x5f\x74\x79\160\x65" => \Bitrix\Main\ORM\Query\Join::TYPE_LEFT])]]);
        if ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $gmdccf5pmjyh3lcct1dc = true;
        }
        return $gmdccf5pmjyh3lcct1dc;
    }
    
    public function exportRunDeleteOldFromVKBaseModeActionDeleteInVkIds($iah0d64tbf6mmp)
    {
        $tmzq14qqemjb1lfl5p5994bi0wofat4rt = 0;
        $qnuwch47 = [];
        foreach ($iah0d64tbf6mmp as $av36pxlrdkbf3v9yc8j26krl => $vjm73iu2f1ssgz8fkkn0cbz) {
            $qnuwch47 = array_merge($qnuwch47, array_column($vjm73iu2f1ssgz8fkkn0cbz, "\x50\x52\117\104\x55\x43\124\137\111\104"));
            $j0zw202vtem5oi[] = "\x22" . $av36pxlrdkbf3v9yc8j26krl . "\42\40\72\x20\x41\120\x49\56\155\141\162\x6b\x65\164\56\144\145\154\145\164\145\50\x7b\42\x6f\167\156\145\162\137\x69\144\42\x20\x3a\40\x2d" . $this->exportItem()->getGroupId() . "\54\x22\151\164\x65\155\137\151\144\x22\40\72\40\42" . $av36pxlrdkbf3v9yc8j26krl . "\x22\x7d\51";
        }
        
        if (count($j0zw202vtem5oi)) {
            try {
                $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\145\x78\x65\143\x75\164\x65", ["\x63\x6f\144\145" => "\x72\145\164\165\x72\x6e\x20\x7b" . implode("\54", $j0zw202vtem5oi) . "\x7d\73"]);
                $a7rypydp3yan8yj = $j5iunqjq99s53lvcg0x6buywgec0zf->getData("\x72\x65\163\x70\x6f\156\163\145");
                $tmzq14qqemjb1lfl5p5994bi0wofat4rt += count($j0zw202vtem5oi);
                
                foreach ($iah0d64tbf6mmp as $av36pxlrdkbf3v9yc8j26krl => $vjm73iu2f1ssgz8fkkn0cbz) {
                    foreach ($vjm73iu2f1ssgz8fkkn0cbz as $m5fuff1swjsnadwe0c6vnotetlwfapxrr) {
                        
                        $this->photo()->getTable()->deleteByProduct($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\x52\117\x44\x55\x43\x54\137\x49\x44"], 0, $this->exportItem()->getGroupId());
                    }
                    $this->log()->ok($this->getMessage("\x45\130\120\x4f\122\124\x5f\122\125\x4e\137\x44\105\x4c\105\124\105\137\117\x4c\104\137\x46\122\117\x4d\137\126\113\x2e\111\124\x45\x4d\137\104\x45\114\x45\124\105\x44", ["\x23\120\x52\x4f\104\x55\103\x54\137\x49\x44\x23" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\122\117\x44\125\x43\124\x5f\111\x44"], "\x23\x4f\106\x46\105\122\x5f\111\x44\43" => implode("\x2c\x20", array_column($vjm73iu2f1ssgz8fkkn0cbz, "\x4f\x46\106\105\x52\x5f\111\104"))]));
                }
            } catch (\VKapi\Market\Exception\ApiResponseException $uykkeeeugwsap9h5ih) {
                $this->log()->error($this->getMessage("\x45\x58\x50\117\x52\x54\x5f\122\x55\116\137\x44\x45\x4c\105\x54\x45\137\x4f\x4c\104\x5f\x46\x52\x4f\115\137\x56\x4b\x2e\x49\x54\x45\115\x5f\104\105\x4c\x45\x54\x45\x5f\x41\120\x49\137\105\x52\x52\117\x52", ["\x23\120\122\117\104\x55\x43\124\x5f\x49\104\x23" => implode("\54\x20", $qnuwch47), "\x23\115\x53\107\43" => $uykkeeeugwsap9h5ih->getMessage()]));
            }
        }
        return $tmzq14qqemjb1lfl5p5994bi0wofat4rt;
    }
    
    public function getActiveExportIds()
    {
        $tnddwx18uf1ah = [];
        $k43ik = $this->manager()->exportTable()->getList(["\146\151\154\x74\145\162" => ["\101\x43\124\x49\x56\105" => true, "\107\x52\117\125\120\137\111\104" => $this->exportItem()->getGroupId()], "\163\145\x6c\145\143\164" => ["\x49\104"]]);
        while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $tnddwx18uf1ah[] = $ls4lkqztkohkucjlphkh243kf["\x49\104"];
        }
        return $tnddwx18uf1ah;
    }
    
    public function exportRunDeleteLocalDoublesFormVK()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\145\x78\160\157\x72\x74\122\165\x6e\104\x65\154\x65\x74\x65\114\x6f\143\x61\x6c\x44\157\165\x62\154\145\163\106\x6f\x72\x6d\126\x4b";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\143\157\155\x70\154\145\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = [
                //завершено
                "\143\157\155\160\x6c\x65\164\x65" => false,
                //процент выполнения
                "\x70\x65\162\143\145\156\x74" => 0,
                // всего
                "\143\157\165\156\x74" => 0,
                // отступ
                "\x6f\146\x66\x73\x65\x74" => 0,
                // лимит на итерацию
                "\x6c\151\155\151\x74" => 20,
                "\144\x65\154\x65\x74\x65\x64" => 0,
                "\141\162\x49\144" => null,
            ];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        
        if ($this->exportItem()->isDisabledOldItemDeleting()) {
            $qgz907efrkxvvn7bff00yy4["\143\x6f\155\160\154\x65\164\145"] = true;
            $qgz907efrkxvvn7bff00yy4["\160\145\x72\143\145\x6e\x74"] = 100;
            $qgz907efrkxvvn7bff00yy4["\x64\x65\154\145\x74\x65\x64"] = 0;
            $qgz907efrkxvvn7bff00yy4["\x6f\146\146\x73\x65\164"] = 0;
            
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
            
            $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\x66\x66\163\x65\164" => $qgz907efrkxvvn7bff00yy4["\x6f\146\x66\163\145\x74"], "\x63\x6f\x75\x6e\164" => $qgz907efrkxvvn7bff00yy4["\143\157\165\x6e\164"], "\143\157\155\160\154\x65\164\x65" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\x70\154\145\x74\145"], "\160\x65\162\x63\x65\156\x74" => $qgz907efrkxvvn7bff00yy4["\x70\145\162\x63\x65\x6e\164"], "\155\x65\163\163\x61\x67\x65" => $this->getMessage("\105\x58\x50\117\122\x54\137\x52\x55\116\x5f\104\x45\114\x45\x54\105\137\114\x4f\x43\x41\114\137\104\x4f\125\x42\114\x45\123\137\106\122\117\x4d\x5f\126\113\56\x44\111\123\101\x42\114\x45\104")]);
            return $xsv2da4i3y9tmqlf3p7l7pp2np;
        }
        try {
            
            if (empty($qgz907efrkxvvn7bff00yy4["\141\162\111\144"])) {
                $qgz907efrkxvvn7bff00yy4["\x61\162\x49\x64"] = $this->goodExportTable()->getDoublesIdByGroupId($this->exportItem()->getGroupId());
                $qgz907efrkxvvn7bff00yy4["\143\x6f\165\156\x74"] = count($qgz907efrkxvvn7bff00yy4["\141\162\111\144"]);
            }
            if (\Bitrix\Main\Loader::includeSharewareModule("\166\153\141\160\x69" . "\x2e\x6d\x61\x72\x6b" . "\145" . "\x74") == constant("\x4d\x4f\x44\125\114\x45" . "\x5f\x44\x45\x4d\117\x5f\x45\x58\120\111\122\x45\104")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\x41\x50\x49\x2e\115\101\x52" . "\113\x45\x54\56\x44\x45\x4d\117\137\x45" . "\130\120\x49\x52\105" . "" . "\104"), "\102\130\x4d\101\x4b\x45\122\137\104\105\115\117\x5f\105\x58\120\x49\122\x45\x44");
            }
            
            while (count($qgz907efrkxvvn7bff00yy4["\x61\x72\x49\x64"])) {
                $this->manager()->checkTime();
                $t6akj3q6 = array_slice($qgz907efrkxvvn7bff00yy4["\141\x72\111\x64"], 0, $qgz907efrkxvvn7bff00yy4["\x6c\151\155\151\164"]);
                
                $j0zw202vtem5oi = [];
                $vjm73iu2f1ssgz8fkkn0cbz = [];
                $k43ik = $this->goodExportTable()->getList(["\x66\x69\x6c\164\145\x72" => ["\111\104" => $t6akj3q6]]);
                while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
                    $vjm73iu2f1ssgz8fkkn0cbz[$ls4lkqztkohkucjlphkh243kf["\111\x44"]] = $ls4lkqztkohkucjlphkh243kf;
                    $j0zw202vtem5oi[] = "\42" . $ls4lkqztkohkucjlphkh243kf["\111\104"] . "\42\40\x3a\x20\x41\120\111\56\x6d\x61\x72\153\x65\x74\x2e\144\x65\x6c\145\164\x65\x28\173\42\x6f\167\156\x65\x72\137\x69\x64\x22\40\x3a\40\x2d" . $this->exportItem()->getGroupId() . "\x2c\x22\151\164\x65\x6d\x5f\x69\x64\42\40\x3a\40\42" . $ls4lkqztkohkucjlphkh243kf["\126\113\137\x49\104"] . "\x22\x7d\x29";
                }
                $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\145\170\145\143\165\164\x65", ["\x63\157\144\x65" => "\162\x65\164\x75\x72\x6e\x20\173" . implode("\54", $j0zw202vtem5oi) . "\x7d\73"]);
                $a7rypydp3yan8yj = $j5iunqjq99s53lvcg0x6buywgec0zf->getData("\162\x65\x73\x70\157\x6e\x73\x65");
                foreach ($a7rypydp3yan8yj as $n4uqcvcuj3zs => $p95izz9hrn2e0mubcrw2si0abhbgb9otq) {
                    if ($p95izz9hrn2e0mubcrw2si0abhbgb9otq == 1) {
                        if (isset($vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs])) {
                            $this->goodExportTable()->delete($vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\x49\104"]);
                            $qgz907efrkxvvn7bff00yy4["\144\145\x6c\x65\x74\145\x64"]++;
                            $qgz907efrkxvvn7bff00yy4["\157\x66\146\x73\x65\x74"]++;
                            $this->log()->ok($this->getMessage("\x45\130\x50\117\x52\124\137\x52\125\x4e\137\104\x45\114\105\x54\x45\x5f\x4c\x4f\103\101\114\137\x44\x4f\x55\x42\x4c\105\123\137\x46\x52\x4f\x4d\137\126\113\x2e\x44\105\114\x45\124\x45\104", ["\43\x50\122\x4f\x44\125\x43\124\x5f\x49\x44\43" => $vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\120\122\x4f\x44\125\x43\124\x5f\111\x44"], "\x23\117\x46\106\x45\x52\137\111\x44\43" => $vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]["\117\106\106\105\122\x5f\x49\x44"]]));
                        }
                    }
                    unset($vjm73iu2f1ssgz8fkkn0cbz[$n4uqcvcuj3zs]);
                }
                foreach ($vjm73iu2f1ssgz8fkkn0cbz as $m5fuff1swjsnadwe0c6vnotetlwfapxrr) {
                    $qgz907efrkxvvn7bff00yy4["\x64\x65\154\x65\x74\x65\144"]++;
                    $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\163\x65\164"]++;
                    $this->log()->ok($this->getMessage("\105\x58\x50\x4f\122\124\137\x52\125\x4e\137\104\105\114\x45\x54\105\x5f\114\117\x43\x41\114\x5f\104\117\x55\102\x4c\x45\123\137\106\x52\x4f\115\137\x56\x4b\x2e\104\x45\x4c\x45\124\x45\x44", ["\43\120\122\117\104\x55\103\x54\137\111\104\x23" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\122\x4f\104\125\x43\124\x5f\x49\104"], "\x23\x4f\106\106\105\122\137\111\x44\43" => $m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x4f\106\x46\105\122\x5f\111\104"]]));
                }
                
                $qgz907efrkxvvn7bff00yy4["\x61\162\x49\x64"] = array_slice($qgz907efrkxvvn7bff00yy4["\141\162\111\x64"], $qgz907efrkxvvn7bff00yy4["\x6c\x69\155\x69\164"]);
            }
        } catch (\VKapi\Market\Exception\BaseException $sfm8797cchactbca) {
        }
        $qgz907efrkxvvn7bff00yy4["\160\x65\x72\143\145\156\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\160\145\x72\143\145\x6e\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\143\157\x6d\x70\x6c\x65\x74\x65"] = true;
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\x6f\x66\146\163\x65\164" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\163\145\164"], "\x63\x6f\165\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\143\157\165\x6e\x74"], "\x63\157\x6d\x70\x6c\145\x74\x65" => $qgz907efrkxvvn7bff00yy4["\143\157\x6d\160\154\145\x74\x65"], "\x70\x65\x72\143\145\156\x74" => $qgz907efrkxvvn7bff00yy4["\x70\x65\x72\x63\145\156\x74"], "\x6d\145\x73\163\141\x67\x65" => $this->getMessage("\x45\x58\x50\117\122\x54\137\122\125\116\137\x44\105\x4c\x45\124\105\137\114\117\103\x41\114\137\104\117\x55\x42\x4c\x45\123\137\106\122\117\115\137\126\113\x2e\123\124\101\x54\125\123", ["\x23\x4f\106\x46\123\x45\x54\x23" => $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\x73\145\x74"], "\x23\103\x4f\125\x4e\x54\43" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x75\x6e\x74"], "\43\104\x45\x4c\x45\124\105\x44\43" => $qgz907efrkxvvn7bff00yy4["\144\145\154\x65\164\145\x64"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunDeleteUnknownInVK()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\145\170\x70\x6f\x72\164\122\x75\x6e\x44\x65\x6c\x65\164\145\125\156\x6b\156\157\x77\x6e\111\x6e\x56\113";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\x63\157\x6d\160\x6c\145\x74\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = ["\143\157\155\x70\154\x65\164\x65" => false, "\x70\145\x72\x63\145\x6e\164" => 0, "\143\157\165\156\x74" => 0, "\157\x66\146\x73\145\164" => 0, "\154\x69\x6d\x69\164" => 20, "\x64\x65\154\145\x74\145\x64" => 0, "\x76\x6b\x49\x74\145\155\163" => null, "\x76\153\x49\x64\x73" => []];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        
        if ($this->exportItem()->isDisabledOldItemDeleting()) {
            $qgz907efrkxvvn7bff00yy4["\144\x65\154\145\164\x65\144"] = 0;
            $qgz907efrkxvvn7bff00yy4["\157\146\x66\163\x65\x74"] = 0;
            $qgz907efrkxvvn7bff00yy4["\143\157\x75\x6e\164"] = 0;
            $qgz907efrkxvvn7bff00yy4["\x70\145\162\x63\145\156\x74"] = 100;
            $qgz907efrkxvvn7bff00yy4["\143\x6f\155\160\154\x65\x74\145"] = true;
            
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
            
            $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\157\x66\x66\x73\145\164" => $qgz907efrkxvvn7bff00yy4["\157\x66\146\163\x65\164"], "\143\x6f\x75\156\x74" => $qgz907efrkxvvn7bff00yy4["\143\x6f\x75\x6e\164"], "\143\157\155\160\x6c\x65\x74\145" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\155\x70\x6c\145\x74\x65"], "\160\145\162\143\145\x6e\164" => $qgz907efrkxvvn7bff00yy4["\x70\145\162\143\145\156\x74"], "\155\145\x73\x73\x61\147\x65" => $this->getMessage("\105\130\x50\117\x52\x54\137\x52\125\x4e\x5f\104\105\114\x45\124\105\x5f\x55\x4e\x4b\116\117\127\116\137\x49\116\x5f\x56\113\56\x44\111\x53\101\102\114\x45\104")]);
            return $xsv2da4i3y9tmqlf3p7l7pp2np;
        }
        try {
            
            if (empty($qgz907efrkxvvn7bff00yy4["\166\153\111\x64\163"])) {
                $qgz907efrkxvvn7bff00yy4["\166\153\111\x64\163"] = $this->getVkItemIdList($qgz907efrkxvvn7bff00yy4["\166\x6b\x49\164\145\155\163"]);
                $qgz907efrkxvvn7bff00yy4["\x63\157\x75\156\164"] = count($qgz907efrkxvvn7bff00yy4["\166\153\x49\x64\x73"]);
            }
            while (count($qgz907efrkxvvn7bff00yy4["\166\x6b\111\x64\163"]) > 0) {
                $this->manager()->checkTime();
                $t6akj3q6 = array_slice($qgz907efrkxvvn7bff00yy4["\x76\x6b\x49\x64\163"], 0, $qgz907efrkxvvn7bff00yy4["\x6c\151\155\x69\x74"]);
                $rinnu0i6y4snbg1qa9elhkz2z = array_combine($t6akj3q6, $t6akj3q6);
                
                $k43ik = $this->goodExportTable()->getList(["\157\162\144\145\162" => ["\111\x44" => "\x41\x53\x43"], "\x66\x69\x6c\164\x65\162" => ["\107\122\x4f\x55\x50\x5f\111\x44" => intval($this->exportItem()->getGroupId()), "\126\x4b\x5f\111\x44" => $t6akj3q6]]);
                while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
                    unset($rinnu0i6y4snbg1qa9elhkz2z[$ls4lkqztkohkucjlphkh243kf["\126\113\137\x49\x44"]]);
                }
                
                if (count($rinnu0i6y4snbg1qa9elhkz2z) > 0) {
                    $j0zw202vtem5oi = [];
                    foreach ($rinnu0i6y4snbg1qa9elhkz2z as $av36pxlrdkbf3v9yc8j26krl) {
                        $j0zw202vtem5oi[] = "\42" . $av36pxlrdkbf3v9yc8j26krl . "\42\x20\x3a\x20\101\120\111\x2e\x6d\141\162\153\x65\164\56\144\x65\x6c\x65\x74\x65\x28\x7b\x22\x6f\167\156\x65\x72\x5f\151\144\42\40\72\40\x2d" . $this->exportItem()->getGroupId() . "\x2c\42\151\164\x65\155\x5f\151\x64\x22\40\72\40\x22" . $av36pxlrdkbf3v9yc8j26krl . "\42\x7d\51";
                    }
                    $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\x65\x78\145\x63\x75\164\x65", ["\x63\x6f\144\145" => "\162\x65\x74\x75\x72\156\40\x7b" . implode("\x2c", $j0zw202vtem5oi) . "\175\73"]);
                    $qgz907efrkxvvn7bff00yy4["\144\145\x6c\x65\164\x65\x64"] += count($rinnu0i6y4snbg1qa9elhkz2z);
                }
                $qgz907efrkxvvn7bff00yy4["\x76\153\x49\144\x73"] = array_slice($qgz907efrkxvvn7bff00yy4["\x76\x6b\111\x64\x73"], $qgz907efrkxvvn7bff00yy4["\x6c\x69\x6d\151\x74"]);
                $qgz907efrkxvvn7bff00yy4["\x6f\x66\x66\x73\x65\x74"] += count($t6akj3q6);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        if (\CModule::IncludeModuleEx("\166\153\141\x70\x69\x2e\155\x61\x72\x6b\x65\164") == constant("\x4d\117\104\x55\x4c\x45\x5f\x44\105\x4d\117\137\105\130\120" . "\x49\122" . "\x45\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\x50\x49\x2e\x4d\101\122\113" . "" . "" . "\x45\x54\x2e\x44\x45\115\117\x5f\105\x58\120\x49\x52\105" . "\x44"), "\102\x58\x4d\x41\x4b\105\122" . "\x5f\x44\105" . "" . "\115\x4f\x5f\105\130\x50" . "\111\x52" . "\x45" . "" . "" . "\x44");
        }
        $qgz907efrkxvvn7bff00yy4["\160\145\162\143\145\156\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\160\x65\162\143\145\156\x74"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\143\x6f\x6d\160\154\145\x74\x65"] = true;
            unset($qgz907efrkxvvn7bff00yy4["\x76\x6b\x49\164\x65\x6d\163"]);
            unset($qgz907efrkxvvn7bff00yy4["\166\153\111\x64\x73"]);
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\157\x66\x66\x73\145\x74" => $qgz907efrkxvvn7bff00yy4["\x6f\146\146\x73\145\x74"], "\143\x6f\165\156\x74" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\156\x74"], "\x63\x6f\155\x70\154\145\x74\x65" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x6d\160\154\x65\x74\x65"], "\x70\x65\162\x63\x65\156\x74" => $qgz907efrkxvvn7bff00yy4["\x70\145\x72\x63\x65\x6e\164"], "\155\145\x73\x73\x61\x67\145" => $this->getMessage("\105\130\x50\x4f\122\x54\137\122\125\x4e\137\x44\105\114\x45\x54\105\x5f\125\116\x4b\x4e\117\x57\x4e\x5f\111\116\137\126\113\x2e\x53\x54\101\124\x55\x53", ["\x23\117\106\106\123\105\124\x23" => $qgz907efrkxvvn7bff00yy4["\157\146\x66\x73\x65\164"], "\x23\x43\117\125\116\x54\43" => $qgz907efrkxvvn7bff00yy4["\143\157\x75\x6e\x74"], "\x23\104\x45\x4c\105\x54\105\x44\x23" => $qgz907efrkxvvn7bff00yy4["\x64\145\154\x65\x74\x65\x64"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunGroupUngroupItem()
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $f8gfs6e30q0asw9qvjg222vrdw92qz35 = "\145\x78\x70\157\x72\164\122\x75\x6e\107\x72\x6f\x75\160\x55\156\147\x72\157\x75\x70\111\164\145\x6d";
        $eolxh = $this->state()->get();
        if (!isset($eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]) || $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35]["\143\x6f\x6d\160\x6c\x65\164\145"]) {
            $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35] = ["\x63\x6f\155\x70\154\145\164\x65" => false, "\x70\145\162\143\x65\x6e\x74" => 0, "\x63\x6f\x75\156\164" => 0, "\x6f\x66\x66\163\x65\x74" => 0, "\154\151\x6d\151\164" => 25, "\147\162\x6f\165\160\145\x64" => 0, "\x61\162\x49\x64" => null];
            $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35])->save();
        }
        $qgz907efrkxvvn7bff00yy4 = $eolxh[$f8gfs6e30q0asw9qvjg222vrdw92qz35];
        try {
            if (empty($qgz907efrkxvvn7bff00yy4["\141\162\x49\x64"])) {
                $qgz907efrkxvvn7bff00yy4["\141\x72\x49\x64"] = $this->exportRunGroupUngroupItemActionGetProductIds();
                $qgz907efrkxvvn7bff00yy4["\143\157\x75\x6e\164"] = count($qgz907efrkxvvn7bff00yy4["\x61\x72\x49\x64"]);
            }
            
            if (!$this->exportItem()->isEnabledExtendedGoods()) {
                $qgz907efrkxvvn7bff00yy4["\x63\x6f\x75\x6e\164"] = 0;
                $qgz907efrkxvvn7bff00yy4["\157\x66\x66\163\145\164"] = 0;
                $qgz907efrkxvvn7bff00yy4["\141\x72\x49\x64"] = [];
            }
            while (count($qgz907efrkxvvn7bff00yy4["\141\162\111\x64"])) {
                $this->manager()->checkTime();
                $frnr2p1y3qq = $qgz907efrkxvvn7bff00yy4["\141\162\111\x64"][0];
                $vjm73iu2f1ssgz8fkkn0cbz = [];
                
                $k43ik = $this->goodExportTable()->getList(["\157\x72\x64\145\x72" => ["\x49\104" => "\x41\123\103"], "\146\151\154\164\145\x72" => ["\x47\x52\117\x55\x50\137\111\104" => intval($this->exportItem()->getGroupId()), "\x50\x52\x4f\x44\125\103\x54\137\111\104" => $frnr2p1y3qq]]);
                while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
                    $vjm73iu2f1ssgz8fkkn0cbz[] = $ls4lkqztkohkucjlphkh243kf;
                }
                $p1vsod5nqn8r = array_column($vjm73iu2f1ssgz8fkkn0cbz, "\x56\x4b\137\x49\104");
                try {
                    if ($this->exportItem()->isEnabledOfferCombine()) {
                        
                        if (count($p1vsod5nqn8r) > 1) {
                            $bffc0yyrtn3820t = [];
                            $bffc0yyrtn3820t[] = "\40\x41\x50\x49\x2e\155\x61\162\153\x65\164\56\x75\156\x67\x72\157\x75\160\111\x74\145\155\163\50\x7b\x67\162\x6f\x75\x70\137\151\x64\x20\72\x20" . $this->exportItem()->getGroupId() . "\54\40\151\164\x65\x6d\x5f\x67\162\157\165\160\x5f\x69\x64\x3a\x20" . $frnr2p1y3qq . "\40\175\51";
                            $bffc0yyrtn3820t[] = "\40\101\120\x49\56\x6d\x61\162\x6b\x65\164\56\x67\x72\x6f\165\x70\111\x74\x65\x6d\x73\50\173\147\162\x6f\x75\160\137\151\144\40\72\40" . $this->exportItem()->getGroupId() . "\54\40\x69\164\145\x6d\x5f\x67\x72\x6f\x75\160\x5f\151\144\72\40" . $frnr2p1y3qq . "\x2c\x20\151\x74\145\x6d\137\x69\144\x73\72\x20\42" . implode("\54", $p1vsod5nqn8r) . "\42\40\175\x29";
                            $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\x65\x78\x65\x63\x75\x74\145", ["\x63\157\x64\145" => "\162\x65\x74\x75\x72\156\40\x5b" . implode("\54", $bffc0yyrtn3820t) . "\135\73"]);
                            $zzvx12p3v99ox3ehcjjqcxtg = $bgc2t2kjmh35of->getData("\x65\170\145\143\165\164\x65\137\145\x72\162\x6f\x72\x73");
                            if (isset($zzvx12p3v99ox3ehcjjqcxtg[0])) {
                                throw new \VKapi\Market\Exception\ApiResponseException($zzvx12p3v99ox3ehcjjqcxtg[0]);
                            }
                            $qgz907efrkxvvn7bff00yy4["\x67\162\x6f\165\x70\145\x64"]++;
                            $this->log()->ok($this->getMessage("\105\130\x50\117\x52\124\x5f\122\x55\x4e\137\107\x52\117\125\120\x5f\125\116\107\x52\x4f\x55\120\137\111\x54\x45\115\x2e\x47\x52\x4f\x55\120\x50\105\104", ["\x23\x50\x52\x4f\x44\125\x43\x54\137\x49\x44\43" => $frnr2p1y3qq, "\x23\117\106\106\x45\122\x5f\111\104\43" => implode("\54", array_column($vjm73iu2f1ssgz8fkkn0cbz, "\x4f\106\x46\x45\x52\x5f\x49\104"))]));
                        }
                    } else {
                        $bgc2t2kjmh35of = $this->exportItem()->connection()->method("\155\x61\x72\x6b\145\x74\x2e\x75\x6e\147\162\157\165\x70\x49\x74\x65\x6d\163", ["\x67\162\157\165\x70\x5f\x69\144" => $this->exportItem()->getGroupId(), "\x69\x74\x65\155\x5f\x67\x72\157\x75\x70\137\151\x64" => $frnr2p1y3qq]);
                        $this->log()->ok($this->getMessage("\x45\x58\x50\117\x52\x54\137\122\125\116\137\x47\122\x4f\x55\120\x5f\x55\116\107\122\117\125\120\x5f\x49\x54\105\115\56\125\116\107\122\117\125\x50\120\105\x44", ["\x23\120\x52\x4f\104\x55\103\x54\137\111\x44\x23" => $frnr2p1y3qq, "\x23\x4f\106\x46\x45\x52\x5f\x49\104\x23" => implode("\x2c", array_column($vjm73iu2f1ssgz8fkkn0cbz, "\117\106\106\105\x52\x5f\x49\x44"))]));
                    }
                } catch (\VKapi\Market\Exception\ApiResponseException $uykkeeeugwsap9h5ih) {
                    $this->log()->error($this->getMessage("\105\x58\120\x4f\x52\x54\137\x52\x55\x4e\x5f\107\122\x4f\x55\x50\x5f\x55\x4e\107\x52\117\125\x50\x5f\x49\124\105\x4d\x2e\105\x52\x52\x4f\x52", ["\43\x50\x52\117\104\x55\103\x54\x5f\x49\x44\x23" => $frnr2p1y3qq, "\x23\117\x46\106\105\122\137\111\x44\43" => implode("\54", array_column($vjm73iu2f1ssgz8fkkn0cbz, "\117\106\106\x45\122\137\111\x44")), "\43\115\x53\107\x23" => $uykkeeeugwsap9h5ih->getMessage()]));
                }
                $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\x73\145\x74"]++;
                array_shift($qgz907efrkxvvn7bff00yy4["\141\162\x49\144"]);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sfm8797cchactbca) {
            
        }
        $qgz907efrkxvvn7bff00yy4["\160\145\162\x63\x65\156\x74"] = $this->state()->calcPercentByData($qgz907efrkxvvn7bff00yy4);
        if ($qgz907efrkxvvn7bff00yy4["\x70\x65\162\x63\x65\156\164"] == 100) {
            $qgz907efrkxvvn7bff00yy4["\143\x6f\155\x70\154\145\164\x65"] = true;
            unset($qgz907efrkxvvn7bff00yy4["\141\162\111\x64"]);
        }
        
        $this->state()->setField($f8gfs6e30q0asw9qvjg222vrdw92qz35, $qgz907efrkxvvn7bff00yy4)->save();
        
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(["\157\146\146\x73\x65\164" => $qgz907efrkxvvn7bff00yy4["\x6f\x66\146\163\x65\164"], "\x63\157\x75\156\164" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\156\x74"], "\x63\157\155\x70\x6c\x65\164\145" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\x6d\160\x6c\145\164\145"], "\160\145\162\x63\145\x6e\x74" => $qgz907efrkxvvn7bff00yy4["\x70\x65\162\x63\x65\156\x74"], "\155\145\x73\x73\x61\147\145" => $this->getMessage("\x45\130\x50\117\122\x54\137\x52\x55\x4e\x5f\x47\x52\x4f\x55\x50\x5f\125\x4e\107\x52\117\125\x50\x5f\111\x54\x45\x4d\x2e\123\x54\101\124\x55\x53", ["\x23\117\x46\x46\x53\x45\x54\x23" => $qgz907efrkxvvn7bff00yy4["\157\146\x66\x73\145\164"], "\x23\103\x4f\x55\116\124\43" => $qgz907efrkxvvn7bff00yy4["\x63\x6f\165\156\x74"], "\43\107\122\x4f\125\x50\105\104\x23" => $qgz907efrkxvvn7bff00yy4["\x67\x72\x6f\x75\x70\x65\144"]])]);
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
    
    public function exportRunGroupUngroupItemActionGetProductIds()
    {
        $tnddwx18uf1ah = [];
        $k43ik = $this->goodExportTable()->getList(["\x73\x65\x6c\145\143\x74" => ["\x50\x52\117\x44\125\x43\124\x5f\111\104"], "\146\151\154\x74\x65\x72" => ["\41\117\106\106\105\x52\x5f\111\104" => 0, "\107\122\117\125\x50\x5f\x49\x44" => $this->exportItem()->getGroupId(), "\x21\105\x58\x50\x4f\x52\x54\137\x52\x45\106\105\x52\105\116\x43\x45\x2e\111\104" => null], "\147\162\x6f\x75\x70" => ["\x50\x52\117\x44\125\x43\x54\x5f\x49\x44"], "\162\x75\x6e\164\x69\x6d\x65" => [new \Bitrix\Main\Entity\ReferenceField("\x45\x58\120\x4f\x52\x54\x5f\x52\105\106\105\122\105\116\x43\x45", \VKapi\Market\Good\Reference\ExportTable::class, \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\x74\150\151\163\56\x50\x52\117\x44\125\103\x54\x5f\111\x44", "\x72\x65\x66\x2e\120\122\117\x44\125\103\x54\137\111\x44")->whereColumn("\164\x68\151\x73\x2e\x4f\106\106\x45\122\x5f\111\x44", "\162\x65\146\56\117\106\x46\x45\122\137\x49\104")->where("\162\x65\x66\56\x45\x58\x50\x4f\122\x54\137\x49\104", $this->exportItem()->getId()), ["\x6a\157\x69\156\x5f\164\171\160\x65" => \Bitrix\Main\ORM\Query\Join::TYPE_LEFT])]]);
        while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
            $tnddwx18uf1ah[] = $ls4lkqztkohkucjlphkh243kf["\120\122\x4f\104\125\x43\124\x5f\111\104"];
        }
        return $tnddwx18uf1ah;
    }
    
    public function getAlbumIdInVkList()
    {
        static $ke6wzn9r2d23jsqe1it3wopql4 = [];
        if (!isset($ke6wzn9r2d23jsqe1it3wopql4[$this->exportItem()->getGroupId()])) {
            $ke6wzn9r2d23jsqe1it3wopql4[$this->exportItem()->getGroupId()] = [];
            $j5iunqjq99s53lvcg0x6buywgec0zf = $this->exportItem()->connection()->method("\x6d\141\x72\x6b\x65\x74\x2e\147\x65\164\x41\154\x62\x75\x6d\163", ["\157\x77\x6e\x65\162\x5f\151\x64" => "\55" . $this->exportItem()->getGroupId()]);
            if ($j5iunqjq99s53lvcg0x6buywgec0zf->isSuccess()) {
                $xsv2da4i3y9tmqlf3p7l7pp2np = $j5iunqjq99s53lvcg0x6buywgec0zf->getData("\162\145\163\160\157\x6e\x73\145");
                if (!is_null($xsv2da4i3y9tmqlf3p7l7pp2np) && isset($xsv2da4i3y9tmqlf3p7l7pp2np["\151\164\x65\155\163"])) {
                    foreach ($xsv2da4i3y9tmqlf3p7l7pp2np["\151\x74\145\x6d\x73"] as $i2un9b) {
                        if (in_array($i2un9b["\x69\x64"], [0, -1])) {
                            continue;
                        }
                        $ke6wzn9r2d23jsqe1it3wopql4[$this->exportItem()->getGroupId()][] = $i2un9b["\151\x64"];
                    }
                }
            }
        }
        return $ke6wzn9r2d23jsqe1it3wopql4[$this->exportItem()->getGroupId()];
    }
    
    public function getAlbumsInVk()
    {
        if (is_null($this->arAlbumsInVk)) {
            $this->arAlbumsInVk = [];
            $kdub0156fv86u9tua = [];
            
            $ztfidlaow1rau666wd2xtfhy = $this->albumExport()->getVkAlbums();
            if ($ztfidlaow1rau666wd2xtfhy->isSuccess()) {
                foreach ($ztfidlaow1rau666wd2xtfhy->getData("\151\x74\x65\155\x73") as $i2un9b) {
                    $kdub0156fv86u9tua[$i2un9b["\x69\x64"]] = $i2un9b["\x69\144"];
                }
            } else {
                $this->log()->notice($this->getMessage("\107\x45\124\137\x41\114\x42\125\115\123\x5f\x49\x4e\137\x56\113\x5f\105\122\x52\117\x52", ["\43\x4d\x53\x47\x23" => $ztfidlaow1rau666wd2xtfhy->getFirstErrorMessage(), "\43\x43\117\x44\x45\43" => $ztfidlaow1rau666wd2xtfhy->getFirstErrorCode()]));
            }
            
            $k43ik = $this->albumExport()->albumExportTable()->getList(["\146\x69\154\164\145\162" => ["\x47\122\117\x55\x50\137\x49\104" => $this->exportItem()->getGroupId()]]);
            while ($ls4lkqztkohkucjlphkh243kf = $k43ik->fetch()) {
                if (!!$ls4lkqztkohkucjlphkh243kf["\126\113\x5f\111\104"] && isset($kdub0156fv86u9tua[$ls4lkqztkohkucjlphkh243kf["\126\x4b\137\111\104"]])) {
                    $this->arAlbumsInVk[$ls4lkqztkohkucjlphkh243kf["\x41\114\x42\125\115\137\111\104"]] = $ls4lkqztkohkucjlphkh243kf["\126\113\137\x49\x44"];
                }
            }
        }
        return $this->arAlbumsInVk;
    }
    
    public function getPreviewForVk($kuj9fmlzy5 = false)
    {
        $xsv2da4i3y9tmqlf3p7l7pp2np = new \VKapi\Market\Result();
        $dhkhgcd0qvgx9xs2b = new \VKapi\Market\Export();
        
        $dva4bsrvo9iozyw = $dhkhgcd0qvgx9xs2b->parseExportDataFromPostData();
        if ($dva4bsrvo9iozyw->isSuccess()) {
            $this->exportItem()->setData($dva4bsrvo9iozyw->getData("\x46\111\x45\114\x44\x53"));
        } else {
            return $dva4bsrvo9iozyw;
        }
        
        $frnr2p1y3qq = $this->exportItem()->getProductIdForPreview();
        $xip4druw2fxklyfu7h02opev = $this->exportItem()->getOfferIdForPreview();
        $this->exportItem()->setPreviewMode(true);
        $oyuavn814c9evdh09cz1h018nrjn31hg = [];
        if (\Bitrix\Main\Loader::includeSharewareModule("\x76" . "\153\x61\160\x69\56\155\x61\162\153" . "\145" . "" . "" . "\x74") == constant("\x4d\x4f\x44\x55\x4c\x45\x5f" . "\104\x45\115\117\x5f\x45\x58\120" . "\111" . "\x52\105\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\101\x50\111\56\115\101\x52\x4b\x45\x54\x2e\x44\x45\x4d\117\x5f" . "\105\130\x50\111\122\105" . "" . "\104"), "\102\130\x4d\x41\113" . "\105\x52\137\x44\x45\115\x4f\x5f" . "\x45\130\120\111" . "" . "" . "\122" . "" . "" . "\105\x44");
        }
        if ($kuj9fmlzy5) {
            if (!$xip4druw2fxklyfu7h02opev) {
                return $xsv2da4i3y9tmqlf3p7l7pp2np->addError($this->getMessage("\120\122\105\x56\x49\105\127\x5f\106\117\122\x5f\126\113\56\x45\x52\x52\x4f\x52\x5f\117\106\x46\x45\x52\x5f\x49\104"), "\x45\122\x52\117\122\x5f\x4f\106\x46\x45\x52\x5f\111\104");
            }
            $gw8f0m8qc91lg0o72791w1ryni42n = $this->iblockElementOld()->GetList([], ["\x49\102\x4c\117\x43\x4b\x5f\111\104" => $this->exportItem()->getOfferIblockId(), "\x49\104" => $xip4druw2fxklyfu7h02opev], false, ["\156\x54\157\x70\103\x6f\165\156\164" => 1], ["\x49\104", "\x49\102\x4c\x4f\103\x4b\x5f\x49\104", "\x50\x52\117\120\105\122\124\x59\x5f" . $this->exportItem()->getLinkPropertyId()])->Fetch();
            if (!$gw8f0m8qc91lg0o72791w1ryni42n) {
                return $xsv2da4i3y9tmqlf3p7l7pp2np->addError($this->getMessage("\120\x52\x45\126\x49\105\x57\x5f\x46\x4f\x52\x5f\126\113\56\x45\122\x52\x4f\x52\x5f\x4f\106\106\x45\x52\x5f\x49\x44\137\116\117\124\x5f\x46\x4f\125\x4e\x44"), "\105\122\x52\x4f\122\137\x4f\x46\x46\105\x52\137\x49\x44\x5f\x4e\117\124\137\x46\x4f\x55\x4e\104");
            }
            
            $frnr2p1y3qq = intval($gw8f0m8qc91lg0o72791w1ryni42n["\120\x52\x4f\120\105\x52\124\x59\137" . $this->exportItem()->getLinkPropertyId() . "\137\126\x41\x4c\125\105"]);
            if (!$frnr2p1y3qq) {
                return $xsv2da4i3y9tmqlf3p7l7pp2np->addError($this->getMessage("\x50\x52\x45\x56\x49\105\127\x5f\x46\117\122\x5f\126\x4b\56\x45\x52\122\117\x52\137\x4f\x46\x46\105\x52\x5f\x50\122\117\104\125\103\124\137\x49\104\137\116\x4f\x54\137\x46\x4f\125\116\x44"), "\x45\122\x52\117\122\x5f\117\x46\x46\105\122\137\x50\122\x4f\104\x55\x43\124\x5f\x49\104\137\x4e\x4f\124\137\x46\117\x55\x4e\x44");
            }
            
            $vnhsq49hfv6hwhzph1c1z = $this->iblockElementOld()->GetList([], ["\111\102\114\x4f\103\x4b\x5f\x49\x44" => $this->exportItem()->getProductIblockId(), "\111\104" => $frnr2p1y3qq], false, ["\x6e\124\157\160\103\157\x75\156\x74" => 1], ["\111\104", "\111\x42\114\x4f\103\x4b\137\x49\x44"]);
            if (!$vnhsq49hfv6hwhzph1c1z->Fetch()) {
                return $xsv2da4i3y9tmqlf3p7l7pp2np->addError($this->getMessage("\120\122\105\x56\111\x45\x57\137\x46\x4f\122\137\126\113\56\x45\122\122\x4f\122\137\x4f\x46\106\x45\x52\x5f\120\x52\117\104\x55\x43\124\137\111\x44\x5f\116\x4f\x54\x5f\106\117\x55\x4e\104"), "\105\122\x52\117\x52\137\x4f\106\x46\105\x52\137\120\x52\117\104\x55\103\x54\137\x49\104\x5f\116\x4f\x54\x5f\106\117\125\116\x44");
            }
            
            $oyuavn814c9evdh09cz1h018nrjn31hg[] = $xip4druw2fxklyfu7h02opev;
            $k43ik = $this->iblockElementOld()->GetList([], ["\x49\102\x4c\x4f\103\x4b\137\x49\104" => $this->exportItem()->getOfferIblockId(), "\120\x52\x4f\120\105\122\124\131\137" . $this->exportItem()->getLinkPropertyId() => $frnr2p1y3qq], false, ["\156\x54\x6f\160\x43\x6f\165\x6e\164" => 3], ["\x49\x44"]);
            while ($ls4lkqztkohkucjlphkh243kf = $k43ik->Fetch()) {
                if (!in_array($ls4lkqztkohkucjlphkh243kf["\111\x44"], $oyuavn814c9evdh09cz1h018nrjn31hg)) {
                    $oyuavn814c9evdh09cz1h018nrjn31hg[] = $ls4lkqztkohkucjlphkh243kf["\x49\x44"];
                }
            }
        } else {
            $xip4druw2fxklyfu7h02opev = 0;
            if (!$frnr2p1y3qq) {
                return $xsv2da4i3y9tmqlf3p7l7pp2np->addError($this->getMessage("\120\122\105\x56\111\105\x57\137\x46\117\122\137\x56\113\56\x45\122\122\x4f\122\137\x50\x52\117\104\125\x43\x54\x5f\x49\x44"), "\x45\x52\122\x4f\122\x5f\x50\122\117\104\x55\103\124\x5f\x49\104");
            }
            $vnhsq49hfv6hwhzph1c1z = $this->iblockElementOld()->GetList([], ["\111\x42\x4c\117\x43\x4b\x5f\x49\x44" => $this->exportItem()->getProductIblockId(), "\x49\104" => $frnr2p1y3qq], false, ["\x6e\124\157\160\x43\157\165\156\164" => 1], ["\111\x44", "\x49\102\x4c\x4f\103\x4b\x5f\x49\104"]);
            if (!$vnhsq49hfv6hwhzph1c1z->Fetch()) {
                return $xsv2da4i3y9tmqlf3p7l7pp2np->addError($this->getMessage("\x50\x52\x45\x56\x49\105\127\137\x46\x4f\122\137\126\x4b\56\105\x52\x52\x4f\x52\x5f\120\x52\117\104\x55\x43\124\x5f\111\104\x5f\x4e\117\x54\x5f\x46\117\125\x4e\104"), "\x45\122\122\x4f\x52\137\x50\x52\x4f\x44\x55\x43\124\x5f\x49\x44\137\116\117\x54\x5f\x46\x4f\125\116\x44");
            }
        }
        $zn1t1hd2qixbm1rqzw0qp = new \VKapi\Market\Good\Export\Item($frnr2p1y3qq, $oyuavn814c9evdh09cz1h018nrjn31hg, $this->exportItem());
        $xsv2da4i3y9tmqlf3p7l7pp2np->setDataArray(array_merge($zn1t1hd2qixbm1rqzw0qp->getFields(), ["\151\x73\x4f\146\146\145\x72" => $zn1t1hd2qixbm1rqzw0qp->isOffer()]));
        return $xsv2da4i3y9tmqlf3p7l7pp2np;
    }
}
?>