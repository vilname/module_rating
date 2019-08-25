<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

?>
<?

$APPLICATION->IncludeComponent(
	"rating:showRatingAdmin",
	"",
	Array(
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "A"
	)
);

?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>