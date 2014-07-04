<?php

/**
 * 默认控制器
 */
class ProductController extends Controller
{
    /**
     * @var String 出错首页
     */
    public $homepage='product';

    /**
     * @var String 布局文件
     */
    public $layout='main';

    /**
     * @var String 标题
     */
    public $title = '产品管理';

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
     * 产品列表页面
     */
    public function actionList() {
        $model=new Tb_product('search');
        if(isset($_REQUEST['Tb_product'])){
            $model->attributes = $_REQUEST['Tb_product'];
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
        $model=new Tb_product('create');
        $parent_id = Tb_category::model()->getAllParents();
        $arrPrioritys = array();
        for($i=1;$i<=20;$i++){
            $arrPrioritys[$i] = $i;
        }
        if(isset($_POST['Tb_product']))
        {
            $model->attributes = $_REQUEST['Tb_product'];
            $model->show = $_REQUEST['Tb_product']['show'];
            $model->price = $_REQUEST['Tb_product']['price'];
            $model->content = $_REQUEST['Tb_product']['content'];
            $model->description = $_REQUEST['Tb_product']['description'];
            $model->specials = $_REQUEST['Tb_product']['specials'];
            $model->newFlag = $_REQUEST['Tb_product']['newFlag'];
            $model->sort = $_REQUEST['Tb_product']['sort'];
            $image=CUploadedFile::getInstance($model,'image');
            if (is_object($image) && get_class($image)==='CUploadedFile')
            {
                $arrImage = explode('.',$image);
                $model->image=Yii::app()->params['FilesPath'].'_'.time().'.'.$arrImage[1];
            }
            else
            {
                $model->image = '';
            }
            if($model->save())
            {
                if (is_object($image) && get_class($image)==='CUploadedFile')
				{
					$image->saveAs($model->image);
				}
                $Url = Yii::app()->createUrl('product/list',array('layout'=>$this->layout));
                $this->CallbackSuccessReturn($Url);
            }
            else
            {
                $this->CallbackErrorReturn('Tb_product',$model->getErrors());
            }
        }
        $this->render('create',array(
            'model'=> $model,
            'parent_id' => $parent_id,
            'arrPrioritys' => $arrPrioritys
        ));
    }

    public function actionUpdate()
    {
        $model = $this->loadModel();
        $parent_id = Tb_category::model()->getAllParents();
        if(isset($_POST['Tb_product']))
        {
            $model->attributes = $_REQUEST['Tb_product'];
            $model->show = $_REQUEST['Tb_product']['show'];
            $model->price = $_REQUEST['Tb_product']['price'];
            $model->content = $_REQUEST['Tb_product']['content'];
            $model->description = $_REQUEST['Tb_product']['description'];
            $model->specials = $_REQUEST['Tb_product']['specials'];
            $model->newFlag = $_REQUEST['Tb_product']['newFlag'];
            $model->sort = $_REQUEST['Tb_product']['sort'];
            $image=CUploadedFile::getInstance($model,'image');
            if (is_object($image) && get_class($image)==='CUploadedFile')
            {
                $arrImage = explode('.',$image);
                $model->image=Yii::app()->params['FilesPath'].'_'.time().'.'.$arrImage[1];
            }
            if($model->save())
            {
                if (is_object($image) && get_class($image)==='CUploadedFile')
                {
                    $image->saveAs($model->image);
                }
                $Url = Yii::app()->createUrl('product/list',array('layout'=>$this->layout));
                $this->CallbackSuccessReturn($Url);
            }
            else
            {
                $this->CallbackErrorReturn('Tb_product',$model->getErrors());
            }
        }
        $arrPrioritys = array();
        for($i=1;$i<=20;$i++){
            $arrPrioritys[$i] = $i;
        }
        $this->render('update',array(
            'model'=>$model,
            'parent_id' =>$parent_id,
            'arrPrioritys' => $arrPrioritys
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
            Tb_product::model()->deleteAll($criteria);
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
            $model = new Tb_product($modelName);
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