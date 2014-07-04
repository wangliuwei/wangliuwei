<?php

Yii::import('zii.widgets.CBreadcrumbs');
/**
 * 自定义面包屑功能
 * 
 * @author kid
 * @package components
 */
class Breadcrumbs extends CBreadcrumbs {
    
    /**
     * 
     * @see protected/libs/zii/widgets/CBreadcrumbs::run()
     */
    public function run()
    {
        if(empty($this->links))
            return;

        echo Html::openTag($this->tagName,$this->htmlOptions)."\n";
        $links=array();
        if($this->homeLink===null)
//            $links[]='<li class="home">'.CHtml::link(Yii::t('basic','首页'),Yii::app()->homeUrl).'<li>';
       		$links[]=CHtml::tag('li', array('class'=>"home"), CHtml::link(Yii::app()->name,Yii::app()->homeUrl));
        else if($this->homeLink!==false)
            $links[]=$this->homeLink;
        foreach($this->links as $label=>$url)
        {
            if(is_string($label) || is_array($url))
                $links[]=CHtml::tag('li', array(), Html::link($this->encodeLabel ? CHtml::encode($label) : $label, $url));
            else
                $links[]=CHtml::tag('li', array('class'=>"cur"), CHtml::tag('span',array('class'=>"text"), ($this->encodeLabel ? CHtml::encode($url) : $url)). CHtml::tag('span',array('class'=>'role'),''));
        }
        echo implode($this->separator,$links);
        echo Html::closeTag($this->tagName);
    }
}