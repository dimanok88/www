<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>$type.'s-grid',
	'dataProvider'=>$list->$type($id),
	'filter'=>$list,
	'columns'=>array(
        'id',
		'main_string',
		'price',
		'marka',
		'active',

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
)); ?>
 
