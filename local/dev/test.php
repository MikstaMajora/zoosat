<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

if(CModule::IncludeModule("iblock")){

$arResult = [];



	$res = CIBlockElement::GetList(
		['SORT' => 'ASC'],
		['ACTIVE' => 'Y', "PROPERTY_KOD" => strval("33606" . "      ")],
		//['ACTIVE' => 'Y', "PROPERTY_KOD" => strval($product['CODED']."      ")],
		false,
		false,
		['IBLOCK_ID', 'ID', "NAME",  'PROPERTY_*' ]
	);

while($obj = $res->GetNextElement()){

	$arItem = $obj->GetFields();
	debug($arItem['ID']);

//	$arItem['PROPERTIES'] = $obj->GetProperties();
//    $arResult[] = $arItem;
}

// debug($arResult);

echo '<hr>';

}


die;

$homepage = file_get_contents('/var/www/www-root/data/www/zoosat.website/bitrix/download/html/html/31205/1Описание.htm');
debug($homepage);

$html = new \voku\Html2Text\Html2Text( $homepage,
	array(
		'width'    => 5000,
		'elements' => array(
			'h1' => array(
				'case' => \voku\Html2Text\Html2Text::OPTION_UPPERCASE,
			),
			'p' => array(
				'case' => \voku\Html2Text\Html2Text::OPTION_UPPERCASE,
				'append' => "\r\n",
			),
		),
	)
);

$value= $html->getText();


CIBlockElement::SetPropertyValues(
	20940,
	28,
	$value,
	"VK_DESC"
);


// Результаты могут включать "UF_" поля, но по умолчанию они не возвращаются, их надо специально указывать
//$user = \Bitrix\Main\UserTable::getList(array(
//    'filter' => array('=ID' => 1,  ),
//    'limit'=>1,
//    'select'=>array('UF_COMPANY_OPROS'),
//))->fetch();
//
//
//if(($user['UF_COMPANY_OPROS'] == null) OR ($user['UF_COMPANY_OPROS'] == 'false')){
//    echo 'test';
//} else {
//
//}

//
//
//$user = new CUser;
//$fields = Array(
//    "UF_COMPANY_OPROS"  => "333",
//);
//if($user->Update(1, $fields)){
//    //echo 'Обновились удачно';
//} else {
//    echo  $user->LAST_ERROR;
//}
