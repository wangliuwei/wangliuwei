<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'NewForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form','enctype'=>'multipart/form-data'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
	<tr>
		<td class="titleTd">
			<?php echo $form->labelEx($model,'Name'); ?><span  title='新闻的名称,为必填项' class="jp_tip">&nbsp;</span>
		</td>
		<td class="textTd">	
			<?php echo $form->textField($model,'Name',array('size'=>20,'maxlength'=>255)); ?>		
		</td>
		<td class="errorTd"></td>	
	</tr>
	<tr>
		<td  class="titleTd" >
			<?php echo $form->labelEx($model,'Content'); ?>
		</td>
		<td	 class="textTd" >
			<div class="input_c">
				<?php 
					$this->widget('application.extensions.ckeditor.CKEditorWidget',array(
					  "model"=>$model,
					  "attribute"=>'Content',
					  "defaultValue"=>$model->Content, 					  
					  "config" => array(
						  "height"=>"400px",
						  "width"=>"800px",
						  //"toolbar"=>"Basic",
						  ),
					  "ckEditor"=>Yii::app()->basePath."/../ckeditor/ckeditor.php",
					  "ckBasePath"=>Yii::app()->baseUrl."/ckeditor/",
					  ) );
				  ?> 
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