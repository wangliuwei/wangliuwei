<div class="blank10"></div>
<div class="block">
<div class="left_box l">
<h2>白酒</h2>
<ul>
<?php 
    foreach ($models as $model) {
?>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/wine?category=<?php echo $model->GID;?>&categoryID=<?php echo $model->ID;?>"><?php echo $model->Name;?></a></li>
<?php
    }
?>
</ul>
</div>
<div class="right_box r">
<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php">首页</a> >> <?php echo $title;?></p>
<div class="box">
<div class="product_mes">
<h2>详细介绍</h2>
<table>
  <tr>
    <td rowspan="2" class="bord" width="240" height="240"><img width="240" height="240" alt="<?php echo $title;?>" title="<?php echo $title;?>" src="<?php echo Yii::app()->baseUrl.'/'.$image;?>" /></td>
    <td class="tit"><?php echo $title;?></td>
  </tr>
  <tr>
    <td><p><?php echo $description;?></p></td>
  </tr>
</table>
<h3>产品说明:</h3>
<p><?php echo $content;?></p>
</div>
</div>
</div>
</div>
<div class="blank10"></div>
