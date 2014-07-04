<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'ContactForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form'))); ?>

<div class="form_post_in">
<table border=0 class="formTable"  width=100% cellspacing="2" >
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'content'); ?>
        </td>
        <td class="textTd" >
            <div class="input_c">
                <?php
                    $this->widget('application.extensions.ckeditor.CKEditorWidget',array(
                        "model"=>$model,
                        "attribute"=>'content',
                        "defaultValue"=>$model->content,
                        "config" => array(
                            "height"=>"300px",
                            "width"=>"800px",
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
            echo $form->hiddenField($model,'id');
        }?>
        <span class="btn bigred">
            <?php echo Html::submitButton(Yii::t('basic','保存'),array('class'=>'sub red'));?>
        </span>
    </p>
</div>
<?php $this->endWidget(); ?>