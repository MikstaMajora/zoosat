<?php

namespace VKapi\Market;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
class ParamTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\x6b\x61\160\151\x5f\155\x61\162\x6b\x65\x74\137\160\141\162\141\x6d";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\StringField("\x43\117\104\105", array("\160\162\x69\x6d\x61\x72\x79" => true)), new \Bitrix\Main\Entity\StringField("\126\101\114\x55\x45"), new \Bitrix\Main\Entity\DatetimeField("\x45\x44\x49\124\x5f\x54\111\x4d\x45", array("\162\x65\161\x75\151\x72\x65\144" => true, "\144\x65\146\141\x75\x6c\164\x5f\166\141\154\x75\x65" => new \Bitrix\Main\Type\DateTime())), new \Bitrix\Main\Entity\ExpressionField("\x43\116\x54", "\x43\117\x55\x4e\x54\50\52\51"));
    }
    public static function onBeforeAdd(\Bitrix\Main\Entity\Event $acgq5poeto5ol7z5)
    {
        $q43zd2xlmpaub595hni95lnhy4dwr6v = new \Bitrix\Main\Entity\EventResult();
        $i375gdh9c1q5z7hk26pdc34er = $acgq5poeto5ol7z5->getParameter("\146\x69\145\154\144\x73");
        if (!isset($i375gdh9c1q5z7hk26pdc34er["\x45\104\111\x54\137\124\x49\x4d\105"])) {
            $q43zd2xlmpaub595hni95lnhy4dwr6v->modifyFields(array("\105\104\111\x54\x5f\124\x49\115\x45" => new \Bitrix\Main\Type\DateTime()));
        }
        return $q43zd2xlmpaub595hni95lnhy4dwr6v;
    }
    public static function onBeforeUpdate(\Bitrix\Main\Entity\Event $acgq5poeto5ol7z5)
    {
        $q43zd2xlmpaub595hni95lnhy4dwr6v = new \Bitrix\Main\Entity\EventResult();
        $i375gdh9c1q5z7hk26pdc34er = $acgq5poeto5ol7z5->getParameter("\x66\151\145\154\x64\163");
        if (!isset($i375gdh9c1q5z7hk26pdc34er["\x45\x44\x49\x54\137\x54\111\x4d\x45"])) {
            $q43zd2xlmpaub595hni95lnhy4dwr6v->modifyFields(array("\105\104\111\x54\x5f\124\x49\x4d\105" => new \Bitrix\Main\Type\DateTime()));
        }
        return $q43zd2xlmpaub595hni95lnhy4dwr6v;
    }
}
?>