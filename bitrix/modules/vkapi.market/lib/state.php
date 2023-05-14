<?php

namespace VKapi\Market;


final class State
{
    
    protected $code = null;
    
    protected $dir = null;
    
    protected $variableName = "\x61\x72\x44\x61\x74\x61";
    
    protected $data = null;
    
    public function __construct($uz7l6557u7jryg50xpql6nc27y65, $ken1mesapqm5oxe92jezawcu24s95xf2 = null)
    {
        $ken1mesapqm5oxe92jezawcu24s95xf2 = trim($ken1mesapqm5oxe92jezawcu24s95xf2, "\x2f");
        if (empty($ken1mesapqm5oxe92jezawcu24s95xf2)) {
            $ken1mesapqm5oxe92jezawcu24s95xf2 = "\x65\170\160\157\x72\164";
        }
        $this->code = trim($uz7l6557u7jryg50xpql6nc27y65);
        $this->dir = "\x2f" . $ken1mesapqm5oxe92jezawcu24s95xf2;
    }
    
    public function getVariableName()
    {
        return $this->variableName;
    }
    
    public function get()
    {
        if (is_null($this->data)) {
            $this->data = array();
            try {
                
                if ($this->isExists()) {
                    
                    include $this->getFilename();
                    
                    if (isset(${$this->getVariableName()}) && is_array(${$this->getVariableName()})) {
                        $this->data = ${$this->getVariableName()};
                    }
                }
            } catch (\ParseError $v66uc8iyo716rgcew) {
                
                $this->clean();
            }
        }
        return $this->data;
    }
    
    public function getField($ujs9p1xe2si92a5oehp)
    {
        $sdzgis8yb17p2 = $this->get();
        if (array_key_exists($ujs9p1xe2si92a5oehp, $sdzgis8yb17p2)) {
            return $sdzgis8yb17p2[$ujs9p1xe2si92a5oehp];
        }
        return null;
    }
    
    public function set($sdzgis8yb17p2)
    {
        if (is_null($this->data)) {
            $this->data = array();
        }
        $this->data = array_merge($this->data, $sdzgis8yb17p2);
        return $this;
    }
    
    public function setField($ujs9p1xe2si92a5oehp, $sdzgis8yb17p2)
    {
        if (is_null($this->data)) {
            $this->data = array();
        }
        $this->data[$ujs9p1xe2si92a5oehp] = $sdzgis8yb17p2;
        return $this;
    }
    
    public function setOnlyKey($sdzgis8yb17p2, $ug7vsnelmzejspnrcbw62kf)
    {
        if (array_key_exists($ug7vsnelmzejspnrcbw62kf, $sdzgis8yb17p2)) {
            $this->setField($ug7vsnelmzejspnrcbw62kf, $sdzgis8yb17p2[$ug7vsnelmzejspnrcbw62kf]);
        }
        return $this;
    }
    
    public function save()
    {
        if (is_null($this->data)) {
            $this->data = array();
        }
        \Bitrix\Main\IO\File::putFileContents($this->getFilename(), "\x3c" . "\77\x20\44" . $this->getVariableName() . "\40\x3d\x20" . var_export($this->data, true) . "\73\x20\77\76");
    }
    
    public function clean()
    {
        $this->data = null;
        return \Bitrix\Main\IO\File::deleteFile($this->getFilename());
    }
    
    public function cleanDir()
    {
        \Bitrix\Main\IO\Directory::deleteDirectory($this->getDirectory());
    }
    
    public function isExists()
    {
        return file_exists($this->getFilename());
    }
    
    public function getBaseDirectory()
    {
        return \Bitrix\Main\Application::getDocumentRoot() . "\57\x75\160\x6c\x6f\x61\x64\57\x76\153\141\x70\151\56\155\141\162\153\x65\164\57\163\x74\141\x74\145";
    }
    
    public function getDirectory()
    {
        try {
            return \Bitrix\Main\IO\Path::normalize($this->getBaseDirectory() . $this->dir);
        } catch (\Exception $v66uc8iyo716rgcew) {
            return $this->getBaseDirectory();
        }
    }
    
    public function getFilename()
    {
        return $this->getDirectory() . "\x2f" . $this->code . "\x2e\160\x68\160";
    }
    
    public function calcPercentByData($sdzgis8yb17p2)
    {
        $bgbqb49uyp158b28dhpewwtrfric9x = 0;
        if (isset($sdzgis8yb17p2["\x73\x74\x65\160\x73"])) {
            $bgbqb49uyp158b28dhpewwtrfric9x = floor(array_sum(array_column($sdzgis8yb17p2["\x73\x74\145\x70\x73"], "\x70\145\162\143\x65\x6e\x74")) / count($sdzgis8yb17p2["\x73\164\x65\160\163"]));
        } else {
            $bgbqb49uyp158b28dhpewwtrfric9x = $this->calcPercent($sdzgis8yb17p2["\x63\157\x75\156\x74"], $sdzgis8yb17p2["\x6f\x66\146\x73\145\x74"]);
        }
        return $bgbqb49uyp158b28dhpewwtrfric9x;
    }
    
    public function calcPercent($q0n3bk7er1ueocegmjm, $kz8tkszg6mwyzg2t32irqqymb0ttjxi)
    {
        if ($q0n3bk7er1ueocegmjm <= 0) {
            return 100;
        }
        if ($kz8tkszg6mwyzg2t32irqqymb0ttjxi <= 0) {
            return 0;
        }
        $kz8tkszg6mwyzg2t32irqqymb0ttjxi = min($kz8tkszg6mwyzg2t32irqqymb0ttjxi, $q0n3bk7er1ueocegmjm);
        $bgbqb49uyp158b28dhpewwtrfric9x = floor($kz8tkszg6mwyzg2t32irqqymb0ttjxi * 100 / $q0n3bk7er1ueocegmjm);
        return max(min($bgbqb49uyp158b28dhpewwtrfric9x, 100), 0);
    }
}
?>