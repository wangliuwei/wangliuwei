<?php
    // Yii::app()->controller->action->id;
    // Yii::app()->controller->id;
?>
<div class="blank10"></div>
<div class="block">
<div class="left_box l">
<h2><?php echo $title;?></h2>
<ul>
<?php
    foreach ($arrCategoryName as $key=>$Category) {
?>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/wine?category=<?php echo $category;?>&categoryID=<?php echo $key;?>"><?php echo $Category;?></a></li>
<?php
    }
?>
</ul>
</div>
<div class="right_box r">
<p><a href="#">首页</a> >> <?php echo $title;?></p>
<div class="box">
    <div class="product_best">
        <div class="PopBorder BestP clearfix">
            <h3 class="BestT"><?php echo $_title;?></h3>
            <div id="demo" class="new fl" >
                <?php
                    if(!empty($products)){
                        foreach ($products as $product) {
                ?>
                    <ul class="goodsbox">
                        <li class="imgbox">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/info?ID=<?php echo $product->ID;?>"><img width="160" height="160" title="<?php echo $product->name;?>" alt ="<?php echo $product->name;?>" src="<?php echo Yii::app()->baseUrl.'/'.$product->image;?>" /></a>
                        </li>
                        <li class="a_title"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/products/info?ID=<?php echo $product->ID;?>"><?php echo $product->name;?></a></li>
                        <li class=".a_descript">
                            <p>
                                <span>原价:</span>
                                <span class="pr1">￥<?php echo $product->actualprice;?></span>
                                <span>活动价:</span>
                                <span class="pr2">￥<?php echo $product->price;?></span>
                            </p>
                        </li>
                    </ul>
                <?php
                        }
                    }else{
                        echo '暂无内容添加';
                    }
                ?>
            </div>
        </div>
    </div>
    <div style="float:right; margin-top:5px;"><?php echo $page->show();?></div>
</div>
</div>
</div>
<div class="blank10"></div>
