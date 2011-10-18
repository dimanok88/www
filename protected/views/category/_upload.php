<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'upload-spare-form',
	'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'file'); ?>
		<?php echo $form->fileField($model, 'file'); ?>
		<?php echo $form->error($model, 'file'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Загрузить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->