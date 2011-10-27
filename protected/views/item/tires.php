<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Шины"
    );
?>

<?= $this->renderPartial('_menu'); ?>

<h2>Шины</h2>
<?= CHtml::image('/images/shini.png'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tires-grid',
	'dataProvider'=>$model->tire(),
	'filter'=>$model,
	'columns'=>array(
        'w',
        'hw',
        'd',
        'model',
        'type_item',
        'season',
        'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList('tire'),
            'value'=>'Item::model()->ModelName($data->category, "tire");'
        ),
		'main_string',
		'price',
        
		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
)); ?>