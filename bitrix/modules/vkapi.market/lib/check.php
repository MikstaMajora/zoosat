<?php

namespace VKapi\Market;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

final class Check
{
    public $exportId = 0;
    public static function create($o6zq51liua7lopjejhe6vn8h89yhcw7)
    {
        $zlcu09qb4e9xiniin714h0i883x12vs = __CLASS__;
        $nwl1810w3ojcctjcx = new $zlcu09qb4e9xiniin714h0i883x12vs($o6zq51liua7lopjejhe6vn8h89yhcw7);
        return $nwl1810w3ojcctjcx;
    }
    public function __constructor($o6zq51liua7lopjejhe6vn8h89yhcw7)
    {
        $this->exportId = intval($o6zq51liua7lopjejhe6vn8h89yhcw7);
    }
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    public function exportItem()
    {
        if (!isset($this->oExportItem)) {
            $this->oExportItem = new \VKapi\Market\Export\Item($this->exportId);
            $this->oExportItem->load();
        }
        return $this->oExportItem;
    }
    
    public function exportPhoto()
    {
        if (is_null($this->oPhoto)) {
            $this->oPhoto = new \VKapi\Market\Export\Photo();
            $this->oPhoto->setExportItem($this->exportItem());
        }
        return $this->oPhoto;
    }
    
    public function albumExport()
    {
        if (is_null($this->oAlbumExport)) {
            $this->oAlbumExport = new \VKapi\Market\Album\Export($this->exportItem());
        }
        return $this->oAlbumExport;
    }
    
    public function goodExport()
    {
        if (is_null($this->oGoodExport)) {
            $this->oGoodExport = new \VKapi\Market\Good\Export($this->exportItem());
        }
        return $this->oGoodExport;
    }
    
    public function propertyExport()
    {
        if (is_null($this->oPropertyExport)) {
            $this->oPropertyExport = new \VKapi\Market\Property\Export($this->exportItem());
        }
        return $this->oPropertyExport;
    }
    public function deleteItemPhotoByFields($obzte0kgjrgh28flic)
    {
        $uovm5xo9r7gzi0gs9d7kwbxg1sdcueybb = (array) $obzte0kgjrgh28flic["\x6d\x61\x69\x6e\x5f\160\150\x6f\164\x6f\x5f\x69\x64"];
        $uovm5xo9r7gzi0gs9d7kwbxg1sdcueybb = array_merge($uovm5xo9r7gzi0gs9d7kwbxg1sdcueybb, explode("\54", $obzte0kgjrgh28flic["\160\x68\x6f\x74\157\x5f\x69\144\x73"]));
        $this->exportPhoto()->deleteByPhotoId($uovm5xo9r7gzi0gs9d7kwbxg1sdcueybb, $this->exportItem()->getGroupId());
    }
    
    public function checkConditon($hy3zrm4yhm66r4eyx)
    {
        \CModule::IncludeModule("\166\153\x61\160\x69\56\155\x61\x72\153\145\x74");
        echo "\x3c\x70\x72\145\76";
        $arResult = $this->manager()->checkExportConditionsForElementId($this->exportId, $hy3zrm4yhm66r4eyx);
        if ($arResult["\x76\141\154\x69\144"]) {
            echo "\111\163\40\166\141\154\x69\x64";
        } else {
            echo "\x49\163\40\156\x6f\164\x20\x76\x61\154\151\x64";
        }
        echo PHP_EOL;
        print_r($arResult);
        echo "\x3c\57\x70\162\145\76";
    }
    
    public function checkProductData($nuqwxpwyx7igrigcqyvad996, $ijd984edz7l7rm6bvzwqo3qy1htt28y5p3t = 0)
    {
        \CModule::IncludeModule("\x76\153\141\x70\x69\56\x6d\x61\x72\153\x65\x74");
        echo "\74\160\x72\x65\x3e";
        $qv3rs5w3t531l2r99ym = new \VKapi\Market\Good\Export\Item($nuqwxpwyx7igrigcqyvad996, $ijd984edz7l7rm6bvzwqo3qy1htt28y5p3t, $this->exportItem());
        echo PHP_EOL;
        echo "\x5c\x56\x4b\x61\160\x69\x5c\115\x61\162\153\145\x74\134\107\157\x6f\144\x5c\x45\170\x70\x6f\x72\x74\134\111\164\x65\x6d\72\x3a\147\145\x74\106\x69\x65\154\x64\163\40" . PHP_EOL;
        var_export($qv3rs5w3t531l2r99ym->getFields());
        echo PHP_EOL;
        echo "\x5c\x56\x4b\141\x70\x69\134\115\141\162\153\145\x74\x5c\107\x6f\157\144\134\x45\x78\160\157\x72\x74\134\x49\164\145\155\x3a\x3a\x67\x65\x74\x50\x72\x6f\144\165\143\164\x44\x61\164\x61\40" . PHP_EOL;
        var_export($qv3rs5w3t531l2r99ym->getProductData());
        echo PHP_EOL;
        echo "\151\163\x4f\146\146\x65\x72\40" . PHP_EOL;
        var_dump($qv3rs5w3t531l2r99ym->isOffer());
        echo PHP_EOL;
        echo "\x5c\126\113\141\160\151\134\115\x61\x72\153\x65\x74\134\x45\170\160\157\x72\x74\x5c\x49\x74\145\x6d\x20" . PHP_EOL;
        var_export($qv3rs5w3t531l2r99ym->exportItem());
        echo "\74\57\160\162\x65\x3e";
    }
}
?>