<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="/html/css/support-contact.css">
		
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

	</head>
	<body>
		<?php 

if($_SESSION['user-feedback']['success']) : ?>
			<!-- Google Code for Pricelist Conversion Page --> <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1055112536;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "5262CN-YjWkQ2PqO9wM"; var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript"  
src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt=""  
src="//www.googleadservices.com/pagead/conversion/1055112536/?label=5262CN-YjWkQ2PqO9wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
		
			
		<?php else : ?>
			
			<div class="box-fancy">
				<form id="support-form" action="/form-best-price" method="POST">
					<!--Page 1-->
					<div id="container" style="width: 550px;">
						<h1 class="fancy" style="font-size: 34px">Best Price Guarantee</h1>

						
							
						
						 
						<div id="first" style="width: 250px; display: inline-block; margin-top: 10px;">
							<div class="form_row"> 
								<label for="accountName" style="font-size: 15px"><asterix>*</asterix> Name:</label>
								<input type="text" name="accountName" required placeholder=""
								    oninvalid="this.setCustomValidity('Full name required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="error"><?php echo $accountNameErr;?></span>
							</div>
						
							<div class="form_row">
								<label for="email" style="font-size: 15px"><asterix>*</asterix> Email address:</label>
								<input type="text" name="email" required placeholder=""
								    oninvalid="this.setCustomValidity('Email address required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
							</div>
							
							<div class="form_row">
								<label for="telephone" style="font-size: 15px"><asterix>*</asterix> Telephone number:</label>
								<input type="text" name="telephone" required placeholder=""
								    oninvalid="this.setCustomValidity('Phone number required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
							</div>

							<div class="form_row">
								&nbsp;
							</div>

							<div class="form_row">
								&nbsp;
							</div>

							<div class="form_row">
								&nbsp;
							</div>

							<div class="form_row">
								&nbsp;
							</div>

							<div class="form_row">
								&nbsp;
							</div>

							<!-- <div class="form_row"> 
								<label for="acPcode" style="font-size: 15px;"><asterix>*</asterix> Postcode:</label>
								<input type="text" name="acPcode" required placeholder=""
								    oninvalid="this.setCustomValidity('Postcode required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acPcode']; ?></span>
							</div> -->

						</div>
						<div id="second" style="width: 295px; display: inline-block;">
							
								<img style="height: 150px; display: inline-block; margin-left: 50px; margin-top: 10px;" src="/images/SSL-Certificate.jpg" alt="SSL Certificate">
								<br>
								<br>
								<h3 class="fancy" style="font-size: 12px; color: #555; margin-left: -10px; margin-top: -10px;">
								<font color="#ff8834">•</font>&nbsp;Fully-licensed, insured and regulated postal 
								<br>
								&nbsp; address provider<br>
								<font color="#ff8834">•</font>&nbsp;Trusted by hundreds of customers<br>
								<font color="#ff8834">•</font>&nbsp;Established in 2007<br>
								<font color="#ff8834">•</font>&nbsp;Based in Brighton, East Sussex (UK)<br>
								</h3>
						</div>
					</div>
					<h3 class="fancy" style="font-size: 15px; color: #555; width: 525px; padding: 0px; margin-top: 0px;">
						Please provide us with details of the company you would like us to price-match<br>
					</h3>

						<div class="form_row"> 
							<label for="company" style="font-size: 15px;"><asterix>*</asterix> Company name</label>
							<input type="text" name="company" required placeholder=""
							    oninvalid="this.setCustomValidity('Company name required')"
							    oninput="this.setCustomValidity('')"  />
							<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['company']; ?></span>
						</div>

						<div class="form_row"> 
							<label for="url" style="font-size: 15px;"><asterix>*</asterix> Website URL / link to prices</label>
							<input type="text" name="url" required placeholder=""
							    oninvalid="this.setCustomValidity('URL required')"
							    oninput="this.setCustomValidity('')"  />
							<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['url']; ?></span>
						</div>

						<div class="form_row"> 
							<label for="addInfo" style="font-size: 15px;"><asterix>*</asterix> Any additional information</label>
							<input type="text" name="addInfo" required placeholder=""
							    oninvalid="this.setCustomValidity('URL required')"
							    oninput="this.setCustomValidity('')"  />
							<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['addInfo']; ?></span>
						</div>


					<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 290px; margin-top: -120px; margin-bottom: 0px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row" style="margin-top: -10px; margin-left: 65px; width: 450px;">
						<button type="submit" name="submit" value="submit" class="bt-support">Price-match request</button>
					</div>

					
				</form>

				<h3 class="fancy" style="font-size: 11px; margin-top: 55px; padding-left: 0px; width: 525px;">By clicking to confirm your price-match request you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) as per our <a href="/privacypolicy">Privacy Policy</a>.</h3>
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>