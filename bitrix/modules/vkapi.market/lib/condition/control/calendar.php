<?php

namespace VKapi\Market\Condition\Control;


class Calendar extends \VKapi\Market\Condition\Control\Input
{
    
    public function __construct($asbbk09n38dkzicxcn196pxyy, $i4srnl9advmo = null)
    {
        parent::__construct($asbbk09n38dkzicxcn196pxyy, $i4srnl9advmo, array("\163\150\x6f\x77\124\151\x6d\x65" => false));
    }
    
    public function setShowTime($mo7lqpx0nmalzh0tsdkkja2 = true)
    {
        $this->setParameter("\163\150\157\167\124\151\155\145", $mo7lqpx0nmalzh0tsdkkja2);
    }
    
    public static function getComponent()
    {
        return "\166\153\x61\x70\151\x2d\155\x61\x72\153\x65\164\x2d\x63\x6f\156\144\x69\x74\151\157\x6e\55\x63\157\156\164\162\157\154\x2d\x63\x61\x6c\x65\x6e\x64\x61\x72";
    }
    
    public function checkValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $asbbk09n38dkzicxcn196pxyy = $this->getParameter("\x6e\x61\155\145");
        
        if (!array_key_exists($asbbk09n38dkzicxcn196pxyy, $ip0ds)) {
            return false;
        }
        return true;
    }
}
?>