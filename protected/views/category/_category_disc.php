<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>$type.'s-grid',
	'dataProvider'=>$list->$type($id),
	'filter'=>$list,
    'ajaxUpdate'=>false,
    'rowCssClass' =>array('odd'),
    'rowCssClassExpression'=>'($data->new_price == "1") ? "odd select" : "odd" ',
	'columns'=>array(
        'pic'=>array(
            'name'=>'pic',
            'type'=>'raw',
            'filter'=>false,
            'value'=>'Item::model()->getPic($data->id)',
        ),
        'w',
        'd',
        'vilet',
        'stupica',
        'krepezh',
        'model',
        'color',
        'type_item'=>array(
            'name'=>'type_item',
            'filter'=> Item::model()->getTypeItem($type),
            'value'=>'Item::model()->getTIA("'.$type.'", $data->type_item)'
        ),
		'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList($type),
            'value'=>'Item::model()->ModelName($data->category, "'.$type.'");'
        ),
        'main_string',
		'price',
        array(
            'header'=>'Цена, VIP',
            'value'=>'Percent::model()->getPercent("'.$type.'",$data->type_item, "vip", $data->price)',
        ),
        array(
            'header'=>'Цена, Опт',
            'value'=>'Percent::model()->getPercent("'.$type.'",$data->type_item, "opt", $data->price)',
        ),
        array(
            'header'=>'Цена, Роз',
            'value'=>'Percent::model()->getPercent("'.$type.'" ,$data->type_item, "roz", $data->price)',
        ),
        'country',
        'pic',
        'link'=>array(
            'name'=>'link',
            'type'=>'raw',
            'value'=>'CHtml::link($data->link,$data->link, array("target"=>"_blank"))',
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
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"'.$type.'", "model_id"=>'.$_GET['id'].'))',
                ),
            ),
        ),
	),
)); ?>
 
