<?php
$tabs = array();
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

<?php
$per = Percent::model()->getTypePerc();

 foreach($t_p as $k=>$v){
    $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>$v));
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider[$k],
            'itemView'=>'_view',
            'id'=>'percent',
            'viewData'=>array('per'=>$per, 'type'=>$type),
            'ajaxUpdate'=>true,
            'itemsTagName' => 'ul',
            'itemsCssClass' =>'percent',
            /*'sortableAttributes'=>array(
                    'percent',
                    'type_item',
                    'type_percent',
         ),*/));
    $this->endWidget();
    //print_r($this->clips);
    $tabs = $this->clips;
 }


$this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs'=>$tabs,
        // additional javascript options for the tabs plugin
        'options'=>array(
            'collapsible'=>true,
        ),
    ));
 ?>
