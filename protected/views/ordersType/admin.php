<?php
$this->menu=array(
	array('label'=>'добавить тип', 'url'=>array('update')),
);
?>

<h1>Тип заказа</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orders-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'sys_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
