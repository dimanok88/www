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
