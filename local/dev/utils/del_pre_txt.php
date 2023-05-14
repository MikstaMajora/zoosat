<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$elemObj = new CIBlockElement;
$elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['ACTIVE' => 'N', 'IBLOCK_ID' => '24', '!PREVIEW_TEXT' => false, '!SECTION_ID' => '754'],
    false,
    ['nTopCount' => 500],
    ['IBLOCK_ID', 'ID', 'NAME', 'PREVIEW_TEXT']

);

echo $res->SelectedRowsCount();

while ($elemObj = $res->Fetch()) {

    // echo $elemObj['PREVIEW_TEXT'].'<br>';

    // debug($elemObj);
/*
    $elemDetail->Update($elemObj['ID'], array(
        'PREVIEW_TEXT'=> '',
        // 'DETAIL_PICTURE' => array('del' => 'Y') // Позже можно удалить этот код
    ));
*/


}