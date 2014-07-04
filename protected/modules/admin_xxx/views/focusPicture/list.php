<?php
$this->breadcrumbs=array(
	'焦点图片列表'
);
?>
<div class="normal_search" id="normal">
<?php echo Html::beginForm(Yii::app()->createUrl('FocusPicture/list'), 'get', '');?>
      <div class="default_corner_input">
	  <span class="l"></span>
  <?php echo Html::activeTextField($model, 'key');?>
          <span class="r"></span>
	</div>
  <span class="btn"><button onclick="form.submit()">查询</button></span>
  <span id='switch_adv_search' class="op" >打开高级搜索</span>
</div>
<?php echo Html::endForm();?>
<div class="senior_search" id="senior" style="display:none;">
 <?php echo Html::beginForm(Yii::app()->createUrl('FocusPicture/list'), 'get', '');?>
  <p><?php echo Html::activeLabel($model, 'ID');?><?php echo Html::activeTextField($model, 'ID');?></p>
  <p><?php echo Html::activeLabel($model, 'Name');?><?php echo Html::activeTextField($model, 'Name');?></p>
  <p class="last"><span class="btn"><button onclick="form.submit()">查询</button></span>
    <span class="btn"><button class="reset">重置</button></span>
 </p>

  <span id='switch_base_search' class="op">关闭高级搜索</span>
</div>
<?php echo Html::endForm();?>
<div class="data">
  <div class="data_op_t">
    <p>
	<?php 
		echo '<span class="btn"><button id="delchk">';
		echo '删除选择项';
	echo '</button></span>';
	?>
    <span class="btn"><button onclick="location.href='<?php echo Yii::app()->createUrl('FocusPicture/create')?>'">新增焦点图片</button></span>
    </p>
  </div>
<?php $this->widget('application.components.IGridView', array(
    'dataProvider'=>$model->search(),
    'columns'=>array(
                array(
                    'id'=>'id',
                    'class' => 'CCheckBoxColumn',
                ),
                array(
                    'name'=>'ID',
                    'type'=>'raw',
                ),
                array(
                    'name'=>'Name',
					'type' => 'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:left',
                    )
                ),
                array(
                    'class'=>'CButtonColumn',
                	'deleteConfirmation'=>Yii::t('zii','是否对所选数据进行存档?'),
                    'template'=>'{update} {delete}',
                    'header'=>Yii::t('basic', '操作'),
                    'buttons'=>array(
                        'update' => array(
                            'label' => Yii::t('basic', '编辑'),
                            'imageUrl'=>false,
                        ),
                        'delete' => array(
							'label' => Yii::t('basic', '删除'),
                            'imageUrl'=>false,
                        ),
                    ),
                ),
        ),
    'htmlOptions' => array(
        'class' => 'datalist',
    ),
    'pagerCssClass' => 'turn_page',
    'id' => 'datalist',
    'pager' => array(
        'class' => 'IAjaxPagers',
        'id' => 'pager',
        'htmlOptions' => array('class' => 'turn_page'),
    ),
));?>
</div>