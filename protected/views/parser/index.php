<?
Yii::app()->clientScript->registerScript(
   'flash-success',
   '$(".flash-success").animate({opacity: 1.0}, 10000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>


<h2>Загрузка прайса</h2>
<div class="form">
        <?php if(Yii::app()->user->hasFlash('price')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('price'); ?>
        </div>
        <?php endif; ?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'photos-form',
	'enableAjaxValidation' => false,
        'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
    //'action' => CHtml::normalizeUrl(array('parser/csvUpload')),
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

