<?php

namespace VKapi\Market\Exception;


class GoodLimitException extends \VKapi\Market\Exception\BaseException
{
    public function __construct()
    {
        parent::__construct(\VKapi\Market\Manager::getInstance()->getMessage("\107\117\x4f\104\x5f\114\x49\115\x49\124\x5f\105\130\103\105\120\x54\111\x4f\x4e"), "\107\117\x4f\x44\137\x4c\x49\x4d\x49\x54\137\x45\130\x43\105\x50\x54\x49\117\x4e");
    }
}
?>