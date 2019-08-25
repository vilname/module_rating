<?
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Internals\OrderTable;

use BG\Rating\RatingOrderTable;

class ShowAdminRating extends CBitrixComponent{

	protected function checkModules()
    {
        if (!Loader::includeModule('bg.rating'))
            throw new Main\LoaderException(Loc::getMessage('BG_RATING_MODULE_NOT_INSTALLED'));
    }

	public function executeComponent(){

		global $APPLICATION;

		$this->includeComponentLang('class.php');
		$this->checkModules();
		
		$nav = new \Bitrix\Main\UI\AdminPageNavigation("nav-culture");

		$action = Context::getCurrent()->getRequest()->get("action");
		$orderId = Context::getCurrent()->getRequest()->get("order_id");

		if($APPLICATION->GetGroupRight("bg.rating")<"K")
        {
            ShowError(Loc::getMessage("ACCESS_DENIED"));
        }
        else
        {
			$arField = [
				'select' => [
					'*', 
					//'O_NUMBER' => 'ORDER.NUMBER'
				],
				'count_total' => true,
				'offset' => $nav->getOffset(),
				'limit' => $nav->getLimit()
			];

			if($action == 'search-order'){
				if($orderId){
					$arField = array_merge($arField, ['filter' => ['ID_ORDER' => $orderId]]);
					// $arField = ['filter' => ['ID_ORDER' => $orderId]];
				}
				
			}

			$obOrders = RatingOrderTable::getList($arField);

			$nav->setRecordCount($obOrders->getCount());

			$adminList = new CAdminList('order_rating');



			$adminList->setNavigation($nav, Loc::getMessage("PAGES"));

			while($arItem = $obOrders->fetch())
			{
				$arOrders[] = $arItem;
			}

			
			
			

			$this->arResult['ITEM'] = $arOrders;
			$this->arResult['NAV'] = $adminList;


            $this->includeComponentTemplate();
        }
	}
	

}

?>
