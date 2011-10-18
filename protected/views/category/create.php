<?php
    $this->breadcrumbs = array(
        'Категории' => array('admin'),
        'Создание категории'
    );

    $this->menu = array(
        array('label' => 'Категории', 'url' => array('admin')),
        array('label' => 'Создать категорию', 'url' => array('create')),
    );

    $this->pageTitle = "Создание категории";
?>

<h1>Создать категорию</h1>

<?php echo $this->renderPartial(
        '_form',
        array(
            'model' => $model,
            'categoryList' => $categoryList,
        )
    );
?>