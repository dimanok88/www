
<h1>Номер заказа <?php echo $order->id; ?></h1>
    <div class="total_summ">
        <div style="float: right;">
            <?= CHtml::link('Счет', "Javascript:void()",
                            array('onClick'=>"window.open('".Yii::app()->createUrl('orders/schet', array('order'=>$order->id))."', 'popup', 'toolbar=0, scrollbars=1, width=640, height=600')"))?><br/>
            <?= CHtml::link('Накладная', "Javascript:void()",
                            array('onClick'=>"window.open('".Yii::app()->createUrl('orders/naklad', array('order'=>$order->id))."', 'popup', 'toolbar=0, scrollbars=1, width=640, height=600')"))?>
        </div>
        
        <b>Итого: </b> <?= Orders::model()->Summ($order->id, true); ?><br/>
        <b>Получатель:</b> <?= Users::model()->getUser($order->id_user)?>
    </div>
<?
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
            'id'=>'oders',
            'ajaxUpdate'=>true,
            'itemsTagName' => 'ul',
            'itemsCssClass' =>'orders',));
?>
