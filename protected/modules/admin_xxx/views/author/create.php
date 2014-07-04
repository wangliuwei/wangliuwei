<?php
$this->breadcrumbs=array(
	'作者列表' => Yii::app()->createUrl('author/list'),
	'新增'
);
?>
<div class="form_post">
 <h2><?php echo Yii::t('basic', '新增作者');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'parentData' =>$parentData,
)); ?>
</div>