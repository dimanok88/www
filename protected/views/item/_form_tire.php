<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
    'action'=>NULL,
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
		<?php echo $form->labelEx($model,'d'); ?>
		<?php echo $form->textField($model,'d'); ?>
		<?php echo $form->error($model,'d'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'hw'); ?>
		<?php echo $form->textField($model,'hw'); ?>
		<?php echo $form->error($model,'hw'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'w'); ?>
		<?php echo $form->textField($model,'w'); ?>
		<?php echo $form->error($model,'w'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pictures'); ?>
	    <?php echo $form->fileField($model, 'pictures'); ?>
	    <?php echo $form->error($model, 'pictures'); ?>
        <?= Item::model()->getPic($model->id); ?>
    </div>

    <div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'type_item'); ?>
		<?php echo $form->dropDownList($model, 'type_item', Item::model()->getTypeItem($type)); ?>
		<?php echo $form->error($model,'type_item'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'season'); ?>
		<?php echo $form->dropDownList($model, 'season', Item::model()->SeasonList()); ?>
		<?php echo $form->error($model,'season'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'shipi'); ?>
		<?php echo $form->CheckBox($model, 'shipi'); ?>
		<?php echo $form->error($model,'shipi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->CheckBox($model, 'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

    <?= CHtml::hiddenField('referrer', Yii::app()->request->urlReferrer);?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->