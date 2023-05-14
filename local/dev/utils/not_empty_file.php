<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$elemObj = new CIBlockElement;
$elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => '28', 'PROPERTY_FILES' => false, "CATALOG_AVAILABLE"=>"Y" ],
    false,
    ['nTopCount' => 50000],
    ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_FILES', 'PROPERTY_KOD']

);

echo 'Товары с отсутствующими файлами '. $res->SelectedRowsCount() . '</br>';
echo '<hr>';

while ($elemObj = $res->Fetch()) {

    echo $elemObj['PROPERTY_KOD_VALUE'] . '  ' . $elemObj['NAME']. ';</br>';

}