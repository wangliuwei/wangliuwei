<?php

/**
 * 默认控制器
 */
class SiteController extends Controller
{
    /**
     * @var String 布局文件
     */
    public $layout='login';

    /**
     * @var String 标题
     */
    public $pageTitle = '登录';
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
    public function accessRules(){
        return array(
            array('allow', // allow authenticated users to access all actions
                'actions' => array(
                    'login',
                    'logout',
                    'error',
                    'captcha',
                    'ajaxUpload'
                ),
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'captcha'=> array(
                //加载外部的action class
                'class' => 'CCaptchaAction',
                //设置验证码图片背景色属性
                'backColor' => 0xffffff,
                'height' => '30',
                'width' => '60',
                'minLength' => '4',
                'maxLength' => '4',
                'padding' => '0',
            ),
        );
    }

    /**
     * 默认动作
     */
    public function actionIndex() {
        if(!Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->homeUrl);
        }
        else{
            $this->redirect($this->createUrl('site/login'));
        }
    }

    /**
     * 错误页面
     */
    public function actionError() {
        $this->layout = 'error';
        if($error=Yii::app()->errorHandler->error){
            if(Yii::app()->request->isAjaxRequest){
                echo $error['message'];
            }else{
                $this->render('error', $error);
            }
        }
    }

    /**
     * 登录
     */
    public function actionLogin() {
        if(!Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->homeUrl);
        }
        $this->layout = 'login';

        $model=new LoginForm('login');
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if($model->validate() && $model->login()){
                $this->redirect(Yii::app()->request->baseUrl.'/index.php/admin_xxx/index/index');
            }
        }

        $this->render('login',array('model'=>$model));
    }

    /**
     * 登出
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->request->baseUrl.'/index.php/admin_xxx/site/login');
    }
    
    //ajax上传图片
    public function actionAjaxUpload(){
        if (!empty($_FILES)) {
            $tempFile = $_FILES['uploadfile']['tmp_name'];
            $imageTypes = array('jpg','jpeg','gif','png');
            $flvTypes = array('avi','mp3','wma','flv','mp4','mkv');
            $fileParts = pathinfo($_FILES['uploadfile']['name']);
            //$size = $_FILES['uploadfile']["size"]; //文件大小
            if(in_array(strtolower($fileParts['extension']),$imageTypes)) {
                $targetFolder = 'files';
                $newimg = 'img_'.time().'_'.rand(1, 9999).'.'.$fileParts['extension'];
                if(move_uploaded_file($tempFile,$targetFolder.'/'.$newimg)){
                    $result = array('status'=>1,'text'=>$targetFolder.'/'.$newimg);
                }else{
                    $result = array('status'=>0,'text'=>'上传失败！');
                }
            }elseif(in_array(strtolower($fileParts['extension']),$flvTypes)){
                $targetFolder = 'flv';
                $newimg = 'flv_'.time().'_'.rand(1, 9999).'.'.$fileParts['extension'];
                if(move_uploaded_file($tempFile,$targetFolder.'/'.$newimg)){
                    $result = array('status'=>1,'text'=>$targetFolder.'/'.$newimg);
                }else{
                    $result = array('status'=>0,'text'=>'上传失败！');
                }
            } else {
                $result = array('status'=>0,'text'=>'上传文件类型错误！');
            }
        }
        echo CJavaScript::jsonEncode($result);
    }
}