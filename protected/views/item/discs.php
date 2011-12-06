<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Диски"
    );
?>

<?= $this->renderPartial('_menu'); ?>

<h2>Диски</h2>

<?= CHtml::beginForm(array('item/act'));?>

<? if (Yii::app()->user->checkAccess('admin')):?>
<?= $this->renderPartial('_formAction');?>
<? endif; ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->disc(),
	'rowCssClass' =>array('odd'),
    'rowCssClassExpression'=>'($data->new_price == "1") ? "odd select" : "odd" ',
	'filter'=>$model,
    'ajaxUpdate'=>false,
    'selectableRows'=>2,
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
            'filter'=> Item::model()->getTypeItem('disc'),
            'value'=>'Item::model()->getTIA("disc", $data->type_item)'
        ),
        'category'=>array(
            'name'=>'category',
            'filter'=> Models::model()->getModelList('disc'),
            'value'=>'Item::model()->ModelName($data->category, "disc");'
        ),
        'main_string',
		'price',
        array(
            'header'=>'Цена, VIP',
            'value'=>'Percent::model()->getPercent("disc",$data->type_item, "vip", $data->price)',
        ),
        array(
            'header'=>'Цена, Опт',
            'value'=>'Percent::model()->getPercent("disc",$data->type_item, "opt", $data->price)',
        ),
        array(
            'header'=>'Цена, Роз',
            'value'=>'Percent::model()->getPercent("disc" ,$data->type_item, "roz", $data->price)',
        ),
        'country',
        'pic',
        'link'=>array(
            'name'=>'link',
            'type'=>'raw',
            'value'=>'Item::model()->getLink($data->link)',
        ),
        array(
           'class' => 'CCheckBoxColumn',
           'name' => 'id',
           'id'=>'item_check',
           'value'=>'$data->id',
           'checkBoxHtmlOptions'=>array('name'=>'item_check[]'),
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
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"disc"))',
                ),
            ),
        ),
	),
)); ?>

<?= CHtml::endForm();?>