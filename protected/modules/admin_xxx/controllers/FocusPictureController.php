<?php

/**
 * 焦点图片控制器
 * 
 * @author      Eden
 * @version     $Id: CampaignController.php 6531 2011-05-19 11:19:11Z kid $
 * @filesource
 * @package     imedia.models
 * @since 1.0.0
 */
class FocusPictureController extends Controller
{

    public $layout='main';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @var String 标题
     */
    public $title = '焦点图片管理';
    
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
    
    /**
     * 新增焦点图片页面
     */
    public function actionCreate()
    {
        $model=new Tb_new('create');
        $model->Disable = 0;
        $parent_id = Tb_category::model()->getAllParents();
        if(isset($_POST['Tb_new']))
        {
            $model->attributes = $_REQUEST['Tb_new'];
            $model->Url = $_REQUEST['Tb_new']['Url'];
            $model->type = 6;
            $image=CUploadedFile::getInstance($model,'Image');
            if (is_object($image) && get_class($image)==='CUploadedFile')
            {
                $arrImage = explode('.',$image);
                $model->Image=Yii::app()->params['FilesPath'].'_'.time().'.'.$arrImage[1];
            }
            else
            {
                $model->Image = '';
            }
            if($model->save())
            {
                if (is_object($image) && get_class($image)==='CUploadedFile')
                {
                    $image->saveAs($model->Image);
                }
                $Url = Yii::app()->createUrl('FocusPicture/list',array('layout'=>$this->layout));
                $this->CallbackSuccessReturn($Url);
            }
            else 
            {
                $this->CallbackErrorReturn('Tb_new',$model->getErrors());
            }    
        }
        $this->render('create',array(
            'model'=>$model,
            'parent_id' =>$parent_id,
        ));
    }
    
    /**
     * 焦点图片列表页面
     */
    public function actionList() {
        $model=new Tb_new('search');
        $model->type = 6;
        if(isset($_REQUEST['Tb_new'])){
            $model->attributes = $_REQUEST['Tb_new'];
        }
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        $this->render('list',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdate()
	{
		$model = $this->loadModel();
		$parent_id = Tb_category::model()->getAllParents();
		if(isset($_POST['Tb_new']))
		{
			$model->attributes = $_REQUEST['Tb_new'];
			$model->Url = $_REQUEST['Tb_new']['Url'];
            $model->type = 6;
			$image=CUploadedFile::getInstance($model,'Image');
			if (is_object($image) && get_class($image)==='CUploadedFile')
			{
				$arrImage = explode('.',$image);
				$model->Image=Yii::app()->params['FilesPath'].'_'.time().'.'.$arrImage[1];
			}
			if($model->save())
			{
				if (is_object($image) && get_class($image)==='CUploadedFile')
				{
					$image->saveAs($model->Image);
				}
				$Url = Yii::app()->createUrl('FocusPicture/list',array('layout'=>$this->layout));
				$this->CallbackSuccessReturn($Url);
			}
			else 
			{
				$this->CallbackErrorReturn('Tb_new',$model->getErrors());
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'parent_id' =>$parent_id,
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
			$id = explode(',', $_REQUEST['id']); 
			$criteria=new CDbCriteria;
			$criteria->addInCondition('ID',$id);
			Tb_new::model()->deleteAll($criteria);			
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
