<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model'); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'file_pic'); ?>
		<?php echo $form->FileField($model,'file_pic'); ?>
		<?php echo $form->error($model,'file_pic'); ?>
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