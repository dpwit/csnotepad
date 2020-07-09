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

<div class="newheadercontact">


				<!--<a href="/" title="Live Web Chat" ><img src="images/logo.png" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>-->
			

	<div class="phonenumber">
	<a href="/" title="Live Web Chat" ><img src="images/logo_clear.png" width="236" height="120" alt="Live Web Chat by CSnotepad" title="Live Web Chat by CSnotepad" /></a>
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
	
	<div class="semiFootertop">
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">Arrange a call back</button>
					</a>
				<!--<a href="/howitworks.php" <!--rel="fancybox-support" class="fancybox.iframe"-->
						<!--<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">How it works</button>
					</a>-->
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">Download prices</button>
					</a>
				</div>
	
	<!--<div class="subheader">
	<!--<h2>Whatever the size of your company we're here to answer your telephone calls when you can't, whether you receive hundreds of calls a month or not, you can expect a bespoke service tailored precisely to your businesses needs.</h2>
	<span>01273 741 400</span>-->
	
	
		
	<!--</div>-->
	<br>
<!--<div id="contentTop">
			
		</div>-->

<div id="contentMiddle">
<!--<h1 style="margin-left: 200px"><b><font color ="423062">Live</font> <font color ="AB2C26">Web</font> <font color ="423062">Chat</font> <font color ="000000">for your business</font></b></h1>-->
<div id="breadcrumb"><h3><b>You are here: </b>
<a class='breadcrumb' title="Home" href="home.php">Home</a>  &gt; <a class="breadcrumb" title="FAQ" href="faq.php">FAQ</a></h3></div>
<div id="breadcrumb-search-fields" style="display:none;">
	<input type='hidden' name='from' value='/faq'/>
</div>
<br>
<h1><i><font color ="423062">Frequently</font><font color ="AB2C26"> Asked</font><font color ="423062"> Questions</font></i></h1>
<br>
•	<a href="#Just software">Can you supply just the software?</a> <br>
•	<a href="#Is the software included">Is the software included in your costs?</a> <br>
•	<a href="#Is there any software">Is there any software that I need to install or maintain?</a><br>
•	<a href="#Can I answer">Can I answer some of my own web chat enquiries along with your team?</a><br>
•	<a href="#How can you be certain">How can you be certain that Live Chat will increase our sales?</a><br>
•	<a href="#How does Live Web Chat">How does ‘Live Web Chat’ give me an edge over the competition?</a><br>
•	<a href="#How much does the service cost">How much does the service cost?</a><br>
•	<a href="#Where is Live Web Chat">Where is ‘Live Web Chat’ based?</a><br>
•	<a href="#Am I tied">Am I tied in to a long term contract?</a><br>
•	<a href="#How do you notify">How do you notify me about chats you’ve had on my behalf?</a><br>
•	<a href="#Can I change the design">Can I white label the chat window and button?</a><br>
•	<a href="#How do I get started"> How do I get started?</a><br>
<br>
<p>
<div class="bubblered">
<a name="Just software"></a><h5><i>Q. Can you supply just the software?</i></h5> 
</div>
<div class="bubbleblue">
<h6>A. No, what we provide you with is both the software and the staff, completely removing the logistical nightmare of managing your own web chat.</h6>
</div>
<br>
<p>
<div class="bubblered">
<a name="Is the software included"></a><div class="h5"><i>Q. Is the software included in your costs?</i></div> 
</div>
<div class="bubbleblue">
<div class="h6">A. Yes. Our costs are all inclusive so there are no additional software costs. </div> 
</div>
<br>
<p>
<div class="bubblered">
<a name="Is there any software"></a><h5><i>Q. Is there any software that I need to install or maintain?</i></h5>
</div>
<div class="bubbleblue">
<h6>A. No. There is no software that you need to install or maintain. There are a couple of lines of code you need to paste on your website, that’s it.</h6>
</div>
<br>
<p>
<div class="bubblered">
<a name="Can I answer"></a><div class="h5a"><i>Q. Can I answer some of my own web chat enquiries along with your team?</i></div> 
</div>
<div class="bubbleblue">
<div class="h6a">A. No. We take responsibility for all of your web chat enquiries, leaving you free to concentrate on doing the things that will contribute most to the growth of your business.</div>
</div>
<br>
<p>
<a name="How can you be certain"></a><h2><i>How can you be certain that Live Chat will increase your sales?</i></h2> If you already have a viable business and online visitors then it makes sense that you’d see an increase in sales. If you are there for your customers when they need you (via a live chat service) and their questions are answered promptly; then common sense dictates that they are more likely to buy from you. 
<br>
<p>
<a name="How does Live Web Chat"></a><h2><i>How does ‘Live Web Chat’ give me an edge over the competition?</i></h2> of your competitors aren’t helping their website visitors to make a purchase unless the visitor calls them. By using Live Web Chat potential customers have someone who can walk them through any problems or queries without them having the barrier of needing to pick up the phone. If they become confused or have a question that may make or break a sale, your team of Live Web Chat agents are there to clarify matters. This helps eliminate 'bounce' away from websites and therefore reduces lost income.
<br>
<p>
<a name="How much does the service cost"></a><h2><i>How much does the service cost?</i></h2> The ‘Live Web Chat’ service starts from just £65 per month. Download our full list of prices at the bottom of this page. 
<br>
<p>
<a name="Where is Live Web Chat"></a><h2><i>Where is LiveWebChat based?</i></h2> We’re a UK company based in Brighton & Hove, East Sussex and all of our staff are from the local area. 
<br>
<p>
<a name="Am I tied"></a><h2><i>Am I tied in to a long term contract?</i></h2> No. The notice period is just two months from the end of the month that notice is given.  
<br>
<p>
<a name="How do you notify"></a><h2><i>How do you notify me of chats you’ve had on my behalf?</i></h2> The moment the chat has ended we email you the details to let you know. We will also email you a daily summary at the end of every day with details of every chat we have had on your account that day. 
<br>
<p>
<a name="Can I change the design"></a><h2><i>Can I white label the chat window and button?</i></h2> Yes, on our Advanced and Pro plans it will be configured to your requirements from the start.   	
<br>
<p>
<a name="How do I get started"></a><h2><i>How do I get started?</i></h2> Simply call us on 01273 741113, or 0333 200 0504 or use the Arrange a call back button below. 

<br>
<br>

			Talk to us today about adding <font color ="423062"><b>Live</font><font color ="AB2C26">Web</font><font color ="423062">Chat</b></font> to your business.
<!--<img class="displayed" src="images/livewebchat-flowchart-900.jpg" alt="Services">-->

<!--<img src="images/Home_Services.png" alt="Services">-->
<br>
<br>

			<div class="underContent">
				<!--<div class="imagesFotter">
					<a href="http://www.linkedin.com/company/csnotepad/products?trk=tabs_biz_product" target="_blank" title="Linked in"><img src="/images/linkedin.png" style="width: 50px; height:50px"></a>
					<img src="/images/fsb.png" style="width: 50px; height:50px">
					<img src="/images/chamber.png"style="width: 50px; height:50px">
					<img src="/images/hba.png" class="hba"style="width: 50px; height:50px">
				</div>-->

				<div class="semiFooter">
					<!--<a href="/our-services">
						<img src="images/signup3.jpg" alt="Signup" class="cards">
					</a>-->
					
					<span class="footerCallMore"><!--Call now to find out more--> <strong>01273 741113</strong></span>
	<br>
					<div class="semiFooterbottom">
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">Arrange a call back</button>
					</a>
				<a href="/our-services.php" <!--rel="fancybox-support" class="fancybox.iframe"-->
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">Compare plans</button>
					</a>
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">Download prices</button>
					</a>
				</div>
	<br>
	<br>
					<span class="companyNo">LiveWebChat is a trading division of Call Solution Ltd.  Registered in England 6107188.</span>
					<!--<span class="companyNo">Registered in England 6107188.</span>-->
					
				</div>
				
			</div>
			<?php // } ?>
		</div>

		
		
		
	</div>
	<div id="contentBottom">
	
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




