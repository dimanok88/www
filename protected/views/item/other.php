<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Разное"
    );
?>

<?= $this->renderPartial('_menu'); ?>

<h2>Разное</h2>

<?= CHtml::beginForm(array('item/act'));?>

<? if (Yii::app()->user->checkAccess('admin')):?>
<?= $this->renderPartial('_formAction');?>
<? endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->other(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
    'rowCssClass' =>array('odd'),
    'selectableRows'=>2,
    'template'=>"{pager}<br/>{items}{pager}",
    'rowCssClassExpression'=>'($data->new_price == "1") ? "odd select" : "odd" ',
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
                'update'=>array(
                   'label'=>'Update',
                   'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"other"))',
                   'options'=>array(  // this is the 'html' array but we specify the 'ajax' element
                     'ajax'=>array(
                       'type'=>'GET',
                       'url'=>"js:$(this).attr('href')", // ajax post will use 'url' specified above
                       'update'=>'#dial',
                       'success'=>"function( data ){
                            $('#dial').html(data);
                            $( '#edit_dialog' )
                              .dialog( { title: 'Редактировать' } )
                              .dialog( 'open' ); }",
                     ),
                   ),
                ),
            ),
        ),
	),
)); 
?>

<?= CHtml::endForm();?>