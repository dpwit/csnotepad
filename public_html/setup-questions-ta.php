<?php
session_start();
?>
<!DOCTYPE HTML>

<html lang="en-GB">
	<head>
		<title>Setup questions | Telephone Answering</title>
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

		<script 
			src="https://code.jquery.com/jquery-3.5.1.min.js" 
			integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			crossorigin="anonymous">
		</script>
	
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

		
		<div style="margin: 0 auto; width: 1323px;">
			
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
						<li><a href="/test-site/setup-questions-ta"><span class="numberCircle">3</span> Setup questions</a></li>
						<li class="inactive"><span class="numberCircleInactive">4</span> <span style="vertical-align: sub;"> Terms & Conditions</span></li>
						<li class="inactive"><span class="numberCircleInactive">5</span> <span style="vertical-align: sub;"> Payment info</span></li>
					</ul>
				</div>
			</div>
			
			<hr style="width: 500px;">
			<br>
			<h1 class="fancy" style="border-bottom: none; color: #505050; font-size: 34px; font-weight: 700; padding-bottom: 0; width: 885px;">Telephone Answering Setup questions</h1>
			<br>
			<hr style="width: 500px;">

			<div class="bg-call-plan-box" style="margin: 50px auto; padding: 20px 135px; width: 72%;">
				<p>Please complete the setup questions below to the best of your ability, and leave blank any that you are unsure of or that don’t apply.</p>
				<p>During the setup of your service if we have any questions or if you have specifically asked to be contacted then one of our scriptwriters will be in touch.</p>
				<p>If you have any questions whilst completing you setup questions then please contact us on <a href="tel:01273741400">01273 741400</a> or chat to us directly using the chat window below.</p>
				
				<input type="checkbox" name="skipSection" id="skipSection" style="display: inline-block; width: 15px;" onchange="window.location.href='#next'" onclick="skipQuestionSet()">
				<label for="skip-section" style="color: #241c15; display: inline-flex; font-size: 16px;">Tick here if you would like to skip this section and for us to complete the setup of your service over the phone or via email instead.</label>
				
			</div>
			
			<div style="margin-top: 30px; width: auto; height: auto; text-align: center;">
				<form id="setup-questions-ta-form" action="/setup-questions-process-telephone-answering.php" method="POST">
					<div style="box-shadow: 4px 5px 7px #696969; margin: 50px;">

						<div style="display: inline-block; width: 100%;">
							<div class="bg-call-plan-box" style="display: inline-block; padding: 10px 20px 5px 10px; margin: 20px 0 0 0; width: 90%">
								
								<div class="form_row" style="margin: 20px 0 20px 13px;">
								<label for="companyName" class="setup"> Company name</label>
								<input type="text" name="companyName" style="height: 25px; width: 50%;" value="<?= $_SESSION['user-feedback']['fields']['companyName']; ?>">
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['companyName']; ?></span>
								
								</div>
								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="first_name" class="setup"> Contact name</label>
								<input type="text" name="first_name" style="height: 25px; width: 50%;" required value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
								
								</div>
								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="officeAddress" class="setup"> What's your office address?</label>
								<input type="text" name="officeAddress" style="height: 50px; width: 50%;" required>
								
								</div>
								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="addressType" class="setup" style="font-size: 14px;"> •	<i>Is that your physical office, a virtual address or your home address?</i></label>
								<input type="text" name="addressType" style="height: 30px; width: 50%;" required >
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="personalAddress" class="setup"> Personal address (anti-money laundering regulation requirement)</label>
								<input type="text" name="personalAddress" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="businessTelephone" class="setup"> Main business telephone number?</label>
								<input type="text" name="businessTelephone" style="height: 25px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="mobileTelephone" class="setup"> Mobile contact number 
								<br>
								<font style="font-size: 12px">(for internal use in the event of a problem)</font></label>
								<input type="text" name="mobileTelephone" style="height: 30px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="emailAddressCallers" class="setup"> Email address (for callers)</label>
								<input type="text" name="emailAddressCallers" style="height: 25px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="emailAddressInternal" class="setup"> Email address (for internal use)</label>
								<input type="text" name="emailAddressInternal" style="height: 25px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="websiteAddress" class="setup"> What is your website address?
									<br>
								<i><font style="font-size: 12px">We do this so our team can get an understanding of what you do and how best to assist your callers.</font></i>
								</label>
								<input type="text" name="websiteAddress" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="websiteUpToDate" class="setup"> Is the website up to date?
								</label>
								<input type="text" name="websiteUpToDate" style="height: 25px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="businessDesc" class="setup"> Brief description of what your business does.
								</label>
								<textarea type="text" name="businessDesc" style="height: 50px; width: 50%; font-family: Arial; font-size: 13px;" required></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="callsAnswered" class="setup"> How you would like your telephone calls answered e.g. 
									<br><i><font style="font-size: 12px">“Good Morning, ABC. How may I help you?”</font></i>
								</label>
								<textarea type="text" name="callsAnswered" style="height: 60px; width: 50%; font-family: Arial; font-size: 13px;" required></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="statusUnavailable" class="setup"> Your status when you are unavailable? 
									<br><i><font style="font-size: 12px">e.g. “I'm sorry Mr Smith is currently with a client. May I take your number and ask him to return your call?”</font></i>
								</label>
								<textarea type="text" name="statusUnavailable" style="height: 75px; width: 50%; font-family: Arial; font-size: 13px;" required></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="emailToUse" class="setup"> Email -
								<i><font style="font-size: 12px">Your team will send you an email after each call, what email address would you like it go to?</font></i></label>
								<input type="text" name="emailToUse" style="height: 30px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="sms" class="setup"> SMS -
								<i><font style="font-size: 12px">Would you like your team to also send you an sms, we can add sms to all the calls in your plan and it's just an extra 12 pence per call.</font></i></label>
								<input type="text" name="sms" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="staff" class="setup"> Staff -
								<i><font style="font-size: 12px">As we will be part of your team, are there any other staff members it would be useful for us to know of?</font></i></label>
								<input type="text" name="staff" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="callPatching" class="setup"> Call patching -
								<i><font style="font-size: 12px">Would you like your team to put calls through to you? It's free to have the service you'll just need to cover the call costs. (3ppm to landlines, 8ppm to mobiles)</font></i></label>
								<input type="text" name="callPatching" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="callPatchingCont" class="setup"> Call patching cont…
								<i><font style="font-size: 12px">Staff names and mobile numbers for call patching (if applicable)</font></i></label>
								<input type="text" name="callPatchingCont" style="height: 50px; width: 50%;">
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="directions" class="setup"> Directions to your premises to assist any visitors or deliveries</label>
								<textarea type="text" name="directions" style="height: 50px; width: 50%; font-family: Arial; font-size: 13px;" required></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="openingTimes" class="setup"> Opening times</label>
								<input type="text" name="openingTimes" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="anyFAQS" class="setup"> Any other FAQ to assist customers'?</label>
								<textarea type="text" name="anyFAQS" style="height: 50px; width: 50%; font-family: Arial; font-size: 13px;" required></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="infoFromCaller" class="setup"> Information you would like obtained from the caller.
									<br>
								<i><font style="font-size: 12px">Name, company name (if applicable), contact number and message/reason for calling, etc</font></i></label>
								<textarea type="text" name="infoFromCaller" style="height: 100px; width: 50%; font-family: Arial; font-size: 13px;" required></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="adviceCallers" class="setup"> Would you like us to advise callers that we are an answering service?</label>
								<input type="text" name="adviceCallers" style="height: 50px; width: 50%;" required>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="usefulInfo" class="setup"> Any other information we may find useful.</label>
								<textarea type="text" name="usefulInfo" style="height: 50px; width: 50%; font-family: Arial; font-size: 13px;"></textarea>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="coverRequired" class="setup"> The cover you require?</label>
								<select id="coverRequired" name="coverRequired" style="font-size: 18px; height: 30px; margin-left: -165px; width: 51%;">
										<option value="">Please choose...</option>
										<option value="MonFri">Monday - Friday</option>
										<option value="MonSun">Monday - Sunday</option>
										<option value="247">24/7</option>
									</select>
								</div>

								<div class="form_row" style="margin: 0 0 20px 13px;">
								<label for="howCalls" class="setup"> How your calls will reach us?</label>
								<input type="text" name="howCalls" style="height: 50px; width: 50%;">
								</div>

							</div>

							<p style="margin-top: 50px;">
								<input type="checkbox" name="accMgrContact" id="accMgrContact" style="display: inline-block; width: 15px;">
								<label for="accMgrContact" style="color: #241c15; display: inline-flex; font-size: 16px;">Tick this box if you would like an account manager to contact you regarding your setup questions. 
									
								</label>
							</p>

							<a name="next">
							<div style="display: flex;">
								<button type="submit" name="submit" value="submit" class="bt-support" style="float: left; margin: 25px auto;">Next</button>
							</div>

						</div>
					</div>
				</form>
		
			</div>
			
		</div>
		<!-- begin Live web chat code -->
		<script src="/js/live-web-chat.js"></script>
		<!-- end Live web chat code -->

		<script>

		function skipQuestionSet() {
				  var form = document.getElementById("setup-questions-ta-form");
				  var elements = form.elements;
				  
				  if (skipSection.checked == true){
				    for (var i = 0, len = elements.length; i < len; ++i) {
					    elements[i].readOnly = true;
					}
					$(".form_row").css("opacity", 0.5)
					//document.getElementById("setup-questions-ta-form").style.backgroundColor = "#CCCCCC";
				  } else {
				     for (var i = 0, len = elements.length; i < len; ++i) {
					    elements[i].readOnly = false;
					}
					$(".form_row").css("opacity", 1)
				  }
				}
		</script>

	</body>
</html>