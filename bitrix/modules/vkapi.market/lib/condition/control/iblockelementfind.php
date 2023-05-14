<?php

namespace VKapi\Market\Condition\Control;


class IblockElementFind extends \VKapi\Market\Condition\Control\Base
{
    
    public function __construct($asbbk09n38dkzicxcn196pxyy, $i4srnl9advmo = null)
    {
        parent::__construct(array(
            "\156\141\155\145" => $asbbk09n38dkzicxcn196pxyy,
            "\x6c\141\142\145\x6c" => $i4srnl9advmo,
            "\x69\142\154\x6f\143\x6b\x49\144" => 0,
            //инфоблок для ограничения поиска
            "\163\x65\141\162\x63\150\130\155\x6c\x49\x64" => false,
        ));
    }
    
    public function setIblockId($mxt5g)
    {
        $this->setParameter("\151\x62\154\157\x63\153\x49\x64", intval($mxt5g));
    }
    
    public function setSearchXmlId($mo7lqpx0nmalzh0tsdkkja2 = true)
    {
        $this->setParameter("\x73\145\141\162\x63\150\x58\x6d\x6c\x49\144", !!$mo7lqpx0nmalzh0tsdkkja2);
    }
    
    public static function getComponent()
    {
        return "\166\153\x61\x70\151\55\155\141\x72\153\145\x74\55\143\157\156\144\151\x74\151\x6f\x6e\x2d\x63\x6f\x6e\164\162\x6f\x6c\55\x69\142\154\157\143\x6b\x65\x6c\145\155\145\x6e\x74\146\151\156\144";
    }
    
    public function checkValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $asbbk09n38dkzicxcn196pxyy = $this->getParameter("\156\141\155\x65");
        
        if (!array_key_exists($asbbk09n38dkzicxcn196pxyy, $ip0ds)) {
            return false;
        }
        return true;
    }
    
    public function getValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        $gicuvkskpuwr53xgm3ud8u3eup[$this->getParameter("\x6e\x61\x6d\145")] = $ip0ds[$this->getParameter("\x6e\141\155\145")];
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
}
?>