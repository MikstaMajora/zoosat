<?php

namespace VKapi\Market\Condition\Control;


class Select extends \VKapi\Market\Condition\Control\Base
{
    
    public function __construct($asbbk09n38dkzicxcn196pxyy, $cut6l2dhn8rl39sr0eh9q5q41 = array(), $ciuc83r7unj8o8mk87y6oijsuq9x = null, $mqkqyt8dy61wrwwy = false)
    {
        if (is_null($ciuc83r7unj8o8mk87y6oijsuq9x)) {
            $e0ksmxto9ks = array_keys($cut6l2dhn8rl39sr0eh9q5q41);
            $ciuc83r7unj8o8mk87y6oijsuq9x = reset($e0ksmxto9ks);
        }
        if ($mqkqyt8dy61wrwwy === true) {
            $mqkqyt8dy61wrwwy = "\x2e\56\x2e";
        }
        parent::__construct(array(
            "\156\x61\x6d\145" => $asbbk09n38dkzicxcn196pxyy,
            "\x76\x61\x6c\x75\145\163" => self::prepareValues($cut6l2dhn8rl39sr0eh9q5q41),
            "\x76\x61\154\165\145" => $ciuc83r7unj8o8mk87y6oijsuq9x,
            "\146\x69\162\163\x74\105\x6d\x70\164\171" => $mqkqyt8dy61wrwwy,
            "\x65\156\x61\142\x6c\x65\144\123\x65\141\162\x63\150" => false,
            // поиск выклчюен
            "\x61\x6a\x61\x78\126\141\x6c\165\x65\x73\x55\x72\154" => false,
        ));
    }
    
    public function enableSearch()
    {
        $this->setParameter("\145\x6e\x61\142\x6c\145\x64\x53\x65\141\162\143\x68", true);
        return $this;
    }
    
    public function setAjaxValues($via8jjvzzi4bhydsevw)
    {
        $this->setParameter("\x61\152\141\170\126\x61\154\x75\145\163\125\162\154", $via8jjvzzi4bhydsevw);
        return $this;
    }
    
    public static function getComponent()
    {
        return "\x76\x6b\141\x70\x69\55\x6d\141\162\153\x65\x74\55\143\x6f\x6e\x64\x69\x74\151\x6f\156\x2d\143\157\156\x74\162\157\154\55\163\x65\x6c\145\x63\x74";
    }
    
    public static function prepareValues($l83w1r4afjy24t3jef63wrjazrg1yo)
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        foreach ($l83w1r4afjy24t3jef63wrjazrg1yo as $usl3e45v5p => $neueels6) {
            $gicuvkskpuwr53xgm3ud8u3eup[] = array("\151\x64" => $usl3e45v5p, "\x6e\141\x6d\x65" => $neueels6);
        }
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
    
    public function checkValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $asbbk09n38dkzicxcn196pxyy = $this->getParameter("\x6e\141\155\145");
        $cut6l2dhn8rl39sr0eh9q5q41 = $this->getParameter("\166\141\154\x75\x65\x73");
        
        if (!array_key_exists($asbbk09n38dkzicxcn196pxyy, $ip0ds)) {
            return false;
        }
        
        $neueels6 = $ip0ds[$asbbk09n38dkzicxcn196pxyy];
        $qyu8mk4dfo86crc32a9o1afxy3wmot = array_filter($cut6l2dhn8rl39sr0eh9q5q41, function ($c4gg2x9j0av) use($neueels6) {
            return $c4gg2x9j0av["\x69\144"] == $neueels6;
        });
        if (empty($qyu8mk4dfo86crc32a9o1afxy3wmot)) {
            return false;
        }
        return true;
    }
    
    public function getValue($ip0ds, $er76o6b0id047jr60eu5o6opfyoyi0259r)
    {
        $gicuvkskpuwr53xgm3ud8u3eup = array();
        $gicuvkskpuwr53xgm3ud8u3eup[$this->getParameter("\156\141\x6d\145")] = $ip0ds[$this->getParameter("\156\x61\155\x65")];
        return $gicuvkskpuwr53xgm3ud8u3eup;
    }
}
?>