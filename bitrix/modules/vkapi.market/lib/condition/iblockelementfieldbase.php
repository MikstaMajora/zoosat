<?php

namespace VKapi\Market\Condition;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use VKapi\Market\Condition\Control\Logic;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class IblockElementFieldBase extends \VKapi\Market\Condition\Base
{
    private $arExistsFields = ["\x49\x53\x5f\117\106\x46\x45\x52", "\111\104", "\x49\x42\x4c\117\x43\113\137\x49\x44", "\111\102\114\x4f\x43\x4b\137\x53\x45\x43\x54\111\117\x4e\137\x49\x44", "\103\117\x44\x45", "\x58\x4d\114\137\x49\x44", "\x4e\101\x4d\x45", "\x41\103\x54\111\126\x45", "\101\x43\x54\x49\x56\x45\137\x44\101\124\105", "\x44\x41\x54\x45\137\x41\103\x54\x49\126\105\x5f\x46\122\x4f\115", "\104\x41\x54\x45\x5f\101\103\124\111\126\x45\137\124\117", "\x53\117\122\x54", "\120\x52\x45\x56\111\105\127\137\x54\x45\x58\x54", "\x44\x45\x54\101\x49\x4c\x5f\124\105\130\x54", "\x44\101\x54\105\x5f\103\122\105\101\x54\x45", "\x43\x52\105\x41\x54\x45\104\x5f\102\x59", "\124\x49\115\x45\x53\x54\x41\x4d\x50\x5f\x58", "\x4d\117\104\111\106\111\x45\x44\x5f\x42\x59", "\124\101\107\123"];
    private $groupLabel = "";
    public function __construct($ie867f10dshfcr1babs = [])
    {
        
        $this->groupLabel = self::getMessage("\107\122\x4f\x55\x50\x5f\114\101\102\105\x4c");
        if (isset($ie867f10dshfcr1babs["\114\x41\102\x45\x4c"])) {
            $this->groupLabel = $ie867f10dshfcr1babs["\x4c\x41\102\x45\x4c"];
        }
        parent::__construct($ie867f10dshfcr1babs);
    }
    
    protected static function getMessage($asbbk09n38dkzicxcn196pxyy, $uorm4uhi = [])
    {
        return parent::getMessage("\111\x42\x4c\x4f\x43\x4b\105\114\105\x4d\105\x4e\124\x46\x49\x45\x4c\104\123\x42\x41\x53\105\x2e" . $asbbk09n38dkzicxcn196pxyy, $uorm4uhi);
    }
    
    public static function getIblockList()
    {
        static $iw5h3fvp0uok3i7vyw6ki;
        if (!isset($iw5h3fvp0uok3i7vyw6ki)) {
            \Bitrix\Main\Loader::includeModule("\151\x62\x6c\157\143\x6b");
            $ahva4gtr = \CIBlock::GetList(["\x4e\101\x4d\x45" => "\101\123\103"]);
            while ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
                $iw5h3fvp0uok3i7vyw6ki[$k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x49\104"]] = $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\116\101\x4d\105"] . "\40\133" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x49\104"] . "\x5d";
            }
        }
        return $iw5h3fvp0uok3i7vyw6ki;
    }
    
    public function getInternalConditions()
    {
        $gicuvkskpuwr53xgm3ud8u3eup = [];
        foreach ($this->arExistsFields as $u5526mf8pwl3bod) {
            if (in_array($u5526mf8pwl3bod, ["\111\104", "\103\x52\105\101\124\x45\104\x5f\102\131", "\115\117\104\x49\x46\111\x45\x44\x5f\x42\131"])) {
                $x2ddfkh5mn4ar98v = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\116\124\x52\117\x4c\137\124\x45\130\124", ["\43\x4e\x41\x4d\x45\43" => self::getMessage($u5526mf8pwl3bod)])), new \VKapi\Market\Condition\Control\Logic("\143\157\x6e\144\151\164\x69\157\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\166\x61\154\x75\145")];
            } elseif (in_array($u5526mf8pwl3bod, ["\x49\123\x5f\117\106\x46\x45\x52", "\101\x43\x54\111\x56\105\137\x44\x41\124\105", "\101\103\x54\111\x56\x45"])) {
                $x2ddfkh5mn4ar98v = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\116\x54\122\117\114\x5f\x54\105\130\124", ["\x23\x4e\101\x4d\105\x23" => self::getMessage($u5526mf8pwl3bod)])), new \VKapi\Market\Condition\Control\Logic("\x63\157\156\144\x69\164\x69\x6f\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Select("\166\x61\x6c\x75\x65", ["\x59" => self::getMessage("\x59\x45\x53"), "\116" => self::getMessage("\x4e\x4f")])];
            } elseif ($u5526mf8pwl3bod == "\111\x42\x4c\117\x43\x4b\137\111\x44") {
                $x2ddfkh5mn4ar98v = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\x4e\124\x52\117\114\137\x54\105\130\x54", ["\x23\116\101\x4d\x45\x23" => self::getMessage($u5526mf8pwl3bod)])), new \VKapi\Market\Condition\Control\Logic("\x63\157\x6e\144\x69\164\151\x6f\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Select("\166\x61\x6c\165\x65", self::getIblockList(), "", true)];
            } elseif ($u5526mf8pwl3bod == "\x49\102\114\x4f\x43\113\137\123\105\103\124\x49\117\x4e\137\111\104") {
                $x2ddfkh5mn4ar98v = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\116\124\x52\x4f\114\137\124\105\x58\x54", ["\x23\x4e\101\x4d\x45\43" => self::getMessage($u5526mf8pwl3bod)])), new \VKapi\Market\Condition\Control\Logic("\x63\157\156\x64\x69\164\x69\157\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\IblockSectionFind("\x76\x61\x6c\165\x65")];
            } elseif (in_array($u5526mf8pwl3bod, ["\x44\x41\124\x45\x5f\103\x52\x45\x41\x54\x45", "\124\x49\x4d\105\x53\x54\101\115\120\137\x58", "\x44\x41\124\x45\137\101\103\x54\x49\x56\x45\137\106\x52\x4f\x4d", "\104\x41\x54\x45\137\x41\103\124\x49\x56\x45\x5f\124\117"])) {
                $x2ddfkh5mn4ar98v = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\x4e\x54\122\x4f\x4c\x5f\124\x45\x58\x54", ["\43\x4e\x41\x4d\105\43" => self::getMessage($u5526mf8pwl3bod)])), new \VKapi\Market\Condition\Control\Logic("\x63\x6f\156\144\151\x74\x69\157\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::MORE, \VKapi\Market\Condition\Control\Logic::MORE_EQUAL, \VKapi\Market\Condition\Control\Logic::LESS, \VKapi\Market\Condition\Control\Logic::LESS_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Calendar("\166\141\154\165\145")];
            } else {
                $x2ddfkh5mn4ar98v = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\117\x4e\x54\x52\117\114\137\x54\x45\130\124", ["\43\x4e\x41\x4d\105\43" => self::getMessage($u5526mf8pwl3bod)])), new \VKapi\Market\Condition\Control\Logic("\143\157\x6e\x64\x69\164\x69\x6f\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL, \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::HAS, \VKapi\Market\Condition\Control\Logic::NOT_HAS, \VKapi\Market\Condition\Control\Logic::START, \VKapi\Market\Condition\Control\Logic::END], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\x76\x61\x6c\165\145")];
            }
            $gicuvkskpuwr53xgm3ud8u3eup[] = ["\151\x64" => $u5526mf8pwl3bod, "\156\141\x6d\145" => self::getMessage($u5526mf8pwl3bod), "\147\x72\x6f\x75\x70" => $this->groupLabel, "\143\157\x6d\160\x6f\156\145\156\164" => "\166\x6b\141\160\151\x2d\x6d\141\162\153\145\164\x2d\143\157\x6e\x64\x69\x74\151\157\x6e\x2d\x69\x62\x6c\157\x63\153\55\x65\154\145\155\x65\156\164\55\146\151\145\154\144\55\x62\141\163\x65", "\143\x6f\x6e\164\162\157\154\x73" => $x2ddfkh5mn4ar98v, "\x70\141\162\x61\155\x73" => [], "\155\157\162\145" => []];
        }
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
    
    public static function getEval($ofwy2g)
    {
        $tutcd4vbdyep83sm3ft = [];
        $bk38shxx = $ofwy2g["\x69\x64"];
        $sdsogn5zv5oxzyyfj8nuw71egkf = $ofwy2g["\166\141\154\165\145\x73"]["\143\x6f\156\144\151\x74\x69\x6f\x6e"];
        $neueels6 = str_replace("\x22", "\x5c\x22", $ofwy2g["\166\141\x6c\165\145\x73"]["\x76\141\x6c\x75\x65"]);
        switch ($bk38shxx) {
            case "\x49\x44":
            case "\111\x42\114\117\103\x4b\137\111\x44":
            case "\x43\122\105\x41\x54\105\104\137\x42\131":
            case "\115\117\104\111\106\x49\x45\104\x5f\x42\131":
            case "\x41\103\x54\x49\x56\105\x5f\x44\101\124\105":
            case "\x41\x43\x54\111\x56\x45":
            case "\x49\x53\137\x4f\106\106\105\122":
            case "\111\x42\x4c\117\103\x4b\137\x53\x45\x43\x54\x49\x4f\116\x5f\x49\104":
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
            case "\x44\101\124\x45\x5f\103\122\x45\101\124\105":
            case "\x54\x49\x4d\105\123\124\x41\115\120\x5f\x58":
            case "\104\101\x54\105\x5f\101\103\124\x49\x56\105\x5f\x46\x52\117\x4d":
            case "\x44\x41\x54\105\x5f\x41\103\x54\111\126\x45\x5f\124\x4f":
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::MORE:
                    case \VKapi\Market\Condition\Control\Logic::MORE_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::LESS:
                    case \VKapi\Market\Condition\Control\Logic::LESS_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($sdsogn5zv5oxzyyfj8nuw71egkf, $bk38shxx, $neueels6);
                }
                break;
            case "\x43\117\104\105":
            case "\130\115\114\x5f\x49\x44":
            case "\x4e\101\115\x45":
            case "\123\x4f\x52\124":
            case "\x50\x52\105\126\x49\x45\x57\x5f\x54\x45\x58\124":
            case "\104\105\x54\x41\111\114\x5f\124\x45\130\124":
            case "\124\101\107\x53":
                switch ($sdsogn5zv5oxzyyfj8nuw71egkf) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::STRICT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::STRICT_NOT_EQUAL:
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
        $cut6l2dhn8rl39sr0eh9q5q41 = $c4gg2x9j0av["\166\141\154\165\145\x73"];
        
        if ($c4gg2x9j0av["\151\x64"] == "\111\102\114\x4f\x43\113\137\x53\105\x43\x54\x49\117\116\x5f\111\x44") {
            if (intval($cut6l2dhn8rl39sr0eh9q5q41["\x76\x61\x6c\165\145"])) {
                if ($so30iwevyy0980b2l2iwu5w = \CIBlockSection::GetByID(intval($cut6l2dhn8rl39sr0eh9q5q41["\x76\141\x6c\165\x65"]))->fetch()) {
                    $cut6l2dhn8rl39sr0eh9q5q41["\166\x61\x6c\x75\145\x50\x72\145\166\x69\145\x77"] = $so30iwevyy0980b2l2iwu5w["\x4e\x41\115\105"] . "\40\x5b" . $so30iwevyy0980b2l2iwu5w["\111\x44"] . "\x5d";
                }
            }
        }
        return $cut6l2dhn8rl39sr0eh9q5q41;
    }
}
?>