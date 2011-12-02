<?php
$t = Item::model()->getTypeList();
echo $t['tire'];
$this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Шины"
    );
?>

<?= $this->renderPartial('_menu'); ?>

<h2>Шины</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tires-grid',
	'dataProvider'=>$model->tire(),
    'rowCssClass' =>array('odd'),
    'rowCssClassExpression'=>'($data->new_price == "1") ? "odd select" : "odd" ',
	'filter'=>$model,
    'selectableRows'=>2,
    'ajaxUpdate'=>false,
	'columns'=>array(
        'pic'=>array(
            'name'=>'pictures',
            'type'=>'raw',
            'filter'=>false,
            'value'=>'Item::model()->getPic($data->id)',
            'htmlOptions'=>array('style'=>'text-align:center !important'),
        ),
        'w',
        'hw',
        'd',
        'model',
        'type_item'=>array(
            'name'=>'type_item',
            'filter'=> Item::model()->getTypeItem('tire'),
            'value'=>'Item::model()->getTIA("tire", $data->type_item)'
        ),
        'season'=>array(
            'name'=>'season',
            'filter'=> Item::model()->SeasonList(),
            'value'=>'Item::model()->getSeason($data->season)'
        ),
        'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList('tire'),
            'value'=>'Item::model()->ModelName($data->category, "tire");'
        ),
		'main_string',
		'price',
        array(
            'header'=>'Цена, VIP',
            'value'=>'Percent::model()->getPercent("tire",$data->type_item, "vip", $data->price)',
        ),
        array(
            'header'=>'Цена, Опт',
            'value'=>'Percent::model()->getPercent("tire",$data->type_item, "opt", $data->price)',
        ),
        array(
            'header'=>'Цена, Роз',
            'value'=>'Percent::model()->getPercent("tire",$data->type_item, "roz", $data->price)',
        ),
        'country',
        'pic',
        'link'=>array(
            'name'=>'link',
            'type'=>'raw',
            'value'=>'CHtml::link($data->link,$data->link, array("target"=>"_blank"))',
        ),
        array(
           'name' => 'id',
           'class' => 'CCheckBoxColumn',
           'value'=>'$data->id',
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
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"tire"))',
                ),
            ),
        ),
	),
));

?>