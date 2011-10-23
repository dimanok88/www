<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Обозначения'
    );
?>

<?= $this->renderPartial('_menu_oboznach', array('type'=>$type)); ?>
<h2>Обозначения</h2>

    <?php if(Yii::app()->user->hasFlash('addoboz')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('addoboz'); ?>
        </div>
    <?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
	'columns'=>array(
		'oboznach',
		array(
            'name' => 'model_id',
            'filter'=> Models::model()->getModelList($type),
            'value' => '$data->getModelID("'.$type.'")',
        ),

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
            'buttons'=>array(
                'update' => array(
                    'label'=>'update',     // text label of the button
                    'url'=>'Yii::app()->createUrl("item/addOboznach", array("id"=>$data->id, "type"=>"'.$type.'"))',       // a PHP expression for generating the URL of the button
                ),
                'delete' => array(
                    'label'=>'delete',     // text label of the button
                    'url'=>'Yii::app()->createUrl("item/deleteOboznach", array("id"=>$data->id))',
                ),
            ),
        ),
	),
)); ?>
 
