<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$rs = CIBlockElement::GetList(
    ['CODE' => 'ASC'],                                               // Порядок
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => 24, "!PROPERTY_TOVARVSEGMENTENOVINKI" => false], // Фильтрация
    false,
    ['nTopCount' => 1000],                      // Кол-во на странице
    ['IBLOCK_ID', 'ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_KOD']            // Выборка
);

echo '<b>' . $rs ->SelectedRowsCount() . '</b>';


// Fetch возвращает массив
while( $elem = $rs->Fetch() ){
   // debug($elem['PROPERTY_KOD_VALUE']);
}



// file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/reset_props_index.log", var_export($arResult, true)."\n\r", FILE_APPEND | LOCK_EX);
