<?php
$_SERVER["DOCUMENT_ROOT"] = '/var/www/sibagrot/data/www/sibagrotrade.com';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Запустить в 4:30  30 4 * * *

$currentTime = (strtotime(date("Y-m-d" )));

$dbAllItems = CIBlockElement::GetList(
    Array(),
    Array("IBLOCK_ID"=>24, ),
    false,
    Array("nPageSize"=>15000),
    Array("ID", "NAME", "IBLOCK_ID",  "IBLOCK_SECTION_ID" )
);

//echo 'Общее кол-во товаров: '. $dbAllItems->SelectedRowsCount() . "</br>";

////////////////////////////////////////////////////////////////////////

$dbActual1SckladItems = CIBlockElement::GetList(
    Array(),
    Array("IBLOCK_ID"=>24, 'ACTIVE' => 'Y',  ">CATALOG_STORE_AMOUNT_1" => 0),
    false,
    Array("nPageSize"=>10000),
    Array("ID", "NAME", "IBLOCK_ID",  "IBLOCK_SECTION_ID" )
);

//echo 'В наличии на НСК складе: '. $dbActual1SckladItems->SelectedRowsCount() . "</br>";



////////////////////////////////////////////////////////////////////////

$dbWaitingItems = CIBlockElement::GetList(
    Array(),
    Array("IBLOCK_ID"=>24, 'ACTIVE' => 'Y',  "=CATALOG_STORE_AMOUNT_1" => 0, '!PROPERTY_DATAPOSTUPLENIYAPLANIRUEMAYA' => 'false'),
    false,
    Array("nPageSize"=>10000),
    Array("ID", "NAME", "IBLOCK_ID",  "IBLOCK_SECTION_ID", "PROPERTY_DATAPOSTUPLENIYAPLANIRUEMAYA" )
);

//echo $dbAllItems->SelectedRowsCount();

while($arItem = $dbWaitingItems->Fetch() ){

    if( $currentTime > strtotime( $arItem['PROPERTY_DATAPOSTUPLENIYAPLANIRUEMAYA_VALUE'] ) )
        //debug($arItem);

    $el = new CIBlockElement;
    $arLoadProductArray = Array("ACTIVE" => "N");

    $res = $el->Update($arItem['ID'], $arLoadProductArray);
}


//
//
//die;
//
//$resultWaitingCount = 0;
//$waitingCount = 0;
//$deactiveCount = 0;
//
//while($arItem = $dbWaitingItems->GetNextElement() ){
//
//    $arFields = $arItem->GetFields();
//
//    // Вычисляем раздел
///*    $rsParentSection = CIBlockSection::GetByID($arFields['IBLOCK_SECTION_ID']);
//    if($arParentSection = $rsParentSection->GetNext()){
//        debug($arParentSection);
//    }*/
//
//   $dbProperty = \CIBlockElement::getProperty(
//       $arFields['IBLOCK_ID'],
//       $arFields['ID'],
//       array("sort", "asc"),
//       array('CODE' => 'DATAPOSTUPLENIYAPLANIRUEMAYA')
//   );
//
//
//     $el = new CIBlockElement;
//      $arLoadProductArray = Array("ACTIVE" => "N");
//
//
//    while ($arProperty = $dbProperty->GetNext()) {
//        // Если есть дата
//        if(!empty($arProperty['VALUE'])){
//            $propertyTime = date('Y-m-d', strtotime( $arProperty['VALUE'] ));
//
//            if($currentTime >= $propertyTime){
//                $waitingCount++;
//            } else {
//                $deactiveCount++;
//                //TODO: Деактивация товара
//              //  echo $arFields['ID'] . ' ' . $arFields['NAME']. '</br>';
//
//                $res = $el->Update($arFields['ID'], $arLoadProductArray);
//            }
//
//        } else {
//            $deactiveCount++;
//            //TODO: Деактивация товара
//            $res = $el->Update($arFields['ID'], $arLoadProductArray);
//            //echo $arFields['ID'] . ' ' . $arFields['NAME']. '</br>';
//        }
//
//    }
//    // echo '<hr>';
//
//}

//  echo 'Ожидается: '. $waitingCount  . "</br>";
// echo 'К деактивации: '. $deactiveCount  . "</br>";



//debug($arItems);
