<!-- Подключение ядра без визуальной части -->
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if(isset($_GET)  && !empty($_GET)) {

    function getArrSection(){
        $db_enum_list = CIBlockProperty::GetPropertyEnum(
            "CML2_MANUFACTURER",
            Array(),
            Array("IBLOCK_ID"=>28,));
        while($obj = $db_enum_list->Fetch() ){
            $ar_enum_list[] = $obj;
        }
        return $ar_enum_list;
    }
    $arEnumValueSection = getArrSection();

    foreach ($arEnumValueSection as $key => $manufact) {
        $arSelect = ["ID", "IBLOCK_ID", "NAME", "CODE"];
        $arFilter = ["IBLOCK_ID" => 30, "CODE" => $manufact['EXTERNAL_ID']];

        $result = CIBlockSection::GetList(
            ["SORT" => "DESC"],
            $arFilter,
            false, //Группировка
            ["nPageSize" => false],
            $arSelect
        );
        if ($obj = $result->Fetch()){
            continue;
        } else {
            //debug( $manufact );
            $bs = new CIBlockSection;
            $arFields = array(
                "ACTIVE"      => 'Y',
                "IBLOCK_ID"   => 30,
                "NAME"        => $manufact['VALUE'],
                "CODE"        => $manufact['EXTERNAL_ID'],
                "DESCRIPTION" => 'Производитель ' . $manufact['VALUE'],
            );

            if ($SECTION_ID = $bs->Add($arFields)) {
                $res = CIBlockSection::GetByID( $SECTION_ID );
                if($ar_res = $res->GetNext())
                    echo "Раздел <b>" . $ar_res['NAME'] . "</b> добавлен <br>";

            } else {
                echo 'Error: ' . $bs->LAST_ERROR;
            }

        }

    }

    echo '<div class="alert alert-success" role="alert"> Производители обновлены </div>';

}