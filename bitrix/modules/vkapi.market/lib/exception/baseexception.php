<?php

namespace VKapi\Market\Exception;

class BaseException extends \Exception
{
    protected $customCode;
    protected $customData;
    public function __construct($xo487dewzf9zh9u3jjcuki18ku3, $imr62ra0dbhwqzpwhxy1o4p5ehu7ak5q13 = "\x44\x45\106\x55\101\x4c\124", $jncc9rfe3rkhv = array(), $j7hjgt3so4q6saqx0epyhxmzvosd = null)
    {
        parent::__construct($xo487dewzf9zh9u3jjcuki18ku3, 0, $j7hjgt3so4q6saqx0epyhxmzvosd);
        $this->customCode = $imr62ra0dbhwqzpwhxy1o4p5ehu7ak5q13;
        $this->customData = $jncc9rfe3rkhv;
    }
    public function getCustomCode()
    {
        return $this->customCode;
    }
    public function getCustomData()
    {
        return $this->customData;
    }
    
    public function setCustomDataField($asbbk09n38dkzicxcn196pxyy, $neueels6)
    {
        $this->customData[$asbbk09n38dkzicxcn196pxyy] = $neueels6;
    }
}
?>