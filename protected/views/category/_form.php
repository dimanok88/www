<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
    
    <?php if( isset($showParentCategory) && $showParentCategory == false ): ?>
        <?php echo $form->hiddenField($model, 'parent'); ?>
    <?php else: ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'parent'); ?>
            <?php echo $form->dropDownList($model, 'parent', $categoryList, array('encode'=>false)); ?>
            <?php echo $form->error($model, 'parent'); ?>
        </div>
    <?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
