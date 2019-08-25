<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?




?>

<?
CJSCore::Init(array("jquery"));
?>
<?if($arResult['ITEM']):?>
	<div class="admin-rating">
		<h2>Рейтинг</h2>
		<div class="admin-rating__search">
			<input type="text" name="SEARCH" class="admin-rating__input-js" />
			<button class="admin_rating__button-js">Поиск</button>
		</div>
		

		<div class="admin-rating__container-js">
			<!--RestartRatingAdminBuffer-->
			<?foreach($arResult['ITEM'] as $key => $value):?>
				<div class="admin-rating__row">
					<span class="admin-rating__item"><?=$key+1?></span>
					<span class="admin-rating__item">ID заказа: <?=$value['ID_ORDER']?></span>
					<span class="admin-rating__item">Взаимодействие с курьером: <?=$value['COURIER_RATING']?></span>
					<span class="admin-rating__item">Упаковка: <?=$value['PACK_RATING']?></span>
					<span class="admin-rating__item">Качество товаров: <?=$value['PRODUCT_QUALITY_RATING']?></span>
				</div>
			<?endforeach;?>
			<!--RestartRatingAdminBuffer-->
			<?
				echo $arResult['NAV']->sNavText;	
			?>
		</div>
	</div>
	
<?else:?>
	<p>Пока не совершен не один заказ</p>
<?endif;?>
