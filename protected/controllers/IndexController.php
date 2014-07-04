<?php

class IndexController extends CController
{
    public $layout='main';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to access all actions
                'actions'=>array(),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     *  网站首页
     */
    public function actionIndex()
    {
        $cids = array();
        $criteria = new CDbCriteria;
        $criteria->addCondition('showIndex = 1 and disable = 0');
        $models = Tb_Content::model()->findAll($criteria);
        $criteria->order = 'priority DESC';
        foreach($models as $model){
            $cids[] = $model->id;
        }
        $this->render('index',array(
            'cids' => $cids
        ));
    }
    
    public function actionGetIndexMedia($mediaId){
        $data = array();
        $model = Tb_Content::model()->findByPk($mediaId);
        if(!empty($model)){
            $data['mediaId'] = $mediaId;
            $data['type'] = $model->type == 1?'gallery':'video';
            $data['link'] = $this->createUrl('site/test',array('mediaId'=>$mediaId));
            $data['title'] = $model->title;
            $data['description'] = $model->subTitle;
            $data['image'] = Yii::app()->baseUrl.'/'.$model->showImage;
            $data['subTitle'] = $model->subTitle;;
        }
        echo CJavaScript::jsonEncode($data);
    }
}
