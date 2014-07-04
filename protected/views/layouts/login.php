<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->pageTitle ?></title>
<link type="text/css" href="<?php echo Yii::app()->request->baseUrl?>/css/login_css.css" rel="stylesheet" />
</head>

<body>
<div class="top_bar">
  <div class="con">
    <p><?php echo Yii::t('basic', '放飞梦想，实现您的梦想。感谢您支持');?></p>
  </div>
</div>
<div class="con_login">
<div class="login_form">
<h2><?php echo Yii::t('login', '用户登录');?></h2>
<?php echo $content?>
</div>
</div>
<div class="foot"><p><?php echo Yii::app()->params->copyrightInfo?></p></div>
</body>
</html>

