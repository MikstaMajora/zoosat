<?php

namespace VKapi\Market\Sale\Order;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\Encoding;
use VKapi\Market\Connect;
use VKapi\Market\Manager;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Sync
{
    public function __construct()
    {
    }
    
    public function table()
    {
        if (!isset($this->oTable)) {
            $this->oTable = new \VKapi\Market\Sale\Order\SyncTable();
        }
        return $this->oTable;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function getMessage($n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp = null)
    {
        return $this->manager()->getMessage("\x4c\111\x42\x2e\x53\x41\x4c\x45\56\x4f\122\x44\x45\122\x2e\123\x59\x4e\x43\56" . $n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp);
    }
    
    public function getApiCallbackUrl($hac2nujpwosiz5c1fuhrxf8pj75)
    {
        $hac2nujpwosiz5c1fuhrxf8pj75 = intval($hac2nujpwosiz5c1fuhrxf8pj75);
        $j08mvitxkh5b3e = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        $n4tjes1 = new \Bitrix\Main\Web\Uri(($j08mvitxkh5b3e->isHttps() ? "\150\164\x74\160\163\x3a\57\x2f" : "\150\x74\x74\x70\72\57\57") . $j08mvitxkh5b3e->getHttpHost() . $j08mvitxkh5b3e->getRequestUri());
        $n4tjes1->deleteParams(["\x49\x44", "\154\141\x6e\x67"]);
        $n4tjes1->setPath("\57\142\x69\x74\162\x69\x78\x2f\x74\x6f\157\154\163\x2f\166\x6b\x61\160\151\56\x6d\141\x72\x6b\145\164\x2f\143\x61\x6c\x6c\142\141\x63\153\x2e\160\x68\x70");
        $n4tjes1->addParams(["\163\171\156\143\111\144" => $hac2nujpwosiz5c1fuhrxf8pj75]);
        return $n4tjes1->getLocator();
    }
    
    public function apiCallback()
    {
        try {
            $ywf3yvh7qkljx1s9uwxhnvte9u779s8h = file_get_contents("\x70\x68\160\x3a\57\57\x69\156\160\165\x74");
            $x7dq07r3028kgc2ltf5 = \Bitrix\Main\Web\Json::decode($ywf3yvh7qkljx1s9uwxhnvte9u779s8h);
            $fund3qkhswqnq = \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->get("\163\x79\x6e\x63\x49\144");
            $o1aitvgl = new \VKapi\Market\Sale\Order\Import\Item($fund3qkhswqnq);
            if (!$o1aitvgl->syncItem()->isActive()) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\122\x52\x4f\x52\x5f\x4f\122\104\105\122\137\x53\131\x4e\103\x5f\x4e\x4f\124\x5f\101\x43\124\x49\x56\105", ["\43\111\104\x23" => $o1aitvgl->syncItem()->getId()]), "\x45\x52\122\117\122\x5f\117\122\104\x45\x52\137\x53\x59\x4e\103\x5f\x4e\x4f\x54\137\x41\103\124\111\x56\x45");
            }
            if (!$o1aitvgl->syncItem()->isEventEnabled()) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x45\x52\122\x4f\122\x5f\x43\101\x4c\x4c\x42\101\103\113\137\101\120\111\137\111\x53\x5f\x44\x49\123\101\102\114\105\104", ["\43\111\104\43" => $o1aitvgl->syncItem()->getId()]), "\105\122\x52\117\x52\x5f\103\x41\x4c\114\x42\101\x43\113\137\101\x50\x49\137\x49\x53\137\x44\111\x53\x41\x42\x4c\x45\104");
            }
            if ($o1aitvgl->syncItem()->getEventSecret() != $x7dq07r3028kgc2ltf5["\x73\x65\143\162\145\x74"]) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\x52\x4f\x52\x5f\x43\101\114\114\x42\x41\103\x4b\x5f\101\120\x49\137\123\105\x43\x52\105\x54", ["\43\x49\x44\43" => $o1aitvgl->syncItem()->getId()]), "\x45\x52\x52\117\122\x5f\x43\101\x4c\x4c\102\x41\103\x4b\x5f\101\x50\x49\x5f\123\x45\103\122\x45\x54");
            }
            switch ($x7dq07r3028kgc2ltf5["\164\x79\x70\145"]) {
                case "\x63\157\156\x66\151\162\x6d\141\x74\x69\x6f\156":
                    $cf3w7c0teje44m6cpsgfy2 = $this->apiCallbackActionConfirmation($o1aitvgl, $x7dq07r3028kgc2ltf5);
                    echo $cf3w7c0teje44m6cpsgfy2;
                    break;
                case "\x6d\x61\x72\153\145\164\137\x6f\162\x64\145\162\x5f\x6e\x65\x77":
                case "\x6d\141\162\153\145\x74\x5f\x6f\162\x64\145\x72\137\145\144\x69\164":
                    $this->apiCallbackActionOrderCreteOrUpdate($o1aitvgl, $x7dq07r3028kgc2ltf5);
                    echo $this->getMessage("\x41\x50\111\137\x43\101\x4c\x4c\x42\x41\x43\x4b\x5f\x4f\x4b");
                    break;
                default:
                    throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x55\116\113\x4e\x4f\127\116\x5f\101\120\x49\137\103\101\114\114\102\101\103\x4b\137\124\x59\x50\x45"), "\125\x4e\113\x4e\117\127\x4e\137\x41\120\111\x5f\x43\101\114\x4c\102\101\x43\x4b\x5f\x54\x59\120\x45");
            }
        } catch (\Throwable $lgm0v) {
            $f6oub2sv5p644gxub9 = ["\x54\x59\x50\105" => "\x53\x41\114\105\137\117\x52\x44\105\122\137\123\131\116\x43\137\x41\120\111\x5f\x43\x41\114\114\102\x41\103\x4b"];
            if ($lgm0v instanceof \Bitrix\Main\DB\SqlQueryException) {
                $f6oub2sv5p644gxub9["\121\x55\105\122\x59"] = $lgm0v->getQuery();
            }
            if (isset($o1aitvgl)) {
                $o1aitvgl->log()->error($this->getMessage("\105\x52\x52\x4f\x52\137\x43\101\114\114\102\x41\103\x4b\x5f\x41\x50\111", ["\43\115\123\x47\x23" => "\x5b" . $lgm0v->getCode() . "\x5d\40" . $lgm0v->getMessage()]), $f6oub2sv5p644gxub9);
            }
            echo \Bitrix\Main\Text\Encoding::convertEncoding($lgm0v->getMessage(), LANG_CHARSET, "\x63\x70\x2d\61\62\x35\x31");
        }
        \Bitrix\Main\Application::getInstance()->end();
    }
    
    public function apiCallbackActionConfirmation(\VKapi\Market\Sale\Order\Import\Item $g74wrkcq2jcrsgj1gjqlpwfr0, $x7dq07r3028kgc2ltf5)
    {
        return $g74wrkcq2jcrsgj1gjqlpwfr0->syncItem()->getEventCode();
    }
    
    public function apiCallbackActionOrderCreteOrUpdate(\VKapi\Market\Sale\Order\Import\Item $g74wrkcq2jcrsgj1gjqlpwfr0, $x7dq07r3028kgc2ltf5)
    {
        $avv26eg5ep97u7un7ok59rq6888qs6q = $x7dq07r3028kgc2ltf5["\x6f\142\x6a\145\143\164"];
        try {
            
            $agoy9h = new \VKapi\Market\Sale\Order\Item($g74wrkcq2jcrsgj1gjqlpwfr0->syncItem());
            
            if ($pvs9vbghko5f8q1djxgc89k8wn = $g74wrkcq2jcrsgj1gjqlpwfr0->loadOrderByItem($avv26eg5ep97u7un7ok59rq6888qs6q)) {
                $agoy9h->setVkOrder($pvs9vbghko5f8q1djxgc89k8wn);
            } else {
                $agoy9h->setVkOrder($avv26eg5ep97u7un7ok59rq6888qs6q);
            }
            if (!$agoy9h->isExistOrder()) {
                $v5zb9qgv07fmojknqgk = $g74wrkcq2jcrsgj1gjqlpwfr0->loadVkOrderItems($avv26eg5ep97u7un7ok59rq6888qs6q);
                $agoy9h->setVkOrderItems($v5zb9qgv07fmojknqgk);
                $u2aud6kkdjjrgc0vhta1hw5y7s = $agoy9h->createOrder();
                $g74wrkcq2jcrsgj1gjqlpwfr0->log()->ok($this->getMessage("\103\122\x45\x41\x54\x45\x44\137\x4f\122\x44\x45\x52", ["\43\126\x4b\x4f\122\104\x45\x52\x5f\111\x44\x23" => $avv26eg5ep97u7un7ok59rq6888qs6q["\x64\151\163\160\154\141\171\137\157\x72\144\x65\x72\x5f\x69\144"], "\x23\x47\x52\117\x55\x50\137\x49\104\x23" => $avv26eg5ep97u7un7ok59rq6888qs6q["\x67\x72\157\165\x70\137\x69\x64"], "\x23\x4f\x52\x44\x45\x52\x5f\111\104\43" => (int) $u2aud6kkdjjrgc0vhta1hw5y7s]));
            } else {
                $jsv2rhksjsqfh92bjdmnij = $agoy9h->updateOrder();
                $g74wrkcq2jcrsgj1gjqlpwfr0->log()->ok($this->getMessage("\x55\120\x44\x41\x54\x45\104\x5f\117\122\104\105\x52", ["\43\126\113\117\122\x44\105\x52\x5f\111\104\x23" => $avv26eg5ep97u7un7ok59rq6888qs6q["\144\x69\x73\160\154\x61\x79\x5f\x6f\x72\144\145\x72\137\151\144"], "\x23\x47\x52\117\x55\120\x5f\x49\104\43" => $avv26eg5ep97u7un7ok59rq6888qs6q["\147\162\157\165\x70\x5f\151\144"], "\43\117\122\104\105\x52\x5f\x49\x44\43" => (int) $jsv2rhksjsqfh92bjdmnij]));
            }
        } catch (\VKapi\Market\Exception\BaseException $lgm0v) {
            if ($lgm0v instanceof \VKapi\Market\Exception\ORMException) {
                $g74wrkcq2jcrsgj1gjqlpwfr0->log()->error($lgm0v->getMessage() . "\x20\174\x20" . $lgm0v->getFile() . "\x3a" . $lgm0v->getLine(), $lgm0v->getCustomData());
                return;
            }
            $g74wrkcq2jcrsgj1gjqlpwfr0->log()->error($lgm0v->getMessage(), $lgm0v->getCustomData());
        }
    }
}
?>