<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>www.livewebchat.co.uk</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="<?php if($context->metaDescription) { ?><?=$context->metaDescription?><?php } else {?><?=$context->pageTitle ?> - Inbound call handling from CSNotepad - specialists in affordable and professional answering services, order taking, call patching and more<?php } ?>" />
		<!--<script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="/cms/js/queryui_1.8.2_custom/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>-->

		<!--[if lt IE 9]><html lang="en-us" class="ie"><![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js" type="text/javascript"></script>
	<!--<script src="/js/flashcanvas.js" type="text/javascript"></script>-->
		<link rel="stylesheet" type="text/css" href="/css/fonts/fonts.css" />
		<link rel="stylesheet" type="text/css" href="/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/css/cs_notepad.css" />
		<link rel="stylesheet" type="text/css" href="/css/shop.css" />
		<link rel="stylesheet" type="text/css" href="/css/new-home.css?1" />
		<script type="text/javascript" src="/js/scrollto.js"></script>
		<script type="text/javascript" src="/js/scripts.js"></script>
		<script src="/js/cufon-yui.js" type="text/javascript"></script>
			<link href="/css/jquery.fancybox.css" rel="stylesheet" />
			<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
			<script type="text/javascript" src="/js/support.js"></script>
			<script type="text/javascript" src="/js/signup.js"></script>
			
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
	  
	  <link rel="stylesheet" href="/css/jquery.signaturepad.css">
		
    </head>
	<body>
	<div id="wrapper">
		<div id="topBar" >
			<!--<div id="logoBox">
				<a href="/" title="Live Web Chat" ><img src="images/logo.png" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>
			</div>-->
			<div id="topBarRightBox">
			<div id="menubox">
			<div class="phonenumbernewleft">
		<!--<span style="padding-right:25px; top:0px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>-->
		<span style="padding-right:25px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 0333 200 0504</span>
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>
			<ul id="menu">
			<li class="home selected">
			<a href="home.php" title="Home">Home</a>
			</li>
			<li class="Our Services unselected">
			<a href="our-services.php" title="Our Services">Our Services</a>
			</li>
			<li class="FAQ unselected">
			<a href="faq.php" title="FAQ">FAQ</a>
			</li>
			<li class="Contact unselected">
			<a href="contact.php" title="Contact">Contact</a>
			</li>
			</ul>
			<div class="phonenumbernew">
		<span style="padding-right:25px; top:0px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>
		<!--<span style="padding-right:25px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 0333 200 0504</span>-->
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>	
			<div class="clear"></div>
		</div>
		</div>
		<div class="clear"></div>
		</div>
		<div id="contentTop">
			
		</div>

<div class="newheaderthanks">


				<!--<a href="/" title="Live Web Chat" ><img src="images/logo.png" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>-->
			

	<div class="phonenumber">
	<a href="/" title="Live Web Chat" ><img src="images/logo.png" width="236" height="120" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>
		<!--<span><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741400</span>-->
		<ul class="homepoints">
			<span>
	
   <ul style="list-style-type: none; display: inline-block;">
      <li><!--<a href="/our-services/order-taking" title="E-Commerce order processing">-->Pro-active chat     </a></li>
      <li><!--<a href="/our-services/order-taking" title="Support ticket logging">-->Mobile friendly     </a></li>
   </ul>

   <ul style="list-style-type: none; display: inline-block; margin: 0 20px;">
      <li>Appointment booking     </li>
      <li><!--<a href="/our-services/order-taking" title="Order fulfilment">-->Easy to Install     </a></li>
   </ul>
   
   <ul style="list-style-type: none; display: inline-block; margin: 0 20px;">
      <li>Checkout assistance     </li>
      <li><!--<a href="/our-services/telephone-answering-brighton" title="Message taking">-->UK office based     </li>
   </ul>
</span>
		</ul>
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>
	
	<div class="subheader">
	<!--<h2>Whatever the size of your company we're here to answer your telephone calls when you can't, whether you receive hundreds of calls a month or not, you can expect a bespoke service tailored precisely to your businesses needs.</h2>
	<span>01273 741 400</span>-->
	
	
		
	</div>
	<br>
	<br>
<div id="mainSection">
				
				<div id="mainSection2ColLeft">
				<br>
				<br>
				<div id="breadcrumb"><h3><b>You are here: </b>
<a class='breadcrumb' title="Home" href="home.php">Home</a>  &gt; <a class="breadcrumb" title="Contact" href="contact.php">Contact</a>  &gt; <a class="breadcrumb" title="Thanks" href="thanks.php">Thanks</a></h3></div>
<div id="breadcrumb-search-fields" style="display:none;">
	<input type='hidden' name='from' value='/thanks'/>
</div>
<br>
<h1><font color ="423062">Get</font><font color ="AB2C26"> In</font><font color ="423062"> Touch</font></h1>
<br>
<!--					
					<div id="mainSection2ColLeftContactLeft">
                      <p>Email</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p><a href="mailto:info@csnotepad.co.uk"><img alt="" src="images/email.jpg"></a></p>
                    </div>
                    <div class="clear"></div>
                    <br>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Address</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p> Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD</p>
                    </div>
                    <div class="clear"></div>
                    <br>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Telephone</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>0800 849 3990 (free from landlines)<br />
0330 300 3990 (free from mobiles as part of your inclusive minutes)
</p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Fax</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>0330 300 3991</p>
                    </div>
                    <div class="clear"></div>
                    <br>
                    <br>
		-->			
					<!--<?=$item->text?>-->
					
					<div> Thank you for contacting us.  One of our Account Managers will be in touch within one working hour </div>
		
	        <br>
					<br>
							<p>
						<em><strong>Our core office hours are: </strong><br>
						<br>
					  	Monday - Friday<br>
					  	8.30am - 6pm<br>
						<br>
						Saturday<br>
					  	9am - 3pm<br>
					  	</em>
					</p>
					<p>
						<!--<em>
						<br>
						Telephone answering extended hours are 24/7
						</em>-->
					</p>
			
					
					<br>
			    <br>
					<br>
					
				</div>
				<div id="mainSection2ColRight">
					<!--<div id="sideBarBoxTop">
						
					</div>
					<div id="sideBarBoxMiddle">
						<?php
							include BASEPATH.'../includes/testimonials.php';
						?>
					</div>
					<div id="sideBarBoxBottom">
						
					</div>
					<p>
						<a href="/reasons" title="Why we're better than letting calls go to voicemail">
							<img width="217" height="75" alt="Why we're better than letting calls go to voicemail" src="images/answer.jpg" title="Why we're better than letting calls go to voicemail" ></a>
						<a href="/temp" title="10 reasons we're better than a temp">
							<img width="217" height="75" alt="10 reasons why our telephone answering services are better than a temp" src="images/temp.jpg" title="10 reasons we're better than a temp" ></a> 
						<a href="/competition" title="10 reasons why we're better than the competition">
							<img width="217" height="75" alt="10 reasons that our call handling and telephone answering services are better than those of competition" src="images/competition.jpg" title="10 reasons why we're better than the competition" ></a>
					</p>-->
				</div>
				<div class="clear"></div>
				
			</div>
			<div class="underContent">
				<div class="imagesFotter">
					<a href="http://www.linkedin.com/company/csnotepad/products?trk=tabs_biz_product" target="_blank" title="Linked in"><img src="/images/linkedin.png" style="width: 50px; height:50px"></a>
					<img src="/images/fsb.png" style="width: 50px; height:50px">
					<img src="/images/chamber.png"style="width: 50px; height:50px">
					<img src="/images/hba.png" class="hba"style="width: 50px; height:50px">
				</div>

				<div class="semiFooter">
					<!--<a href="/our-services">
						<img src="images/signup3.jpg" alt="Signup" class="cards">
					</a>-->
					
					<span class="footerCallMore">Call now to find out more <strong>01273 741113</strong>.</span>
					<span class="companyNo">CSnotepad is a trading division of Call Solution Ltd.</span>
					<span class="companyNo">Registered in England 6107188.</span>
					
				</div>
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">Arrange a call back</button>
					</a>
			</div>
			<?php // } ?>
		</div>

		<!--<div id="contentBottom">
	
		</div>-->
		
		
	</div>
	
<script type="text/javascript">document.write(unescape('%3Cscript type="text/javascript" src="'+document.location.protocol+'//dnn506yrbagrg.cloudfront.net/pages/scripts/0011/3995.js"%3E%3C%2Fscript%3E'))</script>
<!-- Click4Assistance Embedded Chat Button Script -->
<script type="text/javascript"> 
   var head = document.getElementsByTagName('head')[0]; 
   var srcC4AW = document.createElement('script'); 
   srcC4AW.type = 'text/javascript'; 
   srcC4AW.charset = 'utf-8'; 
   srcC4AW.id = 'srcC4AWidget'; 
   srcC4AW.defer = true; 
   srcC4AW.async = true; 
   srcC4AW.src = 'https://prod3si.click4assistance.co.uk/JS/ChatWidget.js'; 
   if (head) {head.appendChild(srcC4AW);} 

   function C4AWJSLoaded() { 
      oC4AW_Widget = new oC4AW_Widget(); 
      oC4AW_Widget.setAccGUID("755a7b99-4f47-4a47-83a2-26f54ef2aa53"); 
      oC4AW_Widget.setWSGUID("7e020e37-a38d-46d6-b31c-53101374b02e"); 
      oC4AW_Widget.setWFGUID("a78d566e-aebb-40f5-a039-c5b4093879ed"); 
      oC4AW_Widget.setPopupWindowWFGUID("8b672537-2249-469c-b797-072109cc708e"); 
      oC4AW_Widget.setDockPosition("BOTTOM"); 
      oC4AW_Widget.setBtnStyle("position:fixed; border:none; bottom:0em; right:1em;"); 
      oC4AW_Widget.setIdentity("Embedded Chat"); 
      oC4AW_Widget.Initilize(); 
   } 
</script> 
<!-- Click4Assistance Embedded Chat Button Script -->



<!-- Click4Assistance Tracking/Proactive Script -->
<script type="text/javascript" defer="defer">
var C4A_TB;
function C4AJSJustLoaded(){
C4A_TB = C4ATB();
C4A_TB.setAccountGUID('755a7b99-4f47-4a47-83a2-26f54ef2aa53');
C4A_TB.setWebsiteGUID('7e020e37-a38d-46d6-b31c-53101374b02e');
C4A_TB.setUseCookie(true);
C4A_TB.Run();
}
</script>
<script src="https://prod3si.click4assistance.co.uk/JS/TrackProactive.js" type="text/javascript" defer="defer"></script>

<noscript>
<img src="https://prod3si.click4assistance.co.uk/Tracking/PageHit_NoScript.aspx?AccountGUID=755a7b99-4f47-4a47-83a2-26f54ef2aa53&amp;WebsiteGUID=7e020e37-a38d-46d6-b31c-53101374b02e" alt="Live Chat Software by Click4Assistance UK" />
</noscript>
<!-- Click4Assistance Tracking/Proactive Script -->




