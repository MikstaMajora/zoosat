<?php

namespace VKapi\Market\Condition\Control;

use Bitrix\Main\Loader;

class SelectHighloadBlock extends \VKapi\Market\Condition\Control\Select
{
    
    public function __construct($lyj55b11, $fpm2y2pll0qgyau8hcvng0e2h53)
    {
        parent::__construct($lyj55b11);
        $this->setParameter("\110\x49\107\x48\114\117\101\x44\102\x4c\x4f\103\x4b\x5f\124\101\102\x4c\105", $fpm2y2pll0qgyau8hcvng0e2h53);
    }
    
    public function checkValue($ag0badw2ae, $wgsrczy074t5fp53wm2jmryt3en8qqgb3x1)
    {
        $lyj55b11 = $this->getParameter("\x6e\141\x6d\145");
        
        if (!array_key_exists($lyj55b11, $ag0badw2ae)) {
            return false;
        }
        try {
            $fpm2y2pll0qgyau8hcvng0e2h53 = $wgsrczy074t5fp53wm2jmryt3en8qqgb3x1->getParameter("\x48\111\107\110\114\117\x41\x44\x42\x4c\x4f\x43\x4b\x5f\x54\x41\x42\x4c\x45");
            
            $g9xzf96fbfir05sfmneglhi9o61nuzg2 = \VKapi\Market\Manager::getInstance()->getHighloadBlockClassByTableName($fpm2y2pll0qgyau8hcvng0e2h53);
            if (!is_null($g9xzf96fbfir05sfmneglhi9o61nuzg2)) {
                $sc42mkbe7t5vs2233l = $g9xzf96fbfir05sfmneglhi9o61nuzg2::getEntity();
                $yzuoxstfuj2vpytj0np9049immuets = ["\x49\x44" => (string) $ag0badw2ae[$lyj55b11]];
                if ($sc42mkbe7t5vs2233l->hasField("\x55\106\x5f\130\115\x4c\x5f\111\104")) {
                    $yzuoxstfuj2vpytj0np9049immuets = ["\125\106\137\130\115\114\137\x49\104" => (string) $ag0badw2ae[$lyj55b11]];
                }
                $jag5b7amwhzfyw6pqe53ktxhhhw2k0on3v = $g9xzf96fbfir05sfmneglhi9o61nuzg2::getList(["\x6c\x69\155\x69\164" => 1, "\146\151\x6c\164\x65\x72" => $yzuoxstfuj2vpytj0np9049immuets]);
                if ($jag5b7amwhzfyw6pqe53ktxhhhw2k0on3v->fetch()) {
                    return true;
                }
            }
        } catch (\Exception $kk3oiibxk18nq1bxa4au9rv7dt34) {
            
        }
        return false;
    }
}
?>