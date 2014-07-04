<?php

/**
 * 默认控制器
 */
class InfoController extends Controller
{
    /**
     * @var String 出错首页
     */    
    public $homepage='info';
    
    /**
     * @var String 布局文件
     */    
    public $layout='main';

    /**
     * @var String 标题
     */
    public $pageTitle = '配置';
	
	private $_model;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     *
     * actions: 设置哪个动作匹配此规则。
     *    allow：允许
     *    deny：拒绝
     * users值
     *    *: 任何用户，包括匿名和验证通过的用户。
     *    ?: 匿名用户。
     *    @: 验证通过的用户。
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
    
    public function actions() {
        return array(
        );
    }

    //编辑联系我们页面
    public function actionUpdate()
    {
        $model = Tb_info::model()->find();
        if(empty($model))
        {
            $model = new Tb_info('create');
        }
        if(isset($_POST['Tb_info']))
        {
            $model->attributes = $_REQUEST['Tb_info'];
            if($model->save())
            {
                $Url = Yii::app()->createUrl('info/update',array('layout'=>$this->layout));
                $this->CallbackSuccessReturn($Url);
            }
            else 
            {
                $this->CallbackErrorReturn('Tb_info',$model->getErrors());
            }
        }
        $this->render('update',array(
            'model'=>$model
        ));
    }
	

	/**
     * 通过GET['id']获取一个账号信息
     * 假如没有找到，抛出Http 404错误
     */
    public function loadModel($id = '', $modelName = '')
    {
        if($this->_model === null)
        {
            $model = new Tb_info($modelName);
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $this->_model = $model->findByPk($_GET['id']);
            }elseif($id > 0){
                $this->_model = $model->findByPk($id);
            }
            if($this->_model === null)
                throw new CHttpException(404,'The requested page does not exist.');
        }

        return $this->_model;
    }
}