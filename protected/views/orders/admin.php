<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	//'Manage',
);

/*$this->menu=array(
	array('label'=>'List Orders', 'url'=>array('index')),
	array('label'=>'Create Orders', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('orders-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Все заказы</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orders-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'id',
		'id_user'=>array(
            'name'=>'id_user',
            'filter'=> Users::model()->AllUsers(),
            'value'=>'Users::model()->getUser($data->id_user)',
        ),
		'id_moderator'=>array(
            'name'=>'id_moderator',
            'filter'=> Users::model()->AllModer(),
            'value'=>'Users::model()->getUser($data->id_moderator)',
        ),
		'date_add'=>array(
            'name'=>'date_add',
            'value'=>'Users::model()->getDate($data->date_add)',
        ),
		'type'=>array(
            'filter'=>OrdersType::model()->AllTypeOrd(),
            'name'=>'type',
            'value'=>'OrdersType::model()->getTypeOrd($data->type)',
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
