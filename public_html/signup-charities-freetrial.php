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
		<?php if($_SESSION['user-feedback']['success']) : ?>
			
		<?php else : ?>
		<a name="recaptchaerror"></a>
		<h1 class="fancy">GET STARTED FOR FREE</h1>
		<h3 class="fancy" style="text-align: center"><strong>21 day trial.  No credit card required</strong></h3>
		<h3 class="fancy" style="font-size:14px">Please provide us with your contact information in the boxes below and one of our team will contact you shortly to complete the setup of your free trial.
							<br>
							<br>
							Your free trial is an opportunity for you to make sure that the service we provide is right for your business. Your free trial is provided during core hours 
							(8:30am until 6:00pm Monday to Friday) and includes up to 100 free calls during your free trial period.       
		</h3>

			<!--<div class="box-fancy">
				<h2>Have our info pack emailed to you instantly</h2>
				<img src="/images/email-icon2.png" alt="">		
			</div>-->
			
			<div class="box-fancy" style="margin-left:120px">
				<form id="support-form" action="/signup-contact-process-charities-freetrial.php" method="POST" style="margin-left: 42px">
					<div class="form_row"> 
					<label for="first_name"><asterix>*</asterix> Name</label>
					<input type="text" name="first_name" placeholder="Please provide your name" value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
					</div>
				
					<div class="form_row">
					<label for="email"><asterix>*</asterix> Email</label>
					<input type="text" name="email" placeholder="Please provide a valid email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
					</div>
					
					<div class="form_row">
					<label for="telephone"><asterix>*</asterix> Telephone number</label>
					<input type="text" name="telephone" placeholder="Please provide a valid phone number">
					
					</div>

					

					<div class="form_row">
					<label for="service">Which service are you interested in?</label>
					<select name="service">
						<option value="Charities">Charities</option>
	
					</select>
					</div>
					
					
					<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-left: 21px; font-size: 16px;">START YOUR FREE TRIAL</button>
					</div>
					
				</form>
		
			</div>
			
		<?php endif; ?>
		
				
	</body>
</html>