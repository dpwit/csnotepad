<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
	$debug=true; 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=Config::value('title','site')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<base href='http://<?=$_SERVER['HTTP_HOST']?>/'/>
		<? 
			$headers = $this->getHeaders();
		?>
		<?php //if(!$debug) { 
//		$headers['jquery'] = '<script src="http://cdn.jquerytools.org/1.1.2/jquery.tools.min.js" type="text/javascript"></script>';
		/*
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
		*/ ?>
		<?= join("\n",$headers) ?>
		<script src="/js/jquery.js" type="text/javascript"></script>
		<script src="/js/jquery.form.js" type="text/javascript"></script>
		<script src="/js/jquery.MetaData.js" type="text/javascript" language="javascript"></script>	
		<script src="/js/jquery.rating.js" type="text/javascript" language="javascript"></script>		
 		<link href="/js/jquery.rating.css" type="text/css" rel="stylesheet"/>
		<script src="/js/jquery.corner.js" type="text/javascript"></script>
		<?php /*
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
		<script src="/cms/js/jqueryui-1.8/minified/jquery.ui.core.min.js" type="text/javascript"></script>
		<script src="/cms/js/jqueryui-1.8/minified/jquery.ui.mouse.min.js" type="text/javascript"></script>
		<script src="/cms/js/jqueryui-1.8/minified/jquery.ui.widget.min.js" type="text/javascript"></script>
		<script src="/cms/js/jqueryui-1.8/minified/jquery.ui.slider.min.js" type="text/javascript"></script>
		<script src="/cms/js/jqueryui-1.8/minified/jquery.ui.tabs.min.js" type="text/javascript"></script>
		<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/ui-darkness/jquery.ui.core.css' />
		<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/ui-darkness/jquery.ui.theme.css' />
		<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/ui-darkness/jquery.ui.slider.css' />		
		<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/ui-darkness/jquery.ui.tabs.css' />				
		*/ ?>

						
		<script src="js/cufon-yui.js" type="text/javascript"></script>
		<script src="js/Typ1451-Bold_400.font.js" type="text/javascript"></script>
		<script type="text/javascript" src="/themes/default/js/elite.js"></script> 
		<link href="/css/reset.css" rel="stylesheet" type="text/css" />
		<link href="/css/boxy.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
				
	<!--[if lt IE 8]>
   <style type="text/css">
   </style>
   <![endif]-->
	</head>
	<body>
<div class="toprounded">
<div id="login">
	<?$this->renderComponent('login',array('skipWrap'=>true))?>
<!--<form name="loginForm" id="loginform" action="">login<input type="text" id="loginbox" /><input
	type="password" id="passwordbox" /><input type="submit" id="loginSubmit"
	value="" />
<div id="loginoptions"><a href="register">register</a>&nbsp;|&nbsp;<a
	href="">forgotten password?</a></div></form>-->

</div> <!-- end login  -->
</div>
<div class="wrapper">
<div class="header">
<div id="logo"><a href='/'><img src="images/logo.png" alt="elitepromo.dj" /></a></div>
<div id="menu">
	<?$this->renderComponent('top',array('skipWrap'=>true))?>
</div> <!-- end menu -->
<div id="searchleft"> </div>
<div id='search'>
<div id='breadcrumb'><?=$this->renderComponent('breadcrumb',array('skipWrap'=>true))?></div>
<?=$this->renderComponent('search',array('skipWrap'=>true))?>
</div>
<div id="searchright"> </div>
<div style="clear:both"></div>
</div> <!-- end header  --><div class="leftcol">
<?$this->renderComponent('left')?>
<?$this->renderComponent('left-banner')?>
</div> <!-- end left1  -->
<div class="maincontent">
<?$this->renderComponent('main')?>
</div> <!-- end maincontent  -->

<div class="rightcol">
<?$this->renderComponent('right')?>
<?$this->renderComponent('right-banner')?>
</div> <!-- end right  -->
<div id="footer">
<div class="floatleft"><? $this->renderComponent('bottom',array('skipWrap'=>true)); ?></div>
<div class="floatright"><? $this->renderComponent('foot',array('skipWrap'=>true)); ?></div>
            </div> <!-- end footer -->
        <script type="text/javascript"> Cufon.now(); </script>
                <br class="clearfix" />
        </div> <!--  end wrapper -->

<?
if ($debug) { ?>
<div id='debug' style='color: black; border: solid red 2px; background: white; padding: 3px; position: absolute; top:5px; left: 5px; z-index: 1500;'>
<div class='debug-trigger'>
	<a href='#' style='color: red;'>Show Debug</a>
</div>
<div class='debug-output' style='display: none'>
<pre><?=$this->__toString()?></pre>
</div>
</div>
	<script>
	$(function(){
		$('div.debug-trigger a').click(function(){
			$('div.debug-output').toggle();
			return false;
		});
		$('body').live('click',function(ev){
			$('div.debug-output').hide();
		});
	});
	</script>
<? } ?>
	</body>
</html>
