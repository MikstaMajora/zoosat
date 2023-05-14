<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$elemObj = new CIBlockElement;
$elemDetail = new CIBlockElement;

$res = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => '24', '!PROPERTY_OSNOVNAYA_UPAKOVKA' => false ],
    false,
    ['nTopCount' => 1000],
    ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_KOD', 'PROPERTY_OSNOVNAYA_UPAKOVKA']

);

echo $res->SelectedRowsCount();

while ($elemObj = $res->Fetch()) {


    debug($elemObj);

    CIBlockElement::SetPropertyValuesEx($elemObj['ID'], 24, array("OSNOVNAYA_UPAKOVKA" => ''));



}