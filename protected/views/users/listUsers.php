<h2>Пользователи</h2>

<?
$this->menu = array(
        array('label' => 'Добавить Пользователя', 'url' => array('users/newed')),
    );
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>2,
    //'template'=>"{pager}<br/>{items}{pager}",
    //'ajaxUpdate'=>false,
	'columns'=>array(
        'login',
        'email',
        'name',
        'role'=>array(
            'name'=>'role',
            'filter'=>$model->AllRoles(),
            'value'=>'$data->role',
        ),
        'active'=>array(
            'name'=>'active',
            'filter'=>array('1'=>'Да','0'=>'Нет'),
            'value'=>'Users::model()->getActive($data->active)',
        ),
        /*array(
           'class' => 'CCheckBoxColumn',
           'name' => 'id',
           'id'=>'item_check',
           'value'=>'$data->id',
           'checkBoxHtmlOptions'=>array('name'=>'item_check[]'),
        ),*/

		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
            'buttons'=>array
             (
                'delete' => array
                (
                    'label'=>'Удалить',
                    'url'=>'Yii::app()->createUrl("users/delete", array("id"=>$data->id))',
                ),
                'update'=>array(
                   'label'=>'Редактировать',
                   'url'=>'Yii::app()->createUrl("users/newed", array("id"=>$data->id))',
                ),
                /*'update' => array
                (
                    'label'=>'Update',
                    'url'=>'Yii::app()->createUrl("item/upnew", array("id"=>$data->id, "type"=>"tire"))',
                ),*/
            ),
        ),
	),
));

?>
