<?php

namespace VKapi\Market\Sale\Order\Import;

use Bitrix\Main\Localization\Loc;
use VKapi\Market\Connect;
use VKapi\Market\Manager;
use VKapi\Market\Exception\BaseException;
use VKapi\Market\Exception\TimeoutException;
use VKapi\Market\Exception\ApiResponseException;
use VKapi\Market\Exception\ORMException;
use VKapi\Market\Result;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Item
{
    protected $syncId;
    public function __construct($fund3qkhswqnq)
    {
        if (!$this->manager()->isInstalledSaleModule()) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x4d\117\x44\125\114\x45\137\x53\x41\x4c\x45\x5f\x49\x53\137\x4e\x4f\x54\x5f\x49\116\123\x54\x41\114\x4c\x45\104"), "\x45\122\122\117\122\137\115\117\x44\x55\114\x45\137\123\101\x4c\105\137\116\x4f\x54\x5f\106\x4f\x55\116\104");
        }
        $this->syncId = (int) $fund3qkhswqnq;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function syncItem()
    {
        if (!isset($this->oSyncItem)) {
            $this->oSyncItem = new \VKapi\Market\Sale\Order\Sync\Item($this->syncId);
        }
        return $this->oSyncItem;
    }
    
    public function state()
    {
        if (!isset($this->oState)) {
            $this->oState = new \VKapi\Market\State("\x73\171\156\143\x5f" . $this->syncItem()->getId(), "\x6f\x72\144\145\162\137\x69\155\x70\157\162\x74");
        }
        return $this->oState;
    }
    
    public function log()
    {
        if (!isset($this->oLog)) {
            $this->oLog = new \VKapi\Market\Export\Log($this->manager()->getLogLevel());
            $this->oLog->setExportId(0);
        }
        return $this->oLog;
    }
    
    public function connection()
    {
        if (is_null($this->oConnection)) {
            $this->oConnection = new \VKapi\Market\Connect();
            $jc7ai89g = $this->oConnection->initAccountId($this->syncItem()->getAccountId());
            if (!$jc7ai89g->isSuccess()) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\122\117\122\137\111\116\111\x54\x5f\x43\x4f\x4e\116\x45\x43\x54\x49\x4f\116", ["\x23\115\123\107\43" => $jc7ai89g->getFirstErrorMessage(), "\x23\103\x4f\104\105\x23" => $jc7ai89g->getFirstErrorCode()]), "\x45\122\x52\117\122\137\x49\x4e\x49\x54\137\x43\117\116\116\x45\103\124\111\117\x4e");
            }
        }
        return $this->oConnection;
    }
    
    public function getMessage($n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp = null)
    {
        return $this->manager()->getMessage("\x4c\111\x42\56\123\x41\x4c\x45\56\117\122\x44\x45\122\x2e\x49\x4d\120\117\122\124\x2e\x49\x54\105\115\x2e" . $n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp);
    }
    
    public function checkApiAccess()
    {
        $jc7ai89g = new \VKapi\Market\Result();
        try {
            $tl45fiskeejuzkkbsbyslvngkdtk = $this->connection()->method("\155\x61\x72\x6b\x65\x74\56\147\145\164\107\162\157\x75\x70\x4f\x72\144\x65\162\x73", ["\141\x63\x63\145\x73\163\137\x74\x6f\153\x65\x6e" => $this->syncItem()->getGroupAccessToken(), "\147\162\157\165\x70\x5f\151\x64" => $this->syncItem()->getGroupId(), "\157\x66\x66\x73\x65\164" => 0, "\x63\157\165\x6e\164" => 1, "\145\170\x74\145\156\144\145\144" => 1]);
        } catch (\VKapi\Market\Exception\BaseException $lgm0v) {
            $jc7ai89g->addError($lgm0v->getMessage(), $lgm0v->getCustomCode(), $lgm0v->getCustomData());
        }
        return $jc7ai89g;
    }
    
    public function run()
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $r05t0ryqx0wgrz7pb4lh9c = $this->state()->get();
        
        if (!empty($r05t0ryqx0wgrz7pb4lh9c) && $r05t0ryqx0wgrz7pb4lh9c["\x72\x75\156"] && $r05t0ryqx0wgrz7pb4lh9c["\164\151\155\145\123\x74\141\x72\164"] > time() - 60 * 3) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x52\x55\x4e\56\127\x41\111\124\x5f\106\x49\x4e\111\x53\x48"), "\127\x41\x49\124\x5f\x46\111\x4e\111\123\x48");
        }
        
        if (empty($r05t0ryqx0wgrz7pb4lh9c) || !isset($r05t0ryqx0wgrz7pb4lh9c["\163\x74\145\160"]) || $r05t0ryqx0wgrz7pb4lh9c["\x63\x6f\155\x70\x6c\x65\x74\145"]) {
            $this->state()->set(["\x63\157\155\x70\154\145\x74\145" => false, "\160\x65\x72\x63\145\x6e\x74" => 0, "\163\164\x65\160" => 1, "\163\164\x65\x70\163" => [1 => ["\x6e\x61\x6d\145" => $this->getMessage("\122\x55\x4e\56\123\124\105\x50\x31"), "\x70\145\162\143\x65\x6e\x74" => 0, "\x65\162\162\157\x72" => false], 2 => ["\x6e\141\155\145" => $this->getMessage("\x52\x55\116\56\123\x54\x45\120\x32"), "\160\x65\x72\143\145\x6e\x74" => 0, "\x65\x72\x72\157\x72" => false]]]);
            $r05t0ryqx0wgrz7pb4lh9c = $this->state()->get();
            $this->log()->notice($this->getMessage("\122\x55\116\56\x53\124\101\122\x54"));
        }
        
        $this->state()->set(["\162\x75\156" => true, "\x74\x69\155\x65\x53\x74\141\x72\164" => time()])->save();
        
        try {
            switch ($r05t0ryqx0wgrz7pb4lh9c["\163\164\x65\x70"]) {
                case 1:
                    $jc7ai89g = $this->checkApiAccess();
                    if ($jc7ai89g->isSuccess()) {
                        $r05t0ryqx0wgrz7pb4lh9c["\163\x74\x65\160"]++;
                        $r05t0ryqx0wgrz7pb4lh9c["\163\x74\x65\x70\x73"][1]["\160\145\162\143\x65\x6e\164"] = 100;
                        $this->log()->notice($this->getMessage("\x52\x55\116\56\x53\124\x45\120\x31\x2e\117\113", ["\43\123\x54\x45\120\43" => 1, "\x23\x53\x54\x45\120\137\x4e\x41\x4d\x45\x23" => $this->getMessage("\x52\x55\x4e\56\123\124\105\x50\x31")]));
                    } else {
                        $r05t0ryqx0wgrz7pb4lh9c["\x73\164\x65\160\x73"][1]["\145\x72\x72\157\162"] = true;
                        $this->log()->error($jc7ai89g->getFirstErrorMessage(), $jc7ai89g->getFirstErrorMore());
                        return $jc7ai89g;
                    }
                    break;
                case 2:
                    $fw3qnyvcnjmvwue8jl2l289jfg1d = $this->runOrdersImport();
                    $r05t0ryqx0wgrz7pb4lh9c["\163\x74\x65\x70\x73"][2]["\x70\145\162\143\145\156\x74"] = $fw3qnyvcnjmvwue8jl2l289jfg1d->getData("\160\x65\162\143\x65\x6e\x74");
                    $r05t0ryqx0wgrz7pb4lh9c["\163\x74\x65\x70\163"][2]["\x6e\x61\155\x65"] = $fw3qnyvcnjmvwue8jl2l289jfg1d->getData("\156\141\155\145");
                    
                    if ($fw3qnyvcnjmvwue8jl2l289jfg1d->getData("\x63\x6f\155\x70\x6c\145\164\145")) {
                        $r05t0ryqx0wgrz7pb4lh9c["\163\164\145\160"]++;
                        $this->log()->notice($this->getMessage("\122\125\x4e\x2e\x53\x54\105\x50\x32\x2e\117\x4b", ["\43\123\x54\x45\x50\43" => 2, "\43\123\x54\x45\120\x5f\x4e\x41\x4d\105\43" => $this->getMessage("\122\x55\x4e\x2e\123\x54\105\x50\62")]));
                    } else {
                        $this->log()->notice($this->getMessage("\122\125\x4e\x2e\x53\x54\105\x50\62\x2e\x50\x52\x4f\103\x45\123\x53", ["\43\x53\124\x45\120\43" => 2, "\43\123\x54\x45\x50\137\x4e\x41\x4d\x45\43" => $r05t0ryqx0wgrz7pb4lh9c["\x73\x74\145\x70\163"][2]["\x6e\x61\x6d\x65"], "\43\x50\x45\122\103\105\116\124\x23" => $r05t0ryqx0wgrz7pb4lh9c["\163\x74\x65\160\x73"][2]["\160\145\162\x63\145\156\164"]]));
                    }
                    break;
            }
        } catch (\VKapi\Market\Exception\BaseException $lgm0v) {
            $this->log()->error($lgm0v->getMessage(), $lgm0v->getCustomData());
        }
        
        $r05t0ryqx0wgrz7pb4lh9c["\160\x65\x72\143\x65\x6e\x74"] = $this->state()->calcPercentByData($r05t0ryqx0wgrz7pb4lh9c);
        if ($r05t0ryqx0wgrz7pb4lh9c["\x70\145\x72\143\145\156\164"] == 100) {
            $r05t0ryqx0wgrz7pb4lh9c["\x63\157\155\x70\x6c\145\x74\145"] = true;
            $this->log()->notice($this->getMessage("\x52\x55\x4e\x2e\123\124\x4f\x50"));
        }
        if (\Bitrix\Main\Loader::includeSharewareModule("\166\153\x61\x70\x69\56\155\x61\162\x6b\145\164") == constant("\x4d" . "\117" . "\x44\x55\x4c\105\x5f\104\105\115\117\137\x45\130" . "\x50\111" . "" . "" . "\x52\105" . "" . "" . "" . "" . "" . "" . "" . "\104")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\x50\x49\x2e\115\x41" . "\122\x4b\x45\x54\x2e\x44\105\x4d\117\x5f\x45\130\120\111\122\105" . "\x44"), "\x42\x58\115\x41\113\105\x52\137\104\x45\x4d\x4f\x5f\105\130\x50\x49" . "\x52\105" . "\x44");
        }
        
        $this->state()->set(["\x72\x75\156" => false, "\x73\164\x65\160" => $r05t0ryqx0wgrz7pb4lh9c["\163\164\x65\x70"], "\x73\164\x65\x70\x73" => $r05t0ryqx0wgrz7pb4lh9c["\x73\164\145\160\x73"], "\x63\157\x6d\x70\154\145\164\x65" => $r05t0ryqx0wgrz7pb4lh9c["\x63\x6f\155\160\154\x65\x74\145"], "\x70\145\x72\143\145\x6e\164" => $r05t0ryqx0wgrz7pb4lh9c["\160\145\x72\143\x65\x6e\x74"]]);
        $jc7ai89g->setDataArray($this->state()->get());
        if ($jc7ai89g->isSuccess()) {
            $this->state()->save();
        } else {
            $this->state()->clean();
        }
        return $jc7ai89g;
    }
    
    public function runOrdersImport()
    {
        $jc7ai89g = new \VKapi\Market\Result();
        $jg1c8mhty6136wrt5o2sevk = "\162\x75\x6e\117\x72\144\x65\162\x73\111\x6d\160\157\x72\x74";
        $r05t0ryqx0wgrz7pb4lh9c = $this->state()->get();
        if (!isset($r05t0ryqx0wgrz7pb4lh9c[$jg1c8mhty6136wrt5o2sevk]) || $r05t0ryqx0wgrz7pb4lh9c[$jg1c8mhty6136wrt5o2sevk]["\143\157\x6d\160\x6c\145\164\145"]) {
            $r05t0ryqx0wgrz7pb4lh9c[$jg1c8mhty6136wrt5o2sevk] = ["\x6e\x61\155\145" => $this->getMessage("\x52\125\x4e\137\x4f\122\104\105\x52\x5f\x49\115\120\x4f\122\124"), "\143\157\x6d\160\154\x65\x74\145" => false, "\143\x6f\x75\156\164" => 0, "\x6f\146\x66\x73\x65\x74" => 0, "\x70\145\x72\x63\x65\156\164" => 0];
            $this->state()->setField($jg1c8mhty6136wrt5o2sevk, $r05t0ryqx0wgrz7pb4lh9c[$jg1c8mhty6136wrt5o2sevk])->save();
        }
        $fs78wgp2r9cn6i = $r05t0ryqx0wgrz7pb4lh9c[$jg1c8mhty6136wrt5o2sevk];
        try {
            while (true) {
                
                $this->manager()->checkTime();
                $xxep2p13 = ["\141\143\143\145\x73\163\x5f\164\x6f\153\x65\x6e" => $this->syncItem()->getGroupAccessToken(), "\x67\162\x6f\165\x70\137\x69\144" => $this->syncItem()->getGroupId(), "\x6f\x66\146\x73\145\164" => $fs78wgp2r9cn6i["\x6f\x66\x66\163\x65\164"], "\143\x6f\x75\156\164" => 25, "\x65\170\x74\x65\x6e\x64\x65\144" => 1];
                $ejszvrh5yqwsjgfetju = $this->connection()->method("\x6d\x61\162\153\x65\164\56\x67\x65\164\x47\162\x6f\165\x70\x4f\x72\144\145\162\x73", $xxep2p13);
                $erblcqkbs = $ejszvrh5yqwsjgfetju->getData("\162\145\x73\160\x6f\x6e\x73\x65");
                $fs78wgp2r9cn6i["\x63\157\165\x6e\x74"] = $erblcqkbs["\143\157\x75\156\x74"];
                if (!count($erblcqkbs["\151\164\145\x6d\163"])) {
                    break;
                }
                \Bitrix\Main\Type\Collection::sortByColumn($erblcqkbs["\x69\164\145\155\x73"], ["\144\x61\x74\145" => SORT_ASC]);
                while ($rg9jim0do2ex6std1k8vdy2fb0h839fy6c1 = array_shift($erblcqkbs["\151\164\145\155\x73"])) {
                    $this->manager()->checkTime();
                    $this->log()->notice($this->getMessage("\122\125\116\x5f\117\122\104\105\122\137\x49\x4d\120\117\x52\124\x5f\111\x54\x45\x4d", ["\x23\126\x4b\117\x52\x44\x45\122\x5f\x49\x44\43" => $rg9jim0do2ex6std1k8vdy2fb0h839fy6c1["\144\151\x73\160\x6c\x61\x79\137\x6f\162\144\145\x72\137\151\x64"], "\x23\x47\122\x4f\x55\120\137\111\x44\x23" => $rg9jim0do2ex6std1k8vdy2fb0h839fy6c1["\147\162\x6f\165\160\x5f\151\x64"]]));
                    $this->runOrdersImportActionUpdateItem($rg9jim0do2ex6std1k8vdy2fb0h839fy6c1);
                    $fs78wgp2r9cn6i["\x6f\x66\146\163\x65\x74"]++;
                }
                if ($fs78wgp2r9cn6i["\157\146\146\163\145\164"] >= $fs78wgp2r9cn6i["\x63\157\165\x6e\164"]) {
                    break;
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $lgm0v) {
        }
        
        $fs78wgp2r9cn6i["\x70\145\x72\143\x65\x6e\x74"] = $this->state()->calcPercent($fs78wgp2r9cn6i["\x63\157\x75\x6e\x74"], $fs78wgp2r9cn6i["\x6f\x66\146\x73\145\x74"]);
        if ($fs78wgp2r9cn6i["\x70\145\x72\143\145\x6e\164"] >= 100) {
            $fs78wgp2r9cn6i["\143\157\155\160\154\x65\x74\x65"] = true;
        }
        $this->state()->setField($jg1c8mhty6136wrt5o2sevk, $fs78wgp2r9cn6i)->save();
        
        $jc7ai89g->setDataArray(["\x6e\x61\x6d\145" => $this->getMessage("\122\x55\116\137\x4f\122\104\x45\122\137\111\115\120\x4f\x52\x54\137\x50\122\117\103\x45\123\x53", ["\43\117\106\x46\123\x45\124\x23" => $fs78wgp2r9cn6i["\157\146\x66\163\x65\164"], "\43\x43\x4f\x55\x4e\124\43" => $fs78wgp2r9cn6i["\x63\157\165\156\x74"]]), "\x63\157\x6d\x70\154\x65\x74\x65" => $fs78wgp2r9cn6i["\143\x6f\x6d\160\154\x65\x74\145"], "\x70\x65\162\x63\x65\x6e\164" => $fs78wgp2r9cn6i["\160\x65\162\143\145\156\164"]]);
        return $jc7ai89g;
    }
    
    public function runOrdersImportActionUpdateItem($avv26eg5ep97u7un7ok59rq6888qs6q)
    {
        try {
            
            $agoy9h = new \VKapi\Market\Sale\Order\Item($this->syncItem());
            
            if ($pvs9vbghko5f8q1djxgc89k8wn = $this->loadOrderByItem($avv26eg5ep97u7un7ok59rq6888qs6q)) {
                $agoy9h->setVkOrder($pvs9vbghko5f8q1djxgc89k8wn);
            } else {
                $agoy9h->setVkOrder($avv26eg5ep97u7un7ok59rq6888qs6q);
            }
            if (!$agoy9h->isExistOrder()) {
                $v5zb9qgv07fmojknqgk = $this->loadVkOrderItems($avv26eg5ep97u7un7ok59rq6888qs6q);
                $agoy9h->setVkOrderItems($v5zb9qgv07fmojknqgk);
                $u2aud6kkdjjrgc0vhta1hw5y7s = $agoy9h->createOrder();
                $this->log()->ok($this->getMessage("\122\125\x4e\x5f\x4f\122\x44\105\x52\x5f\111\x4d\120\x4f\122\124\x5f\111\x54\x45\x4d\137\x43\x52\x45\x41\124\x45\104\137\x4f\x52\104\105\122", ["\x23\x56\x4b\117\x52\104\105\122\x5f\111\x44\43" => $avv26eg5ep97u7un7ok59rq6888qs6q["\x64\x69\x73\160\154\141\x79\137\157\x72\x64\145\162\x5f\151\x64"], "\43\x47\122\117\125\120\137\x49\x44\43" => $avv26eg5ep97u7un7ok59rq6888qs6q["\147\x72\x6f\x75\160\137\151\x64"], "\x23\117\122\x44\x45\122\x5f\x49\104\x23" => intval($u2aud6kkdjjrgc0vhta1hw5y7s)]));
            } else {
                $jsv2rhksjsqfh92bjdmnij = $agoy9h->updateOrder();
                $this->log()->ok($this->getMessage("\x52\125\x4e\x5f\117\x52\x44\105\122\137\x49\x4d\120\x4f\x52\x54\137\111\x54\105\115\x5f\x55\x50\104\101\x54\105\104\x5f\117\x52\104\105\x52", ["\43\126\113\x4f\x52\104\105\122\x5f\111\x44\43" => $avv26eg5ep97u7un7ok59rq6888qs6q["\144\x69\163\160\x6c\x61\x79\137\157\x72\144\145\x72\x5f\151\144"], "\x23\x47\122\117\125\x50\x5f\x49\104\x23" => $avv26eg5ep97u7un7ok59rq6888qs6q["\147\x72\x6f\x75\160\x5f\151\144"], "\x23\x4f\122\104\105\122\x5f\111\104\43" => intval($jsv2rhksjsqfh92bjdmnij)]));
            }
        } catch (\VKapi\Market\Exception\BaseException $lgm0v) {
            if ($lgm0v instanceof \VKapi\Market\Exception\ORMException) {
                $this->log()->error($lgm0v->getMessage() . "\40\174\40" . $lgm0v->getFile() . "\x3a" . $lgm0v->getLine(), $lgm0v->getCustomData());
                return false;
            }
            $this->log()->error($lgm0v->getMessage(), $lgm0v->getCustomData());
            return false;
        }
        return true;
    }
    
    public function loadVkOrderItems($avv26eg5ep97u7un7ok59rq6888qs6q)
    {
        $w06qefa881q4fa = [];
        $xxep2p13 = ["\x61\x63\x63\x65\x73\x73\x5f\164\157\x6b\x65\x6e" => $this->syncItem()->getGroupAccessToken(), "\165\x73\x65\x72\x5f\x69\x64" => $avv26eg5ep97u7un7ok59rq6888qs6q["\165\x73\145\x72\x5f\x69\x64"], "\157\x72\x64\145\x72\137\151\x64" => $avv26eg5ep97u7un7ok59rq6888qs6q["\x69\x64"], "\x6f\x66\x66\163\x65\x74" => 0, "\143\x6f\x75\x6e\x74" => 100];
        while (true) {
            $jc7ai89g = $this->connection()->method("\155\x61\162\x6b\145\164\56\147\145\x74\x4f\162\144\145\x72\x49\x74\145\x6d\x73", $xxep2p13);
            $erblcqkbs = $jc7ai89g->getData("\162\145\163\x70\x6f\156\163\145");
            $fs78wgp2r9cn6i["\143\157\x75\156\x74"] = $erblcqkbs["\143\x6f\x75\x6e\x74"];
            if (!count($erblcqkbs["\x69\164\x65\x6d\x73"])) {
                break;
            }
            $w06qefa881q4fa = array_merge($w06qefa881q4fa, $erblcqkbs["\x69\x74\145\155\163"]);
            $xxep2p13["\x6f\146\146\163\145\164"] += count($erblcqkbs["\x69\164\145\x6d\163"]);
            if ($xxep2p13["\x6f\146\x66\163\145\164"] >= $erblcqkbs["\143\x6f\165\156\x74"]) {
                break;
            }
        }
        return $w06qefa881q4fa;
    }
    
    public function loadOrderByItem($avv26eg5ep97u7un7ok59rq6888qs6q)
    {
        $xxep2p13 = ["\141\143\143\x65\163\163\x5f\x74\157\153\145\x6e" => $this->syncItem()->getGroupAccessToken(), "\x6f\x72\144\x65\162\137\151\144" => $avv26eg5ep97u7un7ok59rq6888qs6q["\x69\x64"], "\x75\163\x65\162\137\x69\144" => $avv26eg5ep97u7un7ok59rq6888qs6q["\165\163\x65\162\137\151\x64"], "\x65\170\x74\x65\156\x64\145\x64" => 1];
        $jc7ai89g = $this->connection()->method("\155\x61\162\x6b\145\x74\x2e\x67\145\164\x4f\x72\x64\145\162\102\x79\x49\x64", $xxep2p13);
        $erblcqkbs = $jc7ai89g->getData("\x72\x65\x73\x70\157\x6e\163\x65");
        if (isset($erblcqkbs["\x6f\x72\144\145\162"])) {
            return $erblcqkbs["\157\162\144\x65\162"];
        }
        return null;
    }
    public function sendOrderChangesToVK(\Bitrix\Sale\OrderBase $dob09zs7om7zpdgbmn9z, $k4cp1exfyc68vkkxzrktrnumxi5z9 = null)
    {
        try {
            
            if (is_null($k4cp1exfyc68vkkxzrktrnumxi5z9)) {
                $k4cp1exfyc68vkkxzrktrnumxi5z9 = \VKapi\Market\Sale\Order\Sync\RefTable::getList(["\146\x69\x6c\x74\145\x72" => ["\x4f\x52\x44\105\122\137\111\x44" => intval($dob09zs7om7zpdgbmn9z->getId())], "\x6c\x69\x6d\x69\x74" => 1])->fetch();
            }
            $fdvewfhxzb5gde = ["\x61\143\143\x65\x73\x73\x5f\164\x6f\153\x65\x6e" => $this->syncItem()->getGroupAccessToken(), "\165\x73\145\x72\x5f\x69\144" => $k4cp1exfyc68vkkxzrktrnumxi5z9["\x56\113\125\123\105\x52\137\111\x44"], "\157\x72\x64\x65\x72\137\x69\144" => $k4cp1exfyc68vkkxzrktrnumxi5z9["\126\x4b\x4f\x52\104\105\122\x5f\x49\104"], "\155\x65\x72\143\150\x61\156\164\x5f\143\x6f\x6d\x6d\x65\x6e\164" => $dob09zs7om7zpdgbmn9z->getField("\103\117\x4d\115\105\x4e\124\123")];
            $a0mteesg0z9jzaxoxtavchgkow = $this->syncItem()->getVkStatusByStatusId($dob09zs7om7zpdgbmn9z->getField("\x53\124\101\124\x55\123\x5f\111\104"));
            if (!empty($a0mteesg0z9jzaxoxtavchgkow)) {
                $fdvewfhxzb5gde["\163\164\141\164\x75\x73"] = $a0mteesg0z9jzaxoxtavchgkow;
            }
            
            $buoz62 = $dob09zs7om7zpdgbmn9z->getShipmentCollection();
            foreach ($buoz62 as $mffug449wratnj2ooqe5isc2roz29z0fdj) {
                if ($mffug449wratnj2ooqe5isc2roz29z0fdj->isSystem()) {
                    continue;
                }
                $s034d4edut8g659j7 = $this->syncItem()->getVkStatusByStatusId($mffug449wratnj2ooqe5isc2roz29z0fdj->getField("\123\x54\101\x54\x55\123\137\111\x44"));
                if (!empty($s034d4edut8g659j7) && $s034d4edut8g659j7 > $a0mteesg0z9jzaxoxtavchgkow) {
                    $fdvewfhxzb5gde["\x73\164\x61\164\x75\x73"] = $s034d4edut8g659j7;
                }
                break;
            }
            $rcpisqy116037syeu8gzqxul836kt = $dob09zs7om7zpdgbmn9z->getField("\124\122\x41\103\x4b\111\116\x47\137\116\125\x4d\102\105\122");
            if ($rcpisqy116037syeu8gzqxul836kt) {
                $fdvewfhxzb5gde["\x74\x72\x61\x63\x6b\x5f\156\165\155\x62\145\162"] = $rcpisqy116037syeu8gzqxul836kt;
            }
            if ($dob09zs7om7zpdgbmn9z->getDeliveryPrice() > 0) {
                $fdvewfhxzb5gde["\144\x65\154\x69\166\x65\x72\171\137\160\162\151\143\145"] = intval(100 * $dob09zs7om7zpdgbmn9z->getDeliveryPrice());
            } else {
                $fdvewfhxzb5gde["\144\x65\154\151\x76\145\x72\171\x5f\x70\162\151\143\145"] = 0;
            }
            
            unset($fdvewfhxzb5gde["\144\x65\154\x69\x76\x65\x72\171\x5f\160\x72\x69\x63\x65"]);
            
            $ujoqbm4qmpihjqzcop6zaa38c39y = $dob09zs7om7zpdgbmn9z->getPaymentCollection();
            $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd = $ujoqbm4qmpihjqzcop6zaa38c39y->getItemByIndex(0);
            if (!empty($ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd)) {
                if ($ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->isReturn()) {
                    $fdvewfhxzb5gde["\160\x61\171\x6d\x65\x6e\164\137\163\x74\x61\x74\x75\x73"] = \VKapi\Market\Sale\Order\Item::PAYMENT_STATUS_RETURNED;
                } elseif ($ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->isPaid()) {
                    $fdvewfhxzb5gde["\160\141\x79\x6d\145\156\x74\137\x73\x74\x61\164\x75\x73"] = \VKapi\Market\Sale\Order\Item::PAYMENT_STATUS_PAID;
                } else {
                    $fdvewfhxzb5gde["\x70\141\171\x6d\x65\x6e\x74\137\163\164\141\164\165\x73"] = \VKapi\Market\Sale\Order\Item::PAYMENT_STATUS_NOT_PAID;
                }
                if ($ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->isReturn() || $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->isPaid()) {
                    $ctwv22jpbot60gree9yoi7oqe0bnrqo3 = \Bitrix\Sale\Cashbox\CheckManager::getLastPrintableCheckInfo($ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd);
                    if (!empty($ctwv22jpbot60gree9yoi7oqe0bnrqo3["\x4c\111\x4e\113"])) {
                        $fdvewfhxzb5gde["\162\145\143\145\x69\160\164\137\x6c\x69\x6e\x6b"] = $ctwv22jpbot60gree9yoi7oqe0bnrqo3["\x4c\111\116\113"];
                    }
                }
            } else {
                $fdvewfhxzb5gde["\160\x61\x79\155\x65\156\x74\137\163\164\x61\x74\x75\x73"] = \VKapi\Market\Sale\Order\Item::PAYMENT_STATUS_NOT_PAID;
            }
            
            $kdch1ywb23v8zk3n60cebr = $dob09zs7om7zpdgbmn9z->getPropertyCollection();
            if ($this->syncItem()->getCommentForUserPropertyId()) {
                $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getCommentForUserPropertyId());
                if ($a75gm0d1773kr11oilqj3um7hkv) {
                    $fdvewfhxzb5gde["\x63\157\x6d\155\145\x6e\164\137\146\x6f\162\x5f\165\x73\145\x72"] = $a75gm0d1773kr11oilqj3um7hkv->getValue();
                }
            }
            
            unset($fdvewfhxzb5gde["\143\157\x6d\x6d\x65\x6e\x74\137\146\157\x72\x5f\165\163\x65\162"]);
            if ($this->syncItem()->getWidthPropertyId()) {
                $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getWidthPropertyId());
                if ($a75gm0d1773kr11oilqj3um7hkv) {
                    $fdvewfhxzb5gde["\167\x69\144\164\x68"] = $a75gm0d1773kr11oilqj3um7hkv->getValue();
                }
            }
            if ($this->syncItem()->getHeightPropertyId()) {
                $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getHeightPropertyId());
                if ($a75gm0d1773kr11oilqj3um7hkv) {
                    $fdvewfhxzb5gde["\x68\145\x69\147\x68\164"] = $a75gm0d1773kr11oilqj3um7hkv->getValue();
                }
            }
            if ($this->syncItem()->getLengthPropertyId()) {
                $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getLengthPropertyId());
                if ($a75gm0d1773kr11oilqj3um7hkv) {
                    $fdvewfhxzb5gde["\154\145\156\x67\x74\x68"] = $a75gm0d1773kr11oilqj3um7hkv->getValue();
                }
            }
            if ($this->syncItem()->getWeightPropertyId()) {
                $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getWeightPropertyId());
                if ($a75gm0d1773kr11oilqj3um7hkv) {
                    $fdvewfhxzb5gde["\x77\x65\151\147\150\164"] = $a75gm0d1773kr11oilqj3um7hkv->getValue();
                }
            }
            $jc7ai89g = $this->connection()->method("\x6d\x61\x72\x6b\145\x74\x2e\x65\144\151\164\x4f\x72\144\x65\162", $fdvewfhxzb5gde);
            $erblcqkbs = $jc7ai89g->getData("\162\x65\x73\160\x6f\x6e\163\x65");
            if ($erblcqkbs) {
                $this->log()->ok($this->getMessage("\123\x45\116\x44\137\x4f\122\104\105\122\137\x43\110\x41\116\107\x45\123\137\x54\x4f\137\126\x4b\x5f\x4f\x4b", ["\43\x56\x4b\x4f\x52\x44\x45\x52\x5f\111\x44\43" => $k4cp1exfyc68vkkxzrktrnumxi5z9["\126\x4b\117\x52\x44\105\x52\x5f\111\104"], "\x23\x47\x52\x4f\x55\120\137\111\104\x23" => $k4cp1exfyc68vkkxzrktrnumxi5z9["\107\122\117\125\x50\x5f\x49\104"], "\43\x4f\x52\104\105\x52\x5f\111\104\43" => (int) $dob09zs7om7zpdgbmn9z->getId()]));
            }
        } catch (\VKapi\Market\Exception\BaseException $lgm0v) {
            if ($lgm0v instanceof \VKapi\Market\Exception\ORMException) {
                $this->log()->error($lgm0v->getMessage() . "\40\174\40" . $lgm0v->getFile() . "\x3a" . $lgm0v->getLine(), $lgm0v->getCustomData());
                return;
            }
            $this->log()->error($lgm0v->getMessage(), $lgm0v->getCustomData());
        }
    }
    
    public function findPropValueByPropId($ztw6dod2q49au, $db267vjo5glrn3vwt5tbys3xe3rqg8ec8w)
    {
        
        foreach ($ztw6dod2q49au as $rg9jim0do2ex6std1k8vdy2fb0h839fy6c1) {
            if ($rg9jim0do2ex6std1k8vdy2fb0h839fy6c1->getPropertyId() > 0 && $db267vjo5glrn3vwt5tbys3xe3rqg8ec8w == $rg9jim0do2ex6std1k8vdy2fb0h839fy6c1->getPropertyId()) {
                return $ztw6dod2q49au[$rg9jim0do2ex6std1k8vdy2fb0h839fy6c1->getInternalIndex()];
            }
        }
        return null;
    }
}
?>