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

    //debug( $arEnumValueSection );

    foreach($arEnumValueSection as $key => $item):

        $arSelect = ["ID", "IBLOCK_ID", "NAME",   "PROPERTY_CML2_MANUFACTURER"  ];
        $arFilter = ["IBLOCK_ID" => 28,     "ACTIVE"=>"Y", "PROPERTY_CML2_MANUFACTURER_VALUE" => $item['VALUE'] ];
        //$arFilter = ["IBLOCK_ID" => 24,    "ACTIVE"=>"Y",       "PROPERTY_CML2_MANUFACTURER" => "41d4c351-0f5d-11ea-80c9-cb4ec39ec3cd" ];
        $result = CIBlockElement::GetList(
            [ "NAME" => "DESC"],
            $arFilter,
            false, //Группировка
            ["nPageSize" => 10000], //Постраничная навигация. по 2эл-та на страницу
            $arSelect
        );

        if($obj = $result->Fetch()){
            //$arItem = $obj->GetFields();
            //$arItem['PROPERTIES'] = $obj->GetProperties();
            //$arElements[] = $obj['ID'];
            continue;
            //debug($obj);
        } else {
            echo $item['VALUE'] . "<br>";
        }


    endforeach;
    echo "<br>";

}