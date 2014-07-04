<?php
	Yii::app()->clientScript->registerCssFile(yii::app()->baseUrl.'/css/assets.css');
	Yii::app()->clientScript->registerCssFile(yii::app()->baseUrl.'/css/news_list.css');
?>
<div class="block">
<div class="left_box l">
<h2><?php echo $title;?></h2>
<ul>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/company">公司简介</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/list">酒文化</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/about">联系我们</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/map">站内地图</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/blog/list">博客链接</a></li>
</ul>
</div>
<div class="right">
  <div class="map">
  	<h4>首页</h4>
    <ul>
    	<li><a href="http://www.zzjiulin.com">首页</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1">国内白酒</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=2">经典葡萄酒</a></li>  
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=3">国外洋酒</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/new/company">公司简介</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/new/list">酒文化</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/blog/list">博客链接</a></li>      
    </ul>
  	<h4>国内白酒</h4>
    <ul>
    	<li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=17">茅台</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=18">五粮液</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=20">汾酒</a></li>  
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=21">郎酒</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=23">剑南春</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=25">泸州老窖</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=26">仰韶彩陶坊</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=31">洋河</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=32">宋河</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=33">宝丰</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=34">国粹</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=35">古井</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=36">口子窖</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=37">舍得</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=39">二锅头</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=40">酒鬼</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=43">赊店</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=47">水井坊</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=48">杜康</a></li> 
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=1&categoryID=50">小糊涂仙</a></li>
    </ul>
        <h4>经典葡萄酒</h4>
    <ul>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=2&categoryID=29">张裕</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=2&categoryID=30">长城</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=2&categoryID=52">紫隆山</a></li>  
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=2&categoryID=53">王朝</a></li>
    </ul>
        <h4>国外洋酒</h4>
    <ul>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=3&categoryID=41">法国</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=3&categoryID=42">西班牙</a></li>
        <li><a href="http://www.zzjiulin.com/index.php/products/wine?category=3&categoryID=54">洋酒</a></li>  
    </ul>
  </div>
</div>
<div class="blank10"></div>
</div>