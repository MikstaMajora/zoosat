<?php

namespace VKapi\Market\Good\Reference;

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Entity;
use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Result;
use VKapi\Market\Exception\BaseException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class AlbumTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\x6b\141\160\x69\x5f\155\141\x72\x6b\145\164\x5f\147\157\x6f\x64\137\x72\145\x66\x65\162\145\156\143\145\137\141\x6c\142\x75\x6d";
    }
    
    public static function getMap()
    {
        return [new \Bitrix\Main\Entity\IntegerField("\x49\x44", ["\x70\162\x69\155\141\162\x79" => true, "\141\x75\x74\x6f\143\x6f\x6d\x70\x6c\145\x74\145" => true]), new \Bitrix\Main\Entity\IntegerField("\x41\114\x42\x55\115\x5f\x49\x44", [
            //идентификатор подборки
            "\162\x65\x71\165\151\162\145\144" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\120\x52\x4f\x44\125\x43\124\x5f\x49\104", [
            //идентификатор товара
            "\162\x65\161\165\x69\x72\x65\x64" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\x4f\x46\x46\105\122\x5f\111\104", [
            //идентификтаор торгового предложения
            "\162\145\161\165\151\x72\x65\x64" => true,
            "\x64\145\146\141\x75\x6c\164\x5f\166\x61\x6c\165\x65" => 0,
        ]), new \Bitrix\Main\Entity\ExpressionField("\103\116\x54", "\x43\117\x55\116\124\x28\x2a\x29"), new \Bitrix\Main\Entity\ReferenceField("\x41\114\x42\125\x4d", "\134\126\113\141\160\x69\x5c\x4d\141\162\x6b\145\164\134\x41\154\142\x75\x6d\x5c\111\164\x65\x6d\x54\x61\142\x6c\145", ["\x3d\x74\x68\x69\x73\56\x41\114\x42\x55\x4d\137\111\104" => "\x72\145\146\x2e\x49\x44"], ["\x6a\157\151\156\137\x74\171\160\145" => "\x4c\105\106\x54"])];
    }
    
    public function deleteByIdList(array $gdrvk03c23s9mbujwbn7d6nuy)
    {
        $gdrvk03c23s9mbujwbn7d6nuy = array_map("\151\x6e\x74\166\141\154", $gdrvk03c23s9mbujwbn7d6nuy);
        $gdrvk03c23s9mbujwbn7d6nuy = array_diff($gdrvk03c23s9mbujwbn7d6nuy, [0]);
        $gdrvk03c23s9mbujwbn7d6nuy = array_values(array_unique($gdrvk03c23s9mbujwbn7d6nuy));
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        if (count($gdrvk03c23s9mbujwbn7d6nuy)) {
            $ue11mo1uabp1y3vqxtqveqal = array_chunk($gdrvk03c23s9mbujwbn7d6nuy, 100);
            foreach ($ue11mo1uabp1y3vqxtqveqal as $r27h4a3nt2dgh6pvf9784qt81a) {
                if (empty($r27h4a3nt2dgh6pvf9784qt81a)) {
                    continue;
                }
                $qtwqi60t3dvkr->query(sprintf("\x44\x45\x4c\x45\x54\105\x20\106\122\x4f\115\40\45\163\40\127\110\105\122\x45\x20\x25\x73", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, ["\x49\104" => $r27h4a3nt2dgh6pvf9784qt81a])));
            }
        }
        return true;
    }
    
    public static function deleteAllByAlbumId($e0acxob619le3xiaxsptmd2w)
    {
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        $qtwqi60t3dvkr->query(sprintf("\104\x45\x4c\x45\x54\105\40\106\122\x4f\115\40\x25\x73\x20\127\x48\105\122\x45\x20\x25\x73", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, ["\101\114\102\x55\115\x5f\x49\104" => intval($e0acxob619le3xiaxsptmd2w)])));
    }
    
    public static function deleteNotExistsYet($k7gerym8v, $pfe7rop439sjaf43jlw6kwr, $choyrb6zberlqqjtty7qew4iox09z)
    {
        $k7gerym8v = array_map("\x69\156\x74\x76\x61\x6c", $k7gerym8v);
        $k7gerym8v = array_diff($k7gerym8v, [0]);
        $k7gerym8v = array_values(array_unique($k7gerym8v));
        
        $k7gerym8v[] = 0;
        $pfe7rop439sjaf43jlw6kwr = intval($pfe7rop439sjaf43jlw6kwr);
        $choyrb6zberlqqjtty7qew4iox09z = intval($choyrb6zberlqqjtty7qew4iox09z);
        $f8s0106dfb262 = static::getEntity();
        $qtwqi60t3dvkr = $f8s0106dfb262->getConnection();
        
        $wqccqp0ldhy5ghmpekjin6j5q = static::query()->addSelect("\111\104")->registerRuntimeField(new \Bitrix\Main\ORM\Fields\Relations\Reference("\x45\x4c\105\115\105\116\x54", "\x5c\x42\x69\164\162\x69\x78\134\111\x62\154\x6f\143\153\134\x45\x6c\x65\155\145\156\x74\x54\141\x62\154\x65", \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\x74\150\151\x73\x2e\120\122\117\104\125\x43\x54\x5f\111\104", "\162\145\x66\56\x49\104")->where("\x72\x65\x66\56\111\102\x4c\x4f\103\113\137\111\104", $pfe7rop439sjaf43jlw6kwr)))->whereIn("\x41\x4c\x42\125\115\137\x49\104", $k7gerym8v)->whereNull("\105\x4c\x45\115\105\116\x54\56\111\104");
        $gx82ng2wvzkfepbz75561ozk2as43uwi = sprintf("\x44\x45\114\x45\x54\x45\40\x46\x52\117\x4d\40\45\x73\x20\x20\127\x48\x45\x52\x45\x20\x25\x73", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, \Bitrix\Main\ORM\Query\Query::filter()->whereExpr("\x25\x73\x20\111\116\40\x28\123\105\x4c\x45\x43\124\40\x60\111\x44\x60\40\106\x52\117\115\40\x28" . $wqccqp0ldhy5ghmpekjin6j5q->getQuery() . "\51\x20\141\x73\40\x54\111\x44\40\51", ["\x49\104"])));
        $qtwqi60t3dvkr->query($gx82ng2wvzkfepbz75561ozk2as43uwi);
        
        if ($choyrb6zberlqqjtty7qew4iox09z) {
            $wqccqp0ldhy5ghmpekjin6j5q = static::query()->addSelect("\x49\x44")->registerRuntimeField(new \Bitrix\Main\ORM\Fields\Relations\Reference("\x45\x4c\105\x4d\x45\116\x54", "\x5c\102\151\164\x72\151\x78\134\111\142\154\x6f\x63\153\x5c\105\154\x65\x6d\x65\x6e\164\x54\141\142\x6c\145", \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\164\x68\x69\163\56\x4f\x46\x46\105\122\137\x49\x44", "\x72\x65\146\56\111\x44")->where("\162\145\146\x2e\111\102\x4c\117\x43\113\137\111\104", $choyrb6zberlqqjtty7qew4iox09z)))->whereIn("\101\x4c\102\125\115\x5f\111\104", $k7gerym8v)->whereNot("\x4f\x46\106\105\122\x5f\x49\104", "\60")->whereNull("\105\114\105\x4d\x45\x4e\124\56\111\104");
            $gx82ng2wvzkfepbz75561ozk2as43uwi = sprintf("\x44\105\114\105\124\105\40\x46\122\x4f\115\40\45\x73\40\x20\x57\x48\105\122\x45\40\45\x73", $qtwqi60t3dvkr->getSqlHelper()->quote($f8s0106dfb262->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($f8s0106dfb262, \Bitrix\Main\ORM\Query\Query::filter()->whereExpr("\x25\x73\40\111\116\40\50\x53\x45\114\105\103\x54\40\140\111\104\x60\x20\106\122\117\115\x20\50" . $wqccqp0ldhy5ghmpekjin6j5q->getQuery() . "\x29\40\x61\x73\40\124\111\x44\x20\51", ["\111\x44"])));
            $qtwqi60t3dvkr->query($gx82ng2wvzkfepbz75561ozk2as43uwi);
        }
        return true;
    }
}

class Album
{
    
    private static $instance = null;
    
    private $oTable = null;
    public function __construct()
    {
        if (!\VKapi\Market\Manager::getInstance()->isInstalledIblockModule()) {
            throw new \VKapi\Market\Exception\BaseException("\115\117\x44\125\x4c\x45\x5f\111\x42\114\x4f\x43\x4b\x5f\111\x53\137\116\117\124\137\x49\116\x53\124\101\114\114\x45\x44", "\115\117\104\x55\x4c\x45\137\116\x4f\124\137\x49\116\x53\124\x41\114\x4c\x45\104");
        }
    }
    private function __clone()
    {
    }
    
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $v335mwa4t9nhbw = __CLASS__;
            self::$instance = new $v335mwa4t9nhbw();
        }
        return self::$instance;
    }
    
    public function getTable()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Good\Reference\AlbumTable();
        }
        return $this->oTable;
    }
    
    public function updateElementReferenceList(array $jf5qet8wwo, array $k7gerym8v)
    {
        
        if (empty($k7gerym8v) || empty($jf5qet8wwo)) {
            return false;
        }
        
        $qm3650jyecji81izpqcxqt3q4l9ehhf4h = $this->getTable()->getList(["\146\151\154\x74\145\x72" => ["\x50\122\117\104\x55\103\x54\137\x49\104" => array_keys($jf5qet8wwo), "\x41\114\102\125\x4d\137\111\104" => $k7gerym8v]]);
        while ($p6b8qkj818r5kg5 = $qm3650jyecji81izpqcxqt3q4l9ehhf4h->fetch()) {
            
            if (!isset($jf5qet8wwo[$p6b8qkj818r5kg5["\x50\x52\117\104\125\103\x54\x5f\x49\104"]])) {
                $this->getTable()->delete($p6b8qkj818r5kg5["\x49\x44"]);
            } elseif (!isset($jf5qet8wwo[$p6b8qkj818r5kg5["\120\122\117\104\x55\x43\124\x5f\x49\104"]][$p6b8qkj818r5kg5["\117\x46\x46\105\122\137\x49\104"]])) {
                $this->getTable()->delete($p6b8qkj818r5kg5["\x49\104"]);
            } elseif (!isset($jf5qet8wwo[$p6b8qkj818r5kg5["\120\122\x4f\x44\x55\103\124\137\111\x44"]][$p6b8qkj818r5kg5["\117\x46\x46\105\x52\137\111\104"]][$p6b8qkj818r5kg5["\101\114\102\x55\115\137\x49\x44"]])) {
                $this->getTable()->delete($p6b8qkj818r5kg5["\111\x44"]);
            } else {
                
                unset($jf5qet8wwo[$p6b8qkj818r5kg5["\x50\122\117\x44\x55\x43\124\x5f\x49\104"]][$p6b8qkj818r5kg5["\x4f\x46\x46\105\x52\137\111\104"]][$p6b8qkj818r5kg5["\101\x4c\102\x55\115\137\111\x44"]]);
            }
        }
        
        if (count($jf5qet8wwo)) {
            foreach ($jf5qet8wwo as $ac7ibi5i7jdp2xf6k4dajqcg74rkri5zb3n => $r2yarfgnvx0msn2diuxhbaa) {
                foreach ($r2yarfgnvx0msn2diuxhbaa as $e03kvd => $a026jogh2k5zz8y6tg82z3p4bfzs800) {
                    
                    if (count((array) $a026jogh2k5zz8y6tg82z3p4bfzs800)) {
                        foreach ((array) $a026jogh2k5zz8y6tg82z3p4bfzs800 as $e0acxob619le3xiaxsptmd2w) {
                            $this->getTable()->add(["\101\114\102\125\x4d\x5f\x49\104" => $e0acxob619le3xiaxsptmd2w, "\120\x52\x4f\104\125\x43\x54\137\x49\104" => $ac7ibi5i7jdp2xf6k4dajqcg74rkri5zb3n, "\117\106\106\x45\x52\137\x49\x44" => $e03kvd]);
                        }
                    }
                }
            }
        }
        return true;
    }
}
?>