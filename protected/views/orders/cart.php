<h1>Корзина</h1>

<div>
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
            'type'=>array(
                'header'=>'Тип',
                'name'=>'type',
            ),
            'count'=>array(
                'header'=>'Количество',
                'name'=>'count',
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
                'footer'=>'Итого: '.Yii::app()->shoppingCart->getCost(),
            ),

            array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{delete}',
            'deleteButtonUrl'=>'Yii::app()->createUrl("/orders/deleteOrd", array("id" => $data[\'id\'], "type"=>$data["type"]))',
            ),
        ),
    )); ?>

</div>
