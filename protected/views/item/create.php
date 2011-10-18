<?php
    $this->breadcrumbs = array(
        'Позиции' => array('admin'),
        'Добавление позиции'
    );

    $this->menu = array(
        array('label' => 'Элементы каталога', 'url' => array('admin')),
        array('label' => 'Добавить позицию', 'url' => array('create')),
    );

    $this->pageTitle = "Добавление позиции";
?>

<h1>Добавить позиции</h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model' => $model,
        'categoryList' => $categoryList,
    )
); ?>