<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Диски"
    );
?>

<?= $this->renderPartial('_menu'); ?>

<h2>Диски</h2>
<?= CHtml::image('/images/disc.jpg'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discs-grid',
	'dataProvider'=>$model->discs(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'main_string',
		'price',
		'd',
		'model',
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