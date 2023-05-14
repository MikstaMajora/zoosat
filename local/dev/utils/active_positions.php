<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//Подключаем модуль, чтобы пользоваться классами этого модуля
if(CModule::IncludeModule("iblock")) {

    //Перечень свойств и полей, которые необходимы в выборке
    $arSelect = ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "EXTERNAL_ID"];

    //Данные берем из блока 3, с активной датой
    $arFilter = ["IBLOCK_ID" => 24, "ACTIVE" => "Y"];

    //Формируем объект
    $result = CIBlockElement::GetList(
        ["SORT" => "DESC"], //Сортировка данных. Сначала по дате, по потом по полю SORT (по убыв)
        $arFilter, //Массив фильтр. Это те данные, которые будем фильтровать
        false, //Группировка
        ["nPageSize" => 10000], //Постраничная навигация. по 2эл-та на страницу
        $arSelect
    );

    //Перебираем все данные, которые попали в объект
    while ($obj = $result->GetNextElement()) {
        $arItem = $obj->GetFields(); //Получаем из объекта поля
        //$arItem['PROPERTIES'] = $obj->GetProperties(); //Получаем свойства
        $arResult[] = $arItem['EXTERNAL_ID'];

    }



    $unique = array_unique($arResult);

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/dev/utils/active_positions.txt", null);

    foreach($unique as $value){

        echo $value . "\n";

        //file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/dev/utils/active_positions.txt", $value ."\n",  FILE_APPEND | LOCK_EX);
    }

}

