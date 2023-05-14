<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$arEventFields = array(
    "TEXT" => 'testing',
    "EMAIL" => "it@sibagrotrade.ru",
);
$res = CEvent::Send("SENDING_EMAIL_TEST", SITE_ID, $arEventFields);

debug($res);

