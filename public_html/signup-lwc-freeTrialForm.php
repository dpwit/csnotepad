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
				<form id="support-form" action="/form-to-email-lwc30" method="POST">
					<!--Page 1-->
					<!-- <div id="container" style="width: 550px;">
						<h1 class="fancy" style="font-size: 34px">30 day FREE trial</h1>
							<h2 class="fancy" style="font-size: 15px; padding: 0px; margin-top: 20px;">Experience our full service completely free for 30 days.
							<br>
							<br>
							To us, free means exactly that; no hidden costs, no set-up fees, no admin charges and absolutely no ongoing commitment.
							<br>
							<br>
							Please enter your details below and one of our friendly team will be in touch to arrange your 30 day no-obligation free trial.</h2>
						</div> -->
						<div class="innerDivHome" style="width:550px; background-color: #29B8EF; -webkit-padding-before: 12px; border-radius: 5px; box-shadow: 3px 3px 5px #505050; height: 135px; margin: 5px 0 10px 0; text-align: center;">
								<h2 style="color: #fff; font-size: 32px; margin-bottom: 10px; text-shadow: none"><strong>Try Live Web Chat free</strong></h2>
								<h3 style="color: #fff; font-size: 13px; text-shadow: none;">Experience our full service completely free for 30 days.
								<br>
								To us, free means exactly that; no hidden costs, no set-up fees, no admin charges
								<br>
								and absolutely no ongoing commitment.
								<br>
								<br>
								You've got nothing to lose.
								<br>
								</h3>
								<br>
							</div>
						<div style="width: 555px; display: inline-block;">
							<div id="first" style="width: 250px; display: inline-block;">
								<div class="form_row"> 
									<label for="accountName" style="font-size: 15px"><asterix>*</asterix> Full name:</label>
									<input type="text" name="accountName" required placeholder=""
									    oninvalid="this.setCustomValidity('Full name required')"
									    oninput="this.setCustomValidity('')"  />
									<span class="error"><?php echo $accountNameErr;?></span>
								</div>

								<div class="form_row">
									<label for="companyName" style="font-size: 15px"><asterix>*</asterix> Company name:</label>
									<input type="text" name="companyName" required placeholder=""
									    oninvalid="this.setCustomValidity('Company name required')"
									    oninput="this.setCustomValidity('')"  />
									<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['companyName']; ?></span>
								</div>

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

								<div class="form_row">
									<label for="website" style="font-size: 15px"><asterix>*</asterix> Website:</label>
									<input type="text" name="website" required placeholder=""
									    oninvalid="this.setCustomValidity('web address required')"
									    oninput="this.setCustomValidity('')"  />
									<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['website']; ?></span>
								</div>

							</div>
							<div id="second" style="width: 300px; display: inline-block; font-family: Arial; color: #555; text-align: center;">
								<strong>Disclaimer</strong>
								<br>
								<br>
								The trial period gives you access to the service (as defined in the terms and conditions) for a period of 30 days, the trial is capped at 100 chats.
								<br>
								<br>
								<br>
							</div>
					</div>

						<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row" style="margin-top: -80px; width: 450px;">
						<button type="submit" name="submit" value="submit" class="bt-support">Submit</button>
					</div>
					
				</form>

				<h3 class="fancy" style="font-size: 11px; margin-top: 70px; padding-left: 0px; width: 525px;">
					By clicking to submit, you hereby agree to your details being held by Live Web Chat Ltd and Call Solution Ltd (trading as CSnotepad) as per our privacy policy, details of which can be found here; <a href="https://www.csnotepad.co.uk/privacypolicy" target="_blank">Privacy Policy</a>.
				</h3>
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