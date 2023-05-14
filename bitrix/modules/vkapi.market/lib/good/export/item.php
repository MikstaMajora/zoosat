<?php

namespace VKapi\Market\Good\Export;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Item
{
    const PROPERTY_TYPE_L = "\x4c";
    
    const PROPERTY_TYPE_S = "\x53";
    
    const PROPERTY_TYPE_N = "\x4e";
    
    const PROPERTY_TYPE_F = "\106";
    
    const PROPERTY_TYPE_G = "\x47";
    
    const PROPERTY_TYPE_E = "\105";
    
    protected $productId = 0;
    protected $arOffers = [];
    
    protected $oExportItem = null;
    
    protected $oGoodExportDescription = null;
    
    protected $oIblockElementOld = null;
    
    protected $oPhoto = null;
    
    protected $oPropertyVariantTable = null;
    
    protected $arCache = [];
    public function __construct($ze9alfzrxna3tl6, $f13u9, \VKapi\Market\Export\Item $c7epck1rrj7bjznlzt8b6z8fdiqog1)
    {
        if (!$this->manager()->isInstalledIblockModule()) {
            
        }
        $this->productId = intval($ze9alfzrxna3tl6);
        $f13u9 = (array) $f13u9;
        $f13u9 = array_map("\x69\156\x74\166\141\154", $f13u9);
        $f13u9 = array_values(array_unique($f13u9));
        if (empty($f13u9)) {
            $f13u9[] = 0;
        }
        $this->arOffers = $f13u9;
        $this->oExportItem = $c7epck1rrj7bjznlzt8b6z8fdiqog1;
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    public function description()
    {
        if (is_null($this->oGoodExportDescription)) {
            $this->oGoodExportDescription = new \VKapi\Market\Good\Export\Description($this->exportItem());
        }
        return $this->oGoodExportDescription;
    }
    
    public function iblockElementOld()
    {
        if (is_null($this->oIblockElementOld)) {
            $this->oIblockElementOld = new \CIBlockElement();
        }
        return $this->oIblockElementOld;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function goodReferenceAlbum()
    {
        return \VKapi\Market\Good\Reference\Album::getInstance();
    }
    
    public function photo()
    {
        if (is_null($this->oPhoto)) {
            $this->oPhoto = new \VKapi\Market\Export\Photo();
            $this->oPhoto->setExportItem($this->exportItem());
        }
        return $this->oPhoto;
    }
    
    public function propertyVariantTable()
    {
        if (is_null($this->oPropertyVariantTable)) {
            $this->oPropertyVariantTable = new \VKapi\Market\Property\VariantTable();
        }
        return $this->oPropertyVariantTable;
    }
    
    public function getMessage($bb0afkg, $isc6w2bmw7efogcbvz3a = [])
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\126\113\x41\x50\x49\x2e\x4d\x41\122\x4b\x45\x54\56\x47\117\x4f\x44\x2e\x45\130\x50\117\122\124\x2e\x49\x54\x45\x4d\x2e" . $bb0afkg, $isc6w2bmw7efogcbvz3a);
    }
    
    public function isOffer()
    {
        return max($this->arOffers) > 0;
    }
    
    public function getProductId()
    {
        return $this->productId;
    }
    
    public function getProductXmlId()
    {
        $gmh54dglsfqqm09okw2 = $this->getProductFields();
        if (isset($gmh54dglsfqqm09okw2["\120\122\117\104\125\103\124\x5f\x58\x4d\x4c\137\111\x44"])) {
            return $gmh54dglsfqqm09okw2["\x50\x52\117\104\125\103\x54\x5f\130\115\x4c\x5f\x49\104"];
        }
        return null;
    }
    
    public function getProductIblockId()
    {
        $gmh54dglsfqqm09okw2 = $this->getProductFields();
        if (isset($gmh54dglsfqqm09okw2["\120\122\117\x44\125\103\x54\x5f\x49\x42\x4c\x4f\103\x4b\137\111\104"])) {
            return (int) $gmh54dglsfqqm09okw2["\x50\x52\117\104\x55\x43\x54\137\111\102\114\117\103\x4b\137\111\104"];
        }
        return null;
    }
    
    public function getOfferIds()
    {
        return $this->arOffers;
    }
    
    public function getOfferId()
    {
        return $this->arOffers[0] ?: 0;
    }
    
    public function getOfferXmlId()
    {
        $gmh54dglsfqqm09okw2 = $this->getOfferFields($this->getOfferId());
        if (isset($gmh54dglsfqqm09okw2["\117\106\x46\105\122\x5f\130\x4d\x4c\x5f\x49\x44"])) {
            return $gmh54dglsfqqm09okw2["\x4f\106\x46\x45\122\x5f\x58\x4d\x4c\137\x49\x44"];
        }
        return null;
    }
    
    public function getOfferIblockId()
    {
        $gmh54dglsfqqm09okw2 = $this->getOfferFields($this->getOfferId());
        if (isset($gmh54dglsfqqm09okw2["\117\x46\x46\105\122\x5f\x49\102\x4c\117\x43\113\137\111\104"])) {
            return (int) $gmh54dglsfqqm09okw2["\x4f\x46\x46\x45\x52\x5f\111\102\x4c\117\103\113\x5f\111\104"];
        }
        return null;
    }
    
    public function getProductFields()
    {
        $nq86uonzq9qbsmo2i0xa00 = [];
        
        if (isset($this->arCache["\147\x65\x74\x50\x72\x6f\x64\165\x63\x74\106\151\145\x6c\x64\163"])) {
            return $this->arCache["\x67\145\164\120\x72\157\144\x75\143\x74\106\x69\x65\154\x64\163"];
        }
        $w4mx92o0rt0hoqt37d716zzf0r5 = $this->iblockElementOld()->getList(["\111\x44" => "\x41\x53\103"], ["\x49\104" => $this->getProductId()], false, false, ["\x49\104", "\x58\x4d\x4c\137\x49\x44", "\105\x58\124\105\x52\116\101\x4c\137\x49\104", "\103\x4f\104\x45", "\x49\x42\114\117\x43\x4b\x5f\x49\x44", "\101\x43\124\111\126\105", "\x4e\101\x4d\x45", "\x50\x52\x45\126\x49\105\x57\x5f\124\x45\x58\124", "\x50\122\x45\126\x49\105\x57\x5f\x54\x45\x58\x54\137\124\131\x50\105", "\x50\x52\x45\126\x49\x45\x57\137\x50\x49\x43\124\x55\122\105", "\104\105\x54\101\x49\x4c\x5f\124\x45\130\124", "\x44\x45\x54\101\111\x4c\x5f\124\x45\x58\124\137\x54\131\x50\105", "\x44\x45\124\101\x49\x4c\137\x50\x49\103\x54\x55\122\x45", "\x44\x45\124\101\x49\x4c\137\x50\101\x47\105\137\x55\122\114"]);
        if ($aescd4z5h1qs32e2sm6kdtfu9lbis4x = $w4mx92o0rt0hoqt37d716zzf0r5->GetNextElement(true, false)) {
            $n0hdg9on8 = $aescd4z5h1qs32e2sm6kdtfu9lbis4x->getFields();
            $elh7r0q85k = $aescd4z5h1qs32e2sm6kdtfu9lbis4x->GetProperties();
            $nq86uonzq9qbsmo2i0xa00["\120\122\117\104\125\x43\124\137\123\x45\x4f\137\124\111\x54\x4c\105"] = "";
            $nq86uonzq9qbsmo2i0xa00["\x50\122\117\x44\125\x43\x54\137\x53\x45\x4f\x5f\x4d\105\x54\x41\137\124\111\x54\x4c\x45"] = "";
            foreach ($n0hdg9on8 as $vaf3wf1zxulfio => $d1psilu0jtekydi0x7) {
                $nq86uonzq9qbsmo2i0xa00["\x50\x52\117\104\125\103\124\137" . $vaf3wf1zxulfio] = $d1psilu0jtekydi0x7;
            }
            foreach ($elh7r0q85k as $vaf3wf1zxulfio => $d1psilu0jtekydi0x7) {
                $nq86uonzq9qbsmo2i0xa00["\x50\x52\x4f\120\x45\122\x54\131\137" . $d1psilu0jtekydi0x7["\111\104"]] = $this->getPreparedPropertyValue($d1psilu0jtekydi0x7);
                if ($d1psilu0jtekydi0x7["\120\122\x4f\x50\105\122\124\131\137\x54\x59\120\105"] == self::PROPERTY_TYPE_F) {
                    $nq86uonzq9qbsmo2i0xa00["\120\x52\x4f\120\x45\122\x54\131\x5f" . $d1psilu0jtekydi0x7["\111\x44"] . "\137\106\x49\104"] = $d1psilu0jtekydi0x7["\x56\x41\x4c\x55\105"];
                }
            }
            $nq86uonzq9qbsmo2i0xa00["\x50\122\x4f\104\x55\103\124\x5f\x50\122\x45\x56\111\105\127\x5f\x54\105\130\124"] = $this->htmlToText($nq86uonzq9qbsmo2i0xa00["\x50\x52\117\104\x55\x43\124\137\120\x52\x45\x56\111\x45\x57\137\x54\x45\x58\124"], $this->getHtmlToTextDeleteRules());
            $nq86uonzq9qbsmo2i0xa00["\x50\x52\x4f\x44\x55\x43\x54\x5f\104\105\124\101\111\114\x5f\x54\105\130\x54"] = $this->htmlToText($nq86uonzq9qbsmo2i0xa00["\x50\x52\x4f\104\x55\103\x54\137\104\105\124\x41\111\x4c\137\124\105\x58\x54"], $this->getHtmlToTextDeleteRules());
            $nq86uonzq9qbsmo2i0xa00["\120\122\x4f\x44\x55\103\124\137\x4e\101\115\105"] = $this->htmlToText($nq86uonzq9qbsmo2i0xa00["\120\122\x4f\104\125\x43\124\x5f\116\101\115\105"]);
            
            $nq86uonzq9qbsmo2i0xa00["\x50\x52\117\x44\125\x43\x54\137\104\105\124\x41\x49\x4c\x5f\x50\x41\107\x45\x5f\x55\122\x4c"] = $this->prepareProductUrl($nq86uonzq9qbsmo2i0xa00["\x50\x52\x4f\x44\125\x43\124\137\x44\x45\x54\101\111\x4c\137\x50\101\107\105\x5f\x55\x52\114"]);
            
            if (class_exists("\102\x69\x74\x72\151\x78\x5c\111\142\x6c\x6f\x63\153\134\111\156\150\145\x72\151\x74\x65\144\x50\x72\157\160\145\162\x74\171\x5c\105\154\145\155\x65\x6e\x74\126\141\x6c\165\x65\x73")) {
                $f0ud5mvem1agmuxlv = new \Bitrix\Iblock\InheritedProperty\ElementValues($n0hdg9on8["\111\102\x4c\x4f\103\x4b\x5f\x49\x44"], $n0hdg9on8["\111\104"]);
                $dzx0sg8c = $f0ud5mvem1agmuxlv->getValues();
                if (isset($dzx0sg8c["\x45\114\105\x4d\105\x4e\124\137\x50\101\107\105\x5f\124\111\124\x4c\x45"])) {
                    $nq86uonzq9qbsmo2i0xa00["\x50\122\x4f\104\125\x43\124\137\123\x45\x4f\137\x54\x49\x54\x4c\x45"] = $this->htmlToText($dzx0sg8c["\x45\x4c\105\x4d\105\x4e\x54\137\120\x41\x47\x45\137\x54\x49\x54\x4c\105"]);
                }
                if (isset($dzx0sg8c["\x45\114\x45\x4d\105\116\x54\x5f\115\105\x54\101\x5f\x54\x49\x54\x4c\x45"])) {
                    $nq86uonzq9qbsmo2i0xa00["\x50\122\x4f\x44\125\x43\x54\137\x53\105\117\x5f\x4d\x45\x54\101\x5f\x54\111\x54\114\105"] = $this->htmlToText($dzx0sg8c["\105\114\x45\x4d\x45\x4e\x54\137\115\105\124\x41\x5f\x54\111\124\114\x45"]);
                }
                unset($f0ud5mvem1agmuxlv);
            }
        }
        $this->arCache["\147\145\x74\x50\162\157\144\165\143\164\x46\151\145\x6c\x64\x73"] = $nq86uonzq9qbsmo2i0xa00;
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function getProductData()
    {
        
        if (isset($this->arCache["\147\145\164\120\162\x6f\144\x75\143\164\104\141\164\141"])) {
            return $this->arCache["\147\x65\x74\120\x72\x6f\144\x75\x63\164\104\141\164\x61"];
        }
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductFields();
        
        if (!$this->isOffer()) {
            $this->fillCatalogStoreDimensions($zlepcfesz1rla843x48cba7qn2, $this->getProductId());
            $this->fillCatalogPrice($zlepcfesz1rla843x48cba7qn2, $this->getProductId());
            if (preg_match("\57\136\120\122\117\120\x45\x52\124\x59\137\50\134\x64\53\x29\x24\x2f", $this->exportItem()->getProductWeight(), $dv7a6tnpq5bl3kzg)) {
                $zlepcfesz1rla843x48cba7qn2["\x43\x41\x54\x41\114\x4f\x47\x5f\x57\105\111\x47\x48\124"] = $zlepcfesz1rla843x48cba7qn2["\120\122\x4f\x50\x45\122\x54\131\x5f" . $dv7a6tnpq5bl3kzg[1]];
            }
            if (preg_match("\x2f\x5e\x50\x52\117\120\x45\x52\x54\131\x5f\x28\134\x64\x2b\x29\44\x2f", $this->exportItem()->getProductLength(), $dv7a6tnpq5bl3kzg)) {
                $zlepcfesz1rla843x48cba7qn2["\103\x41\x54\x41\114\x4f\107\x5f\x4c\x45\x4e\x47\x54\x48"] = $zlepcfesz1rla843x48cba7qn2["\120\122\117\120\x45\x52\124\x59\x5f" . $dv7a6tnpq5bl3kzg[1]];
            }
            if (preg_match("\x2f\136\120\x52\x4f\x50\105\x52\x54\x59\137\50\x5c\x64\x2b\x29\44\57", $this->exportItem()->getProductHeight(), $dv7a6tnpq5bl3kzg)) {
                $zlepcfesz1rla843x48cba7qn2["\x43\101\x54\101\114\117\x47\137\x48\x45\111\x47\x48\x54"] = $zlepcfesz1rla843x48cba7qn2["\x50\x52\117\120\x45\x52\x54\x59\137" . $dv7a6tnpq5bl3kzg[1]];
            }
            if (preg_match("\57\136\x50\x52\x4f\x50\105\x52\124\x59\x5f\x28\x5c\x64\x2b\51\x24\x2f", $this->exportItem()->getProductWidth(), $dv7a6tnpq5bl3kzg)) {
                $zlepcfesz1rla843x48cba7qn2["\103\101\124\101\114\117\107\137\127\111\104\x54\x48"] = $zlepcfesz1rla843x48cba7qn2["\x50\122\117\120\x45\x52\x54\131\137" . $dv7a6tnpq5bl3kzg[1]];
            }
            
            $rpgkzyhkgu = $this->exportItem()->getProductPrice();
            if (preg_match("\x2f\x5e\120\x52\111\x43\x45\137\x28\x5c\x64\53\51\x24\x2f", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
                $zlepcfesz1rla843x48cba7qn2 = array_replace($zlepcfesz1rla843x48cba7qn2, $this->getPriceGroupFields($dv7a6tnpq5bl3kzg[1], $zlepcfesz1rla843x48cba7qn2));
            } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                $zlepcfesz1rla843x48cba7qn2["\x50\x52\x49\x43\105"] = $this->preparePrice($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu]);
                $zlepcfesz1rla843x48cba7qn2["\x50\x52\x49\x43\x45\137\x46\x4f\122\115\x41\124"] = $this->getFormatedPrice($zlepcfesz1rla843x48cba7qn2["\120\122\111\103\x45"]);
            }
            
            $rpgkzyhkgu = $this->exportItem()->getProductPriceOld();
            if (preg_match("\57\136\x50\x52\x4f\x50\x45\122\x54\131\137\x2f", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
                if (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                    $zlepcfesz1rla843x48cba7qn2["\120\x52\x49\x43\x45\x5f\117\x4c\104"] = $this->preparePrice($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu]);
                    $zlepcfesz1rla843x48cba7qn2["\120\x52\111\x43\x45\x5f\117\114\x44\137\106\x4f\x52\x4d\x41\124"] = $this->getFormatedPrice($zlepcfesz1rla843x48cba7qn2["\120\x52\x49\x43\105\137\117\114\104"]);
                }
            }
            $this->calcPriceDiscount($zlepcfesz1rla843x48cba7qn2);
        }
        [$nlb1g52mou] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_AFTER_PREPARE_PRODUCT_DATA, ["\141\x72\120\x72\157\x64\165\143\x74" => $zlepcfesz1rla843x48cba7qn2, "\x61\162\105\x78\160\x6f\162\164\x44\141\x74\x61" => $this->exportItem()->getData(), "\x67\157\x6f\144\x45\170\160\157\162\164\x49\x74\x65\x6d" => $this], true);
        if (!empty($nlb1g52mou)) {
            $zlepcfesz1rla843x48cba7qn2 = $nlb1g52mou;
        }
        $this->arCache["\147\145\164\x50\162\157\144\x75\143\164\x44\x61\x74\141"] = $zlepcfesz1rla843x48cba7qn2;
        return $zlepcfesz1rla843x48cba7qn2;
    }
    
    public function getOfferFields($zvhkvc87600p0zq4fhfj7e4n28pr)
    {
        
        if (isset($this->arCache["\147\x65\x74\x4f\x66\x66\x65\162\x46\x69\x65\x6c\x64\163"][$zvhkvc87600p0zq4fhfj7e4n28pr])) {
            return $this->arCache["\x67\x65\x74\117\146\x66\145\x72\x46\151\145\x6c\x64\163"][$zvhkvc87600p0zq4fhfj7e4n28pr];
        }
        $nq86uonzq9qbsmo2i0xa00 = [];
        $w4mx92o0rt0hoqt37d716zzf0r5 = $this->iblockElementOld()->getList(["\111\104" => "\101\123\103"], ["\111\x44" => $zvhkvc87600p0zq4fhfj7e4n28pr], false, false, ["\111\x44", "\x58\115\114\x5f\111\104", "\x45\x58\124\x45\122\116\101\114\x5f\x49\x44", "\103\117\x44\105", "\x49\x42\x4c\117\x43\113\137\x49\x44", "\x41\x43\x54\111\x56\105", "\116\101\115\x45", "\120\122\x45\126\x49\x45\127\x5f\x54\105\x58\x54", "\x50\122\x45\x56\x49\105\x57\x5f\x54\105\130\x54\137\x54\131\x50\x45", "\120\x52\x45\x56\111\x45\127\137\120\x49\x43\x54\x55\122\x45", "\104\x45\124\x41\111\114\x5f\x54\105\130\124", "\104\105\124\101\111\x4c\x5f\x54\x45\130\124\137\124\131\120\105", "\104\105\124\x41\x49\x4c\x5f\x50\x49\x43\124\125\122\105", "\x44\105\x54\101\x49\114\x5f\120\x41\x47\105\x5f\125\122\x4c"]);
        if ($aescd4z5h1qs32e2sm6kdtfu9lbis4x = $w4mx92o0rt0hoqt37d716zzf0r5->GetNextElement(true, false)) {
            $n0hdg9on8 = $aescd4z5h1qs32e2sm6kdtfu9lbis4x->getFields();
            $elh7r0q85k = $aescd4z5h1qs32e2sm6kdtfu9lbis4x->GetProperties();
            $nq86uonzq9qbsmo2i0xa00["\x4f\x46\106\x45\x52\x5f\123\x45\117\x5f\x54\x49\124\x4c\x45"] = "";
            $nq86uonzq9qbsmo2i0xa00["\x4f\x46\x46\x45\122\x5f\123\x45\117\x5f\115\x45\124\101\x5f\x54\x49\x54\114\x45"] = "";
            foreach ($n0hdg9on8 as $vaf3wf1zxulfio => $d1psilu0jtekydi0x7) {
                $nq86uonzq9qbsmo2i0xa00["\x4f\x46\x46\x45\x52\137" . $vaf3wf1zxulfio] = $d1psilu0jtekydi0x7;
            }
            foreach ($elh7r0q85k as $vaf3wf1zxulfio => $d1psilu0jtekydi0x7) {
                $nq86uonzq9qbsmo2i0xa00["\x50\122\117\x50\105\x52\124\131\x5f" . $d1psilu0jtekydi0x7["\x49\104"]] = $this->getPreparedPropertyValue($d1psilu0jtekydi0x7);
                if ($d1psilu0jtekydi0x7["\x50\x52\x4f\120\105\122\124\x59\x5f\x54\131\120\105"] == self::PROPERTY_TYPE_F) {
                    $nq86uonzq9qbsmo2i0xa00["\x50\x52\117\x50\105\x52\x54\131\137" . $d1psilu0jtekydi0x7["\x49\x44"] . "\x5f\x46\x49\x44"] = $d1psilu0jtekydi0x7["\x56\101\114\125\x45"];
                } elseif ($d1psilu0jtekydi0x7["\x50\122\117\x50\x45\x52\124\131\137\x54\x59\x50\x45"] == self::PROPERTY_TYPE_L) {
                    $nq86uonzq9qbsmo2i0xa00["\120\x52\x4f\120\105\122\124\x59\137" . $d1psilu0jtekydi0x7["\111\104"] . "\137\x45\x4e\x55\x4d\137\111\x44"] = $d1psilu0jtekydi0x7["\126\x41\x4c\x55\x45\x5f\x45\x4e\125\115\137\x49\104"];
                } elseif ($d1psilu0jtekydi0x7["\120\122\117\120\x45\x52\x54\x59\137\x54\x59\x50\x45"] == self::PROPERTY_TYPE_S && $d1psilu0jtekydi0x7["\125\x53\x45\122\x5f\124\x59\120\105"] == "\144\x69\162\x65\143\x74\157\x72\x79") {
                    $nq86uonzq9qbsmo2i0xa00["\120\122\x4f\120\x45\122\124\x59\x5f" . $d1psilu0jtekydi0x7["\x49\104"] . "\x5f\x45\116\x55\115\137\111\x44"] = $this->getHighloadEnumIdByPropertyValue($d1psilu0jtekydi0x7);
                }
            }
            $nq86uonzq9qbsmo2i0xa00["\117\x46\106\105\x52\x5f\x50\122\105\x56\x49\x45\127\x5f\x54\105\x58\124"] = $this->htmlToText($nq86uonzq9qbsmo2i0xa00["\x4f\x46\x46\x45\x52\x5f\x50\x52\105\x56\x49\105\x57\x5f\x54\x45\130\x54"], $this->getHtmlToTextDeleteRules());
            $nq86uonzq9qbsmo2i0xa00["\117\x46\106\105\x52\137\x44\x45\124\x41\x49\114\x5f\x54\x45\x58\124"] = $this->htmlToText($nq86uonzq9qbsmo2i0xa00["\x4f\x46\x46\x45\122\x5f\x44\105\x54\101\111\114\137\124\105\130\124"], $this->getHtmlToTextDeleteRules());
            $nq86uonzq9qbsmo2i0xa00["\117\106\106\x45\122\x5f\x4e\101\115\105"] = $this->htmlToText($nq86uonzq9qbsmo2i0xa00["\x4f\x46\106\x45\122\x5f\x4e\x41\x4d\x45"]);
            
            if (class_exists("\102\x69\164\x72\151\x78\134\x49\142\154\157\143\x6b\x5c\111\156\150\145\162\151\x74\x65\x64\x50\x72\157\160\x65\x72\x74\x79\x5c\105\154\145\x6d\x65\156\164\x56\x61\x6c\165\x65\x73")) {
                $f0ud5mvem1agmuxlv = new \Bitrix\Iblock\InheritedProperty\ElementValues($n0hdg9on8["\111\x42\x4c\x4f\x43\x4b\137\111\x44"], $n0hdg9on8["\x49\104"]);
                $dzx0sg8c = $f0ud5mvem1agmuxlv->getValues();
                if (isset($dzx0sg8c["\x45\114\x45\115\105\x4e\x54\137\120\101\107\x45\137\x54\x49\x54\x4c\105"])) {
                    $nq86uonzq9qbsmo2i0xa00["\117\106\106\105\x52\x5f\x53\105\117\137\124\111\x54\x4c\x45"] = $this->htmlToText($dzx0sg8c["\x45\x4c\x45\x4d\105\x4e\124\137\x50\x41\107\x45\x5f\x54\111\x54\114\x45"]);
                }
                if (isset($dzx0sg8c["\105\x4c\105\x4d\x45\116\124\x5f\x4d\x45\124\101\137\124\x49\x54\x4c\105"])) {
                    $nq86uonzq9qbsmo2i0xa00["\117\106\x46\105\122\x5f\123\x45\x4f\137\x4d\105\124\x41\x5f\x54\111\124\114\105"] = $this->htmlToText($dzx0sg8c["\105\x4c\105\115\105\x4e\124\137\115\x45\x54\101\137\x54\x49\124\x4c\105"]);
                }
                unset($f0ud5mvem1agmuxlv);
            }
        }
        unset($aescd4z5h1qs32e2sm6kdtfu9lbis4x, $aq55kp2fkziwl2, $l62mbzbcdf2618a);
        $this->arCache["\147\x65\164\117\146\146\x65\x72\x46\151\x65\154\x64\163"][$zvhkvc87600p0zq4fhfj7e4n28pr] = $nq86uonzq9qbsmo2i0xa00;
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function getOfferData($zvhkvc87600p0zq4fhfj7e4n28pr)
    {
        
        if (isset($this->arCache["\x67\145\164\x4f\x66\146\x65\x72\x44\141\164\141"][$zvhkvc87600p0zq4fhfj7e4n28pr])) {
            return $this->arCache["\x67\x65\x74\117\146\x66\x65\x72\x44\141\164\x61"][$zvhkvc87600p0zq4fhfj7e4n28pr];
        }
        $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferFields($zvhkvc87600p0zq4fhfj7e4n28pr);
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductFields();
        
        $this->fillVariants($rewhklyoypc3yth2e7lprhccbnev);
        
        $this->fillCatalogStoreDimensions($rewhklyoypc3yth2e7lprhccbnev, $zvhkvc87600p0zq4fhfj7e4n28pr);
        $this->fillCatalogPrice($rewhklyoypc3yth2e7lprhccbnev, $zvhkvc87600p0zq4fhfj7e4n28pr);
        $rpgkzyhkgu = $this->exportItem()->getOfferWeight();
        if (preg_match("\x2f\x5e\x50\122\x4f\120\x45\x52\x54\x59\x5f\x28\134\144\x2b\x29\x24\57", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
            if (array_key_exists($rpgkzyhkgu, $rewhklyoypc3yth2e7lprhccbnev)) {
                $rewhklyoypc3yth2e7lprhccbnev["\103\x41\124\101\x4c\117\107\x5f\x57\105\111\x47\x48\124"] = $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                $rewhklyoypc3yth2e7lprhccbnev["\103\x41\x54\x41\x4c\117\107\x5f\127\x45\x49\107\x48\124"] = $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        $rpgkzyhkgu = $this->exportItem()->getOfferLength();
        if (preg_match("\x2f\x5e\120\122\x4f\x50\105\x52\124\x59\x5f\50\x5c\x64\x2b\51\x24\57", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
            if (array_key_exists($rpgkzyhkgu, $rewhklyoypc3yth2e7lprhccbnev)) {
                $rewhklyoypc3yth2e7lprhccbnev["\x43\101\x54\x41\x4c\117\107\x5f\114\x45\116\107\x54\110"] = $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                $rewhklyoypc3yth2e7lprhccbnev["\x43\101\x54\x41\114\117\x47\137\x4c\105\x4e\x47\124\110"] = $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        $rpgkzyhkgu = $this->exportItem()->getOfferHeight();
        if (preg_match("\x2f\x5e\120\x52\x4f\120\x45\122\x54\131\x5f\x28\134\144\53\x29\x24\57", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
            if (array_key_exists($rpgkzyhkgu, $rewhklyoypc3yth2e7lprhccbnev)) {
                $rewhklyoypc3yth2e7lprhccbnev["\103\x41\x54\x41\114\x4f\107\x5f\x48\105\111\107\x48\x54"] = $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                $rewhklyoypc3yth2e7lprhccbnev["\103\x41\124\101\114\117\107\x5f\110\x45\x49\107\110\x54"] = $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        $rpgkzyhkgu = $this->exportItem()->getOfferWidth();
        if (preg_match("\x2f\136\120\122\117\x50\x45\122\124\x59\137\x28\134\144\53\x29\44\57", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
            if (array_key_exists($rpgkzyhkgu, $rewhklyoypc3yth2e7lprhccbnev)) {
                $rewhklyoypc3yth2e7lprhccbnev["\103\x41\124\x41\114\x4f\107\x5f\x57\x49\x44\x54\x48"] = $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                $rewhklyoypc3yth2e7lprhccbnev["\103\x41\124\101\114\x4f\107\x5f\x57\x49\x44\x54\x48"] = $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        
        $rpgkzyhkgu = $this->exportItem()->getOfferPrice();
        if (preg_match("\57\x5e\x50\x52\x49\103\x45\x5f\x28\134\144\x2b\x29\44\x2f", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
            $rewhklyoypc3yth2e7lprhccbnev = array_replace($rewhklyoypc3yth2e7lprhccbnev, $this->getPriceGroupFields($dv7a6tnpq5bl3kzg[1], $rewhklyoypc3yth2e7lprhccbnev));
        } elseif (array_key_exists($rpgkzyhkgu, $rewhklyoypc3yth2e7lprhccbnev)) {
            $rewhklyoypc3yth2e7lprhccbnev["\120\x52\x49\103\x45"] = $this->preparePrice($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu]);
            $rewhklyoypc3yth2e7lprhccbnev["\120\122\111\103\105\137\106\117\122\x4d\x41\124"] = $this->getFormatedPrice($rewhklyoypc3yth2e7lprhccbnev["\120\122\111\103\x45"]);
        } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
            $rewhklyoypc3yth2e7lprhccbnev["\120\122\111\103\105"] = $this->preparePrice($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu]);
            $rewhklyoypc3yth2e7lprhccbnev["\x50\122\x49\103\x45\137\106\117\122\x4d\x41\x54"] = $this->getFormatedPrice($rewhklyoypc3yth2e7lprhccbnev["\x50\122\111\103\x45"]);
        }
        
        $rpgkzyhkgu = $this->exportItem()->getOfferPriceOld();
        if (preg_match("\57\136\x50\x52\117\120\x45\x52\124\131\x5f\57", $rpgkzyhkgu, $dv7a6tnpq5bl3kzg)) {
            if (array_key_exists($rpgkzyhkgu, $rewhklyoypc3yth2e7lprhccbnev)) {
                $rewhklyoypc3yth2e7lprhccbnev["\x50\122\x49\x43\x45\137\117\114\104"] = $this->preparePrice($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu]);
                $rewhklyoypc3yth2e7lprhccbnev["\x50\122\111\x43\x45\137\x4f\x4c\x44\x5f\106\117\x52\115\x41\124"] = $this->getFormatedPrice($rewhklyoypc3yth2e7lprhccbnev["\x50\122\x49\103\105\137\117\114\104"]);
            } elseif (array_key_exists($rpgkzyhkgu, $zlepcfesz1rla843x48cba7qn2)) {
                $rewhklyoypc3yth2e7lprhccbnev["\120\x52\111\103\105\x5f\x4f\114\104"] = $this->preparePrice($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu]);
                $rewhklyoypc3yth2e7lprhccbnev["\x50\122\111\x43\105\137\117\114\104\137\x46\117\122\115\101\x54"] = $this->getFormatedPrice($rewhklyoypc3yth2e7lprhccbnev["\x50\122\111\x43\105\x5f\x4f\114\104"]);
            }
        }
        $this->calcPriceDiscount($rewhklyoypc3yth2e7lprhccbnev);
        [$lmqms4h2anxcbyhvm] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_AFTER_PREPARE_OFFER_DATA, ["\x61\x72\x4f\146\x66\x65\x72" => $rewhklyoypc3yth2e7lprhccbnev, "\141\162\105\x78\x70\157\x72\164\x44\141\164\141" => $this->exportItem()->getData(), "\x61\x72\x50\162\157\x64\165\143\x74" => $zlepcfesz1rla843x48cba7qn2, "\x67\157\157\x64\105\170\x70\x6f\162\164\111\164\x65\x6d" => $this], true);
        if (!empty($lmqms4h2anxcbyhvm)) {
            $rewhklyoypc3yth2e7lprhccbnev = $lmqms4h2anxcbyhvm;
        }
        $this->arCache["\147\145\164\117\146\x66\x65\162\x44\x61\x74\141"][$zvhkvc87600p0zq4fhfj7e4n28pr] = $rewhklyoypc3yth2e7lprhccbnev;
        return $rewhklyoypc3yth2e7lprhccbnev;
    }
    
    public function prepareProductUrl($i3vw8whd077r)
    {
        $qqb9n48vq9p7lteu5ylld56topprue0 = new \Bitrix\Main\Web\Uri($this->getSiteUrl() . $i3vw8whd077r);
        $hefhn2ovhao = $this->manager()->getUrlUtm();
        if (strlen(trim($hefhn2ovhao)) > 0) {
            $hefhn2ovhao = str_replace("\x7b\147\x72\157\165\x70\137\151\144\x7d", $this->exportItem()->getGroupId(), $hefhn2ovhao);
            $fk3e30osvqkecceyoecjr = [];
            parse_str($hefhn2ovhao, $fk3e30osvqkecceyoecjr);
            $qqb9n48vq9p7lteu5ylld56topprue0->addParams($fk3e30osvqkecceyoecjr);
        }
        return $qqb9n48vq9p7lteu5ylld56topprue0->getLocator();
    }
    
    public function getCurrencyId()
    {
        static $sqqrpvot9e2il21oq;
        
        if (!isset($sqqrpvot9e2il21oq)) {
            $sqqrpvot9e2il21oq = "\x52\x55\x42";
            if (\VKapi\Market\Manager::getInstance()->isInstalledCurrencyModule()) {
                if ($j6hlwze9yqn001ync6gj8ex7jsko1 = \Bitrix\Currency\CurrencyManager::getBaseCurrency()) {
                    $sqqrpvot9e2il21oq = $j6hlwze9yqn001ync6gj8ex7jsko1;
                } elseif (!empty($duiakxkj5ttlerx21nkqigdz7p8e = \Bitrix\Currency\CurrencyManager::getCurrencyList())) {
                    $jtgu32r8vsojnpnfhc3lv = array_keys($duiakxkj5ttlerx21nkqigdz7p8e);
                    $sqqrpvot9e2il21oq = reset($jtgu32r8vsojnpnfhc3lv);
                }
                unset($j6hlwze9yqn001ync6gj8ex7jsko1, $duiakxkj5ttlerx21nkqigdz7p8e);
            }
        }
        return $this->exportItem()->getCurrencyId();
    }
    
    public function getCurrencyConvertPrice($l741yevuv9zc, $r70iuy6pucy38pytyw6kq7jh2eayq751scs)
    {
        if ($this->manager()->isInstalledCurrencyModule() && $r70iuy6pucy38pytyw6kq7jh2eayq751scs != $this->getCurrencyId()) {
            
            return \CCurrencyRates::ConvertCurrency($l741yevuv9zc, $r70iuy6pucy38pytyw6kq7jh2eayq751scs, $this->getCurrencyId());
        }
        return $l741yevuv9zc;
    }
    
    public function getPreparedPropertyValue($vd4hcm6uouad50oat3bbzs6ow5ug)
    {
        $m4wva0122vk9vebdmr1s74ajls = $vd4hcm6uouad50oat3bbzs6ow5ug["\126\101\114\x55\x45"];
        if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
            if (empty($m4wva0122vk9vebdmr1s74ajls)) {
                return "";
            }
        } elseif (trim($m4wva0122vk9vebdmr1s74ajls) == "") {
            return trim($m4wva0122vk9vebdmr1s74ajls);
        }
        switch ($vd4hcm6uouad50oat3bbzs6ow5ug["\x50\x52\117\120\x45\122\124\x59\x5f\x54\x59\120\105"]) {
            case self::PROPERTY_TYPE_S:
                switch ($vd4hcm6uouad50oat3bbzs6ow5ug["\x55\x53\105\122\x5f\x54\131\120\x45"]) {
                    
                    case "\x64\151\162\x65\143\x74\157\x72\x79":
                        return $this->getPreparedPropertyValueHighload($vd4hcm6uouad50oat3bbzs6ow5ug);
                        break;
                    case "\x45\x6c\145\x6d\x65\x6e\164\130\155\x6c\x49\104":
                        if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                            $s5g8s = [];
                            $gm3vugm0jq54duz299d4x = [];
                            foreach ($m4wva0122vk9vebdmr1s74ajls as $btzg598kh) {
                                $btzg598kh = trim($btzg598kh);
                                if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$btzg598kh])) {
                                    $gm3vugm0jq54duz299d4x[] = $btzg598kh;
                                } else {
                                    $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$btzg598kh];
                                }
                            }
                            if (count($gm3vugm0jq54duz299d4x)) {
                                $cjwbaxi0k6lr = $this->manager()->iblockElementOld()->getList(["\x53\117\x52\x54" => "\101\x53\103"], ["\130\x4d\x4c\137\x49\104" => $gm3vugm0jq54duz299d4x], false, false, ["\111\104", "\116\x41\115\105", "\x58\115\x4c\137\111\x44"]);
                                while ($n0hdg9on8 = $cjwbaxi0k6lr->Fetch()) {
                                    $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][trim($n0hdg9on8["\x58\x4d\114\x5f\111\x44"])] = $this->htmlToText($n0hdg9on8["\x4e\x41\115\x45"]);
                                    $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\x44"]][trim($n0hdg9on8["\130\x4d\x4c\x5f\x49\104"])];
                                }
                            }
                            return implode("\x2c", $s5g8s);
                        } else {
                            $m4wva0122vk9vebdmr1s74ajls = trim($m4wva0122vk9vebdmr1s74ajls);
                            if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls])) {
                                $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls] = "";
                                $cjwbaxi0k6lr = $this->manager()->iblockElementOld()->getList(["\123\x4f\x52\124" => "\x41\x53\x43"], ["\x58\x4d\x4c\137\x49\x44" => $m4wva0122vk9vebdmr1s74ajls], false, false, ["\111\104", "\116\x41\115\105", "\130\x4d\x4c\137\111\104"]);
                                if ($n0hdg9on8 = $cjwbaxi0k6lr->Fetch()) {
                                    $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\x44"]][trim($n0hdg9on8["\130\x4d\x4c\137\111\x44"])] = $this->htmlToText($n0hdg9on8["\116\101\x4d\105"]);
                                }
                            }
                            return $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls];
                        }
                        break;
                    default:
                        if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                            return implode("\54", array_diff($m4wva0122vk9vebdmr1s74ajls, [""]));
                        } else {
                            return $m4wva0122vk9vebdmr1s74ajls;
                        }
                        break;
                }
                break;
            
            case self::PROPERTY_TYPE_F:
                if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                    $s5g8s = [];
                    $gm3vugm0jq54duz299d4x = [];
                    foreach ($m4wva0122vk9vebdmr1s74ajls as $ncd7brjnq9h5ar5u5ph) {
                        $ncd7brjnq9h5ar5u5ph = intval($ncd7brjnq9h5ar5u5ph);
                        if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\104"]][$ncd7brjnq9h5ar5u5ph])) {
                            $gm3vugm0jq54duz299d4x[] = $ncd7brjnq9h5ar5u5ph;
                        } else {
                            $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$ncd7brjnq9h5ar5u5ph];
                        }
                    }
                    if (count($gm3vugm0jq54duz299d4x)) {
                        $inblyunr5bbg4b3ceoqsyju4txs86q5 = $this->manager()->file()->GetList([], ["\100\111\104" => $gm3vugm0jq54duz299d4x]);
                        while ($spsqf8n76rkj26i6 = $inblyunr5bbg4b3ceoqsyju4txs86q5->Fetch()) {
                            $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$spsqf8n76rkj26i6["\111\x44"]] = $this->getSiteUrl() . $this->manager()->file()->GetFileSRC($spsqf8n76rkj26i6);
                            $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\x44"]][$spsqf8n76rkj26i6["\111\x44"]];
                        }
                    }
                    return implode("\x2c", $s5g8s);
                } else {
                    $m4wva0122vk9vebdmr1s74ajls = intval($m4wva0122vk9vebdmr1s74ajls);
                    if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls])) {
                        $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls] = false;
                        if ($spsqf8n76rkj26i6 = $this->manager()->file()->GetFileArray($m4wva0122vk9vebdmr1s74ajls)) {
                            $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls] = $this->getSiteUrl() . $this->manager()->file()->GetFileSRC($spsqf8n76rkj26i6);
                        }
                    }
                    return $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\104"]][$m4wva0122vk9vebdmr1s74ajls];
                }
                break;
            
            case self::PROPERTY_TYPE_E:
                if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                    $s5g8s = [];
                    $gm3vugm0jq54duz299d4x = [];
                    foreach ($m4wva0122vk9vebdmr1s74ajls as $btzg598kh) {
                        $btzg598kh = intval($btzg598kh);
                        if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\104"]][$btzg598kh])) {
                            $gm3vugm0jq54duz299d4x[] = $btzg598kh;
                        } else {
                            $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$btzg598kh];
                        }
                    }
                    if (count($gm3vugm0jq54duz299d4x)) {
                        $cjwbaxi0k6lr = $this->manager()->iblockElementOld()->getList(["\123\x4f\122\124" => "\101\x53\103"], ["\111\x44" => $gm3vugm0jq54duz299d4x], false, false, ["\111\104", "\x4e\101\115\105"]);
                        while ($n0hdg9on8 = $cjwbaxi0k6lr->Fetch()) {
                            $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\104"]][$n0hdg9on8["\x49\104"]] = $this->htmlToText($n0hdg9on8["\116\101\x4d\105"]);
                            $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\x44"]][$n0hdg9on8["\111\104"]];
                        }
                    }
                    return implode("\x2c", $s5g8s);
                } else {
                    $m4wva0122vk9vebdmr1s74ajls = intval($m4wva0122vk9vebdmr1s74ajls);
                    if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls])) {
                        $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls] = "";
                        $cjwbaxi0k6lr = $this->manager()->iblockElementOld()->getList([], ["\x49\104" => $m4wva0122vk9vebdmr1s74ajls], false, false, ["\111\104", "\116\x41\115\x45"]);
                        if ($n0hdg9on8 = $cjwbaxi0k6lr->Fetch()) {
                            $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\x44"]][$m4wva0122vk9vebdmr1s74ajls] = $this->htmlToText($n0hdg9on8["\116\101\x4d\105"]);
                        }
                    }
                    return $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\104"]][$m4wva0122vk9vebdmr1s74ajls];
                }
                break;
            
            case self::PROPERTY_TYPE_G:
                if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                    $s5g8s = [];
                    $gm3vugm0jq54duz299d4x = [];
                    foreach ($m4wva0122vk9vebdmr1s74ajls as $btzg598kh) {
                        $btzg598kh = intval($btzg598kh);
                        
                        if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\104"]][$btzg598kh])) {
                            $gm3vugm0jq54duz299d4x[] = $btzg598kh;
                        } else {
                            $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$btzg598kh];
                        }
                    }
                    if (count($gm3vugm0jq54duz299d4x)) {
                        $xxs82bdwad20to = $this->manager()->iblockSectionOld()->GetList(["\123\x4f\122\x54" => "\x41\x53\103"], ["\x49\104" => $gm3vugm0jq54duz299d4x], false, ["\111\104", "\116\101\x4d\x45"]);
                        while ($o2neds7l = $xxs82bdwad20to->Fetch()) {
                            $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$o2neds7l["\111\x44"]] = $this->htmlToText($o2neds7l["\x4e\101\115\x45"]);
                            $s5g8s[] = $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$o2neds7l["\x49\x44"]];
                        }
                    }
                    return implode("\x2c", $s5g8s);
                } else {
                    $m4wva0122vk9vebdmr1s74ajls = intval($m4wva0122vk9vebdmr1s74ajls);
                    if (!isset($this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls])) {
                        $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls] = "";
                        $xxs82bdwad20to = $this->manager()->iblockSectionOld()->GetList([], ["\x49\104" => $m4wva0122vk9vebdmr1s74ajls], false, ["\x49\x44", "\x4e\101\x4d\105"]);
                        if ($o2neds7l = $xxs82bdwad20to->Fetch()) {
                            $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\111\104"]][$m4wva0122vk9vebdmr1s74ajls] = $this->htmlToText($o2neds7l["\x4e\101\x4d\x45"]);
                        }
                    }
                    return $this->arPrepiredPropValue[$vd4hcm6uouad50oat3bbzs6ow5ug["\x49\x44"]][$m4wva0122vk9vebdmr1s74ajls];
                }
                break;
            default:
                
                if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                    return implode("\x2c", array_diff($m4wva0122vk9vebdmr1s74ajls, [""]));
                } else {
                    return $m4wva0122vk9vebdmr1s74ajls;
                }
        }
    }
    
    private function getPreparedPropertyValueHighload($cre8zulorsrej0589m3o05t)
    {
        static $f6oz4e280;
        $m4wva0122vk9vebdmr1s74ajls = $cre8zulorsrej0589m3o05t["\x56\x41\114\125\105"];
        do {
            if (!$this->manager()->isInstalledHighloadBlockModule()) {
                break;
            }
            if ($cre8zulorsrej0589m3o05t["\120\122\x4f\120\105\x52\x54\x59\137\124\131\x50\x45"] != self::PROPERTY_TYPE_S) {
                break;
            }
            if ($cre8zulorsrej0589m3o05t["\125\x53\x45\x52\137\x54\x59\120\x45"] != "\144\151\162\145\143\164\157\162\x79") {
                break;
            }
            $lmdy26lbugzee1htz7u5x = null;
            if (isset($cre8zulorsrej0589m3o05t["\x55\123\105\x52\137\124\131\x50\105\137\x53\105\124\x54\111\116\x47\123\x5f\x4c\111\x53\124"]["\124\x41\102\x4c\105\137\x4e\101\115\x45"])) {
                $lmdy26lbugzee1htz7u5x = $cre8zulorsrej0589m3o05t["\x55\123\x45\x52\x5f\124\x59\x50\105\x5f\x53\105\124\124\x49\x4e\107\x53\137\x4c\111\x53\x54"]["\x54\x41\x42\114\105\137\x4e\101\115\105"];
            } elseif (isset($cre8zulorsrej0589m3o05t["\x55\x53\x45\122\137\124\x59\x50\x45\137\x53\x45\x54\124\111\116\x47\x53"]["\x54\101\x42\x4c\105\x5f\116\101\x4d\x45"])) {
                $lmdy26lbugzee1htz7u5x = $cre8zulorsrej0589m3o05t["\x55\x53\105\122\x5f\124\131\120\105\137\123\105\124\124\111\x4e\107\x53"]["\x54\x41\x42\x4c\105\137\x4e\101\115\x45"];
            }
            if (is_null($lmdy26lbugzee1htz7u5x)) {
                break;
            }
            
            if (!isset($f6oz4e280[$lmdy26lbugzee1htz7u5x])) {
                
                if (!($cuszy37936ongboj9d = \Bitrix\Highloadblock\HighloadBlockTable::getList(["\x73\x65\x6c\x65\143\x74" => ["\52"], "\157\x72\x64\145\x72" => ["\116\x41\x4d\x45" => "\101\x53\103"], "\146\x69\154\164\145\x72" => ["\x54\101\x42\114\x45\x5f\x4e\x41\x4d\x45" => $lmdy26lbugzee1htz7u5x]])->fetch())) {
                    break;
                }
                
                $mviwfco6601xp0iof88m4ncuhz = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($cuszy37936ongboj9d);
                $cen2jw = $mviwfco6601xp0iof88m4ncuhz->getDataClass();
                $f6oz4e280[$lmdy26lbugzee1htz7u5x] = new $cen2jw();
            }
            if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                $s5g8s = [];
                $gm3vugm0jq54duz299d4x = [];
                foreach ($m4wva0122vk9vebdmr1s74ajls as $btzg598kh) {
                    $btzg598kh = trim($btzg598kh);
                    if (!isset($this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\x49\104"]][$btzg598kh])) {
                        $gm3vugm0jq54duz299d4x[] = $btzg598kh;
                    } else {
                        $s5g8s[] = $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\x49\x44"]][$btzg598kh];
                    }
                }
                if (count($gm3vugm0jq54duz299d4x)) {
                    $ukhke0aqs5hnwu503b5n = $f6oz4e280[$lmdy26lbugzee1htz7u5x]->getList(["\146\151\154\164\x65\162" => ["\125\106\137\130\x4d\x4c\137\x49\x44" => $gm3vugm0jq54duz299d4x]]);
                    while ($vc6pdfqtga = $ukhke0aqs5hnwu503b5n->fetch()) {
                        $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\x49\x44"]][$vc6pdfqtga["\125\x46\137\x58\x4d\114\x5f\111\104"]] = $vc6pdfqtga["\x55\x46\137\x4e\101\x4d\x45"];
                        $s5g8s[] = $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\x49\104"]][$vc6pdfqtga["\125\106\x5f\130\115\114\x5f\111\104"]];
                    }
                }
                return implode("\54", $s5g8s);
            } else {
                $m4wva0122vk9vebdmr1s74ajls = trim($m4wva0122vk9vebdmr1s74ajls);
                if (!isset($this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\111\104"]][$m4wva0122vk9vebdmr1s74ajls])) {
                    $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\x49\x44"]][$m4wva0122vk9vebdmr1s74ajls] = false;
                    $ukhke0aqs5hnwu503b5n = $f6oz4e280[$lmdy26lbugzee1htz7u5x]->getList(["\146\x69\x6c\164\145\x72" => ["\x55\x46\137\130\115\x4c\x5f\x49\104" => $m4wva0122vk9vebdmr1s74ajls]]);
                    if ($vc6pdfqtga = $ukhke0aqs5hnwu503b5n->fetch()) {
                        $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\x49\104"]][$vc6pdfqtga["\x55\x46\x5f\130\115\x4c\137\x49\x44"]] = $vc6pdfqtga["\125\x46\137\116\101\x4d\105"];
                        $s5g8s[] = $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\111\104"]][$vc6pdfqtga["\x55\106\137\130\115\114\137\111\104"]];
                    }
                }
                return isset($this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\111\104"]][$m4wva0122vk9vebdmr1s74ajls]) ? $this->arPrepiredPropValue[$cre8zulorsrej0589m3o05t["\111\104"]][$m4wva0122vk9vebdmr1s74ajls] : "";
            }
        } while (false);
        
        if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
            return implode("\54", array_diff($m4wva0122vk9vebdmr1s74ajls, [""]));
        } else {
            return $m4wva0122vk9vebdmr1s74ajls;
        }
    }
    
    private function getHighloadEnumIdByPropertyValue($cre8zulorsrej0589m3o05t)
    {
        static $f6oz4e280;
        $m4wva0122vk9vebdmr1s74ajls = $cre8zulorsrej0589m3o05t["\x56\101\114\x55\x45"];
        do {
            if (!$this->manager()->isInstalledHighloadBlockModule()) {
                break;
            }
            if ($cre8zulorsrej0589m3o05t["\x50\122\x4f\120\105\122\x54\131\x5f\x54\x59\120\105"] != self::PROPERTY_TYPE_S) {
                break;
            }
            if ($cre8zulorsrej0589m3o05t["\x55\123\105\122\x5f\124\131\x50\105"] != "\x64\x69\162\145\143\x74\157\x72\171") {
                break;
            }
            $lmdy26lbugzee1htz7u5x = null;
            if (isset($cre8zulorsrej0589m3o05t["\x55\123\x45\122\x5f\x54\131\x50\x45\137\x53\105\x54\x54\111\x4e\107\123\x5f\114\x49\123\124"]["\124\101\x42\114\x45\x5f\116\x41\x4d\x45"])) {
                $lmdy26lbugzee1htz7u5x = $cre8zulorsrej0589m3o05t["\125\x53\105\x52\x5f\x54\131\x50\x45\137\123\105\x54\x54\x49\116\x47\x53\x5f\114\x49\x53\124"]["\x54\x41\x42\114\105\137\x4e\101\115\105"];
            } elseif (isset($cre8zulorsrej0589m3o05t["\125\x53\x45\122\137\x54\131\x50\105\137\x53\105\124\x54\111\116\x47\123"]["\124\101\102\x4c\105\137\x4e\x41\x4d\105"])) {
                $lmdy26lbugzee1htz7u5x = $cre8zulorsrej0589m3o05t["\125\x53\105\x52\137\x54\x59\x50\105\137\x53\x45\124\124\111\x4e\x47\123"]["\x54\101\102\x4c\105\137\116\101\115\x45"];
            }
            if (is_null($lmdy26lbugzee1htz7u5x)) {
                break;
            }
            
            if (!isset($f6oz4e280[$lmdy26lbugzee1htz7u5x])) {
                
                if (!($cuszy37936ongboj9d = \Bitrix\Highloadblock\HighloadBlockTable::getList(["\163\x65\154\145\x63\x74" => ["\x2a"], "\x6f\162\x64\145\x72" => ["\116\101\115\x45" => "\x41\x53\x43"], "\x66\x69\x6c\x74\x65\x72" => ["\x54\101\102\x4c\x45\x5f\x4e\101\115\105" => $lmdy26lbugzee1htz7u5x]])->fetch())) {
                    break;
                }
                
                $mviwfco6601xp0iof88m4ncuhz = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($cuszy37936ongboj9d);
                $cen2jw = $mviwfco6601xp0iof88m4ncuhz->getDataClass();
                $f6oz4e280[$lmdy26lbugzee1htz7u5x] = new $cen2jw();
            }
            if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
                $s5g8s = [];
                $gm3vugm0jq54duz299d4x = [];
                foreach ($m4wva0122vk9vebdmr1s74ajls as $btzg598kh) {
                    $btzg598kh = trim($btzg598kh);
                    if (!isset($this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\x49\x44"]][$btzg598kh])) {
                        $gm3vugm0jq54duz299d4x[] = $btzg598kh;
                    } else {
                        $s5g8s[] = $this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\111\104"]][$btzg598kh];
                    }
                }
                if (count($gm3vugm0jq54duz299d4x)) {
                    $ukhke0aqs5hnwu503b5n = $f6oz4e280[$lmdy26lbugzee1htz7u5x]->getList(["\x66\151\154\x74\145\162" => ["\125\106\137\x58\x4d\x4c\137\111\104" => $gm3vugm0jq54duz299d4x]]);
                    while ($vc6pdfqtga = $ukhke0aqs5hnwu503b5n->fetch()) {
                        $this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\x49\104"]][$vc6pdfqtga["\125\x46\137\x58\x4d\x4c\x5f\x49\104"]] = $vc6pdfqtga["\111\x44"];
                        $s5g8s[] = $this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\x49\x44"]][$vc6pdfqtga["\x55\106\x5f\x58\x4d\114\x5f\111\104"]];
                    }
                }
                return implode("\54", $s5g8s);
            } else {
                $m4wva0122vk9vebdmr1s74ajls = trim($m4wva0122vk9vebdmr1s74ajls);
                if (!isset($this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls])) {
                    $this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls] = 0;
                    $ukhke0aqs5hnwu503b5n = $f6oz4e280[$lmdy26lbugzee1htz7u5x]->getList(["\146\x69\x6c\x74\x65\162" => ["\125\106\x5f\x58\115\114\137\111\104" => $m4wva0122vk9vebdmr1s74ajls]]);
                    if ($vc6pdfqtga = $ukhke0aqs5hnwu503b5n->fetch()) {
                        $this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\x49\x44"]][$vc6pdfqtga["\125\x46\x5f\x58\x4d\x4c\x5f\111\104"]] = $vc6pdfqtga["\x49\x44"];
                    }
                }
                return isset($this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\111\x44"]][$m4wva0122vk9vebdmr1s74ajls]) ? $this->arPrepiredPropHighloadXmlIdToId[$cre8zulorsrej0589m3o05t["\111\104"]][$m4wva0122vk9vebdmr1s74ajls] : "";
            }
        } while (false);
        
        if (is_array($m4wva0122vk9vebdmr1s74ajls)) {
            return implode("\54", array_diff($m4wva0122vk9vebdmr1s74ajls, [""]));
        } else {
            return $m4wva0122vk9vebdmr1s74ajls;
        }
    }
    
    public function getSiteUrl()
    {
        return $this->manager()->getSiteSchema($this->exportItem()->getSiteId()) . $this->manager()->getSiteHost($this->exportItem()->getSiteId());
    }
    
    public function htmlToText($rq8o64lejxr0l, $p9j8u92t7ld0jztle5fsjci2be = [])
    {
        
        $rq8o64lejxr0l = htmlspecialcharsBack(\HTMLToTxt($rq8o64lejxr0l, "", $p9j8u92t7ld0jztle5fsjci2be, false));
        
        $rq8o64lejxr0l = preg_replace("\x2f\x28\46\133\x61\x2d\x7a\x5d\x2b\73\x29\57", "\x20", $rq8o64lejxr0l);
        return $rq8o64lejxr0l;
    }
    
    public function getHtmlToTextDeleteRules()
    {
        $nq86uonzq9qbsmo2i0xa00 = [];
        $mcd40ze = $this->exportItem()->getDescriptionDeleteRules();
        foreach ($mcd40ze as $e5ug4271vfe4mg9cnw0pkevzmeapi0a) {
            switch ($e5ug4271vfe4mg9cnw0pkevzmeapi0a) {
                case "\111\x4d\107":
                    $nq86uonzq9qbsmo2i0xa00[] = "\57\x3c\x69\155\x67\x5b\136\x3e\x5d\x2a\x3f\76\x2f\151\x73";
                    break;
                case "\x4c\x49\116\x4b":
                    $nq86uonzq9qbsmo2i0xa00[] = "\x2f\x3c\141\x5b\136\76\x5d\x2a\77\76\56\x2a\x3f\x3c\x5c\57\x61\76\57\151\x73";
                    break;
                case "\x54\x41\102\x4c\x45":
                    $nq86uonzq9qbsmo2i0xa00[] = "\57\x3c\164\141\142\x6c\145\x5b\x5e\76\x5d\x2a\77\x3e\x28\56\x2a\77\51\74\x5c\57\x74\x61\142\154\x65\x3e\57\x69\163";
                    break;
            }
        }
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function getFormatedPrice($l741yevuv9zc)
    {
        if (function_exists("\103\x75\162\x72\145\x6e\143\171\x46\x6f\162\x6d\x61\x74")) {
            return \CurrencyFormat($l741yevuv9zc, $this->getCurrencyId());
        }
        return $this->preparePrice($l741yevuv9zc) . "\x20" . $this->getMessage("\120\x52\x49\103\x45\137\x43\x55\122\x52\x45\116\103\131\x5f\123\110\117\x52\x54\137\106\x4f\x52\x4d\101\124");
    }
    
    public function fillCatalogPrice(&$nq86uonzq9qbsmo2i0xa00, $p8v7hijob34zz0poahqnq4ewa)
    {
        $nq86uonzq9qbsmo2i0xa00["\x43\125\122\x52\105\116\103\131"] = $this->getCurrencyId();
        $nq86uonzq9qbsmo2i0xa00["\120\x52\111\103\x45"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\x50\122\111\x43\x45\x5f\x46\117\122\x4d\101\x54"] = "";
        $nq86uonzq9qbsmo2i0xa00["\x50\122\x49\103\x45\137\117\x4c\x44"] = "";
        $nq86uonzq9qbsmo2i0xa00["\120\x52\x49\x43\x45\x5f\117\x4c\104\137\x46\x4f\x52\x4d\101\x54"] = "";
        $nq86uonzq9qbsmo2i0xa00["\104\111\123\103\x4f\x55\x4e\124\x5f\120\122\x49\x43\x45"] = "";
        $nq86uonzq9qbsmo2i0xa00["\x44\x49\123\x43\x4f\x55\x4e\x54\137\120\122\x49\x43\105\x5f\x46\x4f\122\115\x41\124"] = "";
        $nq86uonzq9qbsmo2i0xa00["\104\111\123\103\x4f\x55\x4e\124\x5f\103\x55\122\x52\x45\x4e\103\x59"] = "";
        $nq86uonzq9qbsmo2i0xa00["\104\111\123\x43\x4f\x55\x4e\x54\x5f\x43\x55\x52\x52\x45\116\x43\x59\x5f\106\117\x52\x4d\101\x54"] = "";
        
        if (!$this->manager()->isInstalledCatalogModule()) {
            return $nq86uonzq9qbsmo2i0xa00;
        }
        
        $qqqrtd = $this->manager()->catalogPrice()->getList(["\146\x69\x6c\x74\145\162" => ["\x50\x52\x4f\104\x55\x43\124\x5f\x49\x44" => $p8v7hijob34zz0poahqnq4ewa], "\x73\x65\154\x65\x63\x74" => ["\x49\x44", "\x50\x52\117\x44\125\x43\124\137\111\x44", "\103\x55\x52\x52\x45\116\x43\131", "\x50\x52\111\x43\x45", "\103\x41\124\101\114\x4f\x47\x5f\x47\x52\x4f\x55\x50\137\111\x44"]]);
        while ($bfvmhhn = $qqqrtd->fetch()) {
            $nq86uonzq9qbsmo2i0xa00 = array_merge($nq86uonzq9qbsmo2i0xa00, $this->addPriceGroupPrefix($bfvmhhn["\x43\x41\x54\x41\x4c\117\x47\x5f\107\x52\x4f\125\x50\x5f\111\104"], $this->preparePriceGroup($bfvmhhn)));
        }
    }
    
    public function addPriceGroupPrefix($satjxapy, $bfvmhhn)
    {
        $nq86uonzq9qbsmo2i0xa00 = [];
        $pvyfb = "\103\101\x54\x41\x4c\117\107\137\x47\x52\x4f\x55\120\137" . $satjxapy . "\137";
        foreach ($bfvmhhn as $sialjw394a9grrujxq65 => $jlanqhf8lm12f838ybxi) {
            $nq86uonzq9qbsmo2i0xa00[$pvyfb . $sialjw394a9grrujxq65] = $jlanqhf8lm12f838ybxi;
        }
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function preparePriceGroup($bfvmhhn)
    {
        $nq86uonzq9qbsmo2i0xa00 = [
            "\x43\x55\x52\x52\105\x4e\x43\131" => $this->getCurrencyId(),
            //валюта
            "\x50\x52\x49\103\x45" => $bfvmhhn["\x50\x52\111\x43\105"],
            //цена
            "\120\122\111\103\105\x5f\117\x4c\x44" => "",
            //старая цена
            "\104\x49\123\103\117\125\116\124\137\120\x52\111\x43\x45" => "",
            // размер скидки в рублях
            "\x44\111\x53\x43\117\125\116\124\137\x50\x45\122\x43\x45\116\x54" => "",
            //размер скидки в процентах
            "\x50\122\111\103\105\x5f\106\x4f\122\115\x41\124" => "",
            "\120\x52\x49\103\x45\x5f\117\114\104\x5f\106\x4f\122\x4d\x41\124" => "",
            "\104\111\123\103\x4f\x55\116\124\137\120\x52\x49\x43\105\x5f\106\x4f\x52\x4d\x41\124" => "",
            "\x44\111\123\103\117\x55\x4e\124\x5f\120\x45\x52\x43\105\x4e\124\137\x46\117\x52\115\x41\124" => "",
        ];
        
        $nq86uonzq9qbsmo2i0xa00["\120\x52\x49\x43\x45"] = $this->getCurrencyConvertPrice($bfvmhhn["\120\x52\x49\x43\105"], $bfvmhhn["\103\125\x52\x52\x45\x4e\103\x59"]);
        
        $pege0knnnnv = $this->manager()->catalogDiscount()->GetDiscountByPrice($bfvmhhn["\x49\104"], [2], "\116", $this->exportItem()->getSiteId());
        $oe2hs6yikoquyqaell5w89w = $this->manager()->catalogProduct()->CountPriceWithDiscount($bfvmhhn["\x50\122\x49\x43\105"], $bfvmhhn["\x43\x55\122\x52\105\116\103\131"], $pege0knnnnv);
        $oe2hs6yikoquyqaell5w89w = $this->getCurrencyConvertPrice($oe2hs6yikoquyqaell5w89w, $bfvmhhn["\x43\125\x52\122\x45\116\103\x59"]);
        
        $oe2hs6yikoquyqaell5w89w = \Bitrix\Catalog\Product\Price::roundPrice($bfvmhhn["\103\101\x54\101\114\117\x47\137\x47\122\x4f\125\x50\x5f\x49\x44"], $oe2hs6yikoquyqaell5w89w, $bfvmhhn["\x43\x55\x52\122\x45\x4e\x43\131"]);
        if (intval($oe2hs6yikoquyqaell5w89w) && $oe2hs6yikoquyqaell5w89w < $nq86uonzq9qbsmo2i0xa00["\120\x52\x49\x43\x45"]) {
            $nq86uonzq9qbsmo2i0xa00["\x50\122\111\x43\105\x5f\x4f\x4c\x44"] = $nq86uonzq9qbsmo2i0xa00["\120\122\111\x43\105"];
            $nq86uonzq9qbsmo2i0xa00["\104\x49\123\x43\117\x55\116\124\x5f\x50\105\x52\x43\105\116\x54"] = round(floatval($nq86uonzq9qbsmo2i0xa00["\x50\122\x49\103\x45\x5f\117\x4c\104"] - $nq86uonzq9qbsmo2i0xa00["\120\x52\x49\103\x45"]) / $nq86uonzq9qbsmo2i0xa00["\x50\122\111\x43\105\x5f\x4f\x4c\104"] * 100);
            $nq86uonzq9qbsmo2i0xa00["\x44\x49\x53\x43\x4f\125\x4e\124\137\x50\122\x49\x43\105"] = round($nq86uonzq9qbsmo2i0xa00["\120\122\x49\103\x45\x5f\117\x4c\104"] - $nq86uonzq9qbsmo2i0xa00["\x50\x52\x49\103\x45"]);
        }
        $nq86uonzq9qbsmo2i0xa00["\x50\x52\x49\x43\105"] = $oe2hs6yikoquyqaell5w89w;
        $nq86uonzq9qbsmo2i0xa00["\120\122\x49\103\x45\x5f\106\117\x52\115\101\x54"] = $nq86uonzq9qbsmo2i0xa00["\x50\x52\111\103\105"];
        if (!!$nq86uonzq9qbsmo2i0xa00["\120\122\111\x43\105\137\x4f\x4c\104"]) {
            $nq86uonzq9qbsmo2i0xa00["\120\x52\111\103\x45\x5f\x4f\114\104\x5f\106\x4f\122\x4d\x41\x54"] = $nq86uonzq9qbsmo2i0xa00["\120\122\x49\103\105\137\117\x4c\x44"];
        }
        if (!!$nq86uonzq9qbsmo2i0xa00["\104\111\x53\103\x4f\x55\x4e\x54\137\120\122\111\x43\x45"]) {
            $nq86uonzq9qbsmo2i0xa00["\x44\x49\x53\x43\x4f\x55\x4e\x54\x5f\120\x52\111\103\105\x5f\106\x4f\x52\115\101\124"] = $nq86uonzq9qbsmo2i0xa00["\x44\x49\x53\x43\117\x55\x4e\124\x5f\x50\x52\x49\103\x45"];
        }
        if (!!$nq86uonzq9qbsmo2i0xa00["\x44\x49\x53\x43\x4f\x55\116\124\137\120\x45\122\x43\x45\116\124"]) {
            $nq86uonzq9qbsmo2i0xa00["\x44\x49\123\x43\x4f\125\x4e\x54\x5f\120\105\122\x43\105\x4e\124\x5f\x46\x4f\122\x4d\x41\x54"] = $nq86uonzq9qbsmo2i0xa00["\x44\111\123\103\117\125\x4e\x54\x5f\120\x45\122\x43\x45\116\124"] . "\x25";
        }
        
        $nq86uonzq9qbsmo2i0xa00["\x50\122\111\103\x45\137\x46\117\122\115\101\124"] = $this->getFormatedPrice($nq86uonzq9qbsmo2i0xa00["\x50\x52\111\103\x45"]);
        if (!!$nq86uonzq9qbsmo2i0xa00["\x50\x52\x49\x43\105\x5f\x4f\114\x44"]) {
            $nq86uonzq9qbsmo2i0xa00["\x50\122\111\103\105\137\x4f\114\104\x5f\x46\117\122\115\x41\x54"] = $this->getFormatedPrice($nq86uonzq9qbsmo2i0xa00["\120\122\x49\x43\105\x5f\117\114\x44"]);
        }
        if (!!$nq86uonzq9qbsmo2i0xa00["\104\111\x53\x43\x4f\125\x4e\x54\x5f\x50\x52\x49\103\105"]) {
            $nq86uonzq9qbsmo2i0xa00["\x44\111\x53\x43\x4f\x55\x4e\124\137\120\122\111\x43\105\137\106\x4f\x52\x4d\x41\x54"] = $this->getFormatedPrice($nq86uonzq9qbsmo2i0xa00["\x44\x49\x53\103\x4f\x55\116\124\x5f\120\x52\x49\x43\x45"]);
        }
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function getPriceGroupFields($edgy1vduw4is, $diefb3dkarctvftwub1el3gfan6db7)
    {
        $nq86uonzq9qbsmo2i0xa00 = [];
        $pvyfb = "\103\101\x54\x41\114\117\107\137\x47\122\x4f\x55\x50\137" . $edgy1vduw4is . "\x5f";
        $v5s00k = ["\103\125\x52\122\x45\116\x43\131", "\x50\122\x49\x43\105", "\120\x52\111\103\105\x5f\117\114\x44", "\104\111\x53\103\117\x55\116\x54\137\x50\122\x49\x43\105", "\104\111\x53\103\117\x55\116\x54\x5f\120\x45\122\x43\105\x4e\x54", "\120\x52\111\103\x45\137\106\117\x52\x4d\101\124", "\x50\122\x49\103\x45\137\117\114\x44\137\106\117\122\115\101\x54", "\x44\111\123\x43\x4f\x55\x4e\124\x5f\x50\122\x49\x43\x45\137\106\x4f\x52\115\x41\124", "\x44\111\x53\103\117\125\116\124\x5f\x50\105\x52\103\105\116\124\137\106\x4f\122\115\x41\124"];
        foreach ($v5s00k as $vaf3wf1zxulfio) {
            if (isset($diefb3dkarctvftwub1el3gfan6db7[$pvyfb . $vaf3wf1zxulfio])) {
                $nq86uonzq9qbsmo2i0xa00[$vaf3wf1zxulfio] = $diefb3dkarctvftwub1el3gfan6db7[$pvyfb . $vaf3wf1zxulfio];
            }
        }
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function calcPriceDiscount(&$zlepcfesz1rla843x48cba7qn2)
    {
        $zlepcfesz1rla843x48cba7qn2["\x50\122\x49\103\x45"] = floatval($zlepcfesz1rla843x48cba7qn2["\120\x52\111\x43\105"]);
        $zlepcfesz1rla843x48cba7qn2["\x50\x52\111\x43\x45\x5f\117\x4c\x44"] = floatval($zlepcfesz1rla843x48cba7qn2["\x50\x52\x49\103\105\137\x4f\x4c\x44"]);
        if ($zlepcfesz1rla843x48cba7qn2["\x50\122\x49\103\105"] > 0 && $zlepcfesz1rla843x48cba7qn2["\x50\x52\x49\103\x45\x5f\x4f\114\x44"] > 0) {
            $zlepcfesz1rla843x48cba7qn2["\104\x49\x53\103\x4f\125\x4e\124\x5f\120\105\122\x43\105\116\124"] = round(floatval($zlepcfesz1rla843x48cba7qn2["\120\122\111\x43\x45\137\117\114\104"] - $zlepcfesz1rla843x48cba7qn2["\x50\x52\111\x43\105"]) / $zlepcfesz1rla843x48cba7qn2["\120\x52\x49\x43\105\137\x4f\x4c\x44"] * 100);
            $zlepcfesz1rla843x48cba7qn2["\x44\111\123\x43\x4f\x55\x4e\x54\x5f\x50\122\x49\x43\x45"] = round($zlepcfesz1rla843x48cba7qn2["\120\122\x49\103\x45\x5f\x4f\114\x44"] - $zlepcfesz1rla843x48cba7qn2["\120\122\x49\103\x45"]);
            $zlepcfesz1rla843x48cba7qn2["\x44\x49\123\103\x4f\x55\116\x54\x5f\x50\122\111\103\x45\137\x46\117\122\115\101\124"] = $this->getFormatedPrice($zlepcfesz1rla843x48cba7qn2["\x44\x49\123\103\x4f\125\x4e\x54\x5f\120\x52\111\103\x45"]);
            $zlepcfesz1rla843x48cba7qn2["\x44\x49\x53\x43\117\125\116\124\x5f\120\105\x52\103\x45\x4e\x54\x5f\x46\117\x52\115\x41\x54"] = $zlepcfesz1rla843x48cba7qn2["\x44\111\123\103\x4f\125\x4e\124\137\120\105\x52\103\x45\x4e\x54"] . "\45";
        } else {
            $zlepcfesz1rla843x48cba7qn2["\x50\x52\111\103\105\137\117\114\104"] = "";
            $zlepcfesz1rla843x48cba7qn2["\x44\111\x53\103\x4f\125\x4e\124\x5f\x50\x45\122\x43\x45\116\x54"] = "";
            $zlepcfesz1rla843x48cba7qn2["\104\x49\123\103\117\125\x4e\124\137\x50\x52\111\103\105"] = "";
            $zlepcfesz1rla843x48cba7qn2["\120\122\111\x43\105\x5f\x4f\114\x44\137\x46\117\x52\x4d\x41\x54"] = "";
            $zlepcfesz1rla843x48cba7qn2["\104\111\123\103\x4f\x55\116\x54\x5f\x50\x52\x49\103\105\x5f\x46\117\122\115\x41\x54"] = "";
            $zlepcfesz1rla843x48cba7qn2["\104\x49\x53\103\x4f\x55\116\124\137\x50\x45\x52\103\x45\116\x54\137\106\117\122\x4d\101\x54"] = "";
        }
    }
    
    public function fillCatalogStoreDimensions(&$nq86uonzq9qbsmo2i0xa00, $p8v7hijob34zz0poahqnq4ewa)
    {
        $nq86uonzq9qbsmo2i0xa00["\103\101\x54\101\114\117\x47\137\x57\105\x49\x47\110\124"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\x43\x41\124\101\114\117\107\x5f\127\111\104\x54\110"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\x43\x41\124\x41\114\117\107\137\110\x45\111\x47\x48\x54"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\x43\x41\x54\101\x4c\x4f\107\x5f\x4c\105\x4e\x47\124\110"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\x43\101\124\101\114\117\x47\x5f\x4d\105\x41\x53\125\122\x45"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\103\x41\x54\x41\114\117\x47\x5f\115\x45\101\x53\x55\x52\105\x5f\x4e\101\x4d\105"] = "";
        $nq86uonzq9qbsmo2i0xa00["\x43\101\124\101\x4c\117\x47\137\x51\125\x41\116\124\x49\x54\131"] = 0;
        $nq86uonzq9qbsmo2i0xa00["\103\x41\x54\x41\114\117\107\x5f\x41\126\101\x49\114\x41\x42\x4c\x45"] = $this->getMessage("\116\x4f");
        if ($this->manager()->isInstalledCatalogModule()) {
            $q867dmd5 = \Bitrix\Catalog\Model\Product::getList(["\x66\151\154\164\145\x72" => ["\x49\x44" => $p8v7hijob34zz0poahqnq4ewa], "\x73\145\154\145\143\164" => ["\111\104", "\121\x55\101\116\x54\x49\124\131", "\101\126\x41\111\x4c\101\x42\114\105", "\x57\105\x49\x47\110\x54", "\127\111\104\x54\110", "\110\105\x49\107\x48\x54", "\114\105\116\x47\124\110", "\x4d\105\x41\123\x55\122\105"]]);
            while ($zlepcfesz1rla843x48cba7qn2 = $q867dmd5->fetch()) {
                $nq86uonzq9qbsmo2i0xa00["\x43\101\x54\x41\114\x4f\x47\x5f\x57\105\x49\107\110\x54"] = intval($zlepcfesz1rla843x48cba7qn2["\127\105\x49\x47\x48\124"]);
                $nq86uonzq9qbsmo2i0xa00["\x43\101\x54\x41\114\117\107\137\127\x49\x44\x54\x48"] = intval($zlepcfesz1rla843x48cba7qn2["\x57\111\104\x54\110"]);
                $nq86uonzq9qbsmo2i0xa00["\x43\101\124\x41\114\117\x47\x5f\x48\105\x49\107\110\x54"] = intval($zlepcfesz1rla843x48cba7qn2["\110\x45\111\107\x48\x54"]);
                $nq86uonzq9qbsmo2i0xa00["\x43\101\124\101\x4c\117\107\x5f\114\x45\x4e\107\x54\110"] = intval($zlepcfesz1rla843x48cba7qn2["\x4c\105\116\107\x54\110"]);
                $nq86uonzq9qbsmo2i0xa00["\103\101\124\x41\x4c\117\x47\137\x4d\x45\101\123\125\122\105"] = intval($zlepcfesz1rla843x48cba7qn2["\x4d\x45\x41\x53\x55\x52\105"]);
                $nq86uonzq9qbsmo2i0xa00["\x43\x41\x54\101\114\117\107\x5f\115\x45\101\123\125\122\x45\x5f\x4e\x41\115\105"] = $this->manager()->getMeasureName(intval($zlepcfesz1rla843x48cba7qn2["\115\x45\101\x53\125\122\105"]));
                $nq86uonzq9qbsmo2i0xa00["\x43\101\124\x41\114\x4f\x47\x5f\121\x55\101\x4e\x54\x49\124\131"] = intval($zlepcfesz1rla843x48cba7qn2["\121\x55\101\x4e\x54\x49\124\x59"]);
                $nq86uonzq9qbsmo2i0xa00["\103\101\124\101\x4c\x4f\107\137\x41\x56\101\111\114\101\x42\114\x45"] = $zlepcfesz1rla843x48cba7qn2["\x41\x56\101\x49\x4c\x41\102\x4c\105"] == "\116" ? $this->getMessage("\x4e\117") : $this->getMessage("\131\105\x53");
            }
            
            if (class_exists("\x5c\x43\103\141\x74\x61\154\157\147\123\x74\157\x72\x65\120\162\157\144\165\x63\164")) {
                $y2u5igtgaw06zf8updthkjkh7dvo71 = \Bitrix\Catalog\StoreProductTable::getList(["\x66\151\154\x74\x65\x72" => ["\75\x50\x52\x4f\x44\x55\x43\x54\137\111\104" => $p8v7hijob34zz0poahqnq4ewa], "\163\x65\x6c\145\143\164" => ["\x50\122\117\x44\125\103\124\x5f\111\104", "\123\x54\x4f\122\x45\137\111\104", "\x41\115\x4f\x55\x4e\124"]]);
                while ($u6qdqswrk8rre80inz5e = $y2u5igtgaw06zf8updthkjkh7dvo71->fetch()) {
                    $nq86uonzq9qbsmo2i0xa00["\x43\101\124\x41\114\x4f\107\x5f\x53\x54\117\x52\x45\137" . $u6qdqswrk8rre80inz5e["\x53\x54\117\x52\x45\137\111\x44"]] = intval($u6qdqswrk8rre80inz5e["\x41\x4d\x4f\125\x4e\124"]);
                }
            }
        }
    }
    
    public function fillVariants(&$rewhklyoypc3yth2e7lprhccbnev)
    {
        $rewhklyoypc3yth2e7lprhccbnev["\x56\x41\122\111\101\x4e\x54\123"] = [];
        $m0r2g7f = $this->exportItem()->getPropertyIds();
        
        foreach ($m0r2g7f as $ppjchr8) {
            if (!empty($rewhklyoypc3yth2e7lprhccbnev["\x50\122\x4f\x50\105\122\124\131\x5f" . $ppjchr8 . "\x5f\x45\x4e\125\x4d\137\111\104"])) {
                $fuwcr0k = explode("\x2c", $rewhklyoypc3yth2e7lprhccbnev["\x50\122\117\120\x45\122\x54\x59\x5f" . $ppjchr8 . "\x5f\x45\116\125\x4d\137\111\104"]);
                $j174tkpt2ehv1bhulyb06zl4w4ekcyrno = reset($fuwcr0k);
                
                $iaimtbdviv0cs3z72q6ymppxtg8i1b5b3 = $this->propertyVariantTable()->getList(["\x66\x69\154\164\x65\162" => ["\x47\122\x4f\x55\x50\137\x49\104" => $this->exportItem()->getGroupId(), "\120\x52\117\x50\105\122\x54\x59\137\x49\x44" => $ppjchr8, "\105\x4e\125\x4d\x5f\x49\104" => $j174tkpt2ehv1bhulyb06zl4w4ekcyrno], "\x73\145\x6c\145\x63\164" => ["\x50\x52\117\x50\x45\x52\124\x59\137\x49\x44", "\105\116\x55\115\x5f\111\x44", "\x56\x4b\137\x56\101\122\111\101\x4e\x54\137\111\x44"], "\154\x69\x6d\x69\x74" => 1])->fetch();
                if ($iaimtbdviv0cs3z72q6ymppxtg8i1b5b3) {
                    $rewhklyoypc3yth2e7lprhccbnev["\x56\101\122\111\x41\x4e\x54\123"][] = $iaimtbdviv0cs3z72q6ymppxtg8i1b5b3;
                }
            }
        }
    }
    
    public function getElementSections()
    {
        $nq86uonzq9qbsmo2i0xa00 = [];
        $w4mx92o0rt0hoqt37d716zzf0r5 = $this->manager()->iblockElementSection()->getList(["\146\151\154\x74\145\162" => ["\111\x42\x4c\117\103\x4b\x5f\105\x4c\105\x4d\x45\x4e\x54\x5f\111\x44" => $this->productId]]);
        while ($gmh54dglsfqqm09okw2 = $w4mx92o0rt0hoqt37d716zzf0r5->fetch()) {
            $nq86uonzq9qbsmo2i0xa00[] = $gmh54dglsfqqm09okw2["\111\102\114\x4f\103\113\137\123\105\x43\x54\111\117\116\x5f\x49\104"];
        }
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function getAlbums()
    {
        $nq86uonzq9qbsmo2i0xa00 = [];
        $ybrk0yffsq2zkpqoj07tdml8wj2c = $this->goodReferenceAlbum()->getTable()->getList(["\163\x65\154\145\x63\164" => ["\52", "\x56\113\137\x49\x44" => "\x41\114\102\125\115\137\105\x58\x50\x4f\122\x54\x2e\x56\x4b\137\x49\x44", "\101\x4c\x42\x55\115\x5f\120\101\122\x41\x4d\123" => "\x41\114\102\x55\115\56\x50\101\122\x41\x4d\123"], "\146\151\154\x74\145\x72" => ["\x50\122\117\104\x55\x43\124\x5f\x49\104" => $this->getProductId(), "\x4f\x46\x46\x45\122\x5f\111\104" => $this->getOfferIds(), "\41\126\x4b\137\x49\104" => null], "\162\165\x6e\164\151\155\x65" => [new \Bitrix\Main\Entity\ReferenceField("\101\114\x42\x55\115\x5f\105\130\120\117\x52\124", "\134\126\x4b\141\x70\151\x5c\115\x61\162\153\145\164\134\x41\154\142\165\x6d\x5c\x45\170\x70\x6f\162\x74\x54\x61\x62\x6c\x65", ["\75\x74\x68\151\163\56\x41\x4c\x42\x55\115\137\111\x44" => "\162\x65\x66\x2e\101\x4c\102\125\115\137\x49\x44", "\x3d\x72\145\146\x2e\x47\122\117\x55\x50\137\111\104" => new \Bitrix\Main\DB\SqlExpression("\x3f\151", $this->exportItem()->getGroupId())], ["\x6a\x6f\151\x6e\x5f\164\171\x70\x65" => "\x4c\105\106\124"])]]);
        while ($ab72f0tx9d279xtz0d0r8vf = $ybrk0yffsq2zkpqoj07tdml8wj2c->fetch()) {
            $nq86uonzq9qbsmo2i0xa00[$ab72f0tx9d279xtz0d0r8vf["\111\x44"]] = ["\111\104" => $ab72f0tx9d279xtz0d0r8vf["\111\104"], "\101\x4c\x42\125\x4d\x5f\111\104" => $ab72f0tx9d279xtz0d0r8vf["\101\x4c\x42\125\115\137\111\104"], "\x56\113\137\x49\104" => $ab72f0tx9d279xtz0d0r8vf["\x56\x4b\x5f\111\x44"], "\103\x41\124\105\107\x4f\x52\x59\137\111\x44" => $ab72f0tx9d279xtz0d0r8vf["\x41\114\x42\125\x4d\137\120\101\x52\x41\115\x53"]["\103\101\124\x45\x47\117\x52\x59\x5f\111\x44"]];
        }
        return $nq86uonzq9qbsmo2i0xa00;
    }
    
    public function getAlbumsVkIds()
    {
        return array_column($this->getAlbums(), "\x56\x4b\137\111\x44");
    }
    
    public function getFields()
    {
        $diefb3dkarctvftwub1el3gfan6db7 = ["\x6f\167\156\x65\162\137\151\144" => "\55" . $this->exportItem()->getGroupId(), "\x70\x72\x69\x63\145" => $this->getFieldPrice(), "\x70\x72\x69\x63\145\137\x66\x6f\162\x6d\x61\164" => "", "\157\154\x64\x5f\x70\162\x69\x63\145" => $this->getFieldOldPrice(), "\x6f\154\x64\x5f\160\162\x69\x63\x65\137\146\x6f\162\x6d\x61\x74" => 0, "\x6e\x61\155\145" => $this->getFieldName(), "\143\141\x74\x65\147\x6f\x72\x79\x5f\x69\x64" => $this->getFieldCategoryId(), "\144\145\154\x65\x74\x65\x64" => $this->getFieldDeleted(), "\x64\x65\x73\x63\162\x69\x70\164\x69\157\x6e" => $this->getFieldDescription(), "\x75\162\154" => $this->getFieldUrl(), "\155\141\151\156\137\x70\x68\x6f\164\x6f\137\x69\144" => $this->getFieldMainPhotoId(), "\160\x68\157\x74\x6f\x5f\151\144\x73" => $this->getFieldPhotoIds(), "\144\151\x6d\x65\156\x73\151\x6f\x6e\x5f\167\151\144\164\x68" => $this->getFieldDimensionWidth(), "\x64\151\155\145\156\x73\151\157\x6e\x5f\150\x65\x69\147\x68\x74" => $this->getFieldDimensionHeight(), "\x64\151\x6d\x65\x6e\x73\x69\x6f\x6e\x5f\154\145\156\147\x74\x68" => $this->getFieldDimensionLength(), "\x77\x65\151\147\x68\164" => $this->getFieldDimensionWeight(), "\163\153\x75" => $this->getFieldSku(), "\x73\164\157\143\153\x5f\141\155\157\x75\x6e\x74" => $this->getFieldStockAmount()];
        if ($this->exportItem()->isEnabledExtendedGoods()) {
            $diefb3dkarctvftwub1el3gfan6db7["\x76\141\x72\x69\141\156\164\x5f\151\x64\x73"] = $this->getVariantIds();
        }
        $diefb3dkarctvftwub1el3gfan6db7["\160\162\x69\x63\x65\137\146\157\162\155\x61\x74"] = $this->getFormatedPrice($diefb3dkarctvftwub1el3gfan6db7["\160\x72\151\143\145"]);
        if ($diefb3dkarctvftwub1el3gfan6db7["\x6f\x6c\x64\137\160\x72\x69\x63\x65"] <= 0) {
            unset($diefb3dkarctvftwub1el3gfan6db7["\x6f\x6c\144\x5f\160\x72\151\143\x65"]);
            unset($diefb3dkarctvftwub1el3gfan6db7["\157\x6c\x64\x5f\160\x72\151\143\145\x5f\x66\157\162\155\141\x74"]);
        }
        if ($this->isOffer()) {
            $jwmiio7qt8wg5wjfs87 = [];
            foreach ($this->getOfferIds() as $zvhkvc87600p0zq4fhfj7e4n28pr) {
                $jwmiio7qt8wg5wjfs87 = $this->getOfferData($zvhkvc87600p0zq4fhfj7e4n28pr);
            }
            [$wiydq2] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_AFTER_PREPARE_FIELDS_VK_FROM_OFFER, ["\x61\x72\x46\151\x65\154\144\163" => $diefb3dkarctvftwub1el3gfan6db7, "\x61\162\105\x78\160\x6f\162\x74\104\x61\164\x61" => $this->exportItem()->getData(), "\141\162\x50\162\157\x64\x75\x63\164" => $this->getProductData(), "\x61\162\117\x66\x66\x65\x72\x73" => $jwmiio7qt8wg5wjfs87, "\x67\x6f\x6f\144\105\170\160\157\x72\164\111\x74\145\x6d" => $this], true);
        } else {
            [$wiydq2] = $this->manager()->sendEvent(\VKapi\Market\Manager::EVENT_ON_AFTER_PREPARE_FIELDS_VK_FROM_PRODUCT, ["\141\x72\x46\x69\145\x6c\x64\163" => $diefb3dkarctvftwub1el3gfan6db7, "\x61\162\105\170\160\x6f\162\164\104\x61\164\x61" => $this->exportItem()->getData(), "\141\x72\120\162\157\x64\165\143\x74" => $this->getProductData(), "\147\157\x6f\144\105\170\x70\x6f\162\164\111\164\x65\x6d" => $this], true);
        }
        if (is_array($diefb3dkarctvftwub1el3gfan6db7) && isset($wiydq2["\157\x77\x6e\x65\162\137\x69\144"])) {
            $diefb3dkarctvftwub1el3gfan6db7 = $wiydq2;
        }
        return $diefb3dkarctvftwub1el3gfan6db7;
    }
    
    public function getFieldPrice()
    {
        $l741yevuv9zc = 0;
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $qt40zjmqkbuwwff = $this->exportItem()->getOfferPrice();
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            if (preg_match("\x2f\136\120\x52\x49\x43\x45\137\57", $qt40zjmqkbuwwff)) {
                $l741yevuv9zc = $rewhklyoypc3yth2e7lprhccbnev["\x50\x52\111\103\105"];
            } elseif (isset($rewhklyoypc3yth2e7lprhccbnev[$qt40zjmqkbuwwff])) {
                $l741yevuv9zc = $rewhklyoypc3yth2e7lprhccbnev[$qt40zjmqkbuwwff];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$qt40zjmqkbuwwff])) {
                $l741yevuv9zc = $zlepcfesz1rla843x48cba7qn2[$qt40zjmqkbuwwff];
            }
        } else {
            $qt40zjmqkbuwwff = $this->exportItem()->getProductPrice();
            if (preg_match("\57\x5e\120\x52\x49\x43\x45\137\x2f", $qt40zjmqkbuwwff)) {
                $l741yevuv9zc = $zlepcfesz1rla843x48cba7qn2["\x50\122\111\103\x45"];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$qt40zjmqkbuwwff])) {
                $l741yevuv9zc = $zlepcfesz1rla843x48cba7qn2[$qt40zjmqkbuwwff];
            }
        }
        return $this->preparePrice($l741yevuv9zc);
    }
    
    public function getFieldOldPrice()
    {
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $l741yevuv9zc = $rewhklyoypc3yth2e7lprhccbnev["\120\x52\x49\103\x45\137\117\114\x44"];
        } else {
            $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
            $l741yevuv9zc = $zlepcfesz1rla843x48cba7qn2["\x50\122\x49\103\105\137\117\x4c\104"];
        }
        return $this->preparePrice($l741yevuv9zc);
    }
    
    public function preparePrice($l741yevuv9zc)
    {
        $l741yevuv9zc = str_replace(["\x20"], [""], $l741yevuv9zc);
        $l741yevuv9zc = number_format(floatval($l741yevuv9zc), 2, "\x2e", "");
        return (float) $l741yevuv9zc;
    }
    
    public function getFieldName()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$this->exportItem()->getOfferName()])) {
                $bb0afkg = $rewhklyoypc3yth2e7lprhccbnev[$this->exportItem()->getOfferName()];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$this->exportItem()->getOfferName()])) {
                $bb0afkg = $zlepcfesz1rla843x48cba7qn2[$this->exportItem()->getOfferName()];
            } else {
                $bb0afkg = $rewhklyoypc3yth2e7lprhccbnev["\x4f\106\x46\105\122\x5f\116\101\x4d\105"];
            }
        } else {
            $bb0afkg = trim($zlepcfesz1rla843x48cba7qn2[$this->exportItem()->getProductName()]) ?: $zlepcfesz1rla843x48cba7qn2["\120\122\x4f\x44\x55\103\x54\137\x4e\101\x4d\105"];
        }
        
        $bb0afkg = $this->manager()->truncateTextVK(strval($bb0afkg), 99);
        return $bb0afkg;
    }
    
    public function getFieldCategoryId()
    {
        $u2ydyxqgtjeag181pkviqz70s4j6q3vai5 = $this->exportItem()->getCategoryId();
        $d069sfuz0vqy3o0usx = $this->getAlbums();
        $pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh = array_column($d069sfuz0vqy3o0usx, "\103\x41\x54\105\107\x4f\122\x59\137\111\104");
        $pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh = array_map("\x69\156\164\166\x61\x6c", $pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh);
        $pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh = array_diff($pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh, [0]);
        if (count($pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh)) {
            $u2ydyxqgtjeag181pkviqz70s4j6q3vai5 = reset($pvh6oo20pc1yybh7l52dmtzyv0p8lddnrh);
        }
        return (int) $u2ydyxqgtjeag181pkviqz70s4j6q3vai5;
    }
    
    public function getFieldDeleted()
    {
        return (int) 0;
    }
    
    public function getFieldDescription()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $tfg6vqktdh30uihu0llcrb7wbs = [];
            if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
                foreach ($this->getOfferIds() as $zvhkvc87600p0zq4fhfj7e4n28pr) {
                    $tfg6vqktdh30uihu0llcrb7wbs[] = $this->getOfferData($zvhkvc87600p0zq4fhfj7e4n28pr);
                }
            } else {
                $tfg6vqktdh30uihu0llcrb7wbs[] = $this->getOfferData($this->getOfferId());
            }
            $rq8o64lejxr0l = $this->description()->getOffersText($zlepcfesz1rla843x48cba7qn2, $tfg6vqktdh30uihu0llcrb7wbs);
            if (strlen($rq8o64lejxr0l) < 10) {
                $rq8o64lejxr0l = $this->exportItem()->getOfferDefaultText();
            }
        } else {
            $rq8o64lejxr0l = $this->description()->getProductText($zlepcfesz1rla843x48cba7qn2);
            if (strlen($rq8o64lejxr0l) < 10) {
                $rq8o64lejxr0l = $this->exportItem()->getProductDefaultText();
            }
        }
        $rq8o64lejxr0l = $this->manager()->truncateText($rq8o64lejxr0l, $this->manager()->getDescriptionLengthLimit());
        return (string) $rq8o64lejxr0l;
    }
    
    public function getFieldUrl()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        return (string) $zlepcfesz1rla843x48cba7qn2["\120\x52\117\x44\x55\x43\x54\137\x44\105\x54\x41\111\x4c\137\120\x41\x47\x45\137\125\122\114"];
    }
    
    public function getFieldMainPhotoId()
    {
        $n11zc37sdkjk518xq9xe30ug3cvayss21ik = [];
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $kc2879hk7rwp01z = $this->exportItem()->getOfferPhoto();
            foreach ($this->getOfferIds() as $zvhkvc87600p0zq4fhfj7e4n28pr) {
                $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($zvhkvc87600p0zq4fhfj7e4n28pr);
                if (array_key_exists($kc2879hk7rwp01z . "\x5f\x46\x49\x44", $zlepcfesz1rla843x48cba7qn2)) {
                    $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_merge($n11zc37sdkjk518xq9xe30ug3cvayss21ik, (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z . "\x5f\x46\x49\x44"]);
                } elseif (array_key_exists($kc2879hk7rwp01z, $zlepcfesz1rla843x48cba7qn2)) {
                    $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_merge($n11zc37sdkjk518xq9xe30ug3cvayss21ik, (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z]);
                } elseif (array_key_exists($kc2879hk7rwp01z . "\137\106\x49\104", $rewhklyoypc3yth2e7lprhccbnev)) {
                    $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_merge($n11zc37sdkjk518xq9xe30ug3cvayss21ik, (array) $rewhklyoypc3yth2e7lprhccbnev[$kc2879hk7rwp01z . "\x5f\x46\111\104"]);
                } elseif (array_key_exists($kc2879hk7rwp01z, $rewhklyoypc3yth2e7lprhccbnev)) {
                    $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_merge($n11zc37sdkjk518xq9xe30ug3cvayss21ik, (array) $rewhklyoypc3yth2e7lprhccbnev[$kc2879hk7rwp01z]);
                }
            }
        } else {
            
            $kc2879hk7rwp01z = $this->exportItem()->getProductPhoto();
            if (isset($zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z . "\x5f\106\x49\104"])) {
                $n11zc37sdkjk518xq9xe30ug3cvayss21ik = (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z . "\137\x46\x49\x44"];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z])) {
                $n11zc37sdkjk518xq9xe30ug3cvayss21ik = (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z];
            }
        }
        $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_map("\x69\x6e\164\x76\141\x6c", $n11zc37sdkjk518xq9xe30ug3cvayss21ik);
        $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_diff($n11zc37sdkjk518xq9xe30ug3cvayss21ik, [0]);
        $n11zc37sdkjk518xq9xe30ug3cvayss21ik = array_slice(array_unique($n11zc37sdkjk518xq9xe30ug3cvayss21ik), 0, 1);
        if ($this->exportItem()->isPreviewMode()) {
            $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9 = $this->photo()->prepareProductFiles($n11zc37sdkjk518xq9xe30ug3cvayss21ik);
            $b9stu6fduwoziaz70bsihur = $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9->getData("\x69\164\145\155\163");
            if (count($b9stu6fduwoziaz70bsihur)) {
                $mzk88fd28g1byx26vx99amh30xh = reset($b9stu6fduwoziaz70bsihur);
                if ($mzk88fd28g1byx26vx99amh30xh->isSuccess()) {
                    return $mzk88fd28g1byx26vx99amh30xh->getData();
                }
            }
            return [];
        } else {
            
            $zvhkvc87600p0zq4fhfj7e4n28pr = $this->getOfferId();
            if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
                $zvhkvc87600p0zq4fhfj7e4n28pr = 0;
            }
            $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9 = $this->photo()->exportProductPictures($n11zc37sdkjk518xq9xe30ug3cvayss21ik, true, $this->getProductId(), $zvhkvc87600p0zq4fhfj7e4n28pr);
            $b9stu6fduwoziaz70bsihur = $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9->getData("\151\164\x65\155\x73");
            if (count($b9stu6fduwoziaz70bsihur)) {
                $mzk88fd28g1byx26vx99amh30xh = reset($b9stu6fduwoziaz70bsihur);
                if ($mzk88fd28g1byx26vx99amh30xh->isSuccess()) {
                    return $mzk88fd28g1byx26vx99amh30xh->getData("\120\x48\x4f\x54\117\137\x49\104");
                }
            }
            return 0;
        }
    }
    
    public function getFieldPhotoIds()
    {
        $em1cr4y7sgvlei7wy3ky0 = [];
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $kc2879hk7rwp01z = $this->exportItem()->getOfferMorePhoto();
            foreach ($this->getOfferIds() as $zvhkvc87600p0zq4fhfj7e4n28pr) {
                $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($zvhkvc87600p0zq4fhfj7e4n28pr);
                if (array_key_exists($kc2879hk7rwp01z . "\137\106\111\104", $zlepcfesz1rla843x48cba7qn2)) {
                    $em1cr4y7sgvlei7wy3ky0 = array_merge($em1cr4y7sgvlei7wy3ky0, (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z . "\137\x46\x49\104"]);
                } elseif (array_key_exists($kc2879hk7rwp01z, $zlepcfesz1rla843x48cba7qn2)) {
                    $em1cr4y7sgvlei7wy3ky0 = array_merge($em1cr4y7sgvlei7wy3ky0, (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z]);
                } elseif (array_key_exists($kc2879hk7rwp01z . "\137\x46\x49\x44", $rewhklyoypc3yth2e7lprhccbnev)) {
                    $em1cr4y7sgvlei7wy3ky0 = array_merge($em1cr4y7sgvlei7wy3ky0, (array) $rewhklyoypc3yth2e7lprhccbnev[$kc2879hk7rwp01z . "\x5f\x46\x49\104"]);
                } elseif (array_key_exists($kc2879hk7rwp01z, $rewhklyoypc3yth2e7lprhccbnev)) {
                    $em1cr4y7sgvlei7wy3ky0 = array_merge($em1cr4y7sgvlei7wy3ky0, (array) $rewhklyoypc3yth2e7lprhccbnev[$kc2879hk7rwp01z]);
                }
            }
        } else {
            
            $kc2879hk7rwp01z = $this->exportItem()->getProductMorePhoto();
            if (isset($zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z . "\x5f\106\111\x44"])) {
                $em1cr4y7sgvlei7wy3ky0 = (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z . "\x5f\x46\111\x44"];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z])) {
                $em1cr4y7sgvlei7wy3ky0 = (array) $zlepcfesz1rla843x48cba7qn2[$kc2879hk7rwp01z];
            }
        }
        $em1cr4y7sgvlei7wy3ky0 = array_map("\151\x6e\x74\x76\141\154", $em1cr4y7sgvlei7wy3ky0);
        $em1cr4y7sgvlei7wy3ky0 = array_diff($em1cr4y7sgvlei7wy3ky0, [0]);
        $em1cr4y7sgvlei7wy3ky0 = array_slice(array_unique($em1cr4y7sgvlei7wy3ky0), 0, 4);
        if ($this->exportItem()->isPreviewMode()) {
            $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9 = $this->photo()->prepareProductFiles($em1cr4y7sgvlei7wy3ky0);
            $b9stu6fduwoziaz70bsihur = $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9->getData("\x69\164\145\155\163");
            if (count($b9stu6fduwoziaz70bsihur)) {
                $nq86uonzq9qbsmo2i0xa00 = [];
                foreach ($b9stu6fduwoziaz70bsihur as $mzk88fd28g1byx26vx99amh30xh) {
                    if ($mzk88fd28g1byx26vx99amh30xh->isSuccess()) {
                        $nq86uonzq9qbsmo2i0xa00[] = $mzk88fd28g1byx26vx99amh30xh->getData();
                    }
                }
                return $nq86uonzq9qbsmo2i0xa00;
            }
            return [];
        } else {
            
            $zvhkvc87600p0zq4fhfj7e4n28pr = $this->getOfferId();
            if ($this->exportItem()->isEnabledOfferCombine() && !$this->exportItem()->isEnabledExtendedGoods()) {
                $zvhkvc87600p0zq4fhfj7e4n28pr = 0;
            }
            $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9 = $this->photo()->exportProductPictures($em1cr4y7sgvlei7wy3ky0, false, $this->getProductId(), $zvhkvc87600p0zq4fhfj7e4n28pr);
            $b9stu6fduwoziaz70bsihur = $am7n9ex9izy0yt6g5jx2fvdp6oe5i1f9->getData("\151\x74\145\x6d\x73");
            if (count($b9stu6fduwoziaz70bsihur)) {
                $nq86uonzq9qbsmo2i0xa00 = [];
                foreach ($b9stu6fduwoziaz70bsihur as $mzk88fd28g1byx26vx99amh30xh) {
                    if ($mzk88fd28g1byx26vx99amh30xh->isSuccess()) {
                        $nq86uonzq9qbsmo2i0xa00[] = $mzk88fd28g1byx26vx99amh30xh->getData("\x50\x48\x4f\124\x4f\137\111\104");
                    }
                }
                return implode("\x2c", $nq86uonzq9qbsmo2i0xa00);
            }
            return "";
        }
    }
    
    public function getFieldDimensionWidth()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $rpgkzyhkgu = $this->exportItem()->getOfferWidth();
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu])) {
                return (int) $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        } else {
            $rpgkzyhkgu = $this->exportItem()->getProductWidth();
            if (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        return 0;
    }
    
    public function getFieldDimensionHeight()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $rpgkzyhkgu = $this->exportItem()->getOfferHeight();
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu])) {
                return (int) $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        } else {
            $rpgkzyhkgu = $this->exportItem()->getProductHeight();
            if (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        return 0;
    }
    
    public function getFieldDimensionLength()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $rpgkzyhkgu = $this->exportItem()->getOfferLength();
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu])) {
                return (int) $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        } else {
            $rpgkzyhkgu = $this->exportItem()->getProductLength();
            if (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        return 0;
    }
    
    public function getFieldDimensionWeight()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $rpgkzyhkgu = $this->exportItem()->getOfferWeight();
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu])) {
                return (int) $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        } else {
            $rpgkzyhkgu = $this->exportItem()->getProductWeight();
            if (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        return 0;
    }
    
    public function getFieldSku()
    {
        $svitv2tued6gn8u31iuxb97ltucru8fqxn1 = "";
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $rpgkzyhkgu = $this->exportItem()->getOfferSku();
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu])) {
                $svitv2tued6gn8u31iuxb97ltucru8fqxn1 = $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu];
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                $svitv2tued6gn8u31iuxb97ltucru8fqxn1 = $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        } else {
            $rpgkzyhkgu = $this->exportItem()->getProductSku();
            if (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                $svitv2tued6gn8u31iuxb97ltucru8fqxn1 = $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu];
            }
        }
        return trim($svitv2tued6gn8u31iuxb97ltucru8fqxn1);
    }
    
    public function getVariantIds()
    {
        $x2oh2176c9b40g3u2t = [];
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $x2oh2176c9b40g3u2t = array_column($rewhklyoypc3yth2e7lprhccbnev["\126\x41\x52\111\x41\x4e\124\123"], "\126\113\137\x56\x41\122\x49\101\x4e\124\137\x49\x44");
        }
        return implode("\54", $x2oh2176c9b40g3u2t);
    }
    
    public function getFieldStockAmount()
    {
        $zlepcfesz1rla843x48cba7qn2 = $this->getProductData();
        if ($this->isOffer()) {
            $rewhklyoypc3yth2e7lprhccbnev = $this->getOfferData($this->getOfferId());
            $rpgkzyhkgu = $this->exportItem()->getOfferQuantity();
            if (isset($rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu])) {
                return max(0, (int) $rewhklyoypc3yth2e7lprhccbnev[$rpgkzyhkgu]);
            } elseif (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return max(0, (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu]);
            }
        } else {
            $rpgkzyhkgu = $this->exportItem()->getProductQuantity();
            if (isset($zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu])) {
                return max(0, (int) $zlepcfesz1rla843x48cba7qn2[$rpgkzyhkgu]);
            }
        }
        
        return -1;
    }
}
?>