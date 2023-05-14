<?php

namespace VKapi\Market\Exception;

class ORMException extends \VKapi\Market\Exception\BaseException
{
    
    public function __construct($rza2q5z1lwckcufa6c4av)
    {
        
        $c9twhmmwp7r09w90fs3bo = $rza2q5z1lwckcufa6c4av->getErrorCollection()->rewind();
        parent::__construct($c9twhmmwp7r09w90fs3bo->getMessage(), "\105\x52\122\x4f\x52\x5f\117\122\115", $c9twhmmwp7r09w90fs3bo->getCustomData());
    }
}
?>