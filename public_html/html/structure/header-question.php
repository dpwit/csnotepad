
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
		<meta name="description" content="<?php if($context->metaDescription) { ?><?=$context->metaDescription?><?php } else {?><?=$context->pageTitle ?> - Inbound call handling from CSNotepad - specialists in affordable and professional answering services, order taking, call patching and more<?php } ?>" />
		<!--<script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="/cms/js/queryui_1.8.2_custom/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>-->

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js" type="text/javascript"></script>
	<!--<script src="/js/flashcanvas.js" type="text/javascript"></script>-->
	
		<link rel="stylesheet" type="text/css" href="/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/css/cs_notepad.css" />
		<link rel="stylesheet" type="text/css" href="/css/shop.css" />
		<link rel="stylesheet" type="text/css" href="/css/new-home.css" />
		<script src="/js/cufon-yui.js" type="text/javascript"></script>
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
      <link rel="stylesheet" href="/css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
      <script src="/js/jquery.validationEngine-en.js" type="text/javascript"></script>
      <script src="/js/jquery.validationEngine.js" type="text/javascript"></script>
		<script src="/js/jquery.signaturepad.min.js" type="text/javascript"></script>
		<script src="/js/json2.min.js" type="text/javascript"></script>
		<script>
	  	jQuery(document).ready(function(){
                jQuery("#contact-form").validationEngine();
				$('.ProductTable:not(.Virtual.Address) tr').click(function(){
					window.location.href = $(this).find("a").attr("href");
				});
            });
	  </script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2882596-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

		<link rel="stylesheet" href="/css/jquery.signaturepad.css">
    </head>
	<body>
	<div id="wrapper">
		<div id="topBar" >
			<div id="logoBox">
				<a href="/" title="Virtual Receptionist Services by CSnotepad" ><img src="images/logo.png" alt="Virtual Receptionist and other virtual office services by CSnotepad" title="CSnotepad - Virtual Receptionist and Virtual Office Services" /></a>
			</div>
			<div id="topBarRightBox">
				<div id="menuBox">
					<?php $this->renderComponent('menu',array('skipWrap'=>true));?>
					<?php $this->renderComponent('top',array('skipWrap'=>true));?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<div id="contentTop">

		</div>
