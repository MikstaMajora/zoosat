<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$allRegisterUsers = [];
$allZeroUsers = [];
$allOneUsers = [];
$allTwoMoreUsers = [];

$arFilter = Array(
	Array(
		"LOGIC"=>"AND",
		Array(
			">=DATE_REGISTER"=> "01.01.2022 00:43:44",
		),
		Array(
			"<=DATE_REGISTER"=> "01.01.2023 00:43:44"
		)
	)
);

$dbUser = \Bitrix\Main\UserTable::getList(array(
	'select' => array('ID', 'NAME', 'LAST_NAME', 'EMAIL', 'DATE_REGISTER'),
	'filter' => $arFilter
));


if($arUser = $dbUser->fetchAll()){

	// Если у клиента есть заказы за год
	// Заносим в массив

	foreach($arUser as $key => $user){
		$ordersUser = [];
		$allRegisterUsers[] = $user;
		//debug($user);

		$dbRes = \Bitrix\Sale\Order::getList([
			'select' => ['ID'],
			'filter' => [
				"USER_ID" => $user['ID'], //по пользователю
				//"<DATE_INSERT" => "2023-01-01 16:51:17.000000", //по дате
			],
			'order' => ['ID' => 'DESC']
		]);

		while ($order = $dbRes->fetch()){
			$ordersUser[] = $order;
		}

		if(count($ordersUser) >= 2){
			$allTwoMoreUsers[$user['EMAIL']]['Имя'] = $user['NAME'] . " " . $user['LAST_NAME'];
			$allTwoMoreUsers[$user['EMAIL']]['Почта'] = $user['EMAIL'];
			$allTwoMoreUsers[$user['EMAIL']]['Заказы'] = count($ordersUser);

			//debug($user['EMAIL']);

		} else if(count($ordersUser) == 1) {

			$allOneUsers[$user['EMAIL']]['Имя'] = $user['NAME'] . " " . $user['LAST_NAME'];
			$allOneUsers[$user['EMAIL']]['Почта'] = $user['EMAIL'];
			$allOneUsers[$user['EMAIL']]['Заказы'] = count($ordersUser);

			//debug($user['EMAIL']);

		} else {
			$allZeroUsers[$user['EMAIL']]['Имя'] = $user['NAME'] . " " . $user['LAST_NAME'];
			$allZeroUsers[$user['EMAIL']]['Почта'] = $user['EMAIL'];
			$allZeroUsers[$user['EMAIL']]['Заказы'] = count($ordersUser);
			debug($user['EMAIL']);
		}

		//echo '<hr>';
	}

	echo "Зарегистрированных клиентов с янв. 22 по янв. 23 год: <b> " . count($allRegisterUsers) . "</b>";
	echo '</br>';
	echo "Клиентов, не сделавших ни одного заказа: <b>" . count($allZeroUsers) . "</b>";
	echo '</br>';
	echo "Клиентов, сделавших 1 заказ: <b>" . count($allOneUsers) . "</b>";
	echo '</br>';
    echo "Клиентов, сделавших 2 заказа и более: <b>" . count($allTwoMoreUsers) . "</b>";
	//debug($allTwoMoreUsers);
	//debug($allOneUsers);
	//debug($allZeroUsers[][0]);
}