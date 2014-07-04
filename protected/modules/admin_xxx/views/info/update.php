<?php
$this->breadcrumbs=array(
	'首页SEO配置'
);
?>
<h2 class="title"><?php echo Yii::t('basic', '编辑首页SEO配置');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
)); ?>