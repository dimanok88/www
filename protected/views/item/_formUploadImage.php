<h2>Загрузка фотографии</h2>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'photos-form',
	'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
    'action' => CHtml::normalizeUrl(array('imageupload', 'id' => $_GET['id'] )),
)); ?>
    
    <?php echo $form->errorSummary($imageModel); ?>

    <div class="row">
        <?php echo $form->labelEx($imageModel, 'photo'); ?>
		<?php echo $form->fileField($imageModel, 'photo'); ?>
		<?php echo $form->error($imageModel, 'photo'); ?>
    </div>

    <div class="row">
		<?php echo $form->labelEx($imageModel, 'description'); ?>
		<?php echo $form->textField($imageModel, 'description', array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($imageModel, 'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Загрузить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->