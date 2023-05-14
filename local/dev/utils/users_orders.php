<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


echo \Bitrix\Main\UserTable::getActiveUsersCount();

	$arUncustomers = [];
	$filter = Array(
		"GROUPS_ID"=> Array(5)
	);
	$rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter);
	while($arItem = $rsUsers->GetNext()){

		$arFilterOrder = Array(
			"USER_ID" => $arItem['ID'],

		);

		$db_sales = CSaleOrder::GetList(array(), $arFilterOrder);
		if($ar_sales = $db_sales->Fetch()){
			//debug($ar_sales);
			continue;
		} else {

			$arUncustomers[] = $arItem['ID'];
		}


	}

//debug($arUncustomers);

	foreach($arUncustomers as $key => $uncustomer){

		$data = CUser::GetList(($by="ID"), ($order="ASC"),
			array(
				'>=DATE_REGISTER' => '01.08.2021',
				'ACTIVE' => 'Y',
				'ID' => $uncustomer
			)
		);

		while($arUser = $data->Fetch()) {
			$full =  $key. ' ' .
				//$arUser['ID'].' '.
				$arUser['NAME'].' '.
				$arUser['LAST_NAME'].' '.
				$arUser['PERSONAL_PHONE']. ' ' .
				$arUser['LOGIN']. ' ' .
				$arUser['DATE_REGISTER'].
				"<br>";
			debug($full);
		}
	}




