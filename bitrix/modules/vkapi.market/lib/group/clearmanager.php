<?php

namespace VKapi\Market\Group;

use VKapi\Market\Connect;
use VKapi\Market\Exception\ApiResponseException;
use VKapi\Market\Result;
use VKapi\Market\Exception\BaseException;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ClearManager
{
    
    protected $oConnection = null;
    protected $groupId = 0;
    public function __construct()
    {
        $this->oConnection = new \VKapi\Market\Connect();
    }
    
    public function setAccountId($ienk3321u19e4o6)
    {
        $this->oConnection->initAccountId($ienk3321u19e4o6);
    }
    
    public function setGroupId($h9mx9xx6xzezul71a873ujm83fjx8)
    {
        $this->groupId = abs((int) $h9mx9xx6xzezul71a873ujm83fjx8);
    }
    
    public function getGroupId()
    {
        return $this->groupId;
    }
    
    public function connection()
    {
        return $this->oConnection;
    }
    
    public function state()
    {
        if (is_null($this->oState)) {
            $this->oState = new \VKapi\Market\State("\147\x72\x6f\165\x70\x5f" . $this->getGroupId(), "\57\143\154\145\141\x72");
        }
        return $this->oState;
    }
    
    public function getMessage($aqjtsa9n, $w2y12u0sl4xtikt7q4w3ydyqgpt8kq = [])
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\126\x4b\101\120\x49\x2e\x4d\x41\122\113\x45\124\x2e\103\x4c\105\x41\x52\115\101\116\101\107\x45\122\x2e" . $aqjtsa9n, $w2y12u0sl4xtikt7q4w3ydyqgpt8kq);
    }
    
    public function getGroups()
    {
        $u6qncmw5573cnhhcpk1ques1z = $this->connection()->method("\x67\x72\x6f\165\160\163\x2e\x67\145\x74", array("\x66\151\154\164\x65\x72" => "\x65\144\x69\164\157\162", "\145\x78\x74\x65\156\x64\x65\144" => 1));
        if ($u6qncmw5573cnhhcpk1ques1z->isSuccess()) {
            $r6rpo215zv9nukk08n54jq9wsh1a = $u6qncmw5573cnhhcpk1ques1z->getData("\x72\145\x73\x70\x6f\x6e\x73\x65");
            return $r6rpo215zv9nukk08n54jq9wsh1a["\x69\x74\145\155\163"];
        }
        return [];
    }
    
    public function clearGroup()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (empty($u4voliardef7gcuv1yw9cl9jr4uf273kfdm) || !isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\145\160"]) || $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x63\157\155\x70\154\145\164\145"]) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = array("\x63\x6f\155\160\154\x65\x74\145" => false, "\160\145\x72\x63\145\x6e\x74" => 0, "\163\x74\x65\160" => 1, "\x6e\x61\155\x65" => "", "\x73\x74\145\160\x73" => array(1 => array("\x6e\141\155\x65" => $this->getMessage("\x43\114\105\x41\122\137\x47\122\x4f\125\x50\56\123\124\x45\x50\x31"), "\x70\x65\162\143\x65\x6e\x74" => 0, "\x65\x72\162\x6f\x72" => false), 2 => array("\x6e\x61\155\145" => $this->getMessage("\103\114\105\x41\122\x5f\x47\x52\117\x55\x50\x2e\x53\x54\x45\x50\x32"), "\160\x65\162\x63\x65\156\x74" => 0, "\145\162\x72\x6f\x72" => false), 3 => array("\x6e\x61\155\x65" => $this->getMessage("\103\x4c\105\x41\122\137\107\122\117\125\120\56\x53\124\105\x50\x33"), "\x70\x65\162\x63\x65\x6e\164" => 0, "\x65\162\x72\x6f\162" => false)));
            $this->state()->set($u4voliardef7gcuv1yw9cl9jr4uf273kfdm)->save();
        }
        if (\CModule::IncludeModuleEx("\x76" . "\153\x61\160\x69" . "" . "\56\x6d\141\x72\153" . "\145" . "" . "" . "\x74") == constant("\x4d\x4f\104\125\114\x45\x5f\x44\x45\x4d\117\137\105" . "\130\120\x49\122\x45\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\x41\x50\x49\x2e\115\101\x52" . "\113\105\124\56" . "\x44\x45\x4d\x4f\x5f\105" . "\x58\x50\x49\x52\105" . "\x44"), "\102\130\115\x41\113\x45\122" . "\137\x44\105\x4d\x4f\137\x45\130\x50\x49\x52\x45\104");
        }
        switch ($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\x65\x70"]) {
            case 1:
                $rhq19scjfw3gobfo6e32cp5n6pbaua2lq = $this->clearGroupAlbums();
                $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x6e\141\155\145"] = $rhq19scjfw3gobfo6e32cp5n6pbaua2lq->getData("\156\141\x6d\145");
                $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\x65\160\163"][1]["\160\145\x72\x63\x65\x6e\164"] = $rhq19scjfw3gobfo6e32cp5n6pbaua2lq->getData("\160\x65\x72\x63\145\x6e\164");
                if ($rhq19scjfw3gobfo6e32cp5n6pbaua2lq->getData("\x63\x6f\155\x70\x6c\x65\x74\145")) {
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\145\160"]++;
                }
                break;
            case 2:
                $rzcxqy3oi723uh458w5hd57t266f = $this->clearGroupProperties();
                $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\156\x61\x6d\x65"] = $rzcxqy3oi723uh458w5hd57t266f->getData("\x6e\141\x6d\145");
                $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\145\x70\x73"][2]["\x70\145\162\143\145\x6e\164"] = $rzcxqy3oi723uh458w5hd57t266f->getData("\160\x65\162\143\145\156\x74");
                if ($rzcxqy3oi723uh458w5hd57t266f->getData("\143\x6f\x6d\x70\x6c\x65\164\x65")) {
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\145\x70"]++;
                }
                break;
            case 3:
                $rzcxqy3oi723uh458w5hd57t266f = $this->clearGroupGoods();
                $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x6e\141\155\145"] = $rzcxqy3oi723uh458w5hd57t266f->getData("\156\x61\155\x65");
                $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\x65\160\163"][3]["\160\145\x72\143\145\156\x74"] = $rzcxqy3oi723uh458w5hd57t266f->getData("\160\x65\x72\x63\145\x6e\164");
                if ($rzcxqy3oi723uh458w5hd57t266f->getData("\x63\157\155\160\x6c\145\164\x65")) {
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\x65\160"]++;
                }
                break;
            default:
                $this->state()->clean();
                break;
        }
        
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\160\145\162\143\x65\156\x74"] = $this->state()->calcPercentByData($u4voliardef7gcuv1yw9cl9jr4uf273kfdm);
        if ($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x70\x65\x72\x63\x65\156\164"] >= 100) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\143\x6f\155\x70\x6c\145\164\x65"] = true;
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\156\141\155\145"] = $this->getMessage("\103\114\x45\101\122\137\x47\122\117\x55\120\56\x4f\113");
        }
        if (\CModule::IncludeModuleEx("\x76\x6b\x61" . "\x70\x69\x2e\x6d" . "\141\162\153\145\164") == constant("\x4d\x4f\x44\125\x4c\105\137\104\x45\x4d\x4f\x5f\x45\x58\120\111" . "\122\105" . "\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\120\x49\56\115\101\122\113\105" . "\124\x2e\x44\x45\x4d\117\137\105\130\x50\x49\122\x45\x44"), "\x42" . "\x58\115\x41\113\105\122" . "\137\x44\x45\x4d\x4f\x5f\105\x58\x50\x49\x52\x45" . "" . "" . "" . "\104");
        }
        
        $this->state()->set($u4voliardef7gcuv1yw9cl9jr4uf273kfdm)->save();
        return $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\156\x61\155\145" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x6e\141\155\x65"], "\160\x65\x72\x63\145\x6e\x74" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\160\x65\x72\x63\x65\156\164"], "\143\x6f\x6d\160\x6c\x65\164\x65" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\143\x6f\155\160\154\x65\164\x65"], "\x72\145\x70\145\141\164" => !$u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\143\x6f\x6d\x70\x6c\145\x74\145"]]);
    }
    
    public function clearGroupAlbums()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\143\x6c\145\141\162\107\x72\157\165\x70\101\154\x62\x75\x6d\163";
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = array("\156\141\155\x65" => "", "\143\x6f\x6d\160\154\145\x74\145" => false, "\160\x65\x72\143\x65\x6e\164" => 0, "\x63\x6f\x75\156\x74" => null, "\157\x66\146\x73\145\x74" => 0);
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
            
            \VKapi\Market\Album\ExportTable::deleteAllByGroupId($this->getGroupId());
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        $jds83zryqpja6n9f7m = \VKapi\Market\Manager::getInstance();
        $z5o5n370y7nrn69h7d1xz93 = 1;
        try {
            while (!$jds83zryqpja6n9f7m->isTimeout() && $z5o5n370y7nrn69h7d1xz93) {
                $jk8y2msr0ei3z0mm45oo1lro73gg2x74 = $this->connection()->method("\x6d\x61\x72\153\x65\164\x2e\x67\x65\164\101\154\142\165\155\x73", array("\x6f\x77\x6e\x65\162\137\x69\144" => "\55" . $this->getGroupId(), "\x63\157\165\156\x74" => 25));
                $r6rpo215zv9nukk08n54jq9wsh1a = $jk8y2msr0ei3z0mm45oo1lro73gg2x74->getData("\x72\145\163\160\x6f\x6e\163\145");
                $z5o5n370y7nrn69h7d1xz93 = (int) $r6rpo215zv9nukk08n54jq9wsh1a["\143\157\x75\x6e\x74"];
                
                if (is_null($qhlmd95l2je9bcrimqphd0x["\x63\x6f\165\156\164"])) {
                    $qhlmd95l2je9bcrimqphd0x["\143\157\165\156\164"] = $z5o5n370y7nrn69h7d1xz93;
                    $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
                }
                if ($z5o5n370y7nrn69h7d1xz93) {
                    $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 = "\40\x76\141\162\40\162\145\x73\165\x6c\x74\x73\40\75\x20\133\x5d\x3b\x20" . "\xa";
                    foreach ($r6rpo215zv9nukk08n54jq9wsh1a["\151\164\145\155\x73"] as $k7eqxvix60) {
                        if ((int) $k7eqxvix60["\151\144"] <= 0) {
                            continue;
                        }
                        $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 .= "\x20\162\145\x73\165\154\164\163\56\x70\165\163\x68\50\133" . $k7eqxvix60["\151\144"] . "\x2c\40\x41\120\x49\x2e\x6d\141\162\x6b\145\164\56\x64\x65\154\x65\x74\145\101\154\142\165\155\x28\x7b\x22\x6f\167\x6e\145\162\137\151\x64\42\40\72\x20\x22\55" . $this->getGroupId() . "\42\x2c\42\x61\x6c\142\x75\155\137\151\x64\x22\x20\72" . $k7eqxvix60["\151\x64"] . "\x7d\x29\x20\135\51\73" . "\xa";
                    }
                    $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 .= "\x20\162\x65\164\165\162\156\40\x72\145\163\x75\154\x74\163\73";
                    $pxq0eglu9i = $this->connection()->method("\x65\x78\x65\143\165\164\x65", array("\x63\157\x64\x65" => $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7));
                    $r6rpo215zv9nukk08n54jq9wsh1a = $pxq0eglu9i->getData("\x72\x65\x73\160\x6f\x6e\x73\x65");
                    if (is_array($r6rpo215zv9nukk08n54jq9wsh1a)) {
                        foreach ($r6rpo215zv9nukk08n54jq9wsh1a as $hacdsstvxzfccwgx1gz8kcl) {
                            
                            if ($hacdsstvxzfccwgx1gz8kcl[1]) {
                                $qhlmd95l2je9bcrimqphd0x["\x6f\x66\x66\x73\x65\164"]++;
                            }
                        }
                    }
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\157\x66\x66\163\145\x74"] = $qhlmd95l2je9bcrimqphd0x["\x63\157\165\x6e\164"];
                }
            }
        } catch (\VKapi\Market\Exception\BaseException $ouxam818oykc60ox4qap) {
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\145\x72\143\x65\156\x74"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\143\157\x75\156\x74"], $qhlmd95l2je9bcrimqphd0x["\157\146\x66\x73\x65\x74"]);
        $qhlmd95l2je9bcrimqphd0x["\x6e\x61\x6d\x65"] = $this->getMessage("\103\x4c\x45\x41\122\x5f\107\122\x4f\125\120\137\101\114\102\125\115\x53\56\120\x52\x4f\x43\105\123\x53", ["\x23\x4f\x46\x46\x53\x45\x54\x23" => $qhlmd95l2je9bcrimqphd0x["\157\x66\x66\x73\145\x74"], "\x23\103\117\125\116\124\x23" => $qhlmd95l2je9bcrimqphd0x["\143\x6f\165\x6e\164"]]);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\145\x72\x63\145\156\164"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\x63\157\x6d\160\x6c\145\164\145"] = true;
        }
        if ($ouxam818oykc60ox4qap) {
            $qhlmd95l2je9bcrimqphd0x["\156\x61\x6d\145"] = $ouxam818oykc60ox4qap->getMessage();
            
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
            throw $ouxam818oykc60ox4qap;
        }
        if (\CModule::IncludeModuleEx("\166" . "\x6b" . "\141\x70\151\x2e\155\141\162\153\x65\164") === constant("\x4d\117\104\125\x4c\x45\137\104\105" . "\115\x4f\x5f\x45" . "\x58\x50" . "\111\122\105\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\101\x50\111\x2e\115\101\x52\x4b\x45\124\x2e\x44\x45\115\x4f\137\x45\x58\120\x49\x52\105\x44"), "\102\130\x4d\101\113\105\x52\137\x44\105\115\117\x5f\x45\130\x50\111\x52" . "\x45" . "" . "\104");
        }
        
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        return $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\156\141\x6d\x65" => $qhlmd95l2je9bcrimqphd0x["\x6e\x61\155\x65"], "\x70\x65\162\143\x65\x6e\164" => $qhlmd95l2je9bcrimqphd0x["\x70\145\x72\x63\x65\x6e\x74"], "\143\157\155\160\154\x65\x74\x65" => $qhlmd95l2je9bcrimqphd0x["\143\x6f\155\x70\154\x65\x74\145"]]);
    }
    
    public function clearGroupProperties()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\143\154\145\x61\x72\107\162\157\165\160\x50\x72\157\x70\x65\162\x74\151\145\163";
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = array("\x6e\x61\x6d\x65" => "", "\x63\157\155\160\x6c\145\x74\x65" => false, "\x70\145\x72\143\145\156\x74" => 0, "\143\157\x75\x6e\x74" => null, "\157\146\x66\163\145\x74" => 0);
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
            
            \VKapi\Market\Property\PropertyTable::deleteAllByGroupId($this->getGroupId());
            
            \VKapi\Market\Property\VariantTable::deleteAllByGroupId($this->getGroupId());
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        $jds83zryqpja6n9f7m = \VKapi\Market\Manager::getInstance();
        $z5o5n370y7nrn69h7d1xz93 = 1;
        try {
            while (!$jds83zryqpja6n9f7m->isTimeout() && $z5o5n370y7nrn69h7d1xz93) {
                $jk8y2msr0ei3z0mm45oo1lro73gg2x74 = $this->connection()->method("\x6d\x61\x72\x6b\x65\x74\56\147\x65\x74\120\x72\x6f\x70\145\162\x74\x69\x65\x73", array("\x67\x72\x6f\165\160\x5f\x69\x64" => $this->getGroupId()));
                $r6rpo215zv9nukk08n54jq9wsh1a = $jk8y2msr0ei3z0mm45oo1lro73gg2x74->getData("\x72\145\x73\x70\x6f\x6e\163\x65");
                $z5o5n370y7nrn69h7d1xz93 = (int) $r6rpo215zv9nukk08n54jq9wsh1a["\143\157\165\x6e\164"];
                if (\Bitrix\Main\Loader::includeSharewareModule("\166\153" . "\x61\x70\151" . "\x2e\x6d" . "\141\x72\153" . "\x65" . "" . "" . "\x74") === constant("\115" . "\117\x44\125\114\105\137\104" . "\105\115\117\x5f\x45\130\x50\x49\122" . "" . "\105\x44")) {
                    throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\101\x50\x49\56\115\101\122\x4b\105\124\x2e\104\105" . "\x4d" . "\117\x5f\x45" . "\x58\x50\111\122\x45" . "\104"), "\x42\x58\115\101\x4b\105\122\137\104\x45" . "\x4d\117\137\105\130\120\111" . "\x52\x45" . "\x44");
                }
                
                if (is_null($qhlmd95l2je9bcrimqphd0x["\x63\x6f\165\x6e\164"])) {
                    $qhlmd95l2je9bcrimqphd0x["\143\x6f\x75\x6e\164"] = $z5o5n370y7nrn69h7d1xz93;
                    $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
                }
                if ($z5o5n370y7nrn69h7d1xz93) {
                    $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 = "\40\x76\141\x72\40\x72\x65\x73\165\154\164\x73\x20\x3d\x20\133\135\x3b\40" . "\xa";
                    $r6rpo215zv9nukk08n54jq9wsh1a["\151\x74\x65\x6d\163"] = array_slice($r6rpo215zv9nukk08n54jq9wsh1a["\x69\x74\145\155\163"], 0, 25);
                    foreach ($r6rpo215zv9nukk08n54jq9wsh1a["\151\164\x65\x6d\163"] as $k7eqxvix60) {
                        if ((int) $k7eqxvix60["\x69\x64"] <= 0) {
                            continue;
                        }
                        $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 .= "\40\x72\145\163\165\x6c\164\163\x2e\160\165\x73\x68\x28\x5b" . $k7eqxvix60["\151\x64"] . "\54\x20\101\x50\111\x2e\x6d\x61\x72\153\x65\x74\x2e\144\145\x6c\x65\x74\x65\120\162\157\x70\x65\x72\x74\x79\x28\x7b\x22\x67\x72\157\x75\x70\137\x69\144\x22\x20\x3a\40\42" . $this->getGroupId() . "\42\54\42\160\162\x6f\160\x65\162\164\171\137\x69\144\42\x20\72" . $k7eqxvix60["\x69\x64"] . "\x7d\51\40\135\51\73" . "\12";
                    }
                    $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 .= "\40\x72\x65\x74\x75\162\x6e\x20\x72\145\163\x75\x6c\164\163\73";
                    $pxq0eglu9i = $this->connection()->method("\x65\170\x65\143\165\x74\x65", array("\x63\x6f\144\145" => $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7));
                    $r6rpo215zv9nukk08n54jq9wsh1a = $pxq0eglu9i->getData("\x72\145\163\160\x6f\156\x73\145");
                    $wffewr0xfejid5hx84vdup6fm1vtonwu3h = $pxq0eglu9i->getData("\145\170\145\x63\x75\164\145\137\x65\162\x72\157\162\163") ?? [];
                    if (is_array($r6rpo215zv9nukk08n54jq9wsh1a)) {
                        foreach ($r6rpo215zv9nukk08n54jq9wsh1a as $hacdsstvxzfccwgx1gz8kcl) {
                            
                            if ($hacdsstvxzfccwgx1gz8kcl[1]) {
                                $qhlmd95l2je9bcrimqphd0x["\157\x66\146\x73\x65\164"]++;
                            } else {
                                throw new \VKapi\Market\Exception\ApiResponseException($wffewr0xfejid5hx84vdup6fm1vtonwu3h[0]);
                            }
                        }
                    }
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\157\x66\146\x73\x65\x74"] = $qhlmd95l2je9bcrimqphd0x["\x63\x6f\165\x6e\164"];
                }
            }
        } catch (\VKapi\Market\Exception\BaseException $ouxam818oykc60ox4qap) {
            if ($ouxam818oykc60ox4qap instanceof \VKapi\Market\Exception\ApiResponseException && $ouxam818oykc60ox4qap->is(\VKapi\Market\Api::ERROR_1409)) {
                $qhlmd95l2je9bcrimqphd0x["\157\146\x66\x73\x65\x74"] = 0;
                $qhlmd95l2je9bcrimqphd0x["\143\157\x75\156\x74"] = 0;
            }
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\x65\x72\x63\x65\156\x74"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\143\157\x75\156\x74"], $qhlmd95l2je9bcrimqphd0x["\157\146\x66\163\145\x74"]);
        $qhlmd95l2je9bcrimqphd0x["\156\141\x6d\x65"] = $this->getMessage("\103\114\105\101\122\x5f\107\122\117\x55\x50\x5f\120\122\117\120\x45\x52\x54\x49\105\x53\x2e\120\122\117\103\x45\x53\x53", ["\43\x4f\106\106\123\105\124\x23" => $qhlmd95l2je9bcrimqphd0x["\x6f\x66\x66\163\x65\164"], "\43\103\x4f\x55\x4e\x54\43" => $qhlmd95l2je9bcrimqphd0x["\143\157\165\x6e\x74"]]);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\x65\x72\143\145\156\164"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\143\157\x6d\160\154\x65\164\x65"] = true;
        }
        if ($ouxam818oykc60ox4qap) {
            if ($ouxam818oykc60ox4qap instanceof \VKapi\Market\Exception\ApiResponseException && $ouxam818oykc60ox4qap->is(\VKapi\Market\Api::ERROR_1409)) {
                
            } else {
                $qhlmd95l2je9bcrimqphd0x["\156\x61\x6d\145"] = $ouxam818oykc60ox4qap->getMessage();
                
                $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
                throw $ouxam818oykc60ox4qap;
            }
        }
        
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        return $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\x6e\141\155\145" => $qhlmd95l2je9bcrimqphd0x["\x6e\141\x6d\145"], "\x70\x65\162\143\x65\156\x74" => $qhlmd95l2je9bcrimqphd0x["\x70\145\162\143\145\156\x74"], "\143\157\x6d\x70\154\145\164\145" => $qhlmd95l2je9bcrimqphd0x["\x63\x6f\x6d\x70\x6c\x65\x74\x65"]]);
    }
    
    public function clearGroupGoods()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\143\154\145\x61\x72\x47\x72\x6f\x75\x70\x47\x6f\157\x64\x73";
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = array("\x6e\141\x6d\x65" => "", "\143\x6f\x6d\x70\154\x65\x74\x65" => false, "\160\x65\162\143\145\x6e\x74" => 0, "\143\x6f\x75\156\x74" => null, "\x6f\x66\146\163\x65\x74" => 0);
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
            
            \VKapi\Market\Good\ExportTable::deleteAllByGroupId($this->getGroupId());
            
            \VKapi\Market\Export\PhotoTable::deleteAllByGroupId($this->getGroupId());
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        $jds83zryqpja6n9f7m = \VKapi\Market\Manager::getInstance();
        $z5o5n370y7nrn69h7d1xz93 = 1;
        try {
            while (!$jds83zryqpja6n9f7m->isTimeout() && $z5o5n370y7nrn69h7d1xz93) {
                $jk8y2msr0ei3z0mm45oo1lro73gg2x74 = $this->connection()->method("\155\x61\x72\x6b\145\x74\x2e\x67\145\x74", array("\x6f\x77\156\x65\x72\x5f\151\x64" => "\55" . $this->getGroupId(), "\167\x69\x74\x68\x5f\144\x69\x73\141\x62\x6c\145\x64" => 1, "\x6e\x65\145\144\x5f\166\141\162\151\141\156\x74\163" => 1, "\143\157\165\x6e\x74" => 25));
                $r6rpo215zv9nukk08n54jq9wsh1a = $jk8y2msr0ei3z0mm45oo1lro73gg2x74->getData("\162\x65\163\160\157\156\x73\145");
                $z5o5n370y7nrn69h7d1xz93 = (int) $r6rpo215zv9nukk08n54jq9wsh1a["\x63\x6f\x75\156\x74"];
                
                if (is_null($qhlmd95l2je9bcrimqphd0x["\x63\157\x75\156\164"])) {
                    $qhlmd95l2je9bcrimqphd0x["\143\x6f\x75\156\164"] = $z5o5n370y7nrn69h7d1xz93;
                    $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
                }
                if (\CModule::IncludeModuleEx("\x76\153\141\x70" . "\151\56\x6d\141" . "" . "\162" . "\153" . "\x65\164") == constant("\115\x4f\x44\x55\114\x45\x5f\104\x45\115\117" . "\137\x45\130\x50\x49\x52" . "\x45" . "" . "\x44")) {
                    throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\101\120\111\56\x4d\x41\x52\x4b\x45\124\x2e\104\105\115\x4f\x5f\x45" . "\130\120\x49" . "" . "" . "\x52\x45\104"), "\x42\x58\x4d\x41" . "\113\x45\x52\x5f\x44\105\115\117\x5f\x45\x58\x50\x49\x52\105\104");
                }
                if ($z5o5n370y7nrn69h7d1xz93) {
                    $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 = "\40\166\141\162\40\162\145\x73\165\x6c\164\x73\x20\75\x20\x5b\x5d\73\x20" . "\xa";
                    $r6rpo215zv9nukk08n54jq9wsh1a["\151\x74\145\x6d\163"] = array_slice($r6rpo215zv9nukk08n54jq9wsh1a["\x69\x74\x65\x6d\163"], 0, 25);
                    foreach ($r6rpo215zv9nukk08n54jq9wsh1a["\x69\x74\x65\x6d\x73"] as $k7eqxvix60) {
                        if ((int) $k7eqxvix60["\x69\144"] <= 0) {
                            continue;
                        }
                        $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 .= "\x20\162\145\x73\x75\x6c\x74\x73\x2e\x70\165\x73\x68\50\133" . $k7eqxvix60["\x69\x64"] . "\x2c\x20\101\120\x49\56\155\141\162\x6b\x65\x74\56\x64\145\154\145\164\145\50\x7b\x22\x6f\x77\x6e\145\162\137\x69\144\42\x20\x3a\40\x22\55" . $this->getGroupId() . "\42\x2c\x22\151\x74\x65\x6d\137\x69\144\42\40\x3a" . $k7eqxvix60["\x69\144"] . "\x7d\x29\x20\135\51\x3b" . "\xa";
                    }
                    $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7 .= "\40\x72\x65\164\x75\162\156\x20\x72\145\x73\165\154\164\x73\73";
                    $pxq0eglu9i = $this->connection()->method("\145\170\145\x63\165\164\x65", array("\x63\x6f\144\145" => $zroxeeeir6pd9gd80zdq1gqv541tlr5dm7));
                    $r6rpo215zv9nukk08n54jq9wsh1a = $pxq0eglu9i->getData("\162\145\163\160\157\156\x73\x65");
                    $wffewr0xfejid5hx84vdup6fm1vtonwu3h = $pxq0eglu9i->getData("\145\x78\x65\x63\x75\164\145\137\145\162\x72\x6f\162\x73") ?? [];
                    if (is_array($r6rpo215zv9nukk08n54jq9wsh1a)) {
                        foreach ($r6rpo215zv9nukk08n54jq9wsh1a as $hacdsstvxzfccwgx1gz8kcl) {
                            
                            if ($hacdsstvxzfccwgx1gz8kcl[1]) {
                                $qhlmd95l2je9bcrimqphd0x["\157\146\x66\x73\145\x74"]++;
                            } else {
                                throw new \VKapi\Market\Exception\ApiResponseException($wffewr0xfejid5hx84vdup6fm1vtonwu3h[0]);
                            }
                        }
                    }
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\x6f\146\146\163\x65\164"] = $qhlmd95l2je9bcrimqphd0x["\143\157\x75\x6e\164"];
                }
            }
        } catch (\VKapi\Market\Exception\BaseException $ouxam818oykc60ox4qap) {
        }
        
        $qhlmd95l2je9bcrimqphd0x["\x70\x65\162\x63\145\156\164"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\x63\157\165\x6e\x74"], $qhlmd95l2je9bcrimqphd0x["\157\146\146\x73\145\164"]);
        $qhlmd95l2je9bcrimqphd0x["\x6e\x61\155\x65"] = $this->getMessage("\x43\x4c\x45\101\122\x5f\x47\122\117\x55\x50\x5f\107\x4f\117\104\123\56\x50\x52\117\103\105\123\123", ["\x23\x4f\x46\106\123\105\124\x23" => $qhlmd95l2je9bcrimqphd0x["\x6f\146\146\163\145\x74"], "\x23\x43\x4f\125\x4e\x54\43" => $qhlmd95l2je9bcrimqphd0x["\x63\x6f\x75\156\164"]]);
        if ($qhlmd95l2je9bcrimqphd0x["\160\145\162\143\x65\156\164"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\x63\x6f\155\160\154\145\x74\x65"] = true;
        }
        if ($ouxam818oykc60ox4qap) {
            $qhlmd95l2je9bcrimqphd0x["\156\x61\155\145"] = $ouxam818oykc60ox4qap->getMessage();
            
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
            throw $ouxam818oykc60ox4qap;
        }
        
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        return $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\x6e\141\155\145" => $qhlmd95l2je9bcrimqphd0x["\156\141\x6d\145"], "\x70\145\x72\143\x65\x6e\164" => $qhlmd95l2je9bcrimqphd0x["\160\x65\x72\x63\x65\156\x74"], "\x63\157\x6d\160\x6c\145\x74\145" => $qhlmd95l2je9bcrimqphd0x["\143\157\155\x70\154\x65\x74\145"]]);
    }
}
?>