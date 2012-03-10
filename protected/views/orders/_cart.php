<? if (Yii::app()->shoppingCart->getItemsCount() > 0): ?>
 	Количество товаров: <?= Yii::app()->shoppingCart->getItemsCount();?><br/>
 	Общая сумма: <?= Yii::app()->shoppingCart->getCost();?><br/>
	<?= CHtml::Link('Очистить корзину', '',
		array('onClick'=>CHtml::ajax(array(
                        'url'=>array('orders/removeCart'),
                        'update'=>"#cart")
  				      ), 'style'=>"cursor:pointer;"
  			  )
	); ?>
<? else:?>
	<div>В корзине пусто!</div>
<?endif;?>