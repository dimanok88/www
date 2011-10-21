<h2>Обозначения</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discs-grid',
	'dataProvider'=>$model->$type(),
	'filter'=>$model,
	'columns'=>array(
		'oboznach',
		'model_id',

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
)); ?>
 
