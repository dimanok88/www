<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'items-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>
    
    <h2>Параметры</h2>

    <div class="row">
		<?php echo $form->labelEx($model,'vendor'); ?>
		<?php echo $form->textField($model,'vendor',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'vendor'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'brand'); ?>
		<?php echo $form->textField($model,'brand',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'brand'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'typename'); ?>
		<?php echo $form->textField($model,'typename',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'typename'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'et'); ?>
		<?php echo $form->textField($model,'et',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'et'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'dia'); ?>
		<?php echo $form->textField($model,'dia',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'dia'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'pcd'); ?>
		<?php echo $form->textField($model,'pcd',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pcd'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'d'); ?>
		<?php echo $form->textField($model,'d',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'d'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'season'); ?>
		<?php echo $form->textField($model,'season',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'season'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'w'); ?>
		<?php echo $form->textField($model,'w',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'w'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'hw'); ?>
		<?php echo $form->textField($model,'hw',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hw'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'indg'); ?>
		<?php echo $form->textField($model,'indg',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'indg'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'indv'); ?>
		<?php echo $form->textField($model,'indv',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'indv'); ?>
	</div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->