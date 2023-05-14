<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//Подключаем модуль, чтобы пользоваться классами этого модуля
if (CModule::IncludeModule("iblock")) {

    //Перечень свойств и полей, которые необходимы в выборке
    $arSelect = ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "EXTERNAL_ID"];

    $arFilter = ["IBLOCK_ID" => 24, "ACTIVE" => "Y"];

    $result = CIBlockElement::GetList(
        ["SORT" => "DESC"], //Сортировка данных. Сначала по дате, по потом по полю SORT (по убыв)
        $arFilter, //Массив фильтр. Это те данные, которые будем фильтровать
        false, //Группировка
        ["nPageSize" => 10000], //Постраничная навигация. по 2эл-та на страницу
        $arSelect
    );

    while ($obj = $result->GetNextElement()) {
        $arItem = $obj->GetFields(); //Получаем из объекта поля
        //$arItem['PROPERTIES'] = $obj->GetProperties(); //Получаем свойства
        $arResult[$arItem['ID']] = $arItem['EXTERNAL_ID'];
    }

    //debug($arResult);

    $unique = array_unique($arResult);

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/dev/utils/element_in_section.txt", null);

    foreach($unique as $key => $arItem){

        $dbGroups = CIBlockElement::GetElementGroups($key, true);

        while($ar_group = $dbGroups->Fetch()){

            debug($ar_group);

            $ar_new_groups[$key][$ar_group['XML_ID']] = $ar_group['XML_ID'];
            $line = implode(", ", $ar_new_groups[$key]);
        }

        $fullLine =  $arItem . ' ' .  $line;
        echo $fullLine;
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/local/dev/utils/element_in_section.txt", $fullLine . "\n", FILE_APPEND | LOCK_EX);
    }

}
