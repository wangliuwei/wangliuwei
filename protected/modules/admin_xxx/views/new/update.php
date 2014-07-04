<?php
$this->breadcrumbs=array(
	'新闻列表' => Yii::app()->createUrl('new/list'),
	'编辑'
);
?>
<h2 class="title"><?php echo Yii::t('basic', '编辑新闻');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
)); ?>