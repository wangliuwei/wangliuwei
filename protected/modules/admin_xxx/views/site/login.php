<?php $form=$this->beginWidget('ActiveForm',array(
    'id'=>'login-form',
    'enableAjaxValidation'=>true
)); ?>
<div class="login_form_in">
<p><?php echo $form->labelEx($model,'username')?><?php echo $form->textField($model,'username')?></p>
<p><?php echo $form->labelEx($model,'password')?><?php  echo $form->passwordField($model,'password')?></p>
<p><?php echo $form->labelEx($model,'verifyCode')?><?php  echo $form->textField($model,'verifyCode',array('class'=>'code'))?>
<span class="code"><?php $this->widget("CCaptcha",array(
                    'showRefreshButton' => false,
                    'clickableImage' => true,
                    'imageOptions'=>array(
                                'id'=>'login-captcha',
                                'alt'=>Yii::t('basic','验证码'),
                                'title'=>Yii::t('basic','点击换一张'),
                            ),
                ));?>
</span>
</p>
<p class="login"><span class="btn"><button type="submit">登录</button></span></p>
<span class="login_tips"><?php echo Html::error($model, 'username')?><?php echo Html::error($model, 'password')?><?php echo Html::error($model, 'verifyCode')?></span>
</div>
<?php $this->endWidget();?>