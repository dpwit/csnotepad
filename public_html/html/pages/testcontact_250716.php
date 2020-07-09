<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0" />-->		
        <title>CSnotepad Virtual Receptionist Service</title>
		<meta name="description" content="CSnotepad virtual Receptionist provide Telephone Answering, Order Taking, Diary Management and Support Ticket logging services to large and small businesses." />
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
<script
src="http://maps.googleapis.com/maps/api/js">
</script>

<script>
var myCenter=new google.maps.LatLng(50.8386753,-0.1761254);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:12,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter, map: map,
    title: 'CSnotepad'
  });

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

    </head>
	<body> <!--style="background-image:url(----/images/CS_comparison_table_V2_700x407.png)"-->
	<div id="wrappernewfull">
		<div id="topBarNew" >
			<div id="topBarRightBoxNew">
			
			<div id="menuBoxNew">
			
			<div class="phonenumbernewleft">
		<!--<span style="padding-right:25px; top:0px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741113</span>-->
		<span> <img src="/images/logo.png" alt="Virtual Receptionist Service"  /></span>
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>
			<ul id="menunew">
			<li class="home selected" >
			<a href="/home" title="Home">Home</a>
			</li>
			<li class="Why us? unselected">
			<a href="/html/content/testreasons.php" title="Testimonials">Testimonials</a>
			</li>
			<li class="Services unselected">
			<a href="/our-services" title="Services">Services</a>
			</li>
			<li class="FAQ unselected">
			<a href="/faq" title="FAQ">FAQ</a>
			</li>
			<li class="Contact unselected">
			<a href="/contact" title="Contact">Contact</a>
			</li>
			</ul>
		
				
			<div class="phonenumbernew">
		<span style="padding-top:20px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 01273 741400</span>
		<!--<span style="padding-right:25px"><img src="/images/telephone_small2.png" alt="Virtual Receptionist Service" align="top" /> 0333 200 0504</span>-->
		<!--<h1>Personalised Business Telephone Answering Services</h1>-->
	</div>		
	
			<div class="clear"></div>

		</div>
		
		</div>
		<div class="clear"></div>
		</div>
		<!--<div id="contentTop">
			
		</div>-->
		
<div id="wrapperhead">
	<div id="headlinetop">
		<div class="newsite_headline">Get In Touch...
			<ul class="homepointsnew">
			<span>
	
   <ul style="list-style-type: none; display: inline-block;">
      <li><a href="/our-services/telephone-answering-brighton" title="Telephone Answering">Telephone Answering</a></li>
   </ul>

   <ul style="list-style-type: none; display: inline-block; ">
      <li><a href="/our-services/order-taking" title="Order Taking">Order Taking</a></li>
   </ul>
   
   <ul style="list-style-type: none; display: inline-block; ">
     <li><a href="/our-services/order-taking" title="Support ticket logging">Support Ticket Logging</a></li>
   </ul>
    <ul style="list-style-type: none; display: inline-block; ">
     <li><a href="/our-services/virtual-address" title="Virtual Address">Virtual Address</a></li>
   </ul>
</span>
		</ul>
		<p>
		</div>
		</div>
		<div id="headlinefaq">
		<!--<div class="newsite_subheadline"><b>Grow your business</b> with a <b>tailor made virtual receptionist service,</b> designed to give you the <b>support you need, when you need it.</b>  Whether as overflow support for your in-house team or there as your customers' first point of contact, your team of <b>professional receptionists</b> are on hand to <b>guarantee you never miss a call again.</b></div>-->
		<div class="newsite_subheadlinefirst"><b>We'd love to hear from you; whether you have an enquiry, question or something else, we'd love to know!</b></div>
		
		
	</div>
	
	
	
	
	
</div>


<div id="wrappernewtitles">
	<div id="firsttitlecontact">Need some help
		<br>
		<img src="/images/greyline_gradient_200px.png" alt="grey line"></img>	
		<br>
	</div>
	<div id="secondtitlecontact">Location
		<br>
		<img src="/images/greyline_gradient_200px.png" alt="grey line"></img>	
		<br>
	</div>
	<div id="thirdtitlecontact">Get in touch
		<br>
		<img src="/images/greyline_gradient_200px.png" alt="grey line"></img>
		<br>
	</div>
</div>

<div id="wrappernewcontact">
	<div id="leftcontact"><b>If you have any questions or would like more information about the service we offer then please contact our super friendly team...</b>
	<br>
	<br>
	<img src="/images/ContactEmail.PNG" alt="Email image"><a href="mailto:message@csnotepad.co.uk">message@csnotepad.co.uk</a></img>
	<br>
	<br>
	<img src="/images/ContactPhone.PNG" alt="Phone image" align="middle">Sales 01273 741400</img>
	<br>
	<br>
	<strong>Our core office hours are: </strong><br>
	<br>
				Monday - Friday<br>
				8.30am - 6pm<br>
				Saturday<br>
				9am - 3pm
				<br>
						
						<br>
						Telephone answering extended hours are 24/7
						
		 
	</div>
	<div id="middlecontact"><b>Our Offices are at:</b>
	<br>
	Gemini House,136-140 Old Shoreham Road<br>
	Brighton.  BN3 7BD
	<div id="googleMap" style="width:395px;height:275px;"></div>

	</div>
	<div id="rightcontact">
			
		
		
		<div class="callbackboxnew" id="callbackboxbluenew">
		<div class="innerDivHome">
		<h2><!--Want to see if CSnotepad is right for your business?--></h2>
		<br>
		<h3><!--Drop your details in below and one of our expert team will be in touch!--></h3>
		<br>
		<form action="/request-call.php" method="post" id="contact-form">
			<?php if($_SERVER['QUERY_STRING'] == 'entername') {  ?>
			<div class="requestcallerror">Please enter your name</div>
			<?php } elseif($_SERVER['QUERY_STRING'] == 'enternumber') { ?>
			<div class="requestcallerror">Please enter a phone number</div>
			<?php } ?>
			<div class="clearfix">
				<label class="callbackboxlabel" for="callbackboxname"><!--Name--></label>
				<input id="callbackboxname" name="callbackboxname" type="text" placeholder="Name" class="validate[required]" size="20"/>
			</div>
<p>
			<div class="clearfix">
				<label class="callbackboxlabel" for="callbackboxnumber"><!--Number--></label>
				<input id="callbackboxnumber" name="callbackboxnumber" type="text" placeholder="Number" size="20"/>
			</div>
			<!--class="validate[required,custom[onlyNumber]]" no longer required - taken from Number above-->
<p>

			<div class="clearfix">
				<label class="callbackboxlabel" for="callbackboxcompany"><!--Email--></label>
				<input id="callbackboxcompany" name="callbackboxcompany" type="text" placeholder="Email" class="validate[required]" size="20"/>
			</div>

<br>
<br>
			<!--<div class="clearfix">
				<label class="callbackboxselect" for="callbackboxtime">Best Time to Call</label>
				<select class="callbackboxtime" name="callbackboxtime" width="20">
					<option value="asap" selected="selected">ASAP</option>
					<option value="morning">Morning</option>
					<option value="afternoon">Afternoon</option>
					<option value="evening">Evening</option>
				</select>
			</div>-->
			<!--<div><input name="submit" class="callme" id="callmegreen" type="submit" value="Call Me"/></div>-->
			<div style="margin-left: 56px"><button type="submit" name="submit" value="submit" class="homepageleftnew"><!--Call me--></button></div>
			
		</form>
		</div>
		<!--<span>01273 741400 </span>
		<img src="/images/telephone.png" id="telephone" alt="Virtual Receptionist Service"  />-->
	</div>
	
		
	</div>
	<!--<div id="secondleftcontact">Data Capture
	</div>
	<div id="secondrightcontact">
		<div id="corehourscontact">Core hours
		<br>
		<img src="/images/greyline_gradient_200px.png" alt="grey line"></img>
		<br>
		</div>
		
	</div>-->
	
					
				</div>
	
			
</div>
<br>
<br>
<!--<div id="wrapperreasons">-->
	<!--<div id="datacapturepricelistreasons">Data capture (pricelist)
	</div>-->
	<!--<div id="textrightreasons">
		<div id="subtitle">
	<div class="newsite_headline_welcome">Find out how we can help your business grow…</div>
<br>
<div class="newsite_text">Whether you are looking for a front line receptionist service, extra cover for when you or your team are busy, or you are looking for a company that can take orders over the phone, log support tickets and process payments on your behalf, we’ll make sure that you get the right service for you, built around your needs and tailored to your exact requirements.
<br>
<br>
Talk to one of our friendly team now on <b>01273 741400</b>

</div>
</div>
	</div>-->
<!--</div>-->
<!--<div id="contactmaincontent">
	<h2>
						Contact Us<br>
						<br>
                    </h2>
				<div id="contactusgrey">	
					<div id="mainSection2ColLeftContactLeft">
                      <p>Email</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p><a href="mailto:info@csnotepad.co.uk"><img src="/images/email_grey.jpg"></img></a></p>
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
                      <p>01273 741400<br />

</p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Fax</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>0330 300 3991</p>
                    </div>
				</div>	
                    <div class="clear"></div>
				
				<br>
                    <br>
					<strong>Or why not let us contact you? Just fill in the form below.</strong><br>
					<br>
					
					<h2>Contact form</h2>
					
					<br>
					
					<form method="post" action="/contact-process.php" id="contact-form">
					
					<div id="contactformgrey">	
					<div>
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
					</div>	
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
							<br>-->
						
						<!--<label for="submit">&nbsp;</label>
						<input type="submit" value="Submit" class="coolButton">
						<div align="center"><input name="submit" class="callme" id="callmegreen" type="submit" value="Submit"/></div>-->
						
						<!--<div style="left: 170px; position: relative; visibility: show;"><input name="submit" class="callme" id="callmegreen" type="submit" value="Submit"/></div>
					</form>
					</div>
					
					
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
						<em>
						<br>
						Telephone answering extended hours are 24/7
						</em>
					</p>
					
					<br>
			    <br>
					<br>
	</div>-->
<div id="datacapturepricelisttext" style="text-align: center">Want to see if CSnotepad is right for you?  Drop in your details and one of our expert team will be in touch!
	</div>
	<div id="datacapturepricelist" style="text-align: center">
		<a href="/support-contact" rel="fancybox-support" class="fancybox.iframe">
				<button type="submit" name="submit" value="submit" class="homepageleft">YES I would like to talk to someone about my business</button>
			</a>
			
	</div>
<div id="latestnewsnew">
	<div class="latestnewsarticle">
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
			ORDER BY wposts.post_date DESC limit 4
			";
			$result = mysql_query($querystr);

			while($row = mysql_fetch_assoc($result)){ ?>
			<div class="newsinsert">
			<p>	<strong><a href="/blog/<?=$row['post_name']?>"><?=htmlentities($row['post_title'])?></a></strong>
			<?=substr($row['post_content'],0,99,'...')?>
			
			<a href="/blog/<?=$row['post_name']?>">more</a>
			</p>
			</div>
			<?php }
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
					<li style="color: #455665">_</li>
				</ul>
				<ul>
					<li style="color: #ffffff">_</li>
				</ul>
			
		</div>
		<div class="column_footernewsecond">
			<div class="title_footernew">Opening Hours <span>*Telephone answering is available for customers 24/7</span></div>
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
				<!--<ul>
					<li>*Telephone answering is available for customers 24/7</span></li>
				</ul>-->
				
		</div>
		<div class="column_footernewthird">
			<div class="title_footernew">Address</div>
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
					<li><a href="https://www.linkedin.com/company/csnotepad" title="CSnotepad LinkedIn"><img src="/images/linkedin_30x30.png" alt="LinkedIn" align="middle">     </img></a><a href="https://www.facebook.com/CSnotepad-167447616636513/" title="CSnotepad facebook"><img src="/images/facebook_30x30.png" alt="Facebook"></img></a></li>
				</ul>
				
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



