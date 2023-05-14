<?php

namespace VKapi\Market\Condition\Control;


class Input extends \VKapi\Market\Condition\Control\Base
{
    
    public function __construct($asbbk09n38dkzicxcn196pxyy, $i4srnl9advmo = null, $ie867f10dshfcr1babs = array())
    {
        parent::__construct(array_merge($ie867f10dshfcr1babs, array("\156\141\x6d\x65" => $asbbk09n38dkzicxcn196pxyy, "\154\141\142\145\x6c" => $i4srnl9advmo)));
    }
    
    public static function getComponent()
    {
        return "\x76\x6b\x61\160\x69\55\155\x61\x72\x6b\145\x74\55\x63\x6f\x6e\x64\151\164\151\x6f\x6e\55\x63\157\x6e\164\162\x6f\154\x2d\151\156\x70\x75\x74";
    }
    
    public function checkValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $asbbk09n38dkzicxcn196pxyy = $this->getParameter("\x6e\141\155\145");
        
        if (!array_key_exists($asbbk09n38dkzicxcn196pxyy, $ip0ds)) {
            return false;
        }
        return true;
    }
    
    public function getValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        $gicuvkskpuwr53xgm3ud8u3eup[$this->getParameter("\156\x61\x6d\145")] = $ip0ds[$this->getParameter("\156\x61\x6d\145")];
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
}
?>