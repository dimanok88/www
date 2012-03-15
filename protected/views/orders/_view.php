<li>
    <?
        $item = Item::model()->getItem($data->id_item);
    ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_item')); ?>:</b>
	<?php echo $item->main_string; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
	<?php echo CHtml::encode($data->count); ?>
    <br />

    <b>Сумма: </b>

	<?php
    $price_item = $item->price*$data->count;
     echo Item::model()->getPriceOther($price_item);
    ?>
    <br />
</li>