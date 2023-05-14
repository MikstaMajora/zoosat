<?php

namespace VKapi\Market\Exception;

class ResponseErrorException extends \VKapi\Market\Exception\BaseException
{
    
    public function __construct($ymx36moxlmdddh3chm91vf25hgzpzp02af)
    {
        $vnnrpe60a1cf2e1wjogzmrx = $ymx36moxlmdddh3chm91vf25hgzpzp02af->getFirstError();
        parent::__construct($vnnrpe60a1cf2e1wjogzmrx->getMessage(), $vnnrpe60a1cf2e1wjogzmrx->getCode(), $vnnrpe60a1cf2e1wjogzmrx->getMore());
    }
}
?>