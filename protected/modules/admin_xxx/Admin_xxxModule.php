<?php
Class Admin_xxxModule extends CWebModule{
    public $defaultController = 'site';
    public function __construct(){
        parent::init();
    	Yii::import('application.modules.admin_xxx.models.*');
    	Yii::import('application.modules.admin_xxx.components.*');
    }
}