<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => 'Шинный центр',

	'preload'=>array('log'),

    'language' => 'ru',
    'sourceLanguage' => 'ru_ru',
    'charset' => 'utf-8',

    'defaultController' => 'parser',

	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.extensions.PHPExcel4Yii.*',
        'application.extensions.shoppingCart.*',
        'application.extensions.categorytree.*',
		'application.extensions.parser.*',
	),

	'components'=>array(
		'user'=>array(
			'allowAutoLogin' => true,
            'loginUrl' => array('profile/login'),
		),

        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),

        'excel'=>array(
	          'class'=>'application.extensions.PHPExcel4Yii.PHPExcel',
	    ),

		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
				
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=mobil',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
            'errorAction'=>'front/error',
        ),
        
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				
                /*array(
					'class'=>'CWebLogRoute',
				),*/
			),
		),

        'shoppingCart' => array(
            'class' => 'ext.shoppingCart.EShoppingCart',
            'discounts' => array(
                array(
                    'class' => 'ext.shoppingCart.discounts.ShopDiscount',
                ),
            ),
        ),
	
	),

    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>false,
        ),
    ),

	'params' => array(
		'adminEmail' => 'dimanok88@gmail.com',

        'uploadDir' => '/resources/upload/',

        'imgThumbWidth' => '200',
        'imgThumbHeight' => '150',
        'imgWidth' => '480',
        'imgHeight' => '320',

        'countItemsByPage' => '50',
        'countNewsByPage' => '2',
        'countNewsForIndex' => '3',

        'cacheListTime' => '1',

        'shortName' => 'Шинный центр',
	),

    'onBeginRequest' => 'beginRequest',
);

function beginRequest($event)
{
    $app = Yii::app();    
    if( $app->request->getUrl() != CHtml::normalizeUrl($app->user->loginUrl) && $app->user->isGuest )
    {
        $app->user->setState('urlBack', $app->request->getUrl());
    }
}
