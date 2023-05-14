<?php

namespace VKapi\Market\Ajax;

use VKapi\Market\Result;
use VKapi\Market\Exception\BaseException;

class JsonResponse
{
    protected $arError = null;
    protected $arResponse = array();
    
    public function setResponse($iy4fwxq5etq1b83jf77)
    {
        $this->arResponse = $iy4fwxq5etq1b83jf77;
    }
    
    public function setResponseField($emkee4qd22txk, $i375gdh9c1q5z7hk26pdc34er)
    {
        $this->arResponse[$emkee4qd22txk] = $i375gdh9c1q5z7hk26pdc34er;
    }
    
    public function setError($jbfuk26litwmr2iyvh, $emkee4qd22txk, $iy4fwxq5etq1b83jf77 = [])
    {
        $this->arError = ["\155\163\x67" => $jbfuk26litwmr2iyvh, "\x63\157\144\x65" => $emkee4qd22txk, "\x6d\x6f\x72\x65" => $iy4fwxq5etq1b83jf77];
    }
    
    public function setErrorFromResult(\VKapi\Market\Result $q43zd2xlmpaub595hni95lnhy4dwr6v)
    {
        $this->setError($q43zd2xlmpaub595hni95lnhy4dwr6v->getFirstError()->getMessage(), $q43zd2xlmpaub595hni95lnhy4dwr6v->getFirstError()->getCode(), $q43zd2xlmpaub595hni95lnhy4dwr6v->getFirstError()->getMore());
    }
    
    public function setException(\Throwable $x05dsektbergekgzp3qtrmlhkyntgq)
    {
        $ihzpw2mzqk5ax4m8lpyr42 = "";
        if (defined("\x56\x4b\101\x50\111\137\x4d\101\122\x4b\105\x54\x5f\x44\105\x42\x55\x47") && constant("\126\113\101\120\111\137\115\x41\122\113\x45\x54\x5f\x44\x45\x42\125\107") == true) {
            $ihzpw2mzqk5ax4m8lpyr42 .= "\40\174\x20" . $x05dsektbergekgzp3qtrmlhkyntgq->getFile() . "\72" . $x05dsektbergekgzp3qtrmlhkyntgq->getLine();
            $ihzpw2mzqk5ax4m8lpyr42 .= "\40\174\x20" . $x05dsektbergekgzp3qtrmlhkyntgq->getTraceAsString();
        }
        if ($x05dsektbergekgzp3qtrmlhkyntgq instanceof \VKapi\Market\Exception\BaseException) {
            $this->setError($x05dsektbergekgzp3qtrmlhkyntgq->getMessage() . $ihzpw2mzqk5ax4m8lpyr42, $x05dsektbergekgzp3qtrmlhkyntgq->getCustomCode(), $x05dsektbergekgzp3qtrmlhkyntgq->getCustomData());
        } else {
            $this->setError($x05dsektbergekgzp3qtrmlhkyntgq->getMessage() . $ihzpw2mzqk5ax4m8lpyr42, "\125\116\x4b\116\x4f\x57\116\137\x45\x58\x43\105\x50\x54\x49\x4f\116");
        }
    }
    
    public function output()
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        header("\103\157\156\164\x65\156\164\55\x54\x79\x70\145\x3a\x20\x61\160\x70\x6c\151\143\x61\164\x69\157\156\57\x6a\x73\157\x6e");
        if (!is_null($this->arError)) {
            echo \Bitrix\Main\Web\Json::encode(["\x65\x72\x72\x6f\162" => $this->arError]);
        } else {
            echo \Bitrix\Main\Web\Json::encode(["\162\145\163\x70\157\156\163\145" => $this->arResponse]);
        }
        self::finish();
    }
    
    public static function finish()
    {
        if (\Bitrix\Main\Loader::includeModule("\143\x6f\x6d\160\162\145\163\163\x69\x6f\x6e")) {
            \CCompress::DisableCompression();
        }
        \Bitrix\Main\Context::getCurrent()->getResponse()->writeHeaders();
        \Bitrix\Main\Application::getConnection()->disconnect();
        die;
    }
}
?>