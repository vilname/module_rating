<?
use Bitrix\Main\Loader;
Loader::includeModule("sale");

$obOrders = \Bitrix\Sale\Internals\OrderTable::getList(array(
	'select' => ['ID', 'SUM_PAID']
));

while($arOrders = $obOrders->fetch()){
	$item[$arOrders["ID"]] = "[".$arOrders["ID"]."] ".$arOrders["SUM_PAID"];
}

$arComponentParameters = array(
	"PARAMETERS" => array(
		"BG_ORDERS_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BG_RATING_ORDERS"),
			"TYPE" => "LIST",
			"VALUES" => $item,
		 ),
		// "IBLOCK_TYPE" => array(
		//     "PARENT" => "BASE",
		//     "NAME" => GetMessage("ADD_CHANNEL_IBLOCK_TYPE"),
		//     "TYPE" => "STRING",
		// ),
		// "IBLOCK_ID" => array(
		//     "PARENT" => "BASE",
		//     "NAME" => GetMessage("ADD_CHANNEL_IBLOCK_ID"),
		//     "TYPE" => "STRING",
		// ),
		// "TEMPLATE_URL_SECTION" => array(
		//     "PARENT" => "BASE",
		//     "NAME" => GetMessage("TEMPLATE_URL_SECTION"),
		//     "TYPE" => "STRING",
		// ),
		"CACHE_TIME" => array(),
	)
);

?>