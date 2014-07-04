<?php
if($flashes = Yii::app()->user->getFlashes()) {
    foreach($flashes as $key => $message) {
        if($key != 'counters') {
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//                        'id'=>$key,
						'id' => 'dialog',
                        'options'=>array(
                            'show' => 'blind',
                            'hide' => 'explode',
                            'modal' => 'true',
                            'title' => $message['title'],
                            'autoOpen'=>true,
            				'resizable'=>false,
            				'buttons'=>array(
									'ok'=>"js:function(){jQuery(this).dialog('close');}"
								),
                            ),
                        ));
 
            printf('<span class="dialog">%s</span>', $message['content']);
 
            $this->endWidget('zii.widgets.jui.CJuiDialog');
        }
    }
}
?>