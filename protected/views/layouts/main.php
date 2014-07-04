<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="cn"> <!--<![endif]-->
<head>

<meta charset="utf-8">
<title>Art Power</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="N49 Interactive">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=IE6,chrome=IE7,chrome=IE8,chrome=IE9">
<meta name="distribution" content="global" />
<meta property="og:title" content="Art Power" />
<meta property="og:type" content="company" />
<meta property="og:url" content="/" />
<meta property="og:image" content="" />
<meta property="og:site_name" content="Art Power" />
<meta property="fb:admins" content="515506409" />
<?php //Yii::app()->clientScript->registerCoreScript('jquery');?>
<!--script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/owa2omv.js"></script-->
<script type="text/javascript">
try{Typekit.load();}catch(e){}
</script>
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/base_fluid_twocol.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/jquery.simplyscroll.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/video-js.css">
<link href="<?php echo Yii::app()->baseUrl;?>/css/thickbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl;?>/css/main.css" rel="stylesheet" type="text/css" />

<!--[if lt IE 9]>
<script src="<?php echo Yii::app()->baseUrl;?>/html5.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/IE9.js"></script>
<![endif]-->
<script type="text/javascript"> var siteUrl = 'http://localhost/'; var current_page = 'index'; </script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.cycle2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.cycle2.autoheight.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.cycle2.center.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.cycle2.caption.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/thickbox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/main.js"></script>
<div id="fb-root"></div>
<?php
    $menu = Tb_category::model()->getMobileMenu();
?>
<script type="text/javascript"> 
    var menu = <?php echo $menu;?>; 
</script>
</head>
<body class="index">
	<header>
		<div class="fluid">
			<div id="logo" class="left column omega">
				<a href="<?php echo $this->createUrl('site/index');?>"><img src="<?php echo Yii::app()->baseUrl;?>/images/logo.png" alt="Logo - Art Partner" title="Art Partner"></a>
				<div id="subNavTrigger" class="popupInit" data-type="toggleNav" data-params="show"></div>
			</div>
			<!---Navigation Begins-->
			<nav class="right column alpha right" role="navigation">
				
				<ul>
					<li><a class="homepageNav" href="index-1.htm">print/film</a></li>
					<li><a class="homepageNav" href="index-2.htm">stylists</a></li>
					<li><a class="homepageNav" href="index-3.htm">hair stylists</a></li>
					<li><a class="homepageNav" href="index-4.htm" >make upartists</a></li>
					<li><a class="homepageNav">production</a>
					<li class="last"><a class="homepageNav">about</a>
					</li>
				</ul>
				<ul class="socialMedia right">
					<li><a href="index-5.htm">News</a></li>
					<li class="last"><a href="index-6.htm">Contact</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div id="overlayBackground"></div>
	<div id="subNav"></div>
	<div id="main" style="margin-top:23px;margin-left:30px;margin-bottom:30px;margin-right:30px;">
	<?php echo $content;?>
	</div>
	<!--footer>
		<div class="container">
			<div id="copy">
				<ul>
				<li>Copyright &copy; 2014. art partner. All rights reserved  </li>
				<li><a href="index-7.htm">legal</a> </li>
				<li class="last"><a href="index-8.htm">about the company</a></li>
				</ul>
			</div>
		</div>
	</footer-->        
</body>
</html>
