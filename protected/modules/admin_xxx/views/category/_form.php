<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'NewForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'title'); ?>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'title',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>	
	</tr>
	<tr>
		<td  class="titleTd" >
			<?php echo $form->labelEx($model,'gid'); ?>
		</td>
		<td	 class="textTd" >
			<div class="input_c">
				<?php echo $form->dropDownList($model,'gid',$parentData);?>
			</div>
		</td>
		<td class="errorTd"></td>
	</tr>
</table>
	<p class="sub">
		<?php if($model->isNewRecord != 1){
			echo $form->hiddenField($model,'id');
		}?>
		<span class="btn bigred" style="float:left">
			<?php echo Html::submitButton($model->isNewRecord ? Yii::t('basic','创建') : Yii::t('basic','保存'),array('class'=>'sub red'));?>
		</span>
		<span class="btn" style="margin-top:4px">
			<button onclick="window.location.href='<?php echo Yii::app()->baseUrl ?>/index.php/admin_xxx/category/list'; return false;"><?php echo Yii::t('basic','返回')?></button>
		</span>
    </p>
</div>
<?php $this->endWidget(); ?>