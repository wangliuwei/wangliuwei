<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'userForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form')
));?>
<h2><?php echo $model->id?Yii::t('basic', '编辑账号:') . Html::encode($model->username):Yii::t('basic', '新增账号');?><span>(</span><span class="required">*</span><span><?php echo Yii::t('basic', '为必填项');?>)</span></h2>
<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'username'); ?>&nbsp;</span>
		</td>
		<td class="textTd">
			<?php echo $form->textField($model,'username'); ?>
		</td>
		<td class="errorTd"></td>
	</tr>
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'password'); ?><span  title='登录广告系统时需要验证登录者身份合法性的密码以及密码的安全性,为必填项' class="jp_tip">&nbsp;</span>
		</td>
		<td class="textTd">
			<?php echo $form->passwordField($model,'password'); ?>
		</td>
		<td class="errorTd"></td>
	</tr>
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'passwordConfirm'); ?><span  title='登录广告系统的密码确认，与密码输入一致,为必填必选项' class="jp_tip">&nbsp;</span>
		</td>
		<td class="textTd">
			<?php echo $form->passwordField($model,'passwordConfirm'); ?>
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
			<button onclick="window.location.href='<?php echo Yii::app()->baseUrl ?>/index.php/admin_xxx/user/list'; return false;"><?php echo Yii::t('basic','返回')?></button>
		</span>
    </p>
	</div>
	
</div>
<?php $this->endWidget(); ?>