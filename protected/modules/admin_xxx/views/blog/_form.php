<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'NewForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form','enctype'=>'multipart/form-data'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'Name'); ?><span  title='博客链接的名称,为必填项' class="jp_tip">&nbsp;</span>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'Name',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>	
	</tr>
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'Url'); ?>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'Url',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>	
	</tr>
    <tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'keytitle'); ?>
		</td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->textField($model,'keytitle',array('maxlength'=>80)); ?>
            </div>
        </td>
		<td class="errorTd"></td>	
	</tr>
    <tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'keywords'); ?>
		</td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->textArea($model,'keywords',array('maxlength'=>255)); ?>
            </div>
        </td>
		<td class="errorTd"></td>	
	</tr>
    <tr>
    <td class="titleTd">
			<?php echo $form->labelEx($model,'keycontent'); ?>
		</td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->textArea($model,'keycontent',array('maxlength'=>255)); ?>
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
			<button onclick="window.location.href='<?php echo Yii::app()->baseUrl ?>/index.php/admin_xxx/blog/list'; return false;"><?php echo Yii::t('basic','返回')?></button>
		</span>
    </p>
</div>
<?php $this->endWidget(); ?>