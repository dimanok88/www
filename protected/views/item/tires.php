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
	'dataProvider'=>$model->tires(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'main_string',
		'price',
		'd',
		'season',
        'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList('tire'),
            'value'=>'Item::model()->ModelName($data->category, "tire");'
        ),
		//'password',	
		//'date_birthday',
		'active',

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
)); ?>