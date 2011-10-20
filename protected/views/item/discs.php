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