<h2>Пользователи</h2>

<?
$this->menu = array(
        array('label' => 'Добавить Пользователя', 'url' => array('users/newed')),
    );
?>


<?
// конфиурация для autocomplete
$autocompleteConfig = array(
    'model'=>$model, // модель
    'name'=>'term',
    // "источник" данных для выборки
    // может быть url, который возвращает JSON, массив
    // или функция JS('js: alert("Hello!");')
    'source' =>Yii::app()->createUrl('ajax/autocomplete'),
    // параметры, подробнее можно посмотреть на сайте
    // http://jqueryui.com/demos/autocomplete/
    'options'=>array(
        // минимальное кол-во символов, после которого начнется поиск
        'minLength'=>'2',
        'showAnim'=>'fold',
        // обработчик события, выбор пункта из списка
        'select' =>'js: function(event, ui) {
            // действие по умолчанию, значение текстового поля
            // устанавливается в значение выбранного пункта
            this.value = ui.item.label;
            // устанавливаем значения скрытого поля
            $("#ids").val(ui.item.id);
            return false;
        }',
    ),
    'htmlOptions' => array(
        'maxlength'=>50,
    ),
);
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'order-form',
)); ?>
<div class="row">
    <?php echo $form->label($model,'name'); ?>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', $autocompleteConfig); ?>
    <?php echo CHtml::hiddenField('ids'); ?>
</div>
<?php $this->endWidget(); ?>

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
