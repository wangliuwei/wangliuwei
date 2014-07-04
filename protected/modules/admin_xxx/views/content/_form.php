<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/ajaxupload.js"></script>
<?php $form=$this->beginWidget('ActiveForm',array(
'id'=>'ContentForm','htmlOptions'=>Array('target' => 'formtarget','widget_type'=>'form','enctype'=>'multipart/form-data'))); ?>
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
        <td class="titleTd">
            <?php echo $form->labelEx($model,'subTitle'); ?>
        </td>
        <td class="textTd">    
            <?php echo $form->textField($model,'subTitle',array('size'=>20,'maxlength'=>255)); ?>        
        </td>
        <td class="errorTd"></td>    
    </tr>
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'type'); ?>
        </td>
        <td class="textTd">
            <div class="input_c">
                <?php echo $form->radioButtonList($model,'type', array(1=>'图片',2=>'视频')) ;?>
            </div> 
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td  class="titleTd" >
            <?php echo $form->labelEx($model,'categoryID'); ?>
        </td>
        <td class="textTd" >
            <div class="input_c">
                <?php
                    echo $form->dropDownList($model,'categoryID',$parent_id);
                ?>
            </div>
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'showIndex'); ?>
        </td>
        <td class="textTd">
            <div class="input_c">
                <?php echo $form->radioButtonList($model,'showIndex', array(0=>'否',1=>'是')) ;?>
            </div> 
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'showAuthor'); ?>
        </td>
        <td class="textTd">
            <div class="input_c">
                <?php echo $form->radioButtonList($model,'showAuthor', array(0=>'否',1=>'是')) ;?>
            </div> 
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'showCategory'); ?>
        </td>
        <td class="textTd">
            <div class="input_c">
                <?php echo $form->radioButtonList($model,'showCategory', array(0=>'否',1=>'是')) ;?>
            </div> 
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd" valign="top">
            <?php echo Html::label(Yii::t('basic','首页图片'),'首页图片')?>
        </td>
        <td class="textTd" >
            <?php echo Html::fileField('Tb_Content[showImage]',$model->showImage)?>
            <div class="input_c" >
            </div>
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td colspan="3">
        <div id="indexImageShow" style="margin-left:230px;width:520px;">
            <?php 
                if($model->showImage != '' && isset($model)){
                    $showImages = explode(',',$model->showImage);
                    foreach($showImages as $showImage){
            ?>
                <div style="width:130px;float:left;">
                    <img width="100" height="100" src="<?php echo Yii::app()->request->baseUrl.'/'.$showImage; ?>" />
                    <a style="" href="javascript::void(0)" onclick="delImg(this)">删除</a>
                    <input type="hidden" name="showImage[]" value="<?php echo $showImage;?>">
                </div>
            <?php }}?>
        </div>
        </td>
    </tr>
    <!--tr>
        <td class="titleTd" >
            <?php //echo $form->labelEx($model,'showNum'); ?>
        </td>
        <td class="textTd" >
            <div class="input_c">
                <?php //echo $form->textField($model,'showNum',array('size'=>20,'maxlength'=>255)); ?>
            </div>
        </td>
        <td class="errorTd"></td>
    </tr-->
    <!--tr>
        <td  class="titleTd" >
            <?php echo $form->labelEx($model,'position'); ?>
        </td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->dropDownList($model,'position',array('1'=>'第一列','2'=>'第二列','3'=>'第三列','4'=>'第四列'));?>
            </div>
        </td>
        <td class="errorTd"></td>
    </tr-->
    <tr>
        <td class="titleTd" >
            <?php echo $form->labelEx($model,'priority'); ?>
        </td>
        <td class="textTd" >
            <div class="input_c">
                <?php echo $form->dropDownList($model,'priority',$arrPrioritys); ?>
            </div>
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'url'); ?>
        </td>
        <td class="textTd">
            <div class="input_c">
                <?php echo $form->textField($model,'url') ;?>
            </div> 
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd">
            <?php echo $form->labelEx($model,'jumpUrl'); ?>
        </td>
        <td class="textTd">
            <div class="input_c">
                <?php echo $form->textField($model,'jumpUrl') ;?>
            </div> 
        </td>
        <td class="errorTd"></td>
    </tr>
    <tr>
        <td class="titleTd" valign="top">
            <?php echo Html::label(Yii::t('basic','上传文件'),'上传文件')?><span  title='图片支持jpg,jpeg,gif,png<br/>视频支持avi,mp3,wma,flv,mp4,mkv' class="jp_tip">&nbsp;</span>
        </td>
        <td class="textTd" >
            <?php echo Html::fileField('Tb_Content[path]',$model->path)?>
            <div class="input_c" >
            </div>
        </td>
        <td class="errorTd"></td>
    </tr>
</table>
<div id="imageShow" style="margin-left:230px;width:520px;">
    <?php 
        if($model->path != '' && isset($model)){
            $paths = explode(',',$model->path);
            foreach($paths as $path){
    ?>
        <div style="width:130px;float:left;">
            <img width="100" height="100" src="<?php echo Yii::app()->request->baseUrl.'/'.$path; ?>" />
            <a style="" href="javascript::void(0)" onclick="delImg(this)">删除</a>
            <input type="hidden" name="imagePath[]" value="<?php echo $path;?>">
        </div>
    <?php }}?>
</div>
<div style="clear:left;"></div>
<p class="sub">
    <?php if($model->isNewRecord != 1){
        echo $form->hiddenField($model,'id');
    }?>
    <span class="btn bigred" style="float:left">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('basic','创建') : Yii::t('basic','保存'),array('class'=>'sub red'));?>
    </span>
    <span class="btn" style="margin-top:4px">
        <button onclick="window.location.href='<?php echo Yii::app()->baseUrl ?>/index.php/admin_xxx/content/list'; return false;"><?php echo Yii::t('basic','返回')?></button>
    </span>
</p>
</div>
<?php $this->endWidget(); ?>
<script>
$(function(){
    var imageObj = $('#Tb_Content_showImage');
    new AjaxUpload(imageObj, {  
        action: '<?php echo $this->createUrl('site/ajaxUpload')?>',  
        name: 'uploadfile',
        onSubmit: function(file, ext){  
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){   
                iMediaWin.alert({
                    title:'错误提示',
                    content:'图片格式错误！',
                    cancel:'确认'
                });
                return false;  
            }  
        },  
        onComplete: function(file, response){
            var jsonObj = JSON.parse(response);
            var status = jsonObj.status;
            var text = jsonObj.text;
            if(status =="1"){
            	var html = '<img width="100" height="100" src="<?php echo Yii::app()->request->baseUrl; ?>/'+text+'" alt="" />';
            		html += '<a style="" href="javascript::void(0)" onclick="delImg(this)">删除</a>';
            		html += '<input type="hidden" name="showImage[]" value="' + text + '">';
                	$('<div style="width:130px;float:left;"></div>').appendTo('#indexImageShow').html(html);
            } else{  
                iMediaWin.alert({
                    title:'错误提示',
                    content:text,
                    cancel:'确认'
                });
            }  
        }  
    });    
    var imageObj = $('#Tb_Content_path');
    new AjaxUpload(imageObj, {  
        action: '<?php echo $this->createUrl('site/ajaxUpload')?>',  
        name: 'uploadfile',
        //data:{type:$('input[name="Tb_Content[type]"]:checked').val()},
        // onSubmit: function(file, ext){  
            // if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){   
                // iMediaWin.alert({
                    // title:'错误提示',
                    // content:'图片格式错误！',
                    // cancel:'确认'
                // });
                // return false;  
            // }  
        // },  
        onComplete: function(file, response){
            var jsonObj = JSON.parse(response);
            var status = jsonObj.status;
            var text = jsonObj.text;
            if(status =="1"){
            	var html = '<img width="100" height="100" src="<?php echo Yii::app()->request->baseUrl; ?>/'+text+'" alt="" />';
            		html += '<a style="" href="javascript::void(0)" onclick="delImg(this)">删除</a>';
            		html += '<input type="hidden" name="imagePath[]" value="' + text + '">';
                	$('<div style="width:130px;float:left;"></div>').appendTo('#imageShow').html(html);
            } else{  
                iMediaWin.alert({
                    title:'错误提示',
                    content:text,
                    cancel:'确认'
                });
            }  
        }  
    });
    
});
function delImage(obj){
	$(obj).parent().empty();
}
</script>