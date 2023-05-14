<?php

echo 'test';

function debug($arResult)
{
    echo '<pre>';
    print_r($arResult);
    echo '</pre>';
}

if (!function_exists('xml2array')) {

    function xml2array($xmlObject, $out = [])
    {
        foreach ((array)$xmlObject as $index => $node) {
            $out[$index] = (is_object($node)) ? xml2array($node) : $node;
        }
        return $out;
    }

}

//Функция обрезки текста
function my_crop($text, $length, $clearTags = true)
{
    $text = trim($text);
    if ($clearTags === true)
        $text = strip_tags($text);
    if ($length <= 0 || strlen($text) <= $length)
        return $text;
    $out = mb_substr($text, 0, $length);
    $pos = mb_strrpos($out, ' ');
    if ($pos)
        $out = mb_substr($out, 0, $pos);
    return $out . '…';
}
