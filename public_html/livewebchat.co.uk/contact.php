<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>www.livewebchat.co.uk</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="LiveWebChat for your business, providing you with both the software and the staff to actively engage your website visitors" />
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
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65019023-1', 'auto');
  ga('send', 'pageview');

</script>
	
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
		<span style="padding-right:25px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>
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
	<div class="semiFootertop">
				<a href="/howitworks.php" <!--rel="fancybox-support" class="fancybox.iframe"-->
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px; padding-left:50px; padding-right:50px">How it works</button>
					</a>
				<!--<a href="/howitworks.php" <!--rel="fancybox-support" class="fancybox.iframe"-->
						<!--<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">How it works</button>
					</a>-->
				<a href="/signup-contact.php" rel="fancybox-signup" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">Download prices</button>
					</a>
				</div>
	<!--<div class="subheader">-->
	<!--<h2>Whatever the size of your company we're here to answer your telephone calls when you can't, whether you receive hundreds of calls a month or not, you can expect a bespoke service tailored precisely to your businesses needs.</h2>
	<span>01273 741 400</span>-->
	
	
		
	<!--</div>-->
			
			<div id="mainSection">
				
				<div id="mainSection2ColLeft">
				<div id="breadcrumb"><h3><b>You are here: </b>
<a class='breadcrumb' title="Home" href="home.php">Home</a>  &gt; <a class="breadcrumb" title="Contact" href="contact.php">Contact</a></h3></div>
<div id="breadcrumb-search-fields" style="display:none;">
	<input type='hidden' name='from' value='/contact'/>
</div>
<br>
<h1><font color ="423062">Get</font><font color ="AB2C26"> In</font><font color ="423062"> Touch</font></h1>
<br>
				<div id="contactusgrey">	
					<div id="mainSection2ColLeftContactLeft">
                      <p>Email</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p><a href="mailto:info@livewebchat.co.uk"><img alt="" src="images/email_grey.jpg"></a></p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Address</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p> Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD</p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Telephone</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>01273 741113 or 0333 200 0504<br />

</p>
                    </div>
                    <div class="clear"></div>
                    <!--<div id="mainSection2ColLeftContactLeft">
                      <p>Fax</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>0330 300 3991</p>
                    </div>-->
				</div>	
                    <!--<div class="clear"></div>-->
				
				<br>
                    <br>
					<strong>Or why not let us contact you? Just fill in the form below.</strong><br>
					<br>
					
					<h2>Contact form</h2>
					
					<br>
					
					<form method="post" action="contact-process.php" id="contact-form">
					
					<div id="contactformgrey">	
					<!--<div>
							<label for="interestedIn">I am interested in:</label>
						    <select name="interestedIn">
                              <option value="Telephone Answering Services">Telephone Answering Services</option>
                              <option value="Call Patching">Call Patching</option>
                              <option value="Brochure / Quote Line">Brochure / Quote Line</option>
                              <option value="Order Taking">Order Taking</option>
                              <option value="Voicemail / Information Address">Voicemail / Information Address</option>
                              <option value="Virtual Address">Virtual Address</option>
                              <option value="Outbound Calling">Outbound Calling</option>
                              <option value="Something I haven't seen on your website">Something I haven't seen on your website</option>
                            </select>
					</div>-->
						<br>
						<div><label for="name">Name</label><input type="text" size="40" name="name" id="name" value="<?=$_SESSION['contactValues']['name']?>" class="validate[required]"></div>
						<br>
						<div><label for="businessName">Business name</label><input type="text" size="40" name="businessName" id="businessName" value="<?=$_SESSION['contactValues']['businessName']?>"></div>
						<br>
						<div><label for="email">Email</label><input type="text" size="40" name="email" id="email" class="validate[required,custom[email]]" value="<?=$_SESSION['contactValues']['email']?>"></div>
						<br>
						<div><label for="phone">Phone</label><input type="text" size="40" name="phone" id="phone" class="validate[required,custom[onlyNumber]]" value="<?=$_SESSION['contactValues']['phone']?>"></div>
						<br>
						<div>
							<label for="contactBy">Please contact me by:</label>
							<select name="contactBy">
								<option value="Phone">Phone</option>
								<option value="Email">Email</option>
							</select>
						</div>
						<br>
							<div><label for="additionalInfo">Additional info</label><textarea wrap="wrap" cols="40" rows="" name="additionalInfo" id="additionalInfo"  value="<?=$_SESSION['contactValues']['additionalInfo']?>"></textarea></div>
							<br>
						
						<!--<label for="submit">&nbsp;</label>
						<input type="submit" value="Submit" class="coolButton">
						<div align="center"><input name="submit" class="callme" id="callmegreen" type="submit" value="Submit"/></div>-->
						
						<div style="left: 170px; position: relative; visibility: show;"><input name="submit" class="callme" id="callmegreen" type="submit" value="Submit"/></div>
					</form>
					</div>
					
					
	        <br>
					<br>
					
					<p>
						<em><strong>Our opening hours are:- </strong><br>
						<br>
					  	Monday - Friday: 9am - 9pm<br>
						<br>
						Saturday: 9am - 1pm<br>
					  	</em>
					</p>
					<p>
						<!--<em>
						<br>
						Telephone answering extended hours are 24/7
						</em>-->
					</p>
					
					<!--br>
			    <br>
					<br>-->
					
				</div>
				<div id="mainSection2ColRight">
					<!--<div id="sideBarBoxTop">
						
					</div>-->
					<!--<div id="sideBarBoxMiddle">
						<?php
							include BASEPATH.'../includes/testimonials.php';
						?>
					</div>-->
					<!--<div id="sideBarBoxBottom">
						
					</div>-->
					<!--<p>
						<a href="/reasons" title="Why we're better than letting calls go to voicemail">
							<img width="217" height="75" alt="Why we're better than letting calls go to voicemail" src="images/answer_blue.jpg" onmouseover=this.src="images/answer_orange.jpg" onmouseout=this.src="images/answer_blue.jpg" title="Why we're better than letting calls go to voicemail" ></a>
						<a href="/Temp" title="Why we're better than employing extra staff">
							<img width="217" height="75" alt="Why we're better than employing extra staff" src="images/temp_blue.jpg" onmouseover=this.src="images/temp_orange.jpg" onmouseout=this.src="images/temp_blue.jpg" title="Why we're better than employing extra staff" ></a> 
						<a href="/competition" title="Why we're better than the competition">
							<img width="217" height="75" alt="Why we're better than the competition" src="images/competition_blue.jpg" onmouseover=this.src="images/competition_orange.jpg" onmouseout=this.src="images/competition_blue.jpg" title="Why we're better than the competition" ></a>
					 
					</p>-->
				</div>
				<div class="clear"></div>
				
			</div>
			<br>
			Talk to us today about adding <font color ="423062"><b>Live</font><font color ="AB2C26">Web</font><font color ="423062">Chat</b></font> to your business.
<!--<img class="displayed" src="images/livewebchat-flowchart-900.jpg" alt="Services">-->

<!--<img src="images/Home_Services.png" alt="Services">-->
<!--<div class="openinghours">
Our opening hours are
<br>
Mon-Fri: 9am – 9pm, 
<br>
Sat: 9am – 1pm
</div>-->
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
	<br>				
					<span class="footerCallMore"><!--Call now to find out more--> <strong>01273 741113</strong><img src="images/Review_TeodorHlihor.png" style="padding-left: 70px" alt="Review Teodor Hlihor"><img src="images/Review_CallumFowler.png" style="padding-left: 40px"alt="Review Callum Fowler"></img></span>
	<br>
					<div class="semiFooterbottom">
				<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">Arrange a call back</button>
					</a>
				<a href="/our-services.php" <!--rel="fancybox-support" class="fancybox.iframe"-->
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 20px">Compare plans</button>
					</a>
				<a onclick="window.open('/signup-contact.php', 'downloadprices', 'width=600,height=625')">
				<!--<a href="/signup-contact.php" title="Download prices" class="fancybox.iframe" >-->
				<button type="submit" name="submit" value="submit" class="bt-support">Download prices</button>
						</a>
				</div>
	<br>
	<br>
	<div class="latestnews">
				<div class="latestnewsheading">
					<h2>Latest News</h2>
				</div>
			<?php

			$conn = mysql_connect('localhost','call02_admin','10_Aug_15') or die('Conn failed');
			mysql_select_db('call02_blog',$conn) or die('Select failed');

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
			
			<?=substr($row['post_content'],0,99),'...'?>
			<a href="/blog/<?=$row['post_name']?>">more</a>
			</p>
			</div>
			<?php }
			?>
			
		</div>
					<!--<span class="companyNo">LiveWebChat is a trading division of Call Solution Ltd.  Registered in England 6107188.</span>-->
					<!--<span class="companyNo">Registered in England 6107188.</span>-->
					
				</div>
				
			</div>
			<?php // } ?>
		</div>

		<div id="contentBottom">
	
		</div>
		
		
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
      oC4AW_Widget.setAccGUID("755A7B99-4F47-4A47-83A2-26F54EF2AA53"); 
      oC4AW_Widget.setWSGUID("fc7b9144-fbc0-4846-adab-cb2b1bd60959"); 
      oC4AW_Widget.setWFGUID("bb29dc5b-5957-4d1a-9bff-5498efb7b557"); 
      oC4AW_Widget.setPopupWindowWFGUID("e639bf2c-efd5-416b-95f0-cfee8c22b105"); 
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
C4A_TB.setAccountGUID('755A7B99-4F47-4A47-83A2-26F54EF2AA53');
C4A_TB.setWebsiteGUID('fc7b9144-fbc0-4846-adab-cb2b1bd60959');
C4A_TB.setUseCookie(true);
C4A_TB.Run();
}
</script>
<script src="https://prod3si.click4assistance.co.uk/JS/TrackProactive.js" type="text/javascript" defer="defer"></script>

<noscript>
<img src="https://prod3si.click4assistance.co.uk/Tracking/PageHit_NoScript.aspx?AccountGUID=755A7B99-4F47-4A47-83A2-26F54EF2AA53&amp;WebsiteGUID=fc7b9144-fbc0-4846-adab-cb2b1bd60959" alt="Live Chat Software by Click4Assistance UK" />
</noscript>
<!-- Click4Assistance Tracking/Proactive Script -->




