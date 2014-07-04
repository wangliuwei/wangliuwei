<?php
require_once($ckEditor);

$oCKeditor = new CKeditor(get_class($model).'['.$attribute.']');
$oCKeditor->basePath = $ckBasePath;

if(isset($config) && is_array($config)){
    foreach($config as $key=>$value){
        $oCKeditor->config[$key] = $value;
    }
}

$oCKeditor->editor(get_class($model).'['.$attribute.']',$defaultValue);