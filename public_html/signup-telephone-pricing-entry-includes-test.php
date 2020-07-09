<?php
// Start the session
session_start();
?>
<!DOCTYPE HTML>

<html lang="en-GB">
	<head>
		<title>Signup Telephone Answering Pricing Entry</title>
		<link rel="stylesheet" href="/html/css/support-contact.css">
		<link rel="stylesheet" href="/html/css/breadcrumbs.css">

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NVWB2MG');</script>
		<!-- End Google Tag Manager -->
		
		<script src="http://elite-s001.com/js/24663.js" ></script>
		<noscript>
			<img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" />
		</noscript>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
	</head>

	<style>
		.free-extras {
		    display: none;
		}
		
    </style>

	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVWB2MG"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

		<?php if($_SESSION['user-feedback']['success']) : ?>
			<?php 
			session_start();

			$_SESSION['email'] = $email;
			?>
		
			<img src="/images/email-icon.jpg" alt="" class="email-icon">
			<p class="validation-success"><span class="email">Your information is on its way...</span><br/>We have just emailed you some more information on the services available.</p>
			<p class="validation-success notes">Please let us know if you have any questions that you cannot find the answer to.<br/> We can be contacted between <br/> <strong>8:30am - 6:00pm Monday to Friday</strong><br/> by calling us on <strong>01273 741400</strong>. </p>
			<p class="validation-success notes">
				<a href="/telephone-answering-pricing" title="Back to Simple Pricing">
					<button type="submit" name="submit" value="submit" class="homepageleft" style="float: none; margin-left: 0; width: auto;">Back to Simple Pricing</button>
				</a>
			</p>
		
		<?php else : ?>
		<div style="margin: 0 auto; width: 1323px;">
			
			<div style="text-align: center;">
				<img src="/images/logo_dark.png" style="width: 660px; height: 330px; margin-top: -55px;" alt="CSnotepad Logo." title="CSnotepad Virtual Receptionists" />

				<ul class="breadcrumb">
					<li><a href="/signup-telephone-pricing-entry"><span class="numberCircle">1</span> Call plan</a></li>
					<li><a href="javascript:history.back()"><span class="numberCircle">2</span> Setup questions</span></a></li>
					<li class="inactive"><span class="numberCircleInactive">3</span> <span style="vertical-align: sub;">Terms & Conditions</span></li>
					<li class="inactive"><span class="numberCircleInactive">4</span> <span style="vertical-align: sub;">Payment info</span></li>
				</ul>
			</div>

			

			<hr style="margin-top: -50px; width: 500px;">
			<br>
			<h1 class="fancy" style="border-bottom: none; color: #241c15; font-size: 24px; font-weight: 400; width: 885px;">Flexible, tailored telephone answering services; giving your business the benefits of an in-house receptionist, at a fraction of the costs.</h1>
			<br>
			<hr style="width: 500px;">
			
			<div class="box-fancy" style="float: none; margin: auto; width: auto; height: auto;">
				<form name="callPLans" id="support-form" action="/signup-contact-process-telephone-pricing-call-plans.php" method="POST">
					<div style="display: inline-flex; margin: auto;">
						<div style="display: inline-block; margin: auto; width: 65%;">
							<div class="form_row" style="margin: 20px 0 0 0;">
							<label for="service" style="font-size: 18px; color: #241c15;">Check that you've selected the right call plan:</label>
							
							<select id="callPlan" name="service" style="font-size: 18px; width: 250px;" onchange="this.form.submit()">
								<option value="Entry">Entry call plan</option>
								<option value="Standard">Standard call plan</option>
								<option value="Intermediate">Intermediate call plan</option>
								<option value="Advanced">Advanced call plan</option>
							</select>

							<h3 class="fancy" style="font-size: 18px; color: #241c15; font-weight: 600; padding: 10px 0 0 0;">
								Select any of the <u style="text-underline-position: under;">FREE</u> extras below that you would like as part
								<br> 
								of your service with us;
							</h3>
							</div>

							<div>

							<?php

								//loadPage.php
								//$call_plan = $_POST['service'];

								switch(service) {
								  case "Entry":
								    header ("includes/Entry.php");
								  break;
								  case "Standard":
								    header ("includes/Standard.php");
								  break;
								  case "Intermediate":
								    header ("includes/Intermediate.php");
								  break;
								  case "Advanced":
								    header ("includes/Advanced.php");
								  break;
								  default :
								  	 echo include "includes/Entry.php";
								  break;
								}
							?>
								
							</div>
							<a name="recaptchaerror"></a>
							<div class="form_row" style="display: inline-flex; margin: 20px 0 0 0;">
								<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
								</div>

								<h3 class="fancy" style="color: #241c15; font-size: 12px; margin-left: -45px; width: 300px;">By clicking the "Get started" button, you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) for the purposes of contacting you via email and/or telephone regarding the services it provides.</h3>
						
							</div>

							<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; margin-left: 13px; width: 275px;"><strong>Please check the reCAPTCHA box and try again</strong>
							</div>
							
							<?php } ?>

							<div class="form_row">
								<button type="submit" name="submit" value="submit" class="bt-support" style="float: left;">Get started</button>
							</div>

						</div>

						<br>
						<br>

						<div style="display: inline-block; margin-top: 25px; width: 30%;">
							<div class="form_row" style="margin: 0 0 20px 13px;"> 
							<label for="first_name" style="font-size: 18px; color: #241c15;"><asterix>*</asterix> Full name</label>
							<input type="text" name="first_name" style="width: 300px;" required value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
							<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
							</div>
							<div class="form_row" style="margin: 0 0 20px 13px;">
							<label for="companyName" style="font-size: 18px; color: #241c15;"><asterix>*</asterix> Company name</label>
							<input type="text" name="companyName" style="width: 300px;" required>
							
							</div>
							<div class="form_row" style="margin: 0 0 20px 13px;">
							<label for="telephone" style="font-size: 18px; color: #241c15;"><asterix>*</asterix> Telephone number</label>
							<input type="text" name="telephone" style="width: 300px;" required>
							
							</div>
							<div class="form_row" style="margin: 0 0 20px 13px;">
							<label for="email" style="font-size: 18px; color: #241c15;"><asterix>*</asterix> Email address</label>
							<input type="text" name="email" style="width: 300px;" required value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
							<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
							</div>
							
						</div>
					</div>

				</form>
		
			</div>
		
			<?php endif; ?>
			
			<?php unset($_SESSION['user-feedback']); ?>
			
		</div>
		<!-- begin Live web chat code -->
		<script type="text/javascript" src="/js/live-web-chat.js"></script>
		<!-- end Live web chat code -->

	</body>
</html>