<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tires-grid',
	'dataProvider'=>$list->$type($id),
    'rowCssClass' =>array('odd'),
	'filter'=>$list,
    'ajaxUpdate'=>false,
	'columns'=>array(
        'pic'=>array(
            'name'=>'pic',
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

Yii::app()->clientScript->registerScript('live_date_picker', "

    $('.items tbody tr').live({
         mouseenter: function() {
             var index = $('.odd').index(this);
             var image = $('.prev').eq(index).attr('prev');
             $('.main_pic').eq(index).show('slow').html('<img src=\"'+image+'\">');
             return false;
         },
         mouseleave: function() {
             var index = $('.odd').index(this);
             $('.main_pic').hide();
             return false;
         },

 });

");


?>


 
