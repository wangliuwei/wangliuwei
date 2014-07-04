<?php
class ArtistsController extends CController
{
    public $layout='main';

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

    public function actionPrintFilm(){
        $authorID = $categoryID = array();
        $menus = Tb_category::model()->getLeftMenu(1);
        $criteria = new CDbCriteria;
        $criteria->addCondition('showAuthor = 1 and disable = 0');
        $criteria->order = 'priority DESC';
        $models = Tb_Content::model()->findAll($criteria);
    }
    
    public function actionAjaxGetMediaInfo($categoryID = 0){
        
    }
}
