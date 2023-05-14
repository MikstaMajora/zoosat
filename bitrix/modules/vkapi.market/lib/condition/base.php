<?php

namespace VKapi\Market\Condition;

use Bitrix\Main\Localization\Loc;

abstract class Base implements \VKapi\Market\Condition\IBase
{
    
    protected $arParams = array();
    
    public function __construct(array $de8zu036euhl7j1cwq3cz6ndsoyjkdww06l = array())
    {
        $this->arParams = $de8zu036euhl7j1cwq3cz6ndsoyjkdww06l;
    }
    
    protected static function getMessage($ujs9p1xe2si92a5oehp, $x55x5p3k = array())
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\x50\111\x2e\x4d\101\122\113\x45\124\56\103\117\x4e\104\111\x54\111\117\x4e\56" . $ujs9p1xe2si92a5oehp, $x55x5p3k);
    }
    
    public function getParams()
    {
        return $this->arParams;
    }
    
    public static final function getType()
    {
        return get_called_class();
    }
    
    public function getInternalConditionById($t80m8)
    {
        $o62jbc3re9ue1qt = array_filter($this->getInternalConditions(), function ($tsisf2sgjo8oqono96dfodi1xon6pkz) use($t80m8) {
            return $tsisf2sgjo8oqono96dfodi1xon6pkz["\151\144"] == $t80m8;
        });
        if (!empty($o62jbc3re9ue1qt)) {
            return reset($o62jbc3re9ue1qt);
        }
        return null;
    }
    
    public final function getJsData()
    {
        $cfby55v5z2id8j33r3ajatlyi7 = array();
        
        $d0r932i8t43pq9ta7qqzaxok3913mif = $this->getInternalConditions();
        
        foreach ($d0r932i8t43pq9ta7qqzaxok3913mif as $av836erpffzdx1psw83kp1i1fkbpbwpib6) {
            $l6zvzun = array("\x74\x79\x70\145" => static::getType() . "\x3a" . $av836erpffzdx1psw83kp1i1fkbpbwpib6["\151\144"], "\x63\157\x6d\160\157\x6e\145\x6e\164" => $av836erpffzdx1psw83kp1i1fkbpbwpib6["\x63\157\x6d\x70\157\x6e\x65\156\x74"], "\147\x72\157\165\x70" => $av836erpffzdx1psw83kp1i1fkbpbwpib6["\x67\162\x6f\x75\x70"], "\156\141\155\x65" => $av836erpffzdx1psw83kp1i1fkbpbwpib6["\156\x61\155\145"], "\x63\x6f\156\x74\x72\x6f\154\x73" => array(), "\160\141\162\141\x6d\x73" => array_merge(array("\x5f\166\145\162\163\x69\x6f\x6e" => 1), isset($av836erpffzdx1psw83kp1i1fkbpbwpib6["\x70\141\x72\141\155\x73"]) ? $av836erpffzdx1psw83kp1i1fkbpbwpib6["\160\x61\x72\141\x6d\163"] : array()), "\155\x6f\162\145" => array_merge(array("\137\x76\x65\162\163\151\157\x6e" => 1), isset($av836erpffzdx1psw83kp1i1fkbpbwpib6["\155\157\x72\145"]) ? $av836erpffzdx1psw83kp1i1fkbpbwpib6["\x6d\157\162\x65"] : array()));
            foreach ($av836erpffzdx1psw83kp1i1fkbpbwpib6["\x63\157\156\164\162\x6f\154\x73"] as $nopse5b6h5nwtblgw54wk5x13) {
                if ($nopse5b6h5nwtblgw54wk5x13 instanceof \VKapi\Market\Condition\Control\Base) {
                    $l6zvzun["\143\157\x6e\164\162\x6f\x6c\x73"][] = $nopse5b6h5nwtblgw54wk5x13->getJsData();
                }
            }
            $cfby55v5z2id8j33r3ajatlyi7[] = $l6zvzun;
        }
        return $cfby55v5z2id8j33r3ajatlyi7;
    }
    
    public function parse($uzhtb, $gma84eldouj)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = array();
        $cnht9md = $this->getInternalConditionById($uzhtb);
        
        if (is_null($cnht9md)) {
            return false;
        }
        do {
            $g07gfnxhvwcodl5gqee6fazj01 = array("\151\x64" => $uzhtb, "\164\171\x70\x65" => $this->getType(), "\x63\x68\151\154\144\x73" => array(), "\x76\141\154\x75\x65\163" => array());
            if (!empty($cnht9md["\x63\x6f\x6e\164\162\157\154\x73"])) {
                foreach ($cnht9md["\x63\157\156\164\162\157\x6c\163"] as $nopse5b6h5nwtblgw54wk5x13) {
                    
                    if (!$nopse5b6h5nwtblgw54wk5x13->checkValue($gma84eldouj, $nopse5b6h5nwtblgw54wk5x13)) {
                        return false;
                    } else {
                        $g07gfnxhvwcodl5gqee6fazj01["\x76\141\x6c\x75\x65\x73"] = array_merge($g07gfnxhvwcodl5gqee6fazj01["\166\141\x6c\165\x65\163"], $nopse5b6h5nwtblgw54wk5x13->getValue($gma84eldouj, $cnht9md));
                    }
                }
            }
            return $g07gfnxhvwcodl5gqee6fazj01;
        } while (false);
        return false;
    }
    
    public static abstract function getEval($tvngjz4sn0jclynii4llo3nemwtta2m8es);
    
    public static function getEvalForChilds($ynocaa1b3jfp88gr3fq0kzqb3koy8pld)
    {
        $k23huzd55 = array();
        foreach ($ynocaa1b3jfp88gr3fq0kzqb3koy8pld as $lh0azewfdtwi9nigt27d1haipsl) {
            if (isset($lh0azewfdtwi9nigt27d1haipsl["\x69\144"]) && isset($lh0azewfdtwi9nigt27d1haipsl["\x74\x79\x70\x65"]) && class_exists($lh0azewfdtwi9nigt27d1haipsl["\x74\171\160\145"])) {
                
                $wihnzanhon8g6wyz94d234776bv56jdl1 = $lh0azewfdtwi9nigt27d1haipsl["\x74\x79\x70\145"];
                $lrhm6stqqittmm = $wihnzanhon8g6wyz94d234776bv56jdl1::getEval($lh0azewfdtwi9nigt27d1haipsl);
                if ($lrhm6stqqittmm !== false) {
                    $k23huzd55[] = "\50" . trim($lrhm6stqqittmm) . "\x29";
                }
            }
        }
        return $k23huzd55;
    }
    
    public function getPrepiredValuePreview($tsisf2sgjo8oqono96dfodi1xon6pkz)
    {
        return $tsisf2sgjo8oqono96dfodi1xon6pkz["\166\141\x6c\165\145\163"];
    }
}
?>