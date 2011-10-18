<?php
    $this->breadcrumbs = array(
        'Позиции'
    );

    $this->menu = array(
        array('label' => 'Позиции', 'url' => array('admin')),
        array('label' => 'Добавить позицию', 'url' => array('create')),
    );

    $this->pageTitle = "Управление позициями";
?>

<h1>Управление позициями</h1>

<p>
    Для фильтрации позиций можно применять символы <b>&gt;</b>, <b>&lt;</b>, <b>&lt;=</b>, <b>&gt;=</b>, <b>=</b>. Например: если ввести в поле <b>Фасовка</b> строку <b>=10</b>, то отобразятся все позиции фасовка, которых равно 10.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'items-grid',
	'dataProvider' => $items->search(),
    'filter' => $items,
	'columns'=>array(
		'id',
        array(
            'name' => 'type',
            'filter' => Item::model()->getTypeList(),
            'value' => '$data->getTypeName()',
        ),
		'name',
        array(
            'header' => 'Цена, руб.',
            'name' => 'cost',
            'value' => 'number_format($data->cost, 2, ",", " ")',
        ),
		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
)); ?>
