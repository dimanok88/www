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
        CGoogleApi::load('jquery')
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
                ),
            )
        );
    ?>

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?>

	<?php echo $content; ?>

	<div id="footer">
		Копирайт &copy; 2010-<?php echo date('Y'); ?><br />
		Все права защищены.<br />
	</div>

</div>

</body>
</html>
