<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>$type.'s-grid',
	'dataProvider'=>$list->$type($id),
	'filter'=>$list,
	'columns'=>array(
        'pic'=>array(
            'name'=>'pic',
            'type'=>'raw',
            'filter'=>false,
            'value'=>'Item::model()->getPic($data->id)',
        ),
		'main_string',
        'type_item'=>array(
            'name'=>'type_item',
            'filter'=> Item::model()->getTypeItem($type),
            'value'=>'Item::model()->getTIA("'.$type.'", $data->type_item)'
        ),
		'marka',
		'price',
        array(
            'header'=>'Цена, опт',
            'value'=>'Percent::model()->getPercent("'.$type.'",$data->type_item, "opt", $data->price)',
        ),
        array(
            'header'=>'Цена, VIP',
            'value'=>'Percent::model()->getPercent("'.$type.'",$data->type_item, "vip", $data->price)',
        ),
        array(
            'header'=>'Цена, роз',
            'value'=>'Percent::model()->getPercent("'.$type.'",$data->type_item, "roz", $data->price)',
        ),

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
            'buttons'=>array
             (
                'delete' => array
                (
                    'label'=>'Delete',
                    'url'=>'Yii::app()->createUrl("item/delete", array("id"=>$data->id))',
                ),
                'update' => array
                (
                    'label'=>'Update',
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"'.$type.'"))',
                ),
            ),
        ),
	),
)); ?>
 
