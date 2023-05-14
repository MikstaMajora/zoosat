<?php

namespace VKapi\Market;

use Bitrix\Main\Localization\Loc;

class Message
{
    protected $moduleId = "";
    protected $block = null;
    
    public function __construct($rhkyh4aimop8cg2burli80xbtk72, $hey41cy5yxj6ujpht = "")
    {
        $this->moduleId = strtoupper($rhkyh4aimop8cg2burli80xbtk72);
        $this->block = $hey41cy5yxj6ujpht;
    }
    
    public function get($uz7l6557u7jryg50xpql6nc27y65, $x55x5p3k = array())
    {
        return \Bitrix\Main\Localization\Loc::getMessage($this->moduleId . "\x2e" . $this->block . "\x2e" . $uz7l6557u7jryg50xpql6nc27y65, $x55x5p3k);
    }
}
?>