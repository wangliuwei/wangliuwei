<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_keywords;?>" />
<meta name="Description" content="<?php echo $this->_description;?>" />
<title><?php echo $this->_title;?></title>
<LINK 
rel=stylesheet type=text/css 
href="<?php echo Yii::app()->request->baseUrl; ?>/css/style1.css">
<LINK 
rel=stylesheet type=text/css 
href="<?php echo Yii::app()->request->baseUrl; ?>/css/niutuku.css">
<LINK 
rel=stylesheet type=text/css 
href="<?php echo Yii::app()->request->baseUrl; ?>/css/common.css">
<SCRIPT type=text/javascript 
src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></SCRIPT>
<SCRIPT type=text/javascript 
src="<?php echo Yii::app()->request->baseUrl; ?>/js/niutuku.js"></SCRIPT>
</head>
<body>
<div id="header">
	<div class="topnav">
    	<div class="tit_adv l">郑州买酒就上酒林网，实惠，方便快捷!</div>
    </div>
    <div class="header">
    <div class="logo">
        <a href="#">
        <img alt="法国红酒,白酒,洋酒,葡萄酒,甜酒,起泡酒,红酒柜网购_买酒就上酒林网|中外名酒尽在酒林网" src="<?php echo Yii::app()->baseUrl; ?>/images/logo.png"></a>
    </div>
    </div>
    <div class="searchbox block">
	<div class="menu">
    	<span class="R"></span>
        <dl>
            <div id="category_tree">
            	<ul>
                <li style="margin-left:30px;">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php" class="<?php echo ($this->_css == 'index')?'cat':'cat_a';?>">首页</a>
                    </li>
                <li>
                    <a class="<?php echo ($this->_css == 'baijiu')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/wine?category=1">国内白酒</a>
                </li>
                 <li>
                    <a class="<?php echo ($this->_css == 'putaojiu')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/wine?category=2">经典葡萄酒</a>
                </li>
                 <li>
                    <a class="<?php echo ($this->_css == 'yangjiu')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/wine?category=3">国外洋酒</a>
                </li>
                <li>
                    <a class="<?php echo ($this->_css == 'company')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/company">公司简介</a>
                </li>
                <li>
                    <a class="<?php echo ($this->_css == 'culture')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/list">酒文化</a>
                </li>
				<li>
					<a class="<?php echo ($this->_css == 'blog')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/blog/list">博客链接</a>
                </li>
				<li>
					<a class="<?php echo ($this->_css == 'map')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/map">站内地图</a>
                </li>
                <li>
                    <a class="<?php echo ($this->_css == 'contactus')?'cat':'cat_a';?>" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/about">联系酒林</a>
                </li>
                </ul>
            </div>
        </dl>
        <span class="L"></span>
    </div>
</div>
</div>
<?php
    $bannerInfo = array();
    $bannerInfo = Tb_new::model()->getBannerInfo();
?>
<div id="dt_ad">
    <div class="dt_ad">
        <div class="ads fl">
            <a target="_blank" href="#">
                <img width="980" height="80" border="0" src="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $bannerInfo['Image']?>">
            </a>
        </div>
    </div>
</div>
<DIV id=floatTools class=float0831>
  <DIV id=divFloatToolsView class=floatR>
    <DIV class=tp></DIV>
    <DIV class=cn>
      <UL>
        <LI class=top>
          <H3 class=titZx>QQ咨询</H3>
        </LI>
        <LI><SPAN class=icoZx>在线咨询</SPAN> </LI>
        <LI><A class=icoTc target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=36120041&site=qq&menu=yes">联系我</A> </LI>
      </UL>
    </DIV>
  </DIV>
</DIV>
<?php echo $content?>
<div class="foot">
    <div style="line-height:30px;width:980px;margin:0 auto;">友情链接：
        <span>
        <?php
            $models = Tb_link::model()->findAll();
            $i = 0;
            $count = count($models);
            foreach ($models as $model) {
                $i++;
        ?>
            <a href="<?php echo $model->link?>"><?php echo $model->name?></a>
            <?php 
                if($i != $count){
                    echo '-';
                }
            ?>
        <?php }?>
        </span>
    </div>
	<div class="wine_foot">
    	<div class="block cl">
        	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/about">联系我们</a>
            |
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/company">公司简介</a>
            |
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/purchaseprotection">购物保障</a>
            |
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/privacyStatement">隐私声明</a>
        </div>
    </div>
</div>
<div style="width:980px; height:30px;line-height:30px;color:#333;font-size:12px;text-align:center;margin:0 auto;">&copy; 酒林网 zzjiulin.com All Rights Reserved  豫ICP备12008457号 </div>
  <script src="http://s96.cnzz.com/stat.php?id=4178838&web_id=4178838&show=pic" language="JavaScript"></script>
</body>
</html>