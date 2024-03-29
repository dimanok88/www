<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'percent-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля <span class="required">*</span></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'percent'); ?>
		<?php echo $form->textField($model,'percent'); ?>
		<?php echo $form->error($model,'percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_item'); ?>
		<?php echo $form->dropDownList($model, 'type_item', Item::model()->getTypeItem($type)); ?>
		<?php echo $form->error($model,'type_item'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'type_percent'); ?>
		<?php echo $form->dropDownList($model, 'type_percent', $model->getTypePerc()); ?>
		<?php echo $form->error($model,'type_percent'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'ot'); ?>
		<?php echo $form->textField($model, 'ot'); ?>
		<?php echo $form->error($model,'ot'); ?>

        <?php echo $form->labelEx($model,'do'); ?>
		<?php echo $form->textField($model, 'do'); ?>
		<?php echo $form->error($model,'do'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->