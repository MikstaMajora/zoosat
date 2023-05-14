<?php

namespace VKapi\Market;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Web\HttpClient;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
class AntiCaptchaTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\141\x70\151\137\x6d\141\162\x6b\145\164\x5f\141\156\x74\151\143\x61\x70\164\x63\x68\x61\137\x6c\x69\163\x74";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\x49\104", array("\160\162\x69\155\x61\x72\x79" => true, "\141\x75\164\157\x63\x6f\155\160\154\145\164\145" => true)), new \Bitrix\Main\Entity\IntegerField("\x43\x49\104", array("\162\145\x71\165\x69\x72\145\144" => true)), new \Bitrix\Main\Entity\StringField("\127\117\122\104", array()), new \Bitrix\Main\Entity\StringField("\x53\124\x41\x54\x55\123", array("\x72\x65\161\165\151\x72\145\x64" => true, "\166\x61\x6c\151\144\141\164\x6f\x72" => function () {
            return array(new \Bitrix\Main\Entity\Validator\Range(1, 1));
        }, "\144\145\146\x61\x75\x6c\164\x5f\x76\141\x6c\x75\x65" => 0)), new \Bitrix\Main\Entity\DatetimeField("\124\111\x4d\105\x5f\103\122\105\101\124\x45", array("\x72\x65\x71\165\151\162\145\x64" => true, "\144\145\x66\141\x75\154\x74\x5f\166\x61\154\165\145" => new \Bitrix\Main\Type\DateTime())), new \Bitrix\Main\Entity\ExpressionField("\x43\116\124", "\103\117\125\116\x54\50\111\104\51"));
    }
}
final class AntiCaptcha
{
    private static $instance = null;
    
    protected $bDebug = false;
    protected $antigate_key = "";
    private function __construct()
    {
        $this->oTable = new \VKapi\Market\AntiCaptchaTable();
        $this->bDebug = \VKapi\Market\Manager::getInstance()->getParam("\x44\x45\102\x55\x47", "\116") == "\x59";
        $this->antigate_key = \VKapi\Market\Manager::getInstance()->getParam("\x41\116\x54\111\107\x41\x54\105\x5f\x4b\105\131", "");
    }
    private function __clone()
    {
    }
    
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $nks27h9uihrpte4wvb9p7gn7 = __CLASS__;
            self::$instance = new $nks27h9uihrpte4wvb9p7gn7();
        }
        return self::$instance;
    }
    
    public function sendImageContent($g3lriaq6a674kznat6ucng4m1332)
    {
        $a17fbskq6k0ko3 = new \VKapi\Market\Result();
        $tzw6fg51 = new \Bitrix\Main\Web\HttpClient();
        $tzw6fg51->post("\x68\x74\164\x70\x3a\x2f\x2f\141\x6e\x74\x69\147\x61\x74\x65\x2e\143\157\155\57\x69\156\56\160\150\x70", array("\x6d\145\164\x68\x6f\x64" => "\x62\141\x73\145\x36\x34", "\153\x65\171" => $this->antigate_key, "\142\157\144\x79" => base64_encode($g3lriaq6a674kznat6ucng4m1332)));
        if ($tzw6fg51->getStatus() == 200) {
            $ymx36moxlmdddh3chm91vf25hgzpzp02af = explode("\174", $tzw6fg51->getResult());
            if ($ymx36moxlmdddh3chm91vf25hgzpzp02af[0] == "\117\x4b") {
                $j0hpkormoiit7n7chveyi8rnachj = $this->oTable->add(array("\x43\x49\104" => $ymx36moxlmdddh3chm91vf25hgzpzp02af[1]));
                if ($j0hpkormoiit7n7chveyi8rnachj->isSuccess()) {
                    $a17fbskq6k0ko3->setData("\x49\x44", $j0hpkormoiit7n7chveyi8rnachj->getId());
                } else {
                    $a17fbskq6k0ko3->setError(new \VKapi\Market\Error("\101\x4e\x54\x49\x47\101\124\x45\x5f\x55\116\x4b\x4e\117\x57\x4e\137\x52\105\x53\120\117\116\123\x45", 0));
                }
            } else {
                $a17fbskq6k0ko3->setError(new \VKapi\Market\Error($tzw6fg51->getResult(), 0));
            }
        } else {
            $a17fbskq6k0ko3->setError(new \VKapi\Market\Error("\101\116\124\111\x47\x41\x54\105\x5f\x45\x52\122\x4f\122\x5f\122\105\123\x50\x4f\116\x53\x45\x5f\x53\124\101\x54\125\x53", "\101\x4e\124\111\107\101\x54\x45\x5f\x45\x52\122\x4f\122\137\x52\105\123\120\x4f\116\123\105\x5f\123\124\101\124\x55\x53", array("\110\124\x54\120" => $tzw6fg51)));
        }
        return $a17fbskq6k0ko3;
    }
    
    public function getWord($t80m8)
    {
        $epxmprhyalgxbs1de8ayy20bmlwfpk = $this->oTable->getList(array("\x66\x69\154\164\145\x72" => array("\111\x44" => $t80m8)));
        if ($u0rcd1sbmnrer3hdvfg2je = $epxmprhyalgxbs1de8ayy20bmlwfpk->fetch()) {
            return $u0rcd1sbmnrer3hdvfg2je["\127\x4f\x52\104"];
        } else {
            return false;
        }
    }
    
    public function checkResult()
    {
        $tzw6fg51 = new \Bitrix\Main\Web\HttpClient();
        $epxmprhyalgxbs1de8ayy20bmlwfpk = $this->oTable->getList(array("\146\151\x6c\164\x65\162" => array("\123\124\x41\x54\x55\x53" => 0)));
        while ($u0rcd1sbmnrer3hdvfg2je = $epxmprhyalgxbs1de8ayy20bmlwfpk->fetch()) {
            $tzw6fg51->get("\x68\x74\164\x70\72\x2f\57\141\156\x74\151\147\141\164\x65\56\143\157\x6d\57\x72\145\163\x2e\x70\150\160\x3f\153\x65\171\75" . $this->antigate_key . "\x26\141\143\x74\151\157\156\x3d\147\145\164\x26\151\144\75" . $u0rcd1sbmnrer3hdvfg2je["\103\111\x44"]);
            if ($tzw6fg51->getStatus() == 200) {
                $i0jmnb = explode("\x7c", $tzw6fg51->getResult());
                if ($i0jmnb[0] == "\x4f\113") {
                    $this->oTable->update($u0rcd1sbmnrer3hdvfg2je["\111\104"], array("\127\117\122\x44" => $i0jmnb[1], "\x53\x54\x41\x54\125\x53" => 1));
                } elseif ($i0jmnb["\60"] == "\103\x41\x50\103\x48\101\x5f\116\x4f\x54\x5f\122\x45\101\104\x59") {
                    
                } else {
                    $this->oTable->update($u0rcd1sbmnrer3hdvfg2je["\x49\104"], array("\127\117\122\x44" => "", "\x53\x54\x41\x54\x55\x53" => 3));
                }
            }
            return $u0rcd1sbmnrer3hdvfg2je["\x57\117\122\x44"];
        }
        return __METHOD__ . "\50\x29\73";
    }
    
    public static function clearAgent()
    {
        $kijgep8mn5jwdhsaonf2ssbevxtl3r = new \VKapi\Market\AntiCaptchaTable();
        $epxmprhyalgxbs1de8ayy20bmlwfpk = $kijgep8mn5jwdhsaonf2ssbevxtl3r->getList(array("\x66\x69\x6c\x74\x65\x72" => array("\x3c\x54\x49\x4d\x45\x5f\103\122\105\x41\x54\105" => \Bitrix\Main\Type\DateTime::createFromTimestamp(time() - 60 * 5))));
        while ($u0rcd1sbmnrer3hdvfg2je = $epxmprhyalgxbs1de8ayy20bmlwfpk->fetch()) {
            $kijgep8mn5jwdhsaonf2ssbevxtl3r->delete($u0rcd1sbmnrer3hdvfg2je["\x49\x44"]);
        }
        return __METHOD__ . "\x28\x29\x3b";
    }
}
?>