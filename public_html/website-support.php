<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Low cost, pay monthly website support services | CSnotepad</title>
		<meta name="description" content="Cost effective website support and development for businesses" />
		<meta name="keywords" content="Low cost website support, PAYG website support, website support and development">
		<script async src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript"></script>
		<script async src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js" type="text/javascript"></script>
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
	<script type="text/javascript">// <![CDATA[
							function toggle(Info) {
							var CState = document.getElementById(Info);
							CState.style.display = (CState.style.display != 'block')
							                   ? 'block' : 'none';
							              
							           }
										
								// ]]>
						</script>
	<style>
		.FAA { display:none; }
		@font-face{
			font-family: Lato;
			src: url('/fonts/Lato-Regular.ttf');
		}
	</style>
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
		<!--------------------------------------------------
		Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
		--------------------------------------------------->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1055112536;
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1055112536/?guid=ON&amp;script=0"/>
		</div>
		</noscript>
	
	
		<!--style="background-image:url(----/images/CS_comparison_table_V2_700x407.png)"-->
		<a name="Home"></a>
		<div id="wrappernewfullwebsitesupport" title="CSnotepad website support services">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<div id="topBarRightBoxNewSTL">			
					<div id="menuBoxNewstl">		
						<div class="phonenumbernewleft">
							<span><img src="/images/logo_light_noshadow.png?" style="margin-top: -44px; margin-left: -13px; width: 330px; height: 165px" alt="CSnotepad virtual office address cost effective alternative to renting office" title="CSnotepad Virtual Receptionists"></span>
						</div>
						<ul id="menunewstl">
							<li class="home selected" style="margin-left: 22px; margin-top: 34px">
								<a href="#howitworks" title="How it works">How it works</a>
							</li>
							<li class="Why us? unselected" style="margin-left: 40px; margin-top: 34px">
								<a href="#prices" title="Prices">Prices</a>
							</li>
							<li class="Services unselected" style="margin-left: 45px; margin-top: 34px">
								<a href="#idv" title="ID verification">ID verification</a>
							</li>
							<li class="FAQ unselected" style="margin-left: 47px; margin-top: 34px">
								<a href="#faqs" title="FAQ">FAQ</a>
							</li>
							<li class="Contact unselected" style="margin-left: 45px; margin-top: 34px">
								<a href="#contact" title="Contact">Contact</a>
							</li>
						</ul>				
						<div class="phonenumbernew">		
						</div>			
						<div class="clear"></div>
					</div>		
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="homeleftnewourservices">	
			</div>

			<div style="clear:both;">
			</div>
			
				<a href="/signup-mailbox-fullform" rel="fancybox-support" title="Set up mailbox" class="fancybox.iframe">
					<button type="submit" name="submit" value="submit" class="homepagelefttestimonials" style="margin-top: 10px; margin-left: 450px">Yes I would like to talk to someone about website support</button>
				</a>
		</div>		
				
		<div class="clear"></div>
		
		<div id="wrappernewfullwelcomewebsupport" title="CSnotepad Telephone Answering Testimonials">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<div class="newsitehometestimonials_text" style="font-size: 14px;">
					Are you looking for a premium website support service without the premium prices? 
					<br>
					<br>
					At CSnotepad we provide cost-effective, in-house website support and development, enabling our clients to continually update and improve their website with regular amendments.
					<br>
					<br>
					We recognise the challenge businesses face with the high cost of website support due to the expensive nature of this area of expertise. We're not saying that the costs associated with website support aren't justified, but we recognise that for many businesses rates such as &pound;500+ per day, and minimum half day bookings can be a huge stretch on budgets. 
					<br>
					<br>
					With CSnotepad, we challenge the status quo by offering 4 very simple plans, ranging from as little as just 1-hour support per month to 20+ hours per month with minimum job requests of just 30 minutes.
					<br>
					<br>
					The support and development we can offer includes:
					<br>
					<br>
					<font color="#ff8834">•</font>&nbsp;Amending information on your site<br>
					<font color="#ff8834">•</font>&nbsp;Adding new functionality<br>
					<font color="#ff8834">•</font>&nbsp;Creating new pages<br>
					<font color="#ff8834">•</font>&nbsp;Constructing data feeds<br>
					<font color="#ff8834">•</font>&nbsp;Setting up management information reports<br>
					<font color="#ff8834">•</font>&nbsp;&hellip;in fact, pretty much anything website related including building new websites!<br>
					
					<a href="/signup-mailbox-fullform" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="homepagelefttestimonials" style="margin-top: 20px;">Yes I would like to talk to someone about website support</button>
					</a>

				</div>
			</div>
			<div class="newsitehomewelcomemailbox" style="margin-top: -410px;">				
				<img src="/images/reviews-stars.png" alt="Review Stars">
				<img src="/images/GemmaOSullivan.png" alt="Testimonial Gemma O'Sullivan" align="bottom">
				<br>
				<p style="font-size: 14px; margin-top: 0px; margin-left: 10px;">Excellent service, highly recommended.  I have used them for years.</p>
				<img src="/images/GaryFenton.png" alt="Testimonial Gary Fenton" align="bottom">
				<br>
				<p style="font-size: 14px; margin-top: 0px; margin-left: 10px;">A very professional service that I've been using for several years and thoroughly recommend.</p>
				<img src="/images/AndrewGlaister.png" alt="Testimonial Andrew Glaister" align="bottom">
				<br>
				<p style="font-size: 14px; margin-top: 0px; margin-left: 10px;">Always thoughtful and helpful keep up the good work.</p>
				<img src="/images/DavidRothstein.png" alt="Testimonial David Rothstein" align="bottom">
				<br>
				<p style="font-size: 14px; margin-top: 0px; margin-left: 10px;">Great Company. They do everything 100 per cent to what is promised. Makes my life so easy. Highly recommended as a company !!!</p>
				<!--<div class="newsitehometestimonialsright_text">
					<a href="/reasons" title="read more" target="_blank"><u>read more >></u></a>
				</div>-->
			</div>
					
			<div class="clear"></div>
				
				
		</div>
			
		<div id="wrappernewfullwebsitesupporthowitworks" title="CSnotepad How it Works">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<a name="howitworks"></a>
					<div class="newsitehometa_text" style="font-size: 14px;">
						Once you have setup your account and selected the plan that is best for you, 
						<br>
						a website developer will give you a call at a time that suits you. 
						<br>
						On this call, they will ask you to share with them your vision and requirements for the website. 
						<br>
						Furthermore, should you wish, they can share with you their initial thoughts and recommendations 
						<br>
						based on their many years of experience. 
						<br>
						<br>
						Following this discussion, your website developer will commence work on your website 
						<br>
						and they will regularly update you on all work completed. 
						<br>
						<br>
						At any point in time, you can request new website work or amend any existing work. 
						<br>
						<br>
						It really is that simple&hellip;  
						<br>
						
						<a href="/signup-mailbox-fullform" rel="fancybox-support" class="fancybox.iframe">
							<button type="submit" name="submit" value="submit" class="homepageta" style="margin-top: 40px; margin-left: 185px;">Yes I would like to talk to someone about website support</button>
						</a>
					</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullpostaladdressprices" title="CSnotepad Mailbox prices">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
			<a name="prices"></a>
				<div class="newsitehomeot_text" style="font-size: 14px; text-align: left; padding-left: 0px; width: 55%">
					Whether you would like your post stored for collection, scanned to email or forwarded on to you, the cost of setting up your secure UK postal address is the same.  
					<br>
					<br>
					<font style="font-size: 20px;"><strong>Secure UK postal address</strong></font><br>
					 <font color="#ff8834">•</font>&nbsp;Quarterly in advance &ndash; &pound;30 (equivalent to just &pound;10 a month)<br>
					 <font color="#ff8834">•</font>&nbsp;Bi-annually in advance &ndash; &pound;49.98 (equivalent to just &pound;8.33 a month)<br>
					 <font color="#ff8834">•</font>&nbsp;Annually in advance &ndash; &pound;72.60 (equivalent to just &pound;6.05 a month)<br>
					 <font style="font-size: 11px;">All prices are subject to VAT at 20%</font>
					<br>
					<br>
					<font style="font-size: 20px;"><strong>Security Deposit</strong></font><br>
					As part of your postal address service we will hold a fully-refundable
					&pound;30 security deposit on account. When you stop your service 
					with us, your security deposit will be automatically refunded back to you.

					<!--<strong>Handling charges</strong><br>
					We apply a small charge for each item of mail that we receive and process for you; to sign-for (if necessary), identify, sort, insure whilst on the premises and prep for forwarding.
					<br>
					<br>
					<strong>Mail forwarding:</strong><br>
					Letters &ndash; 75p + postage<br>
					Parcels &ndash; &pound;1.50 + postage
					<br>
					Scan to email: 50p per item
					<br>
					Mail storage (1 month): FREE
					<br>
					Additional months &ndash; &pound;5 a month (includes up to 50 letters)
					<br>
					SMS/email postal alerts: 20p-->
					<br>

					<a href="/handling-charges" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="homepageot" style="margin-left: 250px; margin-top: 45px;">View our mail handling charges</button>
					</a>
					</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullmailboxidverification" title="CSnotepad ID verification">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
				<a name="idv"></a>			
				<div class="newsitehomestl_text" style="font-size: 14px; text-align: left; padding-left: 520px;">
					<strong>Photo ID</strong><br>
					At least one photographic proof of identity is required for the named Account Holder.
					<br>
					<br>
					<strong>This could be your:</strong>
					<br>
					  &nbsp&nbsp <font color="#ff8834">•</font>&nbsp;Passport photo page<br>
					  &nbsp&nbsp <font color="#ff8834">•</font>&nbsp;UK driving licence photo card<br>
					  &nbsp&nbsp <font color="#ff8834">•</font>&nbsp;European Union travel ID card<br>
					  &nbsp&nbsp <font color="#ff8834">•</font>&nbsp;Other Government issued photo ID card<br>
					<!--<strong>As a UK citizen</strong>, your passport alone is usually enough to meet the required points criteria.-->
					<br>
					<strong>Proof of residency &ndash; mail forwarding</strong><br>
					If you would like your post to be forwarded to you then at least one proof of residency is required for the named account holder, dated within the last three months, registered at the address you would like your post forwarded to.
					<br>
					<br>
					<!--This could be:
					<ol type="i">
					<li>A utility bill dated within the last 3 months</li>
					<li>A mobile phone bill dated within the last 3 months</li>
					<li>A bank statement dated within the last 3 months</li>
					</ol>
					ID processing usually takes less than 2 hours during the working week  (Monday to Friday). Once verified we will email you confirmation that your account is active.   -->
					Please note that whilst post can be received on your behalf whilst we are waiting for your ID, we are unable to release any post to you during this time. ID verification is required within 7 days of registration.


					<a href="/signup-mailbox-fullform" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="homepagestl" style="margin-left: 205px; margin-top: 55px;">Set up your secure UK postal address</button>
					</a>
					</div>			
				
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="wrappernewfullmailboxfaqs" title="CSnotepad FAQs">
			<!--Content goes inside here-->
			<div id="topBarNewSTL">
					<a name="faqs"></a>
					<div class="newsitehomevoa_text">
						

						<div class="FAQ" onclick="toggle('faq1')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>How long will it take to set up my service?</u></strong>
							<div id="faq1" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;Providing there are no unexpected delays we will aim to have your account set up the same day.</div>
						</div>
						<br>
						
						<div class="FAQ" onclick="toggle('faq2')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>Am I tied into a contract?</u></strong>
							<div id="faq2" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;No. At CSnotepad we don't believe in tying you into a long contract, should you ever wish to cancel, all we require is 2 full calendar months' notice.</div>
						</div>
						<br>
						
						<div class="FAQ" onclick="toggle('faq3')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>What are your hours of service?</u></strong>
							<div id="faq3" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;Our office if open Monday to Friday 8:30am &ndash; 6:00pm and Saturday 9:00am &ndash; 3:00pm</div>
						</div>
						<br>
						<div class="FAQ" onclick="toggle('faq4')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>How many different names can I receive post for?</u></strong>
							<div id="faq4" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;All our packages allow one name per account.</div>
						</div>
						<br>
						<div class="FAQ" onclick="toggle('faq5')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>What if I need to receive post in more than one name?</u></strong>
							<div id="faq5" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;You can purchase additional mailing names at &pound;4 each per month.</div>
						</div>
						<br>
						<div class="FAQ" onclick="toggle('faq6')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>What kind of address will I be given?</u></strong>
							<div id="faq6" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;A real UK street address (not a PO Box). The address is our Brighton mailing address which is used for personal customers'.</div>
						</div>
						<br>
						<div class="FAQ" onclick="toggle('faq7')" style="font-size: 14px; cursor: pointer; text-align: left;"><strong><img src="/images/q.png" alt="Question" style="vertical-align: middle" />&nbsp;<u>Any other questions?</u></strong>
							<div id="faq7" class="FAA" style="font-size: 14px; text-align: left;"><img src="/images/a.png" alt="Answer" style="vertical-align: middle" />&nbsp;Please contact our team on 0800 086 2741 who will be happy to assist you.</div>
						</div>
						<br>

						<a href="/signup-mailbox-fullform" rel="fancybox-support" class="fancybox.iframe">
							<button type="submit" name="submit" value="submit" class="homepageot" style="margin-left: 190px;">Set up your secure UK postal address</button>
						</a>
					</div>
				
				
			</div>
		</div>
		
		<div id="wrappernewfullpostaladdressaboutus" title="CSnotepad About Us">
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
		<a href="/mailbox-contact" rel="fancybox-support" class="fancybox.iframe">
				<button type="submit" name="submit" value="submit" class="homepageleft">YES I would like to talk to someone about a postal address</button>
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
<a name="contact"></a>
<div id="footernew">
	<div class="wrapper_footernew">
		<div class="wrapper_footernew_title">Call <b>0800 086 2741</b> or email <a href="mailto:info@csnotepad.co.uk" style="color:white">info@csnotepad.co.uk</a></div>
		<div class="column_footernewfirst">
			<div class="title_footernew">Menu</div>
				<ul>
					<li><a href="/privacypolicy" style="color: #ffffff" title="Contact">Privacy Policy</a></li>
				</ul>
				<ul>
					<li>&nbsp;</li>
				</ul>
				<ul>
					<li>&nbsp;</li>
				</ul>
				<ul>
					<li>&nbsp;</li>
				</ul>
				<ul>
					<li style="font-size: 10px; line-height: 10px;">&nbsp;</li>
				</ul>
				<ul>
					<li style="font-size: 10px; line-height: 15px;">CSnotepad is a trading name of Call Solutiuon Ltd</li>
				</ul>
				<ul>
					<li style="font-size: 10px; line-height: 15px;">Registered in England and Wales: 06107188</li>
				</ul>
				<ul>
					<li style="font-size: 10px; line-height: 15px;">VAT No: 907531922</li>
				</ul>
			
		</div>
		<div class="column_footernewsecond">
			<div class="title_footernew">Opening Hours</div>
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
		<div class="column_footernewthird" style="vertical-align: 80px;">
			
				<img style="float: left; margin: -3px 15px 40px 0px; box-shadow: 10px 10px 5px #323232" src="/images/GeminiHouse.png?Cache-Control: max-age=2592000">
			
				<!-- <img src="/images/GeminiHouse.png" style="box-shadow: 10px 10px 5px #323232"> -->
				
			<!--<div class="title_footernew">Address</div>-->
				<ul>
					<li>CSnotepad</li>
				</ul>
				
				<ul>
					<li>140 Old Shoreham Road</li>
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
			
				<ul style="margin-top: -15px;">
					<li></img></a><a href="https://www.facebook.com/CSnotepad-167447616636513/" target="_blank" title="CSnotepad facebook"><img src="/images/Facebook-50.png?Cache-Control: max-age=2592000" alt="Facebook"></img></a>        <a href="https://www.linkedin.com/company/csnotepad" target="_blank" title="CSnotepad LinkedIn"><img src="/images/LinkedIn-50.png?Cache-Control: max-age=2592000" alt="LinkedIn" align="middle">        </img></a><a href="https://plus.google.com/104749442767440988994" target="_blank" title="CSnotepad Google+"><img src="/images/GooglePlus-50.png?Cache-Control: max-age=2592000" alt="Google+"></img></a>        <a href="https://www.youtube.com/channel/UCpb7xUrC7UFF2ZRUBjKqomA" target="_blank" title="CSnotepad YouTube"><img src="/images/YouTube-50.png?Cache-Control: max-age=2592000" alt="YouTube"></img></a></li>
				</ul>
				
		</div>
		
		
	</div>
 	<!--Google Star Rating in Google Search Results-->
  <div itemscope="" itemtype="https://schema.org/ProfessionalService" style="color:white; padding-top:5px">
  <img itemprop="image" src="https://www.csnotepad.co.uk/images/logo.png?Cache-Control: max-age=2592000" alt="CSnotepad Virtual Receptionist" style="display:none;">
  <span itemprop="name">CSnotepad Virtual Receptionist</span>
  <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress" style="color:white">Gemini House<span itemprop="streetAddress">136-140 Old Shoreham Road</span>,<span itemprop="addressLocality">Brighton</span>,<span itemprop="addressRegion">East Sussex</span>,<span itemprop="postalCode">BN3 7BD</span>,<span itemprop="addressCountry">GB</span> |Tel: <span itemprop="telephone">01273 741400</span> |Email: <a href="mailto:info@csnotepad.co.uk" color="white" itemprop="email"></a>.</div>
  <div itemprop="aggregateRating" itemscope="" itemtype="https://schema.org/AggregateRating" style="color:white">
  <span itemprop="ratingValue">4.9</span>
out of <span itemprop="bestRating">5</span>
based on <span itemprop="ratingCount">64</span> user ratings.
  </div>
  </div>

  <!-- Bing remarketing code -->
		<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"19000273"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");
		</script>
</div>
</div>
<!--<div id="latestnewsnew">
	<div class="latestnews">
				<div class="latestnewsheading">
					<h2>Latest News</h2>
				</div>
			<?php

			$conn = mysql_connect('localhost','15327asql','77Mjgyeu') or die('Conn failed');
			mysql_select_db('15327adb',$conn) or die('Select failed');

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