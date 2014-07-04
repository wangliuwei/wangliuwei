<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0025)http://www.topjet.com.cn/ -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>上海均质机</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<LINK 
rel=stylesheet type=text/css 
href="<?php echo Yii::app()->request->baseUrl; ?>/css/index.css">
<SCRIPT type=text/javascript 
src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.3.2.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="<?php echo Yii::app()->request->baseUrl; ?>/js/nav.js"></SCRIPT>

<META name=GENERATOR content="MSHTML 8.00.6001.19088"></HEAD>
<BODY style="BACKGROUND-REPEAT: repeat-x" 
background=<?php echo Yii::app()->request->baseUrl; ?>/images/index_bg.jpg>
<DIV id=container>
<DIV id=idx_top>
<DIV class=top_banner></DIV>
</DIV>
<DIV id=idx_banner>
<DIV class=nav>
<UL>
    <LI class=nav_lift><A href="<?php echo Yii::app()->request->baseUrl; ?>/index.php">首页 
</A></LI>
<?php
	//$models = Tb_category::model()->findAllByAttributes(array('GID'=>0));
	$criteria=new CDbCriteria;
	$criteria->order = 't.ID desc';
	$criteria->limit = 6;
	$criteria->addCondition("t.GID = 0");
	$models = Tb_category::model()->findAll($criteria);
	if($models)
	{
		$i =0;
		$num = count($models);
		foreach($models as $model)
		{
			$i ++;
?>
    <LI class=nav_middle><A onfocus=this.blur(); 
  href="#"><?php echo $model->Name;?> 
		<?php
			$GModels = Tb_category::model()->findAllByAttributes(array('GID'=>$model->ID));
			if(!empty($GModels))
			{
				foreach($GModels as $GModel)
				{
		?>	
			<UL style="Z-INDEX: 99">
				<LI class=nav_box href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/index/list?categoryID=<?php echo $GModel->ID?>"><?php echo $GModel->Name;?></LI>
			</UL>
		<?php
				}
			}
		?>
	</A></LI>
<?php
		}
	}
?>
<LI class=nav_right><A onfocus=this.blur(); 
  href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/index/about">关于我们</A> </LI>
</UL>
</DIV>
  <?php echo $content?>
  <DIV 
id=idx_footer>上海拓景信息科技有限公司　地址：上海市浦东新区（张江高科技园区）晨晖路377弄159号<BR>电话：021-50270659　 
传真：021-50270691<BR>沪ICP备10031429号</DIV></DIV></BODY></HTML>