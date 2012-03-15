<?php
    $this->breadcrumbs = array(
        'Категории' => array('admin'),
        'Обновление из прайс-листа',
    );

    $this->menu = array(
        array('label' => 'Категории', 'url' => array('admin')),
        array('label' => 'Создать категорию', 'url' => array('create')),
        array('label' => 'Обновить прайс-лист', 'url' => array('upload')),
    );

    $this->menu = array(
        array('label' => 'Прайс', 'url' => array('admin')),
    );

    if( !empty($option->value) )
    {
        array_push($this->menu,
            array(
                'label' => 'Удалить прайс',
                'url' => array('delete'),
            )
        );
    }

    $this->pageTitle = "Обновление из прайс-листа";
?>

<h1>Обновление из прайс-листа</h1>

<?php echo $this->renderPartial(
        '_upload',
        array(
            'model' => $model,
        )
    );
?>