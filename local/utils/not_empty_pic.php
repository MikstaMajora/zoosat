<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$elemObj = new CIBlockElement;
$elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ['SORT' => 'DESC'],
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => '28', 'PREVIEW_PICTURE' => false,  ],
    false,
    ['nTopCount' => 50000],
    ['IBLOCK_ID', 'ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_KOD']

);

echo 'Товары с отсутствующими картинками '. $res->SelectedRowsCount() . '</br>';
echo '<hr>';

while ($elemObj = $res->Fetch()) {

    echo $elemObj['PROPERTY_KOD_VALUE'] . '  ' . $elemObj['NAME']. '</br>';

}