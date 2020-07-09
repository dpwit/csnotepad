<?
cms_trigger_action('fe_template_begin');
$debug=true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?=$context->pageTitle?> - <?=Config::value('title','site')?></title>
<?php
	$server = @$_SERVER['HTTPS']? 'https://' : 'http://';
?>
		<base href="<?=$server . $_SERVER['HTTP_HOST']?>/" />
<?
	$headers = $this->getHeaders();
?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="" />
        <script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="/cms/js/queryui_1.8.2_custom/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/bare.css" />
		<link rel="stylesheet" type="text/css" href="css/shop.css" />
		<script src="/js/cufon-yui.js" type="text/javascript"></script>

		<link rel="icon" href="/favicon.ico">
<?
	cms_trigger_action('fe_template_head',$this);
	if(@$_SESSION['messages']){
?>
		<script type="text/javascript" src="/html/js/jquery.boxy.js"></script>
		<link rel="stylesheet" type="text/css" href="/html/js/stylesheets/boxy.css" />
		<script type="text/javascript">
			$(function(){
				try {
				setTimeout(function(){
					Boxy.alert("<div class='message'><?=htmlspecialchars($_SESSION['messages'])?></div>",null,{title:"Notification"});
					setTimeout(function(){Boxy.get($('.message')).hide();},1000);
				},100);
				} catch(err){
				}
			});
		</script>
			<?
			$_SESSION['messages']='';
		}
        ?>
    </head>
	<body>
	<div id="fb-root"></div>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
		FB.init({appId: 'your app id', status: true, cookie: true,
				 xfbml: true});
		};
		(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
			'//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
		}());
	</script>
	<div id="header">
		<div class="inner">
			<h1><a href="/" title="Home">Home</a></h1>
<?$this->renderComponent('top',array('skipWrap'=>true));?>
		</div>
	</div>

	<div id="nav">
		<div class="inner">
			<div id="mp3Player">
<? $this->renderComponent('mp3player') ?>
			</div>
<? $this->renderComponent('menu',array('skipWrap'=>true));?>
		</div>
	</div>

	<?php /*
	<div id="albums">
		<div class="inner"><div id="carousel"><img src="images/albums.png" width="961" height="97" alt="Album Flash Widget" style="display: block" /></div></div>
		<script type="text/javascript">
		var flashvars = {xmlDoc:'/webservice/carousel/release_data.xml.php?label_uid=2',shopURL:'/shop/loaded'};
		var params = { allowscriptaccess: "always", wmode: "transparent"};
		swfobject.embedSWF("/swf/carousel.swf", "carousel", "960", "97", "9.0.0", "expressInstall.swf", flashvars, params);
		</script>
	</div>
	<?php */ ?>

	<div id="content">

		<div class="inner">
