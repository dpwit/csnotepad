<?php

	
?>
						
	<div id="content">
		<div id="VideoPage" class="inner">
		<div class="col">
			<div id="artistsList" class="thinBorder box">
				<h2>Contact</h2>

					</div>
                    </div>
		
					<div id="breadcrumb">
						<h3><a href="/">Home &gt;</a> <a href="/contact">Contact &gt;</a> <a href="/<?=strtolower($label)?>/contact"><?=$label?></a></h3>
					</div>	
                    <div class="last col">
<div id="Contact" class="box thinBorder">                

<div class="form_main">
<div class="contactform">
<h3>Contact <?=$label?></h3>
<?php

	if ($_POST['submit']) {

$name = stripslashes(strip_tags(@$_POST['name']));
$email = stripslashes(strip_tags(@$_POST['email']));
$contactWho = stripslashes(strip_tags(@$_POST['contactWho']));
$message = stripslashes(strip_tags(@$_POST['message']));
$errors = array();

if($name=='')
	$errors['name'] = 'Please enter your name';
	
if($email=='') {
	$errors['email'] = 'Please enter your email address';
} else {
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		$errors['email'] = 'Please enter a valid email address';
}

if($message=='')
	$errors['message'] = 'Please enter a message';

if(!count($errors)){
	
	$now = date('Y-m-d');
	$message = "You received a message from $name ($email) at $now\r\n\r\nSubject: $contactWho \r\n\r\nThe message reads: $message";
	$headers = 'From: Website Enquiry <info@skintentertainment.com>' . "\r\n";
	//$mailto = "contact@skintentertainment.com";  
	$mailto = "jim@bozboz.co.uk";
	if(!mail(
			$mailto, 
			$label . ' Website Enquiry - ' . $contactWho,
			$message,
			$headers
		)
	){
		//die('Sorry there was a problem sending your message, please inform info@robincrosby.com');
	} else {
		
		?>
		
		Thank you for contacting <?=$label?>.
		
		<?php
		
	}
}
else {
	foreach($errors as $error) {
		echo $error . '<br />';
	}
}
	
	} else {

?>
<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
<div class="form_label">Name:</div>
<div class="form_input"><input name="name" id="name" type="text"  /></div>
<div class="form_label">Email:</div>
<div class="form_input"><input name="email" id="email" type="text"  /></div>
<div class="form_label">Subject:</div>
<div class="form_input"><select name="contactWho"><option label="General">General Enquiries</option><option label="LicensingBusiness">Licensing/Business Affairs</option><option label="AR">A&amp;R</option></select></div>
<div class="form_label">Message:</div>
<div class="form_input"><textarea name="message" cols="" rows=""></textarea></div>
<div class="form_footer">
                <input type="submit" name="submit" value="Go" class="go">
</div>
</form><br clear="all" />

<p><a href="http://www.myspace.com/<?=$myspace?>" title="<?=$label?> on MySpace" target="_blank"><?=$label?> on MySpace</a></p>
</div>

<div class="contactform contactright">
<h3>Address</h3>
<p><strong><?=$address?></strong>, PO BOX 174, Brighton, BN1 4BA</p> 
<? if($soundcloud) { ?>
<h3>Demos</h3>
<p>Please upload demos to our soundcloud dropbox:<br />
<a href="http://soundcloud.com/skintrecords/dropbox" title="Soundcloud Dropboz" target="_blank"><img src="/images/soundcloud.png" width="97" height="16" alt="Soundcloud Dropbox" /></a></p>
<? } ?>
<script type="text/javascript" src="/js/signup_ajax.js"></script>
<h3>Sign Up to the <?=$label?> mailing List</h2>
						<form id="signUpForm" action="/lists/newsletteradduser.php" method="post">
							<fieldset>
								<div class="form_label">Name</div>
								<div class="form_input"><input type="text" name="name" id="nameForm"></div>
								<div class="form_label">Email</div>
								<div class="form_input"><input type="text" name="email" id="emailForm"></div>
								<input type="hidden" name="listId" value="<?=$list_id?>" />
								<input type="submit" class="go" value="Go" title="Submit Form">
							</fieldset>
						</form>
						<div id="ajaxReturn"></div>

<?php } ?>

</div>
</div>

<br clear="all" />

			</div>
		</div>
	</div>

</div>
