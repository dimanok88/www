<?php
    $this->breadcrumbs = array(
        'Категории' => array('admin'),
        "Изменение категории {$model->name}"
    );

    $this->menu = array(
        array('label' => 'Категории', 'url' => array('admin')),
        array('label' => 'Создать категорию', 'url' => array('create')),
    );

    $this->pageTitle = "Редактирование категории: {$model->name}";
?>

<h1>Редактирование категории <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial(
        '_form',
        array(
            'model' => $model,
            'showParentCategory' => $showParentCategory,
        )
    );
?>