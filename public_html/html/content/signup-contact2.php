<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="/css/support-contact.css">
	</head>
	<body>
		<?php if($_SESSION['user-feedback']['success']) : ?>
			<img src="/images/email-icon.jpg" alt="" class="email-icon">
			<p class="validation-success"><span class="email">Your information is on its way...</span><br/>We have just emailed you some more information on our (Virtual address/Virtual PA/Virtual receptionist) service.</p>
			<p class="validation-success notes">Please let us know if you have any questions that you cannot find the answer to.<br/> We can be contacted between <br/> <strong>8:30am - 6:00pm Monday to Friday</strong><br/> by calling us on <strong>01273 741400</strong>. </p>

		<?php else : ?>

		<h1 class="fancy">Prices - emailed to you instantly</h1>
		<h3 class="fancy">It's great that you want more information, we just need to know who you are and where to email it.<br/>
				<span></span> </h3>

			<div class="box-fancy">
				<h2>Have our price list emailed to you now</h2>
				
				<img src="/images/telephone.png" alt="">
			</div>


			<div class="box-fancy">
				<form id="support-form" action="/signup-contact-process" method="POST">
					<div class="form_row">
					<label for="first_name">First name</label>
					<input type="text" name="first_name" value="<?= $_SESSION['user-feedback']['fields']['first_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['first_name']; ?></span>
					</div>

					<div class="form_row">
					<label for="last_name">Last name</label>
					<input type="text" name="last_name" value="<?= $_SESSION['user-feedback']['fields']['last_name']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['last_name']; ?></span>
					</div>

					<div class="form_row">
					<label for="telephone">Telephone number</label>
					<input type="text" name="telephone" value="<?= $_SESSION['user-feedback']['fields']['telephone']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
					</div>

					<div class="form_row">
					<label for="email">Email</label>
					<input type="text" name="email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
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