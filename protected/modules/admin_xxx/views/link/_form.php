<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'LinkForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form','enctype'=>'multipart/form-data'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'name'); ?>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>	
	</tr>
    <tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'link'); ?>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'link',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>
	</tr>
</table>
	<p class="sub">
		<?php if($model->isNewRecord != 1){
			echo $form->hiddenField($model,'ID');
		}?>
		<span class="btn bigred" style="float:left">
			<?php echo Html::submitButton($model->isNewRecord ? Yii::t('basic','创建') : Yii::t('basic','保存'),array('class'=>'sub red'));?>
		</span>
		<span class="btn" style="margin-top:4px">
			<button onclick="window.location.href='<?php echo Yii::app()->baseUrl ?>/index.php/new/list'; return false;"><?php echo Yii::t('basic','返回')?></button>
		</span>
    </p>
</div>
<?php $this->endWidget(); ?>