<?php
/**
 * 自定义控制器基础类
 * 所有的控制器类都继承此基础类
 * 
 * @author      $Author: chengjian $
 * @version     $Id: Controller.php 9263 2011-07-22 12:07:57Z chengjian $
 * @filesource
 * @package     imedia.components 
 * @since 1.0.0
 */
class Controller extends CController
{
	/**
	 * 默认布局视图
	 * 
	 * 文件位置 'protected/views/layouts/main.php'.
	 * 
     * @var string
	 */
	public $layout = 'main';
	
	/**
	 * 菜单项
	 * 
     * {@link CMenu::items}
	 * @var array
	 */
	public $menu = array();
	
	/**
	 * 自定义表单菜单项
	 * 
     * {@link CMenu::items}
	 * @var array
	 */
	public $menusCustomizeRepot = array();
	
	/**
     * 用户菜单项
     * 
     * {@link CMenu::items}
     * @var array
     */
//    public $userMenus = array();
    
	/**
	 * 面包屑
	 * 
     * {@link CBreadcrumbs::links}
     * 
	 * @var array
	 */
	public $breadcrumbs = array();

	/**
	 * 
	 * 切换语言链接
	 * @var String
	 */
	public $languageLink = '';
	
	/**
     * 
     * 切换语言标题
     * @var String
     */
    public $languageTitle = '';

    /**
     * 
     * 切换Theme链接
     * @var String
     */
    public $themeLink = '';
    
    /**
     * 
     * 切换Theme标题
     * @var String
     */
    public $themeTitle = 'default';

    public $title = '';
    
    public $helpContent;

    public $helpLink = '';
        
    private $_widgetStack=array();
    
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users'=>array('@'),
            )
        );
    }
    
	public function init(){
        //注册核心js jquery
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/thickbox.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/thickbox.js');
        
        //初始化语言
        $this->initLanguage();
        
        if(isset($_GET['pagerSize'])){
            Yii::app()->params['perPage'] = $_GET['pagerSize'];
        }
        //设置theme
        $this->initTheme();
        parent::init();
    }
    
    /**
     * action 回调函数
     * @see protected/libs/web/CController::beforeAction()
     */
    public function beforeAction($action){
        //自定义面包屑
        $this->initBreadcrumbs();
        //$this->setHelpLink();
        return true;
    }
    
    /**
     * 
     * 初始化菜单项
     */
    public function initLanguage(){
        //通过session，进行中英文转换
        if(isset($_GET['l']) && 'en'===$_GET['l']){
            Yii::app()->user->language = 'en';
//            $_SESSION['mms_language']='en';
        }
        else if(isset($_GET['l']) && 'cn'===$_GET['l']){
            Yii::app()->user->language = 'cn';
//            unset($_SESSION['mms_language']);
        }

        if(isset(Yii::app()->user->language) && 'en'==Yii::app()->user->language){
            Yii::app()->language = 'en';
            $this->languageTitle = '切换中文';
            $languageOld = 'cn';
        } else{
            Yii::app()->language='zh_cn';
            $this->languageTitle = 'English';
            $languageOld = 'en';
        }
        
        $arrUrl = parse_url(Yii::app()->getRequest()->url);
        if(isset($arrUrl['query'])){
            parse_str($arrUrl['query'], $arrQuery);
        }
        $arrQuery['l'] = $languageOld;

        if(Yii::app()->getRequest()->pathInfo != NULL){
            $this->languageLink = $this->createAbsoluteUrl(Yii::app()->getRequest()->pathInfo, $arrQuery);
        }
        else{
            $this->languageLink = '';
        }
        return TRUE;
    }

    /**
     * 
     * 初始主题皮肤
     */
    public function initTheme(){
        $session = Yii::app()->session;
        //通过session，进行中英文转换
        if(isset($_GET['theme']) && 'default'!==$_GET['theme']){
            $session['mms_theme'] = $_GET['theme'];
        }
        else if(isset($_GET['theme']) && 'default'===$_GET['theme']){
            unset($session['mms_theme']);
        }

        if('default'!==$session['mms_theme'] && NULL!==$session['mms_theme']){
            Yii::app()->setTheme($session['mms_theme']);
        } else{
            Yii::app()->setTheme('default');
        }
        
        $arrUrl = parse_url(Yii::app()->getRequest()->url);
        if(isset($arrUrl['query'])){
            parse_str($arrUrl['query'], $arrQuery);
            unset($arrQuery['theme']);
        }
        else{
            $arrQuery = array();
        }
        if(Yii::app()->getRequest()->pathInfo != NULL){
            $this->themeLink = $this->createAbsoluteUrl(Yii::app()->getRequest()->pathInfo, $arrQuery);
        }
        else{
            $this->themeLink = '';
        }
        return TRUE;
    }
    
    /**
     * 访问控制过滤器
     * 
     * 访问控制过滤器是检查当前用户是否能执行访问的controller action的初步授权模式。
     * 这种授权模式基于用户名，客户IP地址和访问类型
     * @return array 
     */

    /**
     * 
     * 自动配置breadcrumbs
     */
    public function initBreadcrumbs(){
        if($this->action->id == 'update'){
            $this->breadcrumbs=array(
//                Yii::app()->name => Yii::app()->homeUrl,
                Yii::t($this->id, $this->title) . Yii::t('basic','列表') => Yii::app()->createUrl($this->id.'/list'),
                Yii::t('basic','编辑'),
            );
        }
        elseif($this->action->id == 'create'){
            $this->breadcrumbs=array(
//                Yii::app()->name => Yii::app()->homeUrl,
                Yii::t($this->id, $this->title) . Yii::t('basic','列表') => Yii::app()->createUrl($this->id.'/list'),
                Yii::t('basic','新增'),
            );
        }
        elseif($this->action->id == 'list'){
            $this->breadcrumbs=array(
//                Yii::app()->name => Yii::app()->homeUrl,
                Yii::t($this->id, $this->title) . Yii::t('basic','列表'),
            );
        }
        elseif($this->action->id == 'view'){
            $this->breadcrumbs=array(
//                Yii::app()->name => Yii::app()->homeUrl,
                Yii::t($this->id, $this->title) . Yii::t('basic','列表') => Yii::app()->createUrl($this->id.'/list'),
                Yii::t('basic','查看'),
            );
        }
        elseif($this->action->id == 'manage'){
            $this->breadcrumbs=array(
//                Yii::app()->name => Yii::app()->homeUrl,
                Yii::t($this->id, $this->title) => Yii::app()->createUrl($this->id.'/list'),
                Yii::t('basic','管理'),
            );
        }
        elseif($this->action->id == 'setting'){
            $this->breadcrumbs=array(
//                Yii::app()->name => Yii::app()->homeUrl,
                Yii::t($this->id, $this->title) => Yii::app()->createUrl($this->id.'/list'),
                Yii::t('basic','设置'),
            );
        }
    }
    
    /**
     * 
     * 父页面跳转
     * @param $url
     */
    public function topRedirect($url){
        if(is_array($url))
        {
            $route=isset($url[0]) ? $url[0] : '';
            $url=$this->createUrl($route,array_splice($url,1));
        }
        $htm = "<script>\n";
        $htm .= "top.location.replace('$url');\n";
        $htm .= "</script>";
        echo $htm;
    }
    
    /**
     * 
     * 首次登陆或密码过期将弹出密码确认框
     * @param $url
     */
    public function showThickboxDialog($title,$url){
        //$updatePwdUrl = $this->createUrl('/account/updatePwd'); 
        Yii::app()->clientScript->registerScript('showthickbox',
            '$(document).ready(function()
            {tb_show("'.$title.'","'.$url.'","thickbox");
            });'
        );
    }
    
    /**
     * 获得帮助页面
     * Enter description here ...
     */
    public function setDefaultHelpInfo(){
        if($this->helpContent == ''){
            $this->helpContent = Yii::t('basic', '默认帮助信息');
        }
    }
    
    public function setHelpLink(){
        $arrUrl = parse_url(Yii::app()->getRequest()->url);
        $this->helpLink  = $arrUrl['path'].'#TB_inline?height=300&width=300&inlineId=help';
        return $this->helpLink;
    }
    
    public function getDisableImage($disable){
        if($disable == 0){
            Chtml::image('images/greenlight.gif');
        }
        elseif($disable == 1){
            Chtml::image('images/lightred.gif');
        }
    }
    
    public function getUserCustomizeReportMenus(){
    	MediaManager_UserCustomizeReport::model()->findAllByAttributes(array(
    		'userid' => Yii::app()->user->id,
    	),array(
    		'order' => 'weight DESC'
    	));
    }
    
    public function beginWidget($className,$properties=array())
    {       
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jQuery.niceTitle.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/validator/jquery.listen.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/validator/jquery.progressbar.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/validator/cn/dict.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/validator/jquery.validate.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/validator/jquery-extendvalidate.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/validator/jquery-inputlenstatus.js');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jQuery.niceTitle.css');
            
        $widget=$this->createWidget($className,$properties);
        $this->_widgetStack[]=$widget;
	return $widget;
    }
        
    public function endWidget($id='')
    {
        if(($widget=array_pop($this->_widgetStack))!==null)
	{
            $form_id = (isset($widget->htmlOptions['id'])) ? $widget->htmlOptions['id'] : 0;          
            $form_target = (isset($widget->htmlOptions['target'])) ? $widget->htmlOptions['target'] : '';           
            $form_type = (isset($widget->htmlOptions['widget_type'])) ? $widget->htmlOptions['widget_type'] : '';
			$errorPlace =  (isset($widget->htmlOptions['errorPlace'])) ? $widget->htmlOptions['errorPlace'] : 'error.appendTo( element.closest("td.textTd").next("td.errorTd"));';

            echo Html::hiddenField('form_id_flag',$form_id);
            $widget->run();        
            if ($form_type == 'form')
            {        
                print<<<EOF
                <iframe name='$form_target' style="width:0;height:0;overflow:hidden;" width="0" height="0" frameBorder="0" ></iframe>
                <script>
                $(function(){ 
                    var _form = $("#$form_id");
					var \$serverDealing = \$('#serverdealing');
					if(!\$serverDealing.size()){
						\$serverDealing = \$('<div class="fbdialog_win serverdealing" id="serverdealing">正在发送...</div>');
						\$serverDealing.css({
							marginLeft: '-30px',
							marginTop:'-15px',
							width:'60px',
							height:'30px'
						}).appendTo('body').hide();
					}

					var ajaxErrorQueue = [];

					_form.validate({
						success:'ok',
						errorPlacement: function(error, element) {						
							$errorPlace
						},
						invalidHandler: function(e, validator){
							iMediaWin.alert({title:'错误提示',content:'表单填写有错误！',cancel:'关闭'});
							ajaxErrorQueue.length = 0;
						},
						submitHandler:function(form){
							if(ajaxErrorQueue.length){
								$.each(ajaxErrorQueue,function(i,itm){
									_jpAjaxError(itm.itm,0,itm.error);
								});
								iMediaWin.alert({title:'错误提示',content:'表单填写有错误！',cancel:'关闭'});
								return;
							}
							\$('#serverdealing').fadeIn();
							form.submit();
						}
					});
					_form.welcomeInputLenStatus();
					_form.extendvalidate(); 
					_form.find('span.jp_tip').niceTitle({showLink: false, clickShow:'fast'});

					var _jpAjaxError = function(input,isOk,data){
						if(isOk){
							\$(input).closest('td.textTd').next('td.errorTd').find('label.error').addClass('ok');						
						}else{
							\$(input).closest('td.textTd').next('td.errorTd').find('label.error').removeClass('ok').html(data);
						}
					};

					_form.find('input[remotea],select[remotea]').blur(function(){
							var _self = this;
							var validator = \$.data(_self.form, 'validator'); 
							if(!validator.check($(_self))) return;
							var v =\$(this).val();
							var moduleUrl = \$(this).attr('remotea');
							var defaultRecord = \$(this).attr('updateRecord');
                                                        var name = \$(this).attr('name');
							v = \$.trim(v);
							
							\$.ajax({
								url: moduleUrl,
								data: "name = " + name + "&value = " + v + "&defaultRecord = " + defaultRecord,
								type: "GET",
								dataType: "json",
								timeout: 30000,
								error: function(){
											
								},
								success: function(data){
										if(!validator.check($(_self)))return;
										if(data===true){
												var newQueue = [];
												_jpAjaxError(_self,1);
												$.each(ajaxErrorQueue,function(i,itm){
													if(itm.itm != _self){
														newQueue.push({
																		itm:itm.itm,
																		ovalue:itm.ovalue,
																		error:itm.error
																	});
													}
												});
												ajaxErrorQueue.length = 0;
												ajaxErrorQueue = newQueue;
												newQueue = null;
										}else{
												_jpAjaxError(_self,0,data);		
											
												ajaxErrorQueue.push({
													itm:_self,
													ovalue:v,
													error:data
												});
										}
								}
							});
					});

					_form.bind('data-server-response',function(){
						var json =  arguments[1] || {}; 
						if(json.result){
							iMediaWin.alert({title:'提示',content:json.msg,cancel:'关闭',cancelCb:function(){if(json.url)window.location.href = json.url;}});
						}else{
							 iMediaWin.alert({title:'提示',content:json.msg,cancel:'关闭'});
							\$(this).validate().showErrors(json.data);
						}
						if(ajaxErrorQueue) ajaxErrorQueue.length = 0;
					});

					if(!window.formCallBack)window.formCallBack ={};
					window.formCallBack['$form_id'] = function(data){
						\$serverDealing.fadeOut('fast',function(){\$(this).hide();});
						_form.trigger('data-server-response',data);
					};
		 

          });
                </script>          
EOF;
            }
            else
            {
                return $widget;
            }
            
	}
	else
        {
            throw new CException(Yii::t('yii','{controller} has an extra endWidget({id}) call in its view.',
		array('{controller}'=>get_class($this),'{id}'=>$id)));
        }    
    }
    
    public function CallbackSuccessReturn($url)
    {
        $return_array = array(
            'result' => 1,
            'msg' => Yii::t('basic', '操作成功！'),
            'url' => $url
        );

        $this->AllyesformCallBack($return_array);
    }
    
    public function CallbackErrorReturn($tableName,$orgErrors)
    {
        $datas = array();
        foreach($orgErrors as $key => $orgError)
        {
            if (is_array($orgError))
            {
                $datas[$tableName.'['.$key.']'] = $orgError[0];
            }
            else
            {
                $datas[$tableName.'['.$key.']'] = $orgError;
            }    
        }    

        $return_array = array(
            'result'=> 0,
            'msg' => Yii::t('basic', '操作失败！'),
            'data' => $datas
        );
        $this->AllyesformCallBack($return_array);
    }
    
    public function AllyesformCallBack($return_array)
    {
        $form_id = $_POST['form_id_flag'];
        echo '<script>parent.formCallBack["'.$form_id.'"]('.CJSON::encode($return_array).');</script>';
        die;
    }
    
    public function AllyesFrameCallBack($url)
    {
        $form_id = $_POST['form_id_flag'];
        $return_array = array(
            'result'=> 0,
            'msg' => Yii::t('basic', '操作成功！'),
            'data' => ''
        );
        echo '<script>parent.formCallBack["'.$form_id.'"]('.CJSON::encode($return_array).');</script>';
        echo '<script>parent.parent.tb_remove(false)</script>';
        echo "<script>parent.parent.location='$url';</script>";
        die;
    }
    
    public function actionAjaxVerifyUnique(){

        $msg = '';
        $names = isset($_GET['name_'])?$_GET['name_']:'';
        $value = isset($_GET['value_'])?trim($_GET['value_']):'';
        $defaultRecord = isset($_GET['defaultRecord_'])?trim($_GET['defaultRecord_']):'';

        if ($names && $value)
        {
            $names = str_replace(']', '', $names);
            $name_array = explode('[', $names);
            $model = trim($name_array[0]);
            $name = trim($name_array[1]);
 
            $models = new $model;
            $value_t = $value;

            if ($defaultRecord && ($defaultRecord == $value))
            {
                $msg = true;
            }
            else
            {
                $data = $models->findByAttributes(array($name => $value_t));
                if ($data)
                {
                    $attributesName = $models->getAttributeLabel($name);
                    $msg = Allyes::t('basic',$attributesName.'"'.$value.'"已存在.');
                }    
                else
                {
                    $msg = true;
                }  
            }      
        }
        else
        {
            $msg = Allyes::t('basic','必填');
        }
        echo CJSON::encode($msg); 
    }
    
      
    /**
     * 
     * 初始化用户菜单项
     */
//    public function initUserMenus(){
//        $userMenus = MediaManager_UserMenus::model()->findAllByAttributes(array('userID'=>Yii::app()->user->ID));
//        foreach($userMenus){
//            $this->userMenus = 
//        }
//        var_dump($userMenus);
//        return TRUE;
//    }
}