<?php
    $this->breadcrumbs = array(
        'Позиции' => array('admin'),
        'Изменение ' . $model->name,
    );

    $this->menu = array(
        array('label' => 'Позиции', 'url' => array('admin')),
        array('label' => 'Добавить позиции', 'url' => array('create')),
        array('label' => 'Удалить элемент', 'url' => array('delete', 'id' => $model->id)),
    );

    $this->pageTitle = "Редактирование элемента каталога: {$model->name}";
?>

<h1>Изменить элемент каталога: <?php echo $model->name; ?></h1>

<?php
    $this->widget(
        'CTabView',
        array(
            'tabs' => array(
                'tab1' => array(
                    'title' => 'Описание',
                    'view' => '_form',
                    'data' => array(
                        'model' => $model,
                        'categoryList' => $categoryList,                        
                    ),
                ),
                'tab2' => array(
                    'title' => 'Изображения',
                    'view' => 'images',
                    'data' => array(
                        'imageList' => $imageList,
                    )
                ),
                'tab3' => array(
                    'title' => 'Загрузить изображение',
                    'view' => '_formUploadImage',
                    'data' => array(
                        'imageModel' => $imageModel,
                    )
                ),
            ),
            'activeTab' => $tab,
        )
);?>