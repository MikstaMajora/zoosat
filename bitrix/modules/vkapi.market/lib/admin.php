<?php

namespace VKapi\Market;

use Bitrix\Main\Localization\Loc;

class Admin
{
    protected $moduleId = "";
    protected $tableId = "";
    protected $arSortFields = array();
    
    protected $defaultSortField = "";
    
    protected $arFilterFields = array();
    
    private $oMessage = null;
    
    private $oAdminList = null;
    
    private $arFilter = array();
    
    public function __construct($bppdkwgordiiyhxpsgxun89dy)
    {
        $this->moduleId = $bppdkwgordiiyhxpsgxun89dy;
    }
    
    public function setAdminList($x7qo5qh3bv22jq228j7ng3skt1z3)
    {
        $this->oAdminList = $x7qo5qh3bv22jq228j7ng3skt1z3;
    }
    
    public function setMessage(\VKapi\Market\Message $fd20yzv7cx3f9nvuk33dyjprtx62sf74c23)
    {
        $this->oMessage = $fd20yzv7cx3f9nvuk33dyjprtx62sf74c23;
    }
    public function getModuleId()
    {
        return $this->moduleId;
    }
    
    public function message()
    {
        return $this->oMessage;
    }
    
    public function setTableId($a0lz4f60w6kdn92pm)
    {
        $this->tableId = $a0lz4f60w6kdn92pm;
    }
    
    public function getTableId()
    {
        return $this->tableId;
    }
    
    public function setSortFields($wfodel046wvo0, $ze5itwy9d = null)
    {
        $this->arSortFields = $wfodel046wvo0;
        $this->defaultSortField = !is_null($ze5itwy9d) ? $ze5itwy9d : reset($wfodel046wvo0);
    }
    
    public function getSiteList()
    {
        static $owvsk1b84um1360iu;
        if (!isset($owvsk1b84um1360iu)) {
            $ahva4gtr = \CSite::GetList($kgn3dg6uubwr = "\x73\157\x72\x74", $atjt130t7su7ctzjgp8hxm = "\x61\x73\143");
            while ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->Fetch()) {
                $owvsk1b84um1360iu[$k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\111\x44"]] = "\133" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\111\x44"] . "\x5d\40" . $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x4e\101\115\105"];
            }
        }
        return $owvsk1b84um1360iu;
    }
    
    public function getListQuery()
    {
        global $APPLICATION;
        $x80lmjozh39qleye6hrzfc = array("\163\x65\x6c\x65\x63\164" => array("\x2a"), "\146\151\x6c\x74\x65\x72" => $this->getFilter());
        $kgn3dg6uubwr = $this->defaultSortField;
        if (isset($_GET["\x62\x79"]) && in_array($_GET["\142\x79"], $this->arSortFields)) {
            $kgn3dg6uubwr = $_GET["\142\171"];
        }
        $jokzqez = array($kgn3dg6uubwr => strtoupper($_GET["\157\x72\x64\x65\162"]) == "\x41\123\x43" ? "\x41\x53\x43" : "\x44\105\123\103");
        $x80lmjozh39qleye6hrzfc["\157\x72\x64\145\162"] = $jokzqez;
        $bvbn4d8yvcd8vnxxzqi3vv7y7oko = \CDBResult::GetNavParams(\CAdminResult::GetNavSize($this->getTableId(), array("\156\x50\x61\x67\x65\x53\x69\172\x65" => 20, "\x73\116\x61\166\x49\104" => $APPLICATION->GetCurPage())));
        $b0qsmosrptw6r7j3ti1f3 = true;
        if ($bvbn4d8yvcd8vnxxzqi3vv7y7oko["\x53\110\117\127\x5f\x41\114\x4c"]) {
            $b0qsmosrptw6r7j3ti1f3 = false;
        } else {
            $bvbn4d8yvcd8vnxxzqi3vv7y7oko["\120\x41\107\x45\116"] = (int) $bvbn4d8yvcd8vnxxzqi3vv7y7oko["\x50\101\107\105\116"];
            $bvbn4d8yvcd8vnxxzqi3vv7y7oko["\x53\111\x5a\x45\116"] = (int) $bvbn4d8yvcd8vnxxzqi3vv7y7oko["\123\x49\x5a\105\116"];
        }
        if ($b0qsmosrptw6r7j3ti1f3) {
            $x80lmjozh39qleye6hrzfc["\x6c\x69\x6d\151\x74"] = $bvbn4d8yvcd8vnxxzqi3vv7y7oko["\123\111\x5a\105\x4e"];
            $x80lmjozh39qleye6hrzfc["\x6f\146\146\163\x65\x74"] = $bvbn4d8yvcd8vnxxzqi3vv7y7oko["\x53\x49\x5a\105\116"] * ($bvbn4d8yvcd8vnxxzqi3vv7y7oko["\x50\x41\x47\x45\x4e"] - 1);
        }
        return $x80lmjozh39qleye6hrzfc;
    }
    
    public function getPageUrl($l8jbw1evz3k41iwd38avy398rr2x11l, $ie867f10dshfcr1babs = array(), $rrjdehcpz7ph1rt4xzxt0eghitw8l8 = array())
    {
        $ie867f10dshfcr1babs["\154\x61\x6e\x67"] = LANG;
        $ie867f10dshfcr1babs = array_diff_key($ie867f10dshfcr1babs, array_flip($rrjdehcpz7ph1rt4xzxt0eghitw8l8));
        return $this->getModuleId() . "\137" . $l8jbw1evz3k41iwd38avy398rr2x11l . "\56\160\x68\160\77" . http_build_query($ie867f10dshfcr1babs);
    }
    
    public function getFullPageUrl($l8jbw1evz3k41iwd38avy398rr2x11l, $ie867f10dshfcr1babs = array(), $rrjdehcpz7ph1rt4xzxt0eghitw8l8 = array())
    {
        return "\57\142\151\164\162\151\x78\x2f\x61\x64\x6d\151\156\57" . $this->getPageUrl($l8jbw1evz3k41iwd38avy398rr2x11l, $ie867f10dshfcr1babs, $rrjdehcpz7ph1rt4xzxt0eghitw8l8);
    }
    
    public function addFilterField($emkee4qd22txk, $ie867f10dshfcr1babs = array())
    {
        $this->arFilterFields[$emkee4qd22txk] = $ie867f10dshfcr1babs;
    }
    
    public function showFilter()
    {
        global $APPLICATION;
        $qyhn6g6yu5mr0yx7cnqen7wa1wb6a4qdvc = array();
        foreach ($this->arFilterFields as $u5526mf8pwl3bod => $u4001ec) {
            $qyhn6g6yu5mr0yx7cnqen7wa1wb6a4qdvc[] = $this->message()->get("\x46\x49\114\x54\105\122\x2e" . $u5526mf8pwl3bod);
        }
        
        $lfeky = new \CAdminFilter($this->getTableId() . "\137\x66\151\154\x74\145\x72", $qyhn6g6yu5mr0yx7cnqen7wa1wb6a4qdvc);
        ?>
            <form name="filter_form" method="get" action="<?php 
        echo $APPLICATION->GetCurPage();
        ?>">
                <?php 
        $lfeky->Begin();
        foreach ($this->arFilterFields as $u5526mf8pwl3bod => $u4001ec) {
            $qyhn6g6yu5mr0yx7cnqen7wa1wb6a4qdvc[] = $this->message()->get("\106\111\114\x54\x45\122\56" . $u5526mf8pwl3bod);
            $ldas3vk6vxwwsiq57xm3b347v8oyw659r = "\146\151\154\x74\x65\162\x5f\x66\151\x65\x6c\x64\x5f" . $u5526mf8pwl3bod;
            $qj13awow = $GLOBALS["\x66\x69\x6c\164\x65\162\137\146\151\145\154\x64\x5f" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r];
            $qwl43e44z = $GLOBALS["\146\x69\154\164\x65\162\137\x66\151\x65\x6c\144\x5f" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r . "\x5f\x66\162\157\x6d"];
            $fcmuz9 = $GLOBALS["\x66\151\x6c\x74\145\x72\137\x66\151\x65\x6c\x64\x5f" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r . "\x5f\164\x6f"];
            ?>
                        <tr>
                            <td><?php 
            echo $this->message()->get("\x46\x49\114\124\105\x52\56" . $u5526mf8pwl3bod);
            ?>:</td>
                            <td>
                                <?php 
            switch ($u4001ec["\124\x59\x50\x45"]) {
                case "\114\x49\x53\124":
                    echo SelectBoxFromArray($ldas3vk6vxwwsiq57xm3b347v8oyw659r, $u4001ec["\126\101\x4c\x55\x45\123"], $qj13awow);
                    break;
                case "\x50\x45\122\111\x4f\x44":
                    echo CalendarPeriod($ldas3vk6vxwwsiq57xm3b347v8oyw659r . "\x5f\146\x72\x6f\155", $qwl43e44z, $ldas3vk6vxwwsiq57xm3b347v8oyw659r . "\137\x74\x6f", $fcmuz9, "\x66\x69\x6c\164\145\162\137\146\157\x72\x6d", "\131");
                    break;
                default:
                    echo InputType("\164\x65\170\164", $ldas3vk6vxwwsiq57xm3b347v8oyw659r, $qj13awow, "");
                    break;
            }
            ?>
                            </td>
                        </tr>
                        <?php 
        }
        $lfeky->Buttons(array("\x74\x61\x62\154\145\137\x69\144" => $this->getTableId(), "\165\162\154" => $APPLICATION->GetCurPage(), "\x66\157\162\155" => "\146\x69\x6c\x74\145\x72\137\146\157\x72\155"));
        $lfeky->End();
        ?>
            </form>

            <?php 
    }
    public function checkFilter()
    {
        $this->arFilter = array();
        if (empty($this->oAdminList)) {
            return false;
        }
        $l8yto0mma7ioadqynh35qyburz6is = array();
        foreach (array_keys($this->arFilterFields) as $ldas3vk6vxwwsiq57xm3b347v8oyw659r) {
            $l8yto0mma7ioadqynh35qyburz6is[] = "\146\x69\x6c\x74\x65\162\137\146\151\x65\154\144\137" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r;
        }
        
        $this->oAdminList->InitFilter($l8yto0mma7ioadqynh35qyburz6is);
        
        if (count($this->oAdminList->arFilterErrors) == 0) {
            
            foreach ($this->arFilterFields as $ldas3vk6vxwwsiq57xm3b347v8oyw659r => $u4001ec) {
                $qj13awow = $GLOBALS["\146\151\154\164\x65\162\x5f\146\x69\x65\154\x64\137" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r];
                $qwl43e44z = $GLOBALS["\x66\151\154\164\x65\162\137\x66\x69\x65\x6c\144\137" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r . "\x5f\146\x72\157\155"];
                $fcmuz9 = $GLOBALS["\x66\151\x6c\164\x65\x72\137\146\151\145\154\x64\137" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r . "\137\164\x6f"];
                switch ($u4001ec["\x54\x59\x50\x45"]) {
                    case "\x4c\x49\x53\x54":
                        if (strlen(trim($qj13awow)) > 0 && in_array(trim($qj13awow), $u4001ec["\126\x41\114\x55\105\123"]["\122\x45\106\x45\122\105\x4e\x43\105\x5f\111\x44"])) {
                            $this->arFilter[$ldas3vk6vxwwsiq57xm3b347v8oyw659r] = trim($qj13awow);
                        }
                        break;
                    case "\x50\105\x52\111\117\x44":
                        if (strlen(trim($qwl43e44z)) > 0 || strlen(trim($fcmuz9)) > 0) {
                            if (strlen(trim($qwl43e44z)) > 0 && strlen(trim($fcmuz9)) > 0) {
                                $fxquqi604k0waexiu0c2l1amywr = new \Bitrix\Main\Type\DateTime($qwl43e44z);
                                $fxquqi604k0waexiu0c2l1amywr->setTime(0, 0, 0);
                                $t7tze = new \Bitrix\Main\Type\DateTime($fcmuz9);
                                $t7tze->setTime(23, 23, 59);
                                $this->arFilter["\76\74" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r] = array($fxquqi604k0waexiu0c2l1amywr, $t7tze);
                            } elseif (strlen(trim($qwl43e44z)) > 0) {
                                $fxquqi604k0waexiu0c2l1amywr = new \Bitrix\Main\Type\DateTime($qwl43e44z);
                                $fxquqi604k0waexiu0c2l1amywr->setTime(0, 0, 0);
                                $this->arFilter["\76" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r] = $fxquqi604k0waexiu0c2l1amywr;
                            } elseif (strlen(trim($fcmuz9)) > 0) {
                                $t7tze = new \Bitrix\Main\Type\DateTime($fcmuz9);
                                $t7tze->setTime(23, 23, 59);
                                $this->arFilter["\74" . $ldas3vk6vxwwsiq57xm3b347v8oyw659r] = $t7tze;
                            }
                        }
                        break;
                    default:
                        if (strlen(trim($qj13awow)) > 0) {
                            $this->arFilter[$ldas3vk6vxwwsiq57xm3b347v8oyw659r] = $qj13awow;
                        }
                        break;
                }
            }
        }
    }
    
    public function getFilter()
    {
        return $this->arFilter;
    }
}
?>