<?php

namespace VKapi\Market\Album;

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Query;
use VKapi\Market\Exception\ApiResponseException;
use VKapi\Market\Exception\BaseException;
use VKapi\Market\Exception\TimeoutException;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class ExportTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }
    public static function getTableName()
    {
        return "\x76\x6b\141\x70\151\x5f\155\x61\162\x6b\145\164\x5f\x61\x6c\x62\x75\155\137\145\x78\160\x6f\162\164\137\x69\x74\145\x6d";
    }
    
    public static function getMap()
    {
        return [new \Bitrix\Main\Entity\IntegerField("\x49\104", ["\x70\162\151\155\141\162\x79" => true, "\141\165\x74\x6f\x63\157\x6d\160\154\145\164\x65" => true]), new \Bitrix\Main\Entity\IntegerField("\x47\122\x4f\x55\x50\137\111\104", [
            //идентификатор группы
            "\x72\x65\x71\165\x69\x72\145\144" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\x41\x4c\x42\x55\115\137\111\104", [
            //идентификатор подборки локальный
            "\x72\x65\161\x75\x69\x72\x65\x64" => true,
        ]), new \Bitrix\Main\Entity\IntegerField("\x56\113\x5f\x49\x44", [
            //идентификатор подборки в вк, положительное целое число или  null
            "\162\x65\x71\x75\x69\162\145\x64" => false,
            "\x64\x65\x66\141\x75\x6c\164\x5f\x76\141\154\165\145" => NULL,
        ]), new \Bitrix\Main\Entity\StringField("\x48\x41\123\110", [
            //hash подготовленных полей, для исключения лишних обновлений на стороне вк
            "\x72\145\x71\165\x69\x72\145\x64" => true,
        ]), new \Bitrix\Main\Entity\ExpressionField("\x43\116\124", "\x43\117\125\116\x54\50\x2a\51"), new \Bitrix\Main\Entity\ReferenceField("\111\x54\x45\x4d", "\x5c\126\x4b\141\x70\151\x5c\115\141\162\153\x65\164\x5c\x41\154\x62\165\x6d\134\111\164\x65\x6d\x54\141\142\154\x65", ["\75\164\150\x69\x73\56\101\x4c\x42\x55\115\137\x49\104" => "\x72\x65\x66\56\111\104"], ["\x6a\157\x69\156\x5f\x74\x79\x70\145" => "\x4c\105\x46\124"])];
    }
    
    public static function deleteAllByAlbumId($q8xqn0p95w903qsjel3hhvox2ikx7aen)
    {
        $zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu = static::getEntity();
        $f76jfwvq2cvygz7x = $zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu->getConnection();
        return $f76jfwvq2cvygz7x->query(sprintf("\104\x45\114\105\124\105\40\x46\x52\117\x4d\40\x25\x73\x20\127\x48\x45\122\105\x20\x25\x73", $f76jfwvq2cvygz7x->getSqlHelper()->quote($zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu, ["\x41\114\x42\125\x4d\137\111\104" => intval($q8xqn0p95w903qsjel3hhvox2ikx7aen)])));
    }
    
    public static function deleteAllByGroupId($cxihp7bp5)
    {
        $zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu = static::getEntity();
        $f76jfwvq2cvygz7x = $zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu->getConnection();
        return $f76jfwvq2cvygz7x->query(sprintf("\104\x45\x4c\x45\124\x45\x20\106\x52\x4f\115\x20\45\x73\x20\x57\x48\x45\122\x45\40\45\x73", $f76jfwvq2cvygz7x->getSqlHelper()->quote($zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu->getDbTableName()), \Bitrix\Main\ORM\Query\Query::buildFilterSql($zb8shcgxo3kp7fxoctxzy11y2y1wlu9pu, ["\x47\122\x4f\x55\120\137\111\104" => intval($cxihp7bp5)])));
    }
}

class Export
{
    
    protected $oAlbumExportTable = null;
    
    protected $oExportItem = null;
    
    protected $oLog = null;
    
    protected $oPhoto = null;
    
    protected $oState = null;
    
    protected $oAlbumItem = null;
    
    protected $oExportTable = null;
    
    public function __construct(\VKapi\Market\Export\Item $a3077odina9r28zmyc8xjw4auj4730)
    {
        $this->oExportItem = $a3077odina9r28zmyc8xjw4auj4730;
    }
    
    public function albumExportTable()
    {
        if (is_null($this->oAlbumExportTable)) {
            $this->oAlbumExportTable = new \VKapi\Market\Album\ExportTable();
        }
        return $this->oAlbumExportTable;
    }
    
    public function item()
    {
        if (is_null($this->oAlbumItem)) {
            $this->oAlbumItem = new \VKapi\Market\Album\Item();
        }
        return $this->oAlbumItem;
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function photo()
    {
        if (is_null($this->oPhoto)) {
            $this->oPhoto = new \VKapi\Market\Export\Photo();
            $this->oPhoto->setExportItem($this->exportItem());
        }
        return $this->oPhoto;
    }
    
    public function exportItem()
    {
        return $this->oExportItem;
    }
    
    public function log()
    {
        if (is_null($this->oLog)) {
            $this->oLog = new \VKapi\Market\Export\Log($this->manager()->getLogLevel());
            $this->oLog->setExportId($this->exportItem()->getId());
        }
        return $this->oLog;
    }
    
    public function state()
    {
        if (is_null($this->oState)) {
            $this->oState = new \VKapi\Market\State("\141\154\x62\165\155\163\137" . intval($this->exportItem()->getId()), "\x2f\x61\154\x62\165\x6d");
        }
        return $this->oState;
    }
    
    public function getMessage($jgqumfz9jb, $xborjpk8y7umjvc1l4w30dgwbxu1gx = [])
    {
        return \VKapi\Market\Manager::getInstance()->getMessage("\101\x4c\x42\125\115\x2e\x45\x58\120\x4f\x52\124\56" . $jgqumfz9jb, $xborjpk8y7umjvc1l4w30dgwbxu1gx);
    }
    
    public function exportRun()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        
        if (!empty($z056zprfa7b4cwzpd6minwf3s19d) && $z056zprfa7b4cwzpd6minwf3s19d["\162\x75\156"] && $z056zprfa7b4cwzpd6minwf3s19d["\164\151\x6d\145\123\x74\x61\x72\164"] > time() - 60 * 3) {
            throw new \VKapi\Market\Exception\BaseException($this->getMessage("\x57\101\111\124\x5f\106\x49\x4e\x49\x53\110"), "\x57\x41\111\x54\137\106\111\x4e\x49\x53\110");
        }
        
        if (empty($z056zprfa7b4cwzpd6minwf3s19d) || !isset($z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\x70"]) || $z056zprfa7b4cwzpd6minwf3s19d["\143\x6f\155\160\154\x65\164\145"]) {
            $this->state()->set(["\143\157\155\x70\x6c\x65\x74\145" => false, "\160\145\162\x63\145\156\164" => 0, "\x73\x74\145\160" => 1, "\163\164\x65\160\163" => [
                //все шаги, которые есть, в процессе работы, могут меняться сообщения, например о работано 2 из 10
                1 => ["\156\x61\155\145" => $this->getMessage("\123\124\105\x50\61"), "\x70\x65\x72\x63\145\156\164" => 0, "\145\162\x72\x6f\x72" => false],
                2 => ["\156\x61\155\145" => $this->getMessage("\123\x54\105\x50\x32"), "\160\145\162\143\145\x6e\x74" => 0, "\x65\x72\162\157\162" => false],
                3 => ["\156\141\155\x65" => $this->getMessage("\123\x54\x45\120\63"), "\160\145\162\143\145\156\x74" => 0, "\145\x72\x72\x6f\x72" => false],
                4 => ["\156\x61\155\145" => $this->getMessage("\123\x54\x45\x50\64"), "\x70\145\162\143\145\x6e\164" => 0, "\145\x72\162\x6f\x72" => false],
                5 => ["\x6e\x61\155\x65" => $this->getMessage("\x53\124\105\x50\x35"), "\160\145\162\143\145\156\x74" => 0, "\145\162\162\157\x72" => false],
                6 => ["\156\x61\155\x65" => $this->getMessage("\x53\x54\x45\x50\x36"), "\x70\145\162\x63\145\156\164" => 0, "\145\162\x72\157\x72" => false],
            ]]);
            $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
            $this->log()->notice($this->getMessage("\x45\130\x50\117\x52\124\137\101\114\102\125\115\123\56\x53\x54\x41\x52\124"));
        }
        
        $this->state()->set(["\x72\x75\156" => true, "\x74\x69\x6d\x65\x53\x74\141\x72\x74" => time()])->save();
        try {
            switch ($z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\160"]) {
                case 1:
                    $this->exportItem()->checkApiAccess();
                    $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\x65\x70"]++;
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\145\160\x73"][1]["\160\x65\x72\143\145\x6e\x74"] = 100;
                    $this->log()->notice($this->getMessage("\105\x58\x50\x4f\122\124\x5f\101\x4c\x42\125\x4d\x53\56\123\124\105\x50\56\x4f\x4b", ["\x23\123\x54\x45\120\x23" => 1, "\43\x53\124\x45\120\x5f\x4e\x41\x4d\105\43" => $this->getMessage("\123\124\x45\120\x31")]));
                    break;
                case 2:
                    
                    $kicmqv7 = $this->exportRunCheckAlbumInVk();
                    $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\x65\x70\x73"][2]["\160\145\x72\143\145\x6e\x74"] = $kicmqv7->getData("\x70\145\162\143\145\156\x74");
                    
                    if ($kicmqv7->getData("\143\x6f\155\x70\x6c\x65\164\x65")) {
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\x65\160"]++;
                        $z056zprfa7b4cwzpd6minwf3s19d["\x73\x74\x65\160\x73"][2]["\156\141\x6d\145"] = $this->getMessage("\x53\x54\x45\120\62");
                        $this->log()->notice($this->getMessage("\105\130\120\x4f\122\124\137\x41\114\102\125\115\x53\x2e\x53\124\x45\120\x2e\x4f\x4b", ["\43\123\x54\105\x50\x23" => 2, "\43\x53\124\105\120\x5f\116\x41\x4d\105\43" => $this->getMessage("\x53\124\x45\120\x32")]));
                    } else {
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\164\x65\x70\163"][2]["\x6e\141\155\x65"] = $kicmqv7->getData("\x6e\x61\155\145");
                        $this->log()->notice($this->getMessage("\105\x58\120\x4f\x52\x54\137\101\114\102\x55\x4d\123\x2e\123\124\x45\x50\x2e\120\x52\117\x43\x45\x53\x53", ["\x23\x53\124\x45\x50\x23" => 2, "\43\123\x54\x45\x50\137\x4e\x41\115\x45\x23" => $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\145\160\163"][2]["\156\141\x6d\145"], "\43\120\x45\122\103\105\x4e\x54\43" => $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\x65\x70\x73"][2]["\160\145\x72\143\x65\156\164"]]));
                    }
                    break;
                
                case 3:
                    
                    $bf1o0485efp35tdjx1vf = $this->exportRunCheckAlbumPhotoInVk();
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\x70\x73"][3]["\160\145\162\x63\145\156\164"] = $bf1o0485efp35tdjx1vf->getData("\160\145\x72\143\x65\156\164");
                    $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\x65\x70\163"][3]["\x6e\x61\x6d\145"] = $bf1o0485efp35tdjx1vf->getData("\x6e\141\155\x65");
                    
                    if ($bf1o0485efp35tdjx1vf->getData("\143\157\x6d\x70\x6c\145\x74\145")) {
                        $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\145\x70"]++;
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\164\x65\x70\x73"][3]["\156\141\x6d\x65"] = $this->getMessage("\x53\x54\x45\x50\63");
                        $this->log()->notice($this->getMessage("\105\x58\120\x4f\x52\124\137\x41\x4c\102\125\x4d\123\x2e\123\124\x45\120\56\x4f\113", ["\43\123\124\105\x50\x23" => 3, "\x23\x53\x54\x45\120\x5f\x4e\x41\115\x45\x23" => $this->getMessage("\x53\x54\105\120\63")]));
                    } else {
                        $this->log()->notice($this->getMessage("\105\130\x50\x4f\122\124\x5f\101\114\102\x55\x4d\x53\x2e\123\x54\105\120\x2e\x50\122\x4f\103\x45\123\123", ["\43\123\x54\105\120\43" => 3, "\x23\x53\124\105\120\x5f\116\x41\115\x45\43" => $z056zprfa7b4cwzpd6minwf3s19d["\x73\x74\x65\x70\163"][3]["\x6e\141\155\145"], "\x23\x50\105\122\103\x45\116\124\x23" => $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\x65\160\x73"][3]["\x70\x65\x72\x63\145\156\164"]]));
                    }
                    break;
                
                case 4:
                    
                    $quk6pw = $this->exportRunUpdateAlbumInVK();
                    $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\x65\x70\x73"][4]["\x70\x65\162\143\145\156\164"] = $quk6pw->getData("\x70\145\x72\143\145\x6e\164");
                    $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\145\160\163"][4]["\156\x61\x6d\x65"] = $quk6pw->getData("\x6e\x61\155\145");
                    
                    if ($quk6pw->getData("\x63\x6f\155\160\x6c\145\x74\145")) {
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\160"]++;
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\x70\x73"][4]["\156\x61\155\x65"] = $this->getMessage("\123\x54\105\x50\x34");
                        $this->log()->notice($this->getMessage("\105\130\120\x4f\122\124\x5f\101\x4c\102\125\115\123\x2e\123\124\x45\x50\x2e\117\113", ["\x23\123\x54\x45\x50\x23" => 4, "\x23\x53\x54\105\x50\x5f\x4e\101\x4d\105\x23" => $this->getMessage("\x53\124\x45\x50\x34")]));
                    } else {
                        $this->log()->notice($this->getMessage("\x45\130\120\x4f\x52\x54\x5f\101\x4c\102\125\115\123\x2e\x53\x54\105\120\56\x50\x52\117\103\x45\123\x53", ["\x23\x53\x54\105\120\x23" => 4, "\43\123\x54\x45\x50\137\116\x41\x4d\x45\43" => $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\x65\x70\x73"][4]["\156\141\x6d\x65"], "\43\x50\105\x52\103\105\116\124\43" => $z056zprfa7b4cwzpd6minwf3s19d["\163\164\x65\x70\x73"][4]["\x70\x65\x72\x63\145\x6e\164"]]));
                    }
                    break;
                
                case 5:
                    
                    $ccjusd1djhxa = $this->exportRunAddAlbumToVK();
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\x70\163"][5]["\160\x65\162\143\x65\x6e\x74"] = $ccjusd1djhxa->getData("\x70\145\x72\x63\145\x6e\164");
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\145\160\163"][5]["\x6e\x61\155\145"] = $ccjusd1djhxa->getData("\x6e\141\155\145");
                    
                    if ($ccjusd1djhxa->getData("\x63\157\x6d\x70\154\145\x74\145")) {
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\x65\x70"]++;
                        $z056zprfa7b4cwzpd6minwf3s19d["\x73\164\145\160\x73"][5]["\156\141\x6d\145"] = $this->getMessage("\123\124\x45\120\x35");
                        $this->log()->notice($this->getMessage("\x45\130\x50\117\122\124\137\101\114\x42\125\x4d\123\56\x53\124\105\120\56\x4f\113", ["\43\x53\124\x45\x50\x23" => 5, "\43\x53\x54\105\120\x5f\116\x41\x4d\105\x23" => $this->getMessage("\123\124\105\x50\x35")]));
                    } else {
                        $this->log()->notice($this->getMessage("\x45\130\120\117\x52\124\137\x41\114\x42\x55\115\x53\x2e\123\124\x45\x50\56\120\122\117\103\105\123\x53", ["\43\123\124\105\120\43" => 5, "\x23\x53\x54\105\120\137\116\x41\x4d\105\x23" => $z056zprfa7b4cwzpd6minwf3s19d["\x73\x74\145\160\163"][5]["\x6e\141\155\145"], "\x23\120\105\122\x43\x45\116\124\x23" => $z056zprfa7b4cwzpd6minwf3s19d["\x73\x74\x65\160\163"][5]["\160\145\162\x63\145\x6e\164"]]));
                    }
                    break;
                
                case 6:
                    
                    $if3x4dlrilv = $this->exportRunReorderAlbumInVK();
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\145\x70\x73"][6]["\160\145\162\x63\x65\x6e\164"] = $if3x4dlrilv->getData("\x70\x65\162\143\145\156\164");
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\164\x65\x70\x73"][6]["\x6e\141\x6d\x65"] = $if3x4dlrilv->getData("\156\x61\155\x65");
                    
                    if ($if3x4dlrilv->getData("\143\x6f\x6d\160\154\x65\164\x65")) {
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\164\x65\160"]++;
                        $z056zprfa7b4cwzpd6minwf3s19d["\163\164\x65\160\x73"][6]["\x6e\x61\155\x65"] = $this->getMessage("\123\124\x45\x50\x36");
                        $this->log()->notice($this->getMessage("\105\x58\x50\x4f\x52\124\x5f\x41\114\102\125\115\123\56\123\x54\x45\x50\56\117\x4b", ["\x23\123\x54\x45\120\43" => 6, "\x23\123\x54\105\120\x5f\116\101\115\105\x23" => $this->getMessage("\x53\124\105\120\66")]));
                    } else {
                        $this->log()->notice($this->getMessage("\105\x58\120\x4f\x52\x54\x5f\101\x4c\102\125\115\x53\x2e\123\124\105\x50\56\120\122\117\103\x45\x53\x53", ["\43\123\x54\x45\120\x23" => 6, "\x23\x53\x54\x45\x50\137\x4e\101\115\x45\x23" => $z056zprfa7b4cwzpd6minwf3s19d["\x73\x74\145\x70\x73"][6]["\x6e\x61\x6d\145"], "\43\x50\x45\x52\x43\105\116\x54\43" => $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\x70\163"][6]["\160\145\x72\143\x65\x6e\164"]]));
                    }
                    break;
            }
        } catch (\VKapi\Market\Exception\BaseException $lqz6xnq) {
            $this->log()->error($lqz6xnq->getMessage(), $lqz6xnq->getCustomData());
        }
        
        $z056zprfa7b4cwzpd6minwf3s19d["\160\145\162\143\145\156\x74"] = $this->state()->calcPercentByData($z056zprfa7b4cwzpd6minwf3s19d);
        if ($z056zprfa7b4cwzpd6minwf3s19d["\160\145\162\143\x65\156\164"] == 100) {
            $z056zprfa7b4cwzpd6minwf3s19d["\x63\x6f\x6d\160\x6c\x65\164\x65"] = true;
            $this->log()->notice($this->getMessage("\x45\130\x50\117\x52\124\x5f\101\x4c\x42\x55\115\x53\56\x53\x54\117\120"));
        }
        if (\Bitrix\Main\Loader::includeSharewareModule("\x76\153\141\x70\x69\x2e\x6d\141\x72" . "" . "\x6b\145" . "\x74") == constant("\115\x4f\x44\125\x4c\x45" . "" . "" . "" . "\137\104\x45\x4d\x4f\137\x45\x58\120" . "\x49\122" . "" . "\105" . "\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\101\120\x49\x2e\115\101\122\113\x45\124\x2e\x44\x45\115\x4f\x5f\x45\x58\120\111" . "\122\105" . "" . "" . "" . "" . "" . "\104"), "\x42\130\x4d\101\113" . "\105\x52\137\104\x45\x4d\117\x5f\x45\130\x50\111\x52\x45" . "" . "\104");
        }
        
        $this->state()->set(["\162\x75\x6e" => false, "\163\164\x65\160" => $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\160"], "\163\164\x65\x70\x73" => $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\160\x73"], "\x63\x6f\155\x70\x6c\145\164\x65" => $z056zprfa7b4cwzpd6minwf3s19d["\143\x6f\x6d\160\154\145\164\x65"], "\x70\x65\x72\x63\145\x6e\164" => $z056zprfa7b4cwzpd6minwf3s19d["\x70\145\162\x63\145\x6e\x74"]]);
        $omyrf638rz9mnhsms16->setDataArray($this->state()->get());
        if ($omyrf638rz9mnhsms16->isSuccess()) {
            $this->state()->save();
        } else {
            $this->state()->clean();
        }
        return $omyrf638rz9mnhsms16;
    }
    
    public function exportRunCheckAlbumInVk()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\x65\170\x70\x6f\x72\x74\x52\x75\x6e\x43\x68\x65\x63\153\101\x6c\x62\x75\155\x49\156\x56\153";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\143\157\x6d\x70\154\x65\x74\145"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\x63\157\155\160\154\145\164\x65" => false, "\x6e\x61\155\x65" => "", "\x70\145\x72\143\x65\x6e\164" => 0, "\x73\164\145\160" => 1, "\x73\x74\x65\x70\163" => [1 => ["\x6e\x61\155\145" => $this->getMessage("\103\x48\x45\103\x4b\137\101\x4c\x42\x55\x4d\x5f\111\116\137\x56\x4b\x2e\x53\124\x45\120\x31"), "\160\145\x72\143\x65\x6e\164" => 0, "\145\x72\162\x6f\162" => false], 2 => ["\x6e\x61\155\x65" => $this->getMessage("\x43\x48\105\x43\113\137\x41\114\102\x55\115\x5f\x49\x4e\x5f\126\113\56\x53\x54\x45\x50\x32"), "\160\145\x72\x63\145\156\164" => 0, "\x65\162\162\x6f\162" => false], 3 => ["\156\141\x6d\x65" => $this->getMessage("\x43\x48\x45\103\x4b\137\101\114\x42\x55\115\x5f\111\x4e\x5f\126\113\x2e\123\x54\105\120\x33"), "\x70\x65\162\x63\145\156\x74" => 0, "\145\x72\162\157\x72" => false]]];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        try {
            
            $a2c5m3wbfkjk5lp = $this->getAlbums();
            
            $add3os2a7z = $this->getVkAlbums();
            
            if ($add3os2a7z->getData("\143\x6f\x75\x6e\164") <= 0) {
                
                foreach ($a2c5m3wbfkjk5lp as $yi5ft4ke6venx1bp6) {
                    $this->albumExportTable()->delete($yi5ft4ke6venx1bp6["\x49\x44"]);
                }
                
                foreach ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\x65\x70\x73"] as $r7h39o6yw3h2d1eny => $gqakbwhf98vslcc44gh1x922cqd45m8) {
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\x74\145\x70\x73"][$r7h39o6yw3h2d1eny]["\x70\x65\162\x63\145\x6e\x74"] = 100;
                }
                
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\164\145\x70"] = count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\x74\x65\x70\163"]);
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\162\x63\145\156\x74"] = 100;
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x6d\x70\154\x65\x74\x65"] = true;
                
                $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
                
                $omyrf638rz9mnhsms16->setDataArray($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
                $this->log()->notice($this->getMessage("\x43\110\105\x43\x4b\137\101\114\102\x55\x4d\x5f\126\x4b\x2e\101\x4c\x42\x55\x4d\123\137\116\117\x54\137\106\x4f\125\x4e\x44"));
                return $omyrf638rz9mnhsms16;
            }
            
            $lrsk285okb7 = $add3os2a7z->getData("\151\x74\145\155\x73");
            
            $ps9sndx2qq4i7o3t6tvp5j2wzab22z56 = array_column($a2c5m3wbfkjk5lp, "\101\114\102\125\115\x5f\111\104", "\126\113\x5f\111\x44");
            
            $o5d658z29cv0 = $this->getVkItemId2LocalAlbumId($lrsk285okb7, $ps9sndx2qq4i7o3t6tvp5j2wzab22z56);
            
            $smybdom4zc47tx = $this->getOtherExportsAlbumId();
            
            if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\164\145\160"] == 1) {
                
                $z90d9p = array_diff(array_values($ps9sndx2qq4i7o3t6tvp5j2wzab22z56), $o5d658z29cv0);
                if (count($z90d9p)) {
                    $this->deleteByAlbumId($z90d9p);
                    
                    $o5d658z29cv0 = array_flip($o5d658z29cv0);
                    foreach ($z90d9p as $j8gnqzapk3t) {
                        unset($o5d658z29cv0[$j8gnqzapk3t]);
                    }
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\x65\x70"]++;
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\164\x65\x70\163"][1]["\160\x65\162\143\x65\156\x74"] = 100;
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6e\x61\x6d\145"] = $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\x65\x70\163"][1]["\156\x61\x6d\145"];
            } elseif ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\x65\x70"] == 2) {
                
                $z90d9p = array_diff($o5d658z29cv0, $smybdom4zc47tx);
                if (count($z90d9p)) {
                    $vmujzsg85m6nfqkl2sk9d = $this->exportRunCheckAlbumInVkActionDeleteLocalAlbumFromVk($z90d9p);
                    $z056zprfa7b4cwzpd6minwf3s19d["\x73\x74\145\x70\x73"][2]["\x70\x65\162\x63\145\x6e\x74"] = $vmujzsg85m6nfqkl2sk9d->getData("\x70\x65\162\143\145\x6e\x74");
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\x65\x70\163"][2]["\156\x61\x6d\145"] = $vmujzsg85m6nfqkl2sk9d->getData("\x6e\x61\x6d\x65");
                    
                    if ($vmujzsg85m6nfqkl2sk9d->getData("\x63\x6f\155\160\154\145\x74\x65")) {
                        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\x65\160"]++;
                    }
                } else {
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\145\x70"]++;
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\145\x70\x73"][2]["\x70\x65\x72\143\145\x6e\x74"] = 100;
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\156\141\155\145"] = $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\x74\x65\160\163"][2]["\x6e\x61\x6d\x65"];
            } elseif ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\x65\x70"] == 3) {
                
                $z90d9p = array_diff($o5d658z29cv0, $smybdom4zc47tx);
                
                $euuhxvt9mwv3376z5o81ad = array_intersect($z90d9p, [0]);
                if (count($euuhxvt9mwv3376z5o81ad)) {
                    $vmujzsg85m6nfqkl2sk9d = $this->exportRunCheckAlbumInVkActionDeleteUnknownAlbumFromVk(array_keys($euuhxvt9mwv3376z5o81ad));
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\x74\145\x70\163"][3]["\160\x65\x72\x63\x65\x6e\164"] = $vmujzsg85m6nfqkl2sk9d->getData("\160\x65\162\143\145\156\164");
                    $z056zprfa7b4cwzpd6minwf3s19d["\163\164\145\160\163"][3]["\156\x61\155\x65"] = $vmujzsg85m6nfqkl2sk9d->getData("\x6e\141\x6d\x65");
                    if ($vmujzsg85m6nfqkl2sk9d->getData("\143\x6f\155\160\154\145\x74\145")) {
                        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\x65\x70"]++;
                    }
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\156\x61\x6d\x65"] = $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\145\160\163"][3]["\x6e\x61\155\145"];
                } else {
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\145\x70"]++;
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\x65\160\x73"][3]["\x70\x65\x72\x63\145\156\164"] = 100;
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6e\x61\155\145"] = $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\x74\145\160\x73"][3]["\156\141\155\145"];
            } elseif ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\x74\145\160"] == 4) {
                foreach ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\163\x74\145\160\x73"] as $r7h39o6yw3h2d1eny => $gqakbwhf98vslcc44gh1x922cqd45m8) {
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x73\164\x65\160\x73"][$r7h39o6yw3h2d1eny]["\160\x65\x72\143\x65\x6e\164"] = 100;
                }
            }
            if (\Bitrix\Main\Loader::includeSharewareModule("\166" . "\153\141\x70\x69\x2e\155\141" . "" . "\x72" . "" . "" . "\x6b\x65" . "" . "" . "" . "\164") == constant("\115\117\104\125\114\105\x5f\104\105\115" . "" . "\x4f" . "\x5f\105" . "\130\x50" . "" . "\x49\x52\x45\x44")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\x41\120\111\56\115\101\x52\x4b\x45\x54\x2e\104\x45\115\117\137" . "" . "\105\x58" . "\120" . "" . "\111" . "\x52\x45" . "" . "" . "\104"), "\x42\130\x4d\x41\113\105\x52\x5f\104\x45\115\117\x5f\105\x58\x50\x49" . "" . "\122\x45" . "" . "\104");
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\162\x63\x65\x6e\x74"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\145\x72\143\x65\x6e\164"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\155\160\154\x65\164\x65"] = true;
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        return $omyrf638rz9mnhsms16;
    }
    
    public function getVkAlbums()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $gj03ffx0z2v0adev = [];
        try {
            $jx2vbliijuzz6cd5m40tr89qxygj6y = ["\x6f\x77\156\x65\x72\137\x69\144" => "\55" . $this->exportItem()->getGroupId(), "\x6f\x66\146\x73\x65\x74" => 0, "\143\157\x75\x6e\x74" => 100];
            $xc8j1ah1myosrukg8w093 = false;
            while (!$xc8j1ah1myosrukg8w093) {
                $oqa82y51klb5z8o77038d2uz = $this->exportItem()->connection()->method("\x6d\141\x72\x6b\145\x74\x2e\147\145\164\x41\154\142\165\x6d\x73", $jx2vbliijuzz6cd5m40tr89qxygj6y);
                $tvgtuqmwpwo = $oqa82y51klb5z8o77038d2uz->getData("\162\145\163\x70\157\x6e\163\145");
                
                if ($tvgtuqmwpwo["\x63\157\165\x6e\164"] > $jx2vbliijuzz6cd5m40tr89qxygj6y["\x63\157\x75\x6e\164"] + $jx2vbliijuzz6cd5m40tr89qxygj6y["\x6f\146\146\163\x65\164"]) {
                    $jx2vbliijuzz6cd5m40tr89qxygj6y["\x6f\x66\x66\x73\x65\164"] += $jx2vbliijuzz6cd5m40tr89qxygj6y["\143\157\165\x6e\x74"];
                } else {
                    $xc8j1ah1myosrukg8w093 = true;
                }
                $gj03ffx0z2v0adev = array_merge($gj03ffx0z2v0adev, $tvgtuqmwpwo["\x69\164\145\155\163"]);
            }
        } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
            $this->log()->error($this->getMessage("\x47\x45\124\x5f\126\113\137\x41\114\x42\x55\x4d\123", ["\43\115\x53\107\43" => $daivyxab5s88lc25yfxhj->getMessage()]));
        }
        $omyrf638rz9mnhsms16->setData("\x69\x74\145\155\x73", $gj03ffx0z2v0adev);
        $omyrf638rz9mnhsms16->setData("\143\x6f\165\156\164", count($gj03ffx0z2v0adev));
        return $omyrf638rz9mnhsms16;
    }
    
    public function getAlbums()
    {
        $sbyneinl5sdgdhbslvxopcfi = [];
        $h48ses3491xtgdgrwj3fw78z93w = $this->albumExportTable()->getList(["\x6f\x72\144\x65\x72" => ["\x49\x44" => "\101\x53\103"], "\x66\x69\154\164\x65\162" => ["\107\x52\x4f\125\x50\137\111\x44" => $this->exportItem()->getGroupId()]]);
        while ($m7mie25xkl3q5zjuawl62og = $h48ses3491xtgdgrwj3fw78z93w->fetch()) {
            $sbyneinl5sdgdhbslvxopcfi[$m7mie25xkl3q5zjuawl62og["\x49\x44"]] = $m7mie25xkl3q5zjuawl62og;
        }
        return $sbyneinl5sdgdhbslvxopcfi;
    }
    
    public function getLocalAlbums()
    {
        $sbyneinl5sdgdhbslvxopcfi = [];
        $h48ses3491xtgdgrwj3fw78z93w = $this->item()->table()->getList(["\x6f\162\144\145\x72" => ["\x49\x44" => "\101\x53\x43"], "\x66\151\x6c\x74\x65\x72" => []]);
        while ($m7mie25xkl3q5zjuawl62og = $h48ses3491xtgdgrwj3fw78z93w->fetch()) {
            $sbyneinl5sdgdhbslvxopcfi[$m7mie25xkl3q5zjuawl62og["\x49\x44"]] = $m7mie25xkl3q5zjuawl62og;
        }
        return $sbyneinl5sdgdhbslvxopcfi;
    }
    
    public function exportRunCheckAlbumInVkActionDeleteLocalAlbumFromVk(array $ooesdex7)
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\x65\x78\160\x6f\162\x74\122\x75\x6e\103\150\145\143\x6b\101\x6c\x62\165\x6d\111\156\126\153\x41\x63\x74\x69\x6f\156\104\145\x6c\x65\164\145\x4c\x6f\x63\x61\x6c\x41\x6c\x62\x75\x6d\106\x72\x6f\155\x56\153";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\x63\x6f\155\x70\154\x65\164\145"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\156\x61\x6d\145" => "", "\x63\157\155\160\154\145\164\x65" => false, "\160\x65\x72\143\x65\x6e\164" => 0, "\143\157\165\156\164" => 0, "\157\x66\x66\x73\145\x74" => 0, "\154\x69\155\x69\x74" => 25, "\144\145\154\x65\164\145\x64" => 0, "\x61\162\111\x74\x65\x6d\x73" => null];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        
        if ($this->exportItem()->isDisabledOldAlbumDeleting()) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x6d\160\x6c\145\164\145"] = true;
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\x72\x63\145\x6e\x74"] = 100;
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
            
            $omyrf638rz9mnhsms16->setDataArray(["\x6f\x66\x66\x73\145\x74" => 0, "\143\x6f\165\156\164" => 0, "\x63\157\155\160\154\145\x74\x65" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\155\160\154\x65\164\145"], "\160\x65\162\x63\x65\156\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\x72\143\x65\x6e\x74"], "\156\141\x6d\145" => $this->getMessage("\x43\110\105\103\x4b\x5f\x41\x4c\x42\125\115\137\111\x4e\137\126\113\137\x41\x43\124\x49\117\x4e\x5f\104\105\114\x45\x54\105\x5f\x4c\117\103\x41\114\137\x41\x4c\x42\x55\x4d\x5f\x46\x52\117\x4d\x5f\126\113\x2e\104\x49\x53\101\102\114\x45\104")]);
            return $omyrf638rz9mnhsms16;
        }
        try {
            
            $a2c5m3wbfkjk5lp = $this->getAlbums();
            
            $p2rgr9wbp6t4y2djkotipkqjr6 = array_column($a2c5m3wbfkjk5lp, "\x49\104", "\101\114\102\125\x4d\137\111\104");
            
            $ooesdex7 = array_intersect($ooesdex7, array_keys($p2rgr9wbp6t4y2djkotipkqjr6));
            if (empty($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\x49\x74\x65\x6d\x73"])) {
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\162\x49\x74\145\155\x73"] = $ooesdex7;
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\165\x6e\x74"] = count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\111\x74\x65\155\x73"]);
            }
            if (\CModule::IncludeModuleEx("\166\153\x61\160\x69\x2e\x6d\141\x72" . "" . "" . "" . "" . "\x6b" . "\145" . "" . "\164") == constant("\x4d\117\104\125\114\105\x5f\104" . "" . "\105\x4d\x4f\137\105\x58\120\x49\x52\105" . "" . "" . "" . "" . "\x44")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\101\x50" . "\111\56\115\101\x52\x4b\x45\124\56\x44\x45\115\x4f\137\105\x58\120\x49" . "" . "\x52\x45" . "" . "" . "" . "" . "" . "" . "" . "\x44"), "\x42\x58\115\101\113\x45\x52\x5f\x44\x45" . "\115\x4f\x5f\105\x58\120\111\x52" . "" . "" . "\105" . "" . "\x44");
            }
            
            while (count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\162\111\164\145\x6d\x73"])) {
                $this->manager()->checkTime();
                $zrtt2dda39iul1hxmd7mp = array_slice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\162\x49\164\x65\x6d\163"], 0, 25);
                
                $mdhk7tras0dz7ht = [];
                foreach ($zrtt2dda39iul1hxmd7mp as $j8gnqzapk3t) {
                    $mdhk7tras0dz7ht[] = "\x22" . $j8gnqzapk3t . "\x22\x20\72\40\101\x50\x49\56\155\x61\162\x6b\145\164\x2e\144\x65\154\145\164\x65\x41\x6c\x62\x75\x6d\50\x7b\x22\x6f\167\x6e\x65\x72\137\151\x64\42\x20\x3a\40\55" . $this->exportItem()->getGroupId() . "\x2c\42\141\154\x62\x75\155\x5f\x69\144\42\x20\72\x20\42" . $a2c5m3wbfkjk5lp[$p2rgr9wbp6t4y2djkotipkqjr6[$j8gnqzapk3t]]["\126\113\137\x49\104"] . "\x22\175\x29";
                }
                try {
                    $oqa82y51klb5z8o77038d2uz = $this->exportItem()->connection()->method("\x65\170\x65\x63\x75\164\145", ["\x63\157\x64\145" => "\x72\145\164\165\162\x6e\40\173" . implode("\54", $mdhk7tras0dz7ht) . "\x7d\73"]);
                    $tvgtuqmwpwo = $oqa82y51klb5z8o77038d2uz->getData("\x72\145\163\x70\157\x6e\163\x65");
                    $o111ek1to77z66awsoqvc622f = $oqa82y51klb5z8o77038d2uz->getData("\x65\x78\145\143\165\x74\x65\x5f\145\x72\x72\157\x72\x73");
                    $rirry1f4t1yy237m83stmkwy67lun41n7q0 = -1;
                    foreach ($tvgtuqmwpwo as $j8gnqzapk3t => $qkg7zan5a3o3vj0id6frepon7le6d15me95) {
                        if ($qkg7zan5a3o3vj0id6frepon7le6d15me95 == 1) {
                            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x64\145\154\145\x74\x65\x64"]++;
                            $this->log()->ok($this->getMessage("\x43\110\x45\103\113\137\101\x4c\x42\125\x4d\x5f\111\116\137\126\113\137\x41\x43\124\x49\x4f\x4e\x5f\104\x45\x4c\105\124\105\x5f\x4c\x4f\x43\x41\x4c\137\101\114\x42\125\x4d\x5f\106\x52\x4f\x4d\137\x56\113\56\x44\105\114\105\124\105\x44", ["\x23\101\x4c\x42\125\x4d\x5f\111\x44\x23" => $j8gnqzapk3t]));
                        } else {
                            $rirry1f4t1yy237m83stmkwy67lun41n7q0++;
                            if (isset($o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0])) {
                                $this->log()->notice($this->getMessage("\x43\110\105\x43\113\137\x41\x4c\x42\x55\115\x5f\111\116\x5f\x56\113\137\x41\103\x54\x49\x4f\116\x5f\104\x45\x4c\105\x54\105\x5f\x4c\117\x43\x41\x4c\x5f\x41\x4c\102\125\115\x5f\106\x52\117\x4d\137\126\x4b\56\x44\x45\x4c\105\124\105\137\105\x52\122\x4f\x52", ["\x23\x4d\x53\107\43" => $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\x72\162\157\x72\x5f\143\x6f\144\145"] . "\x20" . $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\145\162\162\157\x72\137\x6d\163\147"], "\43\x41\x4c\102\x55\115\137\111\x44\x23" => $j8gnqzapk3t]));
                            }
                        }
                    }
                    
                    $this->deleteByAlbumId($zrtt2dda39iul1hxmd7mp);
                } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
                    $this->log()->error($this->getMessage("\x43\x48\x45\103\x4b\137\x41\114\102\125\115\137\x49\116\137\126\113\137\x41\x43\x54\x49\117\x4e\137\104\105\x4c\x45\x54\105\137\x4c\117\x43\x41\114\137\x41\114\102\x55\115\137\x46\122\117\115\137\126\x4b\56\x45\122\x52\117\x52", ["\43\115\123\x47\x23" => $daivyxab5s88lc25yfxhj->getMessage()]));
                    throw $daivyxab5s88lc25yfxhj;
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\164\145\155\163"] = array_slice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\x49\164\x65\x6d\163"], 25);
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\x66\146\163\x65\x74"] += count($zrtt2dda39iul1hxmd7mp);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\162\x63\x65\156\x74"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\x72\143\145\156\164"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\x6d\x70\x6c\145\164\x65"] = true;
            unset($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\x74\145\x6d\x73"]);
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray(["\x6f\146\x66\x73\x65\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\x66\x66\x73\x65\164"], "\x63\x6f\x75\x6e\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x75\156\x74"], "\x63\x6f\155\x70\154\145\x74\145" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x6d\x70\x6c\x65\x74\145"], "\x70\x65\162\143\x65\156\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\145\162\143\x65\x6e\x74"], "\x64\145\154\x65\164\x65\x64" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\144\145\154\145\164\145\x64"], "\156\141\155\145" => $this->getMessage("\x43\x48\105\x43\113\137\101\114\102\x55\x4d\x5f\x49\116\x5f\126\x4b\x5f\x41\x43\x54\x49\117\116\x5f\104\105\114\105\x54\x45\x5f\x4c\117\103\101\114\x5f\x41\114\x42\x55\x4d\x5f\x46\x52\117\115\x5f\x56\113\56\x53\124\101\x54\125\x53", ["\x23\x43\117\125\x4e\124\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\x75\x6e\164"], "\43\x4f\x46\x46\x53\x45\124\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\x66\x73\145\164"], "\x23\x44\105\x4c\x45\124\x45\104\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\144\x65\x6c\x65\x74\x65\144"]])]);
        return $omyrf638rz9mnhsms16;
    }
    
    public function exportRunCheckAlbumInVkActionDeleteUnknownAlbumFromVk(array $dg7fo2zi)
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\x65\170\x70\x6f\x72\164\122\165\156\x43\x68\x65\x63\x6b\x41\x6c\142\x75\155\111\x6e\x56\x6b\x41\x63\x74\x69\x6f\156\104\145\x6c\x65\164\x65\x55\156\153\156\x6f\x77\156\x41\x6c\x62\165\x6d\x46\162\157\x6d\x56\x6b";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\x63\x6f\x6d\x70\x6c\145\x74\145"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\156\x61\x6d\x65" => "", "\143\x6f\x6d\x70\x6c\145\x74\145" => false, "\160\x65\x72\x63\x65\x6e\164" => 0, "\x63\157\x75\x6e\164" => 0, "\x6f\x66\146\163\145\x74" => 0, "\154\x69\x6d\x69\164" => 25, "\x64\145\x6c\145\164\x65\144" => 0, "\141\162\x49\164\145\x6d\163" => null];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        
        if ($this->exportItem()->isDisabledOldAlbumDeleting()) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\155\x70\x6c\145\x74\145"] = true;
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\x65\162\143\145\156\164"] = 100;
            
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
            
            $omyrf638rz9mnhsms16->setDataArray(["\143\157\165\156\x74" => 0, "\157\x66\x66\x73\145\x74" => 0, "\143\157\x6d\x70\x6c\145\x74\x65" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x6d\x70\x6c\x65\x74\145"], "\x70\145\x72\x63\x65\156\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\162\x63\x65\x6e\164"], "\144\145\154\x65\x74\145\144" => 0, "\156\141\155\145" => $this->getMessage("\103\110\105\x43\x4b\137\x41\x4c\102\x55\x4d\x5f\x49\x4e\137\126\113\x5f\101\103\x54\x49\x4f\x4e\x5f\104\x45\x4c\105\124\105\137\125\116\x4b\116\117\x57\x4e\137\101\x4c\x42\125\x4d\137\x46\x52\x4f\115\137\126\113\x2e\x44\111\x53\101\102\x4c\x45\104")]);
            return $omyrf638rz9mnhsms16;
        }
        if (empty($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\x49\x74\145\x6d\x73"])) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\x72\x49\164\x65\155\x73"] = array_diff($dg7fo2zi, [0, -1]);
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x75\x6e\164"] = count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\x72\111\x74\x65\x6d\163"]);
        }
        try {
            
            while (count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\164\145\155\163"])) {
                $this->manager()->checkTime();
                $zrtt2dda39iul1hxmd7mp = array_slice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\x49\x74\x65\x6d\163"], 0, 25);
                
                $mdhk7tras0dz7ht = [];
                foreach ($zrtt2dda39iul1hxmd7mp as $q8xqn0p95w903qsjel3hhvox2ikx7aen) {
                    $mdhk7tras0dz7ht[] = "\x22" . $q8xqn0p95w903qsjel3hhvox2ikx7aen . "\42\40\x3a\x20\x41\x50\x49\56\x6d\141\162\x6b\x65\164\x2e\x64\145\154\x65\164\145\x41\154\x62\165\x6d\50\173\x22\157\x77\x6e\145\162\x5f\x69\144\x22\40\x3a\x20\55" . $this->exportItem()->getGroupId() . "\x2c\42\141\x6c\x62\165\x6d\x5f\x69\x64\42\40\72\x20\42" . $q8xqn0p95w903qsjel3hhvox2ikx7aen . "\42\175\51";
                }
                if (\Bitrix\Main\Loader::includeSharewareModule("\166\153\x61\x70\151\56\155\x61" . "\x72\153\145\x74") === constant("\115" . "\x4f\x44\125\x4c\105\x5f\x44\x45\x4d\117\137\105\130\x50\x49\x52\105" . "\104")) {
                    throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\x4b\x41\120\x49\x2e\x4d\101\x52\x4b\x45\124\x2e\x44\x45\115\117\x5f\x45\130\120\x49\x52\x45\x44"), "\102" . "\x58\x4d\x41\x4b\x45\x52\x5f\x44\x45\x4d\x4f\137\x45\x58\120\111\x52\x45" . "\x44");
                }
                try {
                    $oqa82y51klb5z8o77038d2uz = $this->exportItem()->connection()->method("\145\x78\x65\x63\x75\164\145", ["\143\x6f\x64\145" => "\x72\x65\164\165\x72\156\40\x7b" . implode("\54", $mdhk7tras0dz7ht) . "\175\x3b"]);
                    $tvgtuqmwpwo = $oqa82y51klb5z8o77038d2uz->getData("\x72\x65\x73\x70\x6f\x6e\x73\x65");
                    $o111ek1to77z66awsoqvc622f = $oqa82y51klb5z8o77038d2uz->getData("\145\x78\x65\143\x75\164\x65\137\x65\x72\x72\x6f\162\163");
                    $rirry1f4t1yy237m83stmkwy67lun41n7q0 = -1;
                    foreach ($tvgtuqmwpwo as $q8xqn0p95w903qsjel3hhvox2ikx7aen => $qkg7zan5a3o3vj0id6frepon7le6d15me95) {
                        if ($qkg7zan5a3o3vj0id6frepon7le6d15me95 == 1) {
                            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\144\145\154\145\x74\x65\x64"]++;
                            $this->log()->ok($this->getMessage("\103\x48\105\x43\x4b\137\x41\x4c\102\125\115\x5f\x49\x4e\137\x56\x4b\137\x41\x43\x54\111\117\116\x5f\104\x45\114\x45\x54\x45\137\x55\x4e\x4b\116\117\127\x4e\137\x41\x4c\x42\x55\x4d\137\106\122\x4f\x4d\x5f\126\x4b\56\x44\105\114\105\124\x45\104", ["\x23\101\x4c\x42\x55\x4d\x5f\111\x44\43" => $q8xqn0p95w903qsjel3hhvox2ikx7aen]));
                        } else {
                            $rirry1f4t1yy237m83stmkwy67lun41n7q0++;
                            if (isset($o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0])) {
                                $this->log()->notice($this->getMessage("\103\110\105\x43\113\x5f\x41\114\x42\x55\x4d\x5f\111\116\x5f\126\x4b\137\x41\103\124\x49\x4f\x4e\137\x44\x45\x4c\105\x54\x45\x5f\x55\116\113\116\x4f\127\x4e\x5f\101\114\x42\125\115\x5f\106\122\x4f\x4d\137\x56\x4b\x2e\x44\105\x4c\x45\124\105\x5f\105\x52\x52\x4f\122", ["\x23\115\123\x47\43" => $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\x72\x72\x6f\162\137\x63\157\144\x65"] . "\40" . $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\162\162\157\162\x5f\155\x73\147"], "\43\x41\114\102\x55\115\137\x49\x44\x23" => $q8xqn0p95w903qsjel3hhvox2ikx7aen]));
                            }
                        }
                    }
                } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
                    $this->log()->error($this->getMessage("\x43\x48\x45\x43\x4b\137\x41\x4c\x42\x55\x4d\137\x49\116\137\x56\x4b\137\101\103\x54\x49\117\x4e\x5f\104\105\114\105\x54\x45\137\125\116\113\116\x4f\x57\x4e\x5f\x41\x4c\x42\125\115\x5f\x46\x52\x4f\115\x5f\126\113\56\105\x52\x52\x4f\122", ["\x23\x4d\123\107\x23" => $daivyxab5s88lc25yfxhj->getMessage()]));
                    throw $daivyxab5s88lc25yfxhj;
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\x49\x74\x65\155\163"] = array_slice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\162\111\164\145\155\x73"], 25);
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\x66\163\145\164"] += count($zrtt2dda39iul1hxmd7mp);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\x72\x63\x65\156\x74"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\x72\143\145\156\164"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\x6d\160\x6c\145\164\145"] = true;
            unset($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\x74\x65\155\x73"]);
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray(["\x6f\x66\x66\x73\x65\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\x66\163\145\164"], "\143\157\x75\156\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\x75\x6e\164"], "\x63\x6f\155\x70\154\145\x74\145" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x6d\x70\154\145\x74\x65"], "\160\145\162\x63\x65\156\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\x65\x72\143\x65\x6e\x74"], "\x64\145\x6c\x65\x74\145\144" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x64\x65\x6c\x65\164\x65\144"], "\156\141\155\x65" => $this->getMessage("\103\110\x45\103\113\137\101\114\102\x55\x4d\x5f\x49\116\137\x56\x4b\137\x41\x43\124\111\117\116\x5f\104\105\x4c\x45\124\x45\x5f\x55\x4e\x4b\x4e\117\x57\x4e\x5f\x41\x4c\x42\x55\x4d\137\106\x52\x4f\115\137\x56\113\56\123\x54\x41\x54\125\123", ["\43\103\117\x55\116\x54\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\165\x6e\x74"], "\43\x4f\x46\106\123\105\124\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\x66\146\x73\145\164"], "\43\x44\105\114\105\124\105\x44\x23" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\144\145\x6c\x65\164\145\x64"]])]);
        return $omyrf638rz9mnhsms16;
    }
    
    public function exportRunCheckAlbumPhotoInVk()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        
        $sneo9rs19907634 = $this->exportItem()->getAlbumIds();
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\145\170\x70\157\x72\x74\x52\165\x6e\x43\x68\145\x63\x6b\x41\154\x62\x75\155\120\x68\x6f\164\x6f\111\x6e\126\153";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\x63\157\155\x70\x6c\145\164\x65"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\156\141\155\x65" => false, "\x63\157\155\160\154\145\164\x65" => false, "\x70\145\162\x63\x65\156\164" => 0, "\x63\x6f\165\x6e\x74" => 0, "\x6f\146\146\x73\x65\x74" => 0, "\x6c\151\x6d\x69\164" => 25, "\x61\162\111\x64" => null];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        
        if (empty($sneo9rs19907634)) {
            return $omyrf638rz9mnhsms16->setDataArray(["\x6e\x61\155\x65" => "", "\x63\x6f\x75\156\x74" => 0, "\157\x66\x66\163\x65\164" => 0, "\x63\157\x6d\160\154\x65\164\x65" => true, "\x70\x65\162\x63\x65\x6e\x74" => 100]);
        }
        try {
            if (empty($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\x49\144"])) {
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\x49\x64"] = $this->exportRunCheckAlbumPhotoInVkActionGetIds();
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\165\x6e\x74"] = count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\x49\144"]);
            }
            while (count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\162\111\x64"])) {
                $this->manager()->checkTime();
                $kcf7pvabo52w7y21nx6dnqxz = array_slice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\144"], 0, 1);
                
                $sf1sz4tlumv4azw8g4w7xm50fl29f = [];
                $jrnb1pvihaujpu4yvu4c8343310 = $this->item()->table()->getList(["\146\151\154\164\145\x72" => ["\111\104" => $kcf7pvabo52w7y21nx6dnqxz], "\163\x65\154\x65\x63\164" => ["\x49\104", "\x50\111\x43\x54\x55\x52\x45"]]);
                while ($fv3hi2pemn9 = $jrnb1pvihaujpu4yvu4c8343310->fetch()) {
                    $sf1sz4tlumv4azw8g4w7xm50fl29f[$fv3hi2pemn9["\111\104"]] = $fv3hi2pemn9["\120\111\x43\124\125\122\105"];
                }
                try {
                    
                    $ydgqjvjicwn3fhbjz4zh5bfnpry1u05oi = $this->photo()->exportAlbumPictures(array_values($sf1sz4tlumv4azw8g4w7xm50fl29f));
                    $higoc3f0wvhx0vijtsae0tlv = array_flip($sf1sz4tlumv4azw8g4w7xm50fl29f);
                    $zkadbd4le2 = $ydgqjvjicwn3fhbjz4zh5bfnpry1u05oi->getData("\x69\x74\x65\x6d\163");
                    foreach ($zkadbd4le2 as $kexb0108gprn7tw2bkia5cb => $x3ecx4q) {
                        
                        if (!$x3ecx4q->isSuccess()) {
                            $this->log()->error($this->getMessage("\103\110\105\x43\113\x5f\x41\x4c\102\x55\x4d\x5f\120\110\x4f\124\117\137\111\116\137\126\x4b\56\x46\111\114\105\x5f\105\x52\x52\117\122", ["\x23\106\x49\114\105\x5f\111\x44\43" => $kexb0108gprn7tw2bkia5cb, "\x23\x41\x4c\102\x55\x4d\x5f\111\x44\43" => $higoc3f0wvhx0vijtsae0tlv[$kexb0108gprn7tw2bkia5cb], "\x23\x4d\123\107\43" => $x3ecx4q->getFirstErrorMessage()]));
                            break;
                        }
                    }
                    if (\Bitrix\Main\Loader::includeSharewareModule("\x76\153" . "\x61\160\x69\56" . "\x6d\x61\162\153\x65" . "\164") == constant("\115\x4f\x44\125\114\x45\137\x44\105\x4d\117\137\105\x58\120\111" . "" . "\x52\x45" . "" . "\104")) {
                        throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\113\x41\120\x49\x2e\115\101\x52" . "\x4b\105\124\x2e\104\105\x4d\x4f\x5f" . "" . "" . "\105\x58\x50" . "\x49\x52" . "\x45\x44"), "\x42\x58\x4d\101\x4b\x45\x52\x5f\x44\105\115\117\137\105" . "\130\120\x49" . "\122\x45\104");
                    }
                } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
                    $this->log()->error($this->getMessage("\103\110\105\103\x4b\x5f\x41\114\102\125\115\x5f\120\110\x4f\124\117\x5f\x49\116\137\126\113\56\x45\x52\122\117\122", ["\x23\115\x53\107\43" => $daivyxab5s88lc25yfxhj->getMessage()]));
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\111\x64"] = array_slice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\x64"], count($kcf7pvabo52w7y21nx6dnqxz));
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\x66\146\x73\145\164"] += count($kcf7pvabo52w7y21nx6dnqxz);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\x65\x72\x63\x65\x6e\164"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\145\x72\143\145\x6e\x74"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x6d\x70\x6c\x65\164\x65"] = true;
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray(["\x6f\146\146\x73\x65\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\x66\x66\163\x65\164"], "\x63\157\165\156\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\165\x6e\x74"], "\143\x6f\155\160\x6c\145\164\145" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x6d\x70\x6c\145\x74\145"], "\x70\x65\162\x63\145\156\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\x72\143\x65\x6e\x74"], "\x6e\x61\155\145" => $this->getMessage("\x43\110\x45\x43\113\137\x41\x4c\x42\125\x4d\137\x50\110\117\x54\x4f\x5f\111\x4e\137\x56\x4b\56\x53\124\101\124\x55\x53", ["\43\103\117\x55\x4e\x54\x23" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\x75\x6e\x74"], "\x23\117\106\106\123\x45\124\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\x66\x66\x73\145\x74"]])]);
        return $omyrf638rz9mnhsms16;
    }
    
    public function exportRunCheckAlbumPhotoInVkActionGetIds()
    {
        $k8116empc8ai1z7b6fkj71en8oquzyu2cr = [];
        $sbyneinl5sdgdhbslvxopcfi = $this->exportItem()->getAlbumIds();
        if (empty($sbyneinl5sdgdhbslvxopcfi)) {
            return $k8116empc8ai1z7b6fkj71en8oquzyu2cr;
        }
        
        $jrnb1pvihaujpu4yvu4c8343310 = $this->item()->table()->getList(["\146\x69\154\x74\145\162" => ["\111\104" => $sbyneinl5sdgdhbslvxopcfi, "\x21\120\111\x43\124\x55\122\105" => null]]);
        while ($i6ed798q1skjstv0cq9315o3yq39q4hk5e8 = $jrnb1pvihaujpu4yvu4c8343310->fetch()) {
            $k8116empc8ai1z7b6fkj71en8oquzyu2cr[] = $i6ed798q1skjstv0cq9315o3yq39q4hk5e8["\111\x44"];
        }
        $lqpywhcfuf7zrinsju0lg2ur2nlmxah9i8m = array_slice($k8116empc8ai1z7b6fkj71en8oquzyu2cr, 0, 2);
        if (\CModule::IncludeModuleEx("\166" . "\x6b\141\160\151\56\x6d\x61\162\x6b" . "\x65" . "" . "\164") == constant("\x4d\x4f\x44\125\x4c\x45\137" . "\x44\105\115" . "" . "\x4f")) {
            return $lqpywhcfuf7zrinsju0lg2ur2nlmxah9i8m;
        }
        return $k8116empc8ai1z7b6fkj71en8oquzyu2cr;
    }
    
    public function exportRunUpdateAlbumInVK()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\145\170\160\157\162\164\x52\165\156\125\x70\144\141\164\145\101\x6c\142\165\155\111\156\126\113";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\143\x6f\155\160\154\145\164\x65"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\156\x61\x6d\145" => "", "\x63\x6f\x6d\160\154\145\x74\145" => false, "\x70\145\162\143\145\156\x74" => 0, "\x63\157\x75\x6e\164" => 0, "\x6f\146\146\x73\145\164" => 0, "\154\151\155\x69\164" => 25, "\165\x70\144\141\164\145\144" => 0];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        try {
            $d8ij1bf8r = $this->exportItem()->getAlbumIds();
            if (empty($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x75\156\x74"])) {
                if (!empty($d8ij1bf8r)) {
                    
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\165\x6e\164"] = $this->albumExportTable()->getCount(["\107\122\x4f\125\120\137\x49\x44" => $this->exportItem()->getGroupId(), "\x41\114\x42\125\x4d\137\x49\x44" => $d8ij1bf8r]);
                }
            }
            
            while ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x75\x6e\x74"] > $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\x66\x73\145\164"]) {
                $this->manager()->checkTime();
                
                $wsbhckk = [];
                $jrnb1pvihaujpu4yvu4c8343310 = $this->albumExportTable()->getList(["\x73\145\x6c\x65\143\x74" => ["\x2a", "\x56\x4b\137\116\101\x4d\x45" => "\x49\124\105\115\x2e\x56\x4b\x5f\x4e\101\115\105", "\120\x49\x43\x54\125\x52\x45" => "\111\x54\105\x4d\56\x50\x49\103\x54\x55\x52\x45", "\x50\x48\x4f\x54\117\137\x49\104" => "\x50\110\117\124\117\56\x50\x48\x4f\x54\117\x5f\x49\104"], "\146\x69\154\x74\145\162" => ["\107\122\117\x55\120\x5f\111\x44" => $this->exportItem()->getGroupId(), "\101\114\102\x55\x4d\x5f\x49\104" => $d8ij1bf8r], "\162\165\x6e\164\x69\155\145" => [new \Bitrix\Main\Entity\ReferenceField("\120\110\117\x54\x4f", "\134\x56\x4b\x61\160\151\x5c\115\x61\162\x6b\x65\x74\x5c\x45\170\x70\x6f\x72\x74\134\x50\x68\x6f\164\157\x54\x61\x62\154\145", ["\75\164\x68\x69\x73\56\x50\x49\x43\x54\125\122\105" => "\x72\x65\146\x2e\106\111\114\105\137\111\x44", "\75\x72\x65\146\x2e\x47\x52\x4f\x55\120\137\111\104" => new \Bitrix\Main\DB\SqlExpression("\x3f\151", $this->exportItem()->getGroupId())], ["\152\x6f\x69\x6e\137\x74\x79\x70\x65" => "\x4c\x45\x46\x54"])], "\157\x66\146\x73\x65\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\146\x73\145\164"], "\x6c\x69\x6d\x69\164" => 25]);
                while ($i6ed798q1skjstv0cq9315o3yq39q4hk5e8 = $jrnb1pvihaujpu4yvu4c8343310->fetch()) {
                    if ($this->getHash($i6ed798q1skjstv0cq9315o3yq39q4hk5e8) != $i6ed798q1skjstv0cq9315o3yq39q4hk5e8["\110\x41\123\110"]) {
                        $wsbhckk[$i6ed798q1skjstv0cq9315o3yq39q4hk5e8["\x41\x4c\102\125\x4d\137\111\x44"]] = $i6ed798q1skjstv0cq9315o3yq39q4hk5e8;
                    }
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\x66\x73\145\x74"]++;
                }
                if (empty($wsbhckk)) {
                    continue;
                }
                
                $mdhk7tras0dz7ht = [];
                foreach ($wsbhckk as $q8xqn0p95w903qsjel3hhvox2ikx7aen => $mkng7vmszpg9fdzjjizainqj8pt) {
                    $uy41s2kilxtvgehpzb83j = ["\x6f\167\156\x65\162\x5f\x69\144" => "\x2d" . $this->exportItem()->getGroupId(), "\141\154\142\x75\x6d\137\151\144" => $mkng7vmszpg9fdzjjizainqj8pt["\126\113\x5f\x49\104"], "\x74\151\164\x6c\x65" => $mkng7vmszpg9fdzjjizainqj8pt["\126\113\x5f\x4e\x41\x4d\105"]];
                    if (intval($mkng7vmszpg9fdzjjizainqj8pt["\120\x48\x4f\124\117\x5f\x49\104"])) {
                        $uy41s2kilxtvgehpzb83j["\160\x68\157\x74\157\x5f\151\x64"] = $mkng7vmszpg9fdzjjizainqj8pt["\x50\110\117\x54\117\x5f\x49\104"];
                    }
                    $mdhk7tras0dz7ht[] = "\42" . $q8xqn0p95w903qsjel3hhvox2ikx7aen . "\42\40\x3a\x20\x41\x50\x49\x2e\155\141\x72\x6b\x65\164\x2e\x65\144\151\164\101\x6c\x62\165\155\x28" . $this->manager()->toJsonString($uy41s2kilxtvgehpzb83j) . "\x29";
                }
                if (\CModule::IncludeModuleEx("\x76\153\x61\x70\x69\x2e\155" . "\x61\162" . "\x6b\145" . "\164") === constant("\115\117\104" . "\x55\x4c" . "\x45\x5f\104\x45\115\117\x5f\105\130" . "\120\x49\x52\105" . "\104")) {
                    throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\x41\x50\111\x2e\115\101\122\x4b\x45\124\x2e\x44\x45\x4d\117\137\105\x58\120\x49\122" . "" . "\x45" . "" . "" . "" . "\x44"), "\x42\130\x4d\x41\113\105\x52\137\x44\x45\115\117\137\105\130\x50" . "" . "" . "\111\x52" . "" . "" . "\x45\x44");
                }
                try {
                    $oqa82y51klb5z8o77038d2uz = $this->exportItem()->connection()->method("\145\x78\x65\x63\x75\x74\x65", ["\143\x6f\144\145" => "\x72\x65\x74\165\x72\x6e\40\173" . implode("\54", $mdhk7tras0dz7ht) . "\175\x3b"]);
                    $tvgtuqmwpwo = $oqa82y51klb5z8o77038d2uz->getData("\162\x65\163\x70\x6f\156\x73\x65");
                    $o111ek1to77z66awsoqvc622f = $oqa82y51klb5z8o77038d2uz->getData("\145\x78\x65\x63\165\x74\x65\137\x65\162\162\x6f\x72\163");
                    $rirry1f4t1yy237m83stmkwy67lun41n7q0 = -1;
                    foreach ($tvgtuqmwpwo as $q8xqn0p95w903qsjel3hhvox2ikx7aen => $il1ea87vy) {
                        if ($il1ea87vy == 1) {
                            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x75\160\x64\141\164\145\x64"]++;
                            
                            $this->albumExportTable()->update($q8xqn0p95w903qsjel3hhvox2ikx7aen, ["\110\101\x53\x48" => $this->getHash($wsbhckk[$q8xqn0p95w903qsjel3hhvox2ikx7aen])]);
                            $this->log()->ok($this->getMessage("\x55\120\104\101\x54\105\x5f\x41\114\102\x55\115\137\x49\116\137\x56\113\56\125\x50\x44\101\124\x45\x44", ["\43\101\x4c\x42\125\115\137\x49\x44\x23" => $q8xqn0p95w903qsjel3hhvox2ikx7aen, "\x23\126\113\x5f\111\104\x23" => $mkng7vmszpg9fdzjjizainqj8pt["\126\113\137\x49\104"]]));
                        } else {
                            $rirry1f4t1yy237m83stmkwy67lun41n7q0++;
                            if (isset($o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0])) {
                                $this->log()->error($this->getMessage("\125\120\104\x41\124\x45\137\x41\114\x42\x55\115\x5f\x49\116\x5f\126\x4b\56\125\120\x44\101\124\105\x5f\105\x52\122\x4f\x52", ["\43\x4d\123\107\43" => $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\145\x72\x72\x6f\x72\x5f\143\x6f\144\x65"] . "\x20" . $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\162\162\157\162\x5f\x6d\x73\x67"], "\x23\101\x4c\x42\x55\x4d\137\x49\104\x23" => $q8xqn0p95w903qsjel3hhvox2ikx7aen]));
                                if ($o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\x72\162\157\162\x5f\x63\157\144\x65"] == \VKapi\Market\Api::ERROR_100 && preg_match("\x2f\134\x3a\134\x73\x2b\160\x68\157\x74\157\134\163\53\x2f", $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\162\162\x6f\162\x5f\x6d\163\147"])) {
                                    
                                    $this->photo()->deleteByPhotoId((array) intval($wsbhckk[$q8xqn0p95w903qsjel3hhvox2ikx7aen]["\120\110\117\x54\x4f\x5f\x49\104"]), $this->exportItem()->getGroupId());
                                }
                            }
                        }
                    }
                } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
                    $this->log()->error($this->getMessage("\x55\120\104\x41\x54\105\x5f\101\x4c\102\125\115\137\111\116\137\x56\113\56\x45\x52\x52\x4f\x52", ["\43\x4d\x53\x47\43" => $daivyxab5s88lc25yfxhj->getMessage(), "\43\111\x44\x23" => implode("\x2c", array_keys($wsbhckk))]));
                }
            }
            if (\CModule::IncludeModuleEx("\x76\153\141" . "\x70\151\56\x6d" . "\141\162" . "\153\x65\x74") == constant("\115\x4f\x44\x55\x4c\105\x5f\104\105\x4d" . "\x4f\x5f\x45\x58\x50\111" . "" . "\122\x45" . "" . "" . "" . "\104")) {
                throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\101\x50\x49\56\x4d\101\122\113\105\124\x2e\x44\x45\115\x4f\x5f\105\130" . "\120\x49\122\105\104"), "\102\x58\x4d\101\113\105\x52\x5f\104\105\115\117\137\x45\130\120\111\x52\x45" . "\104");
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        
        $this->photo()->deleteTemporaryDirectories();
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\x72\143\145\156\x74"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\162\143\145\156\164"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\155\x70\154\x65\164\145"] = true;
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray(["\143\157\155\x70\154\145\164\x65" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x6d\x70\154\x65\164\x65"], "\x70\x65\x72\143\x65\x6e\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\145\162\x63\145\156\x74"], "\x6f\146\146\163\x65\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\x66\x73\x65\164"], "\x63\157\165\x6e\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x75\x6e\x74"], "\156\x61\x6d\x65" => $this->getMessage("\125\x50\104\101\124\105\x5f\101\x4c\102\x55\x4d\x5f\111\x4e\x5f\x56\113\x2e\x53\x54\101\x54\x55\123", ["\43\x43\117\125\x4e\x54\x23" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\165\156\164"], "\x23\117\x46\x46\x53\x45\x54\x23" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\x66\146\163\145\x74"]])]);
        return $omyrf638rz9mnhsms16;
    }
    
    public function exportRunAddAlbumToVK()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\x65\x78\160\x6f\x72\x74\x52\x75\x6e\101\144\x64\101\x6c\142\x75\155\124\x6f\x56\113";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\x63\x6f\155\160\x6c\x65\x74\145"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\143\x6f\155\160\154\145\x74\x65" => false, "\160\x65\x72\143\145\x6e\164" => 0, "\143\157\165\x6e\x74" => 0, "\x6f\146\x66\x73\x65\x74" => 0, "\x6c\151\155\151\x74" => 25, "\141\144\x64\x65\x64" => 0, "\141\162\111\x64" => null];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        try {
            if (empty($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\162\111\144"])) {
                
                $d8ij1bf8r = $this->exportItem()->getAlbumIds();
                
                $gxnpt9g45vp8l5vrpqs = $this->getAlbums();
                $q23bg3nhmx248tx = array_column($gxnpt9g45vp8l5vrpqs, "\111\x44", "\x41\114\102\x55\115\137\111\104");
                
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\x49\144"] = array_diff($d8ij1bf8r, array_keys($q23bg3nhmx248tx));
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x75\x6e\x74"] = count($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\111\x64"]);
            }
            
            while (!empty($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\162\x49\144"])) {
                $this->manager()->checkTime();
                
                $qj4bxpqlepmyh0dgcvi1 = array_splice($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x72\111\x64"], 0, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6c\151\x6d\x69\x74"]);
                $p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl = $this->item()->getItemsById($qj4bxpqlepmyh0dgcvi1);
                $oup5tjmsuf26vgtslpgldkygmx41ptzpv = array_column($p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl, "\x50\111\103\124\x55\122\x45", "\111\104");
                $nx0q2s47qfi0pc50bi0lknvt583 = $this->photo()->getItemsByFileId($oup5tjmsuf26vgtslpgldkygmx41ptzpv, $this->exportItem()->getGroupId());
                
                $mdhk7tras0dz7ht = [];
                foreach ($qj4bxpqlepmyh0dgcvi1 as $q8xqn0p95w903qsjel3hhvox2ikx7aen) {
                    $uy41s2kilxtvgehpzb83j = ["\x6f\167\156\x65\x72\137\x69\144" => "\x2d" . $this->exportItem()->getGroupId(), "\x74\x69\164\x6c\x65" => $p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl[$q8xqn0p95w903qsjel3hhvox2ikx7aen]["\x56\113\x5f\116\101\x4d\x45"]];
                    if (intval($nx0q2s47qfi0pc50bi0lknvt583[$p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl[$q8xqn0p95w903qsjel3hhvox2ikx7aen]["\x50\x49\x43\x54\x55\122\105"]]["\120\110\x4f\x54\117\x5f\111\104"])) {
                        $uy41s2kilxtvgehpzb83j["\x70\150\x6f\164\157\x5f\x69\144"] = $nx0q2s47qfi0pc50bi0lknvt583[$p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl[$q8xqn0p95w903qsjel3hhvox2ikx7aen]["\x50\x49\103\x54\125\x52\x45"]]["\120\110\x4f\124\117\x5f\x49\104"];
                    }
                    $mdhk7tras0dz7ht[] = "\x22" . $q8xqn0p95w903qsjel3hhvox2ikx7aen . "\42\40\x3a\40\101\x50\111\56\x6d\141\162\x6b\x65\164\56\x61\x64\x64\x41\154\142\165\x6d\x28" . $this->manager()->toJsonString($uy41s2kilxtvgehpzb83j) . "\x29";
                }
                try {
                    $oqa82y51klb5z8o77038d2uz = $this->exportItem()->connection()->method("\x65\x78\145\x63\x75\164\x65", ["\x63\157\x64\x65" => "\x72\x65\x74\x75\162\x6e\40\x7b" . implode("\x2c", $mdhk7tras0dz7ht) . "\x7d\x3b"]);
                    $tvgtuqmwpwo = $oqa82y51klb5z8o77038d2uz->getData("\162\145\163\x70\157\156\x73\x65");
                    $o111ek1to77z66awsoqvc622f = $oqa82y51klb5z8o77038d2uz->getData("\x65\170\145\143\165\164\x65\137\x65\162\x72\x6f\162\x73");
                    $rirry1f4t1yy237m83stmkwy67lun41n7q0 = -1;
                    if (\CModule::IncludeModuleEx("\166\153\141\160\x69" . "\56\155" . "\x61\x72\153" . "\145" . "" . "\164") == constant("\x4d\117\104\125\114\105\137\104\x45\x4d\117\x5f\105\x58\x50\111\x52\x45\104")) {
                        throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\x56\113\x41\x50\111\56\115\x41\122" . "\x4b\105\x54\x2e\104\105\115\117\137\105\x58\120\111\x52" . "\x45\x44"), "\102\130\x4d\101\113\x45\122\137\104\x45\x4d\117\137\x45\130\x50\x49\x52\105\104");
                    }
                    foreach ($tvgtuqmwpwo as $q8xqn0p95w903qsjel3hhvox2ikx7aen => $qv0u6b9o4zby9rp) {
                        if (isset($qv0u6b9o4zby9rp["\x6d\x61\162\153\x65\164\x5f\x61\x6c\142\x75\x6d\x5f\x69\144"])) {
                            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x61\x64\x64\145\x64"]++;
                            
                            $this->albumExportTable()->add(["\x47\122\x4f\x55\x50\x5f\x49\x44" => $this->exportItem()->getGroupId(), "\x41\x4c\x42\125\x4d\x5f\x49\x44" => $q8xqn0p95w903qsjel3hhvox2ikx7aen, "\126\113\137\x49\x44" => $qv0u6b9o4zby9rp["\x6d\141\162\x6b\145\x74\137\141\154\x62\165\x6d\x5f\151\144"], "\x48\101\x53\x48" => $this->getHash($p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl[$q8xqn0p95w903qsjel3hhvox2ikx7aen])]);
                            $this->log()->ok($this->getMessage("\x41\x44\x44\137\x41\114\102\x55\115\137\124\x4f\137\126\x4b\56\x41\104\x44\105\104", ["\x23\101\x4c\x42\125\115\x5f\111\x44\43" => $q8xqn0p95w903qsjel3hhvox2ikx7aen, "\x23\126\x4b\x5f\111\x44\x23" => $qv0u6b9o4zby9rp["\x6d\x61\162\x6b\x65\x74\137\141\154\x62\165\155\137\x69\144"]]));
                        } else {
                            $rirry1f4t1yy237m83stmkwy67lun41n7q0++;
                            if (isset($o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0])) {
                                $this->log()->error($this->getMessage("\101\104\104\x5f\x41\114\x42\x55\115\x5f\124\x4f\x5f\x56\113\x2e\x41\104\104\137\x45\x52\122\117\x52", ["\x23\x4d\123\x47\x23" => $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\145\162\x72\157\162\137\x63\x6f\x64\x65"] . "\x20" . $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\x65\162\162\x6f\162\x5f\x6d\163\147"], "\43\101\x4c\x42\x55\115\137\111\104\x23" => $q8xqn0p95w903qsjel3hhvox2ikx7aen]));
                                if ($o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\145\x72\x72\x6f\x72\x5f\143\x6f\144\x65"] == \VKapi\Market\Api::ERROR_100 && preg_match("\57\134\x3a\x5c\163\53\160\150\157\x74\157\134\x73\x2b\57", $o111ek1to77z66awsoqvc622f[$rirry1f4t1yy237m83stmkwy67lun41n7q0]["\145\162\162\x6f\162\x5f\155\x73\147"])) {
                                    
                                    $this->photo()->deleteByPhotoId((array) intval($nx0q2s47qfi0pc50bi0lknvt583[$p45vs0zsu2ln0k5rpm6a1rx87ali0h28hbl[$q8xqn0p95w903qsjel3hhvox2ikx7aen]["\120\111\x43\124\125\x52\105"]]["\x50\x48\x4f\x54\117\x5f\x49\x44"]), $this->exportItem()->getGroupId());
                                }
                            }
                        }
                    }
                } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
                    $this->log()->error($this->getMessage("\101\104\x44\137\101\114\x42\x55\115\137\x54\117\x5f\126\x4b\56\x45\122\x52\117\122", ["\x23\115\123\107\x23" => $daivyxab5s88lc25yfxhj->getMessage(), "\x23\x41\x4c\x42\125\x4d\137\111\x44\x23" => implode("\x2c", array_keys($qj4bxpqlepmyh0dgcvi1))]));
                }
                $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\146\163\x65\x74"] += count($qj4bxpqlepmyh0dgcvi1);
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        
        $this->photo()->deleteTemporaryDirectories();
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\145\x72\x63\145\x6e\x74"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x70\145\x72\x63\145\156\x74"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x6d\x70\154\145\x74\145"] = true;
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray(["\143\157\155\x70\154\145\164\x65" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\x6d\x70\x6c\145\x74\x65"], "\160\x65\162\x63\145\x6e\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\x72\143\145\x6e\x74"], "\157\146\x66\163\145\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\x66\x73\x65\x74"], "\x63\x6f\165\156\164" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x75\156\164"], "\141\144\144\x65\x64" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\141\144\x64\145\144"], "\x6e\141\155\x65" => $this->getMessage("\x41\104\x44\x5f\101\x4c\x42\125\115\137\124\117\x5f\126\x4b\56\123\x54\101\x54\x55\x53", ["\43\x43\117\x55\x4e\x54\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x75\156\164"], "\43\117\x46\x46\x53\x45\124\x23" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\x66\146\x73\145\164"]])]);
        return $omyrf638rz9mnhsms16;
    }
    
    private function exportRunReorderAlbumInVK()
    {
        $omyrf638rz9mnhsms16 = new \VKapi\Market\Result();
        $nu0zsijfkaftfyv551k6y7qassoq54p = "\x65\170\160\157\x72\164\122\165\156\x52\x65\157\162\144\x65\162\x41\x6c\142\x75\x6d\111\x6e\x56\113";
        $z056zprfa7b4cwzpd6minwf3s19d = $this->state()->get();
        if (!isset($z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]) || $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p]["\x63\157\155\160\x6c\x65\164\x65"]) {
            $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p] = ["\156\x61\155\145" => "", "\x63\x6f\155\160\x6c\x65\164\x65" => false, "\160\x65\x72\x63\145\156\164" => 0, "\143\x6f\165\156\x74" => count($this->exportItem()->getAlbumIds()), "\x6f\146\146\163\x65\164" => 0, "\x6c\x69\x6d\x69\164" => 25];
            $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p])->save();
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk = $z056zprfa7b4cwzpd6minwf3s19d[$nu0zsijfkaftfyv551k6y7qassoq54p];
        if (\Bitrix\Main\Loader::includeSharewareModule("\x76\x6b\141\160\x69\x2e\x6d\x61" . "\162\x6b" . "" . "\x65" . "\164") == constant("\x4d\x4f\x44" . "\x55\114\x45\137" . "\x44\x45\x4d\x4f\x5f\105\130\x50\111\x52\105" . "" . "\x44")) {
            throw new \VKapi\Market\Exception\BaseException(\Bitrix\Main\Localization\Loc::getMessage("\126\x4b\101\x50\x49\56\115\x41\122\113\105" . "\124\x2e\x44\x45" . "\x4d\x4f\137\105\130" . "" . "\120\111" . "\122\105" . "\x44"), "\102\130\115\101\x4b\x45\122\x5f\104\105\x4d\x4f\x5f\105\130\x50\x49" . "" . "" . "" . "\122\x45" . "" . "" . "\x44");
        }
        try {
            
            $d8ij1bf8r = $this->exportItem()->getAlbumIds();
            
            $gxnpt9g45vp8l5vrpqs = $this->getAlbums();
            $ufhuj1ouesduwdz2a4h8j2 = array_column($gxnpt9g45vp8l5vrpqs, "\x56\113\137\111\x44", "\x41\x4c\x42\125\115\x5f\x49\104");
            
            $a0xtb21k3wt5jgahfpxf = [];
            foreach ($d8ij1bf8r as $q8xqn0p95w903qsjel3hhvox2ikx7aen) {
                $a0xtb21k3wt5jgahfpxf[] = $ufhuj1ouesduwdz2a4h8j2[$q8xqn0p95w903qsjel3hhvox2ikx7aen];
            }
            
            $uxvotj0c2oaqwqje9xjjlhjutcy = $this->getAlbumOrderTree($a0xtb21k3wt5jgahfpxf);
            
            $dg7fo2zi = [];
            $add3os2a7z = $this->getVkAlbums();
            foreach ($add3os2a7z->getData("\151\x74\145\x6d\x73") as $xonrv4mm8q5r7cfumldf76i1) {
                $dg7fo2zi[] = $xonrv4mm8q5r7cfumldf76i1["\x69\144"];
            }
            $xxez47e9blnlxrw9h1d1 = $this->getAlbumOrderTree(array_values(array_intersect($dg7fo2zi, $a0xtb21k3wt5jgahfpxf)));
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\x6f\x75\156\164"] = count($uxvotj0c2oaqwqje9xjjlhjutcy);
            
            $sioctirmpl0mj = [];
            foreach ($uxvotj0c2oaqwqje9xjjlhjutcy as $sit31f8 => $d5zp28evp22i5tbwtbzjyecf4veom95) {
                
                if (isset($xxez47e9blnlxrw9h1d1[$sit31f8])) {
                    
                    if ($d5zp28evp22i5tbwtbzjyecf4veom95["\141"] && $xxez47e9blnlxrw9h1d1[$d5zp28evp22i5tbwtbzjyecf4veom95["\141"]]) {
                        if ($xxez47e9blnlxrw9h1d1[$sit31f8]["\x61"] != $d5zp28evp22i5tbwtbzjyecf4veom95["\x61"]) {
                            $sioctirmpl0mj[] = "\42" . $sit31f8 . "\42\x20\x3a\x20\x41\120\111\x2e\155\x61\x72\153\x65\x74\56\162\x65\157\x72\144\x65\162\x41\x6c\142\x75\155\x73\x28\x7b\x22\157\x77\156\x65\x72\x5f\151\144\42\x20\72\40\55" . $this->exportItem()->getGroupId() . "\x2c\x22\x61\154\142\x75\155\x5f\x69\144\42\40\72\40\42" . $sit31f8 . "\42\x2c\40\x22\x61\146\x74\x65\x72\x22\40\72\x20" . $d5zp28evp22i5tbwtbzjyecf4veom95["\x61"] . "\175\x29";
                        } else {
                            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\x66\x66\163\145\164"]++;
                        }
                    } elseif ($d5zp28evp22i5tbwtbzjyecf4veom95["\x62"] && $xxez47e9blnlxrw9h1d1[$d5zp28evp22i5tbwtbzjyecf4veom95["\142"]]) {
                        if ($xxez47e9blnlxrw9h1d1[$sit31f8]["\142"] != $d5zp28evp22i5tbwtbzjyecf4veom95["\142"]) {
                            $sioctirmpl0mj[] = "\42" . $sit31f8 . "\x22\40\72\40\x41\x50\x49\x2e\x6d\x61\162\153\145\164\x2e\162\x65\157\162\x64\145\x72\101\154\x62\x75\155\x73\x28\x7b\42\157\x77\156\x65\x72\x5f\151\x64\x22\x20\x3a\40\55" . $this->exportItem()->getGroupId() . "\x2c\42\x61\x6c\x62\165\x6d\137\x69\x64\x22\40\x3a\x20\x22" . $sit31f8 . "\42\54\40\42\142\x65\146\157\162\x65\42\40\x3a\x20" . $d5zp28evp22i5tbwtbzjyecf4veom95["\142"] . "\x7d\x29";
                        } else {
                            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\146\x73\x65\164"]++;
                        }
                    } else {
                        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\x66\146\x73\x65\164"]++;
                    }
                } else {
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\x66\163\x65\164"]++;
                }
            }
            
            while (count($sioctirmpl0mj) > 0) {
                $this->manager()->checkTime();
                
                $jtcfgdb54wcw25v1khgg2kripvo1frwp2 = array_splice($sioctirmpl0mj, 0, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6c\x69\x6d\151\164"]);
                if (!count($jtcfgdb54wcw25v1khgg2kripvo1frwp2)) {
                    break;
                }
                try {
                    $oqa82y51klb5z8o77038d2uz = $this->exportItem()->connection()->method("\x65\170\145\143\165\164\145", ["\x63\x6f\144\x65" => "\162\x65\164\x75\x72\156\x20\x7b" . implode("\x2c", $jtcfgdb54wcw25v1khgg2kripvo1frwp2) . "\x7d\73"]);
                    $tvgtuqmwpwo = $oqa82y51klb5z8o77038d2uz->getData("\162\x65\163\x70\x6f\156\x73\x65");
                    $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\157\146\146\163\145\164"] += count($jtcfgdb54wcw25v1khgg2kripvo1frwp2);
                } catch (\VKapi\Market\Exception\ApiResponseException $daivyxab5s88lc25yfxhj) {
                    $this->log()->error($this->getMessage("\x52\x45\x4f\x52\104\105\x52\137\x41\114\102\125\115\137\111\116\x5f\126\x4b\x2e\105\122\122\117\122", ["\x23\115\x53\x47\43" => $daivyxab5s88lc25yfxhj->getMessage()]));
                }
            }
        } catch (\VKapi\Market\Exception\TimeoutException $sjuxzs48s) {
            
        }
        $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\145\162\x63\145\156\164"] = $this->state()->calcPercentByData($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk);
        if ($m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\162\x63\x65\x6e\x74"] == 100) {
            $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\157\x6d\160\x6c\145\164\145"] = true;
        }
        $this->state()->setField($nu0zsijfkaftfyv551k6y7qassoq54p, $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk)->save();
        
        $omyrf638rz9mnhsms16->setDataArray(["\x63\157\155\160\154\x65\x74\x65" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\x6d\160\154\145\x74\145"], "\160\x65\x72\x63\x65\156\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\160\x65\162\x63\145\156\x74"], "\x6f\146\x66\x73\145\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\146\x73\145\164"], "\143\x6f\165\x6e\x74" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x63\157\x75\x6e\164"], "\x6e\x61\155\145" => $this->getMessage("\122\105\117\x52\104\x45\122\137\x41\x4c\x42\125\x4d\137\x49\116\x5f\x56\x4b\56\123\x54\x41\x54\125\123", ["\x23\103\117\x55\116\x54\x23" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\143\x6f\x75\156\164"], "\43\x4f\x46\106\x53\x45\x54\43" => $m9rltn3n2p5wr6pn7squ9xwihldcs5j3lk["\x6f\146\x66\163\x65\x74"]])]);
        return $omyrf638rz9mnhsms16;
    }
    
    public function getAlbumOrderTree($sneo9rs19907634)
    {
        $k8116empc8ai1z7b6fkj71en8oquzyu2cr = [];
        foreach ($sneo9rs19907634 as $a61x7wdtvu => $q8xqn0p95w903qsjel3hhvox2ikx7aen) {
            $wc9aym58q224agn7unsz = [
                "\141" => false,
                //after
                "\142" => false,
            ];
            if ($a61x7wdtvu > 0) {
                $wc9aym58q224agn7unsz["\141"] = $sneo9rs19907634[$a61x7wdtvu - 1];
            }
            if ($a61x7wdtvu + 1 < count($sneo9rs19907634)) {
                $wc9aym58q224agn7unsz["\x62"] = $sneo9rs19907634[$a61x7wdtvu + 1];
            }
            $k8116empc8ai1z7b6fkj71en8oquzyu2cr[$q8xqn0p95w903qsjel3hhvox2ikx7aen] = $wc9aym58q224agn7unsz;
        }
        return $k8116empc8ai1z7b6fkj71en8oquzyu2cr;
    }
    
    protected function getVkItemId2LocalAlbumId($lrsk285okb7, $ps9sndx2qq4i7o3t6tvp5j2wzab22z56)
    {
        $k8116empc8ai1z7b6fkj71en8oquzyu2cr = [];
        
        $vk7ow6sy0z1j3lg7k2d5rc1pu3anafphgz = array_column($lrsk285okb7, "\151\x64");
        
        foreach ($vk7ow6sy0z1j3lg7k2d5rc1pu3anafphgz as $k86ctvhnv) {
            if (isset($ps9sndx2qq4i7o3t6tvp5j2wzab22z56[$k86ctvhnv])) {
                $k8116empc8ai1z7b6fkj71en8oquzyu2cr[$k86ctvhnv] = $ps9sndx2qq4i7o3t6tvp5j2wzab22z56[$k86ctvhnv];
            } else {
                
                $k8116empc8ai1z7b6fkj71en8oquzyu2cr[$k86ctvhnv] = 0;
            }
        }
        return $k8116empc8ai1z7b6fkj71en8oquzyu2cr;
    }
    
    protected function deleteByAlbumId($sneo9rs19907634)
    {
        $gxnpt9g45vp8l5vrpqs = $this->getAlbums();
        $s75go46pc80ydhacr43gdyyrz5t3ey1zi = array_column($gxnpt9g45vp8l5vrpqs, "\111\104", "\x41\x4c\x42\x55\115\137\111\104");
        $q4uzmiaw1trm6qbdh1efuu5 = [];
        foreach ($sneo9rs19907634 as $j8gnqzapk3t) {
            $yuncta85zlsssp78xt3o1qk3u = $s75go46pc80ydhacr43gdyyrz5t3ey1zi[$j8gnqzapk3t];
            if ($yuncta85zlsssp78xt3o1qk3u) {
                $q4uzmiaw1trm6qbdh1efuu5[] = $yuncta85zlsssp78xt3o1qk3u;
            }
        }
        
        if (count($q4uzmiaw1trm6qbdh1efuu5)) {
            $uzft8c8snfvvhh472k9f = $this->item()->getItemsById(array_keys($s75go46pc80ydhacr43gdyyrz5t3ey1zi));
            foreach ($q4uzmiaw1trm6qbdh1efuu5 as $yuncta85zlsssp78xt3o1qk3u) {
                
                $this->albumExportTable()->delete($yuncta85zlsssp78xt3o1qk3u);
                $this->log()->notice($this->getMessage("\104\105\114\105\124\x45\x5f\102\x59\137\101\x4c\102\x55\x4d\137\x49\x44", ["\x23\101\114\102\125\115\x5f\111\104\x23" => $gxnpt9g45vp8l5vrpqs[$yuncta85zlsssp78xt3o1qk3u]["\x41\114\x42\x55\115\137\x49\x44"]]), ["\101\114\x42\x55\x4d\x5f\x49\104" => $gxnpt9g45vp8l5vrpqs[$yuncta85zlsssp78xt3o1qk3u]["\x41\x4c\102\125\x4d\x5f\111\x44"]]);
                
                if (isset($uzft8c8snfvvhh472k9f[$s75go46pc80ydhacr43gdyyrz5t3ey1zi[$yuncta85zlsssp78xt3o1qk3u]]) && intval($uzft8c8snfvvhh472k9f[$s75go46pc80ydhacr43gdyyrz5t3ey1zi[$yuncta85zlsssp78xt3o1qk3u]]["\x50\111\x43\124\x55\x52\105"])) {
                    $this->photo()->deleteByFileId($uzft8c8snfvvhh472k9f[$s75go46pc80ydhacr43gdyyrz5t3ey1zi[$yuncta85zlsssp78xt3o1qk3u]]["\120\111\103\x54\125\122\105"], $this->exportItem()->getGroupId());
                }
            }
        }
        return true;
    }
    
    public function getOutsideSort($hq6y0, $clwobn3wdal7cvfsczx4yon0)
    {
        $z90d9p = [];
        $v5awj = false;
        $hq6y0 = array_values($hq6y0);
        $clwobn3wdal7cvfsczx4yon0 = array_values($clwobn3wdal7cvfsczx4yon0);
        foreach ($hq6y0 as $l5jhw69jfhpayczlr1p1q => $vjgwezvhpf1bs2n) {
            if ($v5awj) {
                $z90d9p[] = $vjgwezvhpf1bs2n;
            } elseif (!isset($clwobn3wdal7cvfsczx4yon0[$l5jhw69jfhpayczlr1p1q]) || $clwobn3wdal7cvfsczx4yon0[$l5jhw69jfhpayczlr1p1q] != $vjgwezvhpf1bs2n) {
                $z90d9p[] = $vjgwezvhpf1bs2n;
                $v5awj = true;
            }
        }
        return $z90d9p;
    }
    
    public function getHash($nch3hbaemplgayaxf3v0ru8mhdzndztx6)
    {
        $sq4t7h66hy0bb7b3 = array_intersect_key($nch3hbaemplgayaxf3v0ru8mhdzndztx6, array_flip(["\126\x4b\x5f\x4e\x41\115\105", "\x50\111\x43\124\125\122\x45"]));
        ksort($sq4t7h66hy0bb7b3);
        return md5(serialize($sq4t7h66hy0bb7b3));
    }
    
    protected function getOtherExportsAlbumId()
    {
        $k8116empc8ai1z7b6fkj71en8oquzyu2cr = [];
        if ($this->exportItem()->getGroupId()) {
            $jrnb1pvihaujpu4yvu4c8343310 = $this->manager()->exportTable()->getList(["\146\151\x6c\164\x65\162" => ["\x47\x52\x4f\125\120\137\x49\104" => $this->exportItem()->getGroupId(), "\x41\103\x54\x49\126\105" => true]]);
            while ($i6ed798q1skjstv0cq9315o3yq39q4hk5e8 = $jrnb1pvihaujpu4yvu4c8343310->fetch()) {
                $k8116empc8ai1z7b6fkj71en8oquzyu2cr = array_merge($k8116empc8ai1z7b6fkj71en8oquzyu2cr, $i6ed798q1skjstv0cq9315o3yq39q4hk5e8["\101\x4c\102\125\115\123"]);
            }
        }
        return array_values(array_unique($k8116empc8ai1z7b6fkj71en8oquzyu2cr));
    }
}
?>