<?php

namespace VKapi\Market\Condition\Control;


class IblockSectionFind extends \VKapi\Market\Condition\Control\Base
{
    
    public function __construct($asbbk09n38dkzicxcn196pxyy, $i4srnl9advmo = null, $mxt5g = null)
    {
        parent::__construct(array("\x6e\x61\155\145" => $asbbk09n38dkzicxcn196pxyy, "\154\141\x62\145\154" => $i4srnl9advmo, "\151\x62\154\157\x63\x6b\x49\144" => intval($mxt5g)));
    }
    
    public static function getComponent()
    {
        return "\166\153\141\160\151\x2d\x6d\141\x72\x6b\x65\x74\55\x63\x6f\156\144\x69\164\x69\x6f\156\x2d\x63\x6f\x6e\x74\162\x6f\154\x2d\x69\142\x6c\x6f\143\153\x73\x65\143\x74\151\157\156\x66\x69\x6e\x64";
    }
    
    public function checkValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $asbbk09n38dkzicxcn196pxyy = $this->getParameter("\156\141\155\145");
        
        if (!array_key_exists($asbbk09n38dkzicxcn196pxyy, $ip0ds)) {
            return false;
        }
        return true;
    }
    
    public function getValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        $gicuvkskpuwr53xgm3ud8u3eup[$this->getParameter("\156\141\155\x65")] = $ip0ds[$this->getParameter("\156\x61\x6d\145")];
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
}
?>