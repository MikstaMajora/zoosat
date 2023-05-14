<?php

namespace VKapi\Market\Condition\Control;

use Bitrix\Main\Loader;

class SelectPropertyEnum extends \VKapi\Market\Condition\Control\Select
{
    
    public function __construct($ujs9p1xe2si92a5oehp, $yi73vdiue1ouqucy45a60kv99izw5bw6hji)
    {
        parent::__construct($ujs9p1xe2si92a5oehp);
        $this->setParameter("\x50\x52\117\120\x45\x52\x54\131\x5f\x49\104", $yi73vdiue1ouqucy45a60kv99izw5bw6hji);
    }
    
    public function checkValue($pb79ulogqe2sdplp5cwbyusyi8n, $nopse5b6h5nwtblgw54wk5x13)
    {
        $ujs9p1xe2si92a5oehp = $this->getParameter("\156\141\x6d\145");
        $n4m6f93m8e9fm3 = $this->getParameter("\x76\x61\154\x75\x65\163");
        
        if (!array_key_exists($ujs9p1xe2si92a5oehp, $pb79ulogqe2sdplp5cwbyusyi8n) || !\VKapi\Market\Condition\Manager::isInstalledIblockModule()) {
            return false;
        }
        
        $q7u4sw1qtd6ebn50nnlkli = $pb79ulogqe2sdplp5cwbyusyi8n[$ujs9p1xe2si92a5oehp];
        $ylzpg07gafcb1dlefgj5y2emw00f6218sfi = \CIBlockPropertyEnum::GetList(array(), array("\120\x52\x4f\120\x45\x52\124\x59\137\111\104" => intval($nopse5b6h5nwtblgw54wk5x13->getParameter("\x50\x52\x4f\120\105\x52\124\x59\137\111\x44")), "\x49\x44" => intval($q7u4sw1qtd6ebn50nnlkli)));
        if ($ylzpg07gafcb1dlefgj5y2emw00f6218sfi->fetch()) {
            return true;
        }
        return false;
    }
}
?>