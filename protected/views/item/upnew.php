<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        $model->main_string,
    );
?>

<?= $this->renderPartial('_form_'.$type, array('model'=>$model, 'type'=>$type)); ?>