<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Обозначения'
    );
?>

<h2>Обозначения</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
	'columns'=>array(
		'oboznach',
		array(
            'name' => 'model_id',
            'filter'=> Models::model()->getModelList($type),
            'value' => '$data->getModelID("'.$type.'")',
        ),

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
)); ?>
 
