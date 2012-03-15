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
    <br/>
    <?= CHtml::link('В корзину', array('orders/cart'));?>
<? else:?>
	<div>В корзине пусто!</div>
<?endif;?>

