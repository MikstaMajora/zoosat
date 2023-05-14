<?php



//unset($arResult['ITEMS']);


//Из массива разделов получаем символьный код производителя
function getSection( $paramSectionID ){
    $result = CIBlockSection::GetList(
        array("SORT" => "ASC"),
        array("IBLOCK_ID" => 30, 'UF_ON_INDEX_PAGE'=>1),
        false,
        ["ID", "NAME", "PICTURE", "DESCRIPTION", "DETAIL_PICTURE", "CODE", "UF_*"],
        false
    );
    while($rsSection = $result->GetNext()){
        $rsSection['FILE'] = CFile::GetFileArray($rsSection['PICTURE']);
        //$arSection['PROPERTIES'] = $rsSection->GetProperties();
        $arSection[] = $rsSection;

    }
    return $arSection;
}

$arResult['ITEMS'] = getSection($paramSectionID);

// debug($arResult['ITEMS']);

//debug($arResult);

