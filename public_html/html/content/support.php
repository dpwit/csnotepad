<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="/css/support-contact.css">
		
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>
	
	</head>

	<body>
		<div id="support-contact">
			<?php if($_SESSION['user-feedback']['success'] == true) : ?> <!-- Output response -->
				<p class="validation-success"><span>Thank you<br/>for contacting us</span><br/>A member of staff will be<br/>in-touch with you shortly.</p>
			<?php else : ?>	<!-- Render the support contact form -->

			<h1 class="fancy">Want Help Now?</h1>
			
			<div class="box-fancy">
				<h2>Simply fill in your details and we’ll get back to you asap.</h2>
				<img src="/images/telephone.png" alt="">
			</div>
			
			
			<div class="box-fancy">
				<form id="support-form" action="/support-contact-process" method="POST">
					<div class="form-row">
						<label for="name">Name</label>
						<input type="text" name="name" value="<?= $_SESSION['user-feedback']['fields']['name']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['name']; ?></span>
					</div>

					<div class="form-row">
						<label for="telephone">Telephone number</label>
						<input type="text" name="telephone" value="<?= $_SESSION['user-feedback']['fields']['telephone']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
					</div>

					<div class="form-row">
						<label for="email">Email</label>
						<input type="text" name="email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
					</div>

					<div class="form-row">
						<label for="name">Company</label>
						<input type="text" name="company" value="<?= $_SESSION['user-feedback']['fields']['company']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['company']; ?></span>
					</div>

					<div class="form-row">
						<label for="message">Message</label>
						<textarea name="message"><?= $_SESSION['user-feedback']['fields']['message']; ?></textarea>
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['message']; ?></span>
					</div>

					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="bt-support">Submit</button>
					</div>
				</form>
			</div>

				
			<?php endif; ?>
			<?php unset($_SESSION['user-feedback']); ?>
		</div>
	</body>
</html>