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
		<?php if($_SESSION['user-feedback']['success']) : ?>
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
			<img src="/images/email-icon.jpg" alt="" class="email-icon">
			<p class="validation-success"><span class="email">Your information is on its way...</span><br/>We have just emailed you some more information on the services available.</p>
			<p class="validation-success notes">Please let us know if you have any questions that you cannot find the answer to.<br/> We can be contacted between <br/> <strong>8:30am - 6:00pm Monday to Friday</strong><br/> by calling us on <strong>01273 741400</strong>. </p>
		
		<?php else : ?>
		<a name="recaptchaerror"></a>
		<h1 class="fancy" style="font-size: 34px">Info Pack &amp; Price List <br>emailed to you instantly </h1>
		<h3 class="fancy" style="font-size: 14px">It's great that you want more information, we just need to know who you are and where to email it.</h3>
		<h3 class="fancy" style="font-size: 14px">Don't worry, we will never share your details with anyone else.</h3>

			<div class="box-fancy">
				<img src="/images/karl_PDF_PopUp.png" alt="Karl Anscombe testimonial" title="Karl Anscombe testimonial">		
			</div>
			
			<div class="box-fancy" style="margin-left:-20px">
				<form id="support-form" action="/signup-contact-process-order-li.php" method="POST">
					<div class="form_row"> 
					<label for="first_name"><asterix>*</asterix> Name</label>
					<input type="text" name="first_name" value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
					</div>

					
					<div class="form_row">
					<label for="email"><asterix>*</asterix> Email</label>
					<input type="text" name="email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
					</div>
					
					<div class="form_row">
					<label for="telephone">Telephone number</label>
					<input type="text" name="telephone">
					
					</div>

					

					<div class="form_row">
					<label for="service">Which service are you interested in?</label>
					<select name="service">
						
						<option value="Order taking">Order taking</option>
						
					</select>
					</div>
					
					
					<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
						<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="bt-support" style="float: left;">Submit</button>
					</div>
					
				</form>
		
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		<h3 class="fancy" style="font-size: 11px; margin-top: 310px;">By clicking submit you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) for the purposes of contacting you via email and/or telephone regarding the services it provides.</h3>
		
	</body>
</html>