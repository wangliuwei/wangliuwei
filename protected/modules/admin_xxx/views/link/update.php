<?php
$this->breadcrumbs=array(
	'友情链接列表' => Yii::app()->createUrl('link/list'),
	'编辑'
);
?>
<h2 class="title"><?php echo Yii::t('basic', '编辑友情链接');?>:<?php echo Html::encode($model->name);?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
)); ?>