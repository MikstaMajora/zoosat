<?php

namespace VKapi\Market;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ConnectTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\x6b\x61\160\x69\x5f\155\x61\x72\153\145\x74\137\141\x63\x63\x65\x73\x73\137\154\151\x73\x74";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\111\104", array("\160\162\x69\155\141\162\171" => true, "\141\x75\164\157\143\x6f\x6d\160\x6c\x65\164\145" => true)), new \Bitrix\Main\Entity\IntegerField("\125\x53\x45\122\137\111\x44", array(
            // bitrix user id
            "\x72\145\161\x75\x69\162\x65\x64" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\x55\x53\x45\x52\137\111\104\137\x56\113", array(
            // vk user id
            "\x72\145\x71\165\151\162\145\144" => true,
        )), new \Bitrix\Main\Entity\DatetimeField("\x45\130\120\x49\122\x45\x53\x5f\x49\x4e", array("\162\x65\161\x75\151\162\145\x64" => true, "\x76\x61\x6c\x69\144\141\x74\x6f\162" => function () {
            return array(new \Bitrix\Main\Entity\Validator\Date());
        }, "\x64\145\146\x61\x75\x6c\x74\x5f\x76\x61\x6c\x75\145" => new \Bitrix\Main\Type\DateTime())), new \Bitrix\Main\Entity\StringField("\101\103\x43\105\x53\x53\x5f\x54\117\113\105\116", array("\162\145\161\x75\151\x72\145\144" => true, "\166\x61\x6c\151\144\x61\x74\157\162" => function () {
            return array(new \Bitrix\Main\Entity\Validator\Range(1, 255));
        })), new \Bitrix\Main\Entity\StringField("\116\101\x4d\105", array("\x64\145\x66\x61\165\154\164" => "\x20\x2d\40", "\166\141\154\151\144\141\164\157\162" => function () {
            return array(new \Bitrix\Main\Entity\Validator\Range(0, 255));
        })), new \Bitrix\Main\Entity\ExpressionField("\103\x4e\x54", "\x43\x4f\x55\116\124\x28\x49\x44\51"));
    }
    
    public static function onBeforeAdd(\Bitrix\Main\Entity\Event $acgq5poeto5ol7z5)
    {
        $q43zd2xlmpaub595hni95lnhy4dwr6v = new \Bitrix\Main\Entity\EventResult();
        $i375gdh9c1q5z7hk26pdc34er = $acgq5poeto5ol7z5->getParameter("\x66\x69\x65\154\x64\163");
        $c5r2r8019 = array();
        if (!isset($i375gdh9c1q5z7hk26pdc34er["\x45\130\x50\111\x52\105\123\x5f\x49\x4e"]) || $i375gdh9c1q5z7hk26pdc34er["\105\130\120\111\x52\x45\x53\x5f\111\x4e"] == 0) {
            $of8q3bujxlon = \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("\53\60\163\x65\x63\157\x6e\144"));
            $c5r2r8019["\x45\x58\x50\x49\x52\x45\123\137\x49\116"] = $of8q3bujxlon;
        } else {
            $of8q3bujxlon = \Bitrix\Main\Type\DateTime::createFromTimestamp(time() + $i375gdh9c1q5z7hk26pdc34er["\105\130\120\x49\x52\105\x53\x5f\x49\x4e"]);
            $c5r2r8019["\x45\130\x50\111\122\x45\x53\x5f\x49\116"] = $of8q3bujxlon;
        }
        $q43zd2xlmpaub595hni95lnhy4dwr6v->modifyFields($c5r2r8019);
        return $q43zd2xlmpaub595hni95lnhy4dwr6v;
    }
    
    public static function onBeforeUpdate(\Bitrix\Main\Entity\Event $acgq5poeto5ol7z5)
    {
        $q43zd2xlmpaub595hni95lnhy4dwr6v = new \Bitrix\Main\Entity\EventResult();
        $i375gdh9c1q5z7hk26pdc34er = $acgq5poeto5ol7z5->getParameter("\x66\x69\x65\x6c\x64\x73");
        $c5r2r8019 = array();
        if (!isset($i375gdh9c1q5z7hk26pdc34er["\105\130\x50\111\122\105\123\x5f\111\116"]) || $i375gdh9c1q5z7hk26pdc34er["\x45\130\120\111\x52\105\x53\x5f\111\116"] == 0) {
            $of8q3bujxlon = \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("\53\60\163\x65\x63\x6f\156\144"));
            $c5r2r8019["\x45\130\x50\111\122\x45\123\x5f\x49\x4e"] = $of8q3bujxlon;
        } else {
            $of8q3bujxlon = \Bitrix\Main\Type\DateTime::createFromTimestamp(time() + $i375gdh9c1q5z7hk26pdc34er["\x45\x58\x50\111\x52\105\x53\137\x49\x4e"]);
            $c5r2r8019["\x45\130\x50\111\x52\105\x53\137\x49\116"] = $of8q3bujxlon;
        }
        $q43zd2xlmpaub595hni95lnhy4dwr6v->modifyFields($c5r2r8019);
        return $q43zd2xlmpaub595hni95lnhy4dwr6v;
    }
}
?>