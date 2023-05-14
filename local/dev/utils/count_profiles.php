<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");


$filter = Array
(
    "GROUPS_ID"=> Array(11) // ID gruppi
);
$rsUsers = CUser::GetList(($by="id"), ($order="asc"), $filter);
while($arItem = $rsUsers->GetNext())
{


    $db_sales = CSaleOrderUserProps::GetList(
        array("DATE_UPDATE" => "DESC"),
        array("USER_ID" => $arItem['ID'])
    );

    if($db_sales->SelectedRowsCount() > 1){

        echo "<h3>".$arItem['NAME']."</h3>";
        echo "<span>".$arItem['LOGIN']."</span>"."</br>";

        //debug($arItem);

        while ($ar_sales = $db_sales->Fetch())
        {
            echo $ar_sales['ID'].' '. $ar_sales['NAME'].' '.'<br>';
        }
    }
}


// Выберем все профили покупателя для текущего пользователя,
// упорядочив результат по дате последнего изменения
/*$db_sales = CSaleOrderUserProps::GetList(
    array("DATE_UPDATE" => "DESC"),
    array("USER_ID" => $USER->GetID())
);

while ($ar_sales = $db_sales->Fetch())
{
    echo $ar_sales['ID'].' '. $ar_sales['NAME'].'<br>';
}*/