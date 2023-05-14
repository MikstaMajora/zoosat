<?php

namespace VKapi\Market\Exception;


class ApiResponseException extends \VKapi\Market\Exception\BaseException
{
    
    protected $oHttpClient = null;
    
    protected $apiCode = 0;
    protected $apiMessage = "";
    public function __construct($o4oqu, $kv8lehe0bis32tdebdrn2 = null)
    {
        $this->apiCode = $o4oqu["\145\x72\x72\157\x72\x5f\143\157\x64\x65"];
        $this->apiMessage = $o4oqu["\x65\162\x72\157\162\137\155\163\147"];
        $this->oHttpClient = $kv8lehe0bis32tdebdrn2;
        parent::__construct($this->apiCode . "\x20" . $this->apiMessage, "\101\120\111\x5f\x52\x45\123\x50\117\x4e\x53\x45\137\105\x58\x43\105\120\124\111\x4f\116", $o4oqu);
    }
    
    public function is($oi5ubvqm1db1tulgvah6rr)
    {
        return $this->apiCode == $oi5ubvqm1db1tulgvah6rr;
    }
    
    public function getApiCode()
    {
        return $this->apiCode;
    }
    public function getApiMessage()
    {
        return $this->apiMessage;
    }
}
?>