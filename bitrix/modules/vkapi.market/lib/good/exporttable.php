<?php

namespace VKapi\Market\Good;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ExportTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\x6b\141\x70\151\137\155\x61\162\x6b\145\164\137\147\157\157\x64\137\145\x78\160\x6f\162\164";
    }
    
    public static function getMap()
    {
        return [new \Bitrix\Main\Entity\IntegerField("\x49\104", ["\x70\x72\151\155\x61\162\x79" => true, "\x61\x75\164\157\x63\157\x6d\x70\154\x65\164\x65" => true]), new \Bitrix\Main\Entity\IntegerField("\x47\x52\x4f\x55\x50\x5f\111\x44", [
            //группа для выгрузки
            "\162\145\x71\165\151\162\x65\x64" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\120\122\117\104\125\103\124\x5f\x49\104", []), new \Bitrix\Main\Entity\IntegerField("\117\x46\106\x45\x52\x5f\111\x44", []), new \Bitrix\Main\Entity\IntegerField("\x56\x4b\137\111\104", [
            //идентификатор товара в вк,
            "\x64\x65\x66\x61\165\154\x74\137\x76\x61\x6c\x75\145" => null,
        ]), new \Bitrix\Main\Entity\StringField("\110\101\x53\x48", [
            //hash подготовленных полей, для исключения лишних обновлений на стороне вк
            "\x72\145\161\165\151\x72\145\144" => true,
        ]), new \Bitrix\Main\Entity\ExpressionField("\103\116\x54", "\x43\117\x55\x4e\x54\50\52\x29")];
    }
    
    public static function deleteAllByGroupId($f61fe0hgh2rrp8hmsry9loi)
    {
        $niniyqgyxqve6yyg3g4ksu8hs = static::getEntity();
        $wtu84lo2n = $niniyqgyxqve6yyg3g4ksu8hs->getConnection();
        $wtu84lo2n->query(sprintf("\x44\x45\x4c\105\x54\105\x20\106\x52\x4f\x4d\x20\45\x73\x20\x57\x48\x45\x52\x45\x20\x25\x73", $wtu84lo2n->getSqlHelper()->quote($niniyqgyxqve6yyg3g4ksu8hs->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($niniyqgyxqve6yyg3g4ksu8hs, ["\107\x52\x4f\125\x50\137\111\x44" => abs(intval($f61fe0hgh2rrp8hmsry9loi))])));
    }
    
    public static function getDoublesIdByGroupId($f61fe0hgh2rrp8hmsry9loi)
    {
        $rwxdzr = [];
        $niniyqgyxqve6yyg3g4ksu8hs = static::getEntity();
        $wtu84lo2n = $niniyqgyxqve6yyg3g4ksu8hs->getConnection();
        $iil50qn1 = $wtu84lo2n->query(sprintf("\163\x65\x6c\145\143\x74\40\x49\104\x2c\x20\x56\113\x5f\x49\x44\54\x20\x43\117\116\x43\101\x54\50\x50\122\x4f\x44\x55\103\124\137\111\104\54\47\x5f\x27\x20\54\40\117\x46\106\x45\x52\137\x49\104\x29\x20\x61\163\x20\104\x4f\x55\x42\x4c\105\123\xa\40\40\40\x20\40\x20\40\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\x66\x72\157\155\x20\x25\163\xa\40\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\x20\127\110\105\x52\105\40\x25\163\xa\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\40\x20\x20\40\x20\x20\x20\40\x47\122\x4f\125\x50\40\x42\x59\40\x44\117\x55\x42\114\x45\123\xa\x20\40\40\40\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\40\40\x20\x20\x48\x41\126\x49\116\x47\x20\x43\117\x55\x4e\x54\x28\x44\x4f\x55\102\x4c\105\123\51\40\76\x20\61", $wtu84lo2n->getSqlHelper()->quote($niniyqgyxqve6yyg3g4ksu8hs->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($niniyqgyxqve6yyg3g4ksu8hs, ["\x47\122\x4f\x55\x50\137\111\x44" => abs(intval($f61fe0hgh2rrp8hmsry9loi))])));
        while ($luhaga4e83h00j9bh = $iil50qn1->fetch()) {
            $rwxdzr[] = $luhaga4e83h00j9bh["\111\104"];
        }
        return $rwxdzr;
    }
    
    public static function deleteDoublesVkIdByGroupId($f61fe0hgh2rrp8hmsry9loi)
    {
        $niniyqgyxqve6yyg3g4ksu8hs = static::getEntity();
        $wtu84lo2n = $niniyqgyxqve6yyg3g4ksu8hs->getConnection();
        $f61fe0hgh2rrp8hmsry9loi = abs(intval($f61fe0hgh2rrp8hmsry9loi));
        $eck06gpv = sprintf("\xa\x20\x20\40\x20\x20\40\x20\x20\40\x20\x20\40\x44\105\114\105\x54\x45\x20\106\122\117\x4d\x20\45\163\x20\x20\x57\x48\x45\x52\x45\40\126\113\x5f\x49\104\x20\x69\x6e\40\x28\12\40\x20\40\x20\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\x73\145\154\145\143\x74\x20\126\113\x5f\x49\x44\x20\x66\x72\157\x6d\40\x28\12\40\x20\x20\x20\40\x20\40\x20\40\40\40\40\x20\x20\40\x20\x20\x20\x20\40\163\145\x6c\145\x63\164\x20\x20\x49\104\x2c\x20\x56\113\x5f\111\104\xa\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\x20\x20\x20\x20\40\40\x20\x20\40\40\40\x20\x20\40\x20\40\40\40\40\146\162\x6f\155\x20\45\x73\xa\x20\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\x20\40\x20\40\40\40\x20\x20\x57\110\x45\122\x45\x20\x47\x52\x4f\125\120\x5f\x49\104\x20\x3d\x20\45\163\12\40\40\40\40\x20\x20\40\40\40\40\40\x20\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\40\40\40\40\x20\40\x20\40\x47\x52\117\x55\x50\x20\x42\131\x20\126\x4b\137\x49\104\12\x20\x20\40\x20\40\40\40\x20\40\40\x20\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\40\x20\40\40\x20\40\x48\101\126\x49\x4e\107\x20\103\x4f\x55\x4e\124\x28\x56\x4b\x5f\111\x44\51\x20\x3e\x20\61\xa\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x20\40\x29\xa\40\40\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x20\40\40\40\141\163\40\124\111\x44\xa\40\x20\x20\40\40\x20\40\x20\40\x20\x20\x20\x29\xa\40\40\x20\x20\x20\40\x20\40\x20\40\40\x20", $wtu84lo2n->getSqlHelper()->quote($niniyqgyxqve6yyg3g4ksu8hs->getDbTableName()), $wtu84lo2n->getSqlHelper()->quote($niniyqgyxqve6yyg3g4ksu8hs->getDbTableName()), $f61fe0hgh2rrp8hmsry9loi);
        $wtu84lo2n->query($eck06gpv);
        return true;
    }
    
    public static function updateByGroupIdProductId($f61fe0hgh2rrp8hmsry9loi, $la0ov2t4a23d6j1aary5w50jtkq7e4hy, $i91t76oug0fdvtyx7js)
    {
        $niniyqgyxqve6yyg3g4ksu8hs = static::getEntity();
        $wtu84lo2n = $niniyqgyxqve6yyg3g4ksu8hs->getConnection();
        unset($i91t76oug0fdvtyx7js["\x50\122\x4f\104\125\x43\x54\137\111\x44"], $i91t76oug0fdvtyx7js["\117\x46\106\x45\122\x5f\111\104"], $i91t76oug0fdvtyx7js["\111\104"]);
        if (empty($i91t76oug0fdvtyx7js)) {
            return false;
        }
        $q75ni2iy1tku0neah36dc6ohkvg4pd = $wtu84lo2n->getSqlHelper()->prepareUpdate($niniyqgyxqve6yyg3g4ksu8hs->getDbTableName(), $i91t76oug0fdvtyx7js);
        $eck06gpv = sprintf("\x55\x50\x44\x41\124\x45\40\45\163\40" . "\40\123\x45\x54\40\x25\x73\40\127\110\x45\122\105\x20\x25\163", $wtu84lo2n->getSqlHelper()->quote($niniyqgyxqve6yyg3g4ksu8hs->getDbTableName()), $q75ni2iy1tku0neah36dc6ohkvg4pd[0], \Bitrix\Main\ORM\Query\Query::buildFilterSql($niniyqgyxqve6yyg3g4ksu8hs, ["\107\x52\x4f\x55\120\137\x49\104" => abs(intval($f61fe0hgh2rrp8hmsry9loi)), "\x50\x52\117\104\x55\x43\124\137\x49\x44" => intval($la0ov2t4a23d6j1aary5w50jtkq7e4hy)]));
        $wtu84lo2n->query($eck06gpv);
    }
}
?>