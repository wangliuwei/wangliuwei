<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'NewForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form','enctype'=>'multipart/form-data'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'Name'); ?><span  title='焦点图片的名称,为必填项' class="jp_tip">&nbsp;</span>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'Name',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>	
	</tr>
	<tr>
		<td  class="titleTd" valign="top">
			<?php echo Html::label(Yii::t('basic','上传图片'),'上传图片')?><span  title='图片地址。' class="jp_tip">&nbsp;</span>
		</td>
		<td	 class="textTd" >
			<?php echo Html::fileField('Tb_new[Image]',$model->Image)?>
			<div class="input_c">
					<?php if($model->Image != '' && isset($model)){?>
					<img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->Image; ?>" width=200 height = 200/>
				<?php }?>
			</div>
		</td>
		<td class="errorTd"></td>
	</tr>
	<tr>
		<td  class="titleTd" >
			<?php echo $form->labelEx($model,'Url'); ?><span  title='链接' class="jp_tip">&nbsp;</span>
		</td>
		<td	 class="textTd" >
			<div class="input_c">
				<?php echo $form->textField($model,'Url',array('size'=>20,'maxlength'=>255)); ?>	
			</div>
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
			<button onclick="window.location.href='<?php echo Yii::app()->baseUrl ?>/index.php/admin_xxx/focusPicture/list'; return false;"><?php echo Yii::t('basic','返回')?></button>
		</span>
    </p>
</div>
<?php $this->endWidget(); ?>