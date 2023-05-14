<?php

namespace VKapi\Market;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
final class Param
{
    private static $instance = null;
    private static $params = array();
    private function __construct()
    {
    }
    private function __clone()
    {
    }
    
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $g53jireiv5do7ghndk2ayws0mr = __CLASS__;
            self::$instance = new $g53jireiv5do7ghndk2ayws0mr();
        }
        return self::$instance;
    }
    public function getTable()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\ParamTable();
        }
        return $this->oTable;
    }
    public function get($emkee4qd22txk, $wlji1x7bae79xpaz36x0xbo22z3kdak8 = "")
    {
        $emkee4qd22txk = trim($emkee4qd22txk);
        if (!isset(self::$params[$emkee4qd22txk])) {
            $ahva4gtr = $this->getTable()->getList(["\x66\x69\x6c\x74\x65\x72" => ["\103\117\x44\x45" => $emkee4qd22txk]]);
            if ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
                self::$params[$emkee4qd22txk] = $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\126\101\x4c\x55\x45"];
            } else {
                self::$params[$emkee4qd22txk] = $wlji1x7bae79xpaz36x0xbo22z3kdak8;
            }
        }
        return self::$params[$emkee4qd22txk];
    }
    public function set($emkee4qd22txk, $neueels6)
    {
        $emkee4qd22txk = trim($emkee4qd22txk);
        $neueels6 = trim($neueels6);
        $ahva4gtr = $this->getTable()->getList(["\146\151\154\x74\x65\162" => ["\103\x4f\104\105" => $emkee4qd22txk]]);
        if ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
            $this->getTable()->update($emkee4qd22txk, ["\126\101\114\125\x45" => $neueels6, "\x45\x44\x49\x54\x5f\x54\111\115\x45" => new \Bitrix\Main\Type\DateTime()]);
        } else {
            $this->getTable()->add(["\103\117\x44\x45" => $emkee4qd22txk, "\126\101\114\x55\x45" => trim($neueels6), "\105\x44\x49\124\137\x54\111\x4d\105" => new \Bitrix\Main\Type\DateTime()]);
        }
        self::$params[$emkee4qd22txk] = $neueels6;
    }
    
    public function canExecFastAgent()
    {
        $ahva4gtr = $this->getTable()->getList(["\146\151\154\164\x65\162" => ["\103\117\x44\105" => "\x46\x41\123\x54\x5f\101\107\x45\116\124\137\105\130\105\x43"]]);
        if ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
            if ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\126\101\x4c\x55\105"] == "\x59") {
                
                $of8q3bujxlon = $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\105\x44\111\124\x5f\x54\111\x4d\x45"];
                if ($of8q3bujxlon->format("\125") <= time() - 3600) {
                    return true;
                }
                return false;
            }
        }
        return true;
    }
}
?>