<?php

namespace VKapi\Market\Condition\Control;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Text extends \VKapi\Market\Condition\Control\Base
{
    
    public function __construct($jwsdgd856)
    {
        parent::__construct(array("\164\x65\170\164" => $jwsdgd856));
    }
    
    public static function getComponent()
    {
        return "\x76\x6b\x61\160\x69\55\155\141\x72\153\145\164\55\x63\157\156\x64\x69\x74\151\157\156\x2d\x63\x6f\x6e\164\x72\x6f\154\x2d\164\x65\170\164";
    }
    
    public function checkValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        return true;
    }
    
    public function getValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        return array();
    }
}
?>