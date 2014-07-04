<?php

/**
 * 联系我们控制器
 * 
 * @author      Eden
 * @version     $Id: CompanyProfileController.php 6531 2011-05-19 11:19:11Z kid $
 * @filesource
 * @package     imedia.models
 * @since 1.0.0
 */
class BlogController extends Controller
{

    public $layout='main1';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    public $_keywords;
    
    public $_title;
    
    public $_description;
    
    public $_css;
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     *
     * actions: 设置哪个动作匹配此规则。
     *         allow：允许
     *         deny：拒绝
     * users值
     *         *: 任何用户，包括匿名和验证通过的用户。
     *         ?: 匿名用户。
     *         @: 验证通过的用户。

     */
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
	
    /**
     * 新闻列表页面
     */
    public function actionList() {
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $criteriaKey = new CDbCriteria;
        $criteriaKey->select = 't.ID';
        $criteriaKey->order = 't.ID';
        $criteriaKey->addCondition("t.type = 9");
		$criteriaKey->addCondition("t.Disable = 0");
        $count = Tb_new::model()->count($criteriaKey);
        $page = isset($_REQUEST['PB_page']) ? $_REQUEST['PB_page'] : 1;
        $perpage = 20;
        $offset = $perpage*($page-1);
        $page = new page(array('total'=>$count,'perpage'=>$perpage));
        $criteria = new CDbCriteria;
        $criteria->order = 't.ID desc';
        $criteria->addCondition("t.type = 9");
		$criteria->addCondition("t.Disable = 0");
        $criteria->limit = $perpage;
        $criteria->offset = $offset;
        $models = Tb_new::model()->findAll($criteria);
        $this->_css = 'blog';
        $this->render('newList',array(
			'models'=>$models,
            'page' => $page,
		));
    }
}
