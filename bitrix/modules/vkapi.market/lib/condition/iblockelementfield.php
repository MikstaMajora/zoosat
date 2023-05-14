<?php

namespace VKapi\Market\Condition;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use VKapi\Market\Condition\Control\Logic;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class IblockElementField extends \VKapi\Market\Condition\Base
{
    private $arExistsFields = array("\111\102\x4c\x4f\103\113\137\x53\105\x43\x54\111\117\116\x5f\x49\104", "\103\x4f\104\x45", "\x58\115\x4c\x5f\111\x44", "\116\101\x4d\x45", "\101\103\x54\x49\126\105", "\101\103\124\111\x56\x45\137\x44\101\124\x45", "\104\101\x54\105\x5f\x41\x43\x54\x49\x56\105\x5f\x46\x52\x4f\x4d", "\104\x41\124\x45\x5f\101\103\x54\111\x56\105\x5f\124\117", "\123\x4f\x52\124", "\120\122\x45\x56\111\x45\127\137\124\x45\x58\124", "\104\105\124\x41\x49\114\137\x54\105\x58\x54", "\104\101\124\x45\137\x43\122\105\101\124\x45", "\x43\x52\105\101\x54\105\104\137\102\x59", "\x54\111\115\x45\x53\124\101\x4d\120\x5f\x58", "\115\117\x44\111\106\x49\x45\x44\x5f\102\x59", "\124\x41\x47\x53");
    private $groupLabel = "";
    public function __construct($ie867f10dshfcr1babs = array())
    {
        
        $this->groupLabel = self::getMessage("\x47\122\117\125\x50\x5f\x4c\101\x42\105\114");
        if (isset($ie867f10dshfcr1babs["\x4c\x41\102\105\114"])) {
            $this->groupLabel = $ie867f10dshfcr1babs["\x4c\101\102\x45\114"];
        }
        
        if (!isset($ie867f10dshfcr1babs["\111\102\114\117\103\x4b\x5f\111\x44"])) {
            $ie867f10dshfcr1babs["\111\x42\x4c\x4f\x43\113\137\x49\x44"] = array();
        }
        $ie867f10dshfcr1babs["\111\102\114\117\x43\113\137\111\104"] = (array) $ie867f10dshfcr1babs["\111\102\x4c\117\103\x4b\x5f\x49\x44"];
        
        if (empty($ie867f10dshfcr1babs["\x49\x42\x4c\x4f\103\113\x5f\111\x44"])) {
            $iw5h3fvp0uok3i7vyw6ki = \VKapi\Market\Condition\IblockElementField::getIblockList();
            $ie867f10dshfcr1babs["\x49\102\114\x4f\103\113\137\111\104"] = array_keys($iw5h3fvp0uok3i7vyw6ki);
        }
        parent::__construct($ie867f10dshfcr1babs);
    }
    
    protected static function getMessage($asbbk09n38dkzicxcn196pxyy, $uorm4uhi = array())
    {
        return parent::getMessage("\x49\102\x4c\x4f\x43\113\x45\114\x45\115\x45\x4e\124\106\111\105\x4c\104\123\x2e" . $asbbk09n38dkzicxcn196pxyy, $uorm4uhi);
    }
    
    protected static function isInstalledCatalogModule()
    {
        static $fiwjzdakff;
        if (!isset($fiwjzdakff)) {
            $fiwjzdakff = \Bitrix\Main\Loader::includeModule("\143\x61\164\x61\x6c\157\x67");
        }
        return $fiwjzdakff;
    }
    
    public static function getIblockList()
    {
        static $iw5h3fvp0uok3i7vyw6ki;
        if (!isset($iw5h3fvp0uok3i7vyw6ki)) {
            \Bitrix\Main\Loader::includeModule("\x69\x62\x6c\157\x63\153");
            $ahva4gtr = \CIBlock::GetList(array("\x4e\101\x4d\105" => "\x41\x53\103"));
            while ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
                $iw5h3fvp0uok3i7vyw6ki[$k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\111\x44"]] = $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\116\x41\x4d\105"] . "\x20\x5b" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x49\x44"] . "\135";
            }
        }
        return $iw5h3fvp0uok3i7vyw6ki;
    }
    
    public function getInternalConditions()
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        if (!empty($this->arParams["\x49\x42\x4c\x4f\x43\113\137\111\x44"])) {
            $s2962 = \VKapi\Market\Condition\IblockElementField::getIblockList();
        }
        foreach ($this->arParams["\111\x42\114\x4f\103\113\137\x49\x44"] as $mxt5g) {
            foreach ($this->arExistsFields as $u5526mf8pwl3bod) {
                if (in_array($u5526mf8pwl3bod, array("\103\x52\105\101\x54\x45\x44\137\102\131", "\x4d\117\104\x49\106\x49\105\104\137\102\x59"))) {
                    $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\116\x54\x52\117\114\x5f\x54\x45\130\x54", array("\43\116\101\115\105\x23" => self::getMessage($u5526mf8pwl3bod), "\x23\111\x42\114\x4f\x43\113\137\x4e\101\x4d\105\43" => $s2962[$mxt5g]))), new \VKapi\Market\Condition\Control\Logic("\x63\157\x6e\144\x69\164\x69\x6f\x6e", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\166\141\154\x75\145"));
                } elseif (in_array($u5526mf8pwl3bod, array("\101\103\124\x49\126\x45\137\104\101\124\105", "\101\103\124\111\x56\x45"))) {
                    $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\x4e\x54\122\x4f\114\137\124\105\x58\124", array("\x23\116\101\x4d\105\x23" => self::getMessage($u5526mf8pwl3bod), "\x23\111\102\114\117\103\113\x5f\116\101\x4d\105\43" => $s2962[$mxt5g]))), new \VKapi\Market\Condition\Control\Logic("\143\x6f\156\144\x69\x74\151\157\156", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Select("\166\141\154\x75\x65", array("\x59" => self::getMessage("\131\105\123"), "\116" => self::getMessage("\116\x4f"))));
                } elseif ($u5526mf8pwl3bod == "\x49\102\x4c\117\x43\113\137\123\x45\x43\x54\x49\117\x4e\x5f\111\104") {
                    $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\116\124\122\x4f\114\137\x54\105\130\x54", array("\43\x4e\101\115\105\43" => self::getMessage($u5526mf8pwl3bod), "\x23\111\102\114\117\103\x4b\137\x4e\x41\115\105\43" => $s2962[$mxt5g]))), new \VKapi\Market\Condition\Control\Logic("\x63\x6f\156\x64\151\164\151\157\x6e", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\IblockSectionFind("\166\x61\154\165\x65"));
                } elseif (in_array($u5526mf8pwl3bod, array("\x44\101\x54\105\137\103\x52\105\x41\x54\x45", "\124\x49\x4d\105\123\x54\101\115\120\x5f\130", "\104\x41\x54\x45\x5f\101\103\x54\x49\126\x45\x5f\106\122\117\x4d", "\104\101\124\105\x5f\x41\103\124\111\x56\105\137\x54\117"))) {
                    $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\x4e\x54\x52\117\x4c\x5f\x54\105\x58\124", array("\43\x4e\101\115\x45\x23" => self::getMessage($u5526mf8pwl3bod), "\x23\x49\x42\114\x4f\x43\113\137\x4e\101\115\x45\43" => $s2962[$mxt5g]))), new \VKapi\Market\Condition\Control\Logic("\x63\157\x6e\x64\x69\164\x69\x6f\156", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::MORE, \VKapi\Market\Condition\Control\Logic::MORE_EQUAL, \VKapi\Market\Condition\Control\Logic::LESS, \VKapi\Market\Condition\Control\Logic::LESS_EQUAL), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Calendar("\166\x61\x6c\165\x65"));
                } else {
                    $x2ddfkh5mn4ar98v = array(new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\116\x54\x52\x4f\114\137\x54\105\130\124", array("\43\x4e\x41\x4d\105\x23" => self::getMessage($u5526mf8pwl3bod), "\43\x49\x42\114\117\103\x4b\x5f\116\101\x4d\x45\x23" => $s2962[$mxt5g]))), new \VKapi\Market\Condition\Control\Logic("\143\157\x6e\x64\x69\164\x69\157\x6e", array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::HAS, \VKapi\Market\Condition\Control\Logic::NOT_HAS, \VKapi\Market\Condition\Control\Logic::START, \VKapi\Market\Condition\Control\Logic::END), \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\x76\x61\x6c\x75\145"));
                }
                $gicuvkskpuwr53xgm3ud8u3eup[] = array("\x69\x64" => $u5526mf8pwl3bod . "\137" . $mxt5g, "\x6e\x61\x6d\x65" => self::getMessage($u5526mf8pwl3bod, array("\43\x49\x42\x4c\117\103\113\x5f\116\x41\115\x45\43" => $s2962[$mxt5g])), "\147\x72\x6f\165\x70" => str_replace(array("\x23\111\x42\x4c\x4f\103\113\137\116\x41\115\x45\43"), array($s2962[$mxt5g]), $this->groupLabel), "\x63\157\155\160\x6f\x6e\145\156\164" => "\166\153\141\x70\x69\55\x6d\141\162\x6b\145\x74\x2d\x63\157\x6e\x64\x69\x74\x69\157\156\55\x69\142\x6c\157\x63\153\55\145\x6c\x65\x6d\145\156\164\x2d\146\151\145\154\144", "\143\x6f\x6e\164\x72\157\x6c\163" => $x2ddfkh5mn4ar98v, "\160\x61\x72\141\155\x73" => array("\x69\142\154\157\x63\153\111\144" => $mxt5g), "\x6d\x6f\x72\x65" => array());
            }
        }
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
    
    public static function getEval($ofwy2g)
    {
        $tutcd4vbdyep83sm3ft = array();
        $bk38shxx = $ofwy2g["\151\x64"];
        $sdsogn5zv5oxzyyfj8nuw71egkf = $ofwy2g["\x76\x61\x6c\165\x65\x73"]["\143\x6f\156\x64\151\164\151\157\156"];
        $neueels6 = str_replace("\x22", "\x5c\42", $ofwy2g["\166\x61\x6c\x75\x65\x73"]["\166\x61\154\165\145"]);
        switch (preg_replace("\x2f\x28\x5f\x5c\144\53\x29\x24\x2f", "", $bk38shxx)) {
            case "\x43\122\x45\101\124\105\x44\x5f\102\x59":
            case "\115\117\104\111\x46\x49\x45\x44\137\102\131":
                if (in_array($sdsogn5zv5oxzyyfj8nuw71egkf, array(\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL))) {
                    return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
            case "\101\x43\124\x49\x56\x45\x5f\x44\x41\124\105":
            case "\x41\103\x54\x49\126\x45":
            case "\x49\x42\x4c\x4f\x43\113\x5f\x53\105\103\124\111\117\116\x5f\111\104":
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
            case "\104\101\124\x45\x5f\x43\x52\105\x41\x54\105":
            case "\x54\x49\115\105\x53\x54\x41\x4d\x50\137\x58":
            case "\104\x41\x54\x45\137\101\103\x54\x49\126\x45\137\x46\122\x4f\x4d":
            case "\104\101\124\x45\x5f\101\x43\x54\x49\x56\x45\137\124\x4f":
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
            case "\x43\117\104\105":
            case "\130\115\x4c\x5f\x49\x44":
            case "\x4e\x41\115\x45":
            case "\x53\117\x52\x54":
            case "\x50\122\105\x56\x49\105\x57\137\x54\105\x58\x54":
            case "\104\x45\x54\101\111\114\x5f\x54\x45\130\x54":
            case "\x54\101\107\123":
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::HAS:
                    case \VKapi\Market\Condition\Control\Logic::NOT_HAS:
                    case \VKapi\Market\Condition\Control\Logic::START:
                    case \VKapi\Market\Condition\Control\Logic::END:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
            default:
                return 0;
        }
    }
    
    public function getPrepiredValuePreview($c4gg2x9j0av)
    {
        $cut6l2dhn8rl39sr0eh9q5q41 = $c4gg2x9j0av["\166\x61\154\165\145\x73"];
        
        if (preg_replace("\x2f\50\x5f\134\144\53\x29\44\x2f", "", $c4gg2x9j0av["\x69\144"]) == "\111\x42\x4c\117\103\113\x5f\x53\x45\x43\x54\x49\117\x4e\137\x49\104") {
            if (intval($cut6l2dhn8rl39sr0eh9q5q41["\x76\141\154\x75\145"])) {
                if ($so30iwevyy0980b2l2iwu5w = \CIBlockSection::GetByID(intval($cut6l2dhn8rl39sr0eh9q5q41["\166\x61\x6c\165\x65"]))->fetch()) {
                    $cut6l2dhn8rl39sr0eh9q5q41["\x76\x61\x6c\x75\x65\x50\162\x65\x76\x69\x65\167"] = $so30iwevyy0980b2l2iwu5w["\116\x41\x4d\105"] . "\x20\133" . $so30iwevyy0980b2l2iwu5w["\111\104"] . "\x5d";
                }
            }
        }
        return $cut6l2dhn8rl39sr0eh9q5q41;
    }
}
?>