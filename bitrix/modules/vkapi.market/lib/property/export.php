<?php

namespace VKapi\Market\Property;

use Bitrix\Main\Localization\Loc;
use VKapi\Market\Exception\TimeoutException;
use VKapi\Market\Exception\ApiResponseException;
use VKapi\Market\Exception\BaseException;
use VKapi\Market\Exception\ResponseErrorException;
use VKapi\Market\Exception\ORMException;
use VKapi\Market\Export\Item;
use VKapi\Market\Result;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Export
{
    
    protected $arExportData = [];
    
    protected $oConnection = null;
    
    protected $oLog;
    
    protected $oState = null;
    
    protected $oProperty = null;
    
    protected $oExportItem = null;
    
    public function __construct(\VKapi\Market\Export\Item $k6guvgzwhk)
    {
        $this->oExportItem = $k6guvgzwhk;
    }
    
    public function getMessage($aqjtsa9n, $w2y12u0sl4xtikt7q4w3ydyqgpt8kq = null)
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\120\x49\56\x4d\101\122\x4b\x45\x54\56\120\x52\117\x50\105\x52\x54\131\x2e\x45\130\x50\117\x52\x54\56" . $aqjtsa9n, $w2y12u0sl4xtikt7q4w3ydyqgpt8kq);
    }
    
    public function property()
    {
        if (is_null($this->oProperty)) {
            $this->oProperty = new \VKapi\Market\Property\Property();
        }
        return $this->oProperty;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function log()
    {
        if (empty($this->oLog)) {
            $this->oLog = new \VKapi\Market\Export\Log(\VKapi\Market\Manager::getInstance()->getLogLevel());
            $this->oLog->setExportId($this->exportItem()->getId());
        }
        return $this->oLog;
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    public function state()
    {
        if (is_null($this->oState)) {
            $this->oState = new \VKapi\Market\State("\145\x78\160\x6f\162\x74\x5f" . intval($this->exportItem()->getId()), "\57\x70\162\x6f\160\x65\162\x74\x79");
        }
        return $this->oState;
    }
    
    public function getSteps()
    {
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\x65\160\x73"])) {
            return $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\145\x70\x73"];
        }
        return [];
    }
    
    public function getPercent()
    {
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        return $this->state()->calcPercentByData($u4voliardef7gcuv1yw9cl9jr4uf273kfdm);
    }
    public function isComplete()
    {
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (array_key_exists("\143\x6f\x6d\x70\x6c\x65\164\145", $u4voliardef7gcuv1yw9cl9jr4uf273kfdm)) {
            return $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\143\x6f\x6d\x70\154\145\164\x65"];
        }
        return false;
    }
    
    public function exportRun()
    {
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        
        if (!empty($u4voliardef7gcuv1yw9cl9jr4uf273kfdm) && $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x72\165\156"] && $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\164\x69\155\x65\123\x74\141\162\164"] > time() - 60 * 3) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\127\101\x49\124\x5f\x46\x49\x4e\x49\123\x48"), "\127\101\111\x54\137\106\x49\116\111\123\x48");
        }
        
        if (empty($u4voliardef7gcuv1yw9cl9jr4uf273kfdm) || !isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\x65\160"]) || $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x63\x6f\155\x70\x6c\145\164\145"]) {
            $this->state()->set(["\143\157\155\x70\154\145\164\145" => false, "\160\145\x72\x63\x65\156\x74" => 0, "\x73\164\x65\160" => 1, "\x73\164\x65\x70\x73" => [
                //все шаги, которые есть, в процессе работы, могут меняться сообщения, например обработано 2 из 10
                1 => ["\156\x61\155\145" => $this->getMessage("\x53\124\x45\120\61"), "\x70\145\162\x63\x65\156\164" => 0, "\145\162\x72\x6f\162" => false],
                2 => ["\x6e\141\155\145" => $this->getMessage("\x53\x54\105\x50\62"), "\160\145\162\x63\x65\x6e\164" => 0, "\x65\x72\x72\157\162" => false],
                3 => ["\x6e\x61\155\145" => $this->getMessage("\x53\124\105\120\x33"), "\x70\145\162\143\145\x6e\x74" => 0, "\x65\x72\x72\157\162" => false],
            ]]);
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
            $this->log()->notice($this->getMessage("\123\x54\x41\122\124\x45\x44"));
        }
        
        if (!$this->exportItem()->isEnabledExtendedGoods()) {
            $this->log()->notice($this->getMessage("\x44\x49\123\x41\x42\114\x45\104\x5f\105\130\x54\x45\x4e\104\105\x44\137\107\117\117\104\x53", ["\43\x53\124\x45\120\x23" => 1, "\x23\123\124\105\120\x5f\x4e\101\x4d\105\43" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\x65\x70\x73"][1]["\x6e\141\x6d\145"]]));
            foreach ($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\145\x70\x73"] as &$e1xwdh415rrefnvw4r58y0z5fkk3) {
                $e1xwdh415rrefnvw4r58y0z5fkk3["\160\x65\162\143\x65\x6e\164"] = 100;
            }
            unset($e1xwdh415rrefnvw4r58y0z5fkk3);
            
            $this->state()->set(["\162\x75\156" => false, "\163\164\x65\160\x73" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\145\x70\x73"], "\x63\157\155\x70\x6c\145\x74\145" => true, "\x70\145\x72\143\145\x6e\x74" => 100])->save();
            return true;
        }
        
        $this->state()->set(["\162\x75\156" => true, "\164\x69\x6d\x65\123\x74\141\162\x74" => time()])->save();
        try {
            switch ($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\145\160"]) {
                case 1:
                    $this->exportItem()->checkApiAccess();
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\145\160"]++;
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\x65\x70\163"][1]["\x70\x65\162\x63\x65\x6e\x74"] = 100;
                    $this->log()->notice($this->getMessage("\123\124\105\120\56\117\113", ["\x23\x53\124\x45\120\x23" => 1, "\x23\x53\124\105\120\x5f\116\101\115\x45\x23" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\145\160\163"][1]["\x6e\141\155\145"]]));
                    break;
                case 2:
                    if (\CModule::IncludeModuleEx("\x76" . "\x6b\141\x70\151\56" . "\x6d\x61\x72\x6b\x65" . "\x74") == constant("\x4d\117\x44\125\x4c\105" . "\x5f\104\105\115\x4f\x5f\105\130\120\x49\x52" . "\105\104")) {
                        throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\x41\120\111\56\115\101\122\113\x45\x54" . "" . "\56\104\105\x4d" . "\117\x5f\x45\x58\120\x49" . "" . "\122\105" . "\x44"), "\x42\130\x4d\101\x4b\x45\122\x5f\104\x45\115" . "\117\137\105\x58\120\x49\122\x45" . "\x44");
                    }
                    
                    $nb6hig0szvp2 = $this->exportRunExportProperties();
                    if ($nb6hig0szvp2->isSuccess()) {
                        if ($nb6hig0szvp2->getData("\x63\157\155\x70\154\x65\x74\145")) {
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\x65\160"]++;
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\x65\160\x73"][2]["\x70\x65\162\x63\x65\156\x74"] = 100;
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\145\x70\163"][2]["\x6e\141\155\x65"] = $this->getMessage("\123\124\105\120\62");
                            $this->log()->notice($this->getMessage("\123\124\105\x50\56\117\x4b", ["\43\x53\124\105\120\43" => 2, "\x23\123\x54\105\x50\137\x4e\101\115\x45\x23" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\145\160\x73"][2]["\156\141\155\145"]]));
                        } else {
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\x65\160\x73"][2]["\x70\145\x72\x63\145\156\x74"] = $nb6hig0szvp2->getData("\x70\145\162\143\x65\156\x74");
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\145\160\163"][2]["\156\x61\155\145"] = $nb6hig0szvp2->getData("\x6e\141\x6d\145");
                            $this->log()->notice($this->getMessage("\x53\124\x45\120\56\x50\122\117\103\105\x53\x53", ["\x23\x53\124\x45\x50\x23" => 2, "\x23\123\x54\x45\120\137\116\101\x4d\x45\x23" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\x65\160\163"][2]["\156\x61\x6d\145"], "\43\x50\x45\x52\x43\105\x4e\124\43" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\x65\160\163"][2]["\160\145\x72\143\x65\156\164"]]));
                        }
                    } else {
                        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\145\x70\163"][2]["\145\162\x72\157\x72"] = true;
                        $u6qncmw5573cnhhcpk1ques1z = $nb6hig0szvp2;
                    }
                    break;
                case 3:
                    if (\Bitrix\Main\Loader::includeSharewareModule("\166\x6b\141\x70\x69" . "\x2e\x6d\141\162\153" . "\145\164") === constant("\115\117\104" . "" . "\125\x4c\x45\x5f\x44\x45\115" . "\117\x5f\x45\130\x50\111\122\x45" . "\104")) {
                        throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113" . "\101\120\x49\56" . "\115\x41\122\x4b\105\x54\56\x44\105\x4d\x4f\x5f\x45\x58\120" . "\x49" . "\122\105\104"), "\102\130\x4d\101\113\105\x52\x5f\104\105\x4d\x4f\x5f\x45" . "\130\120\111" . "\x52\x45\104");
                    }
                    
                    $nb6hig0szvp2 = $this->exportRunExportVariants();
                    if ($nb6hig0szvp2->isSuccess()) {
                        if ($nb6hig0szvp2->getData("\x63\x6f\x6d\160\154\145\x74\145")) {
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\x65\160"]++;
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\145\x70\x73"][3]["\x70\145\162\143\145\x6e\164"] = 100;
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\x65\160\x73"][3]["\156\x61\x6d\x65"] = $this->getMessage("\x53\x54\105\120\63");
                            $this->log()->notice($this->getMessage("\123\124\x45\120\56\x4f\x4b", ["\43\x53\x54\x45\x50\43" => 3, "\x23\x53\124\x45\x50\x5f\x4e\101\x4d\x45\x23" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\x65\160\x73"][3]["\156\x61\155\x65"]]));
                        } else {
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\145\x70\163"][3]["\x70\145\x72\x63\x65\x6e\164"] = $nb6hig0szvp2->getData("\x70\145\162\x63\145\156\164");
                            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\145\160\x73"][3]["\x6e\141\155\x65"] = $nb6hig0szvp2->getData("\156\x61\155\x65");
                            $this->log()->notice($this->getMessage("\x53\124\x45\120\x2e\x50\x52\117\x43\x45\123\x53", ["\43\123\x54\105\120\43" => 3, "\43\123\x54\105\120\x5f\116\101\115\105\x23" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\145\160\163"][3]["\x6e\x61\155\145"], "\x23\120\x45\122\x43\105\x4e\x54\x23" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\164\x65\x70\x73"][3]["\160\x65\x72\x63\x65\x6e\x74"]]));
                        }
                    } else {
                        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\163\x74\145\x70\x73"][3]["\x65\162\x72\157\162"] = true;
                        $u6qncmw5573cnhhcpk1ques1z = $nb6hig0szvp2;
                    }
                    break;
                default:
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x70\x65\162\x63\x65\156\x74"] = 100;
                    $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\143\157\155\160\154\145\x74\x65"] = true;
            }
        } catch (\VKapi\Market\Exception\BaseException $ouxam818oykc60ox4qap) {
            $this->log()->error($ouxam818oykc60ox4qap->getMessage(), $ouxam818oykc60ox4qap->getCustomData());
        }
        
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\160\x65\162\143\x65\156\164"] = $this->state()->calcPercentByData($u4voliardef7gcuv1yw9cl9jr4uf273kfdm);
        if ($u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x70\x65\x72\143\145\156\164"] == 100) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x63\x6f\155\x70\x6c\145\164\x65"] = true;
            $this->log()->notice($this->getMessage("\103\x4f\115\120\114\x45\124\x45"));
        }
        
        $this->state()->set(["\162\x75\156" => false, "\163\x74\145\160" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\164\145\160"], "\x73\164\x65\160\x73" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x73\x74\145\160\x73"], "\143\x6f\x6d\160\154\145\x74\145" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\143\x6f\x6d\160\x6c\x65\x74\x65"], "\160\145\x72\x63\x65\156\164" => $u4voliardef7gcuv1yw9cl9jr4uf273kfdm["\x70\145\x72\143\x65\x6e\164"]])->save();
        if (isset($ouxam818oykc60ox4qap) && $ouxam818oykc60ox4qap instanceof \VKapi\Market\Exception\ApiResponseException) {
            throw $ouxam818oykc60ox4qap;
        }
    }
    
    public function getPropertiesFromVk()
    {
        $i1iog5m03cqpoyi = [];
        try {
            $qg2x3aos1pzukztd0 = $this->exportItem()->connection()->method("\155\x61\162\153\x65\x74\56\x67\145\164\x50\162\x6f\x70\145\162\x74\x69\x65\x73", ["\147\162\157\x75\x70\x5f\x69\x64" => $this->exportItem()->getGroupId()]);
            $r6rpo215zv9nukk08n54jq9wsh1a = $qg2x3aos1pzukztd0->getData("\162\145\x73\160\x6f\x6e\163\145");
            $i1iog5m03cqpoyi = $r6rpo215zv9nukk08n54jq9wsh1a["\151\164\x65\x6d\x73"];
        } catch (\VKapi\Market\Exception\ApiResponseException $m2bi85eiwkagik5akk1yga00kl0znv47) {
            $this->log()->error($this->getMessage("\107\x45\124\x5f\x50\122\x4f\120\x45\122\x54\x49\105\123\137\106\x52\x4f\115\x5f\126\113\56\x45\122\122\117\122", ["\43\x4d\x53\107\43" => $m2bi85eiwkagik5akk1yga00kl0znv47->getMessage()]));
            if ($m2bi85eiwkagik5akk1yga00kl0znv47->is(\VKapi\Market\Api::ERROR_1409)) {
                throw $m2bi85eiwkagik5akk1yga00kl0znv47;
            }
        }
        return $i1iog5m03cqpoyi;
    }
    
    public function exportRunExportProperties()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\145\170\x70\x6f\162\164\120\x72\157\160\x65\162\164\151\145\163";
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = ["\x63\157\x6d\160\x6c\145\164\145" => false, "\160\x65\162\x63\145\156\164" => 0, "\156\141\x6d\x65" => "", "\x73\164\x65\x70" => 1, "\163\x74\x65\x70\x73" => [1 => ["\160\x65\x72\x63\145\x6e\164" => 0, "\156\x61\155\145" => $this->getMessage("\x45\x58\120\x4f\122\124\x5f\x50\x52\x4f\120\x45\x52\x54\x49\x45\123\x2e\x53\x54\105\120\x31")], 2 => ["\x70\145\x72\x63\x65\156\164" => 0, "\156\141\x6d\x65" => $this->getMessage("\x45\x58\x50\117\122\x54\x5f\x50\122\x4f\x50\105\x52\124\111\x45\123\56\123\x54\105\x50\x32")]]];
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        switch ($qhlmd95l2je9bcrimqphd0x["\163\164\145\x70"]) {
            case "\x31":
                $u6qncmw5573cnhhcpk1ques1z = $this->exportPropertiesActionDelete();
                $qhlmd95l2je9bcrimqphd0x["\x6e\141\155\145"] = $qhlmd95l2je9bcrimqphd0x["\x73\x74\145\x70\x73"][1]["\156\x61\155\x65"];
                $qhlmd95l2je9bcrimqphd0x["\x73\x74\145\160\x73"][1]["\x70\145\x72\143\x65\156\x74"] = $u6qncmw5573cnhhcpk1ques1z->getData("\x70\x65\x72\x63\145\x6e\164");
                if ($u6qncmw5573cnhhcpk1ques1z->getData("\x63\x6f\155\x70\x6c\145\x74\145")) {
                    $qhlmd95l2je9bcrimqphd0x["\x73\164\145\160"]++;
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\156\x61\155\x65"] .= "\40" . $qhlmd95l2je9bcrimqphd0x["\163\164\x65\160\x73"][1]["\x70\x65\162\x63\x65\x6e\x74"] . "\45";
                }
                break;
            case "\62":
                $u6qncmw5573cnhhcpk1ques1z = $this->exportPropertiesActionAdd();
                $qhlmd95l2je9bcrimqphd0x["\156\x61\x6d\145"] = $qhlmd95l2je9bcrimqphd0x["\x73\x74\x65\160\x73"][2]["\x6e\x61\x6d\x65"];
                $qhlmd95l2je9bcrimqphd0x["\163\x74\x65\x70\x73"][2]["\x70\x65\x72\143\x65\x6e\x74"] = $u6qncmw5573cnhhcpk1ques1z->getData("\x70\145\162\143\x65\x6e\164");
                if ($u6qncmw5573cnhhcpk1ques1z->getData("\143\x6f\x6d\x70\x6c\145\164\x65")) {
                    $qhlmd95l2je9bcrimqphd0x["\x73\164\x65\160"]++;
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\156\x61\155\x65"] .= "\40" . $qhlmd95l2je9bcrimqphd0x["\163\164\x65\160\163"][2]["\x70\x65\162\x63\145\x6e\164"] . "\45";
                }
                break;
            default:
                $qhlmd95l2je9bcrimqphd0x["\x63\157\x6d\160\154\x65\164\x65"] = true;
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\x65\x72\x63\145\156\164"] = $this->state()->calcPercentByData($qhlmd95l2je9bcrimqphd0x);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\145\x72\x63\145\x6e\164"] == 100) {
            $qhlmd95l2je9bcrimqphd0x["\143\157\155\160\x6c\145\164\145"] = true;
        }
        
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        return $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\x6e\141\155\x65" => $qhlmd95l2je9bcrimqphd0x["\x6e\141\155\145"], "\160\145\x72\x63\x65\156\164" => $qhlmd95l2je9bcrimqphd0x["\x70\145\162\x63\x65\x6e\x74"], "\143\x6f\155\160\154\145\x74\x65" => $qhlmd95l2je9bcrimqphd0x["\143\x6f\x6d\x70\154\x65\x74\145"]]);
    }
    
    public function exportPropertiesActionDelete()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\145\170\x70\x6f\x72\164\120\x72\157\160\145\x72\164\x69\145\163\x41\143\x74\x69\x6f\156\104\x65\154\x65\164\x65";
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = ["\143\157\155\160\154\x65\x74\x65" => false, "\143\x6f\x75\x6e\x74" => 0, "\157\x66\146\x73\145\x74" => 0, "\160\x65\162\143\x65\x6e\164" => 0];
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        try {
            if (!isset($qhlmd95l2je9bcrimqphd0x["\x70\x72\x6f\x70\145\162\x74\x69\145\x73"])) {
                $qhlmd95l2je9bcrimqphd0x["\160\162\157\160\x65\x72\164\x69\x65\x73"] = $this->getPropertiesFromVk();
                $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
            }
            
            $nqa7p7lxiycqcvmmany28fou3euby1g27nw = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
            $imx7cno41a1j = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\126\x4b\x5f\x50\122\x4f\120\x45\x52\x54\131\x5f\x49\104");
            $q6isvacfqksnsz7eez4xpae = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\120\x52\x4f\x50\105\122\x54\131\137\x49\x44", "\126\113\137\120\122\x4f\120\x45\122\x54\x59\x5f\x49\x44");
            
            $hgzypseuvx4jcy4yl63 = $qhlmd95l2je9bcrimqphd0x["\x70\162\x6f\x70\145\162\164\x69\145\163"];
            $j0shk3qhlf = array_column($hgzypseuvx4jcy4yl63, "\x69\x64");
            
            $jgmcoozpmh8il3i98tl9zdpkgs1 = array_diff($imx7cno41a1j, $j0shk3qhlf);
            if (count($jgmcoozpmh8il3i98tl9zdpkgs1)) {
                $h0xsykc2jp4e087b2j394yjpm8p0goxqzzg = array_flip($jgmcoozpmh8il3i98tl9zdpkgs1);
                $u10g355i6u7p7a6 = array_intersect_key($q6isvacfqksnsz7eez4xpae, $h0xsykc2jp4e087b2j394yjpm8p0goxqzzg);
                $this->property()->deleteByGroupIdPropertyId($this->exportItem()->getGroupId(), array_values($u10g355i6u7p7a6));
            }
            
            $iacw6e62pvw2rcwpzj15rkrhbyfxwcmy = $this->getNeedExistsPropertyId();
            $nqa7p7lxiycqcvmmany28fou3euby1g27nw = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
            $ns4q4iz0iavo46sqmoacfhiejfcjqb05 = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\x50\122\117\120\105\122\x54\x59\137\111\104");
            $fsi3oo0v8jor90j3 = array_diff($ns4q4iz0iavo46sqmoacfhiejfcjqb05, $iacw6e62pvw2rcwpzj15rkrhbyfxwcmy);
            if (count($fsi3oo0v8jor90j3)) {
                $this->property()->deleteByGroupIdPropertyId($this->exportItem()->getGroupId(), array_values($fsi3oo0v8jor90j3));
            }
            
            $nqa7p7lxiycqcvmmany28fou3euby1g27nw = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
            $x80w9r4r0ytks0mldl3y5twrvjc07ntt14 = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\126\x4b\x5f\x50\x52\117\x50\x45\x52\x54\x59\x5f\111\104");
            $xdjpv2pj0uab2 = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\x50\x52\x4f\x50\x45\x52\x54\131\x5f\111\104", "\x56\113\137\120\x52\117\120\x45\122\124\131\x5f\111\x44");
            
            $ftqnsq6c5v3s5fp = array_column($hgzypseuvx4jcy4yl63, "\x69\144");
            $e3bubfkrl2vd = array_diff($ftqnsq6c5v3s5fp, $x80w9r4r0ytks0mldl3y5twrvjc07ntt14);
            $qhlmd95l2je9bcrimqphd0x["\x63\157\x75\x6e\164"] = count($e3bubfkrl2vd);
            $e3bubfkrl2vd = array_slice($e3bubfkrl2vd, $qhlmd95l2je9bcrimqphd0x["\x6f\x66\x66\163\145\x74"]);
            while (count($e3bubfkrl2vd)) {
                $this->manager()->checkTime();
                $eecijmwfukempun82o = array_shift($e3bubfkrl2vd);
                try {
                    $nyq9rwk2jdwow5so3lxeon2j8k = $this->exportItem()->connection()->method("\x6d\141\162\153\x65\164\56\144\x65\154\145\164\145\x50\x72\157\160\x65\162\164\171", ["\147\x72\157\x75\x70\x5f\151\x64" => $this->exportItem()->getGroupId(), "\x70\x72\157\160\x65\162\x74\x79\137\151\x64" => $eecijmwfukempun82o]);
                } catch (\VKapi\Market\Exception\ApiResponseException $m2bi85eiwkagik5akk1yga00kl0znv47) {
                    $this->log()->error($this->getMessage("\105\x58\120\x4f\122\124\x5f\x50\122\x4f\x50\105\122\x54\x49\105\x53\x5f\101\x43\124\x49\x4f\116\x5f\x44\105\x4c\105\124\x45\56\105\122\122\117\x52", ["\x23\x4d\x53\x47\x23" => $m2bi85eiwkagik5akk1yga00kl0znv47->getMessage(), "\x23\120\x52\x4f\120\105\x52\x54\x59\x5f\x49\x44\43" => $xdjpv2pj0uab2[$eecijmwfukempun82o], "\43\126\113\x5f\x50\122\x4f\x50\x45\122\x54\x59\137\x49\104\43" => $eecijmwfukempun82o]));
                }
                $qhlmd95l2je9bcrimqphd0x["\157\146\x66\163\x65\164"]++;
            }
        } catch (\VKapi\Market\Exception\TimeoutException $ouxam818oykc60ox4qap) {
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\145\162\143\145\x6e\164"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\x63\x6f\x75\x6e\164"], $qhlmd95l2je9bcrimqphd0x["\157\146\146\x73\145\x74"]);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\145\x72\143\x65\x6e\164"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\x63\157\x6d\x70\x6c\x65\x74\x65"] = true;
            unset($qhlmd95l2je9bcrimqphd0x["\160\x72\157\x70\145\162\x74\151\x65\x73"]);
        }
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        
        $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\x63\157\x6d\160\154\145\x74\x65" => $qhlmd95l2je9bcrimqphd0x["\143\157\155\x70\x6c\145\164\145"], "\160\x65\x72\x63\x65\x6e\164" => $qhlmd95l2je9bcrimqphd0x["\160\145\162\x63\145\156\164"]]);
        return $u6qncmw5573cnhhcpk1ques1z;
    }
    
    public function exportPropertiesActionAdd()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\145\x78\x70\x6f\162\164\120\x72\x6f\x70\145\x72\x74\151\x65\163\x41\143\164\151\157\x6e\x41\x64\x64";
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = ["\x63\x6f\x75\x6e\x74" => 0, "\157\146\146\163\145\x74" => 0, "\x70\x65\162\x63\145\156\x74" => 0];
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        try {
            
            if (!isset($qhlmd95l2je9bcrimqphd0x["\160\162\157\160\145\162\x74\x69\x65\x73"])) {
                $qhlmd95l2je9bcrimqphd0x["\x70\x72\x6f\x70\145\x72\164\151\x65\x73"] = $this->getPropertiesFromVk();
                $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
            }
            
            $nqa7p7lxiycqcvmmany28fou3euby1g27nw = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
            $ns4q4iz0iavo46sqmoacfhiejfcjqb05 = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\120\x52\117\120\105\122\124\131\137\111\x44");
            
            $h2wkog1ipkybileyxk4s38wqyomqdvpyl1q = $this->getNeedExistsPropertyId();
            
            $uih9gb = array_diff($h2wkog1ipkybileyxk4s38wqyomqdvpyl1q, $ns4q4iz0iavo46sqmoacfhiejfcjqb05);
            $qhlmd95l2je9bcrimqphd0x["\x63\x6f\165\156\164"] = count($uih9gb);
            $i6x5fhip5flf5lax7goi11psoa9imyeuzi8 = array_slice($uih9gb, $qhlmd95l2je9bcrimqphd0x["\x6f\146\x66\x73\x65\x74"]);
            while (count($i6x5fhip5flf5lax7goi11psoa9imyeuzi8)) {
                $this->manager()->checkTime();
                $eecijmwfukempun82o = array_shift($i6x5fhip5flf5lax7goi11psoa9imyeuzi8);
                $this->addPropertyToVk($eecijmwfukempun82o);
                $qhlmd95l2je9bcrimqphd0x["\157\146\146\x73\x65\x74"]++;
            }
        } catch (\VKapi\Market\Exception\TimeoutException $ouxam818oykc60ox4qap) {
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\145\x72\143\145\156\164"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\x63\x6f\165\x6e\164"], $qhlmd95l2je9bcrimqphd0x["\157\x66\146\x73\x65\164"]);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\145\162\x63\x65\156\x74"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\x63\157\x6d\x70\x6c\145\164\145"] = true;
            unset($qhlmd95l2je9bcrimqphd0x["\x70\162\157\x70\x65\162\x74\151\x65\x73"]);
        }
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        
        $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\x63\157\x6d\160\x6c\x65\164\145" => $qhlmd95l2je9bcrimqphd0x["\x63\x6f\x6d\160\x6c\145\164\145"], "\160\145\x72\143\x65\156\x74" => $qhlmd95l2je9bcrimqphd0x["\160\x65\162\x63\x65\x6e\x74"]]);
        return $u6qncmw5573cnhhcpk1ques1z;
    }
    
    public function addPropertyToVk($eecijmwfukempun82o)
    {
        $vuo6y2lywu9vm64yyu9c75iez3114r7xi7 = \CIBlockProperty::GetByID($eecijmwfukempun82o)->fetch();
        if (!$vuo6y2lywu9vm64yyu9c75iez3114r7xi7) {
            $this->log()->error($this->getMessage("\101\x44\104\x5f\120\122\117\x50\x45\x52\x54\x59\x5f\x54\x4f\x5f\x56\x4b\x2e\x4e\117\x54\x5f\x46\x4f\x55\116\104", ["\x23\111\x44\x23" => $eecijmwfukempun82o]));
            return true;
        }
        
        $r8m4m = ["\147\x72\157\x75\160\x5f\x69\x64" => $this->exportItem()->getGroupId(), "\164\x69\x74\154\x65" => $vuo6y2lywu9vm64yyu9c75iez3114r7xi7["\116\101\115\x45"], "\x74\x79\x70\x65" => "\x74\x65\170\x74"];
        try {
            $u6qncmw5573cnhhcpk1ques1z = $this->exportItem()->connection()->method("\155\141\x72\x6b\145\164\x2e\141\x64\144\120\162\x6f\160\x65\162\164\171", $r8m4m);
            $r6rpo215zv9nukk08n54jq9wsh1a = $u6qncmw5573cnhhcpk1ques1z->getData("\162\x65\163\160\157\156\x73\x65");
            if ($r6rpo215zv9nukk08n54jq9wsh1a["\x70\162\157\x70\145\x72\164\x79\x5f\151\x64"]) {
                
                $this->property()->table()->add(["\107\122\x4f\x55\x50\137\x49\104" => $this->exportItem()->getGroupId(), "\x50\x52\x4f\120\x45\122\x54\x59\x5f\111\x44" => $eecijmwfukempun82o, "\x56\x4b\137\120\122\x4f\x50\x45\122\124\x59\137\111\104" => intval($r6rpo215zv9nukk08n54jq9wsh1a["\160\162\157\x70\145\162\x74\171\137\151\x64"])]);
                $this->log()->ok($this->getMessage("\x41\104\104\137\x50\x52\117\x50\x45\x52\124\131\x5f\124\x4f\x5f\126\113\x2e\117\x4b", ["\x23\111\x44\x23" => $eecijmwfukempun82o . "\x20" . $vuo6y2lywu9vm64yyu9c75iez3114r7xi7["\x4e\x41\x4d\105"], "\43\x56\x4b\137\x49\104\43" => intval($r6rpo215zv9nukk08n54jq9wsh1a["\160\162\x6f\160\145\x72\164\x79\x5f\x69\x64"])]));
            }
        } catch (\VKapi\Market\Exception\ApiResponseException $m2bi85eiwkagik5akk1yga00kl0znv47) {
            $this->log()->error($this->getMessage("\101\x44\x44\x5f\x50\x52\117\120\x45\122\124\x59\x5f\124\117\137\x56\x4b\56\105\122\122\117\122", ["\x23\115\123\107\43" => $m2bi85eiwkagik5akk1yga00kl0znv47->getMessage(), "\x23\x49\x44\43" => $eecijmwfukempun82o . "\x20" . $vuo6y2lywu9vm64yyu9c75iez3114r7xi7["\116\x41\115\105"]]));
        }
        return true;
    }
    
    public function exportRunExportVariants()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\145\170\x70\x6f\162\164\x56\141\x72\151\x61\x6e\164\163";
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = ["\143\x6f\155\160\x6c\145\164\145" => false, "\160\x65\x72\143\145\156\x74" => 0, "\156\x61\155\145" => "", "\163\x74\145\160" => 1, "\x73\164\x65\160\x73" => [1 => ["\x70\145\x72\x63\145\156\x74" => 0, "\x6e\141\155\145" => $this->getMessage("\x45\x58\x50\x4f\122\x54\x5f\126\101\x52\111\101\116\x54\123\56\123\124\105\x50\x31")], 2 => ["\160\145\162\143\x65\156\164" => 0, "\156\x61\x6d\145" => $this->getMessage("\105\130\120\x4f\x52\124\x5f\x56\x41\x52\111\101\x4e\124\x53\x2e\x53\124\x45\x50\62")]]];
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        switch ($qhlmd95l2je9bcrimqphd0x["\x73\x74\145\x70"]) {
            case "\61":
                $u6qncmw5573cnhhcpk1ques1z = $this->exportRunExportVariantsActionUpdate();
                $qhlmd95l2je9bcrimqphd0x["\x6e\141\155\x65"] = $qhlmd95l2je9bcrimqphd0x["\x73\x74\x65\160\163"][1]["\x6e\x61\155\x65"];
                $qhlmd95l2je9bcrimqphd0x["\163\164\x65\160\163"][1]["\x70\145\162\x63\145\156\164"] = $u6qncmw5573cnhhcpk1ques1z->getData("\x70\145\162\143\145\156\x74");
                if ($u6qncmw5573cnhhcpk1ques1z->getData("\x63\x6f\155\x70\x6c\x65\164\145")) {
                    $qhlmd95l2je9bcrimqphd0x["\x73\164\145\160"]++;
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\x6e\141\x6d\145"] .= "\x20\55\x20" . $u6qncmw5573cnhhcpk1ques1z->getData("\x6e\x61\x6d\x65");
                }
                break;
            case "\x32":
                if (\Bitrix\Main\Loader::includeSharewareModule("\166\x6b\x61" . "" . "\160\x69\56\x6d\141\x72\153\145" . "\164") === constant("\115\x4f\104\x55\x4c" . "\x45\137\104\105\115\x4f\137" . "\x45\x58\x50\x49" . "\122\x45" . "" . "" . "" . "" . "\104")) {
                    throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\101\x50\111\x2e\115\101\x52\x4b\105\x54\x2e\x44\105\x4d\117\x5f\105\130\x50\x49" . "\x52\x45\x44"), "\x42\x58\115\101\x4b" . "\105" . "\122\137\x44\105\x4d\x4f\137\x45\130\120" . "\111\122\x45" . "" . "" . "" . "\104");
                }
                $u6qncmw5573cnhhcpk1ques1z = $this->exportRunExportVariantsActionAdd();
                $qhlmd95l2je9bcrimqphd0x["\x6e\x61\155\x65"] = $qhlmd95l2je9bcrimqphd0x["\x73\164\145\160\163"][2]["\156\141\155\145"];
                $qhlmd95l2je9bcrimqphd0x["\163\164\145\x70\x73"][2]["\x70\145\162\x63\x65\x6e\x74"] = $u6qncmw5573cnhhcpk1ques1z->getData("\x70\x65\162\143\x65\156\164");
                if ($u6qncmw5573cnhhcpk1ques1z->getData("\143\157\155\x70\x6c\145\x74\145")) {
                    $qhlmd95l2je9bcrimqphd0x["\x73\164\145\160"]++;
                } else {
                    $qhlmd95l2je9bcrimqphd0x["\156\141\x6d\x65"] .= "\x20\x2d\x20" . $u6qncmw5573cnhhcpk1ques1z->getData("\156\x61\155\145");
                }
                break;
            default:
                $qhlmd95l2je9bcrimqphd0x["\x63\x6f\155\x70\154\x65\x74\x65"] = true;
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\145\162\x63\x65\x6e\164"] = $this->state()->calcPercentByData($qhlmd95l2je9bcrimqphd0x);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\145\162\x63\145\x6e\x74"] == 100) {
            $qhlmd95l2je9bcrimqphd0x["\143\157\155\160\x6c\x65\x74\145"] = true;
        }
        
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        return $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\x6e\x61\155\145" => $qhlmd95l2je9bcrimqphd0x["\x6e\141\x6d\145"], "\x70\145\162\x63\x65\x6e\164" => $qhlmd95l2je9bcrimqphd0x["\160\x65\x72\x63\145\x6e\164"], "\143\157\x6d\x70\x6c\145\x74\145" => $qhlmd95l2je9bcrimqphd0x["\143\157\155\x70\154\145\x74\x65"]]);
    }
    
    public function exportRunExportVariantsActionUpdate()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\145\x78\160\x6f\x72\164\126\x61\x72\151\141\x6e\x74\x73\x41\x63\x74\x69\x6f\x6e\125\160\x64\141\x74\145";
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = [
                "\x63\x6f\x6d\160\x6c\x65\164\x65" => false,
                "\x70\x65\x72\x63\x65\156\164" => 0,
                "\x63\x6f\165\156\x74" => 0,
                "\157\x66\x66\163\145\x74" => 0,
                // отступ по свойствам
                "\x73\165\142\x43\157\165\x6e\164" => 0,
                // варианты значений
                "\163\x75\142\117\x66\x66\163\145\164" => 0,
            ];
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        try {
            
            $qhlmd95l2je9bcrimqphd0x["\x70\162\x6f\x70\145\162\164\151\145\x73"] = $this->getPropertiesFromVk();
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
            $we8a2h9mrmbcj93gvqa = array_column($qhlmd95l2je9bcrimqphd0x["\x70\162\157\160\145\x72\164\x69\145\x73"], "\x76\141\162\x69\141\x6e\x74\163", "\151\144");
            
            $nqa7p7lxiycqcvmmany28fou3euby1g27nw = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
            $ns4q4iz0iavo46sqmoacfhiejfcjqb05 = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\120\122\x4f\120\x45\122\124\131\137\111\104");
            $nkwkxqm59jaqpkmj0b13fcmubllrc = $this->property()->getIblockPropertiesById($ns4q4iz0iavo46sqmoacfhiejfcjqb05);
            $pa8gnq39md2utwwwh73ulrf0uh3of0d7v63 = array_column($nkwkxqm59jaqpkmj0b13fcmubllrc, "\x4e\101\x4d\105", "\111\104");
            $qhlmd95l2je9bcrimqphd0x["\143\x6f\x75\156\x74"] = count($nqa7p7lxiycqcvmmany28fou3euby1g27nw);
            
            $vysys8pe = array_slice($nqa7p7lxiycqcvmmany28fou3euby1g27nw, $qhlmd95l2je9bcrimqphd0x["\157\x66\146\x73\145\164"]);
            
            $wftvmhxh = 0;
            while (count($vysys8pe)) {
                $this->manager()->checkTime();
                
                $s2csek72z0m = array_shift($vysys8pe);
                
                if (!isset($we8a2h9mrmbcj93gvqa[$s2csek72z0m["\x56\x4b\137\x50\x52\x4f\x50\105\x52\x54\x59\x5f\111\104"]])) {
                    $qhlmd95l2je9bcrimqphd0x["\x6f\x66\146\163\x65\x74"]++;
                    continue;
                }
                
                $s318tyu9uqz4z4t1j1hlij21t7fdk8fry = $we8a2h9mrmbcj93gvqa[$s2csek72z0m["\x56\x4b\x5f\x50\122\117\x50\x45\x52\x54\x59\x5f\x49\x44"]];
                
                $oayhrak8hdp7vkjuw2rgcieg110mwhd = $this->property()->getPropertyVariants($s2csek72z0m["\120\x52\x4f\x50\105\122\x54\131\x5f\x49\104"]);
                $hd78b8spjzry0dc = array_column($oayhrak8hdp7vkjuw2rgcieg110mwhd, "\116\x41\115\105", "\111\104");
                $qhlmd95l2je9bcrimqphd0x["\163\165\142\103\x6f\165\156\x74"] = count($s318tyu9uqz4z4t1j1hlij21t7fdk8fry);
                $dc3p3o5tfx2pulvfl4lvtbzi2 = array_slice($s318tyu9uqz4z4t1j1hlij21t7fdk8fry, $qhlmd95l2je9bcrimqphd0x["\163\165\142\x4f\146\146\163\145\164"]);
                
                while (count($dc3p3o5tfx2pulvfl4lvtbzi2)) {
                    $this->manager()->checkTime();
                    $wjlsy1k7q3s31rzhyu7kwg0qyfdty = array_shift($dc3p3o5tfx2pulvfl4lvtbzi2);
                    
                    if (!isset($hd78b8spjzry0dc[$wjlsy1k7q3s31rzhyu7kwg0qyfdty["\166\x61\x6c\165\145"]])) {
                        $qhlmd95l2je9bcrimqphd0x["\x73\x75\x62\117\146\x66\x73\x65\x74"]++;
                        continue;
                    }
                    
                    if ($hd78b8spjzry0dc[$wjlsy1k7q3s31rzhyu7kwg0qyfdty["\166\x61\154\x75\145"]] == $wjlsy1k7q3s31rzhyu7kwg0qyfdty["\x74\x69\x74\x6c\145"]) {
                        $qhlmd95l2je9bcrimqphd0x["\163\x75\142\x4f\146\x66\x73\145\164"]++;
                        continue;
                    }
                    
                    try {
                        $nyq9rwk2jdwow5so3lxeon2j8k = $this->exportItem()->connection()->method("\155\141\162\153\x65\x74\56\x65\144\151\x74\x50\x72\157\x70\x65\162\164\x79\x56\141\162\x69\141\156\x74", ["\x67\x72\x6f\165\160\137\151\x64" => $this->exportItem()->getGroupId(), "\x76\141\x72\x69\141\x6e\164\x5f\151\144" => $wjlsy1k7q3s31rzhyu7kwg0qyfdty["\151\144"], "\164\x69\164\x6c\145" => $hd78b8spjzry0dc[$wjlsy1k7q3s31rzhyu7kwg0qyfdty["\166\141\154\x75\x65"]], "\x76\141\154\165\x65" => $wjlsy1k7q3s31rzhyu7kwg0qyfdty["\x76\141\x6c\165\145"]]);
                    } catch (\VKapi\Market\Exception\ApiResponseException $m2bi85eiwkagik5akk1yga00kl0znv47) {
                        $this->log()->error($this->getMessage("\105\122\122\117\x52\137\105\130\120\117\x52\x54\137\x56\x41\x52\111\x41\x4e\124\x5f\x41\x43\124\111\x4f\x4e\x5f\x55\x50\104\x41\124\105", ["\x23\x4d\123\x47\x23" => $m2bi85eiwkagik5akk1yga00kl0znv47->getMessage(), "\x23\x50\122\x4f\x50\105\122\x54\x59\x5f\x49\x44\x23" => $s2csek72z0m["\x50\x52\x4f\x50\x45\x52\124\131\137\x49\104"], "\x23\x56\101\x52\111\x41\x4e\x54\x5f\111\x44\x23" => $wjlsy1k7q3s31rzhyu7kwg0qyfdty["\x76\x61\x6c\x75\x65"]]));
                    }
                    $qhlmd95l2je9bcrimqphd0x["\x73\165\142\x4f\x66\146\163\x65\164"]++;
                }
                $qhlmd95l2je9bcrimqphd0x["\156\141\x6d\x65"] = $pa8gnq39md2utwwwh73ulrf0uh3of0d7v63[$s2csek72z0m["\120\122\x4f\120\105\x52\x54\131\137\111\x44"]] ?? "\x5b" . $s2csek72z0m["\120\x52\x4f\x50\x45\122\124\x59\x5f\111\x44"] . "\135";
                $qhlmd95l2je9bcrimqphd0x["\156\x61\155\x65"] .= "\40";
                $qhlmd95l2je9bcrimqphd0x["\x6e\141\155\145"] .= $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\163\x75\142\x43\157\x75\x6e\x74"], $qhlmd95l2je9bcrimqphd0x["\163\x75\x62\x4f\146\x66\163\x65\164"]) . "\45";
                
                if ($qhlmd95l2je9bcrimqphd0x["\163\165\x62\x4f\x66\146\163\x65\164"] >= $qhlmd95l2je9bcrimqphd0x["\163\x75\142\x43\157\x75\156\x74"]) {
                    $qhlmd95l2je9bcrimqphd0x["\x73\x75\142\117\146\146\x73\x65\164"] = 0;
                    $qhlmd95l2je9bcrimqphd0x["\x73\x75\x62\103\x6f\165\156\x74"] = 0;
                    $qhlmd95l2je9bcrimqphd0x["\157\146\x66\163\x65\164"]++;
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $ouxam818oykc60ox4qap) {
        }
        
        $qhlmd95l2je9bcrimqphd0x["\x70\x65\x72\x63\x65\156\164"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\x63\157\x75\156\x74"], $qhlmd95l2je9bcrimqphd0x["\x6f\146\x66\163\145\x74"]);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\x65\x72\x63\x65\x6e\164"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\143\157\x6d\x70\154\145\x74\x65"] = true;
            unset($qhlmd95l2je9bcrimqphd0x["\x70\x72\x6f\160\145\162\x74\151\145\163"]);
        }
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        
        $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\156\x61\155\145" => $qhlmd95l2je9bcrimqphd0x["\156\x61\x6d\x65"], "\143\157\155\160\154\145\164\145" => $qhlmd95l2je9bcrimqphd0x["\143\157\x6d\x70\x6c\145\x74\145"], "\160\x65\x72\143\x65\156\x74" => $qhlmd95l2je9bcrimqphd0x["\160\x65\162\x63\x65\x6e\x74"]]);
        return $u6qncmw5573cnhhcpk1ques1z;
    }
    
    public function exportRunExportVariantsActionAdd()
    {
        $u6qncmw5573cnhhcpk1ques1z = new \VKapi\Market\Result();
        $sfk1tjrxllk6hq3263jtwp4v180pa = "\145\170\x70\x6f\x72\x74\126\x61\162\151\x61\x6e\x74\x73\x41\x63\x74\x69\157\x6e\x41\x64\x64";
        $u4voliardef7gcuv1yw9cl9jr4uf273kfdm = $this->state()->get();
        if (!isset($u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])) {
            $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa] = ["\143\x6f\165\156\164" => 0, "\157\x66\x66\x73\x65\164" => 0, "\160\145\x72\143\145\x6e\x74" => 0, "\143\157\x6d\160\154\145\164\x65" => false, "\163\165\142\x43\157\x75\156\x74" => 0, "\163\165\x62\117\146\x66\x73\x65\164" => 0, "\156\x61\155\145" => ""];
            $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa])->save();
        }
        $qhlmd95l2je9bcrimqphd0x = $u4voliardef7gcuv1yw9cl9jr4uf273kfdm[$sfk1tjrxllk6hq3263jtwp4v180pa];
        try {
            $qhlmd95l2je9bcrimqphd0x["\x70\x72\157\x70\145\x72\164\x69\x65\163"] = $this->getPropertiesFromVk();
            $we8a2h9mrmbcj93gvqa = array_column($qhlmd95l2je9bcrimqphd0x["\160\162\x6f\x70\145\162\x74\x69\145\x73"], "\x76\141\x72\151\x61\x6e\164\163", "\151\x64");
            
            $nqa7p7lxiycqcvmmany28fou3euby1g27nw = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
            $ns4q4iz0iavo46sqmoacfhiejfcjqb05 = array_column($nqa7p7lxiycqcvmmany28fou3euby1g27nw, "\x50\122\117\120\x45\x52\124\131\137\x49\104");
            $nkwkxqm59jaqpkmj0b13fcmubllrc = $this->property()->getIblockPropertiesById($ns4q4iz0iavo46sqmoacfhiejfcjqb05);
            $pa8gnq39md2utwwwh73ulrf0uh3of0d7v63 = array_column($nkwkxqm59jaqpkmj0b13fcmubllrc, "\116\x41\115\x45", "\x49\x44");
            $qhlmd95l2je9bcrimqphd0x["\143\x6f\165\x6e\164"] = count($nqa7p7lxiycqcvmmany28fou3euby1g27nw);
            
            $vysys8pe = array_slice($nqa7p7lxiycqcvmmany28fou3euby1g27nw, $qhlmd95l2je9bcrimqphd0x["\x6f\x66\x66\163\x65\x74"]);
            
            while (count($vysys8pe)) {
                $this->manager()->checkTime();
                
                $s2csek72z0m = array_shift($vysys8pe);
                
                if (!isset($we8a2h9mrmbcj93gvqa[$s2csek72z0m["\x56\113\x5f\x50\x52\x4f\120\x45\x52\x54\x59\x5f\111\104"]])) {
                    $qhlmd95l2je9bcrimqphd0x["\157\146\x66\163\x65\164"]++;
                    continue;
                }
                
                $xcolgzembox7 = $this->property()->getVariantsByGroupIdPropertyId($this->exportItem()->getGroupId(), $s2csek72z0m["\x50\x52\x4f\x50\105\x52\x54\131\137\111\x44"]);
                $eonn7it = array_column($xcolgzembox7, "\x49\x44", "\x45\x4e\x55\x4d\x5f\x49\104");
                
                $s318tyu9uqz4z4t1j1hlij21t7fdk8fry = $we8a2h9mrmbcj93gvqa[$s2csek72z0m["\126\x4b\x5f\x50\x52\x4f\x50\x45\x52\x54\131\137\x49\104"]];
                $kmtsz1s53 = array_column($s318tyu9uqz4z4t1j1hlij21t7fdk8fry, "\x76\x61\154\165\145", "\166\x61\x6c\165\x65");
                
                $oayhrak8hdp7vkjuw2rgcieg110mwhd = $this->property()->getPropertyVariants($s2csek72z0m["\120\122\x4f\120\105\x52\x54\x59\137\111\x44"]);
                $qhlmd95l2je9bcrimqphd0x["\x73\165\142\x43\157\165\156\164"] = count($oayhrak8hdp7vkjuw2rgcieg110mwhd);
                $kho11hboo3ijs0smgyb3uknmzefdugqg8kl = array_slice($oayhrak8hdp7vkjuw2rgcieg110mwhd, $qhlmd95l2je9bcrimqphd0x["\163\165\x62\117\x66\146\x73\x65\x74"]);
                try {
                    
                    while (count($kho11hboo3ijs0smgyb3uknmzefdugqg8kl)) {
                        $this->manager()->checkTime();
                        $pagdy0owh7rmbgaomekvq = array_shift($kho11hboo3ijs0smgyb3uknmzefdugqg8kl);
                        if (isset($kmtsz1s53[$pagdy0owh7rmbgaomekvq["\111\104"]])) {
                            $qhlmd95l2je9bcrimqphd0x["\x73\165\142\x4f\x66\146\163\x65\x74"]++;
                            continue;
                        }
                        
                        if (isset($eonn7it[$pagdy0owh7rmbgaomekvq["\x49\104"]])) {
                            $this->property()->variantTable()->delete($eonn7it[$pagdy0owh7rmbgaomekvq["\x49\104"]]);
                        }
                        
                        $this->addVariantToVk($s2csek72z0m["\x50\x52\x4f\x50\105\x52\x54\131\x5f\111\104"], $s2csek72z0m["\x56\113\137\120\122\x4f\x50\105\122\124\x59\137\111\x44"], $pagdy0owh7rmbgaomekvq);
                        $qhlmd95l2je9bcrimqphd0x["\163\x75\142\117\x66\x66\163\145\x74"]++;
                    }
                    $qhlmd95l2je9bcrimqphd0x["\156\141\x6d\x65"] = $pa8gnq39md2utwwwh73ulrf0uh3of0d7v63[$s2csek72z0m["\120\122\x4f\x50\105\x52\124\x59\137\x49\104"]] ?? "\x5b" . $s2csek72z0m["\120\122\117\120\x45\122\x54\131\137\x49\104"] . "\x5d";
                    $qhlmd95l2je9bcrimqphd0x["\x6e\141\x6d\145"] .= "\40";
                    $qhlmd95l2je9bcrimqphd0x["\x6e\141\x6d\145"] .= $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\163\x75\142\x43\x6f\165\156\164"], $qhlmd95l2je9bcrimqphd0x["\x73\x75\x62\x4f\146\x66\x73\x65\x74"]) . "\45";
                    
                    if ($qhlmd95l2je9bcrimqphd0x["\x73\x75\142\x4f\146\146\163\145\x74"] >= $qhlmd95l2je9bcrimqphd0x["\x73\165\142\103\x6f\x75\x6e\164"]) {
                        $qhlmd95l2je9bcrimqphd0x["\x73\x75\x62\117\x66\x66\x73\145\164"] = 0;
                        $qhlmd95l2je9bcrimqphd0x["\x73\x75\142\103\157\165\x6e\x74"] = 0;
                        $qhlmd95l2je9bcrimqphd0x["\x6f\x66\x66\163\x65\164"]++;
                    }
                } catch (\VKapi\Market\Exception\ApiResponseException $m2bi85eiwkagik5akk1yga00kl0znv47) {
                    
                    if ($m2bi85eiwkagik5akk1yga00kl0znv47->is(\VKapi\Market\Api::ERROR_1419)) {
                        $qhlmd95l2je9bcrimqphd0x["\x73\165\x62\117\146\146\163\x65\x74"] = 0;
                        $qhlmd95l2je9bcrimqphd0x["\x73\165\x62\103\157\165\156\x74"] = 0;
                        $qhlmd95l2je9bcrimqphd0x["\x6f\146\146\163\x65\x74"]++;
                    }
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $ouxam818oykc60ox4qap) {
        }
        
        $qhlmd95l2je9bcrimqphd0x["\160\x65\x72\x63\145\x6e\x74"] = $this->state()->calcPercent($qhlmd95l2je9bcrimqphd0x["\x63\x6f\165\x6e\164"], $qhlmd95l2je9bcrimqphd0x["\157\x66\x66\x73\x65\164"]);
        if ($qhlmd95l2je9bcrimqphd0x["\x70\x65\162\x63\145\156\164"] >= 100) {
            $qhlmd95l2je9bcrimqphd0x["\x63\157\155\160\154\145\164\x65"] = true;
            unset($qhlmd95l2je9bcrimqphd0x["\x70\162\157\x70\145\x72\164\151\x65\163"]);
        }
        $this->state()->setField($sfk1tjrxllk6hq3263jtwp4v180pa, $qhlmd95l2je9bcrimqphd0x)->save();
        
        $u6qncmw5573cnhhcpk1ques1z->setDataArray(["\156\x61\155\x65" => $qhlmd95l2je9bcrimqphd0x["\x6e\141\x6d\x65"], "\143\x6f\x6d\x70\x6c\145\164\x65" => $qhlmd95l2je9bcrimqphd0x["\143\x6f\155\x70\154\145\x74\x65"], "\x70\x65\162\143\x65\156\x74" => $qhlmd95l2je9bcrimqphd0x["\x70\x65\162\x63\145\x6e\164"]]);
        return $u6qncmw5573cnhhcpk1ques1z;
    }
    
    public function addVariantToVk($eecijmwfukempun82o, $bejczno, $ts1nfj68n1l49m53ix5w203nppltzqg27m0)
    {
        
        $r8m4m = ["\x67\162\x6f\165\160\x5f\x69\x64" => $this->exportItem()->getGroupId(), "\x70\162\x6f\160\145\162\x74\171\x5f\151\x64" => $bejczno, "\x74\x69\x74\x6c\x65" => $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\x4e\x41\115\x45"], "\166\x61\x6c\165\x65" => $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\111\x44"]];
        try {
            $u6qncmw5573cnhhcpk1ques1z = $this->exportItem()->connection()->method("\155\141\x72\x6b\145\164\x2e\x61\144\144\120\162\157\x70\145\x72\x74\x79\x56\141\162\x69\x61\x6e\x74", $r8m4m);
            $r6rpo215zv9nukk08n54jq9wsh1a = $u6qncmw5573cnhhcpk1ques1z->getData("\x72\x65\163\160\157\x6e\x73\x65");
            if ((int) $r6rpo215zv9nukk08n54jq9wsh1a["\166\141\x72\x69\141\156\164\137\x69\144"]) {
                
                $y3m18 = $this->property()->variantTable()->add(["\107\x52\117\x55\120\x5f\111\x44" => $this->exportItem()->getGroupId(), "\x50\122\117\x50\x45\x52\x54\x59\137\111\x44" => $eecijmwfukempun82o, "\x45\116\125\x4d\x5f\111\x44" => $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\x49\x44"], "\126\113\x5f\x56\x41\122\111\x41\116\124\x5f\x49\104" => (int) $r6rpo215zv9nukk08n54jq9wsh1a["\x76\141\x72\x69\141\x6e\164\x5f\151\144"]]);
                $this->log()->ok($this->getMessage("\x41\x44\x44\x5f\x56\101\122\x49\x41\116\x54\x5f\124\117\137\126\x4b\56\117\x4b", ["\x23\x50\x52\117\x50\x45\122\124\x59\137\x49\x44\x23" => $eecijmwfukempun82o, "\43\x56\x4b\137\x50\122\117\x50\105\122\124\131\x5f\x49\x44\43" => $bejczno, "\43\126\x41\122\x49\x41\x4e\x54\137\111\x44\43" => $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\111\x44"] . "\x20" . $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\x4e\x41\x4d\x45"]]));
            }
        } catch (\VKapi\Market\Exception\ApiResponseException $m2bi85eiwkagik5akk1yga00kl0znv47) {
            if ($m2bi85eiwkagik5akk1yga00kl0znv47->is(\VKapi\Market\Api::ERROR_1419)) {
                $this->log()->error($this->getMessage("\101\x44\x44\137\x56\101\x52\x49\x41\x4e\124\x5f\x54\x4f\x5f\x56\113\x2e\105\x52\x52\117\x52\x5f\x4c\x49\115\x49\124", ["\x23\115\123\107\x23" => $m2bi85eiwkagik5akk1yga00kl0znv47->getMessage(), "\43\126\101\122\111\x41\x4e\124\137\x49\104\x23" => $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\x49\x44"] . "\x20" . $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\116\101\x4d\x45"], "\43\x50\122\x4f\120\105\x52\124\131\x5f\x49\104\x23" => $eecijmwfukempun82o, "\43\x56\x4b\x5f\120\x52\117\x50\105\122\124\131\x5f\111\x44\x23" => $bejczno]));
                throw $m2bi85eiwkagik5akk1yga00kl0znv47;
            }
            $this->log()->error($this->getMessage("\101\104\x44\x5f\x56\101\122\111\101\x4e\x54\x5f\124\117\x5f\x56\x4b\x2e\x45\x52\x52\117\x52", ["\43\115\123\x47\43" => $m2bi85eiwkagik5akk1yga00kl0znv47->getMessage(), "\x23\126\x41\x52\x49\x41\x4e\124\x5f\x49\x44\x23" => $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\111\104"] . "\40" . $ts1nfj68n1l49m53ix5w203nppltzqg27m0["\x4e\x41\x4d\105"], "\43\x50\122\117\x50\x45\x52\124\131\x5f\x49\104\43" => $eecijmwfukempun82o, "\43\x56\113\137\120\122\117\120\105\122\x54\x59\x5f\111\104\x23" => $bejczno]));
        }
        return true;
    }
    
    public function getNeedExistsPropertyId()
    {
        $i1iog5m03cqpoyi = [];
        
        $k7eqxvix60 = new \VKapi\Market\Export\Item();
        $d8fncl1p4rlx0 = \VKapi\Market\ExportTable::getList(["\146\151\x6c\164\x65\162" => ["\107\x52\x4f\x55\x50\x5f\111\104" => $this->exportItem()->getGroupId(), "\101\x43\x54\x49\x56\105" => true]]);
        while ($vuo6y2lywu9vm64yyu9c75iez3114r7xi7 = $d8fncl1p4rlx0->fetch()) {
            $k7eqxvix60->setData($vuo6y2lywu9vm64yyu9c75iez3114r7xi7);
            if ($k7eqxvix60->isEnabledExtendedGoods()) {
                $i1iog5m03cqpoyi = array_merge($i1iog5m03cqpoyi, $k7eqxvix60->getPropertyIds());
            }
        }
        unset($k7eqxvix60);
        $i1iog5m03cqpoyi = array_values(array_unique($i1iog5m03cqpoyi));
        return $i1iog5m03cqpoyi;
    }
    
    public function getIdNotExists()
    {
        
        $nkwkxqm59jaqpkmj0b13fcmubllrc = $this->property()->getListByGroupId($this->exportItem()->getGroupId());
        $qcaaoocsd3o0gfvbs0g2512a0 = array_column($nkwkxqm59jaqpkmj0b13fcmubllrc, "\x50\x52\117\x50\105\x52\x54\131\137\x49\x44");
        
        $gy67hgm9r952irh6a223c9lx57ei = array_diff($this->exportItem()->getPropertyIds(), $qcaaoocsd3o0gfvbs0g2512a0);
        return $gy67hgm9r952irh6a223c9lx57ei;
    }
}
?>