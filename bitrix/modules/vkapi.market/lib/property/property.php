<?php

namespace VKapi\Market\Property;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
use VKapi\Market\Error;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class PropertyTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\x6b\x61\x70\151\x5f\x6d\x61\x72\x6b\145\x74\137\x70\162\157\x70\x65\162\164\x79";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\111\104", array("\160\x72\151\155\x61\x72\x79" => true, "\x61\165\x74\157\x63\157\155\x70\x6c\x65\x74\x65" => true)), new \Bitrix\Main\Entity\IntegerField("\x47\122\117\x55\x50\x5f\111\104", array(
            // идентификатор группы в вконтакте, целое положительное число
            "\162\145\161\165\151\162\145\144" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\120\x52\117\x50\x45\122\x54\131\x5f\111\x44", array(
            //id свойства
            "\162\x65\161\x75\151\x72\x65\144" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\x56\113\x5f\120\x52\117\x50\105\x52\x54\x59\x5f\111\104", array(
            // id сыойства в вк
            "\162\x65\x71\165\151\162\145\144" => true,
        )), new \Bitrix\Main\Entity\ExpressionField("\x43\x4e\124", "\x43\x4f\125\116\124\x28\111\104\51"));
    }
    
    public static function deleteAllByGroupId($qxl9ta89pk1lgpm3)
    {
        $u2vtaswbokiabemkx7di2xx2u = static::getEntity();
        $mh1h6uaq0jkhpsb0 = $u2vtaswbokiabemkx7di2xx2u->getConnection();
        return $mh1h6uaq0jkhpsb0->query(sprintf("\104\x45\114\105\x54\105\40\106\x52\117\115\40\45\163\x20\127\x48\x45\122\x45\x20\45\x73", $mh1h6uaq0jkhpsb0->getSqlHelper()->quote($u2vtaswbokiabemkx7di2xx2u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($u2vtaswbokiabemkx7di2xx2u, ["\107\x52\117\125\x50\137\111\104" => abs(intval($qxl9ta89pk1lgpm3))])));
    }
    
    public static function deleteByGroupIdPropertyId($qxl9ta89pk1lgpm3, $ud499ar56c)
    {
        $u2vtaswbokiabemkx7di2xx2u = static::getEntity();
        $mh1h6uaq0jkhpsb0 = $u2vtaswbokiabemkx7di2xx2u->getConnection();
        $ud499ar56c = (array) $ud499ar56c;
        if (empty($ud499ar56c)) {
            return null;
        }
        return $mh1h6uaq0jkhpsb0->query(sprintf("\104\105\x4c\105\124\105\x20\106\x52\x4f\x4d\40\x25\163\x20\x57\110\x45\122\x45\40\x25\x73", $mh1h6uaq0jkhpsb0->getSqlHelper()->quote($u2vtaswbokiabemkx7di2xx2u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($u2vtaswbokiabemkx7di2xx2u, ["\107\122\117\x55\x50\x5f\111\x44" => abs(intval($qxl9ta89pk1lgpm3)), "\x50\122\x4f\x50\105\122\124\x59\x5f\x49\104" => $ud499ar56c])));
    }
}

class Property
{
    
    protected $oTable = null;
    
    protected $oVariantTable = null;
    public function __construct()
    {
        if (!\VKapi\Market\Manager::getInstance()->isInstalledIblockModule()) {
            
        }
    }
    
    public function table()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Property\PropertyTable();
        }
        return $this->oTable;
    }
    
    public function variantTable()
    {
        if (is_null($this->oVariantTable)) {
            $this->oVariantTable = new \VKapi\Market\Property\VariantTable();
        }
        return $this->oVariantTable;
    }
    
    public function deleteByGroupIdPropertyId($qxl9ta89pk1lgpm3, $ud499ar56c)
    {
        $this->table()->deleteByGroupIdPropertyId($qxl9ta89pk1lgpm3, $ud499ar56c);
        $this->variantTable()->deleteByGroupIdPropertyId($qxl9ta89pk1lgpm3, $ud499ar56c);
    }
    
    public function getListByGroupId($qxl9ta89pk1lgpm3)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = array();
        $ylzpg07gafcb1dlefgj5y2emw00f6218sfi = $this->table()->getList(["\146\151\154\164\145\162" => ["\x47\x52\x4f\125\120\x5f\111\104" => $qxl9ta89pk1lgpm3]]);
        while ($u0rcd1sbmnrer3hdvfg2je = $ylzpg07gafcb1dlefgj5y2emw00f6218sfi->fetch()) {
            $g07gfnxhvwcodl5gqee6fazj01[] = $u0rcd1sbmnrer3hdvfg2je;
        }
        return $g07gfnxhvwcodl5gqee6fazj01;
    }
    
    public function getVariantsByGroupIdPropertyId($qxl9ta89pk1lgpm3, $yi73vdiue1ouqucy45a60kv99izw5bw6hji)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = array();
        $ylzpg07gafcb1dlefgj5y2emw00f6218sfi = $this->variantTable()->getList(["\x6f\x72\144\x65\x72" => ["\x49\x44" => "\x41\123\103"], "\146\x69\154\164\x65\x72" => ["\x47\122\117\x55\120\137\111\104" => $qxl9ta89pk1lgpm3, "\x50\122\x4f\120\105\x52\x54\x59\x5f\111\x44" => $yi73vdiue1ouqucy45a60kv99izw5bw6hji]]);
        while ($u0rcd1sbmnrer3hdvfg2je = $ylzpg07gafcb1dlefgj5y2emw00f6218sfi->fetch()) {
            $g07gfnxhvwcodl5gqee6fazj01[] = $u0rcd1sbmnrer3hdvfg2je;
        }
        return $g07gfnxhvwcodl5gqee6fazj01;
    }
    
    public function getPropertyVariants($yi73vdiue1ouqucy45a60kv99izw5bw6hji)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = [];
        $r3yyl653j = $this->getIblockPropertyById($yi73vdiue1ouqucy45a60kv99izw5bw6hji);
        if (is_null($r3yyl653j)) {
            return $g07gfnxhvwcodl5gqee6fazj01;
        }
        if ($r3yyl653j["\x50\x52\117\120\x45\122\124\x59\x5f\x54\x59\x50\105"] == "\114") {
            $g07gfnxhvwcodl5gqee6fazj01 = $this->getIblockPropertyEnumList($r3yyl653j);
        } elseif ($r3yyl653j["\120\122\x4f\x50\105\x52\124\x59\x5f\124\131\120\105"] == "\x53" && $r3yyl653j["\125\123\105\122\137\x54\131\x50\x45"] == "\x64\x69\162\145\143\164\x6f\162\171") {
            $g07gfnxhvwcodl5gqee6fazj01 = $this->getHighloadValuesList($r3yyl653j);
        }
        return $g07gfnxhvwcodl5gqee6fazj01;
    }
    
    public function getIblockPropertyEnumList($r3yyl653j)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = [];
        $ylzpg07gafcb1dlefgj5y2emw00f6218sfi = \Bitrix\Iblock\PropertyEnumerationTable::getList(["\x6f\x72\x64\145\162" => ["\x49\104" => "\x41\123\x43"], "\146\x69\154\164\x65\x72" => ["\x50\122\x4f\120\x45\x52\124\131\137\111\104" => $r3yyl653j["\111\x44"]]]);
        while ($u0rcd1sbmnrer3hdvfg2je = $ylzpg07gafcb1dlefgj5y2emw00f6218sfi->fetch()) {
            $g07gfnxhvwcodl5gqee6fazj01[] = ["\111\x44" => $u0rcd1sbmnrer3hdvfg2je["\111\x44"], "\130\x4d\114\x5f\111\104" => $u0rcd1sbmnrer3hdvfg2je["\130\x4d\x4c\x5f\111\104"], "\116\101\x4d\105" => $u0rcd1sbmnrer3hdvfg2je["\126\x41\x4c\125\105"]];
        }
        return $g07gfnxhvwcodl5gqee6fazj01;
    }
    
    public function getHighloadValuesList($r3yyl653j)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = [];
        if (!\VKapi\Market\Manager::getInstance()->isInstalledHighloadBlockModule()) {
            return $g07gfnxhvwcodl5gqee6fazj01;
        }
        $te2oo = null;
        if (isset($r3yyl653j["\x55\123\105\122\x5f\x54\x59\x50\105\x5f\x53\105\x54\124\x49\116\107\123\137\x4c\x49\123\124"]["\x54\101\102\114\x45\137\116\101\x4d\105"])) {
            $te2oo = $r3yyl653j["\125\x53\105\x52\x5f\124\131\x50\105\x5f\x53\x45\124\x54\x49\116\x47\123\x5f\114\111\123\x54"]["\x54\x41\102\114\x45\137\116\101\115\x45"];
        } elseif (isset($r3yyl653j["\125\x53\105\x52\x5f\x54\131\120\x45\x5f\x53\x45\124\x54\111\116\x47\x53"]["\124\101\x42\114\x45\137\116\x41\x4d\105"])) {
            $te2oo = $r3yyl653j["\125\123\x45\122\137\124\131\x50\105\x5f\x53\105\x54\124\111\x4e\x47\x53"]["\x54\101\x42\x4c\x45\137\x4e\101\115\105"];
        }
        if (is_null($te2oo)) {
            return $g07gfnxhvwcodl5gqee6fazj01;
        }
        
        $ttmb2e6zcxsc = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("\x73\145\x6c\x65\x63\164" => array("\x2a"), "\157\162\144\x65\x72" => array("\116\x41\115\x45" => "\x41\123\x43"), "\146\x69\154\x74\x65\162" => array("\124\101\x42\114\x45\x5f\116\x41\115\105" => $te2oo)))->fetch();
        if (!$ttmb2e6zcxsc) {
            return $g07gfnxhvwcodl5gqee6fazj01;
        }
        
        $gyzs53sl8agdyxz24mw72n250r = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($ttmb2e6zcxsc);
        $x5odyplpm1ega19lyme = $gyzs53sl8agdyxz24mw72n250r->getDataClass();
        $c9dno6oit1rqyq8er6p6w8izlthtwtcy5um[$te2oo] = new $x5odyplpm1ega19lyme();
        $lc0is64b4gmailp0 = $c9dno6oit1rqyq8er6p6w8izlthtwtcy5um[$te2oo]->getList([]);
        while ($u0rcd1sbmnrer3hdvfg2je = $lc0is64b4gmailp0->fetch()) {
            $g07gfnxhvwcodl5gqee6fazj01[] = ["\111\x44" => $u0rcd1sbmnrer3hdvfg2je["\111\104"], "\130\115\x4c\x5f\111\104" => $u0rcd1sbmnrer3hdvfg2je["\125\106\x5f\x58\x4d\x4c\x5f\111\x44"], "\116\x41\x4d\105" => $u0rcd1sbmnrer3hdvfg2je["\x55\x46\137\116\x41\x4d\x45"]];
        }
        return $g07gfnxhvwcodl5gqee6fazj01;
    }
    
    public function getIblockPropertiesById($dv0mezm4cx92ng73i8u6i)
    {
        $g07gfnxhvwcodl5gqee6fazj01 = [];
        if (empty($dv0mezm4cx92ng73i8u6i)) {
            return $g07gfnxhvwcodl5gqee6fazj01;
        }
        $ylzpg07gafcb1dlefgj5y2emw00f6218sfi = \Bitrix\Iblock\PropertyTable::getList(["\146\x69\154\x74\x65\162" => ["\111\104" => $dv0mezm4cx92ng73i8u6i]]);
        while ($u0rcd1sbmnrer3hdvfg2je = $ylzpg07gafcb1dlefgj5y2emw00f6218sfi->fetch()) {
            $g07gfnxhvwcodl5gqee6fazj01[] = $u0rcd1sbmnrer3hdvfg2je;
        }
        return $g07gfnxhvwcodl5gqee6fazj01;
    }
    
    public function getIblockPropertyById($yi73vdiue1ouqucy45a60kv99izw5bw6hji)
    {
        $ylzpg07gafcb1dlefgj5y2emw00f6218sfi = \Bitrix\Iblock\PropertyTable::getList(["\146\x69\154\x74\x65\x72" => ["\111\x44" => intval($yi73vdiue1ouqucy45a60kv99izw5bw6hji)]]);
        if ($u0rcd1sbmnrer3hdvfg2je = $ylzpg07gafcb1dlefgj5y2emw00f6218sfi->fetch()) {
            return $u0rcd1sbmnrer3hdvfg2je;
        }
        return null;
    }
}
?>