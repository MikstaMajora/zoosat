<?php

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

//Уникальный многомерный массив
function super_unique($array)
{
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

    foreach ($result as $key => $value)
    {
        if ( is_array($value) )
        {
            $result[$key] = super_unique($value);
        }
    }

    return $result;
}

function check_mobile_device() {
	$mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	// var_dump($agent);exit;
	foreach ($mobile_agent_array as $value) {
		if (strpos($agent, $value) !== false) return true;
	}
	return false;
}