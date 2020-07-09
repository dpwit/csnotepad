<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="/html/css/support-contact.css">
		
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>

	</head>
	<body>
		<?php if($_SESSION['user-feedback']['success']) : ?>
			<p class="validation-success"><span class="email">Thank you</span><br/>for contacting us.</p>
			<p class="validation-success notes">A member of staff will be<br/>in touch with you shortly.</p>

		<?php else : ?>

		<h1 class="fancy">Info Pack & Pricelist emailed to you instantly </h1>
		<h3 class="fancy">It's great that you want more information, we just need to know who you are and where to email it.</h3>
		<h3 class="fancy">Don't worry, we will never share your details with anyone else.</h3>

			<div class="box-fancy">
				<h2>Have our info pack emailed to you now</h2>
				<img src="/images/email-icon2.png" alt="">		
			</div>
			
			<div class="box-fancy">
				<form id="support-form" action="/signup-contact-process" method="POST">
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
						<option value="Telephone">Telephone answering</option>
						<option value="Order taking">Order taking</option>
						<option value="Virtual address">Virtual address</option>
					</select>
					</div>
					
					

					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="bt-support">Submit</button>
					</div>
					
				</form>
		
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
	</body>
</html>