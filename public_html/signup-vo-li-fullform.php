<!DOCTYPE HTML>
<html>
	<head>
		<title></title>

		<link rel="stylesheet" type="text/css" href="https://www.csnotepad.co.uk/html/css/support-contact.css">
		
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
				<form id="support-form" action="/form-to-email-vo-li" method="POST">
					<!--Page 1-->
					<div id="container" style="width: 550px;">
						<h1 class="fancy" style="font-size: 34px">Set up your service</h1>
						<h2 class="fancy" style="text-align: center; margin-top: 10px; margin-bottom: 5px;">Get Started in 4 Easy Steps</h2>
						<span><img src="/images/1.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; display: inline-block;">Complete your personal details</h2>
						<div id="first" style="width: 550px; display: inline-block; margin-top:-10px;">
							<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Your name and address</strong></h3>
							<h3 class="fancy" style="font-size: 15px; padding: 0px;">Please enter your name and address details below.</h3>
						</div>
						<div id="first" style="width: 250px; display: inline-block;">
							<div class="form_row"> 
								<label for="accountName" style="font-size: 15px"><asterix>*</asterix> Full name:</label>
								<input type="text" name="accountName" required placeholder=""
								    oninvalid="this.setCustomValidity('Full name required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="error"><?php echo $accountNameErr;?></span>
							</div>

							<div class="form_row"> 
								<label for="acAddr" style="font-size: 15px;"><asterix>*</asterix> Address:</label>
								<input type="text" name="acAddr" required placeholder=""
								    oninvalid="this.setCustomValidity('Full address required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acAddr']; ?></span>
							</div>

							<div class="form_row"> 
								<label for="country" style="font-size: 15px;"><asterix>*</asterix> Country of residence:</label>
								<input type="text" name="country" required placeholder=""
								    oninvalid="this.setCustomValidity('Country required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['country']; ?></span>
							</div>
							<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Your contact details</strong></h3>
							<div class="form_row">
								<label for="telephone" style="font-size: 15px"><asterix>*</asterix> Telephone number:</label>
								<input type="text" name="telephone" required placeholder=""
								    oninvalid="this.setCustomValidity('Phone number required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
							</div>
						
							<div class="form_row">
								<label for="email" style="font-size: 15px"><asterix>*</asterix> Email address:</label>
								<input type="text" name="email" required placeholder=""
								    oninvalid="this.setCustomValidity('Email address required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
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
								<h3 class="fancy" style="font-size: 12px; color: #555; margin-left: -10px; margin-bottom: 10px;">
									<font color="#ff8834">•</font>&nbsp;Fully-licensed, insured and regulated postal 
									<br>
									&nbsp; address provider
									<br>
									<br>
									<font color="#ff8834">•</font>&nbsp;Trusted by hundreds of customers
									<br>
									<br>
									<font color="#ff8834">•</font>&nbsp;Established in 2007
									<br>
									<br>
									<font color="#ff8834">•</font>&nbsp;Based in Brighton, East Sussex (UK)
								</h3>
								<br>
								<img style="height: 100px; display: inline-block;" src="/images/SSL-Certificate.jpg" alt="SSL Certificate">
								<img style="height: 100px; display: inline-block; margin-left: 10px;" src="/images/ico-logo.jpg" alt="ICO image">
						</div>
						<div style="text-align: center; margin-top: 30px;">
							<a href="#pagetwo" class="btn-next" style="color: white; text-decoration: none;" role="button">Next</a>
						</div>
						<a name="pagetwo">
							<div style="margin-top: 50px;">
								<span><img src="/images/2.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; display: inline-block;">Company details.</h2>
							</div>
						<div id="third" style="width: 250px; display: inline-block;">
							
							<!--<div class="form_row"> 
								<label for="companyName" style="font-size: 15px"><asterix>*</asterix> Company name:</label>
								<input type="text" name="companyName" required placeholder=""
								    oninvalid="this.setCustomValidity('Company name required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="error"><?php echo $companyNameErr;?></span>
							</div>-->

							<div class="form_row"> 
								<label for="companyWebsite" style="font-size: 15px;">Website (if available):</label>
								<input type="text" name="companyWebsite" />
							</div>

							<div class="form-row">
								<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Your registered names</strong></h3>
								<h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 525px;">
									
									<font style="font-size: 14px;">Please let us know what names you would like registered on your account
									<br>
									(up to 3 names are included free per account).
									<br>
									<br>
									
									<div class="form_row"> 
										<label for="nameOne" style="font-size: 15px;">Name 1: * company name</label>
										<input type="text" name="nameOne" required placeholder=""  />
									</div>
									<div class="form_row"> 
										<label for="nameTwo" style="font-size: 15px;">Name 2: * additional name</label>
										<input type="text" name="nameTwo" />
									</div>
									<div class="form_row"> 
										<label for="nameThree" style="font-size: 15px;">Name 3: * additional name</label>
										<input type="text" name="nameThree" />
									</div>
									
									<br>
									
									<div class="form_row">
										<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Registering additional names (if required)</strong></h3>
										You can purchase additional mailing names at &pound;4 each per month.
										<br>
										<br>
										<label for="addNames" style="font-size: 15px;">Additional names (if required):</label>
										<input type="text" name="addNames" />
									</div>
								</h3>

							</div>

						</div>
						<div style="text-align: center; margin-top: 30px;">
							<a href="#pagethree" class="btn-next" style="color: white; text-decoration: none;" role="button">Next</a>
						</div>
						<a name="pagethree">
							<div style="margin-top: 50px;">
								<span><img src="/images/3.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; display: inline-block;">Select the service you require.</h2>
							</div>
						<div id="forth" style="width: 250px; display: inline-block;">
							
							<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Service</strong></h3>
							
							<div class="form_row">
								<label for="service" style="font-size: 15px">Type of service required:</label>
								<select id="service" name="service">
									<option value="Choose">Please choose...</option>
									<option value="Forwarding">Mail forwarding</option>
									<option value="Scan">Scan to email</option>
									<option value="Stored">Stored for collection</option>
								</select>
							</div>

							<!-- <div class="form_row"> 
								<label for="acPcode" style="font-size: 15px;"><asterix>*</asterix> Postcode:</label>
								<input type="text" name="acPcode" required placeholder=""
								    oninvalid="this.setCustomValidity('Postcode required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acPcode']; ?></span>
							</div> -->

							<div class="form-row">
								<h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 525px;">
									<div id="forward">
										<p style="display: inline-block; width: 350px;">
											<font style="font-size: 14px;">Is the address to be used as your registered office address with Companies House? (no additional charge)</font>
										</p>
										<input type="radio" name="registered" value="Yes" style="display: inline-block; width: 20px;">Check if yes
										<br>
										<br>
										<font style="color: #39F; font-size: 14px;"><strong>Notes (optional)</strong></font>
										 <!-- <input type="text" rows="4" name="notes" style="width: 490px;">-->
										<textarea rows="4" name="notes" style="border: 1px solid black; border-radius: 7px;margin-top: 5px; width: 490px;"></textarea>
										<br>
										<br>
										<font style="font-size: 14px;">Postage and mail handling charges are billed on a PAYG basis, and are invoiced monthly in arrears on the 5th of each month.</font>
									</div>
									
								</h3>

							</div>

						</div>
						<div style="text-align: center; margin-top: 50px;">
							<a href="#pagefour" class="btn-next" style="color: white; text-decoration: none;" role="button">Next</a>
						</div>
						<a name="pagefour">
						<div style="margin-top: 50px;">
							<span><img src="/images/4.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; display: inline-block;">Choose your preferred payment arrangement.</h2>
						</div>
					</div>
					
					
					<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Payment</strong></h3>
					<h3 class="fancy" style="font-size: 15px; color: #555; width: 525px; padding: 0px; margin-top: 0px;">
						How would you like to pay for your service, monthly or annually?<br>
						<!--<font color="#ff8834">•</font>&nbsp;3 months in advance &ndash; &pound;36 (equivalent to just &pound;12 a month)<br>
					 <font color="#ff8834">•</font>&nbsp;6 months in advance &ndash; &pound;58.08 (equivalent to just &pound;9.68 a month)<br>
					 <font color="#ff8834">•</font>&nbsp;12 months in advance &ndash; &pound;88.80 (equivalent to just &pound;7.40 a month)<br> -->
					 
					</h3>

					<div class="form_row">
					<label for="term" style="font-size: 15px">Payment terms:</label>
					<select name="term">
						<option value="Monthly">Monthly &ndash; &pound;24.99</option>
						<option value="Annually">Annually &ndash; &pound;210 (equivalent to just &pound;17.50 a month)</option>
					</select>
					<font style="font-size: 11px; font-family: Arial, Helvetica, sans-serif;">All prices are subject to VAT at 20%</font>
					</div>

					<br>

					<div class="form_row">
					<label for="method" style="font-size: 15px">Preferred payment method:</label>
					<select name="method">
						<option value="CreditCard">Credit card</option>
						<option value="DebitCard">Debit card</option>
						<option value="DirectDebit">Direct debit</option>
					</select>

					</div>
					
					<br>
					<!-- <div class="form-row"> -->
						<!--<button class="bt-support" style="float: left;"><a href="#page2" style="float: left; text-decoration: none; color: #ffffff">Next...</a></button>-->
						<!-- <a href="#page2" style="float: left; text-decoration: none; color: #ffffff; cursor: pointer; background-color: #f57922; font-family: Arial, Helvetica, sans-serif; font-size: 18px; padding: 10px 30px;  background: -webkit-gradient(
							linear, left top, left bottom, 
							from(#ff8731),
							to(#df5d00)); border-radius: 4px; -moz-border-radius: 4px;
						-webkit-border-radius: 4px;
						border-radius: 4px;
						border: 1px solid #949494;
						-moz-box-shadow:
							0px 1px 3px rgba(000,000,000,0.3),
							inset 0px 1px 2px rgba(255,255,255,1);
						-webkit-box-shadow:
							0px 1px 3px rgba(000,000,000,0.3),
							inset 0px 1px 2px rgba(255,255,255,1);
						box-shadow:
							0px 1px 3px rgba(000,000,000,0.3),
							inset 0px 1px 2px rgba(255,255,255,1);
						text-shadow:
							0px 1px 0px rgba(92,92,92,1);">Next...
						</a>
					</div> -->
					
					<!--Page 2-->

					<!--<h3 class="fancy" style="font-size: 16px; width: 525px; padding: 0px;">
						What would you like us to do with your post... forward it on to you at a different address, store it for collection or open, scan it and email it to you?
					</h3>
					<br>-->
					<!-- Hide for now <div style="text-align: center; margin-top: 30px; width: 550px;">
							<a href="#pagefour" class="btn-next" style="color: white; text-decoration: none;">Next</a>
						</div>

					<a name="pagefour"> -->
						<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row" style="margin-top: -80px; margin-left: 80px; width: 450px;">
						<button type="submit" name="submit" value="submit" class="bt-support">Click to confirm your order</button>
					</div>
					<br>
					<br>
					<h1 class="fancy" style="font-size: 34px; margin-top: 30px;">Important information</h1>

					<div class="form-row">
						<h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 525px; margin-top: -18px;">
							
							<!--<font style="color: #39F; font-size: 14px;"><strong>Security Deposit</strong></font>-->
							<br>
							<font style="font-size: 14px;">
								As part of your postal address service we will hold a fully-refundable &pound;30 security deposit on account.  When you stop your service with us, your security 
								deposit will be automatically refunded back to you.
								<br>
								<br>
								By clicking to confirm your order, you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) as per our <a href="/privacypolicy" target="_blank">Privacy Policy</a> and you agree to our <a href="/terms-and-conditions.php" target="_blank">Terms and Conditions</a>.
								<br>
								<br>
							</font>
						</h3>

					</div>
					
				</form>
				
				<div class="fancy" style="margin-top: -10px; padding-left: 0px; width: 525px;"><img src="/images/DD_logo_small.png" style="float: left; width: 33.33%" alt="Direct Debit logo"><img src="/images/Worldpay.png" style="float: right; width: 33.33%" alt="Worldpay logo"></div>
				<h3 class="fancy" style="font-size: 11px; margin-top: 85px; padding-left: 0px; width: 525px;">By clicking submit you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) for the purposes of contacting you via email and/or telephone regarding the services it provides.</h3>
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		<!--<script>
			document.getElementById('service').addEventListener('change', function () {
		    var style = this.value == 'Collection' ? 'block' : 'none';
		    document.getElementById('collection').style.display = style;
		    
		});

		document.getElementById('service').addEventListener('change', function () {
		    var style = this.value == 'Forwarding' ? 'block' : 'none';
		    document.getElementById('forward').style.display = style;
		    
		});

		document.getElementById('service').addEventListener('change', function () {
		    var style = this.value == 'Scan' ? 'block' : 'none';
		    document.getElementById('scan').style.display = style;
		    
		});
		</script>-->

	</body>
</html>