<?php
$this->breadcrumbs=array(
	'焦点图片列表' => Yii::app()->createUrl('FocusPicture/list'),
	'新增'
);
?>
<div class="form_post">
 <h2><?php echo Yii::t('basic', '新增焦点图片');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'parent_id'=>$parent_id,
)); ?>
</div>