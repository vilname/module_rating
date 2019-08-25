<?
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Internals\OrderTable;
use Bitrix\Main\Localization\Loc;

use BG\Rating\RatingOrderTable;

class changeElemChannel extends CBitrixComponent{

	protected function checkModules()
    {
        if (!Loader::includeModule('bg.rating'))
            throw new Main\LoaderException(Loc::getMessage('BG_RATING_MODULE_NOT_INSTALLED'));
    }

	public function getRatingOrders(){
		$obOrders = RatingOrderTable::getList([
			'select' => ['*'],
			'filter' => ['ID_ORDER' => $this->arParams['BG_ORDERS_ID']]
		]);

		while($arItem = $obOrders->fetch()){
			$arOrders = $arItem;
			$arOrders['ID_RATING'] = $arItem['ID'];
			$arOrders['ID'] = $arItem['ID_ORDER'];
		}


		if(!$arOrders){
			$arOrders = OrderTable::getList(array(
				'select' => ['ID'],
				'filter' => ['ID' => $this->arParams['BG_ORDERS_ID']]
			))->fetch();
		}
		
		return $arOrders;
	}

	public function changeRating($data){
		
		$res = [];
		foreach($data as $value){

			$arField = [
				'ID_ORDER' => $value['ID_ORDER'],
				'COURIER_RATING' => $value['RATING_COURIER'],
				'PACK_RATING' => $value['RATING_PACK'],
				'PRODUCT_QUALITY_RATING' => $value['RATING_PQ'],
			];

			if($value['ID_RATING']){
				$result = RatingOrderTable::update($value['ID_RATING'], $arField);
				if ($result->isSuccess()){
					$res['SUCCESS'] = 'Рейтинг '.$result->getId().' обновлен';
				}
			}else{
				$result = RatingOrderTable::add($arField);
				if ($result->isSuccess()){
					$res['SUCCESS'] = 'Рейтинг '.$result->getId().' добавлен';
				}
			}
		}
			
			
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
			echo json_encode($res);
		die();
		
		
	}

	public function executeComponent(){

		global $APPLICATION;

		$this->includeComponentLang('class.php');
		$this->checkModules();
		
		

		// $elemId = Context::getCurrent()->getRequest()->get("id_elem_edit");
		// $sectionId = Context::getCurrent()->getRequest()->get("sec");

		if($APPLICATION->GetGroupRight("bg.rating")<"K")
        {
            ShowError(Loc::getMessage("ACCESS_DENIED"));
        }
        else
        {
			$request = Context::getCurrent()->getRequest();
			if($request->isAjaxRequest()){
				$postList[] = $request->getPostList();

				$this->changeRating($postList);
			}

			$this->arResult = $this->getRatingOrders();

            $this->includeComponentTemplate();
        }
	}
	

}

?>
