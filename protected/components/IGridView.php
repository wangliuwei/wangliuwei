<?php
/**
 * 自定义Gridview类
 * 
 * @author      $Author: wangliuwei $
 * @version     $Id: IGridView.php 8694 2011-07-08 07:50:18Z wangliuwei $
 * @filesource
 * @package     imedia.components
 * @since 1.0.0
 */
Yii::import('zii.widgets.grid.CGridView');

class IGridView extends CGridView{
    /**
     * @var string the template to be used to control the layout of various sections in the view.
     * These tokens are recognized: {summary}, {items} and {pager}. They will be replaced with the
     * summary text, the items, and the pager.
     */
    public $template="{pager}{items}";
    
    public $selectableRows = 2;
    
    /**
     * @var array the configuration for the pager. Defaults to <code>array('class'=>'CLinkPager')</code>.
     * @see enablePagination
     */    
    public $pager=array('class'=>'IAjaxPagers');
    
    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate {@link columns} objects.
     */
    public function init()
    {
        //列表ajax更新后，提示信息
        /*
        $this->afterAjaxUpdate = 'js:function(id, data) { 
            $(".header").append("<div id=message class=message>操作成功！</div>");
            $(".message").animate({opacity: 1.0}, 3000).fadeOut("slow");
        }';*/
//    	var_dump($_GET['pagerSize']);
//    	var_dump($this->dataProvider);
//		Yii::app()->clientScript->registerScript('initPageSize','$("#pagerSize").live("change",function(){
//		    $.fn.yiiGridView.update("'.$this->id.'",{ data:{pageSize: $(this).val() }});
//		});',CClientScript::POS_READY);
		Yii::app()->clientScript->registerScript('initPageList','$("#pagerform").live("submit",function(){
			$.fn.yiiGridView.update("'.$this->id.'",{ data:$(this).serialize()});
			return false;
		});',CClientScript::POS_READY);
		Yii::app()->clientScript->registerScript('initPageDelete','
			$("#gridview-form").live("submit",function(){
			var selectedItems = new Array();
			$("#gridview-form input[@name=\'id[]\']:checked").each(function() {
				selectedItems.push($(this).val());
	    	});
			$.fn.yiiGridView.update("'.$this->id.'",{
		    	type:"POST",
				url:$("#gridview-form").attr("action"),
				data:"id=" + selectedItems,
				success:function() {
					$.fn.yiiGridView.update("'.$this->id.'");
				}
	    	});
			return false;
		});',CClientScript::POS_READY);
		
        parent::init();
		
    }
                
     /**
     * Registers necessary client scripts.
     * This method is invoked by {@link run}.
     * Child classes may override this method to register customized client scripts.
     */
    public function registerClientScript()
    {
        $this->renderCheckBoxJs();
        
        parent::registerClientScript();
    }
    
        /**
     * 绑定checkbox Js 事件
     * @param integer the row number (zero-based).
     */
    public function renderCheckBoxJs()
    {
        //删除选中项
        $message[0] = Yii::t('basic', '确认要删除所选择的数据吗？');
        $message[1] = Yii::t('basic', '请选择至少一条记录');
        Yii::app()->clientScript->registerScript('deleteCheckData',
            '$("#delchk").live("click",function(){
                var item = $("#gridview-form td input:checked");				
				if(item.length==0) {
                    alert("'.$message[1].'");
                    return false;
                }
                msg = "'.$message[0].'";
                if (confirm(msg)==true){
                    $("#gridview-form").submit();
                }
                else{
                    return false;    
                }
            });'
        );
        //存档选中项（类似删除）
        $message[0] = Yii::t('basic', '确认要存档所选择的数据吗？');
        $message[1] = Yii::t('basic', '请选择至少一条记录');
        Yii::app()->clientScript->registerScript('archiveCheckData',
            '$("#archivechk").live("click",function(){
                var item = $("#gridview-form input:checkbox:checked")
                if(item.length==0) {
                    alert("'.$message[1].'");
                    return false;
                }
                msg = "'.$message[0].'";
                if (confirm(msg)==true){
                    $("#gridview-form").submit();
                }
                else{
                    return false;    
                }
            });'
        );
        //恢复选中项
        $message[0] = Yii::t('basic', '确认要恢复所选择的数据吗？');
        $message[1] = Yii::t('basic', '请选择至少一条记录');
        $recover_url = Yii::app()->controller->createUrl("recover");
        Yii::app()->clientScript->registerScript('recoverCheckData',
            '$("#recoverchk").live("click",function(){
                var item = $("#gridview-form input:checkbox:checked")
                if(item.length==0) {
                    alert("'.$message[1].'");
                    return false;
                }
                msg = "'.$message[0].'";
                if (confirm(msg)==true){
                    $("#gridview-form").attr("action","'.$recover_url.'");
                    $("#gridview-form").submit();
                }
                else{
                    return false;    
                }
            });'
        );
        
        //点击行，checkbox选中/取消
        Yii::app()->clientScript->registerScript('CheckedSelected',
            '$("#gridview-form .items > tbody > tr").each(function(){
                $(this).click(function(){
                    if($(this).hasClass("selected") == true){
                        $(this).find("input:checkbox")[0].checked = false;
                    }
                    else{
                        $(this).find("input:checkbox")[0].checked = true;
                    }
                });
            });'
        );
    }
    
    /**
     * Renders the data items for the grid view.
     */
    public function renderItems()
    {
        if($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty)
        {
            //echo CHtml::openTag($this->tagName,array('class'=>'scrollbar'))."\n";
            $url = Yii::app()->controller->createUrl('delete');
            echo '<form id="gridview-form" action="'.$url.'" method="POST" >';
            echo "<table class=\"{$this->itemsCssClass}\">\n";
            $this->renderTableHeader();
            $this->renderTableFooter();
            $this->renderTableBody();
            echo "</table>";
            echo '</form>';
            //echo CHtml::closeTag($this->tagName);
        }
        else
            $this->renderEmptyText();
    }
    
    /**
     * Renders the pager.
     */
    public function renderPager()
    {
        if(!$this->enablePagination)
            return;

        $pager=array();
        $class='CLinkPager';
        if(is_string($this->pager))
            $class=$this->pager;
        else if(is_array($this->pager))
        {
            $pager=$this->pager;
            if(isset($pager['class']))
            {
                $class=$pager['class'];
                unset($pager['class']);
            }
        }
        $pager['pages']=$this->dataProvider->getPagination();
//        var_dump($pager['pages']->pageSize);
        echo CHtml::openTag($this->tagName,array('class'=>'data_op'))."\n";
        echo CHtml::openTag($this->tagName,array('class'=>$this->pagerCssClass))."\n";
        $this->widget($class,$pager);
        echo CHtml::closeTag($this->tagName);
        echo CHtml::closeTag($this->tagName);
    }
}
