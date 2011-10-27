<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Категории'
    );
?>

<?= $this->renderPartial('_menu_category', array('type'=>$type)); ?>
<h2>Категории</h2>

    <?php if(Yii::app()->user->hasFlash('addcategory')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('addcategory'); ?>
        </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->hasFlash('deletecategory')): ?>
            <div class="flash-error">
                <?php echo Yii::app()->user->getFlash('deletecategory'); ?>
            </div>
    <?php endif; ?>

<ul id="category_list">
<? $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$category,
    'itemView'=>'_category',   // refers to the partial view named '_post'
    'sortableAttributes'=>array(
        'model',
    ),
    'viewData'=>array(
        'type'=>$type,
    ),
));
?>
</ul>

<script>
    $(".flash-success").animate({opacity: 1.0}, 5000).fadeOut("slow");
    $(".flash-error").animate({opacity: 1.0}, 5000).fadeOut("slow");
</script>
