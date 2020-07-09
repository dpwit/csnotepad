	<div id="mainSection">
		<div id="mainSection2ColLeft">

				<h2 class="emphhead">One week FREE trial...<br> Sign up for our one week 'No Obligation' <b>FREE</b> trial</h2>
				<p>We are so confident about <strong>CSnotepad</strong> and the value we will bring to your business, that we’d like you to try us absolutely free for one week (the only condition is that this is a normal working week).</p>
				<p>At the end of your trial, not only will you have experienced our fantastic telephone answering service, you can also make an informed decision, safe in the knowledge of what your ongoing costs will be.</p>

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
				<h1 class="recommend">96% of our customers<br/> would recommend us</h1>
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