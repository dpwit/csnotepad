<?
cms_trigger_action('fe_template_begin');
?>
<?php
$debug=true;

try {
   // lessc::ccompile(dirname(__FILE__).'/../css/rsf.less', dirname(__FILE__).'/../css/rsf.css');
} catch (exception $ex) {
    exit('lessphp fatal error:<br />'.$ex->getMessage());
} 
?>
<? /* <?xml version="1.0" encoding="UTF-8"?> - Commented out so IE6 doesn't enter quirks mode. Uses 'meta Content-Type' below instead */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?=$context->pageTitle ? $context->pageTitle.' - ' : ''?><?=Config::value('title','site')?></title>
<? if(@$_SERVER['HTTPS']) { ?>
	<base href='https://<?=$_SERVER['HTTP_HOST']?>/'/>
<? } else { ?>
	<base href='http://<?=$_SERVER['HTTP_HOST']?>/'/>
<? } ?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="Pioneering Big Beat record label. Home to Fatboy Slim, Midfield General, Lo Fidelity All Stars, Space Raiders and Indian ">
		<script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
		
		<script src="/cms/js/queryui_1.8.2_custom/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
		<link href="/css/jquery-ui-1.8.2.custom.css" type="text/css" rel="stylesheet" media="screen, projection" />
		<script src="/js/signup_ajax.js" type="text/javascript"></script>				
		<script type="text/javascript" src="/cms/js/jquery.youtube.channel.js"></script>
		<link type="text/css" href="/cms/js/youtube.channel.css" rel="stylesheet" />
				
		<link href="css/blueprint/src/reset.css" type="text/css" rel="stylesheet" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/skint-ent.css" />
		<link rel="stylesheet" type="text/css" href="css/shop.css" />

            <script src="/js/cufon-yui.js" type="text/javascript"></script>
<script src="/js/Arial_400-Arial_700-Arial_italic_400-Arial_italic_700.font.js" type="text/javascript"></script>
<script type="text/javascript">
			Cufon.replace('h2');
			Cufon.replace('h3');
			Cufon.replace('.labels a');
</script>

		<?
		$headers = $this->getHeaders();
		echo join("\n",$headers);
		?>
        <?
		cms_trigger_action('fe_template_head',$this);
if(@$_SESSION['messages']){
?>
<script src='/html/js/jquery.boxy.js'></script>
<!--<link rel='stylesheet' type='text/css' href='/html/js/stylesheets/boxy.css'/>-->
	<script>
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
	 <script src="http://connect.facebook.net/en_GB/all.js"></script>
	 <script>
		 FB.init({
			 appId  : 'YOUR APP ID',
			 status : false, // check login status
			 cookie : true, // enable cookies to allow the server to access the session
			 xfbml  : true  // parse XFBML
		 });
	 </script>
<script>
	/*window.fbAsyncInit = function() {
	FB.init({appId: 'your app id', status: true, cookie: true,
			 xfbml: true});
	};
	(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol +
		'//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
	}());*/
</script>
	<div id="header">
		<div class="left side"></div>
		<div class="right side"></div>
		<div class="inner">
			<h1><a href="/" title="Skint Entertainment">Skint Entertainment</a></h1>
			<h2 id="skinth2"><a href="/skint" title="Skint Records">Skint</a></h2>
			<h2 id="loadedh2"><a href="/loaded" title="Loaded Records">Loaded</a></h2>
<?$this->renderComponent('top',array('skipWrap'=>true));?>
		</div>
	</div>
	
	<div id="nav">
		<div class="inner">
			<div id="mp3Player">
<? $this->renderComponent('mp3player') ?>
			</div>
			<ul id="menu">
<?$this->renderComponent('menu',array('skipWrap'=>true));?>			
			</ul>
		</div>
	</div>
	
	<div id="albums">
		<div class="inner"><div id="carousel"><img src="images/albums.png" width="961" height="97" alt="Album Flash Widget" style="display: block" /></div></div>
		<script type="text/javascript">
		var flashvars = {xmlDoc:'/webservice/carousel/release_data.xml.php', shopURL:'/shop/'};
		var params = { allowscriptaccess: "always", wmode: "transparent"};
		swfobject.embedSWF("/swf/carousel.swf", "carousel", "960", "97", "9.0.0", "expressInstall.swf", flashvars, params);
		</script>
	</div>
