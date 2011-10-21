<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Разное"
    );
?>

<?= $this->renderPartial('_menu'); ?>

<h2>Разное</h2>
<?= CHtml::image('/images/sotra.jpg'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'other-grid',
	'dataProvider'=>$model->other(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'main_string',
		'price',
		'marka',
		'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList('other'),
            'value'=>'Item::model()->ModelName($data->category, "other");'
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