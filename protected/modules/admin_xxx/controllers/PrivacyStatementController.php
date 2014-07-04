<?php

/**
 * 隐私声明控制器
 * 
 * @author      Eden
 * @version     $Id: CompanyProfileController.php 6531 2011-05-19 11:19:11Z kid $
 * @filesource
 * @package     imedia.models
 * @since 1.0.0
 */
class PrivacyStatementController extends Controller
{

    public $layout='main';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @var String 标题
     */
    public $title = '隐私声明管理';
    
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
    
    //编辑联系我们页面
    public function actionUpdate()
    {
        $model = Tb_new::model()->findByAttributes(array('type'=>8));
        if(empty($model))
        {
            $model = new Tb_new('create');
        }
        if(isset($_POST['Tb_new']))
        {
            $model->attributes = $_REQUEST['Tb_new'];
            $model->Content = $_REQUEST['Tb_new']['Content'];
            $model->Url = $_REQUEST['Tb_new']['Url'];
            $model->Disable = $_REQUEST['Tb_new']['Disable'];
            $model->type = 8;
            if($model->save())
            {
                $Url = Yii::app()->createUrl('ContactUs/update',array('layout'=>$this->layout));
                $this->CallbackSuccessReturn($Url);
            }
            else 
            {
                $this->CallbackErrorReturn('Tb_new',$model->getErrors());
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
            $model = new Tb_new($modelName);
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
