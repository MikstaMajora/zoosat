<?php

namespace VKapi\Market\Condition;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class CatalogField extends \VKapi\Market\Condition\Base
{
    private $arExistsFields = array("\x43\101\x54\101\x4c\x4f\x47\x5f\x41\x56\101\x49\x4c\101\x42\114\x45", "\103\x41\124\101\114\x4f\107\x5f\x57\105\x49\x47\x48\124", "\103\x41\124\x41\114\x4f\x47\137\x51\x55\x41\116\x54\x49\x54\131");
    public function __construct($ie867f10dshfcr1babs = array())
    {
        
        $fwzbo4jrwogmsld8pa9w7 = $this->getStoreList();
        foreach ($fwzbo4jrwogmsld8pa9w7 as $v45elcf75 => $asbbk09n38dkzicxcn196pxyy) {
            $this->arExistsFields[] = "\x43\x41\124\101\114\x4f\x47\137\x53\x54\x4f\x52\105\x5f" . $v45elcf75;
        }
        
        $d7eee9g3iwue2dfirl2kxc9r78n4bza2pa = $this->getPriceList();
        foreach ($d7eee9g3iwue2dfirl2kxc9r78n4bza2pa as $v45elcf75 => $asbbk09n38dkzicxcn196pxyy) {
            $this->arExistsFields[] = "\x43\x41\124\x41\x4c\117\107\137\107\122\x4f\x55\x50\137" . $v45elcf75;
            $this->arExistsFields[] = "\103\x41\124\x41\x4c\117\x47\x5f\120\x52\111\103\105\x5f" . $v45elcf75;
            $this->arExistsFields[] = "\103\101\124\x41\x4c\x4f\107\137\x44\111\123\x43\117\125\x4e\x54\137\120\105\122\103\x45\x4e\124\x5f" . $v45elcf75;
            $this->arExistsFields[] = "\103\101\124\101\114\x4f\107\137\x44\x49\x53\x43\x4f\x55\116\x54\137\x50\x52\x49\x43\x45\x5f" . $v45elcf75;
        }
        parent::__construct($ie867f10dshfcr1babs);
    }
    
    protected static function getMessage($asbbk09n38dkzicxcn196pxyy, $uorm4uhi = array())
    {
        return parent::getMessage("\103\101\124\101\114\117\x47\x46\x49\105\x4c\x44\x2e" . $asbbk09n38dkzicxcn196pxyy, $uorm4uhi);
    }
    
    protected static function isInstalledCatalogModule()
    {
        static $fiwjzdakff;
        if (!isset($fiwjzdakff)) {
            $fiwjzdakff = \Bitrix\Main\Loader::includeModule("\x63\141\x74\x61\154\157\147");
        }
        return $fiwjzdakff;
    }
    
    public static function getStoreList()
    {
        static $iw5h3fvp0uok3i7vyw6ki;
        if (!isset($iw5h3fvp0uok3i7vyw6ki)) {
            $iw5h3fvp0uok3i7vyw6ki = array();
            if (self::isInstalledCatalogModule()) {
                if (class_exists("\134\x43\x43\141\164\141\x6c\157\147\123\x74\157\x72\145")) {
                    $ahva4gtr = \CCatalogStore::GetList(array("\x4e\x41\x4d\105" => "\x41\123\103"), array());
                    while ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
                        $iw5h3fvp0uok3i7vyw6ki[$k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x49\104"]] = $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\124\x49\124\x4c\105"] . "\x20\x5b" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x49\x44"] . "\x5d";
                    }
                }
            }
        }
        return $iw5h3fvp0uok3i7vyw6ki;
    }
    
    public static function getPriceList()
    {
        static $iw5h3fvp0uok3i7vyw6ki;
        if (!isset($iw5h3fvp0uok3i7vyw6ki)) {
            $iw5h3fvp0uok3i7vyw6ki = array();
            if (self::isInstalledCatalogModule()) {
                if (class_exists("\x5c\103\103\x61\x74\141\154\157\x67\x47\162\157\165\x70")) {
                    $ahva4gtr = \CCatalogGroup::GetList();
                    while ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
                        $iw5h3fvp0uok3i7vyw6ki[$k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\111\x44"]] = $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\116\x41\115\105\x5f\114\x41\116\107"] . "\x20\50" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\116\101\x4d\x45"] . "\x29\40\x5b" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\111\x44"] . "\135";
                    }
                }
            }
        }
        return $iw5h3fvp0uok3i7vyw6ki;
    }
    
    public static function getElementDefaultValues()
    {
        static $iw5h3fvp0uok3i7vyw6ki;
        if (!isset($iw5h3fvp0uok3i7vyw6ki)) {
            $iw5h3fvp0uok3i7vyw6ki = array();
            $iw5h3fvp0uok3i7vyw6ki["\103\x41\x54\101\114\117\x47\137\x57\105\111\107\110\x54"] = 0;
            $iw5h3fvp0uok3i7vyw6ki["\x43\101\x54\101\114\x4f\107\137\121\125\x41\x4e\x54\x49\x54\x59"] = 0;
            $iw5h3fvp0uok3i7vyw6ki["\x43\x41\124\101\114\117\107\137\x41\126\101\x49\x4c\101\x42\x4c\x45"] = "\116";
            foreach (self::getStoreList() as $v45elcf75 => $asbbk09n38dkzicxcn196pxyy) {
                $iw5h3fvp0uok3i7vyw6ki["\103\x41\124\x41\114\117\x47\x5f\123\124\117\x52\x45\x5f" . $v45elcf75] = 0;
            }
            foreach (self::getPriceList() as $v45elcf75 => $asbbk09n38dkzicxcn196pxyy) {
                $iw5h3fvp0uok3i7vyw6ki["\103\101\x54\101\114\117\x47\x5f\107\x52\x4f\x55\x50\137" . $v45elcf75] = 0;
                $iw5h3fvp0uok3i7vyw6ki["\x43\x41\x54\x41\x4c\117\x47\x5f\x50\x52\111\103\105\x5f" . $v45elcf75] = 0;
                $iw5h3fvp0uok3i7vyw6ki["\103\101\124\x41\x4c\117\107\x5f\104\111\123\x43\x4f\x55\116\x54\137\120\x45\x52\103\x45\x4e\x54\x5f" . $v45elcf75] = 0;
                $iw5h3fvp0uok3i7vyw6ki["\x43\x41\124\101\114\x4f\107\137\x44\x49\x53\x43\117\x55\x4e\124\137\x50\122\x49\103\x45\x5f" . $v45elcf75] = 0;
            }
        }
        return $iw5h3fvp0uok3i7vyw6ki;
    }
    
    public function getInternalConditions()
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        $axidyoo4oro4fax3i2qesmb = self::getStoreList();
        $ss1t0g4ni83sxakfodwxyd237gwqgv2lq = self::getPriceList();
        foreach ($this->arExistsFields as $u5526mf8pwl3bod) {
            $asbbk09n38dkzicxcn196pxyy = self::getMessage($u5526mf8pwl3bod);
            if (preg_match("\57\x43\101\x54\x41\114\x4f\107\x5f\123\x54\117\x52\105\137\x28\x5c\144\x2b\x29\x2f", $u5526mf8pwl3bod, $b3s13vksf11vpu60sxr4lkm)) {
                $asbbk09n38dkzicxcn196pxyy = self::getMessage("\123\x4b\114\101\x44", array("\43\123\x4b\114\x41\104\43" => $axidyoo4oro4fax3i2qesmb[$b3s13vksf11vpu60sxr4lkm[1]]));
            } elseif (preg_match("\57\x43\101\124\101\x4c\x4f\x47\x5f\107\x52\117\x55\x50\x5f\50\x5c\x64\53\x29\57", $u5526mf8pwl3bod, $b3s13vksf11vpu60sxr4lkm)) {
                $asbbk09n38dkzicxcn196pxyy = self::getMessage("\x47\122\117\125\120", array("\x23\120\122\111\103\x45\x23" => $ss1t0g4ni83sxakfodwxyd237gwqgv2lq[$b3s13vksf11vpu60sxr4lkm[1]]));
            } elseif (preg_match("\x2f\x43\x41\x54\x41\x4c\x4f\x47\x5f\x50\122\111\x43\105\x5f\50\134\x64\x2b\x29\x2f", $u5526mf8pwl3bod, $b3s13vksf11vpu60sxr4lkm)) {
                $asbbk09n38dkzicxcn196pxyy = self::getMessage("\120\x52\111\103\105", array("\43\x50\122\111\103\x45\43" => $ss1t0g4ni83sxakfodwxyd237gwqgv2lq[$b3s13vksf11vpu60sxr4lkm[1]]));
            } elseif (preg_match("\x2f\x43\x41\124\101\114\x4f\107\x5f\x44\111\x53\x43\117\x55\x4e\x54\x5f\x50\105\x52\103\x45\x4e\124\137\x28\134\x64\x2b\x29\57", $u5526mf8pwl3bod, $b3s13vksf11vpu60sxr4lkm)) {
                $asbbk09n38dkzicxcn196pxyy = self::getMessage("\104\x49\x53\103\117\125\116\124\137\x50\x45\122\103\105\x4e\x54", array("\x23\x50\122\x49\x43\105\43" => $ss1t0g4ni83sxakfodwxyd237gwqgv2lq[$b3s13vksf11vpu60sxr4lkm[1]]));
            } elseif (preg_match("\57\103\101\124\x41\114\x4f\x47\x5f\x44\111\123\x43\x4f\x55\x4e\124\137\120\122\111\103\105\137\x28\x5c\x64\x2b\51\57", $u5526mf8pwl3bod, $b3s13vksf11vpu60sxr4lkm)) {
                $asbbk09n38dkzicxcn196pxyy = self::getMessage("\104\111\123\x43\117\125\116\124\x5f\x50\x52\111\x43\105", array("\43\120\122\x49\103\105\x23" => $ss1t0g4ni83sxakfodwxyd237gwqgv2lq[$b3s13vksf11vpu60sxr4lkm[1]]));
            }
            if ($u5526mf8pwl3bod == "\103\101\124\101\114\x4f\107\x5f\x41\x56\x41\111\114\101\102\114\105") {
                $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\116\x54\x52\117\114\137\124\105\130\124", array("\43\x4e\101\x4d\x45\x23" => $asbbk09n38dkzicxcn196pxyy))), new \VKapi\Market\Condition\Control\Logic("\143\x6f\x6e\144\x69\x74\151\157\x6e", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Select("\166\141\154\x75\x65", array("\x59" => self::getMessage("\131\105\123"), "\116" => self::getMessage("\116\x4f"))));
            } else {
                $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\x4e\x54\122\117\114\x5f\x54\105\x58\124", array("\x23\x4e\101\115\105\43" => $asbbk09n38dkzicxcn196pxyy))), new \VKapi\Market\Condition\Control\Logic("\x63\157\156\144\151\x74\151\157\156", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::MORE, \VKapi\Market\Condition\Control\Logic::MORE_EQUAL, \VKapi\Market\Condition\Control\Logic::LESS, \VKapi\Market\Condition\Control\Logic::LESS_EQUAL), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\x76\x61\x6c\x75\145"));
            }
            $gicuvkskpuwr53xgm3ud8u3eup[] = array("\151\144" => $u5526mf8pwl3bod, "\x6e\x61\x6d\145" => $asbbk09n38dkzicxcn196pxyy, "\147\x72\157\x75\160" => self::getMessage("\107\x52\117\125\120\137\x4c\x41\102\x45\114"), "\x63\x6f\x6d\x70\157\156\145\156\x74" => "\x76\x6b\x61\160\x69\x2d\155\x61\x72\153\x65\x74\x2d\143\x6f\x6e\x64\x69\164\x69\157\x6e\55\x63\141\x74\141\154\x6f\147\55\146\x69\145\x6c\144", "\x63\x6f\x6e\164\162\157\154\x73" => $x2ddfkh5mn4ar98v, "\160\x61\x72\x61\155\163" => $this->getParams(), "\155\157\x72\x65" => array());
        }
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
    
    public static function getEval($ofwy2g)
    {
        $bk38shxx = $ofwy2g["\151\x64"];
        $sdsogn5zv5oxzyyfj8nuw71egkf = $ofwy2g["\x76\x61\154\165\145\163"]["\143\157\156\x64\151\x74\x69\x6f\x6e"];
        $neueels6 = str_replace("\42", "\x5c\x22", $ofwy2g["\166\141\x6c\165\145\163"]["\166\x61\154\165\145"]);
        switch ($bk38shxx) {
            case "\103\x41\124\101\114\117\x47\x5f\101\126\101\111\114\x41\102\x4c\x45":
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
            default:
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::MORE:
                    case \VKapi\Market\Condition\Control\Logic::MORE_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::LESS:
                    case \VKapi\Market\Condition\Control\Logic::LESS_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
        }
        return 0;
    }
}
?>