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
		'pic'=>array(
            'name'=>'pic',
            'type'=>'raw',
            'filter'=>false,
            'value'=>'Item::model()->getPic($data->id)',
        ),
		'main_string',
        'type_item'=>array(
            'name'=>'type_item',
            'filter'=> Item::model()->getTypeItem('other'),
            'value'=>'Item::model()->getTIA("other", $data->type_item)'
        ),
		'marka',
		'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList('other'),
            'value'=>'Item::model()->ModelName($data->category, "other");'
        ),
		'price',
        array(
            'header'=>'Цена, опт',
            'value'=>'Percent::model()->getPercent("other",$data->type_item, "opt", $data->price)',
        ),
        array(
            'header'=>'Цена, VIP',
            'value'=>'Percent::model()->getPercent("other",$data->type_item, "vip", $data->price)',
        ),
        array(
            'header'=>'Цена, роз',
            'value'=>'Percent::model()->getPercent("other",$data->type_item, "roz", $data->price)',
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
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"other"))',
                ),
            ),
        ),
	),
)); ?>