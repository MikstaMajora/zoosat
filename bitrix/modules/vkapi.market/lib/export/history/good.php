<?php

namespace VKapi\Market\Export\History;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Validators\DateValidator;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Type\DateTime;
use VKapi\Market\Exception\GoodLimitException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class GoodTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\166\x6b\141\160\x69\137\x6d\141\x72\x6b\x65\164\x5f\x65\x78\160\157\162\x74\x5f\150\x69\x73\x74\x6f\162\171\137\x67\x6f\x6f\x64";
    }
    
    public static function getMap()
    {
        return [(new \Bitrix\Main\Entity\IntegerField("\111\104"))->configurePrimary()->configureAutocomplete(), (new \Bitrix\Main\Entity\IntegerField("\x47\x52\x4f\125\x50\137\x49\x44"))->configureRequired(), (new \Bitrix\Main\Entity\IntegerField("\120\122\117\104\125\x43\124\x5f\111\x44"))->configureRequired(), (new \Bitrix\Main\Entity\IntegerField("\120\122\117\104\x55\103\124\x5f\x49\102\x4c\x4f\x43\113\x5f\x49\x44"))->configureNullable(), (new \Bitrix\Main\Entity\StringField("\x50\122\117\x44\x55\x43\x54\x5f\x58\x4d\x4c\137\x49\104"))->configureNullable()->configureDefaultValue(null)->configureSize(70), (new \Bitrix\Main\Entity\IntegerField("\117\x46\x46\105\x52\137\111\x44"))->configureRequired(), (new \Bitrix\Main\Entity\IntegerField("\117\x46\106\105\x52\x5f\x49\x42\114\x4f\x43\x4b\x5f\x49\104"))->configureNullable(), (new \Bitrix\Main\Entity\StringField("\x4f\x46\106\105\x52\x5f\x58\x4d\x4c\137\x49\104"))->configureNullable()->configureDefaultValue(null)->configureSize(70), (new \Bitrix\Main\Entity\StringField("\x53\113\x55"))->configureNullable()->configureDefaultValue(null)->configureSize(50), (new \Bitrix\Main\Entity\IntegerField("\x56\x4b\x5f\111\x44"))->configureRequired(), (new \Bitrix\Main\Entity\DatetimeField("\103\122\x45\101\124\105\x44"))->configureDefaultValue(new \Bitrix\Main\Type\DateTime()), new \Bitrix\Main\Entity\ExpressionField("\x43\x4e\x54", "\103\117\x55\116\x54\50\111\x44\x29")];
    }
    
    public static function deleteOld()
    {
        $qr99z4wc469iczsyp771x2ikiaeb2 = new \Bitrix\Main\Type\DateTime();
        $qr99z4wc469iczsyp771x2ikiaeb2->add("\55\x20\62\40\x79\145\x61\x72");
        $itakbnrp = static::getEntity();
        $rh54d = $itakbnrp->getConnection();
        return $rh54d->query(sprintf("\104\105\x4c\105\124\105\x20\x46\122\117\x4d\40\45\163\x20\x57\x48\105\122\x45\x20\45\x73", $rh54d->getSqlHelper()->quote($itakbnrp->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($itakbnrp, ["\x3c\x43\122\x45\x41\x54\105\104" => $qr99z4wc469iczsyp771x2ikiaeb2])));
    }
}

class Good
{
    
    protected $oTable;
    public function __construct()
    {
    }
    
    public function table()
    {
        if (is_null($this->oTable)) {
            $this->oTable = new \VKapi\Market\Export\History\GoodTable();
        }
        return $this->oTable;
    }
    
    public function append(\VKapi\Market\Good\Export\Item $tvb8cimacd22piltdtsqji4z2l1fosiwy, $c36qygu3x2e0rum1ezq30vr4gxa0d)
    {
        $c36qygu3x2e0rum1ezq30vr4gxa0d = (int) $c36qygu3x2e0rum1ezq30vr4gxa0d;
        if (!$c36qygu3x2e0rum1ezq30vr4gxa0d) {
            return false;
        }
        $opnrbcspes203 = $this->table()::getRow(["\x66\151\154\x74\x65\x72" => ["\x47\122\117\125\120\x5f\x49\x44" => (int) $tvb8cimacd22piltdtsqji4z2l1fosiwy->exportItem()->getGroupId(), "\126\113\x5f\x49\104" => $c36qygu3x2e0rum1ezq30vr4gxa0d]]);
        if ($opnrbcspes203) {
            
            if ($opnrbcspes203["\117\106\x46\x45\x52\137\111\104"] && ($opnrbcspes203["\117\x46\106\x45\122\x5f\x58\x4d\x4c\x5f\111\x44"] == $opnrbcspes203["\x4f\106\106\105\122\x5f\x49\102\114\117\x43\x4b\x5f\x49\x44"] || empty($opnrbcspes203["\117\106\106\105\122\137\x49\102\114\x4f\x43\x4b\137\111\x44"]))) {
                $this->table()::update($opnrbcspes203["\111\104"], ["\117\x46\106\105\x52\x5f\x49\102\x4c\x4f\103\x4b\x5f\111\104" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getOfferIblockId()]);
            }
            return true;
        }
        $lx7stym6lc90spv9bvnv12my2l4i2 = ["\107\122\117\x55\x50\137\x49\x44" => (int) $tvb8cimacd22piltdtsqji4z2l1fosiwy->exportItem()->getGroupId(), "\126\113\137\111\x44" => $c36qygu3x2e0rum1ezq30vr4gxa0d, "\120\122\117\x44\125\103\124\137\111\104" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getProductId(), "\x50\122\117\104\x55\x43\x54\137\x58\115\x4c\137\111\104" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getProductXmlId(), "\120\122\x4f\104\125\x43\x54\137\111\102\114\x4f\x43\x4b\x5f\111\104" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getProductIblockId(), "\x4f\x46\106\105\x52\137\111\104" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getOfferId(), "\117\106\106\105\122\x5f\x58\115\x4c\137\111\x44" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getOfferXmlId(), "\x4f\x46\106\x45\122\x5f\111\x42\114\x4f\103\113\137\111\104" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getOfferIblockId(), "\x53\x4b\125" => $tvb8cimacd22piltdtsqji4z2l1fosiwy->getFieldSku()];
        if (empty($lx7stym6lc90spv9bvnv12my2l4i2["\123\113\x55"])) {
            unset($lx7stym6lc90spv9bvnv12my2l4i2["\123\113\x55"]);
        }
        $z6naztv7qqx = $this->table()->add($lx7stym6lc90spv9bvnv12my2l4i2);
        return $z6naztv7qqx->isSuccess();
    }
    
    public function findElementByVkIdGroupId($c36qygu3x2e0rum1ezq30vr4gxa0d, $uybn1zh11g5cax64i51nlq3slwsyfs)
    {
        if (!\VKapi\Market\Manager::getInstance()->isInstalledIblockModule()) {
            return null;
        }
        $t0v56pjf4zo2k9agsj = $this->table()::getRow(["\x66\151\x6c\x74\x65\162" => ["\107\122\117\x55\x50\x5f\111\x44" => (int) $uybn1zh11g5cax64i51nlq3slwsyfs, "\x56\113\x5f\x49\x44" => (int) $c36qygu3x2e0rum1ezq30vr4gxa0d]]);
        if (!$t0v56pjf4zo2k9agsj) {
            return null;
        }
        do {
            
            $gfwazz6qyw5g25evmhf3hrovf3abycx2zq = $t0v56pjf4zo2k9agsj["\117\106\x46\105\122\x5f\x58\x4d\x4c\x5f\x49\x44"] == $t0v56pjf4zo2k9agsj["\117\106\x46\105\122\x5f\x49\102\x4c\117\x43\x4b\137\x49\104"] ? null : $t0v56pjf4zo2k9agsj["\x4f\x46\x46\x45\122\137\111\102\114\117\x43\x4b\x5f\111\104"];
            if ($hyw5hnyue97sjnmc721 = $this->findIblockElementById($t0v56pjf4zo2k9agsj["\117\x46\x46\105\122\137\x49\104"], $gfwazz6qyw5g25evmhf3hrovf3abycx2zq)) {
                break;
            }
            if ($hyw5hnyue97sjnmc721 = $this->findIblockElementByXmlId($t0v56pjf4zo2k9agsj["\117\x46\x46\x45\122\x5f\x58\115\x4c\x5f\111\x44"], $gfwazz6qyw5g25evmhf3hrovf3abycx2zq)) {
                break;
            }
            if ($hyw5hnyue97sjnmc721 = $this->findIblockElementById($t0v56pjf4zo2k9agsj["\x50\122\x4f\x44\x55\103\124\x5f\x49\104"], $t0v56pjf4zo2k9agsj["\120\x52\117\104\125\103\x54\137\111\x42\x4c\117\103\113\137\x49\x44"])) {
                break;
            }
            if ($hyw5hnyue97sjnmc721 = $this->findIblockElementByXmlId($t0v56pjf4zo2k9agsj["\120\x52\117\x44\125\x43\x54\x5f\x58\x4d\x4c\x5f\111\x44"], $t0v56pjf4zo2k9agsj["\120\x52\117\x44\125\x43\x54\x5f\x49\102\x4c\x4f\103\113\137\x49\104"])) {
                break;
            }
            return null;
        } while (false);
        $qtfhgzzjsk3xma4j1hx = ["\116\x41\115\105" => $hyw5hnyue97sjnmc721["\116\101\x4d\105"], "\111\104" => $hyw5hnyue97sjnmc721["\111\104"]];
        return $qtfhgzzjsk3xma4j1hx;
    }
    
    public function findIblockElementById($edek9nos1rjdiqpyfhzplvvrfh, $gfwazz6qyw5g25evmhf3hrovf3abycx2zq = null)
    {
        $edek9nos1rjdiqpyfhzplvvrfh = (int) $edek9nos1rjdiqpyfhzplvvrfh;
        if (empty($edek9nos1rjdiqpyfhzplvvrfh)) {
            return null;
        }
        $h8ns2i1mrg6fhn4qknhhc83 = ["\x49\104" => $edek9nos1rjdiqpyfhzplvvrfh];
        if (!is_null($gfwazz6qyw5g25evmhf3hrovf3abycx2zq)) {
            $h8ns2i1mrg6fhn4qknhhc83["\x49\x42\114\x4f\x43\113\x5f\111\104"] = (int) $gfwazz6qyw5g25evmhf3hrovf3abycx2zq;
        }
        $sgmxl = \CIBlockElement::GetList([], $h8ns2i1mrg6fhn4qknhhc83, false, ["\x6e\120\141\147\x65\x53\151\172\x65" => 1], ["\x49\102\x4c\x4f\103\113\137\111\x44", "\111\x44", "\130\x4d\114\x5f\111\x44", "\x4e\x41\115\105", "\101\x43\124\111\x56\105"]);
        if ($cciv7ma1mld7mqy0mkn5svo3 = $sgmxl->Fetch()) {
            return $cciv7ma1mld7mqy0mkn5svo3;
        }
        return null;
    }
    
    public function findIblockElementByXmlId($nph6u7tkjo9riz, $gfwazz6qyw5g25evmhf3hrovf3abycx2zq = null)
    {
        $nph6u7tkjo9riz = trim((string) $nph6u7tkjo9riz);
        if (empty($nph6u7tkjo9riz)) {
            return null;
        }
        $h8ns2i1mrg6fhn4qknhhc83 = ["\x58\115\114\137\x49\x44" => $nph6u7tkjo9riz];
        if (!is_null($gfwazz6qyw5g25evmhf3hrovf3abycx2zq)) {
            $h8ns2i1mrg6fhn4qknhhc83["\111\102\x4c\117\x43\113\137\111\x44"] = (int) $gfwazz6qyw5g25evmhf3hrovf3abycx2zq;
        }
        $sgmxl = \CIBlockElement::GetList([], $h8ns2i1mrg6fhn4qknhhc83, false, ["\156\x50\x61\x67\145\123\151\x7a\145" => 1], ["\x49\x42\x4c\x4f\x43\x4b\137\x49\x44", "\111\104", "\x58\115\114\x5f\x49\104", "\116\x41\x4d\x45", "\101\103\x54\x49\126\105"]);
        if ($cciv7ma1mld7mqy0mkn5svo3 = $sgmxl->Fetch()) {
            return $cciv7ma1mld7mqy0mkn5svo3;
        }
        return null;
    }
}
?>