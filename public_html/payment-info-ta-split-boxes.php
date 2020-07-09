<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en-GB">
	<head>
		<title>Payment information | CSnotepad</title>

		<link rel="stylesheet" type="text/css" href="https://www.csnotepad.co.uk/html/css/support-contact.css">
		<link rel="stylesheet" href="/html/css/breadcrumbs.css">

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NVWB2MG');</script>
		<!-- End Google Tag Manager -->
		
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
		<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		      
	</head>
	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVWB2MG"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

		<?php 

		if($_SESSION['user-feedback']['success']) : ?>
		
		<?php else : ?>
			
			<div style="margin: 0 auto; width: 1323px;">
				<a name="recaptchaerror"></a>
				<div style="text-align: center;">
					<img src="/images/logo_dark.png" style="width: 594px; height: 297px; margin-top: -45px;" alt="CSnotepad Logo." title="CSnotepad Virtual Receptionists" />
				</div>
				<div style="margin-top: -30px; height: 75px; text-align: center;">
				<div style="display: inline-flex;">
					<a href="javascript:history.back()" style="color: #202020; font-family: Arial; font-size: 18px; text-decoration: none;"><< Back</a>
				</div>
				<div style="display: inline-flex;">
					<ul class="breadcrumb">
						<li><a href="javascript:history.back()"><span class="numberCircle">1</span> Call plan</a></li>
						<li><a href="javascript:history.back()"><span class="numberCircle">2</span> Getting started</a></li>
						<li><a href="javascript:history.back()"><span class="numberCircle">3</span> Setup questions</a></li>
						<li><a href="javascript:history.back()"><span class="numberCircle">4</span> Terms & Conditions</a></li>
						<li><a href="/payment-info-ta"><span class="numberCircle">5</span> Payment info</a></li>
					</ul>
				</div>
			</div>
				<hr style="width: 500px;">
				<br>
				<h1 class="fancy" style="border-bottom: none; color: #505050; font-size: 34px; font-weight: 700; padding-bottom: 0; width: 885px;">Payment Information</h1>
				<br>
				<hr style="width: 500px;">

				<div class="bg-call-plan-box" style="margin: 50px auto; padding: 20px 135px; width: 72%;">
					<p>Please complete the setup of your service by providing us with valid payment details.</p>
					<p>In order to complete the setup of your service as quickly as possible we ask where possible that your initial payment be made via debit or credit card. After which future payments can be made via debit/credit card or direct debit.</p>
					<p><strong><u>Important:</u></strong> Subscriptions are payable monthly or annually in advance, additional calls in excess of you plan are charged monthly in arrears.</p>
					<p>Should you have any questions then please do not hesitate to contact us and thank you for choosing CSnotepad.</p>
				</div>

				<div>
					<form action="/form-to-email-mailforwarding" id="paymentForm" method="POST">
						<div style="display: inline-flex; margin: auto;">

							<!--Column 1-->
							<div id="container" style="display: inline-block; margin: 20px 10px 20px 20px; width: 26%;">
								
								<span><img src="/images/1.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Complete your billing details</h2>
								<div class="form_row bg-call-plan-box" style="padding: 10px;">
									<div id="first" style="width: 345px; display: inline-block;">
										<h3 class="fancy" style="color: #241c15; font-weight: 600; font-size: 18px; padding: 0px;"><strong>Your contact details</strong></h3>
										<h3 class="fancy" style="color: #241c15; font-size: 15px; padding-left: 0px;">Please enter your name and address details below.</h3>
									</div>
									<div id="first" style="width: 250px; display: inline-block;">
										<div class="form_row" style="color: #241c15;"> 
											<label for="accountName" style="color: #241c15; font-size: 15px"><asterix>*</asterix> Full name:</label>
											<input type="text" name="accountName" required
											    oninvalid="this.setCustomValidity('Full name required')"
											    oninput="this.setCustomValidity('')"  />
											<span class="error"><?php echo $accountNameErr;?></span>
										</div>

										<div class="form_row" style="color: #241c15;"> 
											<label for="acAddr" style="color: #241c15; font-size: 15px;"><asterix>*</asterix> Address:</label>
											<input type="text" name="acAddr" required placeholder=""
											    oninvalid="this.setCustomValidity('Full address required')"
											    oninput="this.setCustomValidity('')"  />
											<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acAddr']; ?></span>
										</div>

										<div class="form_row" style="color: #241c15;"> 
											<label for="acPcode" style="color: #241c15; font-size: 15px;"><asterix>*</asterix> Postcode:</label>
											<input type="text" name="acPcode" required placeholder=""
											    oninvalid="this.setCustomValidity('Postcode required')"
											    oninput="this.setCustomValidity('')"  />
											<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acPcode']; ?></span>
										</div>

										<div class="form_row" style="color: #241c15;"> 
											<label for="country" style="color: #241c15; font-size: 15px;"><asterix>*</asterix> Country of residence:</label>
											<input type="text" name="country" required placeholder=""
											    oninvalid="this.setCustomValidity('Country required')"
											    oninput="this.setCustomValidity('')"  />
											<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['country']; ?></span>
										</div>
										
										<div class="form_row" style="color: #241c15;">
											<label for="telephone" style="color: #241c15; font-size: 15px"><asterix>*</asterix> Telephone number:</label>
											<input type="text" name="telephone" required placeholder=""
											    oninvalid="this.setCustomValidity('Phone number required')"
											    oninput="this.setCustomValidity('')"  />
											<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
										</div>
									
										<div class="form_row" style="color: #241c15; margin-bottom: 20px;">
											<label for="email" style="color: #241c15; font-size: 15px"><asterix>*</asterix> Email address:</label>
											<input type="text" id='email' name="email" required
											    oninvalid="this.setCustomValidity('Email address required')"
											    oninput="this.setCustomValidity('')"  />
											<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
										</div>

									</div>
								</div>
							</div>

							<!-- Column 2 Payment information -->
							<div style="display: inline-block; margin: 20px; width: 33%;">
							
								<div>
									<span><img src="/images/2.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Choose your preferred payment arrangement</h2>
								</div>

								<div id="third" style="display: inline-block;">

									<div class="form_row bg-call-plan-box" style="padding: 10px;">
										<h3 class="fancy" style="color: #241c15; font-weight: 600px; font-size: 18px; padding: 0px;"><strong>Payment</strong></h3>
										<h3 class="fancy" style="font-size: 14px; padding-left: 0px;">
											
											<font style="font-size: 14px; color: #241c15;">How would you like to pay for your service?</font>
											<br>
											<br>
											<div  class="form_row" style="border: 1px solid #39F; padding: 10px 0 10px 10px; width: 407px;">
												<h3 class="fancy" style="font-size: 15px; color: #241c15; padding: 0px; margin-top: 0px;">
													<font color="#ff8834">•</font>&nbsp;<strong style="font-size: 18px;">Pay monthly &ndash; &pound;39.00 a month</strong>
													<br>
													<br>
													<font color="#ff8834">•</font>&nbsp;<strong style="font-size: 18px;">Pay yearly &ndash; &pound;390 a year</strong> (&pound;78 saving)
													<br>
													<br>
													Change plan - link to create
													<br>
												</h3>
									
												<a name="paymentTerms"></a>
												<div class="form_row">
													<label for="term" style="color: #241c15; font-size: 15px">Payment terms:</label>
													<select name="term" id="term" required onchange="displayTerm()">
														<option value="">Please choose...</option>
														<option value="39.00">&pound;39.00 &ndash; <span value="a month">£39.00 a month</span></option>
														<option value="390.00">&pound;390 &ndash; <span value="a year">£390 a year</span></option>
													</select>
													<br>
													<font style="color: #241c15; font-size: 11px; font-family: Arial, Helvetica, sans-serif;">All prices are subject to VAT at 20%</font>
												</div>
											</div>

										</h3>
										<div>
											<?php include 'includes/creditcard-ta.php';?>

											<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin: 10px 0 -20px 0; transform:scale(0.65);transform-origin:0 0;">
											</div>
											<?php if(isset($_GET['CaptchaFail'])){ ?>
												<div style="color: red; font-family: arial; font-size: 12px; width: 200px;">
													<strong>Please check the reCAPTCHA box and try again</strong>
												</div>
											<?php } ?>
											
											<div class="form-row" style="margin: -82px 0 0 0; width: 420px;">
												<button type="submit" name="submit" value="submit" class="bt-support" onclick="Worldpay.submitTemplateForm()">Confirm your order</button>
											</div>
											<h3 style="color: #241c15; font-size: 12px; font-family: arial; margin-top: 60px; width: 415px;">
												By clicking to confirm your order, you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) as per our <a href="/privacypolicy" target="_blank">Privacy Policy</a> and you agree to our <a href="/terms-and-conditions.php" target="_blank">Terms and Conditions</a>.
											</h3>
										</div>
									</div>
								</div>				
							</div>
						
							<!-- Column 3 -->
							<div style="display: inline-block; margin: 20px 0 20px 20px; width: 33%;">
								<div>
									<span><img src="/images/3.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Summary and payment</h2>

								</div>
								<div class="form_row bg-call-plan-box" style="padding: 10px;">
									<div  class="form_row" style="border: 1px solid #39F; padding: 10px; width: 385px;">
										<h3 class="fancy" style="color: #241c15; font-size: 14px; padding: 0px;">
											<strong style="color: #241c15; font-size: 18px;">Order summary</strong>
											<br>
											<br>
											<strong style="font-size: 18px;">Type of service required:</strong> <span for="service" id="serviceType" name="service" style="font-size: 18px;"></span> <a href="#typeOfService" style="text-decoration: none;">edit</a>
											<br>
											<br>
											<strong style="font-size: 18px;">Payment terms:</strong> &pound;<span id="termType" style="font-size: 18px;"></span> <a href="#paymentTerms" style="text-decoration: none;">edit</a>
											<br>
											<br>
										</h3>
									</div>
								</div>
								<div class="form_row bg-call-plan-box" style="margin-top: 20px; padding: 10px;">
									<div class="form_row" style="color: #241c15; margin: 20px 0 20px 10px; text-align: center; width: 385px;">
										
										<label for="subTotals" style="color: #241c15; font-size: 18px;">Subtotal:</label> &pound;<span id="subTotals"></span>
										<hr>
										<label for="vat" style="color: #241c15; font-size: 18px;">VAT:</label> &pound;<span id="vat"></span>
										<hr>
										<label for="termTotal" style="color: #241c15; font-size: 18px;">Total:</label> <textarea name="termTotal" id="termTotal" style="background-color: #EEF1F6; margin-left: auto; margin-right: auto; border: none; width: 58px; font-family: arial; font-size: 16px;" readonly=""></textarea>
										<hr>

										<div>
											<label for="additionalInfo" style="color: #241c15; font-size: 18px;">Additional information/notes:</label>
											<textarea style="width: 385px;" wrap="wrap" cols="40" rows="" name="additionalInfo" id="additionalInfo" value="<?=$_SESSION['contactValues']['additionalInfo']?>">
											</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</form>
				</div>
				
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		<script>
		function displayService() {
		   
		    var getserv = document.getElementById('service').value;
		    document.getElementById("serviceType").innerHTML = getserv;
		}
		</script>
		<script>
		function displayTerm() {

		    var getterm = document.getElementById('term').value;
		    document.getElementById("termType").innerHTML = getterm;
		    document.getElementById("termAmount").innerHTML = getterm;

		    var Deposit = document.getElementById('secdep').value;

			var subTotal = (Number(getterm) + 30.00).toFixed(2);
			document.getElementById("subTotals").innerHTML = subTotal;

		    var vat = ((Number(getterm) + 30.00) * 0.2).toFixed(2);
		    document.getElementById("vat").innerHTML = vat;

		    var total = (Number(getterm) + Number(vat) + 30.00).toFixed(2);
		    document.getElementById("termTotal").innerHTML = '£' + total;

		}
		</script>
		
	</body> 
</html>