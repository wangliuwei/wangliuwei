<?php
$this->breadcrumbs=array(
	'内容列表' => Yii::app()->createUrl('content/list'),
	'编辑'
);
?>
<h2 class="title"><?php echo Yii::t('basic', '编辑内容');?>:<?php echo Html::encode($model->title);?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
	'parent_id' =>$parent_id,
    'arrPrioritys' => $arrPrioritys
)); ?>