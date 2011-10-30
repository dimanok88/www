<?php
    $this->breadcrumbs = array(
        'Общий раздел' => array('item/'),
        "Предыдущий раздел" => array('item/'.$type),
        'Категории'=>array('item/category', 'type'=>$type),
        $model->model
    );
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model'); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pic'); ?>
	    <?php echo $form->fileField($model, 'pic'); ?>
	    <?php echo $form->error($model, 'pic'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'activate'); ?>
		<?php echo $form->CheckBox($model, 'activate'); ?>
		<?php echo $form->error($model,'activate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->