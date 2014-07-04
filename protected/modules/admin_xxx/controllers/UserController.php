<?php

/**
 * 默认控制器
 */
class UserController extends Controller
{
    /**
     * @var String 出错首页
     */    
    public $homepage='user';
    
    /**
     * @var String 布局文件
     */    
    public $layout='main';

    /**
     * @var String 标题
     */
    public $pageTitle = '登录';
	
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

    /**
     * 新闻列表页面
     */
    public function actionList() {
		$model=new Tb_user('search');
		if(isset($_POST['Tb_user'])){
			$model->attributes = $_POST['Tb_user'];
		}
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
        $this->render('list',array(
			'model'=>$model,
		));
    }
	
	/**
     * 新增新闻页面
     */
    public function actionCreate() {
		$model=new Tb_user('create');
		if(isset($_POST['Tb_user']))
		{
			$model->attributes = $_POST['Tb_user'];
			$model->password = md5($_POST['Tb_user']['password']);
			$model->passwordConfirm = md5($_POST['Tb_user']['passwordConfirm']);
			if($model->save())
			{
				$Url = Yii::app()->createUrl('user/list');
				$this->CallbackSuccessReturn($Url);
			}
			else 
			{
				$this->CallbackErrorReturn('Tb_user',$model->getErrors());
			}	
		}
        $this->render('create',array(
			'model'=>$model,
		));
    }
	
	public function actionUpdate()
	{
		$model = $this->loadModel();
		$model->password = '';
		if(isset($_POST['Tb_user']))
		{
			$model->attributes = $_POST['Tb_user'];
			$model->password = md5($_POST['Tb_user']['password']);
			$model->passwordConfirm = md5($_POST['Tb_user']['passwordConfirm']);
			if($model->save())
			{
				$Url = Yii::app()->createUrl('user/list');
				$this->CallbackSuccessReturn($Url);
			}
			else 
			{
				$this->CallbackErrorReturn('Tb_user',$model->getErrors());
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}
    /**
     * 删除新闻
     * 如果更新成功，页面跳转到新闻列表页面index
     */
    public function actionDelete()
    {
		if(Yii::app()->request->isPostRequest)
		{
			$id = explode(',', $_POST['id']); 
			$criteria=new CDbCriteria;
			$criteria->addInCondition('ID',$id);
			Tb_user::model()->deleteAll($criteria);			
			Yii::app()->user->setFlash('success',Yii::t('basic', '删除成功'));
			if(!isset($_GET['ajax'])) $this->redirect(array('list'));   
		}
    }
	
	/**
     * 通过GET['id']获取一个账号信息
     * 假如没有找到，抛出Http 404错误
     */
    public function loadModel($id = '', $modelName = '')
    {
        if($this->_model === null)
        {
            $model = new Tb_user($modelName);
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