<h1>Корзина</h1>

<? if($items->itemCount >0 ){?>
<div>
    <?= CHtml::form();?>
    <div class="row button-column">
        <?= CHtml::submitButton('Обновить');?>
    </div>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'orders-grid',
        'dataProvider'=>$items,
        //'filter'=>$model,
        'columns'=>array(
            'id'=>array(
                'header'=>'Номер товара',
                'name'=>'id',
            ),
            'string'=>array(
                'header'=>'Товар',
                'name'=>'string',
            ),
            /*'type'=>array(
                'header'=>'Тип',
                'name'=>'type',
            ),*/
            'count'=>array(
                'header'=>'Количество',
                'name'=>'count',
                'type'=>'raw',
                'value'=>'Orders::model()->countRefresh($data["count"], $data["id"])'
            ),
            'price'=>array(
                'header'=>'Цена за шт.',
                'name'=>'price',
                'value'=>'Item::model()->getPriceOther($data["price"])'
            ),
            'summ'=>array(
                'header'=>'Общая сумма',
                'name'=>'summ',
                'value'=>'Item::model()->getPriceOther($data["summ"])',
                'footer'=>'Итого: '.Item::model()->getPriceOther(Yii::app()->shoppingCart->getCost()),
            ),

            array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{delete}',
            'deleteButtonUrl'=>'Yii::app()->createUrl("/orders/deleteOrd", array("id" => $data[\'id\'], "type"=>$data["type"]))',
            ),
        ),
    )); ?>
    <div class="row button-column">
        <?= CHtml::submitButton('Обновить');?>
    </div>
<?= CHtml::endForm();?>
<br/><br/>
    <div id=new_user>

    <?= CHtml::Form(array('orders/add'));?>
        <?= CHtml::dropDownList('users', '',Users::model()->AllUsers()); ?>
        <?= CHtml::submitButton('Оформить заказ');?>
    <?= CHtml::endForm();?>

        <br/><br/>
    <?
    $this->renderPartial('application.views.users.newed', array('model'=>$userModel))
    ?>
    </div>
</div>
<?} else{?>
    <div>Корзина пуста!</div>
<?}?>
