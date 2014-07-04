<?php
$this->breadcrumbs=array(
	'博客链接列表' => Yii::app()->createUrl('blog/list'),
	'新增'
);
?>
<div class="form_post">
 <h2><?php echo Yii::t('basic', '新增博客链接');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
)); ?>
</div>