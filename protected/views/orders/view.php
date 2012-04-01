
<h1>Номер заказа <?php echo $order->id; ?></h1>
    <div class="total_summ">
        <div style="float: right;">
            <?= CHtml::link('Водитель', "Javascript:void()",
                            array('onClick'=>"window.open('".Yii::app()->createUrl('orders/schet', array('order'=>$order->id, 'type_price'=>$type_price))."', 'popup', 'toolbar=0, scrollbars=1, width=800, height=600')"))?><br/>
            <?= CHtml::link('Клиент', "Javascript:void()",
                            array('onClick'=>"window.open('".Yii::app()->createUrl('orders/client', array('order'=>$order->id, 'type_price'=>$type_price))."', 'popup', 'toolbar=0, scrollbars=1, width=800, height=600')"))?><br/>
            <?= CHtml::link('Чек', "Javascript:void()",
                            array('onClick'=>"window.open('".Yii::app()->createUrl('orders/chek', array('order'=>$order->id, 'type_price'=>$type_price))."', 'popup', 'toolbar=0, scrollbars=1, width=800, height=600')"))?>
        </div>
        
        <b>Итого: </b> <?= Orders::model()->Summ($order->id, true, $type_price); ?><br/>
        <b>Получатель:</b> <?= Users::model()->getUser($order->id_user)?>
        <div class="clear"></div>
    </div>
<?
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
            'viewData'=>array('type_price'=>$type_price),
            'id'=>'oders',
            'ajaxUpdate'=>true,
            'itemsTagName' => 'ul',
            'itemsCssClass' =>'orders',));
?>
