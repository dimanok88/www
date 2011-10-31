<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Проценты'=>array('percent/index', 'type'=>$type),
        (!empty($_GET['id'])) ? $model->percent.' - '.$model->type_item : 'Добавить'
    );
?>

<h1><?= (!empty($_GET['id'])) ? $model->percent.' - '.$model->type_item : 'Добавить'?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>