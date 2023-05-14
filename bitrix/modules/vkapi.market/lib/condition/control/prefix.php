<?php

namespace VKapi\Market\Condition\Control;

use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Prefix extends \VKapi\Market\Condition\Control\Text
{
    
    public static function getComponent()
    {
        return "\166\x6b\x61\x70\x69\55\155\x61\162\153\145\x74\55\x63\x6f\156\144\x69\164\x69\157\x6e\x2d\x63\157\x6e\164\x72\x6f\x6c\55\160\162\x65\146\x69\170";
    }
}
?>