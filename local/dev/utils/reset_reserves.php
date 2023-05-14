<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$rsProducts = CCatalogProduct::GetList(
    array(),
    array(),
    false,
    false,
    array(
        'ID',
        'ELEMENT_NAME',
        'QUANTITY',
        'QUANTITY_RESERVED'
    )
);

while( $arProduct = $rsProducts->Fetch() ){
    if( $arProduct['QUANTITY_RESERVED'] >=1 ){
        debug($arProduct);
    }
}




/*
// Получим список всех товаров
$db_res = CCatalogProduct::GetList();

while ($arProduct = $db_res->Fetch())
{
        // Получим записи из таблицы остатков товара для склада с ID=1
	$rs = CCatalogStoreProduct::GetList(false, array('PRODUCT_ID'=> $arProduct['ID'], 'STORE_ID' => 1));

	while($ar_fields = $rs->GetNext())
	{
		// Обновим значение остатка на складе из значения остатка количественного учёта
                $arFields = Array(
                "PRODUCT_ID" => $ar_fields["PRODUCT_ID"],
                "STORE_ID" => 1,
                "AMOUNT" => 0,
    	        );
		CCatalogStoreProduct::Update($ar_fields['ID'], $arFields);
	}
}
*/
