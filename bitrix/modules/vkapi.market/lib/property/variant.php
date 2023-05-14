<?php

namespace VKapi\Market\Property;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;

class VariantTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\x6b\x61\160\x69\x5f\155\141\x72\x6b\x65\x74\137\x70\x72\x6f\160\x65\x72\164\x79\137\166\x61\162\x69\141\156\x74";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\111\104", array("\160\x72\x69\x6d\141\162\171" => true, "\141\165\164\x6f\x63\157\x6d\x70\x6c\x65\x74\145" => true)), new \Bitrix\Main\Entity\IntegerField("\107\x52\x4f\x55\x50\x5f\111\x44", array(
            // идентификатор группы в вконтакте, целое положительное число
            "\162\x65\x71\165\151\162\145\x64" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\x50\x52\x4f\120\x45\x52\124\x59\x5f\111\x44", array(
            //id свойства
            "\x72\145\161\x75\151\x72\x65\144" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\105\x4e\x55\x4d\137\111\x44", array(
            //id значения свойства
            "\162\145\161\165\151\x72\x65\144" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\x56\x4b\x5f\x56\x41\122\111\x41\x4e\x54\x5f\111\x44", array(
            // id вариантазначения в вк
            "\x72\x65\x71\x75\151\162\x65\144" => true,
        )), new \Bitrix\Main\Entity\ExpressionField("\103\x4e\x54", "\103\x4f\125\116\x54\50\x49\x44\x29"));
    }
    
    public static function deleteAllByGroupId($qxl9ta89pk1lgpm3)
    {
        $u2vtaswbokiabemkx7di2xx2u = static::getEntity();
        $mh1h6uaq0jkhpsb0 = $u2vtaswbokiabemkx7di2xx2u->getConnection();
        return $mh1h6uaq0jkhpsb0->query(sprintf("\104\105\114\x45\124\x45\40\x46\122\117\x4d\40\x25\163\40\127\x48\105\122\105\x20\45\x73", $mh1h6uaq0jkhpsb0->getSqlHelper()->quote($u2vtaswbokiabemkx7di2xx2u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($u2vtaswbokiabemkx7di2xx2u, ["\x47\x52\x4f\125\x50\x5f\x49\104" => abs(intval($qxl9ta89pk1lgpm3))])));
    }
    
    public static function deleteByGroupIdPropertyId($qxl9ta89pk1lgpm3, $ud499ar56c)
    {
        $u2vtaswbokiabemkx7di2xx2u = static::getEntity();
        $mh1h6uaq0jkhpsb0 = $u2vtaswbokiabemkx7di2xx2u->getConnection();
        $ud499ar56c = (array) $ud499ar56c;
        if (empty($ud499ar56c)) {
            return null;
        }
        return $mh1h6uaq0jkhpsb0->query(sprintf("\x44\105\114\x45\124\105\40\x46\x52\x4f\x4d\40\x25\163\x20\127\x48\105\x52\x45\40\45\x73", $mh1h6uaq0jkhpsb0->getSqlHelper()->quote($u2vtaswbokiabemkx7di2xx2u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($u2vtaswbokiabemkx7di2xx2u, ["\x47\122\117\x55\120\137\111\x44" => abs(intval($qxl9ta89pk1lgpm3)), "\120\122\x4f\120\x45\x52\124\131\x5f\111\x44" => $ud499ar56c])));
    }
}
?>