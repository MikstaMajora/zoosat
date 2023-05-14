<?php

namespace VKapi\Market\Album;

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Entity;
use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Result;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ItemTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\153\x61\x70\x69\137\x6d\x61\x72\153\145\164\137\x61\154\x62\x75\155\x5f\x69\x74\145\x6d";
    }
    
    public static function getMap()
    {
        return [new \Bitrix\Main\Entity\IntegerField("\111\104", ["\160\x72\151\x6d\x61\x72\171" => true, "\x61\x75\164\157\x63\x6f\x6d\x70\x6c\x65\164\145" => true]), new \Bitrix\Main\Entity\StringField("\126\x4b\137\x4e\x41\x4d\x45", [
            // название подборки в вк
            "\x72\145\x71\x75\151\162\145\144" => false,
            "\x76\x61\154\x69\144\x61\164\x6f\162" => function () {
                return [new \Bitrix\Main\Entity\Validator\Range(1, 255)];
            },
        ]), new \Bitrix\Main\Entity\StringField("\x4e\101\115\x45", [
            // внутренее название в битриксе
            "\162\x65\161\165\x69\x72\145\x64" => false,
            "\166\x61\154\x69\144\x61\x74\157\x72" => function () {
                return [new \Bitrix\Main\Entity\Validator\Range(1, 255)];
            },
        ]), new \Bitrix\Main\Entity\IntegerField("\120\x49\x43\124\x55\122\x45"), new \Bitrix\Main\Entity\TextField("\120\101\x52\101\115\123", ["\162\145\161\165\x69\x72\x65\144" => true, "\163\x65\162\151\141\154\151\172\x65\144" => true, "\x64\145\x66\x61\x75\x6c\164\x5f\166\141\x6c\165\145" => []]), new \Bitrix\Main\Entity\ExpressionField("\103\116\x54", "\103\x4f\x55\116\x54\50\x2a\51")];
    }
    
    public static function OnBeforeDelete(\Bitrix\Main\Entity\Event $fofb9h8l180xsbhwk2kxe8l1a00)
    {
        $w5d8q86owss6wq2f78go3137fr = $fofb9h8l180xsbhwk2kxe8l1a00->getParameter("\x70\162\x69\155\141\162\171");
        if (!isset($w5d8q86owss6wq2f78go3137fr["\x49\104"])) {
            return true;
        }
        $n1azt5248q = $w5d8q86owss6wq2f78go3137fr["\111\x44"];
        $taq0tixwpkxpl27ss0cgu8ee6g = self::getById($n1azt5248q)->fetch();
        if (!$taq0tixwpkxpl27ss0cgu8ee6g) {
            return true;
        }
        if ($taq0tixwpkxpl27ss0cgu8ee6g["\x50\x49\103\x54\x55\122\x45"]) {
            
            \CFile::Delete(intval($taq0tixwpkxpl27ss0cgu8ee6g["\120\111\103\x54\125\x52\x45"]));
            
            \VKapi\Market\Export\PhotoTable::deleteByFileId(intval($taq0tixwpkxpl27ss0cgu8ee6g["\x50\x49\x43\x54\125\x52\x45"]));
        }
        
        \VKapi\Market\Album\ExportTable::deleteAllByAlbumId($n1azt5248q);
        
        \VKapi\Market\Good\Reference\AlbumTable::deleteAllByAlbumId($n1azt5248q);
    }
}

class Item
{
    
    private $oTable = null;
    public function __construct()
    {
    }
    
    public function table()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Album\ItemTable();
        }
        return $this->oTable;
    }
    
    protected function getMessage($edhakv0x, $hwlsnw0lprdluda2x109phniqsurq6u6d = null)
    {
        return \VKapi\Market\Manager::getInstance()->getMessage("\101\114\x42\125\115\56\111\x54\105\115\56" . $edhakv0x, $hwlsnw0lprdluda2x109phniqsurq6u6d);
    }
    
    public function getAllCategories()
    {
        $n4v3fnd4ykg0hv8b5sscnwk = new \Bitrix\Main\Result();
        $rggskcb0cnoc8 = \Bitrix\Main\Data\Cache::createInstance();
        $ljao5nd8dsgo096 = 120;
        $za8bf0 = "\147\x65\164\101\x6c\154\103\x61\x74\x65\147\157\162\151\145\163";
        $qtlak5duhp1e9gaxo30as3gh9nbrcb0knej = "\x76\x6b\x61\160\151\56\155\x61\x72\x6b\x65\164\57\166\153\57\x63\x61\x74\x65\147\157\x72\151\x65\x73";
        if ($rggskcb0cnoc8->initCache($ljao5nd8dsgo096, $za8bf0, $qtlak5duhp1e9gaxo30as3gh9nbrcb0knej)) {
            $gu08sta3uig1l7ekwu1mcuqfb2 = $rggskcb0cnoc8->getVars();
        } elseif ($rggskcb0cnoc8->startDataCache()) {
            $gu08sta3uig1l7ekwu1mcuqfb2 = [];
            $vsf0rm7vuqo2nyezlw3ix9 = \VKapi\Market\Manager::getInstance();
            
            $vn3a12y3n = false;
            $q21evpb1qwa = false;
            $yfchrdz0jo1r430vc3fdgkxqi4yzs5a3bvi = \VKapi\Market\ConnectTable::getList();
            $ilh1scetpls06 = [];
            while ($mr8lx0gi9n451buwbngweg0noz = $yfchrdz0jo1r430vc3fdgkxqi4yzs5a3bvi->fetch()) {
                try {
                    $fzd5ntrq984pvxn2nprsybbi1ny360d = $vsf0rm7vuqo2nyezlw3ix9->getConnection($mr8lx0gi9n451buwbngweg0noz["\x49\x44"]);
                    if (!is_null($fzd5ntrq984pvxn2nprsybbi1ny360d)) {
                        $q21evpb1qwa = $fzd5ntrq984pvxn2nprsybbi1ny360d->method("\155\x61\x72\x6b\x65\164\x2e\147\145\x74\x43\x61\x74\145\147\x6f\162\x69\x65\163");
                        if ($q21evpb1qwa->isSuccess()) {
                            $cbfwwao6 = $q21evpb1qwa->getData("\x72\145\x73\x70\x6f\156\163\x65");
                            $gu08sta3uig1l7ekwu1mcuqfb2 = $cbfwwao6["\151\164\x65\x6d\x73"];
                            $vn3a12y3n = true;
                            break;
                        }
                    }
                } catch (\VKapi\Market\Exception\BaseException $wsqyz) {
                    $ilh1scetpls06[] = $wsqyz;
                }
            }
            if (!$vn3a12y3n) {
                if (count($ilh1scetpls06)) {
                    $wsqyz = $ilh1scetpls06[0];
                    $n4v3fnd4ykg0hv8b5sscnwk->addError(new \Bitrix\Main\Error($wsqyz->getMessage(), $wsqyz->getCode(), $wsqyz->getCustomData()));
                } else {
                    $n4v3fnd4ykg0hv8b5sscnwk->addError(new \Bitrix\Main\Error($this->getMessage("\x45\115\x50\x54\x59\x5f\101\x43\x43\x4f\x55\116\x54\137\114\111\123\x54"), "\105\x4d\120\124\x59\137\x41\x43\x43\x4f\x55\x4e\x54\137\114\x49\123\x54"));
                }
                $rggskcb0cnoc8->abortDataCache();
            } elseif (empty($gu08sta3uig1l7ekwu1mcuqfb2)) {
                if ($q21evpb1qwa instanceof \VKapi\Market\Result && !$q21evpb1qwa->isSuccess()) {
                    $n4v3fnd4ykg0hv8b5sscnwk->addError($q21evpb1qwa->getBitrixError());
                } else {
                    $n4v3fnd4ykg0hv8b5sscnwk->addError(new \Bitrix\Main\Error($this->getMessage("\105\x4d\x50\x54\131\137\x43\x41\x54\x45\107\x4f\122\x49\x45\123\137\114\x49\x53\124"), "\105\115\120\x54\131\137\x43\101\124\105\x47\117\122\111\x45\123\137\114\x49\123\124"));
                }
                $rggskcb0cnoc8->abortDataCache();
            }
            $rggskcb0cnoc8->endDataCache($gu08sta3uig1l7ekwu1mcuqfb2);
        }
        if ($n4v3fnd4ykg0hv8b5sscnwk->isSuccess()) {
            $n4v3fnd4ykg0hv8b5sscnwk->setData(["\x69\x74\145\x6d\x73" => $gu08sta3uig1l7ekwu1mcuqfb2]);
        }
        return $n4v3fnd4ykg0hv8b5sscnwk;
    }
    
    public function getCategorySelectHtml($edhakv0x, $pc0tedf28zs2qb7wq16m = "")
    {
        $c048jm = $this->getAllCategories();
        $mgqxnm0gv = "";
        if ($c048jm->isSuccess()) {
            $ubzdqkr1s5z1xg803a2i4pv64e6hy0coo8 = $c048jm->getData();
            $gu08sta3uig1l7ekwu1mcuqfb2 = $ubzdqkr1s5z1xg803a2i4pv64e6hy0coo8["\x69\x74\x65\x6d\163"];
            $mgqxnm0gv = "\74\x73\x65\x6c\x65\143\164\x20\x6e\x61\155\145\x3d\42" . $edhakv0x . "\42\40\143\154\x61\x73\x73\75\x22\x76\153\x61\x70\x69\55\x6d\141\x72\153\145\x74\55\x73\145\154\145\143\164\x20\x76\153\141\x70\151\x2d\x6d\x61\162\x6b\x65\164\55\x73\x65\154\145\143\164\55\x2d\147\x72\157\165\160\163\x22\x20\x3e";
            $qwuhnsvt9j0syhxyb5 = null;
            if (!empty($gu08sta3uig1l7ekwu1mcuqfb2)) {
                
                foreach ($gu08sta3uig1l7ekwu1mcuqfb2 as $s81rq64d77z1368x8ep3o6g875ofnmsr) {
                    $mgqxnm0gv .= "\x3c\x6f\160\164\147\x72\x6f\165\x70\40\x6c\141\x62\145\x6c\75\42" . $s81rq64d77z1368x8ep3o6g875ofnmsr["\156\x61\x6d\145"] . "\x22\40\x3e";
                    foreach ($s81rq64d77z1368x8ep3o6g875ofnmsr["\143\x68\151\154\144\x72\x65\x6e"] as $s3p20ffb80y9f7wuxmd5c) {
                        $mgqxnm0gv .= "\74\x6f\x70\x74\x69\x6f\156\40\x76\141\154\165\145\x3d\x22" . $s3p20ffb80y9f7wuxmd5c["\151\x64"] . "\42\x20" . ($s3p20ffb80y9f7wuxmd5c["\x69\144"] == $pc0tedf28zs2qb7wq16m ? "\x20\x73\145\154\145\x63\x74\x65\x64\x3d\x22\163\145\154\x65\x63\164\145\x64\x22\40" : "") . "\40\x3e" . $s3p20ffb80y9f7wuxmd5c["\156\141\155\145"] . "\74\x2f\157\160\164\x69\x6f\156\76";
                    }
                    $mgqxnm0gv .= "\x3c\57\x6f\160\x74\147\x72\x6f\x75\160\x3e";
                }
            }
            if (!is_null($qwuhnsvt9j0syhxyb5)) {
                $mgqxnm0gv .= "\x3c\57\x6f\160\x74\147\x72\x6f\165\x70\76";
            }
            $mgqxnm0gv .= "\74\x2f\x73\145\x6c\x65\x63\164\x3e";
        } else {
            $mgqxnm0gv = "\x3c\144\151\x76\40\143\154\141\163\163\x3d\42\166\x6b\x61\x70\151\x2d\155\x61\162\153\145\164\55\155\145\x73\163\141\147\145\40\x76\153\141\160\151\55\x6d\141\162\153\x65\x74\55\155\x65\x73\163\141\x67\145\55\55\145\162\162\x6f\162\x22\76" . implode("\54", $c048jm->getErrorMessages()) . "\74\x2f\x64\x69\166\76";
        }
        return $mgqxnm0gv;
    }
    
    public function getItemsForJs()
    {
        static $nxr2izfk8jtuq0la4bw841qy1z7;
        if (!isset($nxr2izfk8jtuq0la4bw841qy1z7)) {
            $nxr2izfk8jtuq0la4bw841qy1z7 = [];
            $bwmudazx78uynx9 = $this->table()->getList(["\157\162\144\x65\x72" => ["\126\113\x5f\116\101\115\x45" => "\101\x53\103"]]);
            while ($hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj = $bwmudazx78uynx9->fetch()) {
                $p6neqijgs92g7a5so2aowtepv = false;
                if ($hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\x50\111\x43\x54\x55\122\105"]) {
                    $h6z5v6b3okym48vius136 = \CFile::ResizeImageGet($hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\120\111\103\124\125\122\x45"], ["\x77\151\144\164\x68" => 200, "\150\x65\x69\147\150\164" => 200]);
                    $p6neqijgs92g7a5so2aowtepv = $h6z5v6b3okym48vius136["\163\162\143"];
                }
                $nxr2izfk8jtuq0la4bw841qy1z7[] = ["\x69\x64" => $hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\111\104"], "\x6e\141\155\145" => $hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\126\x4b\137\116\101\115\x45"] . "\x20\x28" . $hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\116\101\x4d\x45"] . "\x29\x20\x5b" . $hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\x49\104"] . "\135", "\x69\155\147" => $p6neqijgs92g7a5so2aowtepv];
            }
        }
        return $nxr2izfk8jtuq0la4bw841qy1z7;
    }
    
    public function getItemsById($bps0bvo0enucijykh70gcf17r64upcidlc)
    {
        $nxr2izfk8jtuq0la4bw841qy1z7 = [];
        $bwmudazx78uynx9 = $this->table()->getList(["\146\x69\154\x74\x65\162" => ["\x49\104" => $bps0bvo0enucijykh70gcf17r64upcidlc]]);
        while ($hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj = $bwmudazx78uynx9->fetch()) {
            $nxr2izfk8jtuq0la4bw841qy1z7[$hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj["\111\104"]] = $hg9sd3yf2jjmdk4417ycujp9rsubw4nuytj;
        }
        return $nxr2izfk8jtuq0la4bw841qy1z7;
    }
}
?>