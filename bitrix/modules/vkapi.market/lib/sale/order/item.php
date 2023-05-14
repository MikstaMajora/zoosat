<?php

namespace VKapi\Market\Sale\Order;

use Bitrix\Main\Localization\Loc;
use VKapi\Market\Manager;
use VKapi\Market\Exception\BaseException;
use VKapi\Market\Exception\ORMException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Item
{
    const PAYMENT_STATUS_NOT_PAID = "\156\157\164\x5f\160\x61\151\x64";
    const PAYMENT_STATUS_PAID = "\160\x61\x69\144";
    const PAYMENT_STATUS_RETURNED = "\x72\x65\164\165\x72\156\145\144";
    
    private $vkOrderItem = null;
    
    private $vkOrderDisplayId = "";
    
    private $vkOrderId = 0;
    
    private $vkOrderGroupId = 0;
    
    private $vkOrderUserId = 0;
    
    private $vkOrderDate = 0;
    
    private $vkOrderStatus = 0;
    
    private $vkOrderPaymentStatus = self::PAYMENT_STATUS_NOT_PAID;
    
    private $vkOrderTotalPrice = 0;
    
    private $vkOrderPromocodeDiscount = 0;
    private $vkOrderPromocodeDiscountCurrency = "\122\x55\102";
    
    private $vkOrderDeliveryPrice = 0;
    private $vkOrderDeliveryPriceCurrency = "\122\x55\102";
    
    private $vkOrderCurrency = "\x52\125\x42";
    
    private $vkOrderComment = "";
    
    private $vkOrderMerchantComment = "";
    
    private $vkOrderCommentForUser = "";
    
    private $vkOrderWidth = 0;
    
    private $vkOrderLength = 0;
    
    private $vkOrderHeight = 0;
    
    private $vkOrderWeight = 0;
    
    private $vkOrderReceiptLink = "";
    
    private $vkOrderDelivery = [];
    
    private $vkOrderBuyerName = "";
    
    private $vkOrderBuyerPhone = "";
    
    private $vkOrderItems = [];
    
    private $oSyncItem = null;
    
    public function __construct(\VKapi\Market\Sale\Order\Sync\Item $fhasfg8g101hhdvcp50g2neup1alvomb)
    {
        $this->oSyncItem = $fhasfg8g101hhdvcp50g2neup1alvomb;
        if (!$this->manager()->isInstalledSaleModule()) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x4d\x4f\x44\x55\114\x45\x5f\123\101\114\105\137\111\123\137\x4e\117\124\x5f\111\x4e\123\x54\101\x4c\114\x45\104"), "\x45\122\122\117\122\x5f\115\x4f\104\x55\x4c\105\x5f\123\x41\x4c\x45\x5f\x4e\x4f\124\137\106\x4f\x55\x4e\104");
        }
        if (!$this->manager()->isInstalledCatalogModule()) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x4d\x4f\x44\x55\x4c\x45\137\103\x41\x54\x41\x4c\x4f\x47\137\111\x53\137\116\x4f\124\137\x49\116\x53\x54\101\x4c\114\105\104"), "\105\122\122\x4f\122\x5f\x4d\117\x44\125\114\x45\x5f\103\101\x54\x41\x4c\x4f\x47\137\116\x4f\124\x5f\106\117\x55\116\104");
        }
        if (!$this->manager()->isInstalledIblockModule()) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x4d\x4f\104\x55\114\x45\x5f\111\102\x4c\x4f\x43\x4b\x5f\111\123\x5f\116\117\x54\137\111\x4e\123\124\101\114\114\105\104"), "\105\122\x52\117\x52\x5f\x4d\x4f\104\x55\114\x45\137\111\x42\x4c\x4f\103\113\x5f\x4e\x4f\124\x5f\106\x4f\x55\x4e\104");
        }
    }
    
    public function oldUser()
    {
        if (!isset($this->oOldUser)) {
            $this->oOldUser = new \CUser();
        }
        return $this->oOldUser;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function syncItem()
    {
        return $this->oSyncItem;
    }
    
    public function syncRefTable()
    {
        if (!isset($this->oSyncRefTable)) {
            $this->oSyncRefTable = new \VKapi\Market\Sale\Order\Sync\RefTable();
        }
        return $this->oSyncRefTable;
    }
    
    public function getMessage($n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp = null)
    {
        return $this->manager()->getMessage("\114\x49\102\56\123\101\114\105\56\117\122\x44\x45\x52\56\x49\124\x45\115\x2e" . $n0z8bxh3q, $a2oylr8shyt4x5vcqs3f1onvgp);
    }
    
    public function setVkOrder(array $p6b8qkj818r5kg5)
    {
        $this->vkOrderItem = $p6b8qkj818r5kg5;
        $this->vkOrderId = (int) $p6b8qkj818r5kg5["\151\x64"];
        $this->vkOrderGroupId = (int) $p6b8qkj818r5kg5["\147\x72\157\x75\160\x5f\x69\x64"];
        $this->vkOrderUserId = (int) $p6b8qkj818r5kg5["\165\163\145\162\137\151\144"];
        $this->vkOrderDisplayId = (string) $p6b8qkj818r5kg5["\144\x69\163\x70\x6c\x61\171\137\157\x72\144\x65\162\137\151\x64"];
        if (empty($this->vkOrderDisplayId)) {
            $this->vkOrderDisplayId = sprintf("\x25\163\x2d\x25\163", $this->vkOrderUserId, $this->vkOrderId);
        }
        $this->vkOrderDate = (int) $p6b8qkj818r5kg5["\x64\x61\164\x65"];
        $this->vkOrderDeliveryPrice = (int) $p6b8qkj818r5kg5["\144\x65\x6c\151\x76\145\x72\171\x5f\x70\162\x69\143\145"];
        $this->vkOrderStatus = (int) $p6b8qkj818r5kg5["\x73\164\141\164\165\163"];
        $this->vkOrderPaymentStatus = (string) $p6b8qkj818r5kg5["\x70\x61\171\155\x65\156\164"]["\x70\x61\171\155\145\x6e\x74\137\x73\164\141\164\165\163"];
        $this->vkOrderCurrency = $p6b8qkj818r5kg5["\x74\x6f\x74\141\x6c\x5f\x70\x72\x69\143\x65"]["\x63\x75\162\162\x65\156\x63\x79"]["\156\141\155\x65"];
        $this->vkOrderTotalPrice = (int) $p6b8qkj818r5kg5["\x74\x6f\x74\141\x6c\x5f\160\162\151\143\x65"]["\x61\x6d\x6f\165\156\x74"] / 100;
        $this->vkOrderComment = (string) $p6b8qkj818r5kg5["\143\x6f\x6d\155\x65\x6e\164"];
        $this->vkOrderMerchantComment = (string) $p6b8qkj818r5kg5["\x6d\145\x72\x63\x68\x61\x6e\164\137\143\157\x6d\155\145\156\164"];
        $this->vkOrderCommentForUser = (string) ($p6b8qkj818r5kg5["\x63\x6f\x6d\x6d\x65\156\164\137\x66\157\162\137\x75\x73\x65\x72"] ?: "");
        $this->vkOrderWidth = (int) $p6b8qkj818r5kg5["\x64\151\155\x65\156\x73\x69\157\156\163"]["\167\x69\x64\x74\150"];
        $this->vkOrderLength = (int) $p6b8qkj818r5kg5["\144\x69\x6d\145\x6e\163\151\157\156\163"]["\154\145\x6e\x67\164\150"];
        $this->vkOrderHeight = (int) $p6b8qkj818r5kg5["\144\x69\155\145\156\x73\151\157\x6e\163"]["\150\x65\151\147\x68\x74"];
        $this->vkOrderWeight = (int) $p6b8qkj818r5kg5["\167\x65\151\147\150\x74"];
        $this->vkOrderReceiptLink = (string) ($p6b8qkj818r5kg5["\x72\145\143\145\151\x70\x74\137\154\151\156\153"] ?: "");
        $this->vkOrderDelivery = $p6b8qkj818r5kg5["\144\x65\x6c\x69\x76\145\162\x79"];
        $this->vkOrderBuyerName = (string) $p6b8qkj818r5kg5["\x72\145\143\151\160\x69\145\x6e\164"]["\x6e\x61\x6d\145"];
        $this->vkOrderBuyerPhone = (string) $p6b8qkj818r5kg5["\x72\x65\143\x69\x70\x69\x65\x6e\164"]["\160\150\157\x6e\145"];
        $this->vkOrderPromocodeDiscount = 0;
        $this->vkOrderDeliveryPrice = 0;
        if (!isset($p6b8qkj818r5kg5["\160\162\x69\143\145\x5f\x64\x65\x74\141\151\154\163"])) {
            return $this;
        }
        $zkcz0g551y3 = array_combine(array_column($p6b8qkj818r5kg5["\160\162\x69\143\x65\x5f\x64\145\x74\141\x69\154\x73"], "\164\x69\x74\x6c\145"), $p6b8qkj818r5kg5["\x70\162\151\x63\145\x5f\x64\145\x74\141\151\x6c\x73"]);
        if (isset($zkcz0g551y3[$this->getMessage("\104\x45\x4c\x49\x56\x45\x52\x59\x5f\x43\117\x53\x54")])) {
            $this->vkOrderDeliveryPrice = abs((int) $zkcz0g551y3[$this->getMessage("\104\105\114\x49\126\x45\x52\131\137\x43\117\123\x54")]["\x70\x72\x69\143\145"]["\x61\155\157\165\x6e\x74"] ?? 0);
            $this->vkOrderDeliveryPriceCurrency = (string) $zkcz0g551y3[$this->getMessage("\104\105\x4c\111\126\x45\122\131\137\x43\117\123\124")]["\160\x72\x69\x63\145"]["\143\165\162\162\x65\x6e\143\x79"]["\156\x61\155\145"] ?? "\122\125\102";
            if ($this->vkOrderDeliveryPrice > 0) {
                $this->vkOrderDeliveryPrice = $this->vkOrderDeliveryPrice / 100;
            }
        }
        if (isset($zkcz0g551y3[$this->getMessage("\x50\122\117\x4d\x4f\103\x4f\x44\105\x5f\103\117\123\124")])) {
            $this->vkOrderPromocodeDiscount = abs((int) $zkcz0g551y3[$this->getMessage("\x50\x52\x4f\x4d\117\x43\x4f\104\x45\x5f\x43\117\123\x54")]["\160\162\x69\143\x65"]["\141\155\157\165\156\x74"] ?? 0);
            $this->vkOrderPromocodeDiscountCurrency = (string) $zkcz0g551y3[$this->getMessage("\x50\x52\117\x4d\117\103\117\104\105\x5f\103\117\123\124")]["\x70\x72\x69\x63\x65"]["\143\x75\x72\162\x65\156\x63\171"]["\156\141\x6d\x65"] ?? "\122\125\102";
            if ($this->vkOrderPromocodeDiscount > 0) {
                $this->vkOrderPromocodeDiscount = $this->vkOrderPromocodeDiscount / 100;
            }
        }
        return $this;
    }
    
    public function setVkOrderItems(array $k7i3uoff2lbc6ureqw359c2i)
    {
        $this->vkOrderItems = $k7i3uoff2lbc6ureqw359c2i;
    }
    
    public function isExistOrder()
    {
        if (!empty($this->getOrderId())) {
            return true;
        }
        return false;
    }
    
    public function getOrderId()
    {
        
        $n8x76cvzpajf9k0qt8b6443ey = $this->syncRefTable()->getList(["\146\x69\154\164\145\x72" => ["\126\x4b\117\x52\104\x45\x52\137\111\104" => $this->vkOrderId, "\126\x4b\x55\x53\105\122\x5f\x49\104" => $this->vkOrderUserId], "\154\x69\x6d\151\x74" => 1]);
        if ($v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs = $n8x76cvzpajf9k0qt8b6443ey->fetch()) {
            return $v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs["\x4f\122\x44\x45\x52\x5f\111\x44"];
        }
        return null;
    }
    
    public function saveRef($pn12i72reazoq)
    {
        
        $v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs = $this->syncRefTable()->getList(["\146\151\x6c\164\145\162" => ["\126\113\x4f\x52\x44\x45\x52\137\x49\x44" => $this->vkOrderId, "\126\113\125\123\105\122\x5f\111\104" => $this->vkOrderUserId], "\x6c\x69\x6d\151\164" => 1])->fetch();
        if ($v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs) {
            
            if ($v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs["\x4f\x52\104\x45\122\x5f\111\x44"] != $pn12i72reazoq) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\122\x52\x4f\122\x5f\x4f\122\x44\105\x52\x5f\111\104\x5f\x49\123\x5f\104\111\106\x46\105\122\x45\116\124", ["\43\x4f\x4c\104\x5f\x49\x44\x23" => $v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs["\x4f\122\104\105\x52\137\111\104"], "\43\x49\104\x23" => $pn12i72reazoq]));
            }
        } else {
            $fdvewfhxzb5gde = ["\x56\x4b\117\x52\104\x45\x52\x5f\x49\x44" => $this->vkOrderId, "\126\113\x55\x53\x45\x52\x5f\111\x44" => $this->vkOrderUserId, "\x4f\x52\x44\105\122\137\111\104" => $pn12i72reazoq, "\x47\x52\117\125\120\x5f\111\104" => $this->vkOrderGroupId, "\x53\x59\x4e\103\137\x49\104" => $this->syncItem()->getId()];
            $jc7ai89g = $this->syncRefTable()->add($fdvewfhxzb5gde);
            if (!$jc7ai89g->isSuccess()) {
                throw new \VKapi\Market\Exception\ORMException($jc7ai89g);
            }
        }
    }
    
    public function createOrder()
    {
        $xdgt6s1bnxk0t = \Bitrix\Sale\Registry::getInstance(\Bitrix\Sale\Registry::REGISTRY_TYPE_ORDER);
        $jja0c1no6pc9cwo1w8nuv1 = $this->findOrCreateUserId();
        
        $this->createSaleFUser($jja0c1no6pc9cwo1w8nuv1);
        
        $sbznzqwokzzc1 = $xdgt6s1bnxk0t->getBasketClassName();
        $k6jix78mry = $sbznzqwokzzc1::create($this->syncItem()->getSiteId());
        if (count($this->vkOrderItems)) {
            
            $j031dr69efaxk8tjkz4k4l1hk = 0;
            foreach ($this->vkOrderItems as $f4yofs93s8isv3a0rfdh6f744) {
                $j031dr69efaxk8tjkz4k4l1hk += (int) $f4yofs93s8isv3a0rfdh6f744["\x70\x72\x69\x63\145"]["\141\155\157\165\156\x74"] / 100;
            }
            
            $kexg845 = $this->vkOrderPromocodeDiscount / $j031dr69efaxk8tjkz4k4l1hk;
            
            $dgfylxvie6 = $this->vkOrderPromocodeDiscount;
            $kuys0dnsimpv7qkm4rwzzm00e54o = count($this->vkOrderItems) - 1;
            foreach ($this->vkOrderItems as $jxjzpb8shvmf => $d9w4l2k910wegjzsqb9q) {
                
                $ja2f0jcpxnrrq0oq4v = $this->getProductByVkOrderItem($d9w4l2k910wegjzsqb9q);
                if (empty($ja2f0jcpxnrrq0oq4v)) {
                    throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x45\122\122\117\x52\x5f\126\x4b\111\124\105\115\137\116\117\x54\x5f\x46\x4f\x55\116\104", ["\43\116\101\115\x45\x23" => $d9w4l2k910wegjzsqb9q["\x74\x69\x74\x6c\x65"], "\43\x49\x44\43" => $d9w4l2k910wegjzsqb9q["\151\x74\145\x6d\137\151\x64"], "\43\126\x4b\117\122\x44\x45\x52\137\111\x44\43" => $this->vkOrderDisplayId, "\x23\107\122\117\x55\120\137\111\x44\x23" => $this->vkOrderGroupId]), "\105\122\122\117\x52\137\126\x4b\137\117\122\x44\x45\x52\137\111\124\105\115\137\116\117\x54\x5f\x46\x4f\125\x4e\x44", $d9w4l2k910wegjzsqb9q);
                }
                $bc1mzdrby7kegp7yf = ["\x50\x52\x4f\x44\125\x43\x54\x5f\x49\104" => $ja2f0jcpxnrrq0oq4v["\x49\104"], "\x42\x41\123\105\137\120\x52\x49\x43\105" => $ja2f0jcpxnrrq0oq4v["\120\122\x49\103\x45"], "\103\125\122\x52\105\116\x43\x59" => $ja2f0jcpxnrrq0oq4v["\103\125\x52\122\105\116\103\131"], "\121\x55\x41\x4e\x54\x49\124\x59" => $ja2f0jcpxnrrq0oq4v["\x51\125\101\116\x54\x49\x54\131"], "\x4c\111\104" => $this->syncItem()->getSiteId(), "\104\105\x4c\x41\x59" => "\x4e", "\x43\101\116\137\x42\x55\x59" => "\x59", "\x4e\x41\x4d\105" => $ja2f0jcpxnrrq0oq4v["\116\x41\x4d\x45"], "\x4d\x4f\x44\125\x4c\105" => "\x63\x61\x74\141\154\157\147", "\x50\x52\x4f\x44\x55\103\124\137\x50\122\117\x56\111\x44\105\x52\137\103\x4c\101\123\x53" => \Bitrix\Catalog\Product\Basket::getDefaultProviderName()];
                $terd6w41bmmd706j = \Bitrix\Catalog\Product\Basket::addProductToBasket($k6jix78mry, $bc1mzdrby7kegp7yf, ["\x55\123\105\x52\x5f\x49\x44" => $jja0c1no6pc9cwo1w8nuv1, "\x53\111\x54\105\x5f\x49\x44" => $this->syncItem()->getSiteId()]);
                if ($terd6w41bmmd706j->isSuccess()) {
                    $chn67ar = $terd6w41bmmd706j->getData();
                    if (isset($chn67ar["\x42\x41\x53\x4b\x45\x54\137\111\x54\105\115"])) {
                        
                        $sy8i71ux05ypo = $chn67ar["\x42\x41\123\x4b\105\124\x5f\x49\x54\x45\x4d"];
                    } else {
                        throw new \VKapi\Market\Exception\BaseException("\105\122\x52\x4f\122\137\x41\x44\104\x5f\102\101\x53\113\105\x54\137\x49\124\105\x4d\x5f\124\117\x5f\117\x52\x44\105\122", "\x45\122\122\x4f\x52\137\101\x44\104\137\x42\x41\123\x4b\105\x54\x5f\111\124\x45\115\x5f\x54\x4f\x5f\117\x52\x44\105\x52");
                    }
                } else {
                    throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\x52\x4f\x52\x5f\x41\x44\x44\137\120\122\x4f\104\x55\x43\x54\137\124\117\137\102\101\x53\x4b\105\124", ["\x23\120\x52\117\104\x55\103\124\137\111\x44\43" => $ja2f0jcpxnrrq0oq4v["\x49\x44"], "\43\115\105\123\x53\101\x47\105\x23" => $terd6w41bmmd706j->getErrorCollection()->rewind()->getMessage()]), "\105\x52\x52\117\x52\137\101\104\x44\137\x42\101\123\113\x45\124\x5f\x49\x54\105\115\137\124\117\137\x4f\x52\104\x45\122");
                }
                if (!$this->vkOrderPromocodeDiscount) {
                    $sy8i71ux05ypo->setPrice($ja2f0jcpxnrrq0oq4v["\x50\122\111\x43\x45"], true);
                } else {
                    if ($kuys0dnsimpv7qkm4rwzzm00e54o > $jxjzpb8shvmf) {
                        $hmsrt7lpbqrm = floor($ja2f0jcpxnrrq0oq4v["\120\x52\111\x43\105"] * $kexg845);
                        $sy8i71ux05ypo->setPrice($ja2f0jcpxnrrq0oq4v["\120\122\x49\x43\105"] - $hmsrt7lpbqrm, true);
                        $dgfylxvie6 -= $hmsrt7lpbqrm;
                    } else {
                        $sy8i71ux05ypo->setPrice($ja2f0jcpxnrrq0oq4v["\x50\x52\111\x43\105"] - $dgfylxvie6, true);
                    }
                }
            }
        }
        
        $ctl48bc7takyy3l = $xdgt6s1bnxk0t->getOrderClassName();
        $dob09zs7om7zpdgbmn9z = $ctl48bc7takyy3l::create($this->syncItem()->getSiteId(), $jja0c1no6pc9cwo1w8nuv1);
        $dob09zs7om7zpdgbmn9z->setPersonTypeId($this->syncItem()->getPersonalTypeId());
        $dob09zs7om7zpdgbmn9z->setBasket($k6jix78mry);
        
        $buoz62 = $dob09zs7om7zpdgbmn9z->getShipmentCollection();
        $y37kjbsx1sjhc07 = mb_strtolower($this->vkOrderDelivery["\164\x79\160\145"]);
        if (strpos($y37kjbsx1sjhc07, mb_strtolower($this->getMessage("\x44\x45\114\111\x56\x45\x52\x59\x5f\124\131\120\105\137\120\x4f\111\x4e\124"))) !== false) {
            $y37kjbsx1sjhc07 = mb_strtolower($this->getMessage("\104\x45\114\111\x56\x45\122\131\x5f\124\x59\120\x45\x5f\120\x4f\111\116\x54"));
        }
        
        $mffug449wratnj2ooqe5isc2roz29z0fdj = null;
        switch ($y37kjbsx1sjhc07) {
            case mb_strtolower($this->getMessage("\x44\x45\x4c\111\126\x45\x52\x59\x5f\x54\x59\x50\105\137\103\x4f\x55\122\x49\105\122")):
                
                if ($this->syncItem()->getDeliveryIdCourier()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryIdCourier()));
                } elseif ($this->syncItem()->getDeliveryId()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                }
                break;
            case mb_strtolower($this->getMessage("\104\105\x4c\111\126\x45\122\131\x5f\124\131\120\x45\x5f\x50\117\x43\110\124\101")):
                
                if ($this->syncItem()->getDeliveryIdPochta()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryIdPochta()));
                } elseif ($this->syncItem()->getDeliveryId()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                }
                break;
            case mb_strtolower($this->getMessage("\104\x45\114\111\x56\105\122\x59\137\124\131\x50\105\137\x50\117\x49\x4e\x54")):
                
                if ($this->syncItem()->getDeliveryIdPoint()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryIdPoint()));
                } elseif ($this->syncItem()->getDeliveryId()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                }
                break;
            case mb_strtolower($this->getMessage("\104\x45\x4c\x49\126\105\x52\x59\137\124\x59\x50\105\x5f\x50\111\103\x4b\125\x50")):
            default:
                
                if ($this->syncItem()->getDeliveryId()) {
                    $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                }
        }
        if (!is_null($mffug449wratnj2ooqe5isc2roz29z0fdj)) {
            $mffug449wratnj2ooqe5isc2roz29z0fdj->setBasePriceDelivery($this->vkOrderDeliveryPrice, true);
            $mffug449wratnj2ooqe5isc2roz29z0fdj->setField("\120\x52\111\x43\105\x5f\x44\x45\x4c\111\126\x45\122\131", $this->vkOrderDeliveryPrice);
            if (!empty($this->vkOrderDelivery["\x74\162\141\x63\x6b\137\x6e\165\155\x62\145\162"])) {
                $mffug449wratnj2ooqe5isc2roz29z0fdj->setField("\124\x52\x41\x43\113\x49\116\107\137\116\125\x4d\102\x45\122", $this->vkOrderDelivery["\164\162\141\x63\x6b\137\156\165\155\142\145\x72"]);
            }
            
            $sh7n9336uf6mjp58 = $mffug449wratnj2ooqe5isc2roz29z0fdj->getShipmentItemCollection();
            foreach ($k6jix78mry as $sy8i71ux05ypo) {
                $rg9jim0do2ex6std1k8vdy2fb0h839fy6c1 = $sh7n9336uf6mjp58->createItem($sy8i71ux05ypo);
                $rg9jim0do2ex6std1k8vdy2fb0h839fy6c1->setQuantity($sy8i71ux05ypo->getQuantity());
            }
        }
        $ujoqbm4qmpihjqzcop6zaa38c39y = $dob09zs7om7zpdgbmn9z->getPaymentCollection();
        if ($this->syncItem()->getPaymentId()) {
            $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd = $ujoqbm4qmpihjqzcop6zaa38c39y->createItem(\Bitrix\Sale\PaySystem\Manager::getObjectById($this->syncItem()->getPaymentId()));
            
            $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setField("\103\125\x52\x52\x45\116\103\x59", $this->vkOrderCurrency);
            if ($this->vkOrderPaymentStatus == self::PAYMENT_STATUS_PAID) {
                $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setPaid("\131");
                $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setField("\103\x4f\x4d\115\x45\116\x54\x53", $this->getMessage("\123\x45\124\x5f\x50\x41\111\104\137\131", ["\43\x44\x41\124\105\x23" => date("\144\56\x6d\56\131\x20\x48\72\151\72\x73")]));
            }
        }
        
        $kdch1ywb23v8zk3n60cebr = $dob09zs7om7zpdgbmn9z->getPropertyCollection();
        if ($this->syncItem()->getFioPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getFioPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderBuyerName);
            }
        }
        if ($this->syncItem()->getPhonePropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getPhonePropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderBuyerPhone);
            }
        }
        if ($this->syncItem()->getVkOrderPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getVkOrderPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderUserId . "\55" . $this->vkOrderId);
            }
        }
        if ($this->syncItem()->getAddressPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getAddressPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue((string) $this->vkOrderDelivery["\x61\144\x64\162\x65\x73\x73"]);
            }
        }
        if ($this->syncItem()->getCommentForUserPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getCommentForUserPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderCommentForUser);
            }
        }
        if ($this->syncItem()->getWidthPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getWidthPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderWidth);
            }
        }
        if ($this->syncItem()->getHeightPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getHeightPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderHeight);
            }
        }
        if ($this->syncItem()->getLengthPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getLengthPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderLength);
            }
        }
        if ($this->syncItem()->getWeightPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getWeightPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderWeight);
            }
        }
        $dob09zs7om7zpdgbmn9z->setField("\104\x41\124\105\137\x49\x4e\123\105\x52\124", \Bitrix\Main\Type\DateTime::createFromTimestamp($this->vkOrderDate));
        $dob09zs7om7zpdgbmn9z->setField("\125\123\105\122\x5f\104\x45\x53\x43\122\111\x50\124\111\x4f\116", $this->vkOrderComment);
        $dob09zs7om7zpdgbmn9z->setField("\103\x4f\115\x4d\105\x4e\124\123", $this->vkOrderMerchantComment);
        if ($this->vkOrderPromocodeDiscount) {
            $dob09zs7om7zpdgbmn9z->setField("\103\117\x4d\x4d\105\x4e\x54\123", $this->getMessage("\120\x52\x4f\x4d\x4f\x43\x4f\104\x45\137\103\117\123\x54\137\x43\x4f\115\x4d\x45\116\x54", ["\43\x43\x4f\x4d\115\105\116\124\x23" => $this->vkOrderMerchantComment, "\43\104\x49\123\x43\117\x55\x4e\x54\43" => $this->vkOrderPromocodeDiscount, "\x23\103\x55\x52\x52\105\116\x43\131\43" => $this->vkOrderPromocodeDiscountCurrency]));
        }
        $s034d4edut8g659j7 = $this->syncItem()->getStatusIdByVkStatus($this->vkOrderStatus);
        if (!empty($s034d4edut8g659j7)) {
            $fzp5c1kud22snw2tji01lk1x3wt1oy = $dob09zs7om7zpdgbmn9z->setField("\x53\x54\x41\x54\x55\123\x5f\x49\x44", $s034d4edut8g659j7);
            if (!$fzp5c1kud22snw2tji01lk1x3wt1oy->isSuccess()) {
                throw new \VKapi\Market\Exception\BaseException($fzp5c1kud22snw2tji01lk1x3wt1oy->getErrorCollection()->rewind()->getMessage(), "\105\x52\x52\x4f\122\137\x53\101\x4c\x45\137\x4f\122\104\x45\x52\137\111\124\105\x4d\x5f\123\x45\x54\137\x53\124\101\124\x55\x53");
            }
        }
        
        $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_BEFORE_ORDER_CREATE, ["\x6f\162\144\145\x72" => $dob09zs7om7zpdgbmn9z, "\151\x74\x65\x6d" => $this]);
        $jc7ai89g = $dob09zs7om7zpdgbmn9z->save();
        if (!$jc7ai89g->isSuccess()) {
            throw new \VKapi\Market\Exception\ORMException($jc7ai89g);
        }
        $this->saveRef($jc7ai89g->getId());
        
        $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_AFTER_ORDER_CREATE, ["\157\x72\144\x65\162" => $dob09zs7om7zpdgbmn9z, "\x69\x74\x65\155" => $this]);
        return $jc7ai89g->getId();
    }
    
    public function updateOrder()
    {
        $pn12i72reazoq = (int) $this->getOrderId();
        $xdgt6s1bnxk0t = \Bitrix\Sale\Registry::getInstance(\Bitrix\Sale\Registry::REGISTRY_TYPE_ORDER);
        
        $ctl48bc7takyy3l = $xdgt6s1bnxk0t->getOrderClassName();
        $dob09zs7om7zpdgbmn9z = $ctl48bc7takyy3l::load($pn12i72reazoq);
        if (empty($dob09zs7om7zpdgbmn9z)) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\122\117\122\x5f\117\122\104\x45\122\x5f\x4e\117\124\137\106\117\125\x4e\104", ["\43\117\x52\104\x45\x52\x5f\111\104\43" => $pn12i72reazoq, "\x23\126\x4b\117\122\x44\x45\x52\x5f\111\104\43" => $this->vkOrderDisplayId, "\43\x47\x52\x4f\x55\x50\x5f\x49\x44\x23" => $this->vkOrderGroupId]), "\105\122\122\117\122\x5f\117\x52\104\105\122\137\116\117\124\137\106\117\x55\x4e\x44");
        }
        
        $ujoqbm4qmpihjqzcop6zaa38c39y = $dob09zs7om7zpdgbmn9z->getPaymentCollection();
        $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd = $ujoqbm4qmpihjqzcop6zaa38c39y->getItemByIndex(0);
        if (!is_null($ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd)) {
            if ($this->vkOrderPaymentStatus == self::PAYMENT_STATUS_PAID && !$ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->isPaid()) {
                $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setField("\x43\117\x4d\115\105\x4e\124\123", $this->getMessage("\x53\105\x54\x5f\120\x41\x49\x44\137\131", ["\x23\x44\x41\124\x45\x23" => date("\144\56\155\x2e\x59\40\110\72\151\x3a\163")]));
                $rwbsda3cfugpc4nfa = $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setPaid("\131");
            } elseif ($this->vkOrderPaymentStatus != self::PAYMENT_STATUS_PAID && $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->isPaid()) {
                $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setField("\x43\x4f\x4d\x4d\105\x4e\124\123", $this->getMessage("\x53\x45\x54\x5f\120\101\111\x44\137\116", ["\43\104\x41\124\x45\43" => date("\144\56\x6d\x2e\131\40\x48\x3a\151\x3a\x73")]));
                $rwbsda3cfugpc4nfa = $ehljrak8xf4z2kktfiiyhcbqbnuxrc3mxd->setPaid("\x4e");
            }
            if ($rwbsda3cfugpc4nfa instanceof \Bitrix\Sale\Result && !$rwbsda3cfugpc4nfa->isSuccess()) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\122\x52\117\122\x5f\123\101\114\105\137\x4f\122\104\105\x52\x5f\111\124\x45\x4d\x5f\123\105\x54\x5f\120\x41\131\x4d\105\x4e\x54\137\x53\x54\101\x54\125\123", ["\43\x4f\122\x44\105\x52\137\111\x44\x23" => $pn12i72reazoq, "\x23\126\113\x4f\122\x44\105\x52\x5f\x49\x44\x23" => $this->vkOrderDisplayId, "\x23\x47\x52\117\125\120\x5f\x49\x44\43" => $this->vkOrderGroupId, "\43\x4d\x53\x47\x23" => $rwbsda3cfugpc4nfa->getErrorCollection()->rewind()->getMessage()]), "\105\122\122\x4f\x52\137\x53\x41\114\105\137\x4f\x52\104\105\122\137\111\x54\105\115\137\x53\x45\x54\x5f\x50\x41\131\115\x45\116\124\137\123\x54\101\x54\x55\123");
            }
        }
        $dob09zs7om7zpdgbmn9z->setField("\103\117\115\115\x45\116\124\123", $this->vkOrderMerchantComment);
        
        $kdch1ywb23v8zk3n60cebr = $dob09zs7om7zpdgbmn9z->getPropertyCollection();
        if ($this->syncItem()->getCommentForUserPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getCommentForUserPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderCommentForUser);
            }
        }
        if ($this->syncItem()->getWidthPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getWidthPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderWidth);
            }
        }
        if ($this->syncItem()->getHeightPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getHeightPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderHeight);
            }
        }
        if ($this->syncItem()->getLengthPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getLengthPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderLength);
            }
        }
        if ($this->syncItem()->getWeightPropertyId()) {
            $a75gm0d1773kr11oilqj3um7hkv = $this->findPropValueByPropId($kdch1ywb23v8zk3n60cebr, $this->syncItem()->getWeightPropertyId());
            if ($a75gm0d1773kr11oilqj3um7hkv) {
                $a75gm0d1773kr11oilqj3um7hkv->setValue($this->vkOrderWeight);
            }
        }
        $dob09zs7om7zpdgbmn9z->setField("\x55\x53\x45\122\137\104\x45\123\103\122\x49\x50\x54\x49\x4f\116", $this->vkOrderComment);
        $dob09zs7om7zpdgbmn9z->setField("\x43\x4f\x4d\x4d\105\116\x54\x53", $this->vkOrderMerchantComment);
        $s034d4edut8g659j7 = $this->syncItem()->getStatusIdByVkStatus($this->vkOrderStatus);
        if (!empty($s034d4edut8g659j7) && $dob09zs7om7zpdgbmn9z->getField("\123\124\x41\x54\125\123\x5f\111\x44") != $s034d4edut8g659j7) {
            $fzp5c1kud22snw2tji01lk1x3wt1oy = $dob09zs7om7zpdgbmn9z->setField("\123\x54\x41\x54\125\123\x5f\x49\104", $s034d4edut8g659j7);
            if (!$fzp5c1kud22snw2tji01lk1x3wt1oy->isSuccess()) {
                throw new \VKapi\Market\Exception\BaseException($this->getMessage("\105\x52\x52\117\x52\x5f\x53\x41\x4c\105\137\117\x52\x44\105\122\x5f\111\124\105\x4d\x5f\x53\105\124\137\123\x54\x41\x54\x55\x53", ["\x23\x4f\122\x44\x45\x52\x5f\x49\104\x23" => $pn12i72reazoq, "\x23\126\x4b\x4f\x52\104\x45\122\137\111\104\x23" => $this->vkOrderDisplayId, "\43\107\x52\117\125\x50\137\x49\104\43" => $this->vkOrderGroupId, "\x23\115\123\x47\x23" => $rwbsda3cfugpc4nfa->getErrorCollection()->rewind()->getMessage()]), "\105\x52\x52\117\122\x5f\x53\x41\114\105\137\117\x52\104\105\122\x5f\111\124\105\115\137\123\105\124\x5f\x53\124\x41\x54\x55\x53");
            }
        }
        
        $buoz62 = $dob09zs7om7zpdgbmn9z->getShipmentCollection();
        $mffug449wratnj2ooqe5isc2roz29z0fdj = null;
        foreach ($buoz62 as $uvfyi3qezemqc6lomz29z0v9a21vd5) {
            if ($uvfyi3qezemqc6lomz29z0v9a21vd5->isSystem()) {
                continue;
            }
            $mffug449wratnj2ooqe5isc2roz29z0fdj = $uvfyi3qezemqc6lomz29z0v9a21vd5;
            break;
        }
        if (is_null($mffug449wratnj2ooqe5isc2roz29z0fdj)) {
            $mffug449wratnj2ooqe5isc2roz29z0fdj = null;
            $y37kjbsx1sjhc07 = mb_strtolower($this->vkOrderDelivery["\164\x79\x70\x65"]);
            if (strpos($y37kjbsx1sjhc07, mb_strtolower($this->getMessage("\x44\105\x4c\x49\126\x45\122\131\137\124\x59\120\105\x5f\120\x4f\111\x4e\x54"))) !== false) {
                $y37kjbsx1sjhc07 = mb_strtolower($this->getMessage("\x44\105\x4c\111\126\x45\x52\131\x5f\x54\131\120\105\x5f\x50\x4f\x49\116\x54"));
            }
            switch ($y37kjbsx1sjhc07) {
                case mb_strtolower($this->getMessage("\104\105\114\x49\126\x45\x52\x59\x5f\124\131\x50\105\137\x43\117\125\x52\x49\x45\x52")):
                    
                    if ($this->syncItem()->getDeliveryIdCourier()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryIdCourier()));
                    } elseif ($this->syncItem()->getDeliveryId()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                    }
                    break;
                case mb_strtolower($this->getMessage("\104\x45\114\x49\126\x45\122\x59\137\124\x59\120\x45\137\120\x4f\103\110\x54\x41")):
                    
                    if ($this->syncItem()->getDeliveryIdPochta()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryIdPochta()));
                    } elseif ($this->syncItem()->getDeliveryId()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                    }
                    break;
                case mb_strtolower($this->getMessage("\x44\x45\x4c\x49\x56\x45\122\131\x5f\x54\131\120\105\x5f\x50\117\x49\116\124")):
                    
                    if ($this->syncItem()->getDeliveryIdPoint()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryIdPoint()));
                    } elseif ($this->syncItem()->getDeliveryId()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                    }
                    break;
                case mb_strtolower($this->getMessage("\104\105\114\111\x56\105\x52\131\x5f\124\x59\120\x45\x5f\x50\x49\103\113\125\x50")):
                default:
                    
                    if ($this->syncItem()->getDeliveryId()) {
                        $mffug449wratnj2ooqe5isc2roz29z0fdj = $buoz62->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($this->syncItem()->getDeliveryId()));
                    }
            }
        }
        if (!is_null($mffug449wratnj2ooqe5isc2roz29z0fdj) && !empty($this->vkOrderDelivery["\x74\x72\x61\x63\x6b\137\156\x75\x6d\142\x65\162"]) && $this->vkOrderDelivery["\164\162\x61\143\153\137\156\165\155\x62\145\162"] != $mffug449wratnj2ooqe5isc2roz29z0fdj->getField("\124\122\101\x43\113\111\x4e\x47\x5f\x4e\x55\x4d\x42\x45\x52")) {
            $mffug449wratnj2ooqe5isc2roz29z0fdj->setField("\124\122\x41\x43\x4b\111\x4e\107\137\116\125\115\102\105\x52", $this->vkOrderDelivery["\164\x72\141\143\153\x5f\156\x75\x6d\x62\145\162"]);
        }
        
        $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_BEFORE_ORDER_UPDATE, ["\x6f\x72\x64\145\162" => $dob09zs7om7zpdgbmn9z, "\151\x74\145\155" => $this]);
        $jc7ai89g = $dob09zs7om7zpdgbmn9z->save();
        if (!$jc7ai89g->isSuccess()) {
            throw new \VKapi\Market\Exception\ORMException($jc7ai89g);
        }
        return $jc7ai89g->getId();
    }
    
    protected function preparePhone($jrje70uvulr3l37f3)
    {
        $jrje70uvulr3l37f3 = preg_replace("\57\x5b\x5e\x5c\144\x5d\53\x2f", "", $jrje70uvulr3l37f3);
        $bt2dtia3us6t78s8uu = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse("\x2b" . $jrje70uvulr3l37f3);
        
        if (!$bt2dtia3us6t78s8uu->isValid() || is_null($bt2dtia3us6t78s8uu->getCountry())) {
            $ck9e6athhhtik9dgltixunjejn43fy3rcv = preg_replace("\57\136\x30\x28\x5b\60\55\x39\x5d\x7b\71\x7d\x29\x24\57", "\x33\70\x30\134\61", $jrje70uvulr3l37f3);
            $bt2dtia3us6t78s8uu = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse("\x2b" . $ck9e6athhhtik9dgltixunjejn43fy3rcv);
        }
        
        if (!$bt2dtia3us6t78s8uu->isValid() || is_null($bt2dtia3us6t78s8uu->getCountry())) {
            $ck9e6athhhtik9dgltixunjejn43fy3rcv = preg_replace("\x2f\x5e\70\x28\x5b\x30\55\x39\x5d\173\61\x30\x7d\x29\x24\57", "\x37\x5c\x31", $jrje70uvulr3l37f3);
            $bt2dtia3us6t78s8uu = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse("\x2b" . $ck9e6athhhtik9dgltixunjejn43fy3rcv);
        }
        
        $jrje70uvulr3l37f3 = preg_replace("\x2f\136\x5c\53\57", "", $bt2dtia3us6t78s8uu->format(\Bitrix\Main\PhoneNumber\Format::E164));
        
        if (!$bt2dtia3us6t78s8uu->isValid() && strlen($jrje70uvulr3l37f3) == 10) {
            $bt2dtia3us6t78s8uu = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse("\x2b\x37" . $jrje70uvulr3l37f3);
            if ($bt2dtia3us6t78s8uu->isValid()) {
                $jrje70uvulr3l37f3 = preg_replace("\x2f\x5e\134\x2b\x2f", "", $bt2dtia3us6t78s8uu->format(\Bitrix\Main\PhoneNumber\Format::E164));
            }
        }
        return $jrje70uvulr3l37f3;
    }
    
    protected function isValidPhone($jrje70uvulr3l37f3)
    {
        $jrje70uvulr3l37f3 = $this->preparePhone($jrje70uvulr3l37f3);
        $bt2dtia3us6t78s8uu = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse("\53" . $jrje70uvulr3l37f3);
        if ($bt2dtia3us6t78s8uu->isValid()) {
            return true;
        }
        return false;
    }
    
    protected function findUserByPhone($jrje70uvulr3l37f3)
    {
        $jrje70uvulr3l37f3 = $this->preparePhone($this->vkOrderBuyerPhone);
        if (strlen(trim($jrje70uvulr3l37f3)) <= 0) {
            return false;
        }
        $jrkdwmyhfoc4x81zzok71aq2hww70p = ["\x50\x48\117\116\105\137\116\125\x4d\x42\x45\x52" => "\x2b" . $jrje70uvulr3l37f3];
        $yn9ex1 = \Bitrix\Main\UserTable::getList(["\154\151\x6d\x69\164" => 1, "\x6f\162\x64\145\162" => ["\x49\x44" => "\101\123\x43"], "\146\x69\x6c\164\x65\162" => $jrkdwmyhfoc4x81zzok71aq2hww70p, "\163\x65\154\145\143\x74" => ["\x49\104", "\x50\x48\x4f\x4e\x45\x5f\x4e\125\115\x42\105\x52" => "\120\110\117\116\105\x5f\101\125\124\110\x2e\120\x48\x4f\x4e\x45\x5f\x4e\x55\x4d\102\x45\122", "\101\x43\124\x49\126\105"]]);
        $pffcbov237apcg7wmtr2 = $yn9ex1->fetch();
        return $pffcbov237apcg7wmtr2;
    }
    
    public function isRequiredUserPhone()
    {
        static $jdvrqf7dhvb80n3uims0l;
        if (!isset($jdvrqf7dhvb80n3uims0l)) {
            $jdvrqf7dhvb80n3uims0l = \Bitrix\Main\Config\Option::get("\x6d\141\151\x6e", "\156\x65\x77\137\x75\163\145\x72\137\160\x68\x6f\x6e\145\x5f\x72\x65\161\165\151\162\145\144", "\x4e") == "\131";
        }
        return $jdvrqf7dhvb80n3uims0l;
    }
    
    protected function findOrCreateUserId()
    {
        $j9o64k6m7jibg1kfmhqv31jgotwj = [];
        $jrje70uvulr3l37f3 = $this->preparePhone($this->vkOrderBuyerPhone);
        if ($this->isValidPhone($jrje70uvulr3l37f3)) {
            
            $pffcbov237apcg7wmtr2 = $this->findUserByPhone($jrje70uvulr3l37f3);
            if ($pffcbov237apcg7wmtr2) {
                return $pffcbov237apcg7wmtr2["\x49\104"];
            }
            $j9o64k6m7jibg1kfmhqv31jgotwj["\x50\x48\x4f\x4e\x45\137\x4e\125\115\x42\x45\122"] = "\x2b" . $jrje70uvulr3l37f3;
        } elseif ($this->isRequiredUserPhone()) {
            
            $j9o64k6m7jibg1kfmhqv31jgotwj["\x50\110\117\x4e\x45\x5f\116\x55\x4d\x42\105\x52"] = "\53\67\x39\71\x39\71\71\71\71\71\x39\x39";
        }
        
        $yn9ex1 = \Bitrix\Main\UserTable::getList(["\x6c\151\155\151\164" => 1, "\146\151\x6c\x74\145\162" => ["\x58\x4d\x4c\x5f\x49\104" => "\166\153\141\x70\151\x5f\155\x61\x72\153\x65\164\137\x75\163\145\162\x5f" . $this->vkOrderUserId], "\x73\145\154\145\x63\x74" => ["\x49\x44"]]);
        if ($pffcbov237apcg7wmtr2 = $yn9ex1->fetch()) {
            return $pffcbov237apcg7wmtr2["\111\104"];
        }
        
        $oevw66w25dk8rgsid2h9x21rmp = explode("\x20", $this->vkOrderBuyerName);
        $oevw66w25dk8rgsid2h9x21rmp = array_map("\164\162\151\155", $oevw66w25dk8rgsid2h9x21rmp);
        $oevw66w25dk8rgsid2h9x21rmp = array_values(array_diff($oevw66w25dk8rgsid2h9x21rmp, [""]));
        if (count($oevw66w25dk8rgsid2h9x21rmp) > 2) {
            $j9o64k6m7jibg1kfmhqv31jgotwj["\x4e\101\115\105"] = $oevw66w25dk8rgsid2h9x21rmp[0];
            $j9o64k6m7jibg1kfmhqv31jgotwj["\114\101\123\x54\137\116\x41\115\105"] = $oevw66w25dk8rgsid2h9x21rmp[1];
            $j9o64k6m7jibg1kfmhqv31jgotwj["\x53\105\x43\x4f\x4e\104\x5f\x4e\x41\115\x45"] = $oevw66w25dk8rgsid2h9x21rmp[2];
        } elseif (count($oevw66w25dk8rgsid2h9x21rmp) > 1) {
            $j9o64k6m7jibg1kfmhqv31jgotwj["\116\101\115\105"] = $oevw66w25dk8rgsid2h9x21rmp[0];
            $j9o64k6m7jibg1kfmhqv31jgotwj["\114\x41\123\124\137\116\x41\x4d\x45"] = $oevw66w25dk8rgsid2h9x21rmp[1];
        } elseif (count($oevw66w25dk8rgsid2h9x21rmp) > 0) {
            $j9o64k6m7jibg1kfmhqv31jgotwj["\x4e\x41\x4d\x45"] = $oevw66w25dk8rgsid2h9x21rmp[0];
        }
        $jja0c1no6pc9cwo1w8nuv1 = $this->createUser($j9o64k6m7jibg1kfmhqv31jgotwj);
        return $jja0c1no6pc9cwo1w8nuv1;
    }
    
    protected function createUser($fdvewfhxzb5gde)
    {
        global $APPLICATION, $DB;
        $APPLICATION->ResetException();
        $k8kxlc58hntmjlgyoxq9nctp1 = \Bitrix\Main\Security\Random::getString(10) . "\x40\x6c\x6f\x63\141\x6c\x2e\154\x6f\143";
        $th0ly151tih9b4wc0bwowksuxsz = md5(uniqid() . \CMain::GetServerUniqID());
        $fdvewfhxzb5gde = array_merge(["\103\110\105\x43\x4b\x57\117\x52\x44" => \Bitrix\Main\Security\Password::hash($th0ly151tih9b4wc0bwowksuxsz), "\x7e\103\110\x45\103\x4b\127\117\x52\x44\x5f\x54\x49\x4d\x45" => $DB->CurrentTimeFunction(), "\105\115\101\111\x4c" => $k8kxlc58hntmjlgyoxq9nctp1, "\x41\103\x54\111\x56\105" => "\131", "\116\101\115\105" => "", "\x58\115\114\137\x49\x44" => "\x76\153\x61\x70\x69\137\155\141\162\153\145\164\x5f\x75\x73\x65\x72\x5f" . (int) $this->vkOrderUserId, "\x4c\101\x53\124\x5f\116\101\x4d\105" => "", "\x53\x49\124\x45\137\x49\x44" => $this->syncItem()->getSiteId(), "\x4c\x41\x4e\107\x55\x41\107\x45\x5f\x49\x44" => LANGUAGE_ID], $fdvewfhxzb5gde);
        
        if (!isset($fdvewfhxzb5gde["\x47\x52\x4f\x55\x50\137\111\104"])) {
            $dz7qp6te6m4 = \COption::GetOptionString("\155\141\x69\156", "\156\145\167\137\165\163\x65\162\137\162\145\147\x69\163\x74\162\x61\164\x69\157\156\137\144\145\146\137\147\x72\157\x75\160", "");
            if ($dz7qp6te6m4 != "") {
                $fdvewfhxzb5gde["\107\x52\117\125\120\137\x49\x44"] = explode("\x2c", $dz7qp6te6m4);
            } else {
                $fdvewfhxzb5gde["\107\122\117\x55\120\x5f\111\104"] = [];
            }
        }
        $fdvewfhxzb5gde["\120\101\123\123\x57\117\122\104"] = $fdvewfhxzb5gde["\x43\117\x4e\106\111\122\115\x5f\120\101\123\123\x57\x4f\x52\x44"] = \CUser::GeneratePasswordByPolicy($fdvewfhxzb5gde["\107\122\x4f\125\120\137\x49\104"]);
        foreach (GetModuleEvents("\x76\153\x61\160\x69\x2e\x6d\x61\162\153\145\164", "\x4f\x6e\x42\x65\x66\157\x72\x65\x55\x73\x65\x72\101\144\x64", true) as $d053iefa9mp48ojlcjzf1dz18) {
            if (ExecuteModuleEventEx($d053iefa9mp48ojlcjzf1dz18, [&$fdvewfhxzb5gde]) === false) {
                
            }
        }
        $f8naxz7ucy1ynaaj0kfbhkjsxvrisx9p = false;
        if (!is_set($fdvewfhxzb5gde, "\114\x4f\107\x49\x4e")) {
            $fdvewfhxzb5gde["\x4c\117\x47\111\116"] = \Bitrix\Main\Security\Random::getString(50);
            $f8naxz7ucy1ynaaj0kfbhkjsxvrisx9p = true;
        }
        $fdvewfhxzb5gde["\x4c\x49\x44"] = $fdvewfhxzb5gde["\123\111\x54\x45\x5f\111\x44"];
        $fdvewfhxzb5gde["\x43\110\105\103\113\x57\x4f\x52\x44"] = $th0ly151tih9b4wc0bwowksuxsz;
        $jja0c1no6pc9cwo1w8nuv1 = (int) $this->oldUser()->add($fdvewfhxzb5gde);
        if (!$jja0c1no6pc9cwo1w8nuv1) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x45\122\x52\117\122\x5f\103\122\x45\x41\124\x45\137\x55\x53\105\122", ["\x23\x4d\x53\x47\x23" => $this->oldUser()->LAST_ERROR]), "\x45\x52\x52\117\x52\x5f\103\x52\x45\x41\x54\x45\x5f\x55\x53\105\x52", ["\x76\153\x4f\162\144\145\x72\x49\x64" => $this->vkOrderDisplayId, "\141\x72\x46\151\145\154\x64\x73" => $fdvewfhxzb5gde]);
        }
        if ($f8naxz7ucy1ynaaj0kfbhkjsxvrisx9p) {
            $this->oldUser()->Update($jja0c1no6pc9cwo1w8nuv1, ["\114\x4f\107\111\x4e" => "\x75\x73\x65\x72" . $jja0c1no6pc9cwo1w8nuv1]);
            $fdvewfhxzb5gde["\x4c\117\107\x49\x4e"] = "\165\163\145\x72" . $jja0c1no6pc9cwo1w8nuv1;
        }
        
        if ($fdvewfhxzb5gde["\105\x4d\101\x49\114"] == $k8kxlc58hntmjlgyoxq9nctp1) {
            $DB->Query("\125\x50\104\x41\x54\x45\x20\142\x5f\165\163\x65\x72\x20\x53\105\124\x20\105\115\101\111\114\x3d\47\x27\40\x57\x48\x45\x52\x45\40\111\x44\x3d" . $jja0c1no6pc9cwo1w8nuv1);
            $fdvewfhxzb5gde["\x45\x4d\x41\111\x4c"] = "";
        }
        
        if ($this->isRequiredUserPhone() && $fdvewfhxzb5gde["\120\110\117\x4e\x45\137\x4e\x55\115\102\x45\122"] == "\x2b\67\x39\71\71\71\71\x39\71\x39\x39\71") {
            $this->deleteTemporaryPhone($jja0c1no6pc9cwo1w8nuv1);
        }
        $fdvewfhxzb5gde["\x55\123\105\x52\x5f\111\104"] = $jja0c1no6pc9cwo1w8nuv1;
        $nowv5dbguwk5aad9050raazbgh2l = $fdvewfhxzb5gde;
        unset($nowv5dbguwk5aad9050raazbgh2l["\120\x41\123\x53\x57\117\122\x44"]);
        unset($nowv5dbguwk5aad9050raazbgh2l["\x43\117\116\106\111\x52\115\137\120\101\x53\123\127\x4f\x52\104"]);
        foreach (GetModuleEvents("\166\x6b\141\x70\x69\56\155\141\162\x6b\x65\x74", "\x4f\156\101\146\164\145\162\x55\163\145\162\x41\144\144", true) as $d053iefa9mp48ojlcjzf1dz18) {
            if (ExecuteModuleEventEx($d053iefa9mp48ojlcjzf1dz18, [&$fdvewfhxzb5gde]) === false) {
                
            }
        }
        return $jja0c1no6pc9cwo1w8nuv1;
    }
    
    public function deleteTemporaryPhone($jja0c1no6pc9cwo1w8nuv1 = 0)
    {
        $gj3txc8j92d83c8yl94eah3rtt = ["\120\x48\x4f\x4e\x45\x5f\116\x55\x4d\102\x45\122" => "\53\67\x39\x39\x39\71\x39\71\x39\71\x39\x39"];
        if ($jja0c1no6pc9cwo1w8nuv1 > 0) {
            $gj3txc8j92d83c8yl94eah3rtt["\125\123\105\122\x5f\111\104"] = $jja0c1no6pc9cwo1w8nuv1;
        }
        $n8x76cvzpajf9k0qt8b6443ey = \Bitrix\Main\UserPhoneAuthTable::getList(["\x73\x65\154\x65\143\x74" => ["\x49\x44"], "\x66\151\x6c\x74\x65\x72" => $gj3txc8j92d83c8yl94eah3rtt]);
        if ($v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs = $n8x76cvzpajf9k0qt8b6443ey->fetch()) {
            \Bitrix\Main\UserPhoneAuthTable::delete($v09mhmla3k7hw6hjj7rqmuxhc8zzl4h31cs["\x49\x44"]);
        }
    }
    
    public function createSaleFUser($jja0c1no6pc9cwo1w8nuv1)
    {
        
        global $DB;
        $jja0c1no6pc9cwo1w8nuv1 = intval($jja0c1no6pc9cwo1w8nuv1);
        if (!$jja0c1no6pc9cwo1w8nuv1) {
            return 0;
        }
        $w10kn91nsm6qfnlz0f4vl6kk9g5ld5 = \CSaleUser::GetList(["\125\123\x45\122\137\x49\x44" => $jja0c1no6pc9cwo1w8nuv1]);
        if (!empty($w10kn91nsm6qfnlz0f4vl6kk9g5ld5)) {
            return $w10kn91nsm6qfnlz0f4vl6kk9g5ld5["\111\104"];
        }
        $fdvewfhxzb5gde = ["\x3d\x44\x41\x54\105\137\x49\116\123\x45\122\124" => $DB->GetNowFunction(), "\x3d\104\101\x54\105\x5f\125\x50\x44\101\124\x45" => $DB->GetNowFunction(), "\125\x53\x45\122\x5f\x49\104" => $jja0c1no6pc9cwo1w8nuv1, "\103\117\x44\105" => md5(time() . \Bitrix\Main\Security\Random::getString(10, true))];
        $r1gzwc07q3nwx9el = (int) \CSaleUser::_Add($fdvewfhxzb5gde);
        return $r1gzwc07q3nwx9el;
    }
    
    public function getProductByVkOrderItem($avv26eg5ep97u7un7ok59rq6888qs6q)
    {
        if (!isset($avv26eg5ep97u7un7ok59rq6888qs6q["\x69\x74\x65\155"])) {
            return null;
        }
        $efiknlu0oqe3axdbjdr4w = (int) $avv26eg5ep97u7un7ok59rq6888qs6q["\151\164\x65\x6d"]["\x69\144"];
        $tbyb13tqi6xelnu8dqpu = abs((int) $avv26eg5ep97u7un7ok59rq6888qs6q["\x69\x74\x65\x6d"]["\157\167\x6e\x65\162\x5f\151\144"]);
        $e3bjma865ou0o274pa3w6xl2n9 = new \VKapi\Market\Export\History\Good();
        $rp0q5719zg75dv9kbq1v = $e3bjma865ou0o274pa3w6xl2n9->findElementByVkIdGroupId($efiknlu0oqe3axdbjdr4w, $tbyb13tqi6xelnu8dqpu);
        if (!$rp0q5719zg75dv9kbq1v) {
            return null;
        }
        $w06qefa881q4fa = ["\111\x44" => $rp0q5719zg75dv9kbq1v["\111\x44"], "\116\x41\115\105" => $rp0q5719zg75dv9kbq1v["\116\x41\x4d\x45"] ?? $avv26eg5ep97u7un7ok59rq6888qs6q["\x69\x74\x65\155"]["\x6e\141\x6d\x65"], "\120\x52\x49\103\x45" => (int) $avv26eg5ep97u7un7ok59rq6888qs6q["\x70\162\x69\x63\145"]["\141\x6d\157\x75\x6e\164"] / 100, "\x43\125\122\122\105\x4e\x43\131" => (string) $avv26eg5ep97u7un7ok59rq6888qs6q["\160\162\x69\x63\145"]["\x63\x75\162\x72\145\156\143\171"]["\x6e\141\x6d\x65"], "\121\x55\x41\116\124\111\124\131" => (int) $avv26eg5ep97u7un7ok59rq6888qs6q["\161\x75\x61\156\x74\x69\164\x79"]];
        return $w06qefa881q4fa;
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