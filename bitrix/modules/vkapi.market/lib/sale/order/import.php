<?php

namespace VKapi\Market\Sale\Order;

use Bitrix\Main\Localization\Loc;
use VKapi\Market\Connect;
use VKapi\Market\Manager;
use VKapi\Market\Exception\BaseException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Import
{
    public function __construct()
    {
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function sync()
    {
        if (!isset($this->oSync)) {
            $this->oSync = new \VKapi\Market\Sale\Order\Sync();
        }
        return $this->oSync;
    }
    
    public function getMessage($asbbk09n38dkzicxcn196pxyy, $uorm4uhi = null)
    {
        return $this->manager()->getMessage("\x4c\x49\102\x2e\x53\x41\x4c\x45\x2e\x4f\122\x44\x45\x52\x2e\x49\115\x50\117\x52\124\x2e" . $asbbk09n38dkzicxcn196pxyy, $uorm4uhi);
    }
    
    public function showImportByHand()
    {
        \CUtil::InitJSCore("\x6a\x71\165\145\162\x79");
        $ux0ks3czd0c9kt7ktaekjoft4gcrjgb19p = \Bitrix\Main\Security\Random::getString(10);
        $k6jf2de663fthgmqc6 = "\x76\153\x61\160\151\55\155\x61\162\153\145\x74\55\157\x72\x64\145\x72\x2d\151\155\x70\157\x72\x74\x2d\55" . $ux0ks3czd0c9kt7ktaekjoft4gcrjgb19p;
        
        echo "\x3c\x64\x69\x76\40\143\154\x61\x73\163\x3d\42\x76\x6b\141\x70\x69\55\x6d\x61\162\153\x65\x74\55\157\162\x64\x65\162\55\x69\x6d\x70\157\x72\x74\42\40\x69\144\x3d\42" . $k6jf2de663fthgmqc6 . "\42\76\x3c\57\144\x69\166\x3e";
        
        $iy4fwxq5etq1b83jf77 = ["\x69\x74\145\155\x73" => $this->getSyncSettingsListForJs()];
        
        ?>
        <script type="text/javascript" class="vkapi-market-data">
            (function () {
                window.VKapiMarketOrderImportParams = <?php 
        echo \Bitrix\Main\Web\Json::encode($iy4fwxq5etq1b83jf77);
        ?>;
                window.VKapiMarketOrderImportJs = window.VKapiMarketOrderImportJs || {};
                window.VKapiMarketOrderImportJs['<?php 
        echo $k6jf2de663fthgmqc6;
        ?>'] = new VKapiMarketOrderImport('<?php 
        echo $k6jf2de663fthgmqc6;
        ?>', window.VKapiMarketOrderImportParams);
            })();
        </script>
        <?php 
    }
    
    public function getSyncSettingsListForJs()
    {
        $gicuvkskpuwr53xgm3ud8u3eup = [];
        $ahva4gtr = $this->sync()->table()->getList(["\x6f\x72\144\145\162" => ["\x49\104" => "\x41\x53\103"], "\x66\x69\154\164\145\x72" => ["\101\x43\124\x49\126\105" => true]]);
        while ($k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk = $ahva4gtr->fetch()) {
            $gicuvkskpuwr53xgm3ud8u3eup[] = ["\x69\144" => (int) $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\111\104"], "\x6e\x61\155\x65" => sprintf("\x5b\x25\x73\135\40\x25\163\40\50\x25\163\51", $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\x49\x44"], $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\107\122\117\125\120\137\116\101\x4d\105"], $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\107\122\117\x55\120\x5f\x49\104"]), "\147\162\x6f\x75\160\x49\144" => (int) $k8dxh3ou6s2y7xw9fff8e5pv14ht6lkxhk["\107\x52\x4f\125\x50\137\x49\x44"]];
        }
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
    
    public function item($oelkrc)
    {
        $oelkrc = intval($oelkrc);
        if (!isset($this->arItems[$oelkrc])) {
            $this->arItems[$oelkrc] = new \VKapi\Market\Sale\Order\Import\Item($oelkrc);
        }
        return $this->arItems[$oelkrc];
    }
}
?>