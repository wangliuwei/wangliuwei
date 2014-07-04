<?php
	Yii::app()->clientScript->registerCssFile(yii::app()->baseUrl.'/css/assets.css');
	Yii::app()->clientScript->registerCssFile(yii::app()->baseUrl.'/css/news_list.css');
?>
<div class="block">
<div class="left_box l">
<h2>酒文化</h2>
<ul>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/company">公司简介</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/list">酒文化</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/about">联系我们</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/map">站内地图</a></li>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/blog/list">博客链接</a></li>
</ul>
</div>
<div class="right">
	<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php" style="color: #CC0001;">首页</a> >>酒文化</p>
  <div class="news">
  	<h4><?php echo $title;?></h4>
    <?php echo $Content;?>
  </div>
</div>
<div class="blank10"></div>
</div>