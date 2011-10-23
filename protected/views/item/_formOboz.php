<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'oboznach-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'oboznach'); ?>
		<?php echo $form->textField($model,'oboznach',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'oboznach'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model_id'); ?>
		<?php echo $form->dropDownList($model, 'model_id', Models::model()->getModelList($type), array('empty'=>'-')); ?>
		<?php echo $form->error($model,'model_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

 
