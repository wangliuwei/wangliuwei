<?php
/**
 * 用户菜单
 *
 * 收藏夹的功能，存储用户自定义页面的功能
 */
Yii::import('zii.widgets.CPortlet');

class UserMenu extends CPortlet
{
    public $title=null;

    public $contentCssClass='usermenus';

    public function init()
    {
        $this->renderDecoration();
    }

    /**
     * Renders the content of the portlet.
     */
    public function run()
    {
        $this->renderContent();
        //echo "</div>\n";
        //echo CHtml::closeTag($this->tagName);
    }

    protected function renderContent()
    {
        $usermenus ='';
        if($usermenus == null){
            $usermenus = array();
        }
        $this->render('userMenu',array(
            'usermenus' => $usermenus,
        ));
    }
}