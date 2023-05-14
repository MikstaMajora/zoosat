<?php
define("STOP_STATISTICS", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC","Y");
define("DisableEventsCheck", true);
define("BX_SECURITY_SHOW_MESSAGE", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//ajax
/*if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH'])
      || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') return;*/

$start = microtime(true);

// $elemObj = new CIBlockElement;
// $elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ["SORT" => "ASC"],
    ["ACTIVE" => "N", "IBLOCK_ID" => "24", "NAME" => "%Natural%"  ],
    false,
    false,
    ["IBLOCK_ID", "ID", "NAME", "DETAIL_TEXT"]

);

echo $res->SelectedRowsCount();

while ($elemObj = $res->Fetch()) {

    debug($elemObj);
    echo 'test';

    /*    $elemDetail->Update($elemObj['ID'], array(
            'DETAIL_TEXT'=> '',
            // 'DETAIL_PICTURE' => array('del' => 'Y') // Позже можно удалить этот код
        ));*/

    // unset($elemObj);


}

echo (microtime(true) - $start);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");






