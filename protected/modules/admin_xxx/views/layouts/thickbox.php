<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link type="text/css" href="<?php echo Yii::app()->request->baseUrl?>/css/css.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/jquery.hotkeys.js"></script>
</head>
<body>
<?php echo $content?>
</body>
</html>