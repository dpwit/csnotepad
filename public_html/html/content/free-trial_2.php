	<div id="mainSection">
		<div id="mainSection2ColLeft">

				<h2>You don't need a free trial...<br> You need a superb receptionist service from the off.</h2>
				<p>We don’t offer a free trial... why? Because if you want your calls answered by a company that has all of five minutes knowledge about who you are and what you do, then you’ve come to the wrong company!</p>
				<p><b>Call us old fashioned, but at CSnotepad we like to know what the company does that we’re answering the phones for.</b></p>
				<p>We take your account seriously and so should you. You don't need to test whether we can answer your calls in your business name, you know we can, it's the cornerstone of what we do. What you want to know is 'can we do a good job, especially with the tricky bits?'</p>
				<p>We won't set up a 'skeleton' trial account that our staff have never seen before, when <u>our prestigious clients deserve a fully-fledged, bespoke telephone answering service which fits their business requirements exactly</u> and creates a top-class first impression from the off.</p>
				<p>Our staff know every new account is an important, paying customer, so devote their full attention and receive proper training accordingly.</p>
				<p>At CSnotepad we firmly believe you get what you pay for, but also recognise that, for peace of mind, our clients wish to assess our virtual receptionist services without being locked into a long or expensive contract. Clients can therefore take advantage of our Pay As You Go telephone answering tariff, and trial a quality, truly personalised service for only £30+vat. </p>
				<p>Ultimately, we are so confident in our expert team that we don't need to offer a free trial to encourage business.  Our reputation, testimonials, and existing customer referrals speak for themselves. <b>No gimmicks, no fanfare, just quality virtual receptionist services at competitive prices.</b></p>
				
				<form class="form-freetrial" action="/freetrial-process" method="POST">
			<?php  if($_SESSION['user-feedback']['success']) : ?>
				<p><strong>One of our team will be in touch later today to confirm your free trial and to discuss your script.</strong></p>
			<?php else : ?>
					<div class="form-row">
						<label for="name">Name</label>
						<input text="text" name="name" value="<?= $_SESSION['user-feedback']['fields']['name']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['name']; ?></span>
					</div>

					<div class="form-row">
						<label for="company">Company name</label>
						<input text="text" name="company" value="<?= $_SESSION['user-feedback']['fields']['company']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['company']; ?></span>
					</div>

					<div class="form-row">
						<label for="telephone">Telephone number</label>
						<input text="text" name="telephone" value="<?= $_SESSION['user-feedback']['fields']['telephone']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
					</div>

					<div class="form-row">
						<label for="email">Email</label>
						<input text="text" name="email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
					</div>

					<div class="form-row">
						<label for="message">Message</label>
						<textarea name="message"><?= $_SESSION['user-feedback']['fields']['message']; ?></textarea>
						<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['message']; ?></span>
					</div>


					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="callme callmegreen">Submit</button>
						<!-- <input type="submit" value="Submit"> -->
					</div>
				<?php endif; ?>
				</form>
				<h1 class="recommend">98% of our customers<br/> would recommend us to a friend</h1>
			<?php unset($_SESSION['user-feedback']); ?>
		</div>
		<div id="mainSection2ColRight">
			<div id="sideBarBoxTop"></div>
			<div id="sideBarBoxMiddle">
				<?php	include BASEPATH.'../includes/testimonials.php';?>
			</div>
			<div id="sideBarBoxBottom"></div>
			<p>
				<a href="/reasons" title="10 reasons why we're better than an answerphone">
				<img width="217" height="75" alt="10 reasons why our call handling services beat answerphone" src="images/answer.jpg" title="10 reasons why we're better than an answerphone" ></a>
				<a href="/temp" title="10 reasons we're better than a temp">
				<img width="217" height="75" alt="10 reasons why our telephone answering services are better than a temp" src="images/temp.jpg" title="10 reasons we're better than a temp" ></a>
				<a href="/competition" title="10 reasons why we're better than the competition">
				<img width="217" height="75" alt="10 reasons that our call handling and telephone answering services are better than those of competition" src="images/competition.jpg" title="10 reasons why we're better than the competition" ></a>
			</p>
		</div>
		<div class="clear"></div>
	</div>