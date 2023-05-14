<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$urlRoot = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/download/users/customer_categories.xml';

$xmlObj = simplexml_load_file($urlRoot);



//Проходимся по списку категорий
//Если категории нет, создаем

foreach ($xmlObj->СписокКатегорий->Категория  as $item) {

//    echo "ID: ".$item->Ид.'<br>';
//    echo "NAME: ".$item->Наименование.'<br>';
//    echo "ARTICULE: ".$item->Артикул.'<br>';
//    echo "<br>";

    $groupStringId = "$item->Ид";
    $groupName = "$item->Наименование";

    $result = \Bitrix\Main\GroupTable::GetList( array(
        'select' => array('NAME', 'STRING_ID'),
        'filter' => array('STRING_ID' => $groupStringId )
    ));

    if($category = $result->fetch() ){
        echo "Группа с названием <b>" . $category['NAME'] . "</b> уже существует! <br>";
    } else {

       $group = new CGroup;
        $arFields = Array(
            "ACTIVE"       => "Y",
            "C_SORT"       => 101,
            "NAME"         => $groupName,
            "DESCRIPTION"  => "Группа для почтовых рассылок.",
            //"USER_ID"      => array(128, 134),
            "STRING_ID"      => $groupStringId
        );
        $NEW_GROUP_ID = $group->Add($arFields);
        if (strlen($group->LAST_ERROR)>0) ShowError($group->LAST_ERROR);
    }

}

//Проходимся по списку клиентов
//Выборка клиента по UID
//Если клиента нет в выбранной категории - добавляем.
$usersList = $xmlObj->СписокКлиентов->Клиент;

foreach ($usersList  as $user) {
    //debug($user);

    $userUID = "$user->ИдКлиента";
    $userCategoryID = "$user->ИдКатегории";

    $dbUser = \Bitrix\Main\UserTable::getList(array(
        'select' => array('ID', 'NAME', 'XML_ID', 'EMAIL'),
        'filter' => array('XML_ID' => $userUID )
    ));

    $dbCategory = \Bitrix\Main\GroupTable::GetList( array(
        'select' => array('NAME', 'STRING_ID', 'ID'),
        'filter' => array('STRING_ID' => $userCategoryID )
    ));

    $arCategory = $dbCategory->fetch();

    if( $arUser = $dbUser->fetch()){
        $arGroup = \Bitrix\Main\UserTable::getUserGroupIds( $arUser['ID'] );

        if(!in_array( $arCategory['ID'], $arGroup )){

            \Bitrix\Main\UserGroupTable::add(array(
                'USER_ID' => $arUser['ID'],
                'GROUP_ID' => $arCategory['ID'],
            ));
        }
    }


}




