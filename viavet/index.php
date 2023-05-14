<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Viavet");
?>

<?
$APPLICATION->IncludeComponent(
	"uniqcle:component.viavet",
	"main",
	array(
      "CACHE_TIME" => 0,
      "CACHE_TYPE" => "A"
	)
);
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>