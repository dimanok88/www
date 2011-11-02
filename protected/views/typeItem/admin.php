<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Типы',
    );

$this->menu=array(
	array('label'=>'Добавить тип', 'url'=>array('create', 'type'=>$type)),
);
?>

<h1>Типы</h1>

    <?php if(Yii::app()->user->hasFlash('addtype')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('addtype'); ?>
        </div>
    <?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'type-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'title',
		array(
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons'=>array
             (
                'delete' => array
                (
                    'label'=>'Delete',
                    'url'=>'Yii::app()->createUrl("typeItem/delete", array("id"=>$data->id))',
                ),
                'update' => array
                (
                    'label'=>'Update',
                    'url'=>'Yii::app()->createUrl("typeItem/create", array("id"=>$data->id, "type"=>"'.$type.'"))',
                ),
            ),
		),
	),
)); ?>

<script>
    $(".flash-success").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $(".flash-error").animate({opacity: 1.0}, 5000).fadeOut("slow");
</script>
