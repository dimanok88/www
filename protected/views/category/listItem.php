<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Категории'=>array('item/category', 'type'=>$type),
        $nameModel
    );
?>

<h2><?= $nameModel; ?></h2>

<?= CHtml::image('/images/picmodel/'.$id."_big.jpg");?>

<?= $this->renderPartial('_category_'.$type, array('id'=>$id, 'list'=>$list, 'type'=>$type)); ?>