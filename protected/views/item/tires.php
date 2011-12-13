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

<?= CHtml::beginForm(array('item/act'));?>

<? if (Yii::app()->user->checkAccess('admin')):?>
<?= $this->renderPartial('_formAction');?>
<? endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->tire(),
    'rowCssClass' =>array('odd'),
    'rowCssClassExpression'=>'($data->new_price == "1") ? "odd select" : "odd" ',
	'filter'=>$model,
    'selectableRows'=>2,
    'template'=>"{pager}<br/>{items}{pager}",
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
                   'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"tire"))',
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
                /*'update' => array
                (
                    'label'=>'Update',
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"tire"))',
                ),*/
            ),
        ),
	),
));

?>
<?= CHtml::endForm();?>