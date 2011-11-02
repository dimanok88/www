<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Проценты',
    );

$this->menu=array(
	array('label'=>'Добавить проценты', 'url'=>array('create', 'type'=>$type)),
);
?>

<h1>Проценты</h1>

    <?php if(Yii::app()->user->hasFlash('addpercent')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('addpercent'); ?>
        </div>
    <?php endif; ?>

    <div>Выделенные цветом элементы - элементы по умолчанию</div>

<?php
$per = Percent::model()->getTypePerc();
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'id'=>'percent',
    'viewData'=>array('per'=>$per),
    'ajaxUpdate'=>true,
    'itemsTagName' => 'ul',
    'itemsCssClass' =>'percent',
    'sortableAttributes'=>array(
            'percent',
            'type_item',
            'type_percent',
    ),

)); ?>

<script>
    $(".flash-success").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $(".flash-error").animate({opacity: 1.0}, 5000).fadeOut("slow");
</script>