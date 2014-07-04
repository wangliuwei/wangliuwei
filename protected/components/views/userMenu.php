<ul id="usermenus" class="tabarlevel">
    <li class="nav_menu_li"><?php echo Html::link('收藏夹',array('MediaCenter/FavoritesIndex')); ?>
    <ul>
        <li><?php echo Html::link(Yii::t('basic','添加当前页到收藏夹'),array('userMenus/create?KeepThis=true&TB_iframe=true&height=300&width=960'),array('class'=>'thickbox')); ?></li>
        <li><?php echo Html::link(Yii::t('basic','管理收藏夹'),array('userMenus/list?MediaManager_UserMenus_sort=ID.desc&ajax=datalist')); ?></li>
        <?php $i=0; foreach($usermenus as $usermenu){ $i++; ?>
			<?php if($i>5){?>
				<li>
					<a href="#"><?php echo "..."?></a>
				</li>
			<?php break; }?>
            <li>
            <a href="<?php echo $usermenu->link?>"><?php echo Allyes::mystrcut($usermenu->title,8)?></a>
            <?php //echo Html::link($usermenu->title,array($usermenu->link)); ?>
            </li>
        <?php }?>
    </ul>
    </li>
</ul>