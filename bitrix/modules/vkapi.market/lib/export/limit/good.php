<?php

namespace VKapi\Market\Export\Limit;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Type\DateTime;
use VKapi\Market\Exception\GoodLimitException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class GoodTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\141\160\151\x5f\155\141\x72\153\145\164\137\145\x78\x70\x6f\162\x74\137\154\x69\155\151\x74\x5f\x67\157\x6f\x64";
    }
    
    public static function getMap()
    {
        return [new \Bitrix\Main\Entity\IntegerField("\111\104", ["\160\x72\151\x6d\x61\162\x79" => true, "\x61\165\x74\x6f\x63\x6f\155\x70\154\145\164\x65" => true]), new \Bitrix\Main\Entity\IntegerField("\x45\130\x50\x4f\122\x54\x5f\111\x44", [
            //идентификтор экспорта
            "\x72\145\x71\x75\151\162\145\144" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\107\122\x4f\125\x50\x5f\x49\x44", [
            // идентификтаор группы
            "\x72\145\x71\165\x69\x72\x65\x64" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\x56\x4b\137\x49\104", [
            // идентификтаор товара в VK
            "\x72\145\x71\x75\151\162\x65\x64" => true,
        ]), new \Bitrix\Main\Entity\DatetimeField("\103\122\x45\x41\124\x45\104", ["\162\x65\x71\165\151\x72\x65\x64" => true, "\144\x65\146\141\165\x6c\x74\x5f\x76\141\154\165\x65" => new \Bitrix\Main\Type\DateTime()]), new \Bitrix\Main\Entity\ExpressionField("\x43\116\124", "\103\117\x55\x4e\x54\x28\x49\104\51")];
    }
    
    public static function deleteOld()
    {
        $oq3waatgc8466yhr = new \Bitrix\Main\Type\DateTime();
        $oq3waatgc8466yhr->add("\x2d\40\61\x20\x64\141\171");
        $oq3waatgc8466yhr->add("\x2d\40\61\40\155\x69\x6e\x75\x74\x65");
        $zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu = static::getEntity();
        $f76jfwvq2cvygz7x = $zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu->getConnection();
        return $f76jfwvq2cvygz7x->query(sprintf("\104\105\x4c\105\x54\105\x20\x46\x52\x4f\x4d\40\45\163\x20\127\x48\x45\122\x45\x20\x25\x73", $f76jfwvq2cvygz7x->getSqlHelper()->quote($zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu, ["\74\103\122\x45\x41\x54\105\x44" => $oq3waatgc8466yhr])));
    }
}

class Good
{
    const HOUR_LIMIT = 1000;
    const DAY_LIMIT = 7000;
    
    protected $oExportItem;
    
    protected $oTable;
    public function __construct(\VKapi\Market\Export\Item $a3077odina9r28zmyc8xjw4auj4730)
    {
        $this->oExportItem = $a3077odina9r28zmyc8xjw4auj4730;
    }
    
    public function table()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Export\Limit\GoodTable();
        }
        return $this->oTable;
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    public function append($p5v1i3qmgz86ixaddasx35rpqy)
    {
        $j0g3ripo5br0srs6n7jenfumxyuyf2eww9r = ["\105\x58\x50\x4f\x52\x54\x5f\111\x44" => $this->exportItem()->getId(), "\x47\x52\x4f\125\x50\137\x49\x44" => $this->exportItem()->getGroupId(), "\126\113\137\111\x44" => (int) $p5v1i3qmgz86ixaddasx35rpqy];
        $omyrf638rz9mnhsms16 = $this->table()->add($j0g3ripo5br0srs6n7jenfumxyuyf2eww9r);
        if ($omyrf638rz9mnhsms16->isSuccess()) {
            $omyrf638rz9mnhsms16->getId();
        }
        return null;
    }
    
    public function check()
    {
        $nylton1eobgjvqp0x = new \Bitrix\Main\Type\DateTime();
        $nylton1eobgjvqp0x->add("\55\40\x31\x20\150\x6f\x75\162");
        $rfjfmin6tek = $this->table()->getCount(["\x47\x52\x4f\x55\x50\x5f\111\104" => $this->exportItem()->getGroupId(), "\x3e\103\x52\105\x41\124\105\x44" => $nylton1eobgjvqp0x]);
        if ($rfjfmin6tek >= self::HOUR_LIMIT) {
            throw new \VKapi\Market\Exception\GoodLimitException();
        }
        $elkc3obopw0xl7w3b0supws74pie = new \Bitrix\Main\Type\DateTime();
        $elkc3obopw0xl7w3b0supws74pie->add("\55\40\x32\64\40\150\x6f\x75\162\163");
        $rfjfmin6tek = $this->table()->getCount(["\107\122\117\x55\x50\137\x49\104" => $this->exportItem()->getGroupId(), "\76\103\122\x45\x41\124\105\x44" => $elkc3obopw0xl7w3b0supws74pie]);
        if ($rfjfmin6tek >= self::DAY_LIMIT) {
            throw new \VKapi\Market\Exception\GoodLimitException();
        }
    }
}
?>