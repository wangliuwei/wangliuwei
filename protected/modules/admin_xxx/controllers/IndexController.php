<?php

/**
 * 手机订单审核控制器
 * 
 * @author      Eden
 * @version     $Id: CampaignController.php 6531 2011-05-19 11:19:11Z kid $
 * @filesource
 * @package     imedia.models
 * @since 1.0.0
 */
class IndexController extends Controller
{

	public $layout='main';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @var String 标题
     */
    public $title = '系统管理';
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     *
     * actions: 设置哪个动作匹配此规则。
     * 		allow：允许
     * 		deny：拒绝
     * users值
     * 		*: 任何用户，包括匿名和验证通过的用户。
     * 		?: 匿名用户。
     * 		@: 验证通过的用户。

     */
    public function filters()
	{
		return array(
			'accessControl', 
		);
	}
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
	public function actionIndex()
	{
		$this->render('index');
	}
}
