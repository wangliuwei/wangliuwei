<?php $form=$this->beginWidget('ActiveForm'); ?>
<div class="form_post_in">
	<p>
	    <?php echo $form->labelEx($model,'account'); ?>
	    <?php echo Yii::app()->user->account; ?>
	</p>
    <p>
    <?php echo $form->labelEx($model,'passwordOld'); ?>
    <?php echo $form->passwordField($model,'passwordOld'); ?>
    <?php echo $form->error($model,'passwordOld'); ?>
    </p>
    <p>
    <?php echo $form->labelEx($model,'passwordNew'); ?>
    <?php echo $form->passwordField($model,'passwordNew'); ?>
    <?php echo $form->error($model,'passwordNew'); ?>
    </p>
    <p>
    <?php echo $form->labelEx($model,'passwordConfirm'); ?>
    <?php echo $form->passwordField($model,'passwordConfirm'); ?>
    <?php echo $form->error($model,'passwordConfirm'); ?>
    </p>
	<p class="sub">
    <span class="btn">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('basic','创建') : Yii::t('basic','保存'),array('class'=>'sub'));?>
    </span>
    </p>
</div>
<?php $this->endWidget(); ?>