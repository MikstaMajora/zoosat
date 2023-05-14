<?php

namespace VKapi\Market\Condition\Control;

use Bitrix\Main\Localization\Loc;

abstract class Base implements \VKapi\Market\Condition\Control\IBase
{
    
    protected $arParams = array();
    
    public function __construct(array $de8zu036euhl7j1cwq3cz6ndsoyjkdww06l)
    {
        $cfrt3uw1 = array("\x6e\x61\x6d\145" => "", "\x76\141\154\x75\x65\163" => array(), "\166\x61\154\165\145" => "");
        $this->arParams = array_merge($cfrt3uw1, $de8zu036euhl7j1cwq3cz6ndsoyjkdww06l);
    }
    
    public static function getMessage($ujs9p1xe2si92a5oehp, $x55x5p3k = array())
    {
        return \Bitrix\Main\Localization\Loc::getMessage("\x56\113\x41\120\111\x2e\x4d\x41\x52\113\x45\x54\56\x43\x4f\x4e\104\111\124\x49\x4f\116\56\x43\x4f\116\124\122\x4f\x4c\56" . $ujs9p1xe2si92a5oehp, $x55x5p3k);
    }
    
    public function getParams()
    {
        return $this->arParams;
    }
    
    public function getParameter($ujs9p1xe2si92a5oehp)
    {
        if (array_key_exists($ujs9p1xe2si92a5oehp, $this->arParams)) {
            return $this->arParams[$ujs9p1xe2si92a5oehp];
        }
        return null;
    }
    
    public function setParameter($ujs9p1xe2si92a5oehp, $q7u4sw1qtd6ebn50nnlkli)
    {
        $this->arParams[$ujs9p1xe2si92a5oehp] = $q7u4sw1qtd6ebn50nnlkli;
        return $this;
    }
    public static final function getType()
    {
        return get_called_class();
    }
    
    public final function getJsData()
    {
        return array("\x63\157\x6d\160\157\156\x65\156\164" => static::getComponent(), "\164\171\160\x65" => static::getType(), "\160\x61\162\141\155\x73" => $this->getParams());
    }
}
?>