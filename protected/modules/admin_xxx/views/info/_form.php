<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'NewForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form','enctype'=>'multipart/form-data'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'title'); ?>
		</td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->textField($model,'title',array('size'=>20,'maxlength'=>255)); ?>
            </div>
        </td>
		<td class="errorTd"></td>	
	</tr>
    <tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'description'); ?>
		</td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->textArea($model,'description',array('maxlength'=>255)); ?>
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
</table>
	<p class="sub">
		<?php if($model->isNewRecord != 1){
			echo $form->hiddenField($model,'ID');
		}?>
		<span class="btn bigred" style="float:left">
			<?php echo Html::submitButton($model->isNewRecord ? Yii::t('basic','创建') : Yii::t('basic','保存'),array('class'=>'sub red'));?>
		</span>
    </p>
</div>
<?php $this->endWidget(); ?>