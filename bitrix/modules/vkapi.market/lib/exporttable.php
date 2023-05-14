<?php

namespace VKapi\Market;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ExportTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\141\160\151\x5f\155\141\162\x6b\145\x74\x5f\145\170\160\157\162\x74\x5f\154\x69\x73\164";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\111\x44", array(
            // инкримет записи
            "\160\162\151\155\141\x72\171" => true,
            "\141\x75\164\157\143\157\x6d\160\154\145\x74\x65" => true,
        )), new \Bitrix\Main\Entity\StringField("\x53\x49\124\x45\x5f\x49\x44", array(
            //привязка к сайту
            "\x72\x65\x71\165\x69\x72\145\144" => true,
            "\x76\141\x6c\151\144\141\x74\157\162" => function () {
                return array(new \Bitrix\Main\Entity\Validator\Range(2, 2));
            },
        )), new \Bitrix\Main\Entity\IntegerField("\101\103\x43\117\x55\116\124\x5f\x49\104", array(
            //идентификатор добавленного аккаунта, от имени которого выгружать
            "\162\x65\x71\165\151\162\x65\x64" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\x47\x52\x4f\125\120\137\x49\x44", array(
            //идентификатор группы в вконткате, положительное целое число
            "\x72\145\x71\165\x69\x72\145\x64" => true,
        )), new \Bitrix\Main\Entity\StringField("\x47\x52\x4f\x55\120\137\116\x41\x4d\105", array(
            // название группы в вконтакте, для вывода в списке выгрузок
            "\x72\145\161\x75\151\162\x65\144" => true,
        )), new \Bitrix\Main\Entity\StringField("\x4e\101\115\x45", array(
            // название выгрузки
            "\162\x65\161\165\x69\162\145\144" => true,
        )), new \Bitrix\Main\Entity\BooleanField("\x41\103\124\x49\126\x45", array("\162\x65\161\x75\151\x72\x65\x64" => true, "\x64\145\146\x61\165\154\x74" => false)), new \Bitrix\Main\Entity\BooleanField("\101\125\124\x4f", array("\162\x65\161\165\151\x72\x65\144" => true, "\x64\145\x66\x61\x75\154\x74" => true)), new \Bitrix\Main\Entity\IntegerField("\103\x41\x54\101\x4c\x4f\107\137\111\104", array("\x72\145\161\165\151\x72\x65\x64" => true)), new \Bitrix\Main\Entity\TextField("\x41\114\x42\x55\x4d\123", array(
            // подборки
            "\162\145\161\165\151\x72\x65\144" => false,
            "\163\x65\162\151\141\154\x69\x7a\x65\144" => true,
            "\x64\145\x66\141\x75\154\164\137\166\141\154\165\x65" => array(),
        )), new \Bitrix\Main\Entity\TextField("\x50\101\x52\101\x4d\x53", array("\x72\145\x71\x75\151\x72\145\144" => true, "\163\145\162\151\x61\x6c\x69\172\145\x64" => true, "\167\141\151\164\x5f\160\141\162\x61\155\x73\x5f\154\x69\x73\164" => array("\103\x55\x52\122\x45\116\103\x59"))), new \Bitrix\Main\Entity\ExpressionField("\x43\x4e\124", "\x43\117\125\x4e\124\50\111\x44\x29"));
    }
    
    public static function OnBeforeDelete(\Bitrix\Main\Entity\Event $acgq5poeto5ol7z5)
    {
        $q43zd2xlmpaub595hni95lnhy4dwr6v = new \Bitrix\Main\Entity\EventResult();
        $cx7bfn1ynfkbt87jekps0emmuc0p = $acgq5poeto5ol7z5->getParameter("\151\x64");
        if (!isset($cx7bfn1ynfkbt87jekps0emmuc0p["\111\x44"])) {
            return $q43zd2xlmpaub595hni95lnhy4dwr6v;
        }
        $v45elcf75 = $cx7bfn1ynfkbt87jekps0emmuc0p["\111\x44"];
        if (intval($v45elcf75)) {
            $qo66vnv7y3pc5ro = \Bitrix\Main\Application::getConnection();
            $szsn6mifnx = $qo66vnv7y3pc5ro->getSqlHelper();
            
            $qo66vnv7y3pc5ro->query("\104\105\114\105\x54\105\40\x46\x52\117\115\x20\140" . \VKapi\Market\Good\Reference\ExportTable::getTableName() . "\140\x20\127\110\x45\122\x45\x20\105\x58\x50\x4f\x52\124\137\111\104\x3d" . intval($v45elcf75));
            
            $qo66vnv7y3pc5ro->query("\x44\105\x4c\105\124\x45\40\106\122\117\115\40\x60" . \VKapi\Market\Export\LogTable::getTableName() . "\x60\40\x57\110\105\x52\x45\40\x45\130\120\x4f\122\x54\137\x49\x44\x3d" . intval($v45elcf75));
        }
        return $q43zd2xlmpaub595hni95lnhy4dwr6v;
    }
}
?>