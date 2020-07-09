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
        <title>Skint Records<? //Config::value('title','site')?></title>
<? if(@$_SERVER['HTTPS']) { ?>
	<base href='https://<?=$_SERVER['HTTP_HOST']?>/'/>
<? } else { ?>
	<base href='http://<?=$_SERVER['HTTP_HOST']?>/'/>
<? } ?>
        <?
        $headers = $this->getHeaders();
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Pioneering UK dance label. Home to iconic acts such as Fatboy Slim, X-Press 2, Tim Deluxe, Mirrors, Kidda, Lo Fidelity Allstars, Goose; etc ">
        <script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
        <link href="css/blueprint/src/reset.css" type="text/css" rel="stylesheet" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/css/skint-ent.css" />
		<link rel="stylesheet" type="text/css" href="/css/skint.css" />
		<link rel="stylesheet" type="text/css" href="/css/shop.css" />
		<script src="/js/signup_ajax.js" type="text/javascript"></script>
		<!--[if IE 6]>
		<script type="text/javascript" src="/js/DD_belatedPNG_0.0.8a-min.js"></script>
		<script type="text/javascript">
			DD_belatedPNG.fix('#header h1');
		</script>
		<![endif]-->
                    <script src="/js/cufon-yui.js" type="text/javascript"></script>
<script src="/js/Arial_400-Arial_700-Arial_italic_400-Arial_italic_700.font.js" type="text/javascript"></script>
<script type="text/javascript">
			Cufon.replace('h2');
			Cufon.replace('h3');
			Cufon.replace('h4');
			Cufon.replace('.labels a');
</script>
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
						<script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
		
		<script src="/cms/js/queryui_1.8.2_custom/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
		<link href="/css/jquery-ui-1.8.2.custom.css" type="text/css" rel="stylesheet" media="screen, projection" />
										<script type="text/javascript" src="/cms/js/jquery.youtube.channel.js"></script>
<!--[if IE 6]>
        
<link rel="stylesheet" type="text/css" href="css/ie6.css" />
		<script type="text/javascript" src="/js/DD_belatedPNG_0.0.8a-min.js"></script>
		<script type="text/javascript">
			DD_belatedPNG.fix('h2');
            DD_belatedPNG.fix('.col h2');
            DD_belatedPNG.fix('.twitter .footer');
            DD_belatedPNG.fix('a.more');
		</script>
		<![endif]-->
    	<script type="text/javascript">

   var _gaq = _gaq || [];
   _gaq.push(['_setAccount', 'UA-18680468-1']);
   _gaq.push(['_trackPageview']);

   (function() {
     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
     ga.src = ('https:' == document.location.protocol ? 'https://ssl' :
'http://www') + '.google-analytics.com/ga.js';
     var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);
   })();

</script>
	</head>
	<body id="SkintHomepage">
	<div id="fb-root"></div>
<script>
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
			<h1><a href="/skint" title="Skint Records">Skint</a></h1>
			<h2>Under 5's</h2>
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
		<div class="inner"><div id="carousel"><a href="/shop/skint"><img src="images/albums.png" width="961" height="97" alt="Album Flash Widget" style="display: block" /></a></div></div>
		<script type="text/javascript">
		var flashvars = {xmlDoc:'/webservice/carousel/release_data.xml.php?label_uid=1',shopURL:'/shop/skint'};
		var params = { allowscriptaccess: "always", wmode: "transparent"};
		swfobject.embedSWF("/swf/carousel_skint.swf", "carousel", "960", "97", "9.0.0", "expressInstall.swf", flashvars, params);
		</script>
	</div>
	
	<div id="content">
	
		<div class="inner">
	
	<!--
	
    <?//$this->renderComponent('top',array('skipWrap'=>true));?>
	-->
