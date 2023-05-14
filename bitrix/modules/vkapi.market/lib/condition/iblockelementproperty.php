<?php

namespace VKapi\Market\Condition;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use VKapi\Market\Condition\Control\Logic;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class IblockElementProperty extends \VKapi\Market\Condition\Base
{
    const PROPERTY_TYPE_NUMBER = "\116";
    const PROPERTY_TYPE_STRING = "\123";
    const PROPERTY_TYPE_LIST = "\114";
    const PROPERTY_TYPE_FILE = "\106";
    const PROPERTY_TYPE_GROUP = "\x47";
    const PROPERTY_TYPE_ELEMENT = "\x45";
    static $arPropertyList = null;
    public function __construct($d7ehh2y5bzg6iinj2ko48a5el = [])
    {
        
        if (!isset($d7ehh2y5bzg6iinj2ko48a5el["\111\x42\x4c\x4f\103\x4b\137\x49\x44"])) {
            $d7ehh2y5bzg6iinj2ko48a5el["\x49\102\x4c\117\103\113\137\111\104"] = [];
        }
        $d7ehh2y5bzg6iinj2ko48a5el["\111\x42\x4c\x4f\103\113\x5f\x49\104"] = (array) $d7ehh2y5bzg6iinj2ko48a5el["\x49\x42\114\117\103\113\137\x49\x44"];
        
        if (empty($d7ehh2y5bzg6iinj2ko48a5el["\111\102\114\117\x43\x4b\137\111\104"])) {
            $t8juu22t2ba = \VKapi\Market\Condition\IblockElementField::getIblockList();
            $d7ehh2y5bzg6iinj2ko48a5el["\111\102\x4c\117\103\x4b\137\x49\x44"] = array_keys($t8juu22t2ba);
        }
        parent::__construct($d7ehh2y5bzg6iinj2ko48a5el);
    }
    
    protected static function getMessage($lyj55b11, $g0vvyjqpj = [])
    {
        return parent::getMessage("\111\x42\x4c\x4f\103\x4b\105\x4c\x45\x4d\x45\x4e\124\120\x52\117\120\x45\x52\x54\131\56" . $lyj55b11, $g0vvyjqpj);
    }
    
    public static function getPropertyList()
    {
        if (is_null(self::$arPropertyList)) {
            self::$arPropertyList = [];
            if (!\Bitrix\Main\Loader::includeModule("\x69\142\154\x6f\x63\x6b")) {
                return self::$arPropertyList;
            }
            
            $jag5b7amwhzfyw6pqe53ktxhhhw2k0on3v = \CIBlockProperty::GetList(["\111\x42\x4c\x4f\103\x4b\137\111\x44" => "\x41\x53\103", "\116\x41\115\x45" => "\x41\123\x43"]);
            while ($ai23qv6m8mljj5 = $jag5b7amwhzfyw6pqe53ktxhhhw2k0on3v->fetch()) {
                self::$arPropertyList["\120\x52\x4f\120\105\122\124\131\137" . $ai23qv6m8mljj5["\111\x44"]] = ["\111\x44" => $ai23qv6m8mljj5["\111\x44"], "\111\102\114\x4f\103\113\x5f\x49\104" => $ai23qv6m8mljj5["\x49\x42\x4c\117\103\113\x5f\111\104"], "\116\x41\x4d\105" => $ai23qv6m8mljj5["\116\x41\x4d\x45"], "\x43\x4f\x44\105" => $ai23qv6m8mljj5["\103\117\104\105"], "\x50\122\117\x50\x45\x52\x54\131\x5f\124\131\x50\x45" => $ai23qv6m8mljj5["\x50\122\117\x50\x45\x52\x54\x59\137\124\x59\x50\105"], "\125\123\105\x52\x5f\x54\131\x50\105" => $ai23qv6m8mljj5["\x55\123\x45\x52\137\x54\x59\x50\105"], "\125\123\x45\x52\137\124\x59\120\105\137\x53\x45\x54\124\x49\x4e\x47\123" => $ai23qv6m8mljj5["\125\123\105\122\x5f\x54\x59\120\x45\x5f\x53\x45\x54\124\x49\x4e\107\123"], "\114\111\116\113\x5f\111\102\114\x4f\x43\x4b\137\x49\104" => $ai23qv6m8mljj5["\x4c\x49\116\x4b\x5f\111\x42\x4c\x4f\103\113\137\111\104"]];
            }
        }
        return self::$arPropertyList;
    }
    
    public function getInternalConditions()
    {
        $mxpuzs1vfk0qkacrsikertukb = [];
        $rd0f280c2apj1 = self::getPropertyList();
        if (!empty($this->arParams["\111\x42\114\117\103\113\137\x49\104"])) {
            $tzso8kajn = \VKapi\Market\Condition\IblockElementField::getIblockList();
        }
        foreach ($rd0f280c2apj1 as $xx3pln3z2c7wlg796uk3kn6fehe9er => $rz3hi0kjym5skorx0m5z) {
            if (!in_array($rz3hi0kjym5skorx0m5z["\111\x42\x4c\117\103\113\x5f\111\x44"], $this->arParams["\x49\x42\114\117\103\x4b\137\x49\x44"])) {
                continue;
            }
            switch ($rz3hi0kjym5skorx0m5z["\120\122\x4f\120\105\x52\124\131\137\124\131\120\x45"]) {
                case self::PROPERTY_TYPE_LIST:
                    $uwlf29b0xrxom6o869mhxjwq3784 = new \VKapi\Market\Condition\Control\SelectPropertyEnum("\166\x61\x6c\165\x65", $rz3hi0kjym5skorx0m5z["\x49\x44"]);
                    $uwlf29b0xrxom6o869mhxjwq3784->enableSearch();
                    $uwlf29b0xrxom6o869mhxjwq3784->setAjaxValues("\x2f\142\x69\164\x72\151\170\x2f\x74\157\157\x6c\x73\57\x76\153\141\x70\x69\x2e\155\141\162\153\x65\164\x2f\141\x6a\141\170\x2e\x70\x68\x70\x3f\155\x65\164\150\x6f\x64\75\147\x65\164\111\142\x6c\157\x63\x6b\120\x72\x6f\160\145\162\x74\x79\x45\156\165\x6d\x4c\151\x73\x74\x26\x69\x62\x6c\x6f\143\153\x49\x64\75" . $rz3hi0kjym5skorx0m5z["\x49\102\x4c\117\x43\x4b\x5f\111\x44"] . "\x26\x70\x72\x6f\160\145\x72\164\171\111\x64\75" . $rz3hi0kjym5skorx0m5z["\x49\x44"]);
                    $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\117\x4e\124\x52\117\114\x5f\124\105\130\x54", ["\43\116\101\115\105\43" => $rz3hi0kjym5skorx0m5z["\x4e\x41\115\105"], "\43\103\x4f\104\105\x23" => $rz3hi0kjym5skorx0m5z["\x43\x4f\x44\x45"], "\x23\111\x44\x23" => $rz3hi0kjym5skorx0m5z["\x49\x44"], "\x23\x49\102\114\117\103\x4b\x5f\116\x41\115\x45\x23" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\x49\x42\x4c\x4f\x43\113\x5f\x49\104"]]])), new \VKapi\Market\Condition\Control\Logic("\x63\x6f\x6e\144\151\x74\x69\157\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), $uwlf29b0xrxom6o869mhxjwq3784];
                    break;
                case self::PROPERTY_TYPE_FILE:
                case self::PROPERTY_TYPE_NUMBER:
                    $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\x4e\x54\122\117\114\137\124\x45\x58\124", ["\x23\x4e\x41\x4d\105\x23" => $rz3hi0kjym5skorx0m5z["\x4e\101\x4d\105"], "\x23\103\x4f\x44\105\43" => $rz3hi0kjym5skorx0m5z["\x43\117\104\105"], "\43\111\x44\43" => $rz3hi0kjym5skorx0m5z["\x49\x44"], "\x23\111\102\114\117\x43\113\137\116\101\115\x45\x23" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\x49\x42\114\x4f\103\x4b\137\x49\104"]]])), new \VKapi\Market\Condition\Control\Logic("\x63\157\x6e\144\151\x74\151\157\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::MORE, \VKapi\Market\Condition\Control\Logic::MORE_EQUAL, \VKapi\Market\Condition\Control\Logic::LESS, \VKapi\Market\Condition\Control\Logic::LESS_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\166\x61\154\165\x65")];
                    break;
                case self::PROPERTY_TYPE_ELEMENT:
                    $j26wsmn2m35xcx3h4ca7q3 = new \VKapi\Market\Condition\Control\IblockElementFind("\166\x61\154\x75\x65");
                    $j26wsmn2m35xcx3h4ca7q3->setIblockId($rz3hi0kjym5skorx0m5z["\x4c\x49\x4e\113\137\111\102\x4c\x4f\103\113\137\111\x44"]);
                    $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\117\116\x54\x52\117\114\x5f\124\x45\130\x54", ["\x23\116\101\115\105\43" => $rz3hi0kjym5skorx0m5z["\x4e\x41\x4d\x45"], "\43\x43\117\104\x45\43" => $rz3hi0kjym5skorx0m5z["\103\x4f\x44\x45"], "\43\x49\104\43" => $rz3hi0kjym5skorx0m5z["\111\104"], "\43\111\102\x4c\x4f\103\113\137\x4e\101\x4d\x45\43" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\x49\x42\114\x4f\x43\113\137\x49\x44"]]])), new \VKapi\Market\Condition\Control\Logic("\x63\x6f\156\144\151\x74\x69\x6f\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), $j26wsmn2m35xcx3h4ca7q3];
                    break;
                case self::PROPERTY_TYPE_GROUP:
                    $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\x4e\124\x52\x4f\x4c\137\x54\x45\130\x54", ["\x23\116\101\x4d\105\43" => $rz3hi0kjym5skorx0m5z["\116\101\x4d\105"], "\43\x43\x4f\104\105\x23" => $rz3hi0kjym5skorx0m5z["\x43\x4f\x44\x45"], "\43\x49\x44\43" => $rz3hi0kjym5skorx0m5z["\x49\104"], "\x23\111\102\114\x4f\x43\x4b\x5f\x4e\101\115\x45\x23" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\102\x4c\x4f\x43\x4b\137\x49\104"]]])), new \VKapi\Market\Condition\Control\Logic("\x63\x6f\156\144\x69\164\x69\x6f\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\IblockSectionFind("\x76\141\x6c\165\x65", null, $rz3hi0kjym5skorx0m5z["\114\111\x4e\113\137\111\x42\x4c\117\103\x4b\x5f\111\104"])];
                    break;
                case self::PROPERTY_TYPE_STRING:
                    switch ($rz3hi0kjym5skorx0m5z["\125\x53\x45\x52\x5f\124\131\120\105"]) {
                        
                        case "\x55\x73\145\x72\111\x44":
                            $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\103\x4f\x4e\124\x52\117\x4c\137\124\105\130\124", ["\43\x4e\101\115\105\x23" => $rz3hi0kjym5skorx0m5z["\x4e\101\x4d\105"], "\x23\103\117\x44\x45\43" => $rz3hi0kjym5skorx0m5z["\x43\x4f\104\x45"], "\43\x49\104\43" => $rz3hi0kjym5skorx0m5z["\x49\104"], "\43\x49\x42\x4c\x4f\x43\113\x5f\x4e\x41\x4d\105\43" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\102\x4c\117\103\113\x5f\111\104"]]])), new \VKapi\Market\Condition\Control\Logic("\x63\157\x6e\x64\151\164\x69\157\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\x76\x61\154\x75\x65")];
                            break;
                        
                        case "\104\141\x74\x65\x54\x69\155\145":
                        case "\104\x61\164\x65":
                            $b06wh184ry = new \VKapi\Market\Condition\Control\Calendar("\x76\141\x6c\165\x65");
                            $b06wh184ry->setShowTime($rz3hi0kjym5skorx0m5z["\125\123\x45\122\x5f\x54\131\120\105"] == "\104\141\164\x65\124\x69\x6d\145");
                            $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\x4f\x4e\x54\x52\117\114\137\124\105\x58\x54", ["\x23\116\x41\x4d\x45\43" => $rz3hi0kjym5skorx0m5z["\116\x41\x4d\x45"], "\43\103\117\x44\105\x23" => $rz3hi0kjym5skorx0m5z["\x43\x4f\x44\x45"], "\43\x49\x44\43" => $rz3hi0kjym5skorx0m5z["\x49\x44"], "\x23\x49\102\114\x4f\103\x4b\137\116\x41\115\x45\x23" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\x42\x4c\x4f\103\x4b\x5f\111\104"]]])), new \VKapi\Market\Condition\Control\Logic("\143\x6f\x6e\x64\x69\x74\x69\x6f\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::MORE, \VKapi\Market\Condition\Control\Logic::MORE_EQUAL, \VKapi\Market\Condition\Control\Logic::LESS, \VKapi\Market\Condition\Control\Logic::LESS_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), $b06wh184ry];
                            break;
                        
                        case "\105\x6c\145\155\145\156\164\x58\155\x6c\111\104":
                            $j26wsmn2m35xcx3h4ca7q3 = new \VKapi\Market\Condition\Control\IblockElementFind("\x76\141\154\165\145");
                            $j26wsmn2m35xcx3h4ca7q3->setSearchXmlId();
                            $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\117\x4e\124\122\117\114\x5f\x54\x45\130\x54", ["\x23\x4e\101\x4d\x45\x23" => $rz3hi0kjym5skorx0m5z["\x4e\101\x4d\x45"], "\43\103\x4f\104\105\43" => $rz3hi0kjym5skorx0m5z["\x43\117\104\x45"], "\43\111\104\x23" => $rz3hi0kjym5skorx0m5z["\111\104"], "\x23\111\x42\x4c\x4f\103\113\137\116\101\115\x45\x23" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\x42\114\x4f\x43\x4b\137\x49\104"]]])), new \VKapi\Market\Condition\Control\Logic("\x63\157\156\x64\x69\x74\151\x6f\156", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), $j26wsmn2m35xcx3h4ca7q3];
                            break;
                        
                        case "\x64\151\162\145\x63\164\157\162\171":
                            $uwlf29b0xrxom6o869mhxjwq3784 = new \VKapi\Market\Condition\Control\SelectHighloadBlock("\x76\x61\x6c\165\x65", $rz3hi0kjym5skorx0m5z["\125\x53\105\x52\137\124\x59\120\105\x5f\x53\x45\x54\x54\x49\116\x47\123"]["\124\101\x42\114\105\x5f\x4e\101\x4d\x45"]);
                            $uwlf29b0xrxom6o869mhxjwq3784->enableSearch();
                            $uwlf29b0xrxom6o869mhxjwq3784->setAjaxValues("\x2f\142\151\164\162\x69\x78\57\x74\157\157\x6c\163\x2f\x76\x6b\141\160\x69\56\155\x61\x72\x6b\145\164\x2f\x61\152\141\x78\x2e\x70\150\160\x3f\x6d\x65\164\150\x6f\x64\x3d\x67\145\164\110\151\147\150\154\157\141\x64\102\x6c\x6f\143\x6b\126\x61\x6c\165\x65\x4c\151\163\164\x26\x74\141\142\154\x65\x4e\141\x6d\x65\75" . $rz3hi0kjym5skorx0m5z["\x55\123\105\122\x5f\x54\131\x50\105\137\123\x45\124\x54\x49\116\107\123"]["\x54\x41\102\x4c\105\x5f\x4e\x41\x4d\105"]);
                            $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\117\116\x54\122\x4f\x4c\137\x54\105\130\x54", ["\x23\116\x41\x4d\x45\x23" => $rz3hi0kjym5skorx0m5z["\116\101\x4d\105"], "\43\x43\117\104\105\43" => $rz3hi0kjym5skorx0m5z["\x43\117\x44\105"], "\x23\111\104\43" => $rz3hi0kjym5skorx0m5z["\111\x44"], "\x23\x49\x42\x4c\117\103\x4b\137\x4e\x41\115\105\x23" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\102\x4c\x4f\103\x4b\137\x49\104"]]])), new \VKapi\Market\Condition\Control\Logic("\143\157\x6e\x64\x69\164\151\157\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL], \VKapi\Market\Condition\Control\Logic::EQUAL), $uwlf29b0xrxom6o869mhxjwq3784];
                            break;
                        default:
                            $mkp37xcmd17yegrfwfjogr = [new \VKapi\Market\Condition\Control\Prefix(self::getMessage("\x43\117\x4e\124\122\117\114\x5f\x54\105\x58\x54", ["\x23\116\101\115\x45\43" => $rz3hi0kjym5skorx0m5z["\x4e\x41\115\105"], "\43\103\117\104\x45\x23" => $rz3hi0kjym5skorx0m5z["\103\x4f\104\x45"], "\x23\111\104\43" => $rz3hi0kjym5skorx0m5z["\x49\104"], "\43\x49\x42\x4c\x4f\x43\113\x5f\116\101\115\105\43" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\102\114\117\x43\113\137\111\104"]]])), new \VKapi\Market\Condition\Control\Logic("\143\157\x6e\144\151\x74\151\x6f\x6e", [\VKapi\Market\Condition\Control\Logic::EQUAL, \VKapi\Market\Condition\Control\Logic::NOT_EQUAL, \VKapi\Market\Condition\Control\Logic::HAS, \VKapi\Market\Condition\Control\Logic::NOT_HAS, \VKapi\Market\Condition\Control\Logic::START, \VKapi\Market\Condition\Control\Logic::END], \VKapi\Market\Condition\Control\Logic::EQUAL), new \VKapi\Market\Condition\Control\Input("\166\141\154\165\x65")];
                    }
                    break;
            }
            
            $mxpuzs1vfk0qkacrsikertukb[] = ["\x69\144" => $xx3pln3z2c7wlg796uk3kn6fehe9er, "\156\x61\x6d\145" => self::getMessage("\x46\111\105\x4c\104\x5f\116\101\x4d\x45", ["\43\x4e\x41\x4d\105\x23" => $rz3hi0kjym5skorx0m5z["\x4e\101\x4d\105"], "\x23\x43\x4f\x44\105\43" => $rz3hi0kjym5skorx0m5z["\x43\x4f\x44\105"], "\x23\x49\104\x23" => $rz3hi0kjym5skorx0m5z["\111\104"], "\x23\x49\x42\x4c\117\103\x4b\137\x4e\x41\x4d\x45\43" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\x49\x42\x4c\117\x43\113\137\111\x44"]]]), "\x67\x72\x6f\x75\160" => self::getMessage("\107\x52\117\x55\x50\137\x4c\x41\x42\105\114", ["\x23\111\x42\x4c\117\x43\x4b\x5f\x4e\101\115\105\43" => $tzso8kajn[$rz3hi0kjym5skorx0m5z["\111\102\114\x4f\x43\113\x5f\x49\104"]]]), "\143\x6f\155\160\x6f\156\145\156\x74" => "\x76\x6b\141\160\x69\x2d\155\141\162\x6b\x65\164\55\143\157\156\144\151\x74\151\157\x6e\x2d\x69\x62\154\x6f\143\x6b\55\145\154\x65\x6d\x65\156\164\x2d\x70\162\x6f\160\145\162\164\171", "\x63\x6f\x6e\x74\x72\157\x6c\163" => $mkp37xcmd17yegrfwfjogr, "\x70\141\162\x61\x6d\x73" => ["\151\142\x6c\x6f\143\x6b\111\144" => $rz3hi0kjym5skorx0m5z["\x49\102\114\117\103\x4b\x5f\111\104"]], "\155\157\x72\x65" => []];
        }
        return $mxpuzs1vfk0qkacrsikertukb;
    }
    
    public static function getEval($vn46mlraxh5h5j3u21hp07tctx)
    {
        $me0y8ewo1wiyzshsyi9xft = $vn46mlraxh5h5j3u21hp07tctx["\151\x64"];
        $pcht2z75pio4 = $vn46mlraxh5h5j3u21hp07tctx["\166\x61\154\165\x65\x73"]["\x63\x6f\156\x64\151\164\x69\157\x6e"];
        $qtjcv4xt = str_replace("\x22", "\x5c\x22", $vn46mlraxh5h5j3u21hp07tctx["\x76\141\154\165\145\x73"]["\166\141\x6c\x75\145"]);
        $rd0f280c2apj1 = self::getPropertyList();
        $rz3hi0kjym5skorx0m5z = $rd0f280c2apj1[$me0y8ewo1wiyzshsyi9xft];
        switch ($rz3hi0kjym5skorx0m5z["\x50\122\x4f\120\x45\122\124\131\x5f\124\x59\120\x45"]) {
            case self::PROPERTY_TYPE_FILE:
            case self::PROPERTY_TYPE_NUMBER:
                switch ($pcht2z75pio4) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::MORE:
                    case \VKapi\Market\Condition\Control\Logic::MORE_EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::LESS:
                    case \VKapi\Market\Condition\Control\Logic::LESS_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($pcht2z75pio4, $me0y8ewo1wiyzshsyi9xft, $qtjcv4xt);
                }
                break;
            case self::PROPERTY_TYPE_ELEMENT:
            case self::PROPERTY_TYPE_LIST:
            case self::PROPERTY_TYPE_GROUP:
                switch ($pcht2z75pio4) {
                    case \VKapi\Market\Condition\Control\Logic::EQUAL:
                    case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                        return \VKapi\Market\Condition\Control\Logic::getEvalRule($pcht2z75pio4, $me0y8ewo1wiyzshsyi9xft, $qtjcv4xt);
                }
                break;
            case self::PROPERTY_TYPE_STRING:
                switch ($rz3hi0kjym5skorx0m5z["\x55\x53\x45\122\137\x54\131\x50\105"]) {
                    
                    case "\105\x6c\145\155\145\156\164\x58\x6d\x6c\111\x44":
                    
                    case "\x64\x69\162\145\x63\164\157\x72\171":
                    
                    case "\x55\x73\145\162\111\x44":
                        switch ($pcht2z75pio4) {
                            case \VKapi\Market\Condition\Control\Logic::EQUAL:
                            case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                                return \VKapi\Market\Condition\Control\Logic::getEvalRule($pcht2z75pio4, $me0y8ewo1wiyzshsyi9xft, $qtjcv4xt);
                        }
                        break;
                    
                    case "\x44\141\x74\145\x54\x69\x6d\x65":
                    
                    case "\104\x61\164\145":
                        switch ($pcht2z75pio4) {
                            case \VKapi\Market\Condition\Control\Logic::EQUAL:
                            case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                            case \VKapi\Market\Condition\Control\Logic::MORE:
                            case \VKapi\Market\Condition\Control\Logic::MORE_EQUAL:
                            case \VKapi\Market\Condition\Control\Logic::LESS:
                            case \VKapi\Market\Condition\Control\Logic::LESS_EQUAL:
                                return \VKapi\Market\Condition\Control\Logic::getEvalRule($pcht2z75pio4, $me0y8ewo1wiyzshsyi9xft, $qtjcv4xt);
                        }
                        break;
                    default:
                        switch ($pcht2z75pio4) {
                            case \VKapi\Market\Condition\Control\Logic::EQUAL:
                            case \VKapi\Market\Condition\Control\Logic::NOT_EQUAL:
                            case \VKapi\Market\Condition\Control\Logic::HAS:
                            case \VKapi\Market\Condition\Control\Logic::NOT_HAS:
                            case \VKapi\Market\Condition\Control\Logic::START:
                            case \VKapi\Market\Condition\Control\Logic::END:
                                return \VKapi\Market\Condition\Control\Logic::getEvalRule($pcht2z75pio4, $me0y8ewo1wiyzshsyi9xft, $qtjcv4xt);
                        }
                }
                break;
        }
        return 0;
    }
    
    public function getPrepiredValuePreview($n0gji71fibr5t3)
    {
        $gilnu8140ch8vo47iu4yt = $n0gji71fibr5t3["\x76\141\154\165\145\x73"];
        $rd0f280c2apj1 = self::getPropertyList();
        $rz3hi0kjym5skorx0m5z = $rd0f280c2apj1[$n0gji71fibr5t3["\x69\144"]];
        
        switch ($rz3hi0kjym5skorx0m5z["\120\122\117\x50\105\x52\124\x59\137\x54\x59\x50\x45"]) {
            case self::PROPERTY_TYPE_LIST:
                if ((int) $gilnu8140ch8vo47iu4yt["\166\141\x6c\x75\x65"]) {
                    if ($ypytx3gq = \CIBlockPropertyEnum::GetByID((int) $gilnu8140ch8vo47iu4yt["\166\x61\x6c\x75\x65"])) {
                        $gilnu8140ch8vo47iu4yt["\x76\141\x6c\x75\x65\120\x72\x65\166\151\x65\167"] = $ypytx3gq["\126\101\x4c\x55\x45"] . "\40\133" . $ypytx3gq["\x49\104"] . "\x5d";
                    }
                }
                break;
            case self::PROPERTY_TYPE_GROUP:
                if ((int) $gilnu8140ch8vo47iu4yt["\166\141\154\x75\145"]) {
                    if ($xaivki2 = \CIBlockSection::GetByID((int) $gilnu8140ch8vo47iu4yt["\x76\141\154\x75\x65"])->fetch()) {
                        $gilnu8140ch8vo47iu4yt["\166\x61\x6c\165\x65\120\162\145\x76\151\145\x77"] = $xaivki2["\x4e\x41\x4d\105"] . "\x20\133" . $xaivki2["\x49\104"] . "\135";
                    }
                }
                break;
            case self::PROPERTY_TYPE_ELEMENT:
                if ((int) $gilnu8140ch8vo47iu4yt["\166\x61\154\165\x65"]) {
                    if ($xaivki2 = \CIBlockElement::GetByID((int) $gilnu8140ch8vo47iu4yt["\166\141\154\165\145"])->fetch()) {
                        $gilnu8140ch8vo47iu4yt["\166\141\x6c\165\145\120\x72\x65\x76\151\x65\x77"] = $xaivki2["\x4e\x41\x4d\105"] . "\x20\x5b" . $xaivki2["\x49\x44"] . "\135";
                    }
                }
                break;
            case self::PROPERTY_TYPE_STRING:
                switch ($rz3hi0kjym5skorx0m5z["\125\x53\105\x52\x5f\124\131\x50\105"]) {
                    
                    case "\x45\x6c\x65\155\145\156\164\130\x6d\154\111\104":
                        if (trim($gilnu8140ch8vo47iu4yt["\x76\141\154\165\x65"]) !== "") {
                            $xj1xs71w0gvvgygwkdwvgj13oefgd56 = \CIBlockElement::GetList(["\x49\x44" => "\x41\123\x43"], ["\130\x4d\114\137\x49\x44" => trim($gilnu8140ch8vo47iu4yt["\x76\x61\154\165\145"])], false, ["\x6e\124\x6f\160\103\157\165\156\164" => 1], ["\x49\x44", "\116\x41\x4d\x45", "\x58\115\x4c\137\x49\104"]);
                            if ($xaivki2 = $xj1xs71w0gvvgygwkdwvgj13oefgd56->fetch()) {
                                $gilnu8140ch8vo47iu4yt["\x76\141\x6c\165\145\x50\162\x65\166\x69\145\x77"] = $xaivki2["\x4e\101\115\x45"] . "\x20\133" . $xaivki2["\130\x4d\114\137\x49\x44"] . "\135";
                            }
                        }
                        break;
                    case "\144\151\x72\x65\143\x74\157\162\x79":
                        
                        $g9xzf96fbfir05sfmneglhi9o61nuzg2 = \VKapi\Market\Manager::getInstance()->getHighloadBlockClassByTableName($rz3hi0kjym5skorx0m5z["\125\x53\105\122\137\124\x59\x50\x45\x5f\123\105\124\124\x49\x4e\x47\123"]["\x54\101\x42\x4c\105\x5f\x4e\x41\x4d\x45"]);
                        if (!is_null($g9xzf96fbfir05sfmneglhi9o61nuzg2)) {
                            $sc42mkbe7t5vs2233l = $g9xzf96fbfir05sfmneglhi9o61nuzg2::getEntity();
                            $yzuoxstfuj2vpytj0np9049immuets = ["\x49\104" => trim($gilnu8140ch8vo47iu4yt["\x76\x61\x6c\x75\x65"])];
                            if ($sc42mkbe7t5vs2233l->hasField("\125\x46\137\x58\x4d\x4c\x5f\x49\x44")) {
                                $yzuoxstfuj2vpytj0np9049immuets = ["\x55\106\137\x58\x4d\x4c\137\111\x44" => trim($gilnu8140ch8vo47iu4yt["\x76\x61\x6c\165\145"])];
                            }
                            $jag5b7amwhzfyw6pqe53ktxhhhw2k0on3v = $g9xzf96fbfir05sfmneglhi9o61nuzg2::getList(["\154\x69\155\x69\x74" => 1, "\146\x69\154\x74\x65\x72" => $yzuoxstfuj2vpytj0np9049immuets]);
                            if ($xaivki2 = $jag5b7amwhzfyw6pqe53ktxhhhw2k0on3v->fetch()) {
                                $gilnu8140ch8vo47iu4yt["\x76\x61\154\x75\x65\120\x72\145\166\x69\x65\167"] = $xaivki2["\x55\x46\137\x4e\x41\115\x45"] . "\40\x5b" . $xaivki2["\x49\x44"] . "\x5d";
                            }
                        }
                        break;
                }
                break;
        }
        return $gilnu8140ch8vo47iu4yt;
    }
}
?>