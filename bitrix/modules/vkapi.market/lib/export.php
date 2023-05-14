<?php

namespace VKapi\Market;

use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Export
{
    
    private static $instance = null;
    protected $oOption = null;
    protected $oTable = null;
    protected $oElement = false;
    protected $oProperty = false;
    protected $oPropertyEnum = false;
    protected $arProps = array();
    public function __construct()
    {
        $this->oTable = new \VKapi\Market\ExportTable();
        if (\Bitrix\Main\Loader::includeModule("\x69\x62\154\157\x63\153")) {
            $this->oIblock = new \CIBlock();
            $this->oProperty = new \CIBlockProperty();
            $this->oPropertyEnum = new \CIBlockPropertyEnum();
        }
    }
    
    public function manager()
    {
        return \VKapi\Market\Manager::getInstance();
    }
    
    public function getTable()
    {
        return $this->oTable;
    }
    
    public function getMessage($lyj55b11, $g0vvyjqpj = array())
    {
        return \VKapi\Market\Manager::getInstance()->getMessage("\x45\x58\120\117\x52\124\x2e" . $lyj55b11, $g0vvyjqpj);
    }
    
    public function getSelectList()
    {
        static $xxvxrcpkz8hs9ey4xv5rqbns;
        if (!isset($xxvxrcpkz8hs9ey4xv5rqbns)) {
            $xxvxrcpkz8hs9ey4xv5rqbns = array("\122\105\x46\x45\x52\105\x4e\103\105\x5f\111\x44" => array(""), "\122\x45\106\x45\122\105\x4e\103\x45" => array($this->getMessage("\116\117\x5f\123\x45\114\105\x43\124")));
            $h6ghh75yig2u19bhkbdhewpfwlh = $this->getTable()->getList(array("\x66\151\x6c\x74\145\162" => array("\101\x43\x54\x49\126\x45" => true, "\x41\125\x54\x4f" => false)));
            while ($qxzmwgjdc9v948h = $h6ghh75yig2u19bhkbdhewpfwlh->Fetch()) {
                $xxvxrcpkz8hs9ey4xv5rqbns["\x52\x45\x46\x45\122\x45\116\103\105\x5f\111\104"][] = $qxzmwgjdc9v948h["\111\104"];
                $xxvxrcpkz8hs9ey4xv5rqbns["\x52\105\106\x45\x52\x45\116\103\105"][] = "\133" . $qxzmwgjdc9v948h["\111\x44"] . "\135\40" . "\133" . $qxzmwgjdc9v948h["\107\122\117\x55\x50\137\x49\x44"] . "\x5d\40" . $qxzmwgjdc9v948h["\107\x52\117\x55\120\137\116\x41\x4d\x45"];
            }
        }
        return $xxvxrcpkz8hs9ey4xv5rqbns;
    }
    
    public function getItemsForJs()
    {
        static $xxvxrcpkz8hs9ey4xv5rqbns;
        if (!isset($xxvxrcpkz8hs9ey4xv5rqbns)) {
            $xxvxrcpkz8hs9ey4xv5rqbns = [];
            $h6ghh75yig2u19bhkbdhewpfwlh = $this->getTable()->getList(array("\x6f\162\x64\x65\x72" => array("\111\x44" => "\101\x53\x43"), "\146\x69\154\164\145\x72" => array("\x41\x43\124\x49\x56\105" => true)));
            while ($qxzmwgjdc9v948h = $h6ghh75yig2u19bhkbdhewpfwlh->Fetch()) {
                $xxvxrcpkz8hs9ey4xv5rqbns[] = array("\111\104" => $qxzmwgjdc9v948h["\111\x44"], "\x4e\x41\x4d\x45" => $qxzmwgjdc9v948h["\116\x41\x4d\105"], "\107\x52\x4f\125\120\137\x49\x44" => $qxzmwgjdc9v948h["\x47\x52\x4f\125\x50\137\x49\104"], "\x47\x52\117\125\120\137\x4e\x41\115\x45" => $qxzmwgjdc9v948h["\107\x52\x4f\125\x50\137\x4e\101\x4d\105"]);
            }
        }
        return \VKapi\Market\Manager::getInstance()->toJsDataFormat($xxvxrcpkz8hs9ey4xv5rqbns);
    }
    
    public function showExportBlockByHand()
    {
        \CUtil::InitJSCore("\152\161\x75\x65\162\171");
        $w65jx6seylzsfb34qiihnf = \Bitrix\Main\Security\Random::getString(10);
        $z0h8776fh91m = "\166\x6b\x61\x70\x69\x2d\x6d\141\x72\x6b\145\164\55\x68\141\156\x64\x2d\x65\x78\160\x6f\x72\164\x2d\55" . $w65jx6seylzsfb34qiihnf;
        
        echo "\74\x64\151\x76\x20\x63\154\x61\x73\163\75\x22\166\x6b\141\160\x69\55\155\141\162\x6b\145\x74\x2d\x68\x61\156\x64\55\x65\x78\160\x6f\162\x74\42\x20\151\144\x3d\42" . $z0h8776fh91m . "\42\x3e\74\x2f\x64\151\166\x3e";
        
        $kd38ztjz7fiapvno04qefu2 = array("\151\164\145\155\163" => $this->getItemsForJs());
        
        ?>
            <script type="text/javascript" class="vkapi-market-data">
                (function () {
                    var params =<?php 
        echo \Bitrix\Main\Web\Json::encode($kd38ztjz7fiapvno04qefu2);
        ?>;
                    window.VKapiMarketHandExportJs = window.VKapiMarketHandExportJs || {};
                    window.VKapiMarketHandExportJs['<?php 
        echo $z0h8776fh91m;
        ?>'] = new VKapiMarketHandExport('<?php 
        echo $z0h8776fh91m;
        ?>', params);
                })();
            </script>
            <?php 
    }
    
    public function parseExportDataFromPostData()
    {
        $y9hfezzzp5th0wr17x3 = new \VKapi\Market\Result();
        $y9hfezzzp5th0wr17x3->setData("\x46\x49\105\x4c\x44\x53", []);
        $rbif4hsh57h7ueb6gzzl8ik5w = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        $u8tb3lfhwoo9es1czvssdpx2i4gyvhgi = \VKapi\Market\Manager::getInstance();
        $y4fqnwjniwcdl669vwbn6vjcspbspfz = new \VKapi\Market\Connect();
        $hu0gjkx509608tk03vnf2rprucluiuuxu = new \VKapi\Market\Condition\Manager();
        $hu0gjkx509608tk03vnf2rprucluiuuxu->addCondition(new \VKapi\Market\Condition\Group());
        $hu0gjkx509608tk03vnf2rprucluiuuxu->addCondition(new \VKapi\Market\Condition\CatalogField());
        $hu0gjkx509608tk03vnf2rprucluiuuxu->addCondition(new \VKapi\Market\Condition\IblockElementFieldBase());
        $hu0gjkx509608tk03vnf2rprucluiuuxu->addCondition(new \VKapi\Market\Condition\IblockElementField());
        $hu0gjkx509608tk03vnf2rprucluiuuxu->addCondition(new \VKapi\Market\Condition\IblockElementProperty());
        $d45hv42kzp6p = new \VKapi\Market\Export\Photo();
        $ehtv2 = $u8tb3lfhwoo9es1czvssdpx2i4gyvhgi->getSiteList();
        $uyd5al48dwaop9xu = $y4fqnwjniwcdl669vwbn6vjcspbspfz->getAccountList();
        $omiy96keery38w9gmh = $u8tb3lfhwoo9es1czvssdpx2i4gyvhgi->getIblockItems();
        
        $qv0galclnsilx1s4eiwrju1dqxrflp8eh = $d45hv42kzp6p->getWatermarkPositionSelectList();
        
        $msk0po6wew8yijc5 = $d45hv42kzp6p->getWatermarkOpacitySelectList();
        
        $aas8b0zuwi6xeuxd2a28a2cw6mdwm3qke = $d45hv42kzp6p->getWatermarkKoefficientSelectList();
        $a2xirnd57 = array();
        
        $lcgqa73ja085c3tfz4e9cxvgq = array();
        if (intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\111\x44")) > 0 || intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\x43\117\120\131\x5f\111\104")) > 0) {
            $h6ghh75yig2u19bhkbdhewpfwlh = $this->getTable()->getList(array("\x66\151\x6c\x74\x65\x72" => array("\111\x44" => intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\x49\104")) ? intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\111\104")) : intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\103\x4f\120\131\x5f\x49\104")))));
            if ($ai23qv6m8mljj5 = $h6ghh75yig2u19bhkbdhewpfwlh->fetch()) {
                $lcgqa73ja085c3tfz4e9cxvgq = $ai23qv6m8mljj5;
            }
        }
        do {
            $a2xirnd57["\116\101\115\105"] = htmlspecialchars(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4e\x41\115\105")));
            if (strlen(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\116\x41\115\x45"))) <= 0) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\x45\122\122\117\x52\x2e\x46\111\114\105\104\x2e\x4e\x41\115\x45"));
                break;
            }
            if (strlen(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\123\x49\x54\105\x5f\x49\104"))) <= 0 || !isset($ehtv2[$rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x53\x49\x54\x45\x5f\111\104")])) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\x45\122\122\117\122\56\106\111\114\105\x44\56\x53\111\124\x45\x5f\111\104"));
                break;
            }
            if (strlen(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\101\103\103\x4f\x55\x4e\x54\137\x49\104"))) <= 0 || !isset($uyd5al48dwaop9xu[$rbif4hsh57h7ueb6gzzl8ik5w->getPost("\101\x43\103\x4f\125\116\x54\x5f\x49\x44")])) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\105\x52\122\117\x52\56\x46\111\x4c\105\x44\56\x41\x43\103\117\x55\116\124\137\x49\104"));
                break;
            }
            if (strlen(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x47\122\x4f\x55\x50\x5f\x49\x44"))) <= 0) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\105\x52\122\x4f\x52\x2e\106\x49\x4c\x45\x44\x2e\x47\122\x4f\125\120\x5f\x49\104"));
                break;
            }
            if (strlen(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\107\x52\x4f\x55\x50\x5f\116\101\115\x45"))) <= 0) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\105\122\x52\x4f\x52\56\x46\111\x4c\x45\x44\x2e\107\x52\117\x55\120\137\x4e\x41\115\105"));
                break;
            }
            $a2xirnd57["\x53\x49\x54\x45\137\111\104"] = trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\123\x49\124\x45\137\x49\x44"));
            $a2xirnd57["\x41\x43\x43\117\x55\x4e\124\137\x49\x44"] = trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\101\x43\x43\x4f\x55\x4e\124\x5f\x49\x44"));
            $a2xirnd57["\x47\x52\x4f\125\120\137\116\x41\x4d\x45"] = htmlspecialchars(trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\107\x52\x4f\125\120\x5f\116\x41\115\105")));
            $a2xirnd57["\x47\122\x4f\x55\x50\x5f\x49\x44"] = trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\107\122\x4f\125\120\x5f\x49\x44"));
            $a2xirnd57["\103\x41\124\101\114\x4f\x47\x5f\x49\x44"] = intval($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\103\x41\124\101\x4c\x4f\107\137\x49\102\x4c\117\x43\113\x5f\x49\x44"));
            if (!isset($omiy96keery38w9gmh[$a2xirnd57["\x43\101\124\x41\114\x4f\107\x5f\x49\104"]])) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\x45\122\x52\x4f\x52\56\106\x49\114\x45\x44\56\x43\101\x54\101\114\117\107\137\111\x42\x4c\117\103\113\137\111\x44"));
                break;
            }
            if (intval($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\103\x41\124\105\x47\117\122\131\x5f\111\104")) <= 0) {
                $y9hfezzzp5th0wr17x3->addError($this->getMessage("\105\122\x52\117\122\56\106\x49\114\x45\104\x2e\x43\101\124\x45\x47\x4f\x52\131\x5f\111\x44"));
                break;
            }
            $a2xirnd57["\x41\103\x54\x49\x56\105"] = $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\101\103\124\111\x56\105") == "\131";
            $a2xirnd57["\101\x55\x54\117"] = $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\101\125\124\117") == "\x59";
            $e0gbp2gs3kqkiqh = intval($lcgqa73ja085c3tfz4e9cxvgq["\x50\101\x52\101\115\123"]["\127\x41\124\105\x52\115\101\x52\x4b"]);
            
            if (!!$rbif4hsh57h7ueb6gzzl8ik5w->getPost("\127\x41\124\x45\x52\x4d\x41\x52\113\x5f\x64\145\154") && $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x57\x41\124\x45\122\x4d\x41\x52\x4b\137\144\145\x6c") == "\131" && intval($lcgqa73ja085c3tfz4e9cxvgq["\x50\101\x52\x41\x4d\x53"]["\127\101\124\x45\122\115\101\122\113"])) {
                \CFile::Delete(intval($lcgqa73ja085c3tfz4e9cxvgq["\120\x41\122\x41\115\x53"]["\127\101\x54\105\122\x4d\101\122\x4b"]));
                $e0gbp2gs3kqkiqh = 0;
            }
            
            if (intval($_FILES["\x57\101\124\105\x52\115\x41\122\x4b"]["\163\x69\x7a\x65"]) && intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\111\104"))) {
                $he1hriv4yn20nu5 = array("\x69\155\141\x67\145\57\160\x6e\x67" => "\x70\156\147", "\151\x6d\x61\147\x65\57\x6a\x70\x65\x67" => "\152\160\x65\147", "\151\155\x61\x67\x65\x2f\x6a\160\x67" => "\x6a\x70\147", "\151\155\141\x67\145\x2f\x67\151\146" => "\x67\x69\146");
                $m6c3828y11mopz6fa5xnzegvmnpp5cxf = $_FILES["\127\x41\x54\x45\x52\x4d\101\122\x4b"];
                $m6c3828y11mopz6fa5xnzegvmnpp5cxf["\x4d\117\104\x55\x4c\x45\137\111\x44"] = "\x76\x6b\x61\x70\151\x2e\x6d\141\162\153\x65\164";
                $m6c3828y11mopz6fa5xnzegvmnpp5cxf["\x6e\141\x6d\145"] = "\x77\141\x74\x65\162\155\141\162\x6b" . intval($rbif4hsh57h7ueb6gzzl8ik5w->get("\x49\104")) . "\56" . $he1hriv4yn20nu5[$m6c3828y11mopz6fa5xnzegvmnpp5cxf["\164\171\160\x65"]];
                $e0gbp2gs3kqkiqh = \CFile::SaveFile($m6c3828y11mopz6fa5xnzegvmnpp5cxf, "\x76\x6b\141\160\151\x2e\155\141\x72\153\145\x74\57\167\155\57");
            }
            
            $a2xirnd57["\101\114\x42\125\x4d\123"] = $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\101\x4c\102\x55\115\x53");
            
            $a2xirnd57["\x41\114\x42\x55\x4d\123"] = (array) $a2xirnd57["\x41\114\x42\125\115\123"];
            $a2xirnd57["\120\x41\122\101\115\123"] = array("\x43\x4f\116\x44\x49\124\x49\x4f\116\x53" => $hu0gjkx509608tk03vnf2rprucluiuuxu->parse(), "\x43\x41\124\x45\107\117\122\131\x5f\111\104" => intval($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\103\x41\x54\x45\x47\x4f\122\x59\x5f\111\x44")), "\103\125\x52\122\x45\116\103\x59\x5f\x49\x44" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\103\x55\122\x52\x45\x4e\103\x59\x5f\x49\104")), "\103\x41\x54\101\x4c\x4f\107\137\x49\x42\x4c\x4f\x43\113\137\111\x44" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x43\101\124\x41\114\x4f\x47\x5f\111\x42\114\x4f\103\x4b\x5f\111\x44")), "\117\106\x46\x45\x52\x5f\x49\x42\114\117\103\113\x5f\111\x44" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\x46\x46\x45\x52\x5f\x49\102\x4c\x4f\103\x4b\x5f\111\104")), "\x4c\111\116\x4b\137\x50\122\117\x50\105\x52\x54\131\x5f\111\104" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\114\x49\116\x4b\x5f\120\x52\x4f\120\x45\122\x54\x59\137\x49\x44")), "\x44\105\123\103\x52\x49\x50\124\111\117\x4e\137\104\x45\x4c\x45\124\x45" => array_intersect((array) $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x44\105\123\x43\x52\x49\x50\124\x49\x4f\x4e\137\x44\x45\x4c\x45\124\105"), array("\x4c\x49\x4e\113", "\111\x4d\x47", "\x54\x41\x42\x4c\105")), "\x49\x4d\x41\107\x45\x5f\x54\x4f\137\123\121\125\101\122\105" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\111\x4d\x41\x47\x45\137\x54\x4f\137\x53\x51\125\x41\122\105") ? 1 : 0, "\x44\x49\x53\x41\x42\x4c\105\104\x5f\117\114\104\x5f\101\114\x42\x55\115\x5f\x44\105\x4c\x45\x54\111\x4e\107" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\104\111\123\101\102\x4c\x45\104\137\x4f\x4c\104\x5f\x41\114\x42\x55\115\x5f\x44\x45\x4c\105\124\111\x4e\x47") ? 1 : 0, "\x44\111\x53\101\102\114\x45\104\137\x4f\114\x44\x5f\111\124\x45\x4d\x5f\104\105\x4c\x45\x54\x49\116\107" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\104\x49\123\x41\x42\x4c\105\104\137\x4f\x4c\104\x5f\x49\124\x45\115\137\104\105\114\105\124\111\x4e\107") ? 1 : 0, "\x45\130\x54\x45\116\104\105\x44\137\x47\x4f\x4f\104\123" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x45\130\124\x45\116\104\105\104\x5f\107\x4f\x4f\104\x53") ? 1 : 0, "\117\106\106\105\122\137\103\x4f\115\102\111\116\105" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\106\x46\x45\x52\x5f\103\117\115\102\111\x4e\105") ? 1 : 0, "\120\122\x4f\x44\x55\x43\124\x5f\x50\122\x49\x43\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\x52\x4f\104\x55\103\x54\137\120\122\x49\x43\x45")), "\120\x52\117\x44\125\103\x54\137\120\x52\x49\x43\x45\137\117\114\104" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\122\x4f\104\x55\103\124\137\120\x52\111\x43\x45\x5f\117\x4c\x44")), "\x50\122\x4f\x44\125\x43\x54\137\x4e\x41\115\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\117\x44\125\103\x54\x5f\116\x41\x4d\105")), "\x50\x52\117\104\x55\x43\124\x5f\x57\x45\x49\107\110\x54" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\x52\117\104\x55\x43\124\x5f\x57\x45\111\x47\x48\124")), "\120\x52\x4f\x44\125\103\124\137\x4c\x45\x4e\107\x54\110" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\122\x4f\104\125\x43\124\137\x4c\x45\x4e\x47\124\x48")), "\x50\122\x4f\x44\x55\103\124\137\x48\105\x49\x47\110\x54" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\x4f\104\x55\x43\124\x5f\x48\x45\x49\107\110\x54")), "\x50\122\x4f\x44\125\x43\x54\x5f\127\x49\x44\124\x48" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\117\x44\x55\x43\x54\137\x57\x49\x44\124\110")), "\x50\x52\x4f\104\x55\103\x54\137\121\x55\101\116\124\x49\124\131" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\x52\117\x44\125\x43\124\137\x51\125\x41\x4e\124\x49\124\131")), "\120\122\117\x44\125\x43\x54\x5f\120\x49\x43\124\125\122\x45" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\122\x4f\104\x55\x43\x54\x5f\x50\111\103\124\x55\x52\x45")), "\120\122\117\104\125\103\124\137\x50\x49\x43\x54\x55\122\x45\x5f\115\117\x52\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\x52\x4f\104\x55\x43\124\137\x50\x49\103\124\125\x52\105\x5f\115\x4f\x52\105")), "\120\x52\x4f\x44\x55\103\x54\x5f\x53\x4b\125" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\117\104\x55\103\124\x5f\123\x4b\x55")), "\x4f\106\x46\x45\x52\x5f\x50\122\111\103\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\106\x46\x45\122\137\x50\122\111\x43\x45")), "\x4f\106\106\105\x52\137\120\122\111\x43\105\137\x4f\114\x44" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\x46\x46\x45\122\x5f\x50\122\111\103\105\137\x4f\114\x44")), "\x4f\106\106\105\122\x5f\x4e\101\115\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\106\106\105\122\x5f\x4e\101\x4d\x45")), "\117\106\x46\x45\122\x5f\127\105\x49\x47\x48\x54" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\106\x46\105\x52\x5f\127\105\111\107\110\124")), "\x4f\x46\106\105\122\x5f\x4c\x45\x4e\107\124\110" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\x46\x46\x45\x52\137\x4c\x45\x4e\107\x54\x48")), "\117\x46\106\x45\122\x5f\110\x45\111\107\x48\x54" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\106\106\x45\122\x5f\110\105\x49\107\110\124")), "\117\x46\x46\x45\122\x5f\127\111\x44\124\110" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\x46\106\x45\x52\x5f\x57\x49\104\x54\110")), "\x4f\x46\106\105\x52\x5f\x51\125\101\x4e\124\111\124\131" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\106\106\x45\122\137\121\125\x41\116\124\111\x54\131")), "\x4f\x46\106\x45\122\137\x50\x49\x43\124\125\x52\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\106\x46\x45\x52\x5f\x50\x49\x43\124\125\x52\105")), "\117\x46\x46\105\x52\137\x50\111\x43\x54\125\122\105\137\115\x4f\x52\105" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\x46\106\105\x52\137\x50\x49\103\x54\125\122\x45\x5f\x4d\117\x52\105")), "\117\106\x46\x45\122\137\123\113\x55" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\117\x46\x46\105\x52\x5f\x53\113\125")), "\x50\122\x4f\x44\125\103\124\x5f\x44\x45\106\101\125\x4c\x54\x5f\x54\105\x58\124" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\x52\x4f\x44\x55\x43\124\x5f\104\105\106\x41\125\114\x54\x5f\124\105\130\124"), "\x50\x52\117\104\125\103\124\137\124\x45\115\120\114\101\x54\x45" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\122\117\104\125\103\124\x5f\x54\105\115\x50\114\101\124\105"), "\117\106\x46\105\x52\x5f\x44\105\x46\101\x55\114\x54\137\x54\105\130\124" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\x46\x46\x45\122\x5f\x44\x45\106\x41\125\x4c\x54\x5f\124\x45\x58\x54"), "\x4f\106\106\105\x52\x5f\x54\105\x4d\120\114\x41\124\x45" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\x46\106\x45\122\x5f\x54\105\x4d\120\x4c\x41\x54\x45"), "\117\106\x46\105\122\137\124\x45\x4d\x50\x4c\101\x54\x45\137\x42\105\x46\x4f\x52\105" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\106\x46\105\x52\x5f\124\x45\x4d\120\x4c\101\x54\105\137\x42\x45\106\117\122\105"), "\x4f\106\106\x45\122\137\x54\x45\115\120\x4c\101\124\105\137\101\106\124\105\122" => $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x4f\106\106\105\x52\137\x54\x45\115\x50\114\101\124\x45\137\101\106\124\x45\x52"), "\120\122\x45\126\x49\105\127\137\111\116\137\x56\113\x5f\x50\x52\117\104\x55\103\124\137\x49\104" => intval($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\x45\126\x49\105\x57\137\111\116\137\x56\113\x5f\x50\122\x4f\x44\x55\x43\x54\x5f\111\x44")), "\x50\x52\x45\126\111\105\x57\137\x49\x4e\137\x56\113\x5f\x50\122\x4f\x44\125\103\124\137\116\101\x4d\x45" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\x52\105\126\111\x45\127\137\x49\116\x5f\126\113\137\120\x52\x4f\104\125\x43\124\137\116\x41\115\x45")), "\x50\122\x45\x56\x49\x45\127\x5f\x49\x4e\137\126\113\137\117\x46\x46\105\x52\x5f\x49\104" => intval($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\x52\x45\x56\111\105\127\x5f\111\x4e\137\x56\x4b\137\x4f\106\106\x45\122\137\111\104")), "\120\x52\105\x56\111\105\127\137\111\116\x5f\x56\x4b\137\x4f\x46\106\x45\x52\x5f\116\x41\115\x45" => trim($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\105\x56\x49\105\127\x5f\x49\x4e\137\126\113\x5f\x4f\x46\x46\x45\x52\137\116\x41\x4d\x45")), "\127\101\124\x45\122\115\x41\x52\x4b" => $e0gbp2gs3kqkiqh, "\127\x41\x54\x45\x52\x4d\x41\122\x4b\137\x50\117\123\111\124\x49\117\x4e" => in_array($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\127\x41\124\105\x52\x4d\x41\122\x4b\137\120\x4f\123\111\124\x49\x4f\x4e"), $qv0galclnsilx1s4eiwrju1dqxrflp8eh["\x52\105\106\105\x52\x45\x4e\103\x45\137\x49\x44"]) ? $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x57\101\x54\105\122\x4d\101\x52\113\x5f\120\x4f\123\111\x54\x49\117\x4e") : "", "\x57\x41\124\105\122\x4d\101\122\x4b\x5f\117\120\x41\103\111\x54\x59" => in_array($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\127\101\x54\105\122\x4d\x41\x52\113\137\117\120\101\103\111\x54\131"), $msk0po6wew8yijc5["\122\x45\x46\x45\122\105\x4e\103\105\x5f\111\x44"]) ? $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x57\x41\x54\x45\x52\115\x41\122\113\137\117\120\101\103\x49\124\x59") : "", "\x57\101\124\105\122\115\x41\122\113\137\103\x4f\105\x46\x46\111\103\x49\105\116\124" => in_array($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\127\x41\x54\x45\x52\x4d\x41\122\113\x5f\x43\x4f\x45\106\x46\111\x43\x49\x45\x4e\124"), $aas8b0zuwi6xeuxd2a28a2cw6mdwm3qke["\x52\x45\x46\x45\x52\105\116\103\105\x5f\x49\104"]) ? $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x57\x41\x54\105\x52\115\x41\122\x4b\137\x43\117\105\106\106\111\x43\x49\105\x4e\124") : "");
            if (is_array($rbif4hsh57h7ueb6gzzl8ik5w->getPost("\120\122\117\120\105\122\124\x49\105\123"))) {
                $a2xirnd57["\x50\x41\x52\101\115\x53"]["\120\122\117\120\x45\122\x54\x49\105\123"] = $rbif4hsh57h7ueb6gzzl8ik5w->getPost("\x50\122\x4f\120\x45\122\x54\x49\105\x53");
            }
            
            $bmr3no0s8ahgfpzmd833su31u66 = $u8tb3lfhwoo9es1czvssdpx2i4gyvhgi->getIblockById($a2xirnd57["\x50\x41\x52\101\x4d\x53"]["\x43\101\124\101\114\x4f\x47\x5f\x49\x42\114\117\x43\113\x5f\x49\x44"]);
            if ($bmr3no0s8ahgfpzmd833su31u66) {
                if ($bmr3no0s8ahgfpzmd833su31u66["\111\x53\x5f\103\x41\124\x41\x4c\117\x47"]) {
                    $a2xirnd57["\120\x41\x52\x41\x4d\123"]["\117\x46\106\x45\122\137\111\x42\114\x4f\103\113\x5f\111\x44"] = $bmr3no0s8ahgfpzmd833su31u66["\x4f\x46\x46\105\x52\137\x49\x42\114\117\103\x4b\x5f\x49\104"];
                    $a2xirnd57["\120\x41\x52\101\115\x53"]["\x4c\x49\x4e\113\x5f\x50\x52\117\120\x45\x52\124\131\137\x49\x44"] = $bmr3no0s8ahgfpzmd833su31u66["\x4c\x49\116\x4b\137\x50\x52\x4f\x50\x45\122\124\131\137\111\104"];
                }
            } else {
                $a2xirnd57["\120\101\122\x41\115\123"]["\x43\101\124\101\x4c\117\x47\x5f\111\x42\114\117\x43\113\x5f\x49\x44"] = "";
                $a2xirnd57["\x50\101\x52\x41\115\123"]["\117\106\x46\105\x52\x5f\111\x42\114\117\103\x4b\x5f\111\x44"] = "";
                $a2xirnd57["\120\101\122\x41\x4d\x53"]["\114\x49\x4e\113\x5f\x50\122\x4f\x50\105\x52\124\131\x5f\x49\x44"] = "";
            }
            
            $b8lqcjrezldowi8lt33g0xotpflbzaamg = array("\120\x52\117\x44\x55\103\x54\137\x50\122\x49\x43\105", "\120\x52\x4f\104\x55\x43\x54\137\x4e\x41\x4d\x45", "\x50\x52\117\x44\125\x43\124\137\120\x49\x43\x54\x55\122\105");
            foreach ($b8lqcjrezldowi8lt33g0xotpflbzaamg as $tsmcikokxe) {
                if (empty($a2xirnd57["\120\101\122\x41\x4d\x53"][$tsmcikokxe])) {
                    $y9hfezzzp5th0wr17x3->addError($this->getMessage("\x45\122\122\117\122\56\x46\111\x4c\105\104\56" . $tsmcikokxe));
                    break 2;
                }
            }
            if ($a2xirnd57["\120\x41\122\x41\115\123"]["\114\111\x4e\x4b\137\120\122\x4f\x50\105\122\x54\131\x5f\111\x44"]) {
                $b8lqcjrezldowi8lt33g0xotpflbzaamg = array("\117\x46\106\x45\x52\x5f\x50\x52\x49\103\x45", "\117\106\106\105\x52\x5f\116\101\x4d\105", "\117\x46\106\x45\122\x5f\120\x49\x43\x54\x55\122\105");
                foreach ($b8lqcjrezldowi8lt33g0xotpflbzaamg as $tsmcikokxe) {
                    if (empty($a2xirnd57["\x50\101\x52\101\115\x53"][$tsmcikokxe])) {
                        $y9hfezzzp5th0wr17x3->addError($this->getMessage("\105\122\122\117\122\x2e\106\x49\114\105\104\x2e" . $tsmcikokxe));
                        break 2;
                    }
                }
            }
            $y9hfezzzp5th0wr17x3->setData("\106\111\x45\114\104\x53", $a2xirnd57);
        } while (false);
        return $y9hfezzzp5th0wr17x3;
    }
}
?>