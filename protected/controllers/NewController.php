<?php
class NewController extends Controller
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
    
    public function actionAbout()
    {
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $Model = Tb_new::model()->findByAttributes(array('type'=>'5'));
        $image = '';
        $title = '';
        $Content = '';
        if(!empty($Model))
        {
            $Content = $Model->Content;
            $title = $Model->Name;
        }
        $title = '联系我们';
        $this->_css = 'contactus';
        $this->render('newInfo',array(
            'Content'=>$Content,
            'name' =>$name,
            'title' =>$title,
        ));
    }
    
    public function actionCulture()
    {
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $Model = Tb_new::model()->findByAttributes(array('type'=>'4'));
        $image = '';
        $title = '';
        $Content = '';
        if(!empty($Model))
        {
            $Content = $Model->Content;
            $name = $Model->Name;
        }
        $title = '酒文化';
        $this->_css = 'culture';
        $this->render('newInfo',array(
            'Content'=>$Content,
            'name' =>$name,
            'title' =>$title,
        ));
    }
    
    public function actionCompany()
    {
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $Model = Tb_new::model()->findByAttributes(array('type'=>'3'));
        $image = '';
        $title = '';
        $Content = '';
        if(!empty($Model))
        {
            $Content = $Model->Content;
            $name = $Model->Name;
        }
        $title = '公司简介';
        $this->_css = 'company';
        $this->render('newInfo',array(
            'Content'=>$Content,
            'name' =>$name,
            'title' =>$title,
        ));
    }
    /**
     *购物保障
     */
    public function actionPurchaseProtection(){
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $Model = Tb_new::model()->findByAttributes(array('type'=>'7'));
        $image = '';
        $title = '';
        $Content = '';
        if(!empty($Model))
        {
            $Content = $Model->Content;
            $name = $Model->Name;
        }
        $title = '购物保障';
        $this->render('newInfo',array(
            'Content'=>$Content,
            'name' =>$name,
            'title' =>$title,
        ));
    }
    /**
     *隐私声明
     */
    public function actionPrivacyStatement(){
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $Model = Tb_new::model()->findByAttributes(array('type'=>'8'));
        $image = '';
        $title = '';
        $Content = '';
        if(!empty($Model))
        {
            $Content = $Model->Content;
            $name = $Model->Name;
        }
        $title = '隐私声明';
        $this->render('newInfo',array(
            'Content'=>$Content,
            'name' =>$name,
            'title' =>$title,
        ));
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
        $criteriaKey->addCondition("t.type = 2");
		$criteriaKey->addCondition("t.Disable = 0");
        $count = Tb_new::model()->count($criteriaKey);
        $page = isset($_REQUEST['PB_page']) ? $_REQUEST['PB_page'] : 1;
        $perpage = 20;
        $offset = $perpage*($page-1);
        $page = new page(array('total'=>$count,'perpage'=>$perpage));
        $criteria = new CDbCriteria;
        $criteria->order = 't.ID desc';
        $criteria->addCondition("t.type = 2");
		$criteria->addCondition("t.Disable = 0");
        $criteria->limit = $perpage;
        $criteria->offset = $offset;
        $models = Tb_new::model()->findAll($criteria);
        $this->_css = 'culture';
        $this->render('newList',array(
			'models'=>$models,
            'page' => $page,
		));
    }
	
    public function actionInfo()
    {
        $ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:'';
        $model = Tb_new::model()->findByPk($ID);
        $title = $content = $name = '';
        if(!empty($model)){
            $title = $model->Name;
            $content = $model->Content;
            $this->_title = $model->keytitle;
            $this->_keywords = $model->keywords;
            $this->_description = $model->keycontent;
        }
        $this->_css = 'culture';
        $this->render('news',array(
            'Content'=>$content,
            'name' =>$name,
            'title' =>$title
        ));
    }
    public function actionMap()
    {
        $info = Tb_info::model()->find();
        $this->_title = $info->title;
        $this->_keywords = $info->keywords;
        $this->_description = $info->description;
        $this->_css = 'map';
        $title = '站内地图';
        $this->render('map',array(
            'title' =>$title,
        ));
    }
}
