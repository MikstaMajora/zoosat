<?php

namespace VKapi\Market\Sale\Order\Sync;

use Bitrix\Main\Localization\Loc;
use VKapi\Market\Manager;
use VKapi\Market\Exception\BaseException;
use VKapi\Market\Exception\ORMException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Item
{
    protected $syncId = 0;
    protected $arSync = null;
    
    public function __construct($pjmgazv4wikruym104)
    {
        if (is_array($pjmgazv4wikruym104)) {
            $this->arSync = $pjmgazv4wikruym104;
            $this->syncId = $pjmgazv4wikruym104["\x49\104"];
        } else {
            $this->loadSyncData((int) $pjmgazv4wikruym104);
        }
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function loadSyncData($abw89g7okli7)
    {
        $this->syncId = intval($abw89g7okli7);
        $ai5mqdk95cwmik = \VKapi\Market\Sale\Order\SyncTable::getById($abw89g7okli7)->fetch();
        if (!$ai5mqdk95cwmik) {
            throw new \VKapi\Market\Exception\BaseException($this->manager()->getMessage("\114\111\x42\x2e\123\x41\114\105\56\x4f\122\104\105\x52\56\123\131\x4e\103\56\111\124\105\115\56\123\x59\116\x43\137\x49\x44\137\116\117\124\137\106\x4f\125\116\104", ["\x23\x49\104\x23" => $abw89g7okli7]), "\105\122\x52\x4f\122\x5f\x53\x41\114\x45\x5f\x4f\122\x44\x45\122\x5f\x53\131\116\x43\x5f\x49\x54\x45\115\137\111\x44\137\x4e\117\x54\x5f\106\117\125\x4e\104");
        }
        $this->arSync = $ai5mqdk95cwmik;
    }
    public function isActive()
    {
        return (bool) $this->arSync["\101\x43\x54\x49\126\x45"];
    }
    
    public function getId()
    {
        return (int) $this->syncId;
    }
    
    public function getAccountId()
    {
        return (int) $this->arSync["\101\103\x43\117\x55\x4e\124\x5f\x49\x44"];
    }
    
    public function getGroupId()
    {
        return (int) $this->arSync["\x47\x52\x4f\125\120\x5f\111\104"];
    }
    
    public function isEventEnabled()
    {
        return (bool) $this->arSync["\105\126\105\116\124\x5f\105\x4e\101\102\x4c\105\104"];
    }
    
    public function getEventSecret()
    {
        return $this->arSync["\x45\x56\x45\x4e\124\x5f\x53\105\x43\122\x45\x54"];
    }
    
    public function getEventCode()
    {
        return $this->arSync["\105\126\105\x4e\x54\137\x43\x4f\104\x45"];
    }
    
    public function getGroupAccessToken()
    {
        return $this->arSync["\x47\122\117\x55\120\x5f\x41\103\x43\x45\x53\x53\x5f\124\x4f\113\105\x4e"];
    }
    
    public function getSiteId()
    {
        return $this->arSync["\x53\111\x54\105\x5f\111\x44"];
    }
    
    public function getPersonalTypeId()
    {
        return (int) $this->manager()->getParam("\120\105\x52\123\117\116\101\114\x5f\124\131\x50\105", 0, $this->getSiteId());
    }
    
    public function getDeliveryId()
    {
        return (int) $this->manager()->getParam("\104\x45\x4c\111\x56\105\122\x59\x5f\x49\x44", 0, $this->getSiteId());
    }
    
    public function getDeliveryIdCourier()
    {
        return (int) $this->manager()->getParam("\x44\105\x4c\x49\x56\105\x52\131\137\x49\104\137\x43\x4f\125\x52\x49\x45\122", 0, $this->getSiteId());
    }
    
    public function getDeliveryIdPochta()
    {
        return (int) $this->manager()->getParam("\104\x45\x4c\x49\x56\x45\122\131\x5f\111\104\137\x50\x4f\103\110\x54\x41", 0, $this->getSiteId());
    }
    
    public function getDeliveryIdPoint()
    {
        return (int) $this->manager()->getParam("\104\x45\x4c\111\x56\x45\x52\x59\137\111\x44\x5f\120\117\x49\116\x54", 0, $this->getSiteId());
    }
    
    public function getPaymentId()
    {
        return (int) $this->manager()->getParam("\x50\x41\131\115\105\x4e\x54\137\111\104", 0, $this->getSiteId());
    }
    
    public function getFioPropertyId()
    {
        return (int) $this->manager()->getParam("\123\x41\114\x45\x5f\120\x52\117\120\x45\122\x54\x59\x5f\x46\111\117", 0, $this->getSiteId());
    }
    
    public function getPhonePropertyId()
    {
        return (int) $this->manager()->getParam("\x53\101\x4c\105\137\x50\122\x4f\x50\105\x52\x54\131\x5f\x50\x48\117\x4e\x45", 0, $this->getSiteId());
    }
    
    public function getAddressPropertyId()
    {
        return (int) $this->manager()->getParam("\123\x41\114\105\x5f\x50\122\x4f\120\x45\122\x54\131\x5f\x41\x44\104\122\x45\123\x53", 0, $this->getSiteId());
    }
    
    public function getVkOrderPropertyId()
    {
        return (int) $this->manager()->getParam("\123\101\114\x45\x5f\x50\122\x4f\x50\105\122\x54\x59\137\126\x4b\x4f\x52\x44\x45\122", 0, $this->getSiteId());
    }
    
    public function getCommentForUserPropertyId()
    {
        return (int) $this->manager()->getParam("\x53\101\114\105\x5f\x50\x52\117\120\105\122\124\131\137\103\117\x4d\x4d\105\116\124\137\106\x4f\x52\x5f\x55\123\105\122", 0, $this->getSiteId());
    }
    
    public function getWidthPropertyId()
    {
        return (int) $this->manager()->getParam("\x53\x41\x4c\105\x5f\x50\x52\x4f\x50\105\122\x54\x59\137\127\111\x44\124\110", 0, $this->getSiteId());
    }
    
    public function getHeightPropertyId()
    {
        return (int) $this->manager()->getParam("\123\x41\x4c\x45\137\120\122\x4f\x50\x45\122\124\x59\137\x48\x45\x49\107\x48\124", 0, $this->getSiteId());
    }
    
    public function getLengthPropertyId()
    {
        return (int) $this->manager()->getParam("\x53\101\114\105\x5f\120\122\117\120\105\x52\124\x59\x5f\114\x45\116\107\124\x48", 0, $this->getSiteId());
    }
    
    public function getWeightPropertyId()
    {
        return (int) $this->manager()->getParam("\x53\x41\114\105\x5f\120\x52\117\x50\x45\122\x54\131\x5f\x57\105\x49\x47\x48\124", 0, $this->getSiteId());
    }
    
    public function getStatusIdByVkStatus($lby9vnma0xohnjzpmgm58b0sxku)
    {
        switch (intval($lby9vnma0xohnjzpmgm58b0sxku)) {
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                return $this->manager()->getParam("\123\x54\x41\x54\x55\123\x5f" . intval($lby9vnma0xohnjzpmgm58b0sxku), "", $this->getSiteId());
                break;
        }
        return "";
    }
    
    public function getVkStatusByStatusId($l8a3zyvzdqjd8qd1t)
    {
        $l4j5q7y8wxlifxs1 = [];
        for ($w16wq39ss = 0; $w16wq39ss <= 6; $w16wq39ss++) {
            $k4kgop2xnhkxz9r1yv9 = $this->manager()->getParam("\x53\x54\101\124\125\123\137" . $w16wq39ss, "", $this->getSiteId());
            if (!empty($k4kgop2xnhkxz9r1yv9)) {
                $l4j5q7y8wxlifxs1[$k4kgop2xnhkxz9r1yv9] = $w16wq39ss;
            }
        }
        if (isset($l4j5q7y8wxlifxs1[$l8a3zyvzdqjd8qd1t])) {
            return $l4j5q7y8wxlifxs1[$l8a3zyvzdqjd8qd1t];
        }
        return null;
    }
}
?>