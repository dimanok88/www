<h1><?= (!empty($_GET['id'])) ? $model->login.' '.$model->email : 'Добавить'?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'percent-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля <span class="required">*</span></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model, 'password', array('value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'password_req'); ?>
		<?php echo $form->textField($model, 'password_req', array('value'=>'')); ?>
		<?php echo $form->error($model,'password_req'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model, 'role', Users::model()->AllRoles()); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->checkBox($model, 'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->