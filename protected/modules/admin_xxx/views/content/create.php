<?php
$this->breadcrumbs=array(
	'内容列表' => Yii::app()->createUrl('content/list'),
	'新增'
);
?>
<div class="form_post">
 <h2><?php echo Yii::t('basic', '新增内容');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'parent_id'=>$parent_id,
    'arrPrioritys' => $arrPrioritys
)); ?>
</div>