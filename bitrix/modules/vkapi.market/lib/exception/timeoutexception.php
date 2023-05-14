<?php

namespace VKapi\Market\Exception;


class TimeoutException extends \VKapi\Market\Exception\BaseException
{
    public function __construct()
    {
        parent::__construct(\VKapi\Market\Manager::getInstance()->getMessage("\x54\111\x4d\x45\x4f\125\x54\x5f\x45\x58\103\x45\120\124\111\117\116"), "\x54\x49\x4d\105\117\x55\124\x5f\105\x58\103\x45\x50\x54\x49\117\116");
    }
}
?>