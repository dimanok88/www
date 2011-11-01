<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Типы'=>array('typeItem/index', 'type'=>$type),
    );

?>

<h1>Добавить/Изменить тип</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>