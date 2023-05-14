<?php
use Bitrix\Sale;

AddEventHandler('sale', 'OnSaleBeforeCancelOrder', 'OnSaleBeforeCancelOrderHandler');
AddEventHandler('sale', 'OnSaleCancelOrder', 'OnSaleCancelOrderHandler');
AddEventHandler('sale', 'OnOrderSave', 'OnOrderSaveHandler');

function OnSaleBeforeCancelOrderHandler($ID, $val) {
	// код перед отменой или снятия отмены заказа
}

function OnSaleCancelOrderHandler($order_id, $status, $info) {
	// код после отмены или снятия отмены заказа

	$order = Sale\Order::load($order_id);
	$propertyCollection = $order->getPropertyCollection();

	$emailPropValue = $propertyCollection->getUserEmail()->getValue();
	$namePropValue  = $propertyCollection->getPayerName()->getValue();
	$locPropValue   = $propertyCollection->getDeliveryLocation()->getValue();
	//$taxLocPropValue = $propertyCollection->getTaxLocation()->getValue();
	$profNamePropVal = $propertyCollection->getProfileName()->getValue();
	$phonePropValue = $propertyCollection->getPhone()->getValue();

	$orderNumber = $order->getField("ACCOUNT_NUMBER");

	\Bitrix\Main\Mail\Event::sendImmediate(array(
		//"EVENT_NAME" => "USER_INFO",
		"EVENT_NAME" => "SALE_ORDER_CANCEL_EMAIL",
		"LID" => "s1",
		"C_FIELDS" => array(
			"ORDER_NUMBER" => $orderNumber,
			"EMAIL" => $emailPropValue,
			"NAME" => $profNamePropVal,
			"LAST_NAME" => "",
			"PHONE_CLIENT" => $phonePropValue,
			"DESC" => $info,
		),
		"Y", //можно не указывать
		2 //можно не указывать
	));

//	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export( $emailPropValue, true)."\r", FILE_APPEND | LOCK_EX);
//
//
//
//	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export( $order_id, true)."\r", FILE_APPEND | LOCK_EX);
//	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export( $status, true)."\r", FILE_APPEND | LOCK_EX);
//
//	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export( $info, true)."\r", FILE_APPEND | LOCK_EX);

}

function OnOrderSaveHandler($orderId, $fields, $orderFields, $isNew){


//	$arFields['USER_ID'] = '1';
//
	$dbOrders = \Bitrix\Sale\Order::getList(array(
		'filter' => array('USER_ID' => (int)$orderFields['USER_ID']),
		'group' => array('COUNT' => 'USER_ID'),
		'select' => array('CNT'),
		'runtime' => array(
			new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)')
		)
	));
	if ($arOrders = $dbOrders->fetch()) {
		$CNT_ORDERS= (int)$arOrders['CNT'];
	}

	if( $CNT_ORDERS == 1){

		$order = \Bitrix\Sale\Order::loadByAccountNumber((int)$orderFields['ACCOUNT_NUMBER']);
		$propertyCollection = $order->getPropertyCollection();
		$podarokPropValue = $propertyCollection->getItemByOrderPropertyId(20);
		//$podarokValue = $podarokPropValue->getValue();
		$podarokPropValue->setValue("FIRST_ZAKAZ");
		$order->save();

//		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export($CNT_ORDERS, true)."\n\r", FILE_APPEND | LOCK_EX);
//		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export($orderId, true)."\n\r", FILE_APPEND | LOCK_EX);
//		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export($isNew, true)."\n\r", FILE_APPEND | LOCK_EX);
//		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export($orderFields, true)."\n\r", FILE_APPEND | LOCK_EX);
//		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/orders.log", var_export($fields, true)."\n\r", FILE_APPEND | LOCK_EX);


	} else {
		global $APPLICATION;
		$APPLICATION->ThrowException('Невозможно записать заказ');
	}



}