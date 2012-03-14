<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

<?
    $cs=Yii::app()->clientScript;
$cs->scriptMap=array(
    'jquery.js'=>false,
);
    ?>

    <?php echo CGoogleApi::init(); ?>

    <?php echo CHtml::script(
        CGoogleApi::load('jquery', '1.5.0')
    ); ?>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mycss.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <?
    if(Yii::app()->user->checkAccess('moderator') || Yii::app()->user->checkAccess('admin')){
        if(Yii::app()->controller->id != 'orders'):?>
            <div id="cart">
		        <? $this->renderPartial('/orders/_cart'); ?>
        </div>
        <? endif;
    }
    ?>

	<div id="header">
		<div id="logo">Панель управления сайтом</div>
	</div>
    <?php
        $this->widget(
            'application.extensions.mbmenu.MbMenu',
            array(
                'items' => array(
                    array(
                        'label' => 'Разделы', 'visible'=>!Yii::app()->user->isGuest,
                        'items' => array(
                            array('label'=>'Общий раздел', 'url'=>array('item/')),
                            array('label'=>'Парсер', 'url'=>array('parser/')),
                    ),
                    ),
                    array(
                        'label' => 'Список', 'visible'=>!Yii::app()->user->isGuest,
                        'items'=>array(
                            array('label'=>'Шины', 'url'=>array('item/tire'),
                            'items'=>array(
                                array('label' => 'Обозначения', 'url' => array('item/oboznach', 'type'=>'tire')),
                                array('label' => 'Раздел категорий', 'url' => array('item/category', 'type'=>'tire')),
                                array('label' => 'Проценты', 'url' => array('percent/index', 'type'=>'tire')),
                                array('label' => 'Типы', 'url' => array('typeItem/index', 'type'=>'tire')),
                            ),
                    ),
                    array('label'=>'Диски', 'url'=>array('item/disc'), 'visible'=>!Yii::app()->user->isGuest,
                        'items'=>array(
                                array('label' => 'Обозначения', 'url' => array('item/oboznach', 'type'=>'disc')),
                                array('label' => 'Раздел категорий', 'url' => array('item/category', 'type'=>'disc')),
                                array('label' => 'Проценты', 'url' => array('percent/index', 'type'=>'disc')),
                                array('label' => 'Типы', 'url' => array('typeItem/index', 'type'=>'disc')),
                            ),
                    ),
                    array('label'=>'Разное', 'url'=>array('item/other'), 'visible'=>!Yii::app()->user->isGuest,
                        'items'=>array(
                                array('label' => 'Обозначения', 'url' => array('item/oboznach', 'type'=>'other')),
                                array('label' => 'Раздел категорий', 'url' => array('item/category', 'type'=>'other')),
                                array('label' => 'Проценты', 'url' => array('percent/index', 'type'=>'other')),
                                array('label' => 'Типы', 'url' => array('typeItem/index', 'type'=>'other')),
                            ),
                    ),
                        ),
                    ),
                    array('label'=>'Пользователи', 'url'=>array('users/listUsers'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Заказы', 'url'=>array('orders/'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Выйти', 'url'=>array('users/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Войти', 'url'=>array('users/login'), 'visible'=>Yii::app()->user->isGuest),
                ),
            )
        );
    ?>

	<?php //$this->widget('zii.widgets.CBreadcrumbs', array(
		//'links'=>$this->breadcrumbs,
	//));

    ?>

	<?php echo $content; ?>

	<div id="footer">
		Копирайт &copy; 2010-<?php echo date('Y'); ?><br />
		Все права защищены.<br />
	</div>

</div>

<?
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'edit_dialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        //'title'=>'',
        'resizable'=>true,
        'draggable'=>true,
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'800px',
    ),
));

    echo '<div id="dial"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

</body>
</html>

<?

Yii::app()->clientScript->registerScript('disc', "

    $('.items tbody tr').live({
         mouseenter: function() {
             var index = $('.odd').index(this);
             var image = $('.prev').eq(index).attr('prev');
             $('.main_pic').eq(index).show().html('<img src=\"'+image+'\">');
             return false;
         },
         mouseleave: function() {
             var index = $('.odd').index(this);
             $('.main_pic').hide();
             return false;
         },

 });

");

?>
Отработало за <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?> с. Скушано памяти: <?=round(memory_get_peak_usage()/(1024*1024),2)."MB"?>