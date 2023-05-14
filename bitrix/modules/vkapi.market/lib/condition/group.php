<?php

namespace VKapi\Market\Condition;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Group extends \VKapi\Market\Condition\Base
{
    
    public static function getMessage($asbbk09n38dkzicxcn196pxyy, $uorm4uhi = array())
    {
        return parent::getMessage("\107\122\117\x55\x50\56" . $asbbk09n38dkzicxcn196pxyy, $uorm4uhi);
    }
    
    public function getInternalConditions()
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        $gicuvkskpuwr53xgm3ud8u3eup[] = array("\151\144" => "\x44\x45\x46\x41\125\x4c\x54", "\156\141\155\x65" => self::getMessage("\x4e\101\x4d\105"), "\x63\157\155\160\x6f\156\x65\156\x74" => "\166\x6b\141\x70\151\55\155\141\162\153\145\164\55\x63\157\156\x64\151\164\151\x6f\156\55\147\x72\157\x75\x70", "\143\157\156\x74\162\157\154\x73" => array(new \VKapi\Market\Condition\Control\Select("\141\147\x67\162\145\x67\141\164\x6f\x72", array("\x61\x6e\x64" => self::getMessage("\101\x4c\x4c\137\x43\x4f\x4e\104\x49\124\111\x4f\116"), "\x6f\x72" => self::getMessage("\x4f\x4e\105\x5f\x4f\x46\137\x43\117\116\104\x49\x54\x49\117\116")), "\x61\x6e\x64"), new \VKapi\Market\Condition\Control\Select("\x74\171\x70\145", array("\x74\x72\x75\x65" => self::getMessage("\x43\117\116\x44\111\124\x49\117\x4e\x53\x5f\124\x52\x55\x45"), "\x66\x61\x6c\x73\145" => self::getMessage("\103\x4f\x4e\x44\111\124\x49\117\x4e\123\x5f\106\101\114\123\105")), "\164\x72\165\145")), "\x70\x61\x72\x61\x6d\x73" => $this->getParams(), "\x6d\157\162\x65" => array("\x76\x69\163\165\x61\x6c" => array(array("\162\165\154\x65" => array("\x61\147\x67\x72\x65\147\x61\164\157\162" => "\x61\156\x64", "\164\171\x70\145" => "\x74\x72\x75\x65"), "\x63\x6c\x61\163\163" => "\x76\x6b\x61\160\x69\55\x6d\141\162\x6b\x65\x74\55\x63\x6f\156\x64\x69\164\x69\x6f\156\x2d\154\157\x67\x69\x63\x2d\55\141\x6e\x64\x2d\164\162\165\x65", "\164\145\170\x74" => self::getMessage("\x43\117\116\104\x49\x54\x49\117\116\123\x5f\114\x4f\x47\x49\103\137\x41\116\x44")), array("\162\x75\154\x65" => array("\x61\147\147\162\145\147\x61\x74\157\x72" => "\x6f\x72", "\164\171\160\145" => "\x74\x72\x75\145"), "\x63\x6c\x61\163\x73" => "\x76\x6b\x61\x70\151\55\155\x61\x72\153\145\164\x2d\x63\x6f\x6e\x64\x69\164\151\x6f\156\55\x6c\x6f\147\x69\143\x2d\55\x6f\x72\55\164\x72\x75\145", "\164\145\x78\x74" => self::getMessage("\103\117\116\104\111\x54\x49\117\x4e\x53\x5f\x4c\x4f\107\111\x43\x5f\x4f\x52")), array("\x72\165\x6c\x65" => array("\x61\147\x67\162\145\x67\x61\x74\x6f\x72" => "\x61\156\144", "\x74\171\x70\145" => "\146\141\154\163\145"), "\143\x6c\x61\x73\163" => "\166\153\x61\160\x69\55\x6d\141\162\x6b\145\164\55\143\157\156\144\151\164\151\157\156\55\x6c\x6f\x67\x69\x63\x2d\55\141\156\144\55\x66\x61\154\163\x65", "\164\145\x78\x74" => self::getMessage("\103\x4f\x4e\104\x49\x54\x49\117\x4e\123\x5f\x4c\x4f\107\111\x43\x5f\x41\x4e\x44\137\x4e\x4f")), array("\162\165\x6c\145" => array("\x61\x67\x67\162\x65\147\x61\164\157\162" => "\x6f\x72", "\x74\x79\x70\x65" => "\x66\141\154\x73\x65"), "\x63\154\x61\x73\163" => "\x76\153\x61\x70\151\55\155\x61\162\x6b\145\164\55\x63\x6f\x6e\144\151\164\151\x6f\156\x2d\x6c\157\x67\x69\143\55\x2d\x6f\x72\55\146\x61\x6c\x73\145", "\164\145\x78\164" => self::getMessage("\x43\x4f\116\x44\x49\x54\x49\x4f\116\x53\137\x4c\x4f\107\x49\x43\137\x4f\x52\x5f\116\x4f")))));
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
    public static function getEval($ofwy2g)
    {
        $tutcd4vbdyep83sm3ft = array();
        if (count($ofwy2g["\x63\x68\x69\154\144\163"])) {
            $tutcd4vbdyep83sm3ft = self::getEvalForChilds($ofwy2g["\143\150\151\154\x64\163"]);
        }
        $pfj5o1ukigfqhwu6fpudhub = $ofwy2g["\x76\x61\x6c\165\x65\163"]["\141\x67\147\162\x65\x67\141\164\x6f\162"] == "\141\x6e\144" ? "\x20\x61\156\x64\40" : "\40\157\x72\x20";
        $sdsogn5zv5oxzyyfj8nuw71egkf = $ofwy2g["\x76\x61\154\x75\145\163"]["\164\171\x70\x65"] == "\164\x72\x75\x65" ? "" : "\41";
        if (empty($tutcd4vbdyep83sm3ft)) {
            return false;
        } else {
            return $sdsogn5zv5oxzyyfj8nuw71egkf . implode("\40" . PHP_EOL . $pfj5o1ukigfqhwu6fpudhub . PHP_EOL . "\40" . $sdsogn5zv5oxzyyfj8nuw71egkf, $tutcd4vbdyep83sm3ft);
        }
    }
}
?>