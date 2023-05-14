<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$elemObj = new CIBlockElement;
$elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => '24', "!PROPERTY_TOVARVSEGMENTENOVINKI" => false ],
    false,
    ['nTopCount' => 50000],
    ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_TOVARVSEGMENTENOVINKI']

);

echo ' Рекомендуемые товары '. $res->SelectedRowsCount() . '</br>';
echo '<hr>';

while ($elemObj = $res->Fetch()) {

    debug($elemObj);

}