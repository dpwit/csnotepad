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
			<a href="FAQ" title="FAQ">FAQ</a>
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
      <li><!--<a href="/our-services/order-taking" title="Order fulfilment">-->East to Install     </a></li>
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
			
			<div id="mainSection">
				
				<div id="mainSection2ColLeft">
				<br>
				<br>
				<div id="breadcrumb"><h3><b>You are here: </b>
<a class='breadcrumb' title="Home" href="home.php">Home</a>  &gt; <a class="breadcrumb" title="Contact" href="contact.php">Contact</a></h3></div>
<div id="breadcrumb-search-fields" style="display:none;">
	<input type='hidden' name='from' value='/contact'/>
</div>
<br>
					<h2>
						Contact Us<br>
						<br>
                    </h2>
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
					
					<form method="post" action="contact-process.php" id="contact-form">
					
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
			<div class="underContent">
				<div class="imagesFotter">
					<a href="http://www.linkedin.com/company/csnotepad/products?trk=tabs_biz_product" target="_blank" title="Linked in"><img src="/images/linkedin.png" style="width: 70px;"></a>
					<img src="/images/fsb.png" >
					<img src="/images/chamber.png">
					<img src="/images/hba.png" class="hba">
				</div>

				<div class="semiFooter">
					<a href="/our-services">
						<img src="images/signup3.jpg" alt="Signup" class="cards">
					</a>
					<a href="/support-contact.php" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">Want help now</button>
					</a>
					<span class="footerCallMore">Call now to find out more <strong>01273 741400</strong>.</span>
					<span class="companyNo">CSnotepad is a trading division of Call Solution Ltd Registered in England 6107188.</span>
				</div>
			</div>
			<?php // } ?>
		</div>

		<div id="contentBottom">
	
		</div>
		
		
	</div>