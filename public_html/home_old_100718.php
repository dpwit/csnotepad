<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0" />-->		
        <title>CSnotepad Virtual Receptionist Service</title>
		<meta name="description" content="CSnotepad virtual Receptionist provide Telephone Answering, Order Taking, Diary Management and Virtual Assistant services to large and small businesses." />
		<!--<script src="/cms/js/jquery1.4.2/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="/cms/js/queryui_1.8.2_custom/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>-->

		
		<!--[if lt IE 9]><html lang="en-us" class="ie"><![endif]-->
		<script async src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript"></script>
		<script async src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js" type="text/javascript"></script>
	<!--<script src="/js/flashcanvas.js" type="text/javascript"></script>-->
		<link rel="stylesheet" type="text/css" href="/css/fonts/fonts.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/reset.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/cs_notepad.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/shop.css?Cache-Control: max-age=2592000" />
		<link rel="stylesheet" type="text/css" href="/css/new-home.css?1" />
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
	
<!-- Google Code for Remarketing Tag -->
<!-- ------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
------------------------------------------------- -->
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
	
<!--style="background-image:url(----/images/CS_comparison_table_V2_700x407.png)"-->
	<a name="Home"></a>
		<div id="wrappernewfullhomeheader" title="CSnotepad Virtual Receptionists">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<div id="topBarRightBoxNewSTL">			
					<div id="menuBoxNewstl">		
						<div class="phonenumbernewleft">
							<span> <a href="/home"> <img src="/images/logo_light_noshadow.png?Cache-Control: max-age=2592000" style="margin-top: -44px; margin-left: -13px; width: 330px; height: 165px" alt="CSnotepad virtual office address cost effective alternative to renting office" title="CSnotepad Virtual Receptionists" /></a></span>
						</div>
						<ul id="menunewstl">
							<li class="home selected" style="margin-left: 72px; margin-top: 34px">
								<a href="/home" title="Home">Home</a>
							</li>
							<li class="Why us? unselected" style="margin-left: 40px; margin-top: 34px">
								<a href="/reasons" title="Testimonials">Testimonials</a>
							</li>
							<li class="Services unselected" style="margin-left: 45px; margin-top: 34px">
								<a href="/our-services" title="Services">Services</a>
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
								<li style="margin-right: 40px"><a href="/order-taking" title="Order Taking">Order Taking</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block; ">
								<li style="margin-right: 41px"><a href="/virtual-assistant" title="Virtual Assistant">Virtual Assistant</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block; ">
								<li style="margin-right: 35px"><a href="/virtual-office" title="Virtual Address">Virtual Address</a></li>
							</ul>
							<ul style="list-style-type: none; display: inline-block;">
								<li style="margin-right: 52px"><a href="/telephone-answering-charities.php" title="Charities">Charities</a></li>
							</ul>
						</span>
					</ul>
					<p>
				</div>
			</div>
		
			<div class="homeleftnewourservices">
				
			</div>
	
			<div>
			<!--<div class="newsite_subheadline">Download Info Pack & Pricelist</div>-->
				<p>
					<a href="/signup-contact" rel="fancybox-signup" title="Download Price List" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="homepageheader" style="width: 249px">Download Price List</button>
					</a>	
			</div>
			
			<div style="clear:both;"></div>
			<ul id="tabmenu">
    
<li><a href="#home" title="Home">Home</a></li>

<li><a href="/telephone-answering-service" title="Telephone Answering">Telephone Answering</a></li>
<li><a href="/order-taking" title="Order Taking">Order Taking</a></li>
<li><a href="/virtual-assistant" title="Virtual Assistant">Virtual Assistant</a></li>
    <li><a href="/virtual-office" title="Virtual Office Address">Virtual Office Address</a></li>
	<li><a href="/telephone-answering-charities.php" title="Charities">Charities</a></li>
</ul>			
						
					</div>		
				</div>
				<div class="clear"></div>
			</div>
			
			
			
		</div>

		<div id="wrappernewfullhometestimonials" title="CSnotepad Telephone Answering Testimonials">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<div class="newsitehometestimonials_text">
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
</div>

					</div>
				<div class="newsitehometestimonial">
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
					</img>
<div class="newsitehometestimonialsright_text">
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
					<a href="/telephone-answering-service" title="Telephone Answering"">
						<button type="submit" name="submit" value="submit" class="homepageta">&nbsp;&nbsp;find out more >>&nbsp;&nbsp;</button>
					</a>
					</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullhomeordertaking" title="CSnotepad Order Taking">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
			<a name="ot"></a>
				<div class="newsitehomeot_text">
					Integrated order taking services designed around your in-house systems.
					<br>
					<br>
					It's not just that we process orders over the phone, <strong>we are able to manage
					<br>
					the entire order process.</strong> We can <strong>help customers who are chasing their
					<br>
					delivery</strong> by checking when items were dispatched via your back office
					<br>
					systems, we can <strong>chase suppliers, post out samples, handle complaints</strong>
					<br>
					and more than anything we are able to <strong> continually process orders and 
					<br>
					payments</strong> whenever your in-house team are unavailable.
					<a href="/order-taking" title="Order Taking">
						<button type="submit" name="submit" value="submit" class="homepageot">&nbsp;&nbsp;find out more >>&nbsp;&nbsp;</button>
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
		
	
			
			
<!--delete from here-->	

<!--delete to here -->
<div id="datacapturepricelisttext" style="text-align: center">Want to see if CSnotepad is right for you? Click on the button below and one of our expert team will be in touch!
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

<div id="footernew">
	<div class="wrapper_footernew">
		<div class="wrapper_footernew_title">Call <b>01273 741400</b> or email <a href="mailto:info@csnotepad.co.uk" style="color:white">info@csnotepad.co.uk</a></div>
		<div class="column_footernewfirst">
			<div class="title_footernew">Menu</div>
				<ul>
					<li><a href="/home" style="color: #ffffff" title="Home">Home</a></li>
				</ul>
				<ul>
					<li><a href="/reasons" style="color: #ffffff" title="Why us?">Why us?</a></li>
				</ul>
				<ul>
					<li><a href="/our-services/" style="color: #ffffff" title="Services">Services</a></li>
				</ul>
				<ul>
					<li><a href="/faq" style="color: #ffffff" title="FAQ">FAQ</a></li>
				</ul>
				<ul>
					<li><a href="/contact" style="color: #ffffff" title="Contact">Contact</a></li>
				</ul>
				
				<ul>
					<li><a href="/privacypolicy" style="color: #ffffff" title="Contact">Privacy Policy</a></li>
				</ul>
			
		</div>
		<div class="column_footernewsecond">
			<div class="title_footernew">Opening Hours <span>*Telephone answering is available for customers 24/7</span></div>
			<div class="title_footernew_hours">
				<ul>
					<li>Monday <span>8:30am - 6:00pm</span></li>
				</ul>
				<ul>
					<li>Tuesday <span>8:30am - 6:00pm</span></li>
				</ul>
				<ul>
					<li>Wednesday <span>8:30am - 6:00pm</span></li>
				</ul>
				<ul>
					<li>Thursday <span>8:30am - 6:00pm</span></li>
				</ul>
				<ul>
					<li>Friday <span>8:30am - 6:00pm</span></li>
				</ul>
				<ul>
					<li>Saturday <span>9:00am - 3:00pm</span></li>
				</ul>
				</div>
				<!--<ul>
					<li>*Telephone answering is available for customers 24/7</span></li>
				</ul>-->
				
		</div>
		<div class="column_footernewthird">
			
				<img style="float: left; margin: 5px 15px 40px 0px; box-shadow: 10px 10px 5px #323232" src="/images/GeminiHouse.png?Cache-Control: max-age=2592000">
			
				<!-- <img src="/images/GeminiHouse.png" style="box-shadow: 10px 10px 5px #323232"> -->
				
			<!--<div class="title_footernew">Address</div>-->
				<ul>
					<li>CSnotepad</li>
				</ul>
				<ul>
					<li>Gemini House</li>
				</ul>
				<ul>
					<li>136-140 Old Shoreham Road</li>
				</ul>
				<ul>
					<li>Brighton</li>
				</ul>
				<ul>
					<li>East Sussex</li>
				</ul>
				<ul>
					<li>BN3 7BD</li>
				</ul>
				<ul>
					<li> 
					</li>
				</ul>
				
		</div>
		<div class="column_footernewforth">
			
				<ul>
					<li></img></a><a href="https://www.facebook.com/CSnotepad-167447616636513/" target="_blank" title="CSnotepad facebook"><img src="/images/Facebook-50.png?Cache-Control: max-age=2592000" alt="Facebook"></img></a>        <a href="https://www.linkedin.com/company/csnotepad" target="_blank" title="CSnotepad LinkedIn"><img src="/images/LinkedIn-50.png?Cache-Control: max-age=2592000" alt="LinkedIn" align="middle">        </img></a><a href="https://plus.google.com/104749442767440988994" target="_blank" title="CSnotepad Google+"><img src="/images/GooglePlus-50.png?Cache-Control: max-age=2592000" alt="Google+"></img></a>        <a href="https://www.youtube.com/channel/UCpb7xUrC7UFF2ZRUBjKqomA" target="_blank" title="CSnotepad YouTube"><img src="/images/YouTube-50.png?Cache-Control: max-age=2592000" alt="YouTube"></img></a></li>
				</ul>
				
		</div>
		
		
	</div>
 	<!--Google Star Rating in Google Search Results-->
  <div itemscope="" itemtype="https://schema.org/ProfessionalService" style="color:white; padding-top:5px">
  <img itemprop="image" src="https://www.csnotepad.co.uk/images/logo.png?Cache-Control: max-age=2592000" alt="CSnotepad Virtual Receptionist" style="display:none;">
  <span itemprop="name">CSnotepad Virtual Receptionist</span>
  <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress" style="color:white">Gemini House<span itemprop="streetAddress">136-140 Old Shoreham Road</span>,<span itemprop="addressLocality">Brighton</span>,<span itemprop="addressRegion">East Sussex</span>,<span itemprop="postalCode">BN3 7BD</span>,<span itemprop="addressCountry">GB</span> |Tel: <span itemprop="telephone">01273 741400</span> |Email: <a href="mailto:info@csnotepad.co.uk" color="white" itemprop="email"></a>.</div>
  <div itemprop="aggregateRating" itemscope="" itemtype="https://schema.org/AggregateRating" style="color:white">
  <span itemprop="ratingValue">4.9</span>
out of <span itemprop="bestRating">5</span>
based on <span itemprop="ratingCount">64</span> user ratings.
  </div>
  </div>
</div>
</div>
<!--<div id="latestnewsnew">
	<div class="latestnews">
				<div class="latestnewsheading">
					<h2>Latest News</h2>
				</div>
			<?php

			$conn = mysql_connect('localhost','call02_sql2','6eCkTEBeiR52Q86Q') or die('Conn failed');
			mysql_select_db('call02_db2',$conn) or die('Select failed');

			$querystr = "
			SELECT *, wposts.ID post_id, wpusers.ID user_id
			FROM wp_posts wposts, wp_users wpusers
			WHERE wpusers.ID = wposts.post_author
			AND wposts.post_status = 'publish'
			AND wposts.post_type = 'post'
			ORDER BY wposts.post_date DESC limit 3
			";
			$result = mysql_query($querystr);

			while($row = mysql_fetch_assoc($result)){ ?>
			<div class="newsinsert">
			<p>	<strong><a href="/blog/<?=$row['post_name']?>"><?=htmlentities($row['post_title'])?></a></strong>
			<?=substr_words(60,$row['post_content'],'...')?>
			<a href="/blog/<?=$row['post_name']?>">more</a>
			</p></div>
			<?php }
			?>
		</div>

</div>-->

</div>

</body>
</html>