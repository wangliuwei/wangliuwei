<?php
class CKEditorWidget extends CInputWidget
{

    public $ckEditor;
    public $ckFinder;
    public $ckBasePath;
    public $defaultValue;
    public $config;
    public function run()
    {
        if(!isset($this->model)){
            throw new CHttpException(500,'"model" 必需设置!');
        }
        if(!isset($this->attribute)){
            throw new CHttpException(500,'"attribute" 必须设置!');
        }
        if(!isset($this->ckEditor)){
            $this->ckEditor = Yii::app()->basePath."/../ckeditor/ckeditor.php";
        }
        if(!isset($this->ckBasePath)){
            $this->ckBasePath = Yii::app()->baseUrl."/ckeditor/";
        }
        if(!isset($this->defaultValue)){
            $this->defaultValue = "";
        }

        $controller=$this->controller;
        $action=$controller->action;
        $this->render('CKEditorView',array(
            "ckEditor"=>$this->ckEditor,
            "ckBasePath"=>$this->ckBasePath,
            "model"=>$this->model,
            "attribute"=>$this->attribute,
            "defaultValue"=>$this->defaultValue,
            "config"=>$this->config,
        ));
    }
}