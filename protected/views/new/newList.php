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
<p style="padding-top:3px"><a href="<?php echo Yii::app()->request->baseUrl; ?>" style="color: #CC0001">首页</a> >> 酒文化</p>
  <div class="search_result">
    <ul>
	<?php
		foreach ($models as $model){
	?>
		<li>
			<h2><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/info?ID=<?php echo $model->ID;?>"><?php echo $model->Name;?></a></h2>
					<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/new/info?ID=<?php echo $model->ID;?>"><?php echo Allyes::mystrcut($model->Content,120)?></a></p>	
		</li>
	<?php }?>
	</ul>
  </div>
  <div style="float:right; margin-top:5px;"><?php echo $page->show();?></div>
</div>
<div class="blank10"></div>
</div>