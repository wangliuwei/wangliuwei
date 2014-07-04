<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'意境',

	// preloading 'log' component
	'preload'=>array('log'),
    'aliases'=>array(
        'css'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../css/',
        'services'=>'application.services',
        'widget'=>'application.widget',
        'module'=>'application.modules',
        'component'=>'application.components'
    ),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'defaultController'=>'index',
	'homeUrl'=>array('index/index'),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yj',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'tb_',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'urlManager'=>array(
        	'urlFormat'=>'path',
            'class'=>'component.HttpRequest.UrlManager',
        	'rules'=>array(
        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        	),
        ),
        'cache'=>array(
            'class'=>'CDummyCache',  //无cache作用，开发调试使用
            //'class' => 'CApcCache',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// array(
					// 'class'=>'CWebLogRoute',
				// ),
			),
		),
	),
	'sourceLanguage' => 'zh_cn',
	'timeZone'=>'Asia/Shanghai', //设置时区为上海
    'theme' => 'default',
	'params'=>require(dirname(__FILE__).'/params.php'),
	'modules'=>array('admin_xxx'),
);