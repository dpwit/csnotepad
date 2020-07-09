<!DOCTYPE html>

<html lang="en-GB">
	<head>
		<title>Sign up form | CSnotepad</title>

		<link rel="stylesheet" type="text/css" href="https://www.csnotepad.co.uk/html/css/support-contact.css">

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
			
			<div style="margin: 0 auto; width: 1323px;">
				<a name="recaptchaerror"></a>
				<div style="text-align: center;">
					<img src="/images/logo_dark.png" style="width: 660px; height: 330px; margin-top: -55px;" alt="CSnotepad Logo." title="CSnotepad Virtual Receptionists" />
				</div>
				<hr style="margin-top: -50px; width: 500px;">
				<br>
				<h1 class="fancy" style="border-bottom: none; color: #241c15; font-size: 24px; font-weight: 400; width: 1120px;">Our virtual address is a real UK street address, enabling you to use the address as your correspondence address with friends, relatives, banks and other organisations such as the DVLA and UKPA.</h1>
				<br>
				<hr style="width: 500px;">
				<div>
					<form action="/form-to-email-postal-address-fb" id="paymentForm" method="POST">
						<div style="display: inline-flex; margin: auto;">

							<!--Column 1-->
							<div id="container" style="display: inline-block; margin: 20px 10px 20px 30px; width: 25%;">
								
								<span><img src="/images/1.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Complete your personal details</h2>
								<div id="first" style="width: 345px; display: inline-block; margin-top:-10px;">
									<h3 class="fancy" style="color: #241c15; font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Your contact details</strong></h3>
									<h3 class="fancy" style="color: #241c15; font-size: 15px; padding: 0px;">Please enter your name and address details below.</h3>
								</div>
								<div id="first" style="width: 250px; display: inline-block;">
									<div class="form_row" style="color: #241c15;"> 
										<label for="accountName" style="color: #241c15; font-size: 15px"><asterix>*</asterix> Full name:</label>
										<input type="text" name="accountName" required placeholder=""
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
								
									<div class="form_row" style="color: #241c15;">
										<label for="email" style="color: #241c15; font-size: 15px"><asterix>*</asterix> Email address:</label>
										<input type="text" name="email" required placeholder=""
										    oninvalid="this.setCustomValidity('Email address required')"
										    oninput="this.setCustomValidity('')"  />
										<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
									</div>

								</div>
							</div>

							<!-- Column 2 Registered names -->
							<div style="display: inline-block; margin: 20px; width: 29%;">
							
								<div>
									<span><img src="/images/2.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Registered name/s</h2>
								</div>

								<div id="third" style="display: inline-block; margin-top: -20px;">
									<div class="form-row">
										<h3 class="fancy" style="color: #241c15; font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Your registered names</strong></h3>
										<h3 class="fancy" style="font-size: 14px; padding-left: 0px;">
											
											<font style="font-size: 14px; color: #241c15;">Please let us know what names you would like registered on your account (one name is included free per account).</font>
											<br>
											<br>
											
											<div class="form_row"> 
												<label for="nameOne" style="color: #241c15; font-size: 15px;">Registered name:</label>
												<input type="text" name="nameOne" required placeholder=""  />
											</div>
											
											<br>
											
											<div class="form_row">
												<h3 class="fancy" style="color: #241c15; font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Registering additional names (if required)</strong></h3>
												<font style="font-size: 14px; color: #241c15;">You can purchase additional mailing names at &pound;4 each per month.</font>
												<br>
												<br>
												<label for="addNames" style="color: #241c15;font-size: 15px;">Additional name 1 (if required):</label>
												<input type="text" name="addNames" />
											</div>
											<div class="form_row"> 
												<label for="nameTwo" style="color: #241c15;font-size: 15px;">Additional name 2 (if required):</label>
												<input type="text" name="nameTwo" />
											</div>
											<div class="form_row"> 
												<label for="nameThree" style="color: #241c15;font-size: 15px;">Additional name 3 (if required):</label>
												<input type="text" name="nameThree" />
											</div>
										</h3>

									</div>
								</div>				
							</div>
						
							<!-- Column 3 -->
							<div style="display: inline-block; margin: 20px; width: 34%;">
								<div>
									<span><img src="/images/3.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Select how you would like to receive your post</h2>

									<!-- <div class="tooltip"><font style="font-family: arial; font-size: 14px; color: #39F; font-weight: 900;">?</font>
  										<span class="tooltiptext"><h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 225px;"><font style="color: #39F; font-size: 16px;"><strong>Mail handling charges</strong></font>
  											<br>
  											<br>
									<div id="forwarding">
										<font style="font-size: 14px;">Postage and mail handling charges are billed on a PAYG basis, and are invoiced monthly in arrears on the 5th of each month.</font>
										<br>
										<br>
										<font style="color: #39F; font-size: 14px;"><strong>Mail forwarding</strong></font>
										<br>
										<font style="font-size: 14px;">If you would like your mail forwarded on to you, we will charge:<br>
										Letters &ndash; 75p + postage<br>
										Parcels/recorded delivery items &ndash; &pound;1.50 + postage
										<br>
										<br>
									</div>
									<div id="scan">
										<font style="color: #39F;"><strong>Scan to email</strong></font>
										<br>
										If you would like your mail scanned and emailed to you we will charge: <br>
										75p per scanned page.
										<br>
										<br>
										Scanned mail can be stored for future collection, forwarded to you in bulk or destroyed on request.
										<br>
										<br>
									</div>
									<div id="addressOnly">
										<font style="color: #39F;"><strong>Address only</strong></font>
										<br>
										If you don't believe that you will receive any mail then our address only option comes with no mail handling charges or postage costs. Any mail we do receive will be treated as unwanted and securely destroyed.
									</div>
								</h3></span>
								</div> -->

								</div>
								<div id="first" style="width: 250px; margin-top: -10px; display: inline-block;">
									
									<h3 class="fancy" style="color: #241c15; font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Mail forwarding options</strong></h3>
									
									<a name="typeOfService"></a>
									<div class="form_row">
										<label for="service" style="color: #241c15; font-size: 15px">Type of service required:</label>
										<select name="service" id="service" requird onchange="displayService()">
											<option value="">Please choose...</option>
											<option value="Mail forwarding">Mail forwarding - have your mail forwarded on to you</option>
											<option value="Scan to email">Scan to email - have your mail opened scanned and emailed to you</option>
											<option value="Address only">Address only - no mail will be received</option>
										</select>
									</div>
									
									<div style="margin-top: 20px; width: 450px;">
										<span><img src="/images/4.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F; display: inline-block;">Choose your preferred payment arrangement</h2>
									</div>

								<h3 class="fancy" style="color: #241c15; font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Payment</strong></h3>
								<h3 class="fancy" style="color: #241c15; font-size: 15px; color: #241c15; width: 450px; padding: 0px; margin-top: 0px;">
									How would you like to pay for your service... every 3 months, every 6 months or every 12 months?<br>
								</h3>

								<div  class="form_row" style="border: 1px solid #39F; padding: 10px; width: 450px;">
									<h3 class="fancy" style="font-size: 15px; color: #241c15; padding: 0px; margin-top: 0px;">
										<font color="#ff8834">•</font>&nbsp;3 months in advance &ndash; &pound;30.00 (equivalent to just &pound;10.00 a month)
										<br>
										<br>
										<font color="#ff8834">•</font>&nbsp;6 months in advance &ndash; &pound;49.98 (equivalent to just &pound;8.33 a month)
										<br>
										<br>
										<font color="#ff8834">•</font>&nbsp;12 months in advance &ndash; &pound;72.60 (equivalent to just &pound;6.05 a month)
										<br>
									</h3>
									
									<a name="paymentTerms"></a>
									<div class="form_row">
									<label for="term" style="color: #241c15; font-size: 15px">Payment terms:</label>
									<select name="term" id="term" required onchange="displayTerm()">
										<option value="">Please choose...</option>
										<option value="30.00">&pound;30.00 &ndash; <span value="3 months in advance">3 months in advance</span></option>
										<option value="49.98">&pound;49.98 &ndash; <span value="6 months in advance">6 months in advance</span></option>
										<option value="72.60">&pound;72.60 &ndash; <span value="12 months in advance">12 months in advance</span></option>
									</select>
									<br>
									<font style="color: #241c15; font-size: 11px; font-family: Arial, Helvetica, sans-serif;">All prices are subject to VAT at 20%</font>
									</div>
								</div>

								</div>
							</div>
						</div>
							<!-- Column 4 -->
							

								
						<div style="display: inline-flex; margin: auto;">
							<div style="display: inline-block; margin: 0 20px 20px 20px; width: 37%;">
								<div>
									<span><img src="/images/5.png" alt="" style="width: 30px; height: 30px; display: inline-block; vertical-align: middle; padding-right: 10px; padding-bottom: 3px;"></span><h2 class="fancy" style="font-size: 18px; color: #39F;display: inline-block;">Summary and payment</h2>
								</div>
								<div  class="form_row" style="border: 1px solid #39F; padding: 10px; width: 500px;">
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
										<strong style="font-size: 18px;">Security deposit:</strong> <span style="font-size: 18px;">We will hold a fully-refundable &pound;30 security deposit on account.</span>
									</h3>
								</div>
								<div class="form_row" style="color: #241c15; margin: 20px 0 20px 10px; text-align: center; width: 500px;">
									<label for="subtotal" style="color: #241c15; font-size: 18px;">Virtual Address:</label> &pound;<span id="termAmount"></span>
									<hr>
									<label for="securityDeposit" style="color: #241c15; font-size: 18px;">Security deposit:</label> &pound;<span id="secdep">30.00</span>
									<hr>
									<label for="subTotals" style="color: #241c15; font-size: 18px;">Subtotal:</label> &pound;<span id="subTotals"></span>
									<hr>
									<label for="vat" style="color: #241c15; font-size: 18px;">VAT:</label> &pound;<span id="vat"></span>
									<hr>
									<label for="termTotal" style="color: #241c15; font-size: 18px;">Total:</label> <textarea name="termTotal" id="termTotal" style="margin-left: auto; margin-right: auto; border: none; width: 58px; font-family: arial; font-size: 16px;" readonly=""></textarea>
									<hr>

									<div>
										<label for="additionalInfo" style="color: #241c15; font-size: 18px;">Additional information/notes:</label>
										<textarea style="width: 500px;" wrap="wrap" cols="40" rows="" name="additionalInfo" id="additionalInfo" value="<?=$_SESSION['contactValues']['additionalInfo']?>">
										</textarea>
									</div>
								</div>
							</div>
						
							<div style="display: inline-block; margin: 50px 20px 20px 40px; width: 37%;">
								<?php include 'includes/creditcard.php';?>

								<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0; width: 300px;">
								</div>
								<?php if(isset($_GET['CaptchaFail'])){ ?>
									<div style="color: red; font-family: arial; font-size: 12px; width: 200px;">
										<strong>Please check the reCAPTCHA box and try again</strong>
									</div>
								<?php } ?>
								
								<div class="form-row" style="margin-top: -80px; margin-left: 80px; width: 450px;">
									<button type="submit" name="submit" value="submit" class="bt-support" onclick="Worldpay.submitTemplateForm()">Click to confirm your order</button>
								</div>
								<h3 style="color: #241c15; font-size: 12px; font-family: arial; margin-top: 60px;">By clicking to confirm your order, you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) as per our <a href="/privacypolicy" target="_blank">Privacy Policy</a> and you agree to our <a href="/terms-and-conditions.php" target="_blank">Terms and Conditions</a>.</h3>
								<h3 class="fancy" style="font-size: 11px; padding-left: 0px; width: 550px;">
									<font style="color: #39F; font-size: 11px;"><strong>Mail handling charges</strong></font>
									<br>
									<br>
									<div id="forwarding">
										<font style="font-size: 11px;">The following charges will apply depending on what you would like us to do with your post...</font>
										<br>
										<br>
										<font style="color: #39F; font-size: 11px;"><strong>Handling charges</strong></font>
										<br>
										<font style="font-size: 11px;">We apply a small charge for each item of mail that we receive and process for you; to sign-for (if necessary), identify, sort, insure whilst on the premises and prep for forwarding.
										</font>
										<br>
										<br>
										<font style="color: #39F; font-size: 11px;"><strong>Mail forwarding</strong></font>
										<br>
										<font style="font-size: 11px;">If you would like your mail forwarded on to you, we will charge:<br>
										Letters &ndash; 75p + postage<br>
										Parcels/recorded delivery items &ndash; &pound;1.50 + postage
										<br>
										Note, on months where post is forwarded, the total minimum charge is £3.
										</font>
										<br>
										<br>
									</div>
									<div id="scan">
										<font style="color: #39F;"><strong>Scan to email</strong></font>
										<br>
										If you would like your mail scanned and emailed to you we will charge: <br>
										75p per scanned page.
										<br>
										<br>
										Scanned mail can be stored for future collection, forwarded to you in bulk or destroyed on request.
										<br>
										<br>
										Note, on months where post is forwarded, the total minimum charge is £3.
										<br>
										<br>
									</div>
									<div id="addressOnly">
										<font style="color: #39F;"><strong>Address only</strong></font>
										<br>
										If you don't believe that you will receive any mail then our address only option comes with no mail handling charges or postage costs. Any mail we do receive will be treated as unwanted and securely destroyed.
									</div>
								</h3>
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