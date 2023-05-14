<?php
COption::SetOptionString("catalog", "DEFAULT_SKIP_SOURCE_CHECK", "Y");
COption::SetOptionString("sale", "secure_1c_exchange", "N");

require_once(__DIR__ . '/functions.php');
//require_once(__DIR__ . '/events/events_users.php');

if(file_exists( $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/events/events_orders.php' )){
	require_once( $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/events/events_orders.php' );
}

if(file_exists( $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php' )){
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php' );
}