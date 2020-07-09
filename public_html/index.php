<!DOCTYPE html>

<html lang="en-GB">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			
	    <title>CSnotepad Virtual Receptionist Service</title>
		<meta name="description" content="otepad virtual Receptionist provide Telephone Answering, Order Taking, Diary Management and Virtual Assistant services to large and small businesses." />

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NVWB2MG');</script>
		<!-- End Google Tag Manager -->
			
		<!--[if lt IE 9]><html lang="en-us" class="ie"><![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript" defer="defer"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js" type="text/javascript"  defer="defer"></script>

		<link rel="canonical" href="/" />
		<link rel="stylesheet" type="text/css" href="/css/fonts/fonts-min.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/reset.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/cs_notepad-min.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/shop-min.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/new-home-min.css?1" />
		<link href="/css/tabmenu-min.css?Cache-Control: max-age=2592000" rel="stylesheet" type="text/css" />
		<script async src="/js/tabmenu.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script async src="/js/scrollto.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script async src="/js/scripts.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script async src="/js/cufon-yui.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<link href="/css/jquery.fancybox.css" rel="stylesheet" />
		<script src="/js/jquery.fancybox.pack.js" type="text/javascript" defer="defer"></script>
		<script src="/js/support.js" type="text/javascript" defer="defer"></script>
		<script src="/js/signup.js" type="text/javascript" defer="defer"></script>
		
		<script src="/html/js/jquery.boxy.js" type="text/javascript" defer="defer"></script>
		<link rel="stylesheet" type="text/css" href="/html/js/stylesheets/boxy.css" />
		<script type="text/javascript" defer="defer">
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
		<script async src="/js/jquery.validationEngine-en.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script async src="/js/jquery.validationEngine.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script async src="/js/jquery.signaturepad.min.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script async src="/js/json2.min.js?Cache-Control: max-age=2592000" type="text/javascript" defer="defer"></script>
		<script  defer="defer">
	  	jQuery(document).ready(function(){
                jQuery("#contact-form").validationEngine();
				$('.ProductTable:not(.Virtual.Address) tr').click(function(){
					window.location.href = $(this).find("a").attr("href");
				});
            });
	  	</script>
		  
	  	<link rel="stylesheet" href="/css/jquery.signaturepad.css?Cache-Control: max-age=2592000">

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

		<!-- ClickGuardian.co.uk -->

    </head>

	<?PHP
		include_once 'common.php';
		include_once 'db.php';
		@include_once(dirname(__FILE__).'/config.php');
		@session_start();
		include_once dirname(__FILE__).'/includes/functions/generalFunctions.php';
	?>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVWB2MG"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
	<a name="Home"></a>
		<div id="wrappernewfullhomeheader" alt="Support you need when you need it. Telephone Answering &amp; Live Web Chat Services." title="CSnotepad Telephone Answering &amp; Live Web Chat Services">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<div id="topBarRightBoxNewSTL">			
					<div id="menuBoxNewstl">		
						<div class="phonenumbernewleft">
							<span> <a href="/"> <img src="/images/logo_light_noshadow.png?Cache-Control: max-age=2592000" style="margin-top: -44px; margin-left: -13px; width: 330px; height: 165px" alt="CSnotepad virtual office address cost effective alternative to renting office" title="CSnotepad Virtual Receptionists" /></a></span>
						</div>
						<ul id="menunewstl">
							<li class="home selected" style="margin-left: 72px; margin-top: 34px">
								<a href="/" title="Home">Home</a>
							</li>
							<li class="Why us? unselected" style="margin-left: 40px; margin-top: 34px">
								<a href="/reasons" title="Testimonials">Testimonials</a>
							</li>
							<li class="Services unselected dropdown" style="margin-left: 45px; margin-top: 34px">
								<button class="dropbtn">Services</button>
								  <div class="dropdown-content">
								    <a href="/telephone-answering-service" title="Telephone answering" style="color: #505050">Telephone answering</a>
								    <a href="/live-web-chat" title="Live Web Chat" style="color: #505050">Live Web Chat</a>
								    <a href="/virtual-assistant" title="Virtual assistant" style="color: #505050">Virtual assistant</a>
								    <a href="/virtual-assistant" title="Helpdesk support" style="color: #505050">Helpdesk support</a>
								    <a href="/telephone-answering-charities" title="Charities" style="color: #505050">Charities</a>
								    <a href="/virtual-office" title="Virtual address" style="color: #505050">Virtual address</a>
								  </div>
							</li>
							<li class="FAQ unselected" style="margin-left: 47px; margin-top: 34px">
								<a href="/virtual-receptionist-faq" title="FAQ">FAQ</a>
							</li>
							<li class="Contact unselected" style="margin-left: 45px; margin-top: 34px">
								<a href="/contact" title="Contact">Contact</a>
							</li>
						</ul>				
						<div class="phonenumbernew">		
						</div>			
						<div class="clear"></div>
					</div>		
				</div>
				<div class="clear"></div>
			</div>
			<div id="headlinetop">
				<div class="newsite_headline">
					<ul class="homepointsnewstl">
						<span>
							
							<ul style="list-style-type: none; display: inline-block;">
								<li style="margin-right: 37px"><a href="/telephone-answering-service" title="Telephone Answering">Telephone Answering</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block; ">
								<li style="margin-right: 40px"><a href="/live-web-chat" title="Live Web Chat">Live Web Chat</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block; ">
								<li style="margin-right: 41px"><a href="/virtual-assistant" title="Virtual Assistant">Virtual Assistant</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block; ">
								<li style="margin-right: 35px"><a href="/virtual-office" title="Virtual Address">Virtual Address</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block;">
								<li style="margin-right: 52px"><a href="/telephone-answering-charities" title="Charities">Charities</a></li>
							</ul>
						</span>
					</ul>
					<p>
				</div>
			</div>
		
			<div class="homeleftnewourservices">
				
			</div>
	
			<div style="clear:both;"></div>
			<ul id="tabmenu">
    
				<li><a href="#home" title="Home">Home</a></li>

				<li><a href="/telephone-answering-service" title="Telephone Answering">Telephone Answering</a></li>
				<li><a href="/live-web-chat" title="Live Web Chat">Live Web Chat</a></li>
				<li><a href="/virtual-assistant" title="Virtual Assistant">Virtual Assistant</a></li>
				    <li><a href="/virtual-office" title="Virtual Office Address">Virtual Office Address</a></li>
					<li><a href="/telephone-answering-charities.php" title="Charities">Charities</a></li>
			</ul>					
					
				<div class="clear"></div>
			
		</div>

		<div id="wrappernewfullhometestimonials" title="CSnotepad Telephone Answering Testimonials">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<h1 style="margin-top: 25px;  font-size: 48px;">Welcome to CSnotepad…</h1>
				<div class="newsitehometestimonials_text" style="padding-top: 0px;">
					Whether you’re a <strong>sole trader</strong>, <strong>small business</strong> or <strong>large corporation</strong> there is nothing like the <strong>stability</strong>, <strong>reassurance</strong> and <strong>flexibility</strong> that comes from having a <strong>great team of people</strong> available when you need them.
					<br>
					<br>
					Every service is <strong>designed around you</strong> and <strong>tailored to fit your needs</strong> in the best way possible, with your <strong>personal team</strong> of virtual receptionists able to deliver <strong>far more than a basic message taking service</strong> for your business. 
					<br>
					<br>
					So whether you are a <strong>small business looking for support during busy periods</strong> or a <strong>large company requiring extra help</strong>, we’ll make sure you get the support you need when you need it. 
					<br>
					<br>
					&nbsp&nbsp <font color="#2e6aa5">•</font>	Create the perfect first impression 
					<br>
					&nbsp&nbsp <font color="#2e6aa5">•</font>	Cost effective alternative to hiring staff
					<br>
					&nbsp&nbsp <font color="#2e6aa5">•</font>	Eliminate missed calls & lost opportunities
					<br>
					&nbsp&nbsp <font color="#2e6aa5">•</font>	Grow the service around your business needs 
					<br>
					<br>
					<div class="newsite_textlarger">Talk to an account manager today about how we can help <b>support</b> and <b>grow your business</b>: 
						<br>
						Call <b>01273 741400</b> or request a call back below.

						<a href="/support-contact" rel="fancybox-support" class="fancybox.iframe">
							<button type="submit" name="submit" value="submit" class="homepagelefttestimonials">YES I would like to talk to someone about my business</button>
						</a>
						<img src="/images/Companies-house-logo.png" alt="Companies House logo" title="Companies House logo" style="margin-left: 25px; margin-top: 20px; vertical-align: middle; float: left;">
					</div>

				</div>
				<div class="newsitehometestimonial" style="margin-top: -235px">
					<!--<img src="/images/Ric_Hayden.png" alt="Testimonial_RicHayden" align="bottom">-->
					<script type="application/ld+json">
						{
						  "@context": "http://schema.org/",
						  "@type": "Review",
						  "itemReviewed": {
							"name": ""
						  },
						  "reviewRating": {
							"@type": "Rating",
							"ratingValue": "5"
						  },
						  "name": "What a breath of fresh air CSnotepad have been to my business",
						  "author": {
							"@type": "Person",
							"name": "Karl Anscombe"
						  },
						  "reviewBody": "What a breath of fresh air CSnotepad have been to my business.  I had been hesitating about taking on a call answering service, I thought only I could answer the phone properly to my prospects and customers.. how wrong was I, after an initial set up call where I had the help to craft an awesome script.  I now have all my calls answered when I'm busy by a service that really is proving to be brilliant. I never miss a call, all the information I need is collected, my customers have no idea and think its a member of staff... they are professional, polite, friendly and efficient, what you'd expect from a well run business with a focus on great customer service. I now have time to do my part in the business and I cant tell you how liberating it has been.  Would I recommend them ... yes I would."
						}
					</script>
						What a breath of fresh air CSnotepad have been to my business.
						I had been hesitating about taking on a call answering service, I thought only I could answer the phone properly to my prospects and customers.. how wrong was I, after an initial set up call where I had the help to craft an awesome script.  I now have all my calls answered when I'm busy by a service that really is proving to be brilliant. 
						I never miss a call, all the information I need is collected, my customers have no idea and think its a member of staff... they are professional, polite, friendly and efficient, what you'd expect from a well run business with a focus on great customer service. 
						I now have time to do my part in the business and I cant tell you how liberating it has been.
						Would I recommend them ... yes I would.
					
						<div class="newsitehometestimonialsright_text" style="padding-top: 50px;">
							<a href="/reasons" title="read more" target="_blank"><u>read more >></u></a>
						</div>
				</div>
					
				<div class="clear"></div>	
			</div>
		</div>	
		
		<div id="wrappernewfullhometelephoneanswering" title="CSnotepad Telephone Answering">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
			<a name="ta"></a>
				<div class="newsitehometa_text">
					Having a reliable Telephone Answering service supporting your
					<br>
					business enables you to concentrate on growing your business without
					<br>
					the worry and expense of taking on additional staff.
					<br>
					<br>
					Whether you are a small business looking for support during busy
					<br>
					periods or a large company requiring extra help, we'll make sure you
					<br>
					<u>get the support you need when you need it.</u>
					<a href="/telephone-answering-service" title="Telephone Answering">
						<button type="submit" name="submit" value="submit" class="homepageta">&nbsp;&nbsp;find out more >>&nbsp;&nbsp;</button>
					</a>
					</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullhomelivewebchat" title="CSnotepad Live Web Chat">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
			<a name="ot"></a>
				<div class="newsitehomeot_text">
					Amazing software. Exceptional people. One Winning Combination.
					<br>
					<br>
					Live Web Chat is a <strong>faster, friendlier</strong> and more <strong>profitable</strong> way to engage with
					<br>
					your customers online by combining <strong>amazing software</strong> with the support
					<br>
					and knowledge of real people to ensure that <strong>no chat goes unanswered</strong>.
					<br>
					<br>
					Combine this with our market leading web chat software that's <strong>branded</strong> to your
					<br>
					business and you have the <strong>ultimate combination</strong> for any business looking to 
					<br>
					provide <strong>amazing customer service</strong> and <strong>generate more enquiries</strong>.
					<a href="/live-web-chat" title="Live Web Chat">
						<button type="submit" name="submit" value="submit" class="homepageot" style="margin-top: 35px;">&nbsp;&nbsp;find out more >>&nbsp;&nbsp;</button>
					</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullhomevirtualassistant" title="CSnotepad Virtual Assistant">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<a name="stl"></a>			
				<div class="newsitehomestl_text">
					Our team of virtual assistants provide a complete service that 
					<br>
					places us at the forefront of your calls; able to deal with every 
					<br>
					request you receive or on hand to back up your existing team 
					<br>
					when they are unavailable. 
					<br>
					<br>
					Whatever your requirements, your team of virtual receptionists will be there to 
					<br>
					support you how and when you need them to; whether that’s providing you 
					<br>
					with helpdesk support, processing orders, scheduling 
					<br>
					appointments or taking messages.
					<br>

					<a href="/virtual-assistant" title="Virtual Assistant">
						<button type="submit" name="submit" value="submit" class="homepagestl">&nbsp;&nbsp;find out more >>&nbsp;&nbsp;</button>
					</a>
				</div>			
				
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullhomevirtualofficeaddress" title="CSnotepad Virtual Office Address">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
					<a name="voa"></a>
					<div class="newsitehomevoa_text">
						A <strong>Virtual Office Address</strong> is a <strong>fantastic and cost effective alternative to 
						<br>
						hiring a physical office</strong> by providing your business with the <strong>image you 
						<br>
						would want,</strong> for only a <strong> fraction of the cost.</strong>
						<br>
						<br>
						Whatever your reasons considering a virtual office address, we'll provide
						<br>
						you with a <strong>reliable, professional service</strong> for as long as you need it.
						<a href="/virtual-office" title="Virtual Office Address">
							<button type="submit" name="submit" value="submit" class="homepagevoa">&nbsp;&nbsp;find out more >>&nbsp;&nbsp;</button>
						</a>
					</div>
				
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullhomeaboutus" title="CSnotepad About Us">
			<!--Content goes inside here-->
			<div id="topBarNewAboutUs">
				<div id="topBarRightBoxNewSTL">			
							
				</div>
				<div class="clear"></div>
			</div>

			<div id="datacapturepricelisttext" style="text-align: center">
				Want to see if CSnotepad is right for you? Click on the button below and one of our expert team will be in touch!
			</div>
			<div id="datacapturepricelist" style="text-align: center">
				<a href="/support-contact" rel="fancybox-support" class="fancybox.iframe">
					<button type="submit" name="submit" value="submit" class="homepageleft">YES I would like to talk to someone about my business</button>
				</a>
			</div>
			<br>
			<br>
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . '/virtual-receptionist-blog/wp-blog-header.php');
			?>
			<div id="latestnewsnewthumbnail">
				<div class="latestnewsarticle">
					<div class="latestnewsheading">
						<h2>Latest News</h2>
					</div>
					<?php
						$posts = get_posts('numberposts=4&order=DESC&orderby=post_date');
						foreach ($posts as $post) : setup_postdata( $post ); 
					?>
					<div class="newsinsert">			
						<center><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); echo "<br />"; ?></a><?php the_date(); ?></center>
						<strong><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></strong>    
						 
						<a href="<?php the_permalink() ?>">...Continue reading...</a>
					</div>
					<?php
						endforeach;
					?>
				</div>
			</div>
			<?php include 'includes/footer.php';?>
		</div>

<!-- begin Live web chat code -->
<?php include 'live-web-chat-js.php';?>
<!-- end Live web chat code -->

	</body>
</html>