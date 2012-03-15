<?php
    $this->breadcrumbs = array(
        'Категории'
    );

    $this->menu = array(
        array('label' => 'Категории', 'url' => array('admin')),
        array('label' => 'Создать категорию', 'url' => array('create')),
        array('label' => 'Обновить прайс-лист', 'url' => array('upload')),
    );

    $this->pageTitle = "Управление категориями";
?>

<h1>Управление категориями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'category-grid',
	'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'Название',
            'name' => 'name',
            'value' => '$data["name"]',
            'type' => 'html',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
            'deleteButtonUrl' => 'CHtml::normalizeUrl(array("delete", "id" => $data["id"]))',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id" => $data["id"]))',
        ),
    )
)); ?>
