<?php
$this->breadcrumbs=array(
	'博客链接列表' => Yii::app()->createUrl('blog/list'),
	'编辑'
);
?>
<h2 class="title"><?php echo Yii::t('basic', '编辑博客链接');?>:<?php echo Html::encode($model->Name);?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
)); ?>