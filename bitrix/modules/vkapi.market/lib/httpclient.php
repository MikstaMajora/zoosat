<?php

namespace VKapi\Market;


class HttpClient
{
    const HTTP_1_0 = "\61\x2e\60";
    const HTTP_1_1 = "\61\x2e\x31";
    const HTTP_POST = "\120\117\x53\x54";
    const HTTP_GET = "\x47\x45\x54";
    protected $result = null;
    protected $status = null;
    protected $proxyHost = null;
    protected $proxyPort = null;
    protected $proxyUser = null;
    protected $proxyPass = null;
    protected $timeout = 30;
    protected $maxRedirect = 5;
    protected $httpProtocol = 1.0;
    protected $requestFullUri = false;
    protected $arRequestHeaders = array();
    protected $arResponseHeaders = array();
    protected $arResponseCookies = array();
    protected $stream = null;
    public function __construct()
    {
    }
    public function getVar($nz6v0g46a382)
    {
        return $this->{$nz6v0g46a382};
    }
    
    public function clearResponse()
    {
        $this->result = null;
        $this->status = null;
        $this->stream = null;
        $this->arRequestHeaders = array();
        $this->arResponseCookies = array();
    }
    public function setProxy($sqhxkm5xu4hnnczvxo1iq9, $puhezu2lnhovyn2k2ifh5v0mn8hi, $vty0xqo7fo4k148886lx0p57n38zu6ocrx6 = null, $elmmduf = null)
    {
        $this->proxyHost = $sqhxkm5xu4hnnczvxo1iq9;
        $this->proxyPort = $puhezu2lnhovyn2k2ifh5v0mn8hi;
        $this->proxyUser = $vty0xqo7fo4k148886lx0p57n38zu6ocrx6;
        $this->proxyPass = $elmmduf;
    }
    
    public function setTimeout($dx68bffd)
    {
        $this->timeout = $dx68bffd;
    }
    
    public function setMaxRedirect($wjtn9y47tgq2agdmxcxt53x8itscur1nq)
    {
        $this->maxRedirect = $wjtn9y47tgq2agdmxcxt53x8itscur1nq;
    }
    
    public function setVersion($b3qp9166q9mrv06j7aqeu36i)
    {
        if ($b3qp9166q9mrv06j7aqeu36i == self::HTTP_1_1) {
            $this->httpProtocol = self::HTTP_1_1;
        } else {
            $this->httpProtocol = self::HTTP_1_0;
        }
    }
    
    public function setRequestFullUrl($hmfkei50x8jdin794znfr0nk3ptpxe)
    {
        $this->requestFullUri = $hmfkei50x8jdin794znfr0nk3ptpxe;
    }
    
    public function addHeader($nz6v0g46a382, $th8zj8lazwue22nad2yla2j705fmn4bllia)
    {
        $this->arRequestHeaders[$nz6v0g46a382] = $th8zj8lazwue22nad2yla2j705fmn4bllia;
    }
    
    public function getStreamContextOptions()
    {
        $yntluljklfu672cc7c9fvjgv5gctllq = array("\150\164\164\160" => array(
            "\165\x73\x65\162\x5f\141\x67\x65\156\164" => "\x4d\157\x7a\x69\x6c\154\141\57\x35\x2e\60\40\x28\x58\x31\61\x3b\x20\x4c\151\156\x75\x78\40\170\x38\x36\137\66\64\51\x20\x41\x70\x70\154\145\x57\x65\x62\x4b\x69\x74\x2f\65\x33\67\56\x33\x36\40\50\x4b\x48\124\x4d\x4c\54\40\154\151\x6b\x65\x20\x47\145\143\153\157\x29\x20\x43\x68\162\157\155\x65\57\x37\x34\56\x30\56\63\67\x32\x39\56\x31\x33\61\x20\123\141\146\141\x72\x69\x2f\x35\x33\67\56\63\x36",
            "\162\145\x71\x75\x65\x73\164\137\146\x75\x6c\154\x75\x72\x69" => $this->requestFullUri,
            "\x74\x69\x6d\x65\x6f\x75\164" => $this->timeout,
            "\x66\157\x6c\154\157\x77\137\x6c\x6f\143\x61\x74\x69\x6f\x6e" => $this->maxRedirect > 0 ? 1 : 0,
            "\x6d\141\170\x5f\162\145\x64\151\162\145\143\x74\x73" => $this->maxRedirect,
            //Извлечь содержимое даже при неуспешных статусах завершения.
            "\151\x67\x6e\x6f\x72\145\137\145\x72\x72\157\162\x73" => "\61",
            "\x70\x72\157\164\157\x63\x6f\154\x5f\x76\x65\162\x73\x69\x6f\156" => $this->httpProtocol,
        ), "\x73\x73\154" => ["\166\x65\x72\151\146\171\137\160\145\145\x72\137\x6e\141\x6d\x65" => false, "\x76\x65\x72\151\x66\171\x5f\160\x65\x65\162" => false, "\123\x4e\111\137\145\156\141\142\154\x65\x64" => false, "\x64\x69\x73\x61\x62\154\145\x5f\143\157\155\160\162\x65\x73\x73\x69\x6f\156" => true]);
        if (!is_null($this->proxyHost)) {
            $yntluljklfu672cc7c9fvjgv5gctllq["\x68\x74\164\x70"]["\x70\162\x6f\170\171"] = "\x74\x63\x70\x3a\57\x2f" . $this->proxyHost . "\x3a" . $this->proxyPort;
        }
        if (!is_null($this->proxyUser)) {
            $yntluljklfu672cc7c9fvjgv5gctllq["\x68\x74\x74\160"]["\x41\x75\164\x68\157\x72\x69\172\141\164\x69\157\x6e"] = "\102\x61\163\x69\x63\40" . base64_encode($this->proxyUser . "\72" . $this->proxyPass);
        }
        return $yntluljklfu672cc7c9fvjgv5gctllq;
    }
    
    public function get($zaqdisobpjeottdsoqenyo8kr, $k31m3af1wk9qcfd4lye2 = array())
    {
        $this->clearResponse();
        $xu3zzzryo4s493v5axax70a1ikowmr5jh = array("\x52\145\x71\x75\x65\x73\164\125\122\114" => "", "\122\145\x71\x75\x65\x73\164\115\x65\164\x68\157\144" => "\107\x45\124", "\x53\x74\141\x74\x75\163\x43\x6f\x64\145" => "", "\x52\x65\163\160\x6f\x6e\163\x65\110\x65\x61\x64\145\x72\163" => "", "\x52\145\163\x70\157\156\163\x65\102\157\x64\171" => "");
        $i1b2ke6hpr1yqhzgdbw1vkqjhaoxl5d48 = $zaqdisobpjeottdsoqenyo8kr . "\77" . http_build_query($k31m3af1wk9qcfd4lye2);
        $ofsf8c9h0iyjgynr2p7iprz1 = new \Bitrix\Main\Web\Uri($i1b2ke6hpr1yqhzgdbw1vkqjhaoxl5d48);
        $yntluljklfu672cc7c9fvjgv5gctllq = $this->getStreamContextOptions();
        $yntluljklfu672cc7c9fvjgv5gctllq["\150\x74\164\x70"]["\x6d\x65\x74\x68\157\x64"] = self::HTTP_GET;
        $yntluljklfu672cc7c9fvjgv5gctllq["\150\x74\164\160"]["\x68\145\x61\x64\145\162"] = $this->getRequestHeaders();
        $autx4 = stream_context_create($yntluljklfu672cc7c9fvjgv5gctllq);
        $this->stream = fopen($ofsf8c9h0iyjgynr2p7iprz1->getUri(), "\162", false, $autx4);
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\x52\145\x71\165\145\x73\x74\125\x52\114"] = $i1b2ke6hpr1yqhzgdbw1vkqjhaoxl5d48;
        
        $this->parseResponseHeaders();
        
        $this->result = stream_get_contents($this->stream);
        fclose($this->stream);
        $this->stream = null;
        return $this->result;
    }
    
    public function post($zaqdisobpjeottdsoqenyo8kr, $k31m3af1wk9qcfd4lye2 = array(), $hwbl2agnas9 = array())
    {
        $this->clearResponse();
        $xu3zzzryo4s493v5axax70a1ikowmr5jh = array("\122\x65\x71\x75\145\163\x74\x55\122\x4c" => "", "\x52\x65\x71\x75\145\x73\164\115\145\x74\150\x6f\144" => "\120\x4f\123\124", "\x52\145\161\165\x65\x73\x74\110\x65\141\144\145\162\x73" => "", "\x52\145\x71\x75\145\163\x74\x42\x6f\144\171" => "", "\x53\164\x61\164\165\x73\103\157\144\145" => "", "\122\145\x73\160\157\x6e\x73\145\x48\x65\141\x64\x65\x72\163" => "", "\x52\145\x73\x70\x6f\156\x73\145\x42\x6f\144\171" => "");
        $ofsf8c9h0iyjgynr2p7iprz1 = new \Bitrix\Main\Web\Uri($zaqdisobpjeottdsoqenyo8kr);
        $tol3vnhtdkb1ypta16e0ifksdlfpd = md5(uniqid(time()) . time());
        $yikthbri7ulspvx4w4lz9b5r = "";
        $osq2gdcj4mhr464ads = "";
        
        if (!empty($hwbl2agnas9)) {
            $this->addHeader("\x43\x6f\x6e\x74\145\156\164\55\124\171\160\145", "\x6d\165\154\164\151\x70\141\162\164\x2f\x66\x6f\x72\155\55\x64\x61\164\141\x3b\x20\142\157\x75\x6e\144\x61\x72\171\x3d" . $tol3vnhtdkb1ypta16e0ifksdlfpd);
            $wjtn9y47tgq2agdmxcxt53x8itscur1nq = 0;
            foreach ($k31m3af1wk9qcfd4lye2 as $aku0qeyan3u => $qdxxukag6ve7d4e0) {
                $qdxxukag6ve7d4e0 = urlencode($qdxxukag6ve7d4e0);
                $yikthbri7ulspvx4w4lz9b5r .= "\x2d\55" . $tol3vnhtdkb1ypta16e0ifksdlfpd . "\xd\12";
                $yikthbri7ulspvx4w4lz9b5r .= "\103\x6f\x6e\164\x65\156\x74\x2d\x44\151\x73\x70\x6f\x73\x69\164\x69\157\x6e\x3a\x20\146\157\x72\x6d\55\x64\x61\x74\x61\x3b\x20\156\141\155\145\75\42" . $aku0qeyan3u . "\42" . "\15\xa\xd\xa" . $qdxxukag6ve7d4e0 . "\xd\12";
                $osq2gdcj4mhr464ads .= "\x2d\x2d" . $tol3vnhtdkb1ypta16e0ifksdlfpd . "\xd\12";
                $osq2gdcj4mhr464ads .= "\103\157\x6e\x74\145\156\164\x2d\104\x69\x73\160\x6f\163\151\x74\x69\157\156\72\x20\146\x6f\x72\x6d\55\x64\x61\x74\x61\73\x20\x6e\x61\155\x65\75\x22" . $aku0qeyan3u . "\42" . "\15\12\xd\xa" . $qdxxukag6ve7d4e0 . "\xd\12";
                $wjtn9y47tgq2agdmxcxt53x8itscur1nq++;
            }
            foreach ($hwbl2agnas9 as $aku0qeyan3u => $vl3xh) {
                $gim13zbbn4vampkqcj1 = new \Bitrix\Main\IO\File($vl3xh);
                if ($gim13zbbn4vampkqcj1->isExists()) {
                    $yikthbri7ulspvx4w4lz9b5r .= "\x2d\x2d" . $tol3vnhtdkb1ypta16e0ifksdlfpd . "\15\12";
                    $yikthbri7ulspvx4w4lz9b5r .= "\103\157\156\x74\x65\156\x74\55\104\x69\x73\x70\x6f\163\151\x74\151\157\x6e\x3a\40\146\157\162\x6d\55\144\141\164\141\73\40\x6e\x61\x6d\x65\75\x22" . $aku0qeyan3u . "\42\73\x20\x66\x69\154\145\156\x61\x6d\145\x3d\x22" . $gim13zbbn4vampkqcj1->getName() . "\x22" . "\xd\12";
                    $yikthbri7ulspvx4w4lz9b5r .= "\103\157\x6e\x74\145\x6e\164\55\124\x79\x70\145\x3a\40" . $this->getFileMimeType($gim13zbbn4vampkqcj1->getPath()) . "\xd\xa";
                    $yikthbri7ulspvx4w4lz9b5r .= "\x43\x6f\x6e\164\145\x6e\164\55\124\162\x61\156\x73\146\145\162\55\105\156\x63\157\144\x69\156\147\72\x20\142\x69\156\x61\x72\x79" . "\15\xa\15\xa";
                    $yikthbri7ulspvx4w4lz9b5r .= file_get_contents($gim13zbbn4vampkqcj1->getPath()) . "\xd\12";
                    $osq2gdcj4mhr464ads .= "\55\x2d" . $tol3vnhtdkb1ypta16e0ifksdlfpd . "\15\12";
                    $osq2gdcj4mhr464ads .= "\x43\x6f\x6e\164\x65\156\164\x2d\x44\151\x73\160\157\163\151\x74\151\x6f\156\72\40\146\157\162\155\x2d\x64\x61\164\141\73\40\x6e\x61\155\145\75\x22" . $aku0qeyan3u . "\42\x3b\x20\x66\x69\x6c\x65\x6e\141\x6d\x65\75\42" . $gim13zbbn4vampkqcj1->getName() . "\x22" . "\15\12";
                    $osq2gdcj4mhr464ads .= "\x43\157\156\164\145\x6e\x74\55\x54\x79\x70\x65\72\40" . $this->getFileMimeType($gim13zbbn4vampkqcj1->getPath()) . "\15\12";
                    $osq2gdcj4mhr464ads .= "\103\x6f\x6e\x74\x65\x6e\164\55\x54\x72\x61\x6e\163\146\145\x72\55\x45\156\x63\157\144\151\x6e\147\x3a\x20\x62\151\156\x61\162\171" . "\xd\12\15\xa";
                    $osq2gdcj4mhr464ads .= "\x2a\x2a\52\x2a\40\x66\151\x6c\x65\x20\143\157\x6e\164\145\x6e\164\40\x2a\x2a\x2a\x2a\15\12";
                    $wjtn9y47tgq2agdmxcxt53x8itscur1nq++;
                }
            }
            if ($wjtn9y47tgq2agdmxcxt53x8itscur1nq) {
                $yikthbri7ulspvx4w4lz9b5r .= "\x2d\x2d" . $tol3vnhtdkb1ypta16e0ifksdlfpd . "\x2d\x2d" . "\15\12";
                $osq2gdcj4mhr464ads .= "\x2d\55" . $tol3vnhtdkb1ypta16e0ifksdlfpd . "\x2d\55" . "\xd\12";
            }
        } else {
            $this->addHeader("\103\157\156\x74\x65\156\164\x2d\x54\171\160\145", "\141\x70\160\154\x69\143\141\x74\x69\157\156\57\x78\55\x77\x77\x77\55\146\x6f\x72\x6d\55\165\162\x6c\145\156\143\x6f\x64\x65\144");
            $yikthbri7ulspvx4w4lz9b5r = http_build_query($k31m3af1wk9qcfd4lye2);
            foreach ($k31m3af1wk9qcfd4lye2 as $w5txcs9l3vp33wrb8s1assvg3lbcru80ide => $th8zj8lazwue22nad2yla2j705fmn4bllia) {
                $osq2gdcj4mhr464ads .= $w5txcs9l3vp33wrb8s1assvg3lbcru80ide . "\75" . $th8zj8lazwue22nad2yla2j705fmn4bllia . PHP_EOL;
            }
        }
        $yntluljklfu672cc7c9fvjgv5gctllq = $this->getStreamContextOptions();
        $yntluljklfu672cc7c9fvjgv5gctllq["\150\164\164\x70"]["\155\145\x74\150\x6f\x64"] = self::HTTP_POST;
        $yntluljklfu672cc7c9fvjgv5gctllq["\x68\164\x74\160"]["\150\145\141\144\145\x72"] = $this->getRequestHeaders();
        $yntluljklfu672cc7c9fvjgv5gctllq["\150\164\x74\x70"]["\143\x6f\x6e\164\x65\156\x74"] = $yikthbri7ulspvx4w4lz9b5r;
        
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\x52\145\x71\x75\145\x73\x74\125\x52\x4c"] = $ofsf8c9h0iyjgynr2p7iprz1->getUri();
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\122\x65\161\165\x65\x73\164\110\145\141\x64\145\162\163"] = $this->getRequestHeaders();
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\x52\145\161\x75\x65\163\x74\102\157\x64\171"] = $osq2gdcj4mhr464ads;
        $autx4 = stream_context_create($yntluljklfu672cc7c9fvjgv5gctllq);
        $this->stream = fopen($ofsf8c9h0iyjgynr2p7iprz1->getUri(), "\162", false, $autx4);
        
        $this->parseResponseHeaders();
        
        $this->result = stream_get_contents($this->stream);
        
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\123\164\141\x74\x75\x73\103\157\144\x65"] = $this->getStatus();
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\x52\145\163\x70\157\156\x73\x65\110\145\x61\x64\x65\162\163"] = "";
        $xu3zzzryo4s493v5axax70a1ikowmr5jh["\122\145\x73\160\157\x6e\163\145\x42\157\x64\171"] = $this->result;
        $vsnakgm87 = $this->getResponseHeaders();
        foreach ($vsnakgm87 as $w5txcs9l3vp33wrb8s1assvg3lbcru80ide => $th8zj8lazwue22nad2yla2j705fmn4bllia) {
            $xu3zzzryo4s493v5axax70a1ikowmr5jh["\x52\x65\x73\160\157\156\163\x65\110\x65\141\x64\x65\162\x73"] .= $w5txcs9l3vp33wrb8s1assvg3lbcru80ide . "\x3a\40" . $th8zj8lazwue22nad2yla2j705fmn4bllia . PHP_EOL;
        }
        $zxtek = "\55\x2d\x2d\x2d\55\55\55\55\55\55\x2d\55\x2d\x2d\55\55\55\x2d\55\x2d\x2d\55\x2d\55\55\55\x2d\x2d\x2d\x2d\55\x2d\55\55\55\x2d\55\x2d\55\x2d\x2d\x2d\x2d\x2d\55\55\55\55\x2d\55\55\55\x2d\x2d\55\x2d\x2d\x2d\x2d\55\x2d\x2d" . PHP_EOL;
        $zxtek .= date("\144\x2e\x6d\56\131\x20\x48\x3a\x69\x3a\x73") . PHP_EOL;
        foreach ($xu3zzzryo4s493v5axax70a1ikowmr5jh as $w5txcs9l3vp33wrb8s1assvg3lbcru80ide => $th8zj8lazwue22nad2yla2j705fmn4bllia) {
            $zxtek .= $w5txcs9l3vp33wrb8s1assvg3lbcru80ide . "\72" . PHP_EOL;
            $zxtek .= $th8zj8lazwue22nad2yla2j705fmn4bllia . PHP_EOL;
        }
        $zxtek .= PHP_EOL . PHP_EOL;
        
        fclose($this->stream);
        $this->stream = null;
        return $this->result;
    }
    
    public function getFileMimeType($gim13zbbn4vampkqcj1)
    {
        if (function_exists("\155\x69\x6d\145\x5f\x63\157\156\x74\x65\x6e\164\x5f\164\171\x70\x65")) {
            return mime_content_type($gim13zbbn4vampkqcj1);
        }
        $hueqtvsbyyayqei6g = "\141\x70\160\x6c\x69\143\141\x74\x69\157\156\x2f\157\x63\x74\x65\164\55\163\x74\162\145\141\155";
        if (preg_match("\57\x28\x5c\56\x6a\160\147\51\44\x7c\50\x5c\56\x6a\160\x65\x67\x29\44\174\50\x5c\x2e\160\x6e\x67\51\x24\174\x28\134\x2e\147\151\x66\x29\x24\x2f", $gim13zbbn4vampkqcj1, $czypoihdk)) {
            switch ($czypoihdk[0]) {
                case "\x2e\152\x70\147":
                    $hueqtvsbyyayqei6g = "\151\155\x61\x67\145\x2f\x6a\160\x65\147";
                    break;
                case "\56\152\x70\x65\147":
                    $hueqtvsbyyayqei6g = "\x69\x6d\141\x67\145\57\x6a\x70\145\147";
                    break;
                case "\x2e\x70\156\147":
                    $hueqtvsbyyayqei6g = "\151\155\141\x67\x65\x2f\160\156\x67";
                    break;
                case "\56\147\151\x66":
                    $hueqtvsbyyayqei6g = "\151\155\141\147\145\x2f\147\151\146";
                    break;
            }
        }
        return $hueqtvsbyyayqei6g;
    }
    
    protected function getRequestHeaders()
    {
        $x94fiwclju0rc28 = array();
        foreach ($this->arRequestHeaders as $b3wdw3f7dp6kn14eb8frzoy0l2 => $a8x8dk6lh43mgzzhp8m3sgd32lcxhw) {
            $x94fiwclju0rc28[] = $b3wdw3f7dp6kn14eb8frzoy0l2 . "\x3a\x20" . $a8x8dk6lh43mgzzhp8m3sgd32lcxhw . "\xd\12";
        }
        return implode("", $x94fiwclju0rc28);
    }
    
    protected function parseResponseHeaders()
    {
        $k31m3af1wk9qcfd4lye2 = stream_get_meta_data($this->stream);
        if (is_array($k31m3af1wk9qcfd4lye2) && isset($k31m3af1wk9qcfd4lye2["\x77\162\141\160\160\x65\x72\x5f\x64\x61\164\x61"])) {
            foreach ($k31m3af1wk9qcfd4lye2["\167\162\141\x70\160\145\x72\x5f\x64\141\x74\x61"] as $rysjb6jp5y0uzjlm2) {
                list($q8tuhqk5ptc8w2sdm9n, $j0crgl9jgwr379jt56u1dcetxt) = explode("\72", $rysjb6jp5y0uzjlm2);
                if (preg_match("\57\136\x68\164\x74\160\x5c\57\50\x5c\144\134\x2e\134\144\51\x5c\163\x2b\50\133\x5c\x64\135\53\x29\57\x69", $q8tuhqk5ptc8w2sdm9n, $czypoihdk)) {
                    $this->status = $czypoihdk[2];
                    continue;
                }
                if (strtolower($q8tuhqk5ptc8w2sdm9n) == "\163\x65\164\x2d\143\157\x6f\x6b\151\145") {
                    $this->parseResponseCookieString($j0crgl9jgwr379jt56u1dcetxt);
                    continue;
                }
                $this->arResponseHeaders[$q8tuhqk5ptc8w2sdm9n] = $j0crgl9jgwr379jt56u1dcetxt;
            }
        }
    }
    
    protected function parseResponseCookieString($k3jvkhjkej)
    {
        if (($zbn2kc5oo6w1vh9bqj = strpos($k3jvkhjkej, "\73")) !== false && $zbn2kc5oo6w1vh9bqj > 0) {
            $i0pnn = trim(substr($k3jvkhjkej, 0, $zbn2kc5oo6w1vh9bqj));
        } else {
            $i0pnn = trim($k3jvkhjkej);
        }
        $s52bod = explode("\75", $i0pnn, 2);
        $this->arResponseCookies[rawurldecode($s52bod[0])] = rawurldecode($s52bod[1]);
    }
    
    public function getResult()
    {
        return $this->result;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function getResponseHeaders()
    {
        return $this->arResponseHeaders;
    }
    
    public function getResponseCookies()
    {
        return $this->arResponseCookies;
    }
}
?>