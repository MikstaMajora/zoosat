<?php

namespace VKapi\Market\Export;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
use VKapi\Market\Error;
use VKapi\Market\Exception\BaseException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class PhotoTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\x61\160\151\x5f\x6d\141\x72\153\145\164\x5f\145\170\x70\x6f\x72\164\x5f\160\150\157\164\157\137\154\x69\163\164";
    }
    public static function getMap()
    {
        return [
            new \Bitrix\Main\Entity\IntegerField("\111\x44", ["\160\x72\x69\155\x61\162\171" => true, "\141\x75\164\157\143\x6f\x6d\160\154\145\164\145" => true]),
            // идентификатор группы в вконтакте, целое положительное число
            new \Bitrix\Main\Entity\IntegerField("\107\x52\x4f\x55\x50\x5f\111\104", ["\162\145\x71\165\x69\x72\145\144" => true]),
            ///идентификатор файла в битриксе
            new \Bitrix\Main\Entity\IntegerField("\106\111\114\x45\137\x49\x44", ["\162\x65\161\x75\151\x72\145\144" => true]),
            //идентификатор картинки в ВКонтакте
            new \Bitrix\Main\Entity\IntegerField("\x50\x48\x4f\x54\117\x5f\x49\104", ["\162\145\x71\165\x69\162\x65\144" => false]),
            //идентификатор товара, которому принадлежит картинка
            new \Bitrix\Main\Entity\IntegerField("\x50\x49\104", ["\162\x65\161\x75\151\162\x65\144" => false, "\144\145\x66\x61\165\154\164" => null]),
            //идентфикиатор офера
            new \Bitrix\Main\Entity\IntegerField("\x4f\111\104", ["\x72\x65\x71\x75\151\x72\x65\144" => false, "\144\145\146\141\x75\154\164" => null]),
            // главная картинка товара
            new \Bitrix\Main\Entity\IntegerField("\x4d\x41\x49\116", ["\x64\145\146\x61\x75\154\x74" => 0, "\162\145\161\x75\151\x72\145\x64" => false]),
            //хэш картинки, для замены картинки в случае смены  поля с картинкой
            new \Bitrix\Main\Entity\StringField("\x48\101\x53\x48", ["\x64\145\146\x61\x75\154\164" => ""]),
            // хэш  водного знака, для замены картинки в случае изменения параметров наложения водного знака
            new \Bitrix\Main\Entity\StringField("\127\115\137\110\101\x53\x48", []),
            new \Bitrix\Main\Entity\ExpressionField("\103\116\x54", "\x43\117\125\116\x54\x28\111\x44\51"),
        ];
    }
    
    public static function deleteAllByGroupId($u69np4rn555w6j)
    {
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        $qtwqi60t3dvkr->query(sprintf("\104\105\x4c\105\124\x45\40\106\x52\117\x4d\40\45\163\40\x57\x48\x45\x52\105\40\x25\163", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, ["\x47\x52\117\x55\x50\137\111\104" => abs(intval($u69np4rn555w6j))])));
    }
    
    public static function deleteByFileId($htkae8809wqexvbmi, $u69np4rn555w6j = null)
    {
        $jrkdwmyhfoc4x81zzok71aq2hww70p = ["\x46\x49\114\105\x5f\111\x44" => intval($htkae8809wqexvbmi)];
        if (!is_null($u69np4rn555w6j)) {
            $jrkdwmyhfoc4x81zzok71aq2hww70p["\107\x52\117\x55\x50\x5f\111\104"] = abs(intval($u69np4rn555w6j));
        }
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        $qtwqi60t3dvkr->query(sprintf("\104\x45\114\x45\x54\105\x20\106\x52\x4f\x4d\x20\x25\163\40\x57\x48\x45\122\x45\x20\x25\x73", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, $jrkdwmyhfoc4x81zzok71aq2hww70p)));
    }
    
    public function deleteByPhotoId($az8jw79oxzbrcx3vy1psw, $u69np4rn555w6j)
    {
        $az8jw79oxzbrcx3vy1psw = (array) $az8jw79oxzbrcx3vy1psw;
        $az8jw79oxzbrcx3vy1psw = array_map("\x69\x6e\164\x76\x61\x6c", $az8jw79oxzbrcx3vy1psw);
        $az8jw79oxzbrcx3vy1psw = array_diff($az8jw79oxzbrcx3vy1psw, [0]);
        if (empty($az8jw79oxzbrcx3vy1psw)) {
            $az8jw79oxzbrcx3vy1psw = [0];
        }
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        $qtwqi60t3dvkr->query(sprintf("\x44\105\x4c\x45\124\x45\40\x46\x52\x4f\x4d\x20\45\163\40\x57\110\x45\122\105\x20\45\163", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, ["\120\x48\x4f\124\x4f\137\x49\104" => $az8jw79oxzbrcx3vy1psw, "\x47\122\117\125\x50\x5f\111\x44" => abs(intval($u69np4rn555w6j))])));
    }
    
    public function deleteByProduct($gmuvfv3y, $e03kvd, $u69np4rn555w6j)
    {
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        $qtwqi60t3dvkr->query(sprintf("\x44\x45\114\x45\124\x45\40\x46\122\117\x4d\40\45\x73\x20\127\x48\x45\x52\x45\40\x25\x73", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, ["\120\x49\104" => intval($gmuvfv3y), "\x4f\111\x44" => intval($e03kvd), "\x47\122\117\x55\120\137\x49\x44" => abs(intval($u69np4rn555w6j))])));
    }
}

class Photo
{
    
    protected $oTable = null;
    
    protected $oLog = null;
    
    protected $oExportItem = null;
    
    protected $productHash = null;
    
    protected $watermarkHash = null;
    
    protected $watermarkParams = null;
    
    protected $oFile = null;
    
    protected $previewMode = 0;
    
    public function __construct()
    {
        $this->createTemporaryDirectories();
    }
    
    public function setModePreview($jdvrqf7dhvb80n3uims0l)
    {
        $this->previewMode = (bool) $jdvrqf7dhvb80n3uims0l;
        $this->createTemporaryDirectories();
    }
    
    public function isModePreview()
    {
        return $this->previewMode;
    }
    
    public function createTemporaryDirectories()
    {
        \Bitrix\Main\IO\Directory::createDirectory(\Bitrix\Main\Application::getDocumentRoot() . $this->getWatermarkDir());
        \Bitrix\Main\IO\Directory::createDirectory(\Bitrix\Main\Application::getDocumentRoot() . $this->getCanvasDir());
        \Bitrix\Main\IO\Directory::createDirectory(\Bitrix\Main\Application::getDocumentRoot() . $this->getCloudDir());
    }
    
    public function deleteTemporaryDirectories()
    {
        try {
            \Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . $this->getWatermarkDir());
            \Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . $this->getCanvasDir());
            \Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . $this->getCloudDir());
        } catch (\Exception $ld6wgo1m1ry1vogkgd9s0lk51f7qnrm9) {
            
        }
    }
    
    public function setExportItem($r1n4l4jqhqn1lcuc7c1iiu)
    {
        $this->oExportItem = $r1n4l4jqhqn1lcuc7c1iiu;
        $this->log()->setExportId($r1n4l4jqhqn1lcuc7c1iiu->getId());
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    protected function log()
    {
        if (is_null($this->oLog)) {
            $this->oLog = new \VKapi\Market\Export\Log($this->manager()->getLogLevel());
            $this->oLog->setExportId($this->exportItem()->getId());
        }
        return $this->oLog;
    }
    
    private function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    protected function getMessage($n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp = null)
    {
        return $this->manager()->getMessage("\105\x58\x50\117\x52\x54\x2e\120\110\x4f\124\117\x2e" . $n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp);
    }
    
    public function getTable()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Export\PhotoTable();
        }
        return $this->oTable;
    }
    
    public function getFile()
    {
        if (is_null($this->oFile)) {
            $this->oFile = new \CFile();
        }
        return $this->oFile;
    }
    
    protected function getConnection()
    {
        return $this->exportItem()->connection();
    }
    
    public function getHash()
    {
        if (is_null($this->productHash)) {
            $k6ofq5lgsendx9sf6zt1d99upgx = [$this->exportItem()->getOfferPhoto(), $this->exportItem()->getOfferMorePhoto(), $this->exportItem()->getProductPhoto(), $this->exportItem()->getProductMorePhoto(), $this->exportItem()->isEnabledExtendedGoods(), $this->exportItem()->isEnabledOfferCombine()];
            $this->productHash = md5(implode("\174", $k6ofq5lgsendx9sf6zt1d99upgx));
        }
        return $this->productHash;
    }
    
    public function getWatermarkHash()
    {
        if (is_null($this->watermarkHash)) {
            $k6ofq5lgsendx9sf6zt1d99upgx = [$this->exportItem()->getWatermark(), $this->exportItem()->getWatermarkPosition(), $this->exportItem()->getWatermarkOpacity(), $this->exportItem()->getWatermarkCoefficient()];
            $this->watermarkHash = md5(implode("\174", $k6ofq5lgsendx9sf6zt1d99upgx));
        }
        return $this->watermarkHash;
    }
    
    public function isValidHash($jh2pyou43z8zqgfaiokq4wc7ktg98ar)
    {
        return $this->getWatermarkHash() == $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x57\115\x5f\110\101\123\110"] && $this->getHash() == $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x48\x41\123\x48"];
    }
    
    public function deleteByFileId($htkae8809wqexvbmi, $u69np4rn555w6j)
    {
        $this->log()->notice($this->getMessage("\104\x45\x4c\105\124\x45\x5f\102\x59\x5f\106\111\114\105\137\111\104", ["\43\106\x49\114\105\x5f\x49\x44\x23" => $htkae8809wqexvbmi, "\43\107\x52\x4f\125\x50\137\111\x44\x23" => $u69np4rn555w6j]), ["\106\x49\114\x45\137\111\104" => $htkae8809wqexvbmi, "\x47\x52\117\x55\x50\137\111\x44" => $u69np4rn555w6j]);
        $this->getTable()->deleteByFileId($htkae8809wqexvbmi, $u69np4rn555w6j);
    }
    
    public function deleteByPhotoId($az8jw79oxzbrcx3vy1psw, $u69np4rn555w6j)
    {
        $this->log()->notice($this->getMessage("\104\x45\x4c\105\124\x45\137\x42\131\x5f\120\x48\x4f\x54\x4f\137\111\104", ["\x23\x50\x48\117\x54\x4f\x5f\x49\104\43" => implode("\54\40", $az8jw79oxzbrcx3vy1psw), "\43\107\x52\x4f\125\120\137\111\x44\43" => $u69np4rn555w6j]), ["\x50\110\117\124\x4f\x5f\x49\x44" => $az8jw79oxzbrcx3vy1psw, "\x47\x52\x4f\x55\120\137\x49\104" => $u69np4rn555w6j]);
        $this->getTable()->deleteByPhotoId($az8jw79oxzbrcx3vy1psw, $u69np4rn555w6j);
    }
    
    public function exportAlbumPictures($jm116v9yiq0flu008s0257a26l0fv0f939g)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        
        $jm116v9yiq0flu008s0257a26l0fv0f939g = array_combine($jm116v9yiq0flu008s0257a26l0fv0f939g, $jm116v9yiq0flu008s0257a26l0fv0f939g);
        $aqiqu9od63uzu86l37 = [];
        
        if (\CModule::IncludeModuleEx("\166\x6b\x61\160\151\x2e\155" . "\x61\x72" . "\153" . "\145\x74") === constant("\115\117\x44\x55\114\x45\137\x44\105\x4d\x4f\137\105\x58\x50" . "\111" . "" . "\122" . "\x45\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\101\120\111\56\x4d\101\x52\113\105\124" . "\x2e\104\x45\115\x4f\137\105\130\x50\x49\122\x45" . "\x44"), "\x42\x58\x4d\101\113\105\122\137\x44\105\x4d\x4f\137\x45\x58" . "" . "\x50\x49\122\x45" . "\x44");
        }
        
        $beburcf5lt = $this->getTable()->getList(["\x66\x69\154\164\145\162" => ["\x47\x52\117\125\x50\137\x49\104" => $this->exportItem()->getGroupId(), "\106\111\x4c\x45\137\111\x44" => array_values($jm116v9yiq0flu008s0257a26l0fv0f939g)]]);
        while ($jh2pyou43z8zqgfaiokq4wc7ktg98ar = $beburcf5lt->fetch()) {
            
            if ($this->getWatermarkHash() != $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\127\115\x5f\110\101\x53\x48"] || !$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\120\110\117\x54\x4f\x5f\111\104"]) {
                $this->log()->notice($this->getMessage("\105\130\120\117\x52\124\137\101\114\102\x55\x4d\137\x50\x49\x43\x54\125\x52\x45\123\x2e\x44\105\114\x45\124\x45\x5f\117\x4c\x44\x5f\x52\x4f\x57", ["\43\106\111\114\x45\x5f\x49\x44\43" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\111\x4c\x45\137\x49\104"]]), ["\x46\x49\x4c\105\x5f\111\x44" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x46\111\114\105\x5f\x49\104"]]);
                $this->getTable()->delete($jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x49\104"]);
            } else {
                
                unset($jm116v9yiq0flu008s0257a26l0fv0f939g[$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x46\111\x4c\105\x5f\111\x44"]]);
                
                $aqiqu9od63uzu86l37[$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\111\114\105\x5f\x49\x44"]] = \VKapi\Market\Result::create(["\111\104" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\111\x4c\105\x5f\111\104"], "\120\x48\117\x54\117\x5f\111\x44" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x50\x48\117\124\x4f\137\111\x44"]]);
            }
        }
        
        if (count($jm116v9yiq0flu008s0257a26l0fv0f939g)) {
            $p08qxbhxmb0rarzqd704rnqjkaz5p71 = $this->addAlbumPhotoToVk($jm116v9yiq0flu008s0257a26l0fv0f939g);
            if ($p08qxbhxmb0rarzqd704rnqjkaz5p71->isSuccess()) {
                foreach ($p08qxbhxmb0rarzqd704rnqjkaz5p71->getData("\151\164\145\x6d\163") as $htkae8809wqexvbmi => $mljrrpybc) {
                    $aqiqu9od63uzu86l37[$htkae8809wqexvbmi] = $mljrrpybc;
                }
            } else {
                
                return $jc7ai89g->setError($p08qxbhxmb0rarzqd704rnqjkaz5p71->getFirstError());
            }
        }
        if (\Bitrix\Main\Loader::includeSharewareModule("\166\x6b" . "" . "\x61" . "\x70\x69\x2e\x6d\141\x72\x6b" . "\x65" . "" . "" . "\164") == constant("\115\117\x44\125\x4c\105\x5f\x44\x45\115\x4f\x5f\105\x58\120\111\122\105\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\101" . "\120\111\56\115\101\122\x4b\105\124\56\x44\105\x4d\117\137" . "\105" . "\x58\x50\111" . "" . "\122\x45\x44"), "\x42\x58\x4d\101\113\x45\x52\137\104\x45\115\x4f\137\x45\130\x50\111\x52" . "" . "\x45" . "\104");
        }
        
        $jc7ai89g->setData("\151\x74\x65\x6d\x73", $aqiqu9od63uzu86l37);
        return $jc7ai89g;
    }
    
    public function deleteAlbumPhotoFromVk($muwfr1)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        if (empty($muwfr1)) {
            return $jc7ai89g;
        }
        $v5zb9qgv07fmojknqgk = [];
        
        $oevw66w25dk8rgsid2h9x21rmp = array_chunk($muwfr1, 25, true);
        foreach ($oevw66w25dk8rgsid2h9x21rmp as $r27h4a3nt2dgh6pvf9784qt81a) {
            if (empty($r27h4a3nt2dgh6pvf9784qt81a)) {
                continue;
            }
            $cf3w7c0teje44m6cpsgfy2 = [];
            foreach ($r27h4a3nt2dgh6pvf9784qt81a as $ji0u4b1ds90nkn5f19iw631itldr6 => $wa3da3luj96b4ujzgcnsrq) {
                $cf3w7c0teje44m6cpsgfy2[] = "\42\x70" . $ji0u4b1ds90nkn5f19iw631itldr6 . "\42\x20\x3a\40\x41\x50\111\56\x70\150\x6f\x74\x6f\x73\56\x64\x65\x6c\145\164\x65\50\x7b\x22\x6f\167\156\145\162\137\x69\x64\42\40\72\40\42\55" . $this->exportItem()->getGroupId() . "\x22\x2c\42\x70\150\x6f\x74\x6f\x5f\151\x64\x22\40\x3a\40" . $wa3da3luj96b4ujzgcnsrq . "\175\51";
            }
            $ejszvrh5yqwsjgfetju = $this->exportItem()->connection()->method("\145\170\145\143\165\164\145", ["\x63\157\x64\145" => "\x72\x65\x74\165\162\x6e\x20\x7b" . implode("\x2c", $cf3w7c0teje44m6cpsgfy2) . "\x7d\x3b"]);
            if ($ejszvrh5yqwsjgfetju->isSuccess()) {
                $erblcqkbs = $ejszvrh5yqwsjgfetju->getData("\162\x65\x73\x70\157\156\x73\145");
                foreach ($r27h4a3nt2dgh6pvf9784qt81a as $ji0u4b1ds90nkn5f19iw631itldr6 => $wa3da3luj96b4ujzgcnsrq) {
                    $v5zb9qgv07fmojknqgk[$ji0u4b1ds90nkn5f19iw631itldr6] = $erblcqkbs["\160" . $ji0u4b1ds90nkn5f19iw631itldr6];
                }
            } else {
                return $jc7ai89g->setError($ejszvrh5yqwsjgfetju->getFirstError());
            }
        }
        if (\Bitrix\Main\Loader::includeSharewareModule("\166\x6b\141\x70\x69\56\155\x61\162\153" . "\x65\164") === constant("\x4d\x4f\104\x55\114\x45\137\104\x45" . "" . "\115\117\137\105\x58\120\x49\x52\x45\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\101\120\x49\56\x4d\101\122\113\105\124\x2e\x44\x45" . "\115\117\x5f\x45\x58\x50" . "\x49\x52" . "" . "\x45" . "" . "\104"), "\102\130\115\x41\113" . "\x45\x52\x5f\x44\x45\x4d\117\x5f" . "\x45\x58\x50\x49\x52" . "\x45" . "\104");
        }
        $jc7ai89g->setData("\x69\164\145\155\x73", $v5zb9qgv07fmojknqgk);
        return $jc7ai89g;
    }
    
    public function checkExistsAlbumPhotoFromVk($tzxte)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        if (empty($tzxte)) {
            return $jc7ai89g;
        }
        $hrugthm = [];
        
        $paqpm7uju9cc6k3iaxiod = [];
        
        $l61ol3jlcusdd3rmdp5hl4vb9n = null;
        
        foreach ($tzxte as $jh2pyou43z8zqgfaiokq4wc7ktg98ar) {
            $paqpm7uju9cc6k3iaxiod[$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\111\104"]] = "\x2d" . $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\107\x52\117\x55\x50\137\111\104"] . "\137" . $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x50\x48\x4f\124\117\x5f\111\104"];
        }
        
        $ejszvrh5yqwsjgfetju = $this->exportItem()->connection()->method("\x70\150\157\x74\157\163\x2e\x67\x65\164\102\x79\111\144", ["\160\150\x6f\164\157\163" => implode("\x2c", array_values($paqpm7uju9cc6k3iaxiod)), "\x70\x68\x6f\x74\157\137\163\151\172\145\163" => 0]);
        if ($ejszvrh5yqwsjgfetju->isSuccess()) {
            $erblcqkbs = $ejszvrh5yqwsjgfetju->getData("\162\x65\163\160\x6f\x6e\163\145");
            
            $ts65cu1p = array_flip($paqpm7uju9cc6k3iaxiod);
            foreach ($erblcqkbs as $ok19wm) {
                $hrugthm[] = $ts65cu1p[$ok19wm["\157\167\x6e\x65\162\137\x69\144"] . "\137" . $ok19wm["\151\x64"]];
            }
        } else {
            return $jc7ai89g->setError($ejszvrh5yqwsjgfetju->getFirstError());
        }
        if (\CModule::IncludeModuleEx("\166\x6b\x61" . "\x70\x69\x2e\155\x61\x72\153\x65" . "" . "\164") == constant("\x4d\x4f\104\125\x4c\105\x5f\x44\x45\x4d\x4f\137\x45" . "\x58" . "" . "\120\x49\x52\x45\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\x41\120\111\x2e\115\101" . "\122" . "\x4b\x45\124\x2e\x44\x45\x4d" . "" . "\x4f\x5f" . "\x45\x58\120\x49" . "\x52\x45\x44"), "\102\130\115\101\113\x45\122\137\x44\x45\x4d\117\137\x45\x58\120\x49\122" . "\105\104");
        }
        $jc7ai89g->setData("\x69\x74\145\155\163", $hrugthm);
        return $jc7ai89g;
    }
    
    public function addAlbumPhotoToVk($jm116v9yiq0flu008s0257a26l0fv0f939g)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $m8o13uygyagjzt1amhrnpk5k0 = [];
        
        $cn6vtelyf598uvojoh7cdbd1797 = [];
        
        if (empty($jm116v9yiq0flu008s0257a26l0fv0f939g)) {
            return $jc7ai89g;
        }
        
        $gu40ufp6pk9mind4u3k89ik = null;
        $ysi3ncziv5tpzf8 = $this->getAlbumUploadServer();
        if ($ysi3ncziv5tpzf8->isSuccess()) {
            $gu40ufp6pk9mind4u3k89ik = $ysi3ncziv5tpzf8->getData("\165\160\154\157\x61\x64\137\165\162\x6c");
        } else {
            $this->log()->error($this->getMessage("\101\104\104\x5f\x41\114\102\x55\x4d\x5f\120\110\x4f\124\117\137\124\117\x5f\126\113\56\x45\122\x52\117\x52\x5f\x41\114\x42\125\x4d\x5f\x55\x50\114\117\101\104\x5f\x53\x45\x52\x56\105\122", ["\43\x43\117\x44\x45\43" => $ysi3ncziv5tpzf8->getFirstErrorCode(), "\43\x4d\123\x47\x23" => $ysi3ncziv5tpzf8->getFirstErrorMessage()]), ["\x45\x52\x52\x4f\x52\x5f\x4d\117\x52\105" => $ysi3ncziv5tpzf8->getFirstErrorMore()]);
            return $ysi3ncziv5tpzf8;
        }
        if (\Bitrix\Main\Loader::includeSharewareModule("\166\153\x61\x70\151\x2e\x6d\x61\162\x6b" . "" . "" . "\145" . "\164") === constant("\115\117\104\125\114\x45\x5f\x44\105\x4d\x4f\x5f\105\x58\120\x49" . "" . "\122\105\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\x41\x50\111\x2e\x4d\101\122\x4b\x45\124\56\104\105\x4d\x4f\137\105\130\x50\x49\x52\x45\x44"), "\x42\x58\x4d\x41\x4b\x45\122\137\104\105\115\117\x5f\x45\130\120\x49\x52\x45\104");
        }
        
        $z031np41zlhklp = $this->prepareAlbumFiles($jm116v9yiq0flu008s0257a26l0fv0f939g);
        if ($z031np41zlhklp->isSuccess()) {
            $x3h5tuqhvl195awbgwn6x4ilfechrhkvx = $z031np41zlhklp->getData("\x69\164\x65\x6d\x73");
            if (empty($x3h5tuqhvl195awbgwn6x4ilfechrhkvx)) {
                return $jc7ai89g;
            }
        } else {
            if (!$z031np41zlhklp->isTimeoutError()) {
                $this->log()->error($z031np41zlhklp->getFirstErrorMessage(), $z031np41zlhklp->getFirstErrorMore());
            }
            return $z031np41zlhklp;
        }
        
        foreach ($x3h5tuqhvl195awbgwn6x4ilfechrhkvx as $htkae8809wqexvbmi => $snk0q1sgqh6xtuc) {
            
            $this->manager()->checkTime();
            
            if (!$snk0q1sgqh6xtuc->isSuccess()) {
                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $snk0q1sgqh6xtuc;
                continue;
            }
            try {
                $mz14ga2krk9rnpmq6upc = $this->exportItem()->connection()->sendFiles($gu40ufp6pk9mind4u3k89ik, ["\146\151\x6c\145" => $snk0q1sgqh6xtuc->getData("\x50\x41\124\x48")]);
                if ($mz14ga2krk9rnpmq6upc->isSuccess()) {
                    
                    $sqt5whvrzynyndqnycl3s0kwtqlz09f3 = $mz14ga2krk9rnpmq6upc->getData();
                    if (isset($sqt5whvrzynyndqnycl3s0kwtqlz09f3["\x67\x69\144"])) {
                        $sqt5whvrzynyndqnycl3s0kwtqlz09f3["\x67\162\157\x75\160\x5f\151\x64"] = $sqt5whvrzynyndqnycl3s0kwtqlz09f3["\x67\151\144"];
                    }
                    
                    $nf1q3cxhghp3 = $this->exportItem()->connection()->method("\x70\150\x6f\x74\x6f\x73\56\x73\141\166\x65\x4d\141\162\153\x65\164\101\154\142\165\x6d\120\150\x6f\164\157", $sqt5whvrzynyndqnycl3s0kwtqlz09f3);
                    if ($nf1q3cxhghp3->isSuccess()) {
                        $mmtrlwu27qveqtm6jebpt9ha = $nf1q3cxhghp3->getData("\162\x65\163\x70\x6f\156\x73\145");
                        $mmtrlwu27qveqtm6jebpt9ha = $mmtrlwu27qveqtm6jebpt9ha[0];
                        if (intval($mmtrlwu27qveqtm6jebpt9ha["\151\144"]) > 0) {
                            $j9o64k6m7jibg1kfmhqv31jgotwj = ["\106\111\x4c\x45\x5f\x49\x44" => $htkae8809wqexvbmi, "\107\x52\117\x55\x50\x5f\111\x44" => $this->exportItem()->getGroupId(), "\120\x48\117\x54\117\137\x49\x44" => $mmtrlwu27qveqtm6jebpt9ha["\x69\x64"], "\x50\x49\x44" => 0, "\117\x49\104" => 0, "\115\x41\x49\x4e" => 0, "\110\101\123\x48" => $this->getHash(), "\x57\115\x5f\x48\x41\x53\x48" => $this->getWatermarkHash()];
                            
                            $gdc20vsvwm0aes5gfizrm10tvow7 = $this->getTable()->add($j9o64k6m7jibg1kfmhqv31jgotwj);
                            if ($gdc20vsvwm0aes5gfizrm10tvow7->isSuccess()) {
                                
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9 = new \VKapi\Market\Result();
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9->setData("\x50\110\x4f\x54\117\x5f\x49\104", $mmtrlwu27qveqtm6jebpt9ha["\151\144"]);
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9->setData("\111\x44", $gdc20vsvwm0aes5gfizrm10tvow7->getId());
                                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9;
                                $this->log()->ok($this->getMessage("\101\x44\x44\x5f\101\x4c\102\125\115\x5f\120\110\x4f\124\117\x5f\124\117\x5f\126\113\x2e\x53\x41\126\105\137\x41\114\x42\125\x4d\x5f\x46\111\114\x45\137\117\x4b", ["\x23\106\111\114\105\x5f\111\x44\43" => $htkae8809wqexvbmi, "\x23\x50\110\117\x54\117\137\111\x44\43" => $mmtrlwu27qveqtm6jebpt9ha["\x69\x64"]]), ["\106\111\x4c\105\x5f\x49\104" => $htkae8809wqexvbmi, "\x50\110\x4f\124\117\x5f\x49\x44" => $mmtrlwu27qveqtm6jebpt9ha["\x69\144"]]);
                            } else {
                                $ucgd89xow4i6r = $gdc20vsvwm0aes5gfizrm10tvow7->getErrorCollection()->toArray();
                                $z5xpxj0td6wmd4hv = reset($ucgd89xow4i6r);
                                
                                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = new \VKapi\Market\Result(new \VKapi\Market\Error($z5xpxj0td6wmd4hv->getMessage(), $z5xpxj0td6wmd4hv->getCode()));
                                $this->log()->error($this->getMessage("\x41\x44\x44\137\x41\x4c\x42\125\x4d\137\x50\110\117\x54\x4f\137\124\117\137\x56\x4b\56\x45\x52\x52\x4f\x52\x5f\x4c\x4f\103\101\x4c\137\x53\101\126\105\137\x52\x4f\x57\x5f\x41\x4c\102\125\x4d\x5f\x46\x49\114\105", ["\43\106\x49\114\x45\137\111\104\x23" => $htkae8809wqexvbmi, "\x23\103\117\x44\105\x23" => $z5xpxj0td6wmd4hv->getCode(), "\43\115\x53\x47\43" => $z5xpxj0td6wmd4hv->getMessage()]), ["\x46\111\x4c\x45\x5f\x49\x44" => $htkae8809wqexvbmi, "\106\x49\105\114\104\123" => $j9o64k6m7jibg1kfmhqv31jgotwj]);
                            }
                        } else {
                            $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = new \VKapi\Market\Result(new \VKapi\Market\Error($this->getMessage("\x41\x44\x44\x5f\101\x4c\x42\125\x4d\137\120\x48\x4f\x54\x4f\x5f\124\117\x5f\126\113\56\105\x52\122\117\x52\x5f\123\101\126\105\x5f\101\x4c\102\x55\115\137\x50\110\x4f\x54\x4f\137\105\x4d\x50\124\x59\137\111\104", ["\x23\x46\x49\x4c\105\x5f\111\x44\43" => $htkae8809wqexvbmi])));
                            $this->log()->error($this->getMessage("\101\104\x44\137\x41\114\x42\x55\x4d\137\120\110\117\x54\x4f\x5f\124\x4f\137\126\x4b\56\x45\122\x52\117\x52\137\x53\101\x56\x45\x5f\x41\x4c\102\x55\x4d\x5f\x50\x48\117\124\117\x5f\105\115\120\124\x59\x5f\x49\x44", ["\x23\106\111\x4c\x45\x5f\x49\x44\x23" => $htkae8809wqexvbmi]), ["\106\111\114\x45\137\x49\104" => $htkae8809wqexvbmi, "\x52\x45\123\x50\117\116\123\x45" => $nf1q3cxhghp3]);
                        }
                    } else {
                        $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $nf1q3cxhghp3;
                        $this->log()->notice($this->getMessage("\101\104\104\x5f\101\114\x42\125\x4d\x5f\x50\110\x4f\x54\x4f\x5f\x54\x4f\x5f\126\x4b\x2e\x45\x52\x52\x4f\122\x5f\123\x41\126\x45\x5f\x41\114\102\125\115\x5f\x46\111\x4c\x45", ["\x23\106\x49\114\x45\137\111\x44\x23" => $htkae8809wqexvbmi, "\43\103\117\104\x45\x23" => $nf1q3cxhghp3->getFirstErrorCode(), "\x23\x4d\x53\x47\x23" => $nf1q3cxhghp3->getFirstErrorMessage()]), ["\106\x49\114\x45\137\111\x44" => $htkae8809wqexvbmi, "\105\x52\122\x4f\122\x5f\115\x4f\122\x45" => $nf1q3cxhghp3->getFirstErrorMore()]);
                    }
                } else {
                    $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $mz14ga2krk9rnpmq6upc;
                    $this->log()->notice($this->getMessage("\x41\104\x44\x5f\101\x4c\102\125\x4d\x5f\120\x48\117\124\x4f\137\x54\x4f\137\126\x4b\56\x45\x52\x52\x4f\x52\x5f\x53\105\116\x44\137\101\114\x42\125\115\137\x46\111\x4c\x45", ["\43\106\x49\114\105\137\x49\x44\x23" => $htkae8809wqexvbmi, "\x23\x43\117\x44\105\x23" => $mz14ga2krk9rnpmq6upc->getFirstErrorCode(), "\x23\x4d\123\107\x23" => $mz14ga2krk9rnpmq6upc->getFirstErrorMessage()]), ["\106\111\114\105\x5f\111\x44" => $htkae8809wqexvbmi, "\105\x52\x52\117\x52\x5f\x4d\117\x52\105" => $mz14ga2krk9rnpmq6upc->getFirstErrorMore()]);
                }
            } catch (\VKapi\Market\Exception\UnknownResponseException $lgm0v) {
                $mz14ga2krk9rnpmq6upc = new \VKapi\Market\Result();
                $mz14ga2krk9rnpmq6upc->addError($lgm0v->getMessage(), $lgm0v->getCustomCode());
                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $mz14ga2krk9rnpmq6upc;
                $this->log()->notice($this->getMessage("\101\104\x44\x5f\101\x4c\x42\x55\115\x5f\120\x48\117\124\117\x5f\x54\x4f\137\126\x4b\56\x45\122\122\117\122\137\123\x45\116\104\137\x41\x4c\102\125\115\137\x46\x49\114\x45", ["\x23\x46\x49\x4c\105\x5f\x49\x44\43" => $htkae8809wqexvbmi, "\43\x43\x4f\x44\105\x23" => $lgm0v->getCustomCode(), "\x23\115\x53\x47\43" => $lgm0v->getMessage()]), ["\x46\x49\x4c\105\x5f\111\104" => $htkae8809wqexvbmi, "\105\x52\x52\117\122\x5f\x4d\x4f\122\105" => []]);
            }
        }
        $jc7ai89g->setData("\x69\164\x65\155\163", $m8o13uygyagjzt1amhrnpk5k0);
        return $jc7ai89g;
    }
    
    public function getAlbumUploadServer()
    {
        $jc7ai89g = new \VKapi\Market\Result();
        
        $bf3gkviav212t1bk0xe0kz0f12 = $this->exportItem()->connection()->method("\x70\150\157\164\157\x73\56\147\x65\x74\115\x61\x72\153\145\x74\x41\154\142\x75\155\x55\x70\x6c\157\x61\144\x53\145\x72\166\x65\162", ["\x67\162\157\165\160\x5f\151\144" => $this->exportItem()->getGroupId()]);
        if ($bf3gkviav212t1bk0xe0kz0f12->isSuccess()) {
            $erblcqkbs = $bf3gkviav212t1bk0xe0kz0f12->getData("\x72\145\x73\160\157\156\163\145");
            if (isset($erblcqkbs["\x75\x70\154\157\141\x64\137\x75\x72\x6c"])) {
                $jc7ai89g->setData("\x75\x70\x6c\157\x61\144\x5f\165\162\154", $erblcqkbs["\165\x70\x6c\157\x61\x64\137\165\x72\154"]);
            }
        } else {
            return $bf3gkviav212t1bk0xe0kz0f12;
        }
        return $jc7ai89g;
    }
    
    public function prepareAlbumFiles($jm116v9yiq0flu008s0257a26l0fv0f939g)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $hyho1v7omsx805b3kyovmsw99 = [];
        
        foreach ($jm116v9yiq0flu008s0257a26l0fv0f939g as $htkae8809wqexvbmi) {
            $mljrrpybc = new \VKapi\Market\Result();
            $mljrrpybc->setData("\x49\x44", $htkae8809wqexvbmi);
            
            $this->manager()->checkTime();
            do {
                
                $fn20wxj1c1nsya4tqjqv7mf7 = $this->getFile()->GetFileArray(intval($htkae8809wqexvbmi));
                if (!$fn20wxj1c1nsya4tqjqv7mf7) {
                    $mljrrpybc->addError($this->getMessage("\120\x52\x45\120\x49\122\105\x5f\x41\x4c\102\125\x4d\x5f\106\x49\x4c\x45\123\56\x4e\117\x54\x5f\106\117\x55\116\104", ["\x23\x46\x49\114\x45\x5f\111\104\43" => $htkae8809wqexvbmi]), "\106\111\114\105\x5f\116\117\x54\x5f\106\117\x55\116\104", ["\106\111\x4c\105\x5f\x49\x44" => $htkae8809wqexvbmi]);
                    break;
                }
                
                if (!preg_match("\x2f\x5c\x2e\152\x70\145\77\147\x24\x7c\x5c\x2e\x70\x6e\x67\44\x7c\134\x2e\147\x69\x66\174\134\x2e\x77\x65\142\x70\44\x2f\151", $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\103"], $grit72wdj37imqi17708o927za70unhuc4)) {
                    $mljrrpybc->addError($this->getMessage("\x50\x52\105\x50\x49\x52\x45\x5f\x41\114\x42\x55\x4d\137\106\x49\x4c\x45\123\x2e\105\x52\x52\x4f\122\x5f\106\x49\114\x45\x5f\x46\117\x52\x4d\x41\x54", ["\43\x46\111\x4c\105\137\111\x44\43" => $htkae8809wqexvbmi, "\43\x46\x49\114\105\137\123\122\103\43" => $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\103"]]), "\106\111\x4c\105\137\x46\117\x52\x4d\x41\124", ["\106\x49\114\105\137\111\x44" => $htkae8809wqexvbmi, "\106\x49\114\105\137\x53\x52\x43" => $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\x43"]]);
                    break;
                }
                
                $this->downloadFileFromCloud($fn20wxj1c1nsya4tqjqv7mf7);
                
                if (!file_exists(\Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"])) {
                    $mljrrpybc->addError($this->getMessage("\x50\122\105\x50\111\x52\x45\x5f\x41\114\x42\125\x4d\x5f\106\x49\114\105\x53\56\116\117\124\x5f\x46\x4f\125\116\x44\137\x4f\116\137\x44\111\x53\x4b", ["\x23\106\x49\x4c\105\137\x49\104\x23" => $htkae8809wqexvbmi, "\43\106\111\114\105\137\x53\122\103\x23" => $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\x43"]]), "\106\x49\x4c\105\x5f\x4e\x4f\124\x5f\106\117\x55\x4e\x44", ["\x46\111\114\x45\137\x49\104" => $htkae8809wqexvbmi, "\x46\x49\114\105\137\123\122\103" => $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"]]);
                    break;
                }
                
                $this->convertFromWebp($fn20wxj1c1nsya4tqjqv7mf7);
                
                $this->restoreRealFileSizes($fn20wxj1c1nsya4tqjqv7mf7);
                
                $this->prepareCanvas($fn20wxj1c1nsya4tqjqv7mf7, 1280, 720);
                $mljrrpybc->setData("\120\x41\x54\x48", \Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\103"]);
            } while (false);
            $hyho1v7omsx805b3kyovmsw99[$fn20wxj1c1nsya4tqjqv7mf7["\111\x44"]] = $mljrrpybc;
        }
        $jc7ai89g->setData("\151\x74\145\x6d\163", $hyho1v7omsx805b3kyovmsw99);
        return $jc7ai89g;
    }
    
    public function downloadFileFromCloud(&$fn20wxj1c1nsya4tqjqv7mf7)
    {
        if (!intval($fn20wxj1c1nsya4tqjqv7mf7["\x48\101\116\x44\x4c\105\x52\x5f\111\104"]) || mb_substr($fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\103"], 0, 4) != "\150\x74\x74\160") {
            return false;
        }
        $b8zhlbdaxjrq628iixcvk6f17ojol6 = $this->getCloudDir(true);
        $q6o17hd2 = \Bitrix\Main\Application::getDocumentRoot();
        $a81penkme = explode("\56", $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"]);
        $vp98k5w72np9w0lwbc = $fn20wxj1c1nsya4tqjqv7mf7["\111\x44"] . "\x2e" . end($a81penkme);
        \Bitrix\Main\IO\Directory::createDirectory($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6);
        
        if (!file_exists($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc)) {
            $heu3rp55e6u4b5s = new \Bitrix\Main\Web\HttpClient();
            $heu3rp55e6u4b5s->download($fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"], $q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc);
            
            if ($heu3rp55e6u4b5s->getStatus() == 200) {
                $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\103"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
            }
        } else {
            $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
        }
    }
    
    public function prepareToSquare(&$fn20wxj1c1nsya4tqjqv7mf7)
    {
        $w8dypv88hjcblfnwe4s2r95l = max($fn20wxj1c1nsya4tqjqv7mf7["\127\111\x44\124\x48"], $fn20wxj1c1nsya4tqjqv7mf7["\110\x45\111\x47\110\124"]);
        if ($fn20wxj1c1nsya4tqjqv7mf7["\x57\x49\104\x54\x48"] == $fn20wxj1c1nsya4tqjqv7mf7["\x48\105\111\107\110\124"]) {
            return true;
        }
        $this->prepareCanvas($fn20wxj1c1nsya4tqjqv7mf7, $w8dypv88hjcblfnwe4s2r95l, $w8dypv88hjcblfnwe4s2r95l, true);
    }
    
    public function prepareCanvas(&$fn20wxj1c1nsya4tqjqv7mf7, $idramj2088atml1jh = 400, $i418e55lcno2ahxw = 400, $zwcj7ssze1m7lg = false)
    {
        $q6o17hd2 = \Bitrix\Main\Application::getDocumentRoot();
        $b8zhlbdaxjrq628iixcvk6f17ojol6 = $this->getCanvasDir() . "\57\x6d" . $idramj2088atml1jh . "\x78" . $i418e55lcno2ahxw . "\57";
        \Bitrix\Main\IO\Directory::createDirectory($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6);
        
        $fn20wxj1c1nsya4tqjqv7mf7["\123\x4f\125\122\103\x45"] = $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\x43"];
        $a81penkme = explode("\56", $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"]);
        $vp98k5w72np9w0lwbc = $fn20wxj1c1nsya4tqjqv7mf7["\x49\x44"] . "\x2e" . end($a81penkme);
        
        $lb94m21rxn6x1mnw = max($fn20wxj1c1nsya4tqjqv7mf7["\127\x49\104\x54\110"], $idramj2088atml1jh);
        $s6oh4e4htg6 = max($fn20wxj1c1nsya4tqjqv7mf7["\x48\105\x49\x47\110\x54"], $i418e55lcno2ahxw);
        
        if ($zwcj7ssze1m7lg) {
            $lb94m21rxn6x1mnw = $s6oh4e4htg6 = min(max($lb94m21rxn6x1mnw, $s6oh4e4htg6), 7000);
        }
        
        $mj9baek = $lb94m21rxn6x1mnw + $s6oh4e4htg6;
        if ($mj9baek > 14000) {
            $yo32pe1b3y4v2vqg04559ww = 14000 / $mj9baek;
            $lb94m21rxn6x1mnw = $lb94m21rxn6x1mnw * $yo32pe1b3y4v2vqg04559ww;
            $s6oh4e4htg6 = $s6oh4e4htg6 * $yo32pe1b3y4v2vqg04559ww;
        }
        try {
            
            $this->prepareMaxSize($fn20wxj1c1nsya4tqjqv7mf7, $lb94m21rxn6x1mnw, $s6oh4e4htg6);
            
            $ll8jnub3nzntgyrtd0u = $fn20wxj1c1nsya4tqjqv7mf7["\x57\x49\x44\x54\110"];
            $b9e62w = $fn20wxj1c1nsya4tqjqv7mf7["\x48\x45\111\107\x48\x54"];
            
            if ($ll8jnub3nzntgyrtd0u < $lb94m21rxn6x1mnw || $b9e62w < $s6oh4e4htg6) {
                
                if (!file_exists($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc)) {
                    
                    if (function_exists("\151\155\x61\147\145\x63\x72\x65\141\164\145\164\162\x75\145\x63\157\154\157\162")) {
                        $jnq7mw557kq7rzqc451 = \imagecreatetruecolor($lb94m21rxn6x1mnw, $s6oh4e4htg6);
                    } else {
                        $jnq7mw557kq7rzqc451 = \ImageCreate($lb94m21rxn6x1mnw, $s6oh4e4htg6);
                    }
                    
                    $xe818m5jpyhn39o9lklgczx433vt1eseqms = \imagecolorallocate($jnq7mw557kq7rzqc451, 255, 255, 255);
                    imagefill($jnq7mw557kq7rzqc451, 0, 0, $xe818m5jpyhn39o9lklgczx433vt1eseqms);
                    
                    if ($fn20wxj1c1nsya4tqjqv7mf7["\x43\x4f\x4e\x54\x45\x4e\124\137\124\131\120\105"] == "\x69\x6d\x61\147\x65\x2f\147\151\x66") {
                        $hgoae = \Imagecreatefromgif($q6o17hd2 . $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"]);
                    } else {
                        if ($fn20wxj1c1nsya4tqjqv7mf7["\103\x4f\x4e\124\x45\116\124\137\124\131\120\x45"] == "\151\x6d\141\147\145\57\160\156\x67") {
                            $hgoae = \Imagecreatefrompng($q6o17hd2 . $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\103"]);
                        } else {
                            $hgoae = \Imagecreatefromjpeg($q6o17hd2 . $fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\x43"]);
                        }
                    }
                    
                    $ck0gsnt1vr7lur63atbp82dxr0gv9hstbe4 = (int) (($lb94m21rxn6x1mnw - $ll8jnub3nzntgyrtd0u) / 2);
                    $nt08w57en5 = (int) (($s6oh4e4htg6 - $b9e62w) / 2);
                    if (function_exists("\x69\x6d\x61\147\145\x63\157\x70\171\x72\145\163\141\155\x70\154\x65\x64")) {
                        \ImageCopyResampled($jnq7mw557kq7rzqc451, $hgoae, $ck0gsnt1vr7lur63atbp82dxr0gv9hstbe4, $nt08w57en5, 0, 0, $ll8jnub3nzntgyrtd0u, $b9e62w, $ll8jnub3nzntgyrtd0u, $b9e62w);
                    } else {
                        \ImageCopyResized($jnq7mw557kq7rzqc451, $hgoae, $ck0gsnt1vr7lur63atbp82dxr0gv9hstbe4, $nt08w57en5, 0, 0, $ll8jnub3nzntgyrtd0u, $b9e62w, $ll8jnub3nzntgyrtd0u, $b9e62w);
                    }
                    
                    \imagejpeg($jnq7mw557kq7rzqc451, $q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc, 100);
                }
                
                $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
                
                $fn20wxj1c1nsya4tqjqv7mf7["\x57\111\x44\x54\x48"] = $lb94m21rxn6x1mnw;
                $fn20wxj1c1nsya4tqjqv7mf7["\110\x45\x49\x47\110\124"] = $s6oh4e4htg6;
                unset($jnq7mw557kq7rzqc451, $ck0gsnt1vr7lur63atbp82dxr0gv9hstbe4, $nt08w57en5, $hgoae, $tjxd8to5lm1k7qmkrvyojqfp, $xe818m5jpyhn39o9lklgczx433vt1eseqms, $kbbtktu6n16uyb922u0ds5b5z99eue34or, $ll8jnub3nzntgyrtd0u, $b9e62w, $q6o17hd2, $zwcj7ssze1m7lg);
            }
        } catch (\Exception $ld6wgo1m1ry1vogkgd9s0lk51f7qnrm9) {
            
            $this->log()->notice($ld6wgo1m1ry1vogkgd9s0lk51f7qnrm9->getMessage(), ["\x61\162\x46\151\154\145" => [$fn20wxj1c1nsya4tqjqv7mf7["\111\104"], $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\x43"]], "\105\130\x43\x45\x50\124\x49\117\116" => [$ld6wgo1m1ry1vogkgd9s0lk51f7qnrm9->getMessage(), $ld6wgo1m1ry1vogkgd9s0lk51f7qnrm9->getTraceAsString()]]);
        }
    }
    
    public function prepareWatermark(&$fn20wxj1c1nsya4tqjqv7mf7)
    {
        $p3zuy8ajyuk = $this->getWatermarkParams();
        
        if ($p3zuy8ajyuk && file_exists($p3zuy8ajyuk["\123\x52\103"])) {
            $q6o17hd2 = \Bitrix\Main\Application::getDocumentRoot();
            $b8zhlbdaxjrq628iixcvk6f17ojol6 = $this->getWatermarkDir() . DIRECTORY_SEPARATOR;
            $a81penkme = explode("\56", $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\x43"]);
            $vp98k5w72np9w0lwbc = $fn20wxj1c1nsya4tqjqv7mf7["\x49\104"] . "\x2e" . end($a81penkme);
            $dkpsf21o4k0ec6kac9vp5hhf1o = $q6o17hd2 . $fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\x43"];
            $mspa8p = $q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
            if (file_exists($mspa8p . "\x2e\x68\x61\163\150") && file_get_contents($mspa8p . "\x2e\x68\141\163\150") == $p3zuy8ajyuk["\x48\101\123\110"]) {
                $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
            } else {
                $n7lrdtogiijvbs29v = ["\156\x61\155\x65" => "\x77\141\164\x65\x72\x6d\141\162\x6b", "\160\x6f\x73\x69\x74\x69\157\156" => $p3zuy8ajyuk["\x50\117\x53\111\x54\x49\117\x4e"], "\x73\151\172\x65" => "\x72\145\141\x6c", "\x74\x79\160\145" => "\151\155\x61\147\x65", "\141\154\x70\150\x61\x5f\x6c\145\166\145\154" => $p3zuy8ajyuk["\117\120\x41\x43\111\124\131"], "\146\151\x6c\x65" => $p3zuy8ajyuk["\x53\122\103"]];
                
                if ($p3zuy8ajyuk["\120\x4f\123\111\124\111\117\x4e"] == "\x46\111\114\114") {
                    $n7lrdtogiijvbs29v["\x70\157\x73\151\x74\x69\x6f\156"] = "\164\154";
                    $n7lrdtogiijvbs29v["\146\x69\154\154"] = "\x72\145\x70\x65\141\x74";
                } else {
                    
                    $n7lrdtogiijvbs29v["\163\x69\x7a\145"] = "\x62\x69\x67";
                    $n7lrdtogiijvbs29v["\x66\x69\154\154"] = "\x72\145\163\151\172\x65";
                    $n7lrdtogiijvbs29v["\143\x6f\x65\146\146\x69\143\151\x65\156\x74"] = $p3zuy8ajyuk["\103\117\105\x46\106\x49\x43\x49\x45\116\124"];
                }
                \Bitrix\Main\IO\Directory::createDirectory($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6);
                @unlink($mspa8p);
                $this->getFile()->ResizeImageFile($dkpsf21o4k0ec6kac9vp5hhf1o, $mspa8p, [], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, $n7lrdtogiijvbs29v, 100);
                $fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\103"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
                
                file_put_contents($mspa8p . "\x2e\x68\x61\163\x68", $p3zuy8ajyuk["\x48\101\123\110"]);
                unset($n7lrdtogiijvbs29v);
            }
            unset($dkpsf21o4k0ec6kac9vp5hhf1o, $mspa8p);
        }
        unset($p3zuy8ajyuk, $b8zhlbdaxjrq628iixcvk6f17ojol6, $vp98k5w72np9w0lwbc);
    }
    
    public function getWatermarkParams()
    {
        if (is_null($this->watermarkParams)) {
            $this->watermarkParams = false;
            if ($this->exportItem()->getWatermark()) {
                $vzhwfeeetnhmxou91olykhmv = ["\124\114", "\x54\x43", "\x54\122", "\x4d\114", "\x4d\103", "\115\x52", "\102\x4c", "\102\x43", "\102\x52"];
                $t4qpafqn = in_array($this->exportItem()->getWatermarkPosition(), $vzhwfeeetnhmxou91olykhmv) ? strtolower($this->exportItem()->getWatermarkPosition()) : "\155\x63";
                $fn20wxj1c1nsya4tqjqv7mf7 = $this->getFile()->GetFileArray($this->exportItem()->getWatermark());
                
                $this->restoreRealFileSizes($fn20wxj1c1nsya4tqjqv7mf7);
                $this->watermarkParams = ["\123\x52\103" => \Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"], "\120\x4f\123\x49\124\x49\117\116" => $t4qpafqn, "\x4f\120\101\x43\x49\124\x59" => abs(100 - $this->exportItem()->getWatermarkOpacity()), "\103\x4f\105\106\106\x49\103\111\105\116\x54" => $this->exportItem()->getWatermarkCoefficient()];
                $this->watermarkParams["\x48\x41\x53\110"] = md5(serialize($this->watermarkParams));
            }
        }
        return $this->watermarkParams;
    }
    
    public function getItemsByFileId(array $jm116v9yiq0flu008s0257a26l0fv0f939g, $u69np4rn555w6j = null)
    {
        $w06qefa881q4fa = [];
        $jm116v9yiq0flu008s0257a26l0fv0f939g = array_diff(array_map("\x69\156\164\x76\x61\x6c", $jm116v9yiq0flu008s0257a26l0fv0f939g), [0]);
        if (empty($jm116v9yiq0flu008s0257a26l0fv0f939g)) {
            return $w06qefa881q4fa;
        }
        $jrkdwmyhfoc4x81zzok71aq2hww70p = ["\106\x49\x4c\x45\137\111\104" => $jm116v9yiq0flu008s0257a26l0fv0f939g];
        if (!is_null($u69np4rn555w6j)) {
            $jrkdwmyhfoc4x81zzok71aq2hww70p["\107\x52\117\x55\x50\x5f\x49\x44"] = $u69np4rn555w6j;
        }
        $n8x76cvzpajf9k0qt8b6443ey = $this->getTable()->getList(["\x66\x69\x6c\164\x65\162" => $jrkdwmyhfoc4x81zzok71aq2hww70p]);
        while ($v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs = $n8x76cvzpajf9k0qt8b6443ey->fetch()) {
            $w06qefa881q4fa[$v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs["\x46\111\114\x45\x5f\x49\x44"]] = $v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs;
        }
        return $w06qefa881q4fa;
    }
    
    public function exportProductPictures($jm116v9yiq0flu008s0257a26l0fv0f939g, $a0amgbyxzfxd4yq = false, $gmuvfv3y = 0, $e03kvd = 0)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $aqiqu9od63uzu86l37 = [];
        
        if (empty($jm116v9yiq0flu008s0257a26l0fv0f939g)) {
            return $jc7ai89g->setData("\151\x74\x65\x6d\163", $aqiqu9od63uzu86l37);
        }
        
        $jm116v9yiq0flu008s0257a26l0fv0f939g = array_combine($jm116v9yiq0flu008s0257a26l0fv0f939g, $jm116v9yiq0flu008s0257a26l0fv0f939g);
        $jrkdwmyhfoc4x81zzok71aq2hww70p = ["\x47\122\117\x55\120\137\x49\104" => $this->exportItem()->getGroupId(), "\106\111\114\105\x5f\111\x44" => array_values($jm116v9yiq0flu008s0257a26l0fv0f939g), "\120\x49\x44" => $gmuvfv3y, "\117\x49\104" => $e03kvd, "\115\x41\111\116" => 0];
        if ($a0amgbyxzfxd4yq) {
            $jrkdwmyhfoc4x81zzok71aq2hww70p["\115\x41\x49\116"] = 1;
        }
        
        if ($this->manager()->isDisabledUpdatePicture()) {
            $r7uo0843ts4tyirklbf4k5p0667n8d = ["\x47\122\117\x55\x50\x5f\x49\104" => $this->exportItem()->getGroupId(), "\x50\111\104" => $gmuvfv3y, "\117\x49\x44" => $e03kvd, "\115\101\x49\x4e" => 0];
            if ($a0amgbyxzfxd4yq) {
                $r7uo0843ts4tyirklbf4k5p0667n8d["\115\101\111\x4e"] = 1;
            }
            $iamb7b = false;
            $beburcf5lt = $this->getTable()->getList(["\x66\151\x6c\164\x65\162" => $r7uo0843ts4tyirklbf4k5p0667n8d]);
            while ($jh2pyou43z8zqgfaiokq4wc7ktg98ar = $beburcf5lt->fetch()) {
                $iamb7b = true;
                
                $aqiqu9od63uzu86l37[$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x46\x49\x4c\105\x5f\x49\104"]] = \VKapi\Market\Result::create(["\111\x44" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x49\x44"], "\106\x49\114\105\x5f\111\104" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x46\111\x4c\x45\x5f\x49\x44"], "\120\x48\117\124\x4f\137\x49\x44" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x50\110\x4f\x54\117\x5f\x49\x44"]]);
            }
            if ($iamb7b) {
                
                $jc7ai89g->setData("\151\164\x65\x6d\163", $aqiqu9od63uzu86l37);
                return $jc7ai89g;
            }
        }
        if (\Bitrix\Main\Loader::includeSharewareModule("\x76" . "\153" . "\x61\x70\x69\x2e\155\x61\x72\x6b" . "" . "\145\164") == constant("\x4d\117\104\125\x4c\x45\x5f\x44\x45\115\x4f\137\x45\x58\x50\111\x52\x45" . "" . "\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\101\120\x49\x2e\115" . "\101\x52\x4b\105\x54" . "\x2e\x44\105" . "\x4d\x4f\137\x45\x58\x50\111" . "\122\x45\104"), "\x42\x58\115\x41\113" . "\105\122\137\x44\x45\x4d\117\137\x45\130\120\x49\x52" . "\105\104");
        }
        
        $beburcf5lt = $this->getTable()->getList(["\x66\151\x6c\x74\145\162" => $jrkdwmyhfoc4x81zzok71aq2hww70p]);
        while ($jh2pyou43z8zqgfaiokq4wc7ktg98ar = $beburcf5lt->fetch()) {
            
            if ($this->getWatermarkHash() != $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\127\x4d\x5f\x48\x41\123\x48"] || !$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\120\110\117\124\x4f\x5f\x49\104"]) {
                $this->log()->notice($this->getMessage("\x45\x58\120\x4f\x52\124\137\x50\x52\x4f\104\125\x43\x54\137\x50\x49\x43\x54\125\x52\105\123\56\x45\122\122\117\122\x5f\114\x4f\x43\x41\x4c\x5f\x53\101\x56\x45\x5f\122\117\x57\137\x41\x4c\x42\x55\115\x5f\x46\x49\x4c\105", ["\x23\106\x49\114\x45\137\111\x44\x23" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\111\x4c\105\x5f\111\x44"]]), ["\106\111\114\x45\137\x49\104" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\x49\x4c\105\137\111\104"]]);
                $this->getTable()->delete($jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x49\104"]);
            } else {
                
                unset($jm116v9yiq0flu008s0257a26l0fv0f939g[$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\111\114\105\137\111\104"]]);
                
                $aqiqu9od63uzu86l37[$jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x46\111\114\105\137\111\x44"]] = \VKapi\Market\Result::create(["\111\104" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x49\104"], "\x46\x49\x4c\x45\x5f\x49\104" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\106\111\114\x45\x5f\x49\104"], "\x50\110\117\124\117\137\x49\104" => $jh2pyou43z8zqgfaiokq4wc7ktg98ar["\x50\x48\117\x54\x4f\x5f\111\x44"]]);
            }
        }
        
        if (count($jm116v9yiq0flu008s0257a26l0fv0f939g)) {
            $p08qxbhxmb0rarzqd704rnqjkaz5p71 = $this->addProductPhotoToVk($jm116v9yiq0flu008s0257a26l0fv0f939g, $a0amgbyxzfxd4yq, $gmuvfv3y, $e03kvd);
            if ($p08qxbhxmb0rarzqd704rnqjkaz5p71->isSuccess()) {
                $yngwtglkqx4xnbl = $p08qxbhxmb0rarzqd704rnqjkaz5p71->getData("\x69\164\145\155\163");
                foreach ($yngwtglkqx4xnbl as $htkae8809wqexvbmi => $mljrrpybc) {
                    $aqiqu9od63uzu86l37[$htkae8809wqexvbmi] = $mljrrpybc;
                }
            } else {
                
                return $jc7ai89g->setError($p08qxbhxmb0rarzqd704rnqjkaz5p71->getFirstError());
            }
        }
        
        $jc7ai89g->setData("\x69\x74\x65\x6d\x73", $aqiqu9od63uzu86l37);
        return $jc7ai89g;
    }
    
    public function addProductPhotoToVk($jm116v9yiq0flu008s0257a26l0fv0f939g, $a0amgbyxzfxd4yq = false, $gmuvfv3y = 0, $e03kvd = 0)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $m8o13uygyagjzt1amhrnpk5k0 = [];
        
        $x3h5tuqhvl195awbgwn6x4ilfechrhkvx = [];
        
        $jc7ai89g->setData("\151\x74\145\155\163", $m8o13uygyagjzt1amhrnpk5k0);
        if (empty($jm116v9yiq0flu008s0257a26l0fv0f939g)) {
            return $jc7ai89g;
        }
        
        $gu40ufp6pk9mind4u3k89ik = null;
        $ysi3ncziv5tpzf8 = $this->getProductUploadServer($a0amgbyxzfxd4yq);
        if ($ysi3ncziv5tpzf8->isSuccess()) {
            $gu40ufp6pk9mind4u3k89ik = $ysi3ncziv5tpzf8->getData("\x75\x70\x6c\x6f\141\x64\x5f\x75\x72\x6c");
        } else {
            $this->log()->error($this->getMessage("\101\104\x44\x5f\120\122\117\x44\125\x43\124\x5f\x50\x48\117\x54\x4f\x5f\124\x4f\x5f\126\x4b\x2e\105\122\x52\117\122\137\x55\x50\x4c\x4f\101\x44\137\123\105\122\126\x45\122", ["\x23\103\117\104\x45\x23" => $ysi3ncziv5tpzf8->getFirstErrorCode(), "\x23\x4d\x53\x47\43" => $ysi3ncziv5tpzf8->getFirstErrorMessage()]), ["\105\x52\x52\117\122\x5f\x4d\117\x52\105" => $ysi3ncziv5tpzf8->getFirstErrorMore()]);
            return $ysi3ncziv5tpzf8;
        }
        
        $z031np41zlhklp = $this->prepareProductFiles($jm116v9yiq0flu008s0257a26l0fv0f939g);
        if ($z031np41zlhklp->isSuccess()) {
            $x3h5tuqhvl195awbgwn6x4ilfechrhkvx = $z031np41zlhklp->getData("\x69\x74\x65\x6d\x73");
        } else {
            if (!$z031np41zlhklp->isTimeoutError()) {
                $this->log()->error($z031np41zlhklp->getFirstErrorMessage(), $z031np41zlhklp->getFirstErrorMore());
            }
            return $z031np41zlhklp;
        }
        
        foreach ($x3h5tuqhvl195awbgwn6x4ilfechrhkvx as $htkae8809wqexvbmi => $snk0q1sgqh6xtuc) {
            if (!$snk0q1sgqh6xtuc->isSuccess()) {
                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $snk0q1sgqh6xtuc;
                unset($x3h5tuqhvl195awbgwn6x4ilfechrhkvx[$htkae8809wqexvbmi]);
            }
        }
        if (empty($x3h5tuqhvl195awbgwn6x4ilfechrhkvx)) {
            return $jc7ai89g;
        }
        
        $oevw66w25dk8rgsid2h9x21rmp = array_chunk($x3h5tuqhvl195awbgwn6x4ilfechrhkvx, 5, true);
        foreach ($oevw66w25dk8rgsid2h9x21rmp as $r27h4a3nt2dgh6pvf9784qt81a) {
            if (empty($r27h4a3nt2dgh6pvf9784qt81a)) {
                continue;
            }
            
            $this->manager()->checkTime();
            
            $ma35jebfeu506spo2k8knozxs8tp2yfuo31 = array_keys($r27h4a3nt2dgh6pvf9784qt81a);
            $rgidqxfv3klr0 = [];
            $rnbzi7ao1k1m = 1;
            
            foreach ($r27h4a3nt2dgh6pvf9784qt81a as $htkae8809wqexvbmi => $snk0q1sgqh6xtuc) {
                $rgidqxfv3klr0["\146\151\154\x65" . $rnbzi7ao1k1m++] = $snk0q1sgqh6xtuc->getData("\x50\101\x54\x48");
            }
            try {
                $mz14ga2krk9rnpmq6upc = $this->exportItem()->connection()->sendFiles($gu40ufp6pk9mind4u3k89ik, $rgidqxfv3klr0);
                if ($mz14ga2krk9rnpmq6upc->isSuccess()) {
                    
                    $sqt5whvrzynyndqnycl3s0kwtqlz09f3 = $mz14ga2krk9rnpmq6upc->getData();
                    $sqt5whvrzynyndqnycl3s0kwtqlz09f3["\x67\x72\x6f\165\x70\137\x69\x64"] = $this->exportItem()->getGroupId();
                    
                    $nf1q3cxhghp3 = $this->exportItem()->connection()->method("\x70\150\157\x74\x6f\x73\56\x73\141\x76\x65\115\x61\162\x6b\x65\164\x50\150\157\164\x6f", $sqt5whvrzynyndqnycl3s0kwtqlz09f3);
                    if ($nf1q3cxhghp3->isSuccess()) {
                        $mmtrlwu27qveqtm6jebpt9ha = $nf1q3cxhghp3->getData("\162\x65\163\x70\x6f\x6e\163\x65");
                        foreach ($mmtrlwu27qveqtm6jebpt9ha as $erg9k25twpby7dxt7axjp248j3bx4nj9 => $b8n5td) {
                            $htkae8809wqexvbmi = $ma35jebfeu506spo2k8knozxs8tp2yfuo31[$erg9k25twpby7dxt7axjp248j3bx4nj9];
                            $j9o64k6m7jibg1kfmhqv31jgotwj = ["\x46\111\x4c\105\x5f\x49\104" => $htkae8809wqexvbmi, "\x47\122\117\125\120\x5f\111\104" => $this->exportItem()->getGroupId(), "\120\110\x4f\124\x4f\x5f\111\x44" => $b8n5td["\x69\x64"], "\x50\x49\x44" => $gmuvfv3y, "\117\111\104" => $e03kvd, "\x4d\x41\x49\116" => $a0amgbyxzfxd4yq ? 1 : 0, "\110\101\x53\x48" => $this->getHash(), "\x57\115\x5f\110\x41\123\x48" => $this->getWatermarkHash()];
                            
                            $ez7sg6 = $this->getTable()->add($j9o64k6m7jibg1kfmhqv31jgotwj);
                            if ($ez7sg6->isSuccess()) {
                                
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9 = new \VKapi\Market\Result();
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9->setData("\120\x48\117\124\117\137\x49\x44", $b8n5td["\151\144"]);
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9->setData("\x46\x49\114\105\x5f\111\104", $htkae8809wqexvbmi);
                                $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9->setData("\111\x44", $ez7sg6->getId());
                                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $ifihguqxupygp83z3ld2qjmt0zwm2vrmg9;
                                $this->log()->ok($this->getMessage("\x41\x44\104\x5f\x50\122\117\x44\x55\103\124\x5f\120\110\117\124\x4f\137\124\117\x5f\x56\x4b\x2e\123\101\x56\105\x5f\101\114\x42\125\x4d\x5f\106\x49\114\105\137\x4f\x4b", ["\43\106\x49\x4c\105\137\111\x44\x23" => $htkae8809wqexvbmi, "\43\120\110\117\x54\117\x5f\111\104\43" => $b8n5td["\151\x64"]]));
                            } else {
                                $qkpf4dydbfx4ogwsw365h9agnt9o3 = $ez7sg6->getErrorCollection()->toArray();
                                $z5xpxj0td6wmd4hv = reset($qkpf4dydbfx4ogwsw365h9agnt9o3);
                                
                                $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = new \VKapi\Market\Result(new \VKapi\Market\Error($z5xpxj0td6wmd4hv->getMessage(), $z5xpxj0td6wmd4hv->getCode()));
                                $this->log()->notice($this->getMessage("\x41\104\104\137\x50\x52\x4f\104\x55\103\124\x5f\x50\x48\117\x54\117\137\124\x4f\137\126\x4b\x2e\105\122\122\x4f\x52\137\114\x4f\103\x41\x4c\x5f\x53\101\x56\x45\x5f\122\x4f\127\x5f\x41\114\x42\125\x4d\137\x46\x49\114\x45", ["\43\x46\x49\x4c\105\137\x49\x44\43" => $htkae8809wqexvbmi, "\x23\103\x4f\104\x45\x23" => $z5xpxj0td6wmd4hv->getFirstErrorCode(), "\43\115\123\x47\43" => $z5xpxj0td6wmd4hv->getFirstErrorMessage()]), ["\x46\111\x4c\105\x5f\111\104" => $htkae8809wqexvbmi, "\106\111\x45\x4c\x44\x53" => $j9o64k6m7jibg1kfmhqv31jgotwj]);
                            }
                        }
                    } else {
                        foreach ($ma35jebfeu506spo2k8knozxs8tp2yfuo31 as $htkae8809wqexvbmi) {
                            $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $nf1q3cxhghp3;
                        }
                        $this->log()->notice($this->getMessage("\101\x44\x44\137\120\x52\x4f\x44\x55\103\124\x5f\120\x48\x4f\124\x4f\137\124\x4f\x5f\x56\x4b\x2e\x45\x52\122\117\122\x5f\123\x41\126\x45\137\106\x49\114\x45", ["\43\x46\111\x4c\105\x5f\111\104\43" => implode("\54\x20", $ma35jebfeu506spo2k8knozxs8tp2yfuo31), "\43\x43\117\x44\x45\x23" => $nf1q3cxhghp3->getFirstErrorCode(), "\43\x4d\x53\x47\43" => $nf1q3cxhghp3->getFirstErrorMessage()]), ["\x46\x49\114\105\x5f\x49\x44" => $ma35jebfeu506spo2k8knozxs8tp2yfuo31, "\105\122\122\x4f\122\x5f\115\117\122\x45" => $nf1q3cxhghp3->getFirstErrorMore()]);
                    }
                } else {
                    foreach ($ma35jebfeu506spo2k8knozxs8tp2yfuo31 as $htkae8809wqexvbmi) {
                        $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $mz14ga2krk9rnpmq6upc;
                    }
                    $this->log()->notice($this->getMessage("\101\x44\x44\x5f\120\122\x4f\x44\x55\x43\124\137\x50\110\x4f\x54\x4f\x5f\124\x4f\x5f\126\x4b\56\x45\x52\x52\117\122\137\123\105\116\x44\x5f\x46\x49\x4c\105", ["\43\x46\111\x4c\x45\137\111\104\43" => implode("\54\x20", $ma35jebfeu506spo2k8knozxs8tp2yfuo31), "\x23\103\x4f\104\105\x23" => $mz14ga2krk9rnpmq6upc->getFirstErrorCode(), "\x23\x4d\123\x47\43" => $mz14ga2krk9rnpmq6upc->getFirstErrorMessage()]), ["\106\x49\114\x45\137\111\104" => $ma35jebfeu506spo2k8knozxs8tp2yfuo31, "\x45\x52\122\x4f\x52\x5f\x4d\x4f\x52\105" => $mz14ga2krk9rnpmq6upc->getFirstErrorMore()]);
                }
            } catch (\VKapi\Market\Exception\UnknownResponseException $lgm0v) {
                $mz14ga2krk9rnpmq6upc = new \VKapi\Market\Result();
                $mz14ga2krk9rnpmq6upc->addError($lgm0v->getMessage(), $lgm0v->getCustomCode());
                foreach ($ma35jebfeu506spo2k8knozxs8tp2yfuo31 as $htkae8809wqexvbmi) {
                    $m8o13uygyagjzt1amhrnpk5k0[$htkae8809wqexvbmi] = $mz14ga2krk9rnpmq6upc;
                }
                $this->log()->notice($this->getMessage("\x41\x44\x44\x5f\120\x52\x4f\x44\125\103\124\137\120\x48\x4f\x54\x4f\x5f\124\x4f\x5f\126\x4b\x2e\105\x52\x52\117\122\x5f\123\x45\x4e\104\137\106\x49\x4c\105", ["\x23\x46\x49\x4c\x45\x5f\x49\104\43" => implode("\x2c\40", $ma35jebfeu506spo2k8knozxs8tp2yfuo31), "\x23\x43\x4f\104\105\43" => $lgm0v->getCustomCode(), "\x23\115\x53\107\43" => $lgm0v->getMessage()]), ["\106\x49\x4c\x45\137\111\104" => $ma35jebfeu506spo2k8knozxs8tp2yfuo31, "\x45\x52\x52\x4f\122\x5f\115\x4f\122\105" => []]);
            }
        }
        $jc7ai89g->setData("\151\164\x65\x6d\163", $m8o13uygyagjzt1amhrnpk5k0);
        return $jc7ai89g;
    }
    
    public function getProductUploadServer($a0amgbyxzfxd4yq = false)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $arParams = ["\147\162\x6f\165\160\x5f\151\144" => $this->exportItem()->getGroupId()];
        if ($a0amgbyxzfxd4yq) {
            $arParams["\155\141\151\x6e\137\160\x68\157\164\157"] = 1;
        }
        
        $bf3gkviav212t1bk0xe0kz0f12 = $this->exportItem()->connection()->method("\x70\150\157\164\x6f\163\56\x67\145\x74\115\x61\162\153\145\x74\125\160\x6c\157\x61\144\123\145\x72\x76\145\162", $arParams);
        if ($bf3gkviav212t1bk0xe0kz0f12->isSuccess()) {
            $erblcqkbs = $bf3gkviav212t1bk0xe0kz0f12->getData("\x72\145\163\x70\157\156\163\145");
            if (isset($erblcqkbs["\x75\x70\154\x6f\141\x64\137\165\162\x6c"])) {
                $jc7ai89g->setData("\165\x70\154\x6f\x61\x64\x5f\165\162\154", $erblcqkbs["\165\160\x6c\157\x61\144\x5f\x75\162\x6c"]);
            }
        } else {
            return $bf3gkviav212t1bk0xe0kz0f12;
        }
        return $jc7ai89g;
    }
    
    public function prepareProductFiles($jm116v9yiq0flu008s0257a26l0fv0f939g)
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $hyho1v7omsx805b3kyovmsw99 = [];
        
        foreach ($jm116v9yiq0flu008s0257a26l0fv0f939g as $htkae8809wqexvbmi) {
            
            $this->manager()->checkTime();
            $snk0q1sgqh6xtuc = new \VKapi\Market\Result();
            $snk0q1sgqh6xtuc->setData("\x49\104", $htkae8809wqexvbmi);
            do {
                
                $fn20wxj1c1nsya4tqjqv7mf7 = $this->getFile()->GetFileArray(intval($htkae8809wqexvbmi));
                if (!$fn20wxj1c1nsya4tqjqv7mf7) {
                    $snk0q1sgqh6xtuc->addError($this->getMessage("\x50\122\105\x50\x49\122\105\x5f\x50\122\x4f\104\x55\103\x54\x5f\106\111\114\x45\x53\x2e\x46\x49\114\105\137\x4e\x4f\x54\x5f\106\x4f\x55\x4e\x44", ["\x23\x46\x49\x4c\105\x5f\111\104\43" => $htkae8809wqexvbmi]), "\106\111\114\x45\x5f\x4e\x4f\124\137\106\x4f\125\x4e\x44", ["\x46\111\114\105\137\x49\104" => $htkae8809wqexvbmi]);
                    break;
                }
                
                if (!preg_match("\x2f\134\56\152\x70\x65\77\147\44\174\134\x2e\x70\x6e\147\44\x7c\x5c\56\147\151\146\x7c\x5c\56\167\x65\142\x70\44\x2f\x69", $fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\x43"], $grit72wdj37imqi17708o927za70unhuc4)) {
                    $snk0q1sgqh6xtuc->addError($this->getMessage("\120\x52\x45\120\111\x52\x45\137\120\x52\x4f\x44\125\x43\124\x5f\x46\111\x4c\105\x53\x2e\x45\x52\x52\117\122\x5f\106\111\x4c\105\x5f\x46\x4f\122\115\x41\x54", ["\43\x46\111\x4c\x45\137\111\104\x23" => $htkae8809wqexvbmi, "\43\106\x49\114\x45\137\123\122\103\x23" => $fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\x43"]]), "\x46\x49\x4c\105\137\x46\117\x52\115\101\x54", ["\x46\x49\114\x45\x5f\x49\x44" => $htkae8809wqexvbmi, "\x46\x49\x4c\x45\137\123\122\x43" => $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"]]);
                    break;
                }
                
                if ($fn20wxj1c1nsya4tqjqv7mf7["\x57\111\104\124\x48"] + $fn20wxj1c1nsya4tqjqv7mf7["\110\105\111\107\110\124"] > 14000) {
                    $snk0q1sgqh6xtuc->addError($this->getMessage("\120\122\x45\x50\x49\122\x45\137\x50\x52\117\x44\x55\x43\124\x5f\x46\x49\x4c\x45\123\56\105\122\x52\x4f\x52\137\106\x49\x4c\x45\137\115\x41\x58\x5f\123\111\x5a\105", ["\43\106\x49\x4c\105\137\x49\104\43" => $htkae8809wqexvbmi, "\43\x46\x49\114\x45\137\x53\122\x43\43" => $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"], "\x23\123\x49\132\105\43" => $fn20wxj1c1nsya4tqjqv7mf7["\x57\111\x44\124\x48"] + $fn20wxj1c1nsya4tqjqv7mf7["\x48\105\x49\107\110\124"]]), "\x46\111\114\x45\137\x4d\x41\x58\x5f\123\111\132\x45", ["\106\x49\114\x45\137\x49\x44" => $htkae8809wqexvbmi, "\106\111\114\105\x5f\123\x52\x43" => $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"], "\123\111\132\105" => $fn20wxj1c1nsya4tqjqv7mf7["\x57\x49\104\124\x48"] + $fn20wxj1c1nsya4tqjqv7mf7["\110\x45\x49\107\x48\124"]]);
                    break;
                }
                
                $this->downloadFileFromCloud($fn20wxj1c1nsya4tqjqv7mf7);
                
                if (!file_exists(\Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"])) {
                    $snk0q1sgqh6xtuc->addError($this->getMessage("\120\x52\x45\120\x49\122\105\x5f\x50\x52\117\x44\125\103\124\x5f\106\111\114\105\x53\x2e\x4e\x4f\x54\x5f\x46\x4f\x55\x4e\x44\137\x4f\116\x5f\x44\x49\123\113", ["\x23\x46\111\114\x45\137\x49\104\x23" => $htkae8809wqexvbmi, "\x23\x46\111\x4c\105\137\123\x52\103\x23" => $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"]]), "\x46\111\114\x45\137\x4e\x4f\124\137\106\117\x55\x4e\x44\137\117\x4e\137\x44\111\x53\x43", ["\106\111\x4c\105\x5f\111\104" => $htkae8809wqexvbmi, "\106\x49\114\x45\x5f\x53\122\103" => $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"]]);
                    break;
                }
                
                $this->restoreRealFileSizes($fn20wxj1c1nsya4tqjqv7mf7);
                
                if ($fn20wxj1c1nsya4tqjqv7mf7["\x57\111\104\x54\110"] + $fn20wxj1c1nsya4tqjqv7mf7["\x48\x45\111\x47\x48\124"] > 14000) {
                    $snk0q1sgqh6xtuc->addError($this->getMessage("\x50\122\x45\120\x49\x52\105\x5f\120\122\x4f\x44\125\x43\124\x5f\106\111\x4c\x45\x53\x2e\x45\122\122\117\x52\x5f\x46\111\x4c\105\137\x4d\x41\130\x5f\x53\x49\x5a\x45", ["\43\106\111\114\105\137\x49\104\43" => $htkae8809wqexvbmi, "\43\106\111\x4c\105\x5f\x53\122\x43\x23" => $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\x43"], "\x23\123\111\x5a\x45\x23" => $fn20wxj1c1nsya4tqjqv7mf7["\127\x49\x44\124\110"] + $fn20wxj1c1nsya4tqjqv7mf7["\110\105\x49\107\x48\x54"]]), "\106\x49\114\x45\x5f\x4d\x41\x58\137\123\111\132\105", ["\x46\111\x4c\105\137\x49\104" => $htkae8809wqexvbmi, "\x46\x49\x4c\x45\x5f\123\122\x43" => $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\103"], "\123\x49\x5a\105" => $fn20wxj1c1nsya4tqjqv7mf7["\x57\x49\104\124\x48"] + $fn20wxj1c1nsya4tqjqv7mf7["\110\x45\x49\107\x48\124"]]);
                    break;
                }
                
                $this->convertFromWebp($fn20wxj1c1nsya4tqjqv7mf7);
                
                if ($this->exportItem()->isEnabledImageToSquare()) {
                    $this->prepareToSquare($fn20wxj1c1nsya4tqjqv7mf7);
                }
                
                $this->prepareCanvas($fn20wxj1c1nsya4tqjqv7mf7, 400, 400);
                
                $this->prepareWatermark($fn20wxj1c1nsya4tqjqv7mf7);
                
                if (filesize(\Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\x53\x52\103"]) > 50 * 1024 * 1024 * 8) {
                    $snk0q1sgqh6xtuc->addError($this->getMessage("\x50\122\105\x50\111\122\x45\x5f\120\x52\x4f\x44\x55\103\x54\137\x46\x49\114\105\x53\x2e\105\122\x52\x4f\122\137\106\111\x4c\x45\x53\x49\x5a\105", ["\43\106\x49\x4c\x45\x5f\x49\x44\43" => $htkae8809wqexvbmi, "\43\x46\x49\114\105\x5f\x53\x52\103\43" => $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\103"]]), "\x46\x49\x4c\105\123\111\132\105", ["\106\111\114\x45\137\111\104" => $htkae8809wqexvbmi, "\x46\111\x4c\105\137\123\122\x43" => $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"]]);
                    break;
                }
                $snk0q1sgqh6xtuc->setData("\120\x41\x54\110", \Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\103"]);
                $snk0q1sgqh6xtuc->setData("\123\122\103", $fn20wxj1c1nsya4tqjqv7mf7["\x53\122\103"]);
            } while (false);
            $hyho1v7omsx805b3kyovmsw99[$htkae8809wqexvbmi] = $snk0q1sgqh6xtuc;
        }
        $jc7ai89g->setData("\151\x74\145\155\163", $hyho1v7omsx805b3kyovmsw99);
        return $jc7ai89g;
    }
    
    public function getWatermarkDir($rjam2av68owfhppsxai6oorsnkbq521 = false)
    {
        if ($this->isModePreview()) {
            return "\x2f\165\x70\x6c\157\141\x64\x2f\166\153\141\160\151\x2e\155\141\162\x6b\x65\x74\57\160\x72\x65\x76\x69\145\167\57\x77\x61\164\145\x72\155\141\x72\x6b" . ($rjam2av68owfhppsxai6oorsnkbq521 ? "\57" : "");
        }
        return "\57\x75\160\154\157\141\144\x2f\166\153\141\x70\151\x2e\155\141\162\153\x65\x74\57\167\141\x74\145\x72\x6d\141\x72\153" . ($rjam2av68owfhppsxai6oorsnkbq521 ? "\x2f" : "");
    }
    
    public function getCanvasDir($rjam2av68owfhppsxai6oorsnkbq521 = false)
    {
        if ($this->isModePreview()) {
            return "\57\165\160\154\157\x61\144\x2f\x76\153\x61\x70\151\x2e\x6d\x61\162\x6b\145\164\57\160\x72\145\x76\x69\145\x77\57\x63\x61\156\x76\141\163" . ($rjam2av68owfhppsxai6oorsnkbq521 ? "\x2f" : "");
        }
        return "\x2f\165\x70\x6c\157\141\x64\x2f\166\x6b\x61\160\151\56\155\141\x72\x6b\x65\164\57\x63\x61\x6e\x76\141\163" . ($rjam2av68owfhppsxai6oorsnkbq521 ? "\57" : "");
    }
    
    public function getCloudDir($rjam2av68owfhppsxai6oorsnkbq521 = false)
    {
        if ($this->isModePreview()) {
            return "\x2f\x75\x70\x6c\157\x61\144\57\x76\x6b\141\160\151\56\x6d\141\x72\x6b\x65\164\57\x70\x72\x65\x76\151\145\x77\57\x63\154\157\165\144" . ($rjam2av68owfhppsxai6oorsnkbq521 ? "\x2f" : "");
        }
        return "\x2f\165\x70\x6c\157\141\144\57\166\153\x61\160\x69\56\x6d\x61\162\153\145\x74\57\x63\154\157\165\144" . ($rjam2av68owfhppsxai6oorsnkbq521 ? "\57" : "");
    }
    
    public function getWatermarkPositionList()
    {
        return ["\106\x49\x4c\x4c" => $this->getMessage("\127\101\x54\105\x52\x4d\101\122\x4b\137\120\117\123\x49\124\111\117\x4e\137\x46\111\x4c\114"), "\124\114" => $this->getMessage("\127\x41\124\105\122\115\101\122\x4b\x5f\120\x4f\x53\111\124\111\x4f\116\x5f\x54\x4c"), "\124\103" => $this->getMessage("\127\101\124\x45\122\x4d\101\x52\x4b\x5f\120\x4f\123\x49\124\111\x4f\116\137\x54\x43"), "\x54\122" => $this->getMessage("\127\x41\x54\105\122\115\x41\x52\x4b\137\120\x4f\x53\111\124\111\x4f\116\137\x54\x52"), "\115\114" => $this->getMessage("\127\101\124\x45\x52\x4d\101\122\113\137\x50\x4f\x53\111\x54\x49\117\116\137\115\x4c"), "\x4d\103" => $this->getMessage("\x57\x41\x54\105\x52\x4d\101\x52\x4b\x5f\120\x4f\123\111\124\111\117\x4e\x5f\115\103"), "\x4d\122" => $this->getMessage("\x57\x41\124\105\122\115\x41\x52\113\137\120\x4f\x53\111\x54\111\x4f\116\x5f\x4d\x52"), "\102\x4c" => $this->getMessage("\127\101\x54\105\x52\115\101\x52\113\137\120\x4f\123\x49\124\111\117\116\x5f\x42\x4c"), "\102\x43" => $this->getMessage("\x57\101\124\x45\122\x4d\101\122\113\x5f\x50\117\x53\x49\x54\111\x4f\x4e\137\x42\103"), "\102\x52" => $this->getMessage("\127\101\124\105\122\115\101\122\x4b\137\x50\x4f\x53\111\124\x49\x4f\x4e\137\102\122")];
    }
    
    public function getWatermarkPositionSelectList()
    {
        $rdxnm = $this->getWatermarkPositionList();
        return ["\x52\x45\x46\x45\x52\105\116\103\x45\x5f\111\x44" => array_keys($rdxnm), "\x52\x45\x46\x45\122\x45\116\103\x45" => array_values($rdxnm)];
    }
    
    public function getWatermarkOpacityList()
    {
        static $w06qefa881q4fa;
        if (!isset($w06qefa881q4fa)) {
            $w06qefa881q4fa = [];
            for ($b2r7h2b2 = 0; $b2r7h2b2 <= 100; $b2r7h2b2 += 2) {
                $w06qefa881q4fa[$b2r7h2b2] = $b2r7h2b2 . "\x25";
            }
        }
        return $w06qefa881q4fa;
    }
    
    public function getWatermarkOpacitySelectList()
    {
        $rdxnm = $this->getWatermarkOpacityList();
        return ["\122\105\106\x45\x52\x45\x4e\103\x45\x5f\x49\x44" => array_keys($rdxnm), "\122\105\106\105\122\x45\x4e\x43\105" => array_values($rdxnm)];
    }
    
    public function getWatermarkKoefficientList()
    {
        static $w06qefa881q4fa;
        if (!isset($w06qefa881q4fa)) {
            $t4aq5ffryuubewaxd = ["\x31", "\60\x2e\x39", "\60\56\70", "\x30\56\67", "\60\x2e\x36", "\x30\56\x35", "\60\56\x34", "\x30\x2e\63", "\x30\x2e\62", "\x30\56\x31"];
            $w06qefa881q4fa = array_combine($t4aq5ffryuubewaxd, $t4aq5ffryuubewaxd);
        }
        return $w06qefa881q4fa;
    }
    
    public function getWatermarkKoefficientSelectList()
    {
        $rdxnm = $this->getWatermarkKoefficientList();
        return ["\x52\x45\106\x45\x52\105\x4e\103\x45\137\x49\x44" => array_keys($rdxnm), "\x52\105\x46\105\122\x45\116\x43\105" => array_values($rdxnm)];
    }
    
    public function restoreRealFileSizes(&$fn20wxj1c1nsya4tqjqv7mf7)
    {
        if (isset($fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"])) {
            
            $cy2wwfv6m0 = (new \Bitrix\Main\File\Image(\Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"]))->getInfo();
            if ($cy2wwfv6m0) {
                $fn20wxj1c1nsya4tqjqv7mf7["\x57\111\x44\x54\x48"] = $cy2wwfv6m0->getWidth();
                $fn20wxj1c1nsya4tqjqv7mf7["\110\x45\x49\107\110\124"] = $cy2wwfv6m0->getHeight();
            }
        }
    }
    
    public function convertFromWebp(&$fn20wxj1c1nsya4tqjqv7mf7)
    {
        if (preg_match("\57\134\56\x77\145\142\x70\44\x2f\x69", $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"])) {
            $cgypq6cf0cez6uwgj2e8lu7 = new \Bitrix\Main\File\Image(\Bitrix\Main\Application::getDocumentRoot() . $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"]);
            $cgypq6cf0cez6uwgj2e8lu7->load();
            $b8zhlbdaxjrq628iixcvk6f17ojol6 = $this->getCanvasDir() . "\x2f\x66\162\157\155\137\167\x65\x62\160\57";
            $q6o17hd2 = \Bitrix\Main\Application::getDocumentRoot();
            \Bitrix\Main\IO\Directory::createDirectory($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6);
            $vp98k5w72np9w0lwbc = "\x66\162\x6f\155\x5f\167\145\x62\x70\x5f" . $fn20wxj1c1nsya4tqjqv7mf7["\111\x44"] . "\x2e\152\x70\x67";
            if ($bovegg4be1ubhd = $cgypq6cf0cez6uwgj2e8lu7->saveAs($q6o17hd2 . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc, 100, \Bitrix\Main\File\Image::FORMAT_JPEG)) {
                $fn20wxj1c1nsya4tqjqv7mf7["\123\122\103"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
            }
        }
    }
    
    public function prepareMaxSize(&$fn20wxj1c1nsya4tqjqv7mf7, $hs7um3gwjfl9m3kqiu9ere8mik1ff0i, $avzo9q5xun7ciq87jovxe9kyuakqe)
    {
        $mnmzflqgyflcb01bgx71d747quvvbhog = new \Bitrix\Main\File\Image($this->root() . $fn20wxj1c1nsya4tqjqv7mf7["\123\x52\x43"]);
        $pjauu7arxa9h03xm9hzsuuwuh8li = $mnmzflqgyflcb01bgx71d747quvvbhog->getInfo();
        if ($pjauu7arxa9h03xm9hzsuuwuh8li === null || !$pjauu7arxa9h03xm9hzsuuwuh8li->isSupported()) {
            return false;
        }
        $bmnnxn4grk9cckesz6bh4lx58vscs2s3 = $pjauu7arxa9h03xm9hzsuuwuh8li->toRectangle();
        $a0rzb9jjchhyx7qvr99b6t = new \Bitrix\Main\File\Image\Rectangle($hs7um3gwjfl9m3kqiu9ere8mik1ff0i, $avzo9q5xun7ciq87jovxe9kyuakqe);
        if ($bmnnxn4grk9cckesz6bh4lx58vscs2s3->resize($a0rzb9jjchhyx7qvr99b6t, \Bitrix\Main\File\Image::RESIZE_PROPORTIONAL)) {
            $mnmzflqgyflcb01bgx71d747quvvbhog->load();
            if ($mnmzflqgyflcb01bgx71d747quvvbhog->resize($bmnnxn4grk9cckesz6bh4lx58vscs2s3, $a0rzb9jjchhyx7qvr99b6t)) {
                $b8zhlbdaxjrq628iixcvk6f17ojol6 = $this->getCanvasDir() . "\x2f\155\141\x78\57";
                $vp98k5w72np9w0lwbc = $fn20wxj1c1nsya4tqjqv7mf7["\x49\104"] . "\56\x6a\160\147";
                \Bitrix\Main\IO\Directory::createDirectory($this->root() . $b8zhlbdaxjrq628iixcvk6f17ojol6);
                $mnmzflqgyflcb01bgx71d747quvvbhog->saveAs($this->root() . $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc, 100, \Bitrix\Main\File\Image::FORMAT_JPEG);
                $fn20wxj1c1nsya4tqjqv7mf7["\123\122\x43"] = $b8zhlbdaxjrq628iixcvk6f17ojol6 . $vp98k5w72np9w0lwbc;
                $fn20wxj1c1nsya4tqjqv7mf7["\x48\105\111\x47\110\124"] = $a0rzb9jjchhyx7qvr99b6t->getHeight();
                $fn20wxj1c1nsya4tqjqv7mf7["\x57\x49\104\124\110"] = $a0rzb9jjchhyx7qvr99b6t->getWidth();
            }
        }
    }
    
    public function root()
    {
        return \Bitrix\Main\Application::getDocumentRoot();
    }
}
?>