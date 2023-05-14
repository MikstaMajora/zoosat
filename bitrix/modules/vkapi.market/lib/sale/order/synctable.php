<?php

namespace VKapi\Market\Sale\Order;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class SyncTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\x61\x70\x69\x5f\155\x61\162\x6b\x65\x74\137\x73\x61\154\145\137\157\162\144\x65\162\x5f\x73\171\x6e\143";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\111\104", array("\160\162\151\x6d\141\x72\x79" => true)), new \Bitrix\Main\Entity\BooleanField("\x41\103\124\111\126\105", array("\162\145\161\x75\x69\162\x65\x64" => true, "\144\x65\146\141\x75\x6c\x74\137\x76\x61\154\165\x65" => false)), new \Bitrix\Main\Entity\IntegerField("\x41\103\103\117\125\x4e\x54\x5f\x49\104", array(
            //идентификатор добавленного аккаунта, от имени которого работать
            "\x72\145\161\165\x69\162\x65\144" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\107\122\x4f\x55\120\137\111\x44", array(
            //идентификатор группы в вконткате, положительное целое число
            "\x72\x65\161\165\151\x72\x65\x64" => true,
        )), new \Bitrix\Main\Entity\StringField("\x47\x52\117\125\120\x5f\x4e\101\x4d\105", array(
            // название группы в вконтакте, для вывода в списке
            "\x72\145\161\x75\x69\162\145\144" => true,
        )), new \Bitrix\Main\Entity\BooleanField("\x45\126\105\x4e\x54\x5f\105\116\x41\102\x4c\x45\x44", array(
            // вклчюена ли обработка событий
            "\144\x65\146\x61\165\154\x74\x5f\x76\141\x6c\x75\145" => true,
        )), new \Bitrix\Main\Entity\StringField("\x45\x56\x45\x4e\124\x5f\x53\105\x43\x52\105\x54", array(
            //секретный ключ передаваемый вместе с запросом
            "\x64\x65\x66\x61\165\154\164\137\x76\x61\154\x75\x65" => "",
        )), new \Bitrix\Main\Entity\StringField("\105\126\x45\x4e\124\x5f\103\x4f\x44\x45", array(
            // проверочный код при добавлении сервера в вк и выполнении проверки
            "\144\x65\146\x61\165\154\x74\137\166\141\x6c\x75\145" => "",
        )), new \Bitrix\Main\Entity\StringField("\107\122\117\125\120\137\101\103\103\105\x53\x53\137\124\x4f\113\x45\x4e", array(
            // ключ доступа сообщества для получения заказов
            "\x64\x65\146\x61\x75\x6c\x74\137\x76\x61\x6c\x75\145" => "",
        )), new \Bitrix\Main\Entity\StringField("\x53\111\124\x45\137\111\104", array(
            // идентификтаор сайта, дял привязки заказов
            "\x72\x65\161\x75\x69\162\145\144" => true,
        )), new \Bitrix\Main\Entity\TextField("\x50\101\x52\x41\x4d\x53", array("\162\145\x71\165\151\162\145\144" => true, "\163\145\162\x69\x61\154\x69\x7a\145\x64" => true, "\x64\x65\x66\x61\x75\154\164\x5f\x76\x61\x6c\x75\x65" => [])), new \Bitrix\Main\Entity\ReferenceField("\x41\x43\x43\x4f\x55\x4e\124", "\134\126\x4b\x61\x70\x69\x5c\115\141\162\153\x65\164\x5c\103\x6f\x6e\156\145\x63\164\x54\x61\x62\154\145", array("\75\164\150\x69\163\56\101\103\103\117\125\116\124\137\111\104" => "\162\145\146\56\111\104"), array("\x6a\x6f\x69\x6e\x5f\x74\171\160\145" => "\x4c\x45\106\x54")), new \Bitrix\Main\Entity\ExpressionField("\103\116\x54", "\103\117\125\116\124\50\111\104\x29"));
    }
}
?>