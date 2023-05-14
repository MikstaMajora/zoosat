<?php

namespace VKapi\Market\Good\Reference;

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Entity;
use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Result;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ExportTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\153\x61\160\x69\x5f\155\141\162\153\x65\164\x5f\147\157\x6f\x64\137\x72\145\x66\x65\162\145\x6e\x63\145\137\x65\170\x70\x6f\162\x74";
    }
    
    public static function getMap()
    {
        return array(new \Bitrix\Main\Entity\IntegerField("\x49\x44", array("\160\x72\151\155\x61\162\171" => true, "\x61\x75\164\x6f\143\157\155\160\154\145\164\x65" => true)), new \Bitrix\Main\Entity\IntegerField("\x45\x58\x50\117\122\x54\x5f\x49\104", array("\162\x65\161\165\151\x72\x65\144" => true)), new \Bitrix\Main\Entity\IntegerField("\x50\122\117\x44\x55\103\x54\x5f\111\104", array("\162\x65\161\165\151\x72\145\144" => true)), new \Bitrix\Main\Entity\IntegerField("\117\x46\106\x45\x52\x5f\111\104", array(
            // будет 0  у простого товара,
            "\162\x65\161\x75\151\162\x65\x64" => true,
            "\x64\x65\x66\141\165\x6c\x74\137\x76\x61\x6c\165\x65" => 0,
        )), new \Bitrix\Main\Entity\IntegerField("\x46\114\x41\107", array("\x64\145\146\141\x75\x6c\164\x5f\166\x61\x6c\x75\x65" => \VKapi\Market\Good\Reference\Export::FLAG_NEED_UPDATE)), new \Bitrix\Main\Entity\ExpressionField("\x43\116\124", "\103\x4f\x55\x4e\x54\50\x2a\51"), new \Bitrix\Main\Entity\ExpressionField("\x43\116\124\x5f\104\111\123\124\111\116\x43\124\x5f\x50\x52\117\x44\125\103\124\x5f\x49\x44", "\103\x4f\125\116\124\50\x44\x49\x53\x54\x49\116\103\124\x20\45\163\x29", "\120\122\x4f\x44\125\x43\x54\x5f\x49\104"));
    }
    
    public static function setNeedUpdateByExportId($r93xzxht1s8iubytion1)
    {
        $r93xzxht1s8iubytion1 = intval($r93xzxht1s8iubytion1);
        $mgcajgsk02b = \Bitrix\Main\Application::getConnection();
        return $mgcajgsk02b->query("\x55\120\x44\x41\x54\105\40\x60" . self::getTableName() . "\x60\x20\123\x45\124\x20\106\x4c\101\x47\75" . intval(\VKapi\Market\Good\Reference\Export::FLAG_NEED_UPDATE) . "\x20\127\x48\x45\122\105\x20\x45\130\x50\x4f\122\124\137\x49\104\75" . intval($r93xzxht1s8iubytion1));
    }
    
    public static function setUpdateFlagByElementId($hlslm7grkat1k)
    {
        $hlslm7grkat1k = intval($hlslm7grkat1k);
        $mgcajgsk02b = \Bitrix\Main\Application::getConnection();
        return $mgcajgsk02b->query("\125\120\x44\x41\x54\105\40\x60" . self::getTableName() . "\140\x20\123\x45\x54\40\106\x4c\x41\107\x3d" . intval(\VKapi\Market\Good\Reference\Export::FLAG_NEED_UPDATE) . "\x20\127\x48\x45\x52\x45\x20\x50\122\x4f\x44\125\x43\124\137\111\104\x3d" . intval($hlslm7grkat1k) . "\40\x4f\x52\x20\117\x46\106\x45\x52\x5f\111\x44\x3d" . intval($hlslm7grkat1k));
    }
    
    public static function deleteNotExistsYet($r93xzxht1s8iubytion1, $ehh4v2t8bj8181xlu, $mm678ibdr3cqakb4km2c)
    {
        $ehh4v2t8bj8181xlu = intval($ehh4v2t8bj8181xlu);
        $mm678ibdr3cqakb4km2c = intval($mm678ibdr3cqakb4km2c);
        $r93xzxht1s8iubytion1 = intval($r93xzxht1s8iubytion1);
        $oahrajmsjszpnm48u = static::getEntity();
        $mgcajgsk02b = $oahrajmsjszpnm48u->getConnection();
        
        $ass9fux1glwxh1g9opm3jgmv9h3y = static::query()->addSelect("\111\x44")->registerRuntimeField(new \Bitrix\Main\ORM\Fields\Relations\Reference("\105\114\x45\115\105\x4e\x54", "\x5c\102\x69\164\x72\151\170\x5c\111\x62\154\157\x63\x6b\x5c\x45\154\145\155\x65\156\164\x54\x61\x62\x6c\145", \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\x74\x68\151\163\56\x50\x52\x4f\104\x55\103\124\x5f\111\x44", "\162\x65\x66\56\x49\104")->where("\x72\145\146\x2e\111\x42\114\117\103\113\137\x49\104", $ehh4v2t8bj8181xlu)))->where("\x45\130\x50\x4f\122\124\137\111\104", $r93xzxht1s8iubytion1)->whereNull("\x45\x4c\105\x4d\105\116\124\56\x49\x44");
        $gqw5i6ld50s7emivysqg9obow120sn7tb42 = sprintf("\x44\105\x4c\105\x54\x45\x20\106\x52\117\115\x20\x25\x73\40\40\127\110\105\122\x45\x20\x25\x73", $mgcajgsk02b->getSqlHelper()->quote($oahrajmsjszpnm48u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($oahrajmsjszpnm48u, \Bitrix\Main\ORM\Query\Query::filter()->whereExpr("\x25\x73\40\x49\116\40\50\x53\105\114\x45\x43\x54\x20\x60\x49\104\140\x20\106\x52\117\x4d\40\50" . $ass9fux1glwxh1g9opm3jgmv9h3y->getQuery() . "\x29\40\x61\163\40\x54\x49\x44\40\51", ["\x49\104"])));
        $mgcajgsk02b->query($gqw5i6ld50s7emivysqg9obow120sn7tb42);
        
        if ($mm678ibdr3cqakb4km2c) {
            $ass9fux1glwxh1g9opm3jgmv9h3y = static::query()->addSelect("\x49\104")->registerRuntimeField(new \Bitrix\Main\ORM\Fields\Relations\Reference("\105\114\x45\115\105\116\x54", "\x5c\x42\151\164\x72\151\170\x5c\x49\x62\154\157\143\x6b\x5c\105\x6c\x65\x6d\145\x6e\x74\124\x61\142\154\x65", \Bitrix\Main\ORM\Query\Query::filter()->whereColumn("\x74\x68\151\x73\x2e\117\106\x46\105\122\x5f\111\104", "\x72\x65\x66\x2e\x49\104")->where("\162\145\x66\x2e\x49\x42\114\x4f\x43\113\x5f\111\x44", $mm678ibdr3cqakb4km2c)))->where("\x45\130\x50\x4f\x52\124\x5f\111\x44", $r93xzxht1s8iubytion1)->whereNot("\x4f\106\106\105\122\137\x49\104", "\x30")->whereNull("\105\114\105\x4d\105\116\x54\x2e\111\x44");
            $gqw5i6ld50s7emivysqg9obow120sn7tb42 = sprintf("\x44\105\x4c\x45\124\x45\x20\106\x52\117\115\x20\x25\x73\x20\40\127\x48\x45\x52\x45\x20\45\x73", $mgcajgsk02b->getSqlHelper()->quote($oahrajmsjszpnm48u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($oahrajmsjszpnm48u, \Bitrix\Main\ORM\Query\Query::filter()->whereExpr("\45\163\x20\111\x4e\x20\x28\x53\105\x4c\x45\103\124\40\140\x49\104\140\x20\x46\x52\x4f\x4d\40\x28" . $ass9fux1glwxh1g9opm3jgmv9h3y->getQuery() . "\51\40\141\163\x20\x54\x49\104\40\x29", ["\x49\104"])));
            $mgcajgsk02b->query($gqw5i6ld50s7emivysqg9obow120sn7tb42);
        }
        return true;
    }
    
    public function setMarkForAllByExportId($r93xzxht1s8iubytion1)
    {
        $oahrajmsjszpnm48u = static::getEntity();
        $mgcajgsk02b = $oahrajmsjszpnm48u->getConnection();
        $gqw5i6ld50s7emivysqg9obow120sn7tb42 = sprintf("\125\120\x44\101\124\105\x20\x25\x73\40\x53\105\x54\x20\x46\114\101\x47\75\x25\x73\40\x57\x48\x45\x52\x45\40\x25\x73", $mgcajgsk02b->getSqlHelper()->quote($oahrajmsjszpnm48u->getDbTableName()), (int) \VKapi\Market\Good\Reference\Export::FLAG_MARKED, \Bitrix\Main\ORM\Query\Query::buildFilterSql($oahrajmsjszpnm48u, \Bitrix\Main\ORM\Query\Query::filter()->where("\105\130\x50\x4f\122\x54\137\x49\x44", (int) $r93xzxht1s8iubytion1)));
        return $mgcajgsk02b->query($gqw5i6ld50s7emivysqg9obow120sn7tb42);
    }
    
    public function deleteAllMarkedByExportId($r93xzxht1s8iubytion1)
    {
        $oahrajmsjszpnm48u = static::getEntity();
        $mgcajgsk02b = $oahrajmsjszpnm48u->getConnection();
        
        $gqw5i6ld50s7emivysqg9obow120sn7tb42 = sprintf("\104\105\x4c\105\124\105\x20\106\x52\x4f\x4d\x20\x25\x73\40\40\x57\110\x45\x52\x45\x20\x25\x73", $mgcajgsk02b->getSqlHelper()->quote($oahrajmsjszpnm48u->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($oahrajmsjszpnm48u, \Bitrix\Main\ORM\Query\Query::filter()->where("\x46\x4c\101\107", \VKapi\Market\Good\Reference\Export::FLAG_MARKED)->where("\105\x58\120\117\x52\124\x5f\111\x44", (int) $r93xzxht1s8iubytion1)));
        return $mgcajgsk02b->query($gqw5i6ld50s7emivysqg9obow120sn7tb42);
    }
    public function setFlagSkip($tr079vyurzpw264epi4re3)
    {
        $oahrajmsjszpnm48u = static::getEntity();
        $mgcajgsk02b = $oahrajmsjszpnm48u->getConnection();
        $gqw5i6ld50s7emivysqg9obow120sn7tb42 = sprintf("\125\120\104\x41\x54\x45\x20\40\45\x73\40\123\105\x54\40\106\x4c\x41\107\x3d\x25\163\40\40\127\x48\105\x52\x45\x20\111\104\x3d\x25\163", $mgcajgsk02b->getSqlHelper()->quote($oahrajmsjszpnm48u->getDbTableName()), (int) \VKapi\Market\Good\Reference\Export::FLAG_NEED_SKIP, (int) $tr079vyurzpw264epi4re3);
        return $mgcajgsk02b->query($gqw5i6ld50s7emivysqg9obow120sn7tb42);
    }
}

class Export
{
    const FLAG_NEED_SKIP = 0;
    
    const FLAG_NEED_UPDATE = 1;
    
    const FLAG_NEED_DELETE = 2;
    
    const FLAG_MARKED = 3;
    
    private static $instance = null;
    
    private $oTable = null;
    public function __construct()
    {
    }
    
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $kl8m5x5hisahopyvqi0n = __CLASS__;
            self::$instance = new $kl8m5x5hisahopyvqi0n();
        }
        return self::$instance;
    }
    
    public function getTable()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Good\Reference\ExportTable();
        }
        return $this->oTable;
    }
    
    public function updateElementReferenceList(array $o2gu5vso7fg4, array $psiwnj3w00fav89bgqq6aq7dqr6rj2)
    {
        
        if (empty($psiwnj3w00fav89bgqq6aq7dqr6rj2) || empty($o2gu5vso7fg4)) {
            return false;
        }
        
        $i3jdo5ebyo1 = $this->getTable()->getList(array("\146\x69\154\164\145\162" => array("\x50\x52\117\x44\x55\103\x54\137\x49\x44" => array_keys($o2gu5vso7fg4), "\x45\130\x50\117\122\124\137\x49\x44" => $psiwnj3w00fav89bgqq6aq7dqr6rj2)));
        while ($m5fuff1swjsnadwe0c6vnotetlwfapxrr = $i3jdo5ebyo1->fetch()) {
            
            if (!isset($o2gu5vso7fg4[$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\120\122\117\x44\x55\x43\124\137\111\x44"]])) {
                $this->getTable()->delete($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\111\x44"]);
            } elseif (!isset($o2gu5vso7fg4[$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x50\x52\x4f\x44\125\x43\124\137\x49\104"]][$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x4f\106\x46\x45\x52\137\111\x44"]])) {
                $this->getTable()->delete($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\111\104"]);
            } elseif (!isset($o2gu5vso7fg4[$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x50\122\x4f\x44\125\103\x54\137\x49\104"]][$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x4f\106\x46\x45\122\x5f\111\104"]][$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\105\130\x50\117\122\x54\137\x49\x44"]])) {
                $this->getTable()->delete($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x49\x44"]);
            } else {
                $this->getTable()->setFlagSkip($m5fuff1swjsnadwe0c6vnotetlwfapxrr["\111\x44"]);
                
                unset($o2gu5vso7fg4[$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x50\122\117\104\125\x43\x54\x5f\111\x44"]][$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x4f\106\106\105\122\x5f\111\104"]][$m5fuff1swjsnadwe0c6vnotetlwfapxrr["\x45\130\120\117\122\124\137\x49\104"]]);
            }
        }
        
        if (is_array($o2gu5vso7fg4) && count($o2gu5vso7fg4)) {
            foreach ($o2gu5vso7fg4 as $hlslm7grkat1k => $ro3ad8im0ymnybzb0nw5xhas5nxdzcptw2) {
                foreach ($ro3ad8im0ymnybzb0nw5xhas5nxdzcptw2 as $xip4druw2fxklyfu7h02opev => $ji32ja06rm0nk22k1jwl3k6lc7) {
                    
                    if (is_array($ji32ja06rm0nk22k1jwl3k6lc7) && count($ji32ja06rm0nk22k1jwl3k6lc7)) {
                        foreach ($ji32ja06rm0nk22k1jwl3k6lc7 as $r93xzxht1s8iubytion1) {
                            $this->getTable()->add(array("\x45\130\x50\x4f\x52\x54\137\x49\x44" => $r93xzxht1s8iubytion1, "\120\122\x4f\x44\125\x43\124\137\111\x44" => $hlslm7grkat1k, "\x4f\x46\106\x45\122\x5f\111\104" => $xip4druw2fxklyfu7h02opev, "\106\114\x41\107" => self::FLAG_NEED_UPDATE));
                        }
                    }
                }
            }
        }
        return true;
    }
}
?>