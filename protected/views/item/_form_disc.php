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

    <table>
    <tr>
    <td>
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
		<?php echo $form->textField($model,'main_string', array('size'=>'60')); ?>
		<?php echo $form->error($model,'main_string'); ?>
	</div>
    </td>

    <td>
    <div class="row">
		<?php echo $form->labelEx($model,'d'); ?>
		<?php echo $form->textField($model,'d'); ?>
		<?php echo $form->error($model,'d'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'vilet'); ?>
		<?php echo $form->textField($model,'vilet'); ?>
		<?php echo $form->error($model,'vilet'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'w'); ?>
		<?php echo $form->textField($model,'w'); ?>
		<?php echo $form->error($model,'w'); ?>
	</div>
    </td>
    </tr>

    <tr>
    <td>
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
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo $form->textField($model, 'pic'); ?>
		<?php echo $form->error($model,'pic'); ?>
	</div>

    </td>

    <td>
    <div class="row">
		<?php echo $form->labelEx($model,'stupica'); ?>
		<?php echo $form->textField($model,'stupica'); ?>
		<?php echo $form->error($model,'stupica'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'krepezh'); ?>
		<?php echo $form->textField($model,'krepezh'); ?>
		<?php echo $form->error($model,'krepezh'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'color'); ?>
		<?php echo $form->textField($model,'color'); ?>
		<?php echo $form->error($model,'color'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link'); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->CheckBox($model, 'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>
    </td>
    </tr>
    </table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->