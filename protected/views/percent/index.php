<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Проценты',
    );

$this->menu=array(
	array('label'=>'Добавить проценты', 'url'=>array('create', 'type'=>$type)),
);
?>

<h1>Проценты</h1>

<div>Выделенные элементы являются элементами по умолчанию</div>
<?php
$per = Percent::model()->getTypePerc();
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'id'=>'percent',
    'viewData'=>array('per'=>$per),
    'ajaxUpdate'=>true,
    'itemsTagName' => 'ul',
    'itemsCssClass' =>'percent',
    'sortableAttributes'=>array(
            'percent',
            'type_item',
            'type_percent',
    ),

)); ?>
