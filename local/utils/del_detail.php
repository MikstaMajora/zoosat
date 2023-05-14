<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//ajax
/*if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH'])
      || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') return;*/

$start = microtime(true);

// $elemObj = new CIBlockElement;
// $elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
	["SORT" => "ASC"],
	["ACTIVE" => "N", "IBLOCK_ID" => "28", "!PREVIEW_TEXT" => false ],
	false,
	["nPageSize" => 500],
	["IBLOCK_ID", "ID", "NAME", "DETAIL_TEXT", "PREVIEW_TEXT"]

);

echo $res->SelectedRowsCount();
$elemDetail = new CIBlockElement;

while ($elemObj = $res->Fetch()) {

	debug($elemObj);


    $elemDetail->Update($elemObj['ID'], array(
			'PREVIEW_TEXT'=> '',
			// 'DETAIL_PICTURE' => array('del' => 'Y') // Позже можно удалить этот код
		));

	// unset($elemObj);


}

echo (microtime(true) - $start);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");






