<?php

namespace VKapi\Market\Sale\Order\Sync;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class RefTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\x61\x70\x69\x5f\x6d\141\x72\153\145\x74\x5f\163\x61\x6c\x65\137\157\162\x64\x65\162\x5f\x73\171\156\143\x5f\x72\x65\x66";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\x49\x44", array("\x70\x72\x69\155\x61\x72\x79" => true)), new \Bitrix\Main\Entity\IntegerField("\x4f\x52\104\105\x52\x5f\x49\x44", array()), new \Bitrix\Main\Entity\StringField("\x56\x4b\117\x52\104\x45\x52\137\x49\104", array(
            // заказ в вк
            "\x72\145\x71\x75\151\x72\145\x64" => true,
        )), new \Bitrix\Main\Entity\StringField("\x56\113\x55\123\x45\x52\x5f\111\x44", array(
            // идентификтаор польвзаоетля которому принадлежит заказа
            "\162\145\x71\165\x69\162\x65\x64" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\107\122\117\125\120\137\111\104", array(
            //идентификатор группы в вк
            "\x72\145\161\165\151\162\x65\x64" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\123\131\116\x43\x5f\111\104", array(
            //идентификатор синхронизации
            "\x72\145\x71\165\151\162\x65\144" => true,
        )), new \Bitrix\Main\Entity\ExpressionField("\103\116\x54", "\x43\x4f\125\116\124\50\x49\104\x29"));
    }
}
?>