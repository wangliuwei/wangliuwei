<?php
Yii::import('system.web.widgets.pagers.CLinkPager');
/**
 * 
 * 自定义分页类,default模板使用
 * 
 * @author kid
 * @package components
 */
class IAjaxPagers extends CLinkPager{
    /**
     * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
     */
    public $maxButtonCount=5;
    
    /**
     * Initializes the pager by setting some default property values.
     */
    public function init()
    {
        if($this->nextPageLabel===null)
            $this->nextPageLabel=Yii::t('basic','下一页');
        if($this->prevPageLabel===null)
            $this->prevPageLabel=Yii::t('basic','上一页');
        if($this->firstPageLabel===null)
            $this->firstPageLabel=Yii::t('basic','首页');
        if($this->lastPageLabel===null)
            $this->lastPageLabel=Yii::t('basic','末页');
//        if($this->header===null)
//            $this->header=Yii::t('yii','Go to page: ');
        if(!isset($this->htmlOptions['id']))
            $this->htmlOptions['id']=$this->getId();
        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='turn_page';
    }
    
    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $this->registerClientScript();
//		$url = $this->getPages()->createPageUrl($this->getController(),0);
//		echo $url;
		$url = Yii::app()->request->requestUri;
//		echo $url;
		
        echo '<span class="pagecou">共 <strong>'.$this->getPageCount().'</strong>页&nbsp;<strong>'.$this->getItemCount().'</strong>条结果</span>';
        echo '<span><form id="pagerform" method="POST" action="'.$url.'">';
        //生成每页选择数
        
        $this->renderSelectionPager();
        $buttons=$this->createPageButtons();
//        $this->footer = '<span class="pagecou">共'.$this->getPageCount().'页</span>&nbsp;';
        $this->footer .= Yii::t('yii','Go to page: ');
        $this->footer .= Yii::t('basic','第');
        $currentPage = $this->getCurrentPage(false)+1; // currentPage is calculated in getPageRange()
        $this->footer .= '<input style="width: 20px" type="text" name="'.$this->pages->pageVar.'" value="'.$currentPage.'" />';
        $this->footer .= Yii::t('basic','页');

        if(empty($buttons)){
            echo '</form></span>';
            return;
        }
        echo $this->header;
        echo CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons));
        echo $this->footer;
        
        echo '</form></span>';
        
        
    }
    
    /**
     * 每页显示页数功能，使用select实现
     */
    public function renderSelectionPager(){
        $arrPageSizes = array(10=>10,20=>20,50=>50,200=>200,1000=>1000);
    	if(isset(Yii::app()->params->perPageSizes)){
            $arrPageSizes = Yii::app()->params->perPageSizes;
        }
        
        echo '<span>&nbsp;'.Yii::t('basic', '每页显示 ');
        echo CHtml::dropDownList('pageSize',$this->pageSize,$arrPageSizes,array(
        	'id'=>'pagerSize'
    	));
        if(isset(Yii::app()->params->perPageSizes)){
            $arrPageSizes = Yii::app()->params->perPageSizes;
        }
        echo '&nbsp;'.Yii::t('basic', '个').'</span>';
    	Yii::app()->clientScript->registerScript('initPageSize','$("#pagerSize").live("change",function(){
		    $("#pagerform").submit();
		});',CClientScript::POS_READY);
    }
    
}