<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl?>/css/admin_css.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/menu.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/supersubs.js"></script>
</head>
<body>

<div class="header">
    <ul class="op">
      <li><?php echo CHtml::linkButton(Yii::t('basic', '退出'),array(
            'submit' => Yii::app()->createUrl('site/logout'),
            'confirm' => Yii::t('basic', '是否退出'),
      		'id' => 'logout'
        ));?></li>
    </ul>
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div id="message" class="message">
    &nbsp;<?php echo Yii::app()->user->getFlash('success')?>
    </div>
    <?php }?>
    <?php
    //提示信息3秒后自动隐藏
    Yii::app()->clientScript->registerScript(
       'myHideEffect',
       '$(".message").animate({opacity: 1.0}, 3000).fadeOut("slow");',
       CClientScript::POS_READY
    );
    ?>
</div>
<div class="nav" id="mainmenu" style="position:relative;z-index:20;">
  <div class="nav_in">
  <span class="nav_l"></span>

  <?php
        $menus = array(
            array('label'=>Yii::t('menu','作者管理'), 'url'=>'', 'items'=>array(
                array(
                    'label'=>Yii::t('menu','新增作者'),
                    'url'=>array('author/create'),
                ),
                array(
                    'label'=>Yii::t('menu','作者列表'),
                    'url'=>array('author/list'),
                ),
            ),'itemOptions' => array('class'=>'nav_menu_li throw')),
            array('label'=>Yii::t('menu','分类管理'), 'url'=>'', 'items'=>array(
                array(
                    'label'=>Yii::t('menu','新增分类'),
                    'url'=>array('category/create'),
                ),
                array(
                    'label'=>Yii::t('menu','分类列表'),
                    'url'=>array('category/list'),
                ),
            ),'itemOptions' => array('class'=>'nav_menu_li throw')),
            array('label'=>Yii::t('menu','内容管理'), 'url'=>'', 'items'=>array(
                array(
                    'label'=>Yii::t('menu','新增内容'),
                    'url'=>array('content/create'),
                ),
                array(
                    'label'=>Yii::t('menu','内容列表'),
                    'url'=>array('content/list'),
                ),
            ),'itemOptions' => array('class'=>'nav_menu_li origin')),
           array('label'=>Yii::t('menu','新闻管理'), 'url'=>'', 'items'=>array(
                array(
                    'label'=>Yii::t('menu','新增新闻'),
                    'url'=>array('new/create'),
                ),
                array(
                    'label'=>Yii::t('menu','新闻列表'),
                    'url'=>array('new/list'),
                ),
            ),'itemOptions' => array('class'=>'nav_menu_li origin')),
            array('label'=>Yii::t('menu','联系我们'), 'url'=>'', 'items'=>array(
                array(
                    'label'=>Yii::t('menu','联系我们'),
                    'url'=>array('new/contact'),
                ),
            ),'itemOptions' => array('class'=>'nav_menu_li origin')),
            array('label'=>Yii::t('menu','管理员管理'), 'url'=>'', 'items'=>array(
                 array(
                    'label'=>Yii::t('menu','新增管理员'),
                    'url'=>array('user/create'),
                ),
                 array(
                    'label'=>Yii::t('menu','管理员列表'),
                    'url'=>array('user/list'),
                ),
            ),'itemOptions' => array('class'=>'nav_menu_li orderform')),
        );
        $this->widget('zii.widgets.CMenu',array(
            'id' => 'menu',
            'items'=> $menus,
            'htmlOptions' => array('class'=>'tabarlevel '),
            'encodeLabel' => false,
        ));?>
		<span class="nav_r"></span>
  </div>

</div>
<div class="con">
<?php if(!empty($this->breadcrumbs)){?>
  <div class="crumb">
  <?php
	  $this->widget('Breadcrumbs', array(
	    'links' => $this->breadcrumbs,
	    'tagName' => 'ul',
	    'separator' => '',
	  ));
  ?>
  </div>
  <?php }?>
  <div class="con_in"><?php echo $content?></div>
  <div class="con_foot"></div>
</div>

<div class="foot">
  <p><?php echo Yii::app()->params->copyrightInfo?></p>
</div>
</body>
</html>