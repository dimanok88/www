<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => 'Шинный центр',

	'preload'=>array('log'),

    'language' => 'en',
    //'sourceLanguage' => 'en_en',
    'charset' => 'utf-8',


	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.parser.*',
	),

	'components'=>array(
        'cache' => array(
            'class' => 'system.caching.CFileCache',
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
			'connectionString' => 'mysql:host=localhost;dbname=mobil36rf_new',
			'emulatePrepare' => true,
			'username' => 'mobil36rf_new',
			'password' => '1qaz2wsx',
			'charset' => 'utf8',
            'queryCachingDuration'=>true,
            'autoConnect' => false,
            'schemaCachingDuration' => 3600,
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
	
	),


	'params' => array(
		'adminEmail' => 'dimanok88@gmail.com',
	),

    
);
