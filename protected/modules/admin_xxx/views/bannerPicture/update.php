<?php
$this->breadcrumbs=array(
	'横幅图片列表' => Yii::app()->createUrl('BannerPicture/list'),
	'编辑'
);
?>
<h2 class="title"><?php echo Yii::t('basic', '编辑横幅图片');?>:<?php echo Html::encode($model->Name);?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
	'parent_id' =>$parent_id,
)); ?>