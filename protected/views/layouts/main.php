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

	<div id="header">
		<div id="logo">Панель управления сайтом</div>
	</div>

    <?php
        $this->widget(
            'application.extensions.mbmenu.MbMenu',
            array(
                'items' => array(
                    array(
                        'label' => 'Разделы',
                        'items' => array(
                            array('label'=>'Общий раздел', 'url'=>array('item/')),
                            array('label'=>'Парсер', 'url'=>array('parser/')),
                    ),
                    ),
                    array(
                        'label' => 'Список',
                        'items'=>array(
                            array('label'=>'Шины', 'url'=>array('item/tire'),
                            'items'=>array(
                                array('label' => 'Обозначения', 'url' => array('item/oboznach', 'type'=>'tire')),
                                array('label' => 'Раздел категорий', 'url' => array('item/category', 'type'=>'tire')),
                                array('label' => 'Проценты', 'url' => array('percent/index', 'type'=>'tire')),
                                array('label' => 'Типы', 'url' => array('typeItem/index', 'type'=>'tire')),
                            ),
                    ),
                    array('label'=>'Диски', 'url'=>array('item/disc'),
                        'items'=>array(
                                array('label' => 'Обозначения', 'url' => array('item/oboznach', 'type'=>'disc')),
                                array('label' => 'Раздел категорий', 'url' => array('item/category', 'type'=>'disc')),
                                array('label' => 'Проценты', 'url' => array('percent/index', 'type'=>'disc')),
                                array('label' => 'Типы', 'url' => array('typeItem/index', 'type'=>'disc')),
                            ),
                    ),
                    array('label'=>'Разное', 'url'=>array('item/other'),
                        'items'=>array(
                                array('label' => 'Обозначения', 'url' => array('item/oboznach', 'type'=>'other')),
                                array('label' => 'Раздел категорий', 'url' => array('item/category', 'type'=>'other')),
                                array('label' => 'Проценты', 'url' => array('percent/index', 'type'=>'other')),
                                array('label' => 'Типы', 'url' => array('typeItem/index', 'type'=>'other')),
                            ),
                    ),
                        ),
                    ),
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