<?php

namespace VKapi\Market\Export;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class LogTable extends \Bitrix\Main\Entity\DataManager
{
    const TYPE_ERROR = 1;
    const TYPE_NOTICE = 2;
    const TYPE_OK = 4;
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\x61\160\151\x5f\155\x61\x72\x6b\x65\x74\x5f\154\x6f\147";
    }
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\111\x44", array("\160\x72\151\155\141\x72\171" => true, "\141\x75\x74\157\x63\x6f\x6d\x70\154\145\164\145" => true)), new \Bitrix\Main\Entity\IntegerField("\105\130\x50\117\122\124\137\111\x44", array(
            //идентификато экспорта
            "\x72\145\x71\x75\x69\162\x65\x64" => true,
        )), new \Bitrix\Main\Entity\IntegerField("\x54\x59\x50\x45", array(
            //тип
            "\x72\145\161\x75\151\x72\145\x64" => true,
        )), new \Bitrix\Main\Entity\DatetimeField("\103\122\x45\x41\124\x45\x5f\x44\x41\124\x45", array(
            //дата
            "\162\x65\x71\165\151\x72\145\x64" => true,
            "\144\x65\x66\x61\165\154\164\137\166\141\x6c\x75\x65" => new \Bitrix\Main\Type\DateTime(),
        )), new \Bitrix\Main\Entity\StringField("\x4d\x53\107", array(
            //сообщение
            "\162\145\x71\x75\x69\x72\x65\x64" => true,
        )), new \Bitrix\Main\Entity\TextField("\115\x4f\122\105", array(
            //подробности
            "\163\145\x72\x69\x61\x6c\x69\172\145\x64" => true,
            "\144\x65\146\141\165\x6c\x74\137\x76\141\154\165\x65" => array(),
        )), new \Bitrix\Main\Entity\ExpressionField("\x43\x4e\x54", "\x43\x4f\125\116\x54\50\111\104\51"), new \Bitrix\Main\Entity\ReferenceField("\x45\x58\120\x4f\122\x54", "\134\126\113\141\160\x69\x5c\x4d\x61\x72\x6b\145\164\x5c\x45\170\160\157\x72\x74\x54\x61\x62\154\145", array("\x3d\164\150\x69\x73\56\105\x58\120\x4f\122\x54\x5f\111\104" => "\162\145\146\56\111\x44"), array("\152\x6f\151\156\x5f\x74\171\160\x65" => "\x4c\x45\106\124")));
    }
    
    public function deleteAll()
    {
        $ndliiwxivg1jsfq5r30vo72e9rr2h = static::getEntity();
        $zg9iy1v7mtusghrvndaqb9gspfit91m9 = $ndliiwxivg1jsfq5r30vo72e9rr2h->getConnection();
        $zg9iy1v7mtusghrvndaqb9gspfit91m9->query(sprintf("\104\105\114\x45\x54\x45\x20\x46\x52\117\x4d\40\x25\163", $zg9iy1v7mtusghrvndaqb9gspfit91m9->getSqlHelper()->quote($ndliiwxivg1jsfq5r30vo72e9rr2h->getDbTableName())));
        return true;
    }
}

class Log
{
    const LEVEL_NONE = 1;
    
    const LEVEL_OK = 2;
    
    const LEVEL_NOTICE = 4;
    
    const LEVEL_ERROR = 8;
    
    const LEVEL_DEBUG = 16;
    
    protected $level = 1;
    
    protected $memoryUsedOnStart = 0;
    
    protected $table = null;
    
    protected $exportId = null;
    
    public function __construct($c4mminm212 = self::LEVEL_NONE)
    {
        $this->level = $c4mminm212;
        $this->table = new \VKapi\Market\Export\LogTable();
        $this->memoryUsedOnStart = $this->getMemoryUsed();
    }
    
    protected function getMemoryUsed()
    {
        return round(memory_get_usage() / 1024 / 1024, 2);
    }
    
    public function setLevel($js5msm0edjzo5t3c712de7ri8y)
    {
        $this->level = $js5msm0edjzo5t3c712de7ri8y;
    }
    
    public function setExportId($n7rd1lmvayob3dur69wenbi7)
    {
        $this->exportId = intval($n7rd1lmvayob3dur69wenbi7);
    }
    public function exception(\Throwable $nzsypznd14hrd2)
    {
        if ($nzsypznd14hrd2 instanceof \VKapi\Market\Exception\BaseException) {
            $this->error($nzsypznd14hrd2->getMessage(), ["\146\x69\154\145" => $nzsypznd14hrd2->getFile() . "\72" . $nzsypznd14hrd2->getLine(), "\x74\x72\141\143\x65" => $nzsypznd14hrd2->getTraceAsString()]);
        } else {
            $this->error($nzsypznd14hrd2->getMessage() . "\x20\x7c\x20" . $nzsypznd14hrd2->getFile() . "\72" . $nzsypznd14hrd2->getLine() . "\x20\x7c\40" . $nzsypznd14hrd2->getTraceAsString());
        }
    }
    
    public function error($vzx86ud9l7lv4bgkpmo2jzfjwhuhk22r7pp, $sdmf96fpp = array(), $n7rd1lmvayob3dur69wenbi7 = null)
    {
        
        if ($this->level & ~(self::LEVEL_ERROR | self::LEVEL_DEBUG)) {
            return false;
        }
        $this->extendData($sdmf96fpp);
        
        $this->table->add(array("\x45\x58\120\117\122\x54\137\111\104" => intval($n7rd1lmvayob3dur69wenbi7) ?: $this->exportId, "\115\123\x47" => $vzx86ud9l7lv4bgkpmo2jzfjwhuhk22r7pp, "\x4d\117\x52\x45" => $sdmf96fpp, "\124\x59\120\105" => \VKapi\Market\Export\LogTable::TYPE_ERROR));
        return true;
    }
    
    public function ok($vzx86ud9l7lv4bgkpmo2jzfjwhuhk22r7pp, $sdmf96fpp = array(), $n7rd1lmvayob3dur69wenbi7 = null)
    {
        
        if ($this->level & ~(self::LEVEL_OK | self::LEVEL_DEBUG)) {
            return false;
        }
        $this->extendData($sdmf96fpp);
        
        $this->table->add(array("\x45\130\120\117\122\124\x5f\x49\104" => intval($n7rd1lmvayob3dur69wenbi7) ?: $this->exportId, "\x4d\x53\107" => $vzx86ud9l7lv4bgkpmo2jzfjwhuhk22r7pp, "\x4d\x4f\122\105" => $sdmf96fpp, "\x54\131\x50\105" => \VKapi\Market\Export\LogTable::TYPE_OK));
        return true;
    }
    
    public function notice($vzx86ud9l7lv4bgkpmo2jzfjwhuhk22r7pp, $sdmf96fpp = array(), $n7rd1lmvayob3dur69wenbi7 = null)
    {
        
        if ($this->level & ~(self::LEVEL_NOTICE | self::LEVEL_DEBUG)) {
            return false;
        }
        $this->extendData($sdmf96fpp);
        
        $this->table->add(array("\x45\x58\x50\x4f\122\x54\137\111\x44" => intval($n7rd1lmvayob3dur69wenbi7) ?: $this->exportId, "\115\123\x47" => $vzx86ud9l7lv4bgkpmo2jzfjwhuhk22r7pp, "\x4d\117\122\105" => $sdmf96fpp, "\124\131\120\x45" => \VKapi\Market\Export\LogTable::TYPE_NOTICE));
        return true;
    }
    
    protected function extendData(&$sdmf96fpp)
    {
        $sdmf96fpp["\x4d\105\115\117\x52\131"] = $this->getMemoryUsed();
        $sdmf96fpp["\x4d\105\115\x4f\122\131\x5f\x49\x4e\103\122\105\101\x53\105"] = round($sdmf96fpp["\115\x45\115\117\122\x59"] - $this->memoryUsedOnStart, 2);
    }
    
    static function getLevelListForSelect()
    {
        $czjrs0f3nqi05y8267oqq0b022okrjx = array("\122\105\x46\x45\x52\x45\x4e\103\105\137\111\x44" => array(self::LEVEL_NONE, self::LEVEL_OK, self::LEVEL_NOTICE, self::LEVEL_ERROR, self::LEVEL_DEBUG), "\122\x45\106\105\122\105\116\x43\105" => array(\VKapi\Market\Manager::getInstance()->getMessage("\114\117\x47\56\x4c\x45\x56\105\114\x5f\x4e\x4f\x4e\105"), \VKapi\Market\Manager::getInstance()->getMessage("\x4c\x4f\107\x2e\114\x45\x56\x45\114\137\x4f\113"), \VKapi\Market\Manager::getInstance()->getMessage("\x4c\117\107\56\x4c\105\x56\105\114\x5f\116\117\124\111\x43\105"), \VKapi\Market\Manager::getInstance()->getMessage("\114\x4f\x47\56\114\x45\126\x45\x4c\x5f\x45\x52\122\117\x52"), \VKapi\Market\Manager::getInstance()->getMessage("\x4c\117\107\x2e\114\x45\x56\x45\114\x5f\x44\x45\102\x55\107")));
        return $czjrs0f3nqi05y8267oqq0b022okrjx;
    }
    
    static function getTypeListForSelect()
    {
        $czjrs0f3nqi05y8267oqq0b022okrjx = array("\122\105\x46\x45\x52\x45\116\103\105\137\111\x44" => array("", \VKapi\Market\Export\LogTable::TYPE_OK, \VKapi\Market\Export\LogTable::TYPE_NOTICE, \VKapi\Market\Export\LogTable::TYPE_ERROR), "\122\105\x46\105\122\x45\x4e\x43\105" => array(\VKapi\Market\Manager::getInstance()->getMessage("\x4c\x4f\107\56\x54\x59\120\x45\137\116\117\124\137\123\x45\x4c\x45\103\x54\105\104"), \VKapi\Market\Manager::getInstance()->getMessage("\114\117\107\x2e\124\131\x50\x45\x5f\117\x4b"), \VKapi\Market\Manager::getInstance()->getMessage("\114\117\107\x2e\124\x59\x50\105\137\116\117\124\111\103\105"), \VKapi\Market\Manager::getInstance()->getMessage("\114\x4f\x47\x2e\124\x59\120\105\137\x45\x52\x52\117\122")));
        return $czjrs0f3nqi05y8267oqq0b022okrjx;
    }
}
?>