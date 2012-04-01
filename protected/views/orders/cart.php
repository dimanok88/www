<h1>Корзина</h1>

<div>

    <div id=new_user>

    <?= CHtml::Form(array('orders/CartItem'));?>
        <?= CHtml::dropDownList('users', '',Users::model()->AllUsers()); ?>
        <?= CHtml::submitButton('Продолжить');?>
    <?= CHtml::endForm();?>

        <br/><br/>
    <?
    $this->renderPartial('application.views.users.newed', array('model'=>$userModel))
    ?>
    </div>
</div>
