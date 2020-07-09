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
		
			<!--Page 2-->
			<h3 class="fancy" style="font-size: 14px">
				<strong>Page 3 of 3</strong>
				<br>
				<br>
			</h3>
			<a name="page3"></a>
					
						<h3 class="fancy" style="font-size: 16px; padding-left: 0px; width: 550px;">
							Please confirm the account holders address. The address you provide should be your normal residential address, which you can verify to us by providing suitable documentation, such as a driving license or a recent bank statement, should we ask you.  
						</h3>
					
			<div class="box-fancy">
				<form id="support-form" action="/form-to-email" method="POST">
					<!--Page 2-->
					
					<div class="form_row"> 
					<label for="acAddr" style="font-size: 15px;"><asterix>*</asterix> Account holders address:</label>
					<input type="text" name="acAddr" value="<?= $_SESSION['user-feedback']['fields']['acAddr']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acAddr']; ?></span>
					</div>
					<div class="form_row"> 
					<label for="acPcode" style="font-size: 15px;"><asterix>*</asterix> Postcode:</label>
					<input type="text" name="acPcode" value="<?= $_SESSION['user-feedback']['fields']['acPcode']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acPcode']; ?></span>
					</div>
					<div class="form_row"> 
					<label for="confEmail" style="font-size: 15px;"><asterix>*</asterix> Please confirm your email address:</label>
					<input type="text" name="confEmail" value="<?= $_SESSION['user-feedback']['fields']['confEmail']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['confEmail']; ?></span>
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
				<h3 class="fancy" style="font-size: 11px; margin-top: 75px; padding-left: 0px; width: 550px;">By clicking submit you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) for the purposes of contacting you via email and/or telephone regarding the services it provides.</h3>
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>