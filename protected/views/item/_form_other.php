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
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->dropDownList($model, 'category', Models::model()->getModelList($type), array('empty'=>'-')); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'main_string'); ?>
		<?php echo $form->textField($model,'main_string', array('size'=>'40')); ?>
		<?php echo $form->error($model,'main_string'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'marka'); ?>
		<?php echo $form->textField($model,'marka'); ?>
		<?php echo $form->error($model,'marka'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'descript'); ?>
		<?php echo $form->textField($model,'descript'); ?>
		<?php echo $form->error($model,'descript'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pictures'); ?>
	    <?php echo $form->fileField($model, 'pictures'); ?>
	    <?php echo $form->error($model, 'pictures'); ?>
    </div>

    <div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'type_item'); ?>
		<?php echo $form->textField($model,'type_item'); ?>
		<?php echo $form->error($model,'type_item'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->CheckBox($model, 'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->