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
<div class="right_box r">
    <p><a href="<?php echo Yii::app()->request->baseUrl; ?>">首页</a> >> <?php echo $title;?></p>
    <div class="box">
        <div class="product_mes">
            <h2><?php echo $name;?></h2>
            <p><?php echo $Content;?></p>
        </div>
    </div>
</div>
<div class="blank10"></div>
</div>