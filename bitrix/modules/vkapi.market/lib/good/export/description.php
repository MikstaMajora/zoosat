<?php

namespace VKapi\Market\Good\Export;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Description
{
    
    protected $oExportItem = null;
    
    const EOL = "\12";
    public function __construct(\VKapi\Market\Export\Item $ltxc6yup)
    {
        $this->oExportItem = $ltxc6yup;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    public function replaceEOL($hzbyqmp20g0op1ppulny9mv2y9e)
    {
        return preg_replace("\57\15\12\57", "\xa", $hzbyqmp20g0op1ppulny9mv2y9e);
    }
    
    public function removeBrPlaceholder($hzbyqmp20g0op1ppulny9mv2y9e)
    {
        return preg_replace("\57\173\x42\x52\175\57\x6d", self::EOL, $hzbyqmp20g0op1ppulny9mv2y9e);
    }
    
    public function removeEmptyBlock($hzbyqmp20g0op1ppulny9mv2y9e)
    {
        
        if (preg_match_all("\x2f\50\x5c\133\x5b\x5e\134\135\x5d\53\x5c\135\52\x29\57\x6d", $hzbyqmp20g0op1ppulny9mv2y9e, $rv70z97c3n8lq12h2h4t0xyohtyan5l5c)) {
            $rv70z97c3n8lq12h2h4t0xyohtyan5l5c = array_unique($rv70z97c3n8lq12h2h4t0xyohtyan5l5c[1]);
            foreach ($rv70z97c3n8lq12h2h4t0xyohtyan5l5c as $mabqfdcv4qk5gj3rhkg0zrg6pxtiy7epw => $hey41cy5yxj6ujpht) {
                
                if (strpos($hey41cy5yxj6ujpht, "\x7b\104\x45\114\x7d") !== false) {
                    
                    $hzbyqmp20g0op1ppulny9mv2y9e = preg_replace("\176\50\134\133" . trim($hey41cy5yxj6ujpht, "\x5b\135") . "\x5c\135\x5b\12\x5d\x2a\51\176", "", $hzbyqmp20g0op1ppulny9mv2y9e);
                } elseif (preg_match("\57\134\x7b\x42\122\x5c\175\134\x73\x2a\134\135\57", $hey41cy5yxj6ujpht, $griwj4jxxzx9avhl6)) {
                    $hzbyqmp20g0op1ppulny9mv2y9e = str_replace($hey41cy5yxj6ujpht, trim(preg_replace("\57\x5c\x7b\102\122\x5c\x7d\134\163\x2a\134\x5d\57", "\x7b\102\122\x7d", $hey41cy5yxj6ujpht), "\x5b\x5d"), $hzbyqmp20g0op1ppulny9mv2y9e);
                } else {
                    $hzbyqmp20g0op1ppulny9mv2y9e = str_replace($hey41cy5yxj6ujpht, trim($hey41cy5yxj6ujpht, "\133\135"), $hzbyqmp20g0op1ppulny9mv2y9e);
                }
            }
        }
        
        $hzbyqmp20g0op1ppulny9mv2y9e = str_replace("\173\x44\105\x4c\175", "", $hzbyqmp20g0op1ppulny9mv2y9e);
        return $hzbyqmp20g0op1ppulny9mv2y9e;
    }
    
    public function removeDoubleSpace($hzbyqmp20g0op1ppulny9mv2y9e)
    {
        $hzbyqmp20g0op1ppulny9mv2y9e = str_replace("\46\x6e\x62\x73\160\73", "\40", $hzbyqmp20g0op1ppulny9mv2y9e);
        $hzbyqmp20g0op1ppulny9mv2y9e = preg_replace("\57\x28\x5b\x5c\170\62\x30\x5d\x2b\51\57", "\40", $hzbyqmp20g0op1ppulny9mv2y9e);
        return $hzbyqmp20g0op1ppulny9mv2y9e;
    }
    
    public function getProductText($kvhk1d59t8siivfis3p1zica314t)
    {
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->exportItem()->getProductTemplate();
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->replaceEOL($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        if (preg_match_all("\x2f\50\134\x7b\133\136\x7d\x5d\x2b\x5c\x7d\x29\x2f\x6d", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $rv70z97c3n8lq12h2h4t0xyohtyan5l5c)) {
            $h8sl81206ugu6xsw9zsvo4 = array_unique($rv70z97c3n8lq12h2h4t0xyohtyan5l5c[1]);
            unset($rv70z97c3n8lq12h2h4t0xyohtyan5l5c);
            [$g008as6ax1j, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $kvhk1d59t8siivfis3p1zica314t, $h8sl81206ugu6xsw9zsvo4] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_BEFORE_PRODUCT_DESCRIPTION, array("\141\x72\105\x78\160\157\162\x74\x44\141\x74\141" => $this->exportItem()->getData(), "\164\145\x6d\x70\154\141\x74\x65" => $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, "\141\x72\104\141\x74\x61" => $kvhk1d59t8siivfis3p1zica314t, "\141\x72\120\x6c\141\x63\x65\x68\157\154\144\145\x72\x73" => $h8sl81206ugu6xsw9zsvo4), true);
            unset($g008as6ax1j);
            foreach ($h8sl81206ugu6xsw9zsvo4 as $q6sl44122or) {
                $uz7l6557u7jryg50xpql6nc27y65 = trim($q6sl44122or, "\173\175");
                if ($uz7l6557u7jryg50xpql6nc27y65 == "\x42\122") {
                    
                } elseif ($uz7l6557u7jryg50xpql6nc27y65 == "\x45\115\x50\124\131") {
                    
                    $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, PHP_EOL . PHP_EOL, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                } else {
                    
                    if (array_key_exists($uz7l6557u7jryg50xpql6nc27y65, $kvhk1d59t8siivfis3p1zica314t) && strlen(trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]))) {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]), $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    } else {
                        
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, "\x7b\x44\x45\x4c\x7d", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    }
                }
            }
        }
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->removeEmptyBlock($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->removeBrPlaceholder($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->removeDoubleSpace($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = trim($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, "\x9\15\12\x5c\163");
        return $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx;
    }
    
    public function getOffersText($kvhk1d59t8siivfis3p1zica314t, $k0r1x2iz0o48kdynq4dw31ukdx2z40u)
    {
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = "";
        if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
            $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx .= $this->getOfferContentBefore($kvhk1d59t8siivfis3p1zica314t, $k0r1x2iz0o48kdynq4dw31ukdx2z40u);
            foreach ($k0r1x2iz0o48kdynq4dw31ukdx2z40u as $bhfdcy11574kiuydwm7wv) {
                $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx .= $this->getOfferContent($kvhk1d59t8siivfis3p1zica314t, $bhfdcy11574kiuydwm7wv);
            }
            $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx .= $this->getOfferContentAfter($kvhk1d59t8siivfis3p1zica314t, $k0r1x2iz0o48kdynq4dw31ukdx2z40u);
        } else {
            $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx .= $this->getOfferContent($kvhk1d59t8siivfis3p1zica314t, reset($k0r1x2iz0o48kdynq4dw31ukdx2z40u));
        }
        
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->removeEmptyBlock($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->removeBrPlaceholder($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->removeDoubleSpace($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = trim($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, "\11\xd\xa\134\x73");
        return $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx;
    }
    
    public function getOfferContent($kvhk1d59t8siivfis3p1zica314t, $bhfdcy11574kiuydwm7wv)
    {
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->exportItem()->getOfferTemplate();
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->replaceEOL($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        
        if (preg_match_all("\x2f\x28\134\x7b\x5b\136\x7d\x5d\53\134\175\51\x2f\x6d", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $rv70z97c3n8lq12h2h4t0xyohtyan5l5c)) {
            $h8sl81206ugu6xsw9zsvo4 = array_unique($rv70z97c3n8lq12h2h4t0xyohtyan5l5c[1]);
            unset($rv70z97c3n8lq12h2h4t0xyohtyan5l5c);
            [$g008as6ax1j, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $kvhk1d59t8siivfis3p1zica314t, $h8sl81206ugu6xsw9zsvo4, $bhfdcy11574kiuydwm7wv] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_BEFORE_OFFER_DESCRIPTION, array("\141\x72\105\170\x70\x6f\162\164\104\x61\164\141" => $this->exportItem()->getData(), "\164\x65\x6d\x70\154\x61\x74\x65" => $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, "\x61\162\104\141\x74\141" => $kvhk1d59t8siivfis3p1zica314t, "\x61\x72\120\154\141\143\x65\x68\157\x6c\x64\x65\162\x73" => $h8sl81206ugu6xsw9zsvo4, "\x61\x72\117\146\146\x65\162" => $bhfdcy11574kiuydwm7wv), true);
            unset($g008as6ax1j);
            
            foreach ($h8sl81206ugu6xsw9zsvo4 as $q6sl44122or) {
                $uz7l6557u7jryg50xpql6nc27y65 = trim($q6sl44122or, "\x7b\175");
                if ($q6sl44122or == "\173\102\122\x7d") {
                    
                } elseif ($q6sl44122or == "\173\105\x4d\x50\124\x59\175") {
                    
                    $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, self::EOL . self::EOL, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                } else {
                    if (isset($bhfdcy11574kiuydwm7wv[$uz7l6557u7jryg50xpql6nc27y65]) && strlen(trim($bhfdcy11574kiuydwm7wv[$uz7l6557u7jryg50xpql6nc27y65]))) {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, trim($bhfdcy11574kiuydwm7wv[$uz7l6557u7jryg50xpql6nc27y65]), $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    } elseif (isset($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]) && strlen(trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]))) {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]), $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    } else {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, "\173\104\x45\114\x7d", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    }
                }
            }
        }
        return $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx;
    }
    
    public function getOfferContentBefore($kvhk1d59t8siivfis3p1zica314t, $k0r1x2iz0o48kdynq4dw31ukdx2z40u)
    {
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->exportItem()->getOfferTemplateBefore();
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->replaceEOL($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        
        if (preg_match_all("\57\x28\x5c\x7b\x5b\x5e\x7d\135\53\134\x7d\x29\57\x6d", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $rv70z97c3n8lq12h2h4t0xyohtyan5l5c)) {
            $h8sl81206ugu6xsw9zsvo4 = array_unique($rv70z97c3n8lq12h2h4t0xyohtyan5l5c[1]);
            unset($rv70z97c3n8lq12h2h4t0xyohtyan5l5c);
            [$g008as6ax1j, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $kvhk1d59t8siivfis3p1zica314t, $h8sl81206ugu6xsw9zsvo4, $k0r1x2iz0o48kdynq4dw31ukdx2z40u] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_BEFORE_OFFER_DESCRIPTION_BEFORE, array("\141\162\x45\170\160\x6f\x72\x74\104\x61\164\141" => $this->exportItem()->getData(), "\x74\x65\x6d\x70\x6c\x61\x74\145" => $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, "\141\162\x44\141\164\x61" => $kvhk1d59t8siivfis3p1zica314t, "\x61\162\x50\x6c\x61\143\145\150\x6f\154\144\145\x72\163" => $h8sl81206ugu6xsw9zsvo4, "\141\x72\117\146\x66\x65\x72\x4c\x69\163\x74" => $k0r1x2iz0o48kdynq4dw31ukdx2z40u), true);
            unset($g008as6ax1j);
            
            foreach ($h8sl81206ugu6xsw9zsvo4 as $q6sl44122or) {
                $uz7l6557u7jryg50xpql6nc27y65 = trim($q6sl44122or, "\173\x7d");
                if ($q6sl44122or == "\173\x42\x52\175") {
                    
                } elseif ($q6sl44122or == "\x7b\x45\x4d\120\124\x59\x7d") {
                    
                    $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, self::EOL . self::EOL, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                } else {
                    if (isset($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]) && strlen(trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]))) {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]), $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    } else {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, "\x7b\x44\x45\114\175", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    }
                }
            }
        }
        return $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx;
    }
    
    public function getOfferContentAfter($kvhk1d59t8siivfis3p1zica314t, $k0r1x2iz0o48kdynq4dw31ukdx2z40u)
    {
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->exportItem()->getOfferTemplateAfter();
        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = $this->replaceEOL($g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
        
        if (preg_match_all("\x2f\50\x5c\173\133\136\x7d\x5d\53\x5c\175\x29\x2f\155", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $rv70z97c3n8lq12h2h4t0xyohtyan5l5c)) {
            $h8sl81206ugu6xsw9zsvo4 = array_unique($rv70z97c3n8lq12h2h4t0xyohtyan5l5c[1]);
            unset($rv70z97c3n8lq12h2h4t0xyohtyan5l5c);
            [$g008as6ax1j, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, $kvhk1d59t8siivfis3p1zica314t, $h8sl81206ugu6xsw9zsvo4, $k0r1x2iz0o48kdynq4dw31ukdx2z40u] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_BEFORE_OFFER_DESCRIPTION_AFTER, array("\x61\162\105\170\x70\157\x72\x74\104\x61\164\141" => $this->exportItem()->getData(), "\164\x65\155\160\154\x61\x74\x65" => $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx, "\x61\162\x44\141\164\141" => $kvhk1d59t8siivfis3p1zica314t, "\x61\162\x50\154\141\143\x65\150\157\154\x64\x65\x72\x73" => $h8sl81206ugu6xsw9zsvo4, "\141\x72\117\146\146\145\162\x4c\x69\x73\164" => $k0r1x2iz0o48kdynq4dw31ukdx2z40u), true);
            unset($g008as6ax1j);
            
            foreach ($h8sl81206ugu6xsw9zsvo4 as $q6sl44122or) {
                $uz7l6557u7jryg50xpql6nc27y65 = trim($q6sl44122or, "\173\175");
                if ($q6sl44122or == "\x7b\102\122\x7d") {
                    
                } elseif ($q6sl44122or == "\x7b\105\x4d\x50\124\x59\x7d") {
                    
                    $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, self::EOL . self::EOL, $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                } else {
                    if (isset($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]) && strlen(trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]))) {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, trim($kvhk1d59t8siivfis3p1zica314t[$uz7l6557u7jryg50xpql6nc27y65]), $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    } else {
                        $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx = str_replace($q6sl44122or, "\173\104\105\114\x7d", $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx);
                    }
                }
            }
        }
        return $g42l5dq1xko6qj0kpy6h9m7sznu2v1f41hx;
    }
}
?>