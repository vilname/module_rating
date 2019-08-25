<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult):?>
	<div class="rating">
		<div class="rating__success-answer"></div>
		<form id="rating__form" name="RATING_NAME">
			<?//foreach($arResult['ITEMS'] as $arItem):?>
			<div class="rating__row rating__row-indent">
				<span class="rating__item">
					ID заказа: <?=$arResult['ID']?>
				</span>
				<span class="rating__courier-container rating_item">
					<label for="rating__courier">Взаимодействие с курьером</label>
					<select name="RATING_COURIER">
						<?for($i=1; $i<=5; $i++):?>
							<option 
								value="<?=$i?>"
								<?=$arResult['COURIER_RATING'] == $i ? 'selected' : '' ?>
							><?=$i?> балл(а|ов)</option>
						<?endfor;?>
					</select>
				</span>
				<span class="rating__pack-container rating_item">
					<label for="rating__pack">Упаковка</label>
					<select name="RATING_PACK">
						<?for($i=1; $i<=5; $i++):?>
							<option 
								value="<?=$i?>"
								<?=$arResult['PACK_RATING'] == $i ? 'selected' : '' ?>
							><?=$i?> балл(а|ов)</option>
						<?endfor;?>
					</select>
				</span>
				<span class="rating__pq-container rating_item">
					<label for="rating__pq">Качество товаров</label>
					<select name="RATING_PQ">
						<?for($i=1; $i<=5; $i++):?>
							<option 
								value="<?=$i?>"
								<?=$arResult['PRODUCT_QUALITY_RATING'] == $i ? 'selected' : '' ?>
							><?=$i?> балл(а|ов)</option>
						<?endfor;?>
					</select>
				</span>
				<input type="hidden" name="ID_ORDER" value="<?=$arResult['ID']?>" />
				<input type="hidden" name="ID_RATING" value="<?=$arResult['ID_RATING']?>" />
			</div>
			<?//endforeach;?>

			<input type="submit" class="rating__submit" value="Отправить" />
		</form>
	</div>
	
<?else:?>
	<p>Пока не совершен не один заказ</p>
<?endif;?>
