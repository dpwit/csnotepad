<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>		
        <title>CSnotepad Virtual Receptionist Service</title>
		<meta name="description" content="CSnotepad virtual Receptionist provide Telephone Answering, Order Taking, Diary Management and Virtual Assistant services to large and small businesses." />

		<script async src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript"></script>
		<script async src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js" type="text/javascript"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="/css/newstyle.css?Cache-Control: max-age=2592000" rel="stylesheet" type="text/css" />
		<link href="/css/tabmenu.css?Cache-Control: max-age=2592000" rel="stylesheet" type="text/css" />
		<script async src="/js/tabmenu.js?Cache-Control: max-age=2592000" type="text/javascript"></script>
		<script async src="/js/scrollto.js?Cache-Control: max-age=2592000" type="text/javascript" ></script>
		<script async src="/js/scripts.js?Cache-Control: max-age=2592000" type="text/javascript" ></script>
		<script async src="/js/cufon-yui.js?Cache-Control: max-age=2592000" type="text/javascript"></script>
		<link href="/css/jquery.fancybox.css" rel="stylesheet" />
		<script async src="/js/jquery.fancybox.pack.js" type="text/javascript" ></script>
		<script async src="/js/support.js" type="text/javascript" ></script>
		<script async src="/js/signup.js" type="text/javascript" ></script>
		<script async src="/html/js/jquery.boxy.js" type="text/javascript" ></script>
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
		
		<link rel="stylesheet" href="/css/validationEngine.jquery.css?Cache-Control: max-age=2592000" type="text/css" media="screen" charset="utf-8" />
	    <script async src="/js/jquery.validationEngine-en.js?Cache-Control: max-age=2592000" type="text/javascript"></script>
	    <script async src="/js/jquery.validationEngine.js?Cache-Control: max-age=2592000" type="text/javascript"></script>
		<script async src="/js/jquery.signaturepad.min.js?Cache-Control: max-age=2592000" type="text/javascript"></script>
		<script async src="/js/json2.min.js?Cache-Control: max-age=2592000" type="text/javascript"></script>
		<script>
	  		jQuery(document).ready(function(){
                jQuery("#contact-form").validationEngine();
				$('.ProductTable:not(.Virtual.Address) tr').click(function(){
					window.location.href = $(this).find("a").attr("href");
				});
            });
	  	</script>
	  
	  	<link rel="stylesheet" href="/css/jquery.signaturepad.css?Cache-Control: max-age=2592000">
	  
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-65019023-1', 'auto');
		  ga('send', 'pageview');

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
		<!-- ClickGuardian.co.uk -->

		<script type="text/javascript">

			var _cgk = 'VCBDknRtsSGq3';
			var _cgd = 'csnotepad.co.uk';

			(function () {
			var cg = document.createElement('script'); cg.type = 'text/javascript'; cg.async = true;
			cg.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'protection.clickguardian.co.uk/cgts.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(cg, s);
			})();

		</script>
		<noscript>
			<a href="http://clickguardian.co.uk"><img src="https://protection.clickguardian.co.uk/nojs.php?d=csnotepad.co.uk&k=VCBDknRtsSGq3" alt="Click Guardian Tracking"/><a/>
		</noscript>

    </head>

	<?PHP
		include_once 'common.php';
		include_once 'db.php';
		@include_once(dirname(__FILE__).'/config.php');
		@session_start();
		include_once dirname(__FILE__).'/includes/functions/generalFunctions.php';
	?>

	<body> 
		<!-- Google Code for Remarketing Tag -->
		<!--
		Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
		-->
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 1055112536;
			var google_custom_params = window.google_tag_params;
			var google_remarketing_only = true;
			/* ]]> */
		</script>
		<script src="//www.googleadservices.com/pagead/conversion.js" type="text/javascript">
		</script>
		<noscript>
			<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1055112536/?value=0&amp;guid=ON&amp;script=0"/>
			</div>
		</noscript>
		
			<div class="row" id="wrappernewfullhomeheader">
				<div class="col-sm-12 col-md-3 text-center"><a href="/home"> <img src="/images/logo_light_noshadow.png" class="img-reposnive" width="330" height="165" alt="CSnotepad virtual office address cost effective alternative to renting office" title="CSnotepad Virtual Receptionists" /></a>
				</div>
				<div class="col-sm-12 col-md-9">
					
							<div class="col-md-1 headermenuitems">
								<a href="/home" class="headermenuitems" title="Home">Home</a>
							</div>
							<div class="col-md-1 headermenuitems">
								<a href="/home" class="headermenuitems" title="Testimonials">Testimonials</a>
							</div>
							<div class="col-md-1 headermenuitems">
								<a href="/home" class="headermenuitems" title="Services">Services</a>
							</div>
							<div class="col-md-1 headermenuitems">
								<a href="/home" class="headermenuitems" title="FAQ">FAQ</a>
							</div>
							<div class="col-md-1 headermenuitems">
								<a href="/home" class="headermenuitems" title="Contact">Contact</a>
							</div>
							<div class="col-sm-12 col-md-4 text-center">
								<a href="tel:+441273741400"> <img src="/images/csnotepad_telephone.png" class="img-reposnive" alt="CSnotepad virtual office address cost effective alternative to renting office" title="CSnotepad Virtual Receptionists" /></a>		
							</div>
				</div>
				
			</div>
		
	</body>
</html>