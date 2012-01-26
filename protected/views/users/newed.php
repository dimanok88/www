<?php $this->widget('application.extensions.email.Debug'); ?>

<h1><?= (!empty($_GET['id'])) ? $model->login.' '.$model->email : 'Добавить пользователя'?></h1>

<div class="form">
<? if(!empty($_GET['id'])):?>
    <div class="flash-notice">
         Чтобы сменить пароль надо заполнить поля "Пароль" и "Повторить пароль".<br/>
         <b>Если Вы не хотите менять пароль, то поле следует оставить пустым.</b>
    </div>
<? endif;?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'percent-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля <span class="required">*</span></p>

	<?php echo $form->errorSummary($model); ?>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">
                <div class="row">
                    <?php echo $form->labelEx($model,'login'); ?>
                    <?php echo $form->textField($model,'login'); ?>
                    <?php echo $form->error($model,'login'); ?>
                </div>

                 <div class="row">
                    <?php echo $form->labelEx($model,'phone'); ?>
                    <?php $this->widget('CMaskedTextField', array(
                    'model' => $model,
                    'attribute' => 'phone',
                    'mask' => '(999)999-99-99',
                    'htmlOptions' => array('size' => 10)
                    )); ?>
                    <?php echo $form->error($model,'phone'); ?>
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
                    <?php echo $form->labelEx($model,'organization'); ?>
                    <?php echo $form->textField($model, 'organization', array('value'=>'')); ?>
                    <?php echo $form->error($model,'organization'); ?>
                </div>
            </td>
            <td valign="top">
                    <div class="row">
                        <?php echo $form->labelEx($model,'inn'); ?>
                        <?php echo $form->textField($model, 'inn'); ?>
                        <?php echo $form->error($model,'inn'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model,'kpp'); ?>
                        <?php echo $form->textField($model, 'kpp'); ?>
                        <?php echo $form->error($model,'kpp'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model,'bik'); ?>
                        <?php echo $form->textField($model, 'bik'); ?>
                        <?php echo $form->error($model,'bik'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model,'bank'); ?>
                        <?php echo $form->textField($model, 'bank'); ?>
                        <?php echo $form->error($model,'bank'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model,'r-s'); ?>
                        <?php echo $form->textField($model, 'r-s'); ?>
                        <?php echo $form->error($model,'r-s'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->labelEx($model,'k-s'); ?>
                        <?php echo $form->textField($model, 'k-s'); ?>
                        <?php echo $form->error($model,'k-s'); ?>
                    </div>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <div class="row">
                    <?php echo $form->labelEx($model,'role'); ?>
                    <?php echo $form->dropDownList($model, 'role', Users::model()->AllRoles()); ?>
                    <?php echo $form->error($model,'role'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'org_type_user'); ?>
                    <?php echo $form->dropDownList($model, 'org_type_user', Users::model()->OrgTypeUser()); ?>
                    <?php echo $form->error($model,'org_type_user'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'type_user'); ?>
                    <?php echo $form->dropDownList($model, 'type_user', Percent::model()->getTypePerc()); ?>
                    <?php echo $form->error($model,'type_user'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'active'); ?>
                    <?php echo $form->checkBox($model, 'active'); ?>
                    <?php echo $form->error($model,'active'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'send_mail'); ?>
                    <?php echo $form->checkBox($model, 'send_mail'); ?>
                    <?php echo $form->error($model,'send_mail'); ?>
                </div>
            </td>
            <td valign="top">
                <div class="row">
                    <?php echo $form->labelEx($model,'info'); ?>
                    <?php echo $form->textArea($model,'info',array('rows'=>6, 'cols'=>50)); ?>
                    <?php echo $form->error($model,'info'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'address'); ?>
                    <?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
                    <?php echo $form->error($model,'address'); ?>
                </div>
            </td>
        </tr>
    </table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->