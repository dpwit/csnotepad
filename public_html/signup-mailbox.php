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
		<h1 class="fancy" style="font-size: 34px">Set up your service</h1>
		<h3 class="fancy" style="font-size: 14px">
			<strong>Please remember;</strong> although you can start using your new accommodation address immediately,  incoming mail cannot be forwarded or scanned until this <strong>ID verification</strong> process has been completed.
		</h3>
		<h3 class="fancy" style="font-size: 14px; color: red;">
			(all fields must be completed)
		</h3>
			<!--Page 1-->
			<div class="box-fancy">
				<form id="support-form" action="/signup-contact-process-mailbox.php" method="POST">
					<div class="form_row"> 
					<label for="first_name"><asterix>*</asterix> Account holders name:</label>
					<input type="text" name="first_name" value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
					</div>
				
					<div class="form_row">
					<label for="email"><asterix>*</asterix> Contact email address:</label>
					<input type="text" name="email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
					</div>
					
					<div class="form_row">
					<label for="telephone"><asterix>*</asterix> Contact telephone number:</label>
					<input type="text" name="telephone" value="<?= $_SESSION['user-feedback']['fields']['telephone']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
					</div>

					

					<div class="form_row">
					<label for="term">Account term:</label>
					<select name="term">
						<option value="Quarterly">Quarterly (equivalent to just &pound;10 a month)</option>
						<option value="BiAnnually">Bi-annually (equivalent to just &pound;8.33 a month)</option>
						<option value="Annually">Annually (equivalent to just &pound;6.05 a month)</option>
					</select>
					</div>

					<!--<div class="form-row">
						<a href="#page2" class="bt-support" style="float: left; text-decoration: none;">Next...</a>
					</div>
					<br>
					<br>
					<br>
					<br>-->
					<!--Page 2-->
					<a name="page2"></a>
					<div class="form_row">
					<label for="service">Type of service required:</label>
					<select name="service">
						<option value="Forwarding">Mail forwarding</option>
						<option value="Collection">Mail stored for collection</option>
						<option value="Scan">Scan to email service</option>
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
				<h3 class="fancy" style="font-size: 11px;">By clicking submit you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) for the purposes of contacting you via email and/or telephone regarding the services it provides.</h3>
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>