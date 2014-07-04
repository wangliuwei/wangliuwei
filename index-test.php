<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/protected/libs/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
// 是否为Debug模式
defined('YII_DEBUG') or define('YII_DEBUG',true);
require_once($yii);
Yii::createWebApplication($config)->run();
