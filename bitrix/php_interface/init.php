<?php


use \Bitrix\Main\EventManager,
	\Bitrix\Main\Context;

/**
 * Отвечает на заголовок If-Modified-Since
 */
EventManager::getInstance()->addEventHandler("main", "OnEndBufferContent", "setIfModifiedSince");

class bxHttpResponse extends \Bitrix\Main\HttpResponse
{
	function getLastModified($obj)
	{
		return $obj->lastModified;
	}
}

function setIfModifiedSince() {
	if (function_exists('apache_request_headers')) {
		$arHeaders = array_change_key_case(apache_request_headers(), CASE_UPPER);
		
		if ($ifModifiedSince = $arHeaders['IF-MODIFIED-SINCE']) {
			$date = \DateTime::createFromFormat(
				"D, d M Y H:i:s T",
				$ifModifiedSince
			);
			$ob = new bxHttpResponse;
			if ($lastModified = $ob->getLastModified(Context::getCurrent()->getResponse())) {
				if ($date->getTimestamp() > $lastModified->getTimestamp()) { // Прямое сравнение не работает :(
					Context::getCurrent()->getResponse()->setStatus("304 Not Modified");
				}
			}
		}
	}
}