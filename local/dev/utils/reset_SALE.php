<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$elemObj = new CIBlockElement;
$elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => '24', '!PROPERTY_SALE' => false, ],
    false,
    ['nTopCount' => 50000],
    ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_KOD']

);

echo 'Товары с акциями '. $res->SelectedRowsCount() . '</br>';
echo '<hr>';

while ($elemObj = $res->Fetch()) {

   //debug($elemObj);
    echo $elemObj['PROPERTY_KOD_VALUE'] . ' ' . $elemObj['NAME'] . '</br>';

}