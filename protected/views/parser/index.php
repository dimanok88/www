<?
Yii::app()->clientScript->registerScript(
   'flash-success',
   '$(".flash-success").animate({opacity: 1.0}, 10000).fadeOut("slow");',
   CClientScript::POS_READY
);

$mass= array(
    '225/55 R17 Б/К HANKOOK K115 XL 101W',
    '245/50 R17 Б/К BS RE050A 99W Run Flat',
    '165/70 R13 Б/К HANKOOK K715 79T',
    '195/55 R15 Б/К HANKOOK K425 85H',
    '265/70 R18 Б/К HANKOOK RW11 @',
);

foreach($mass as $v)
{
    preg_match('!(.*)\s+(\d+[ABCDEFGJKLMNPQRSTUHVWYZ][R]?)\s?(@)?!i', $v, $res);

    if(count($res) < 3) echo $v."<br/>";
    else echo $res[1]."- ".$res[2]."<br/>";
    //CVarDumper::dump($res, 10, true);
}

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
	<?php echo CHtml::submitButton('Загрузить'); ?> <?php echo CHtml::link('Выгрузить прайс', array('parser/excelSave')); ?>
    </div>

<?php $this->endWidget(); ?>

<?if(count($file)):?>
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'pic-form',)); ?>

    <div class="row buttons">
       <?php echo CHtml::ajaxButton ("Обработать изображения",
                              CController::createUrl('parser/resizePhoto'),
                              array('update' => '#data', 'beforeSend'=>'function(){$("#data").html("Ждите...");}'), array('id'=>'uploadphoto'));
?>
    </div>

<?php $this->endWidget(); ?>

    <div id="data"></div>
<? endif;?>
</div><!-- form -->

