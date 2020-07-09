<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="/html/css/support-contact.css">
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>
		
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>
	<body>
		<?php if($_SESSION['user-feedback']['success']) : ?>
			<img src="/images/email-icon.jpg" alt="" class="email-icon">
			<p class="validation-success"><span class="email">Your information is on its way...</span><br/>We have just emailed you some more information on the services available.</p>
			<p class="validation-success notes">Please let us know if you have any questions that you cannot find the answer to.<br/> We can be contacted between <br/> <strong>8:30am - 6:00pm Monday to Friday</strong><br/> by calling us on <strong>01273 741400</strong>. </p>

		<?php else : ?>

		<h1 class="fancy">Order Taking Service Info Pack & Pricelist emailed to you instantly </h1>
		<h3 class="fancy">It's great that you want more information, we just need to know who you are and where to email it.</h3>
		<h3 class="fancy">Don't worry, we will never share your details with anyone else.</h3>

			<div class="box-fancy">
				<h2>Have our info pack emailed to you now</h2>
				<img src="/images/email-icon2.png" alt="">		
			</div>
			
			<div class="box-fancy">
				<form id="support-form" action="/html/pages/signup_process/signup-order-taking-process.php" method="POST" style="margin-left: 60px">
					<div class="form_row"> 
					<label for="first_name"><asterix>*</asterix> First name</label>
					<input type="text" name="first_name" value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
					</div>

					<div class="form_row">
					<label for="last_name"><asterix>*</asterix> Last name</label>
					<input type="text" name="last_name" value="<?= $_SESSION['user-feedback']['fields']['last_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['last_name']; ?></span>
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
					<label for="service">Service</label>
					<select name="service">
						<option value="Order taking">Order Taking Service</option>
					</select>
					</div>
					
					
					<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-right: 61px">Submit</button>
					</div>
					
				</form>
		
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
	</body>
</html>