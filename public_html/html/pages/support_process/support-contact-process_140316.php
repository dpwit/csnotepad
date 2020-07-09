<?php

	function isValidEmail($email){
	    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}

	$name = $_POST['name'];
	$telephone = $_POST['telephone'];
	$email = $_POST['email'];
	$company = $_POST['company'];
	$message = $_POST['message'];

	$_SESSION['user-feedback']['success'] = true;
	$_SESSION['user-feedback']['fields'] = $_POST;

	if($name === '') {
		$_SESSION['user-feedback']['errors']['name'] = 'Please state your name';
		$_SESSION['user-feedback']['success'] = false;
	}
	if($telephone === '') {
		$_SESSION['user-feedback']['errors']['telephone'] = 'Please state your telephone number';
		$_SESSION['user-feedback']['success'] = false;
	}
	if($email === '') {
		$_SESSION['user-feedback']['errors']['email'] = 'Please state your email address';
		$_SESSION['user-feedback']['success'] = false;
	}
	if(!isValidEmail($email)) {
		$_SESSION['user-feedback']['errors']['email'] = 'Please provide a valid email address';
		$_SESSION['user-feedback']['fields']['email'] = '';
		$_SESSION['user-feedback']['success'] = false;
	}
	if($company === '') {
		$_SESSION['user-feedback']['errors']['company'] = 'Please specify your company\'s name';
		$_SESSION['user-feedback']['success'] = false;
	}
	if($message === '') {
		$_SESSION['user-feedback']['errors']['message'] = 'Please specify a message';
		$_SESSION['user-feedback']['success'] = false;
	}

	if(!isset($_SESSION['user-feedback']['errors'])) {
		require_once('cms/modules/phpmailer/class.phpmailer.php');
		$mail = new phpmailer();
		$mail->IsHTML(true);
		$mail->From = 'contact@csnotepad.co.uk';
		$mail->FromName = $name;
		$mail->Subject = 'Support request';
		$mail->AddAddress('rdonald@csnotepad.co.uk');
		$mail->AddAddress('wfrancis@csnotepad.co.uk');
		$mail->AddAddress('darren.whatford@dpwit.co.uk');
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr>
						<td>
							<table style="font-size: 14px; font-family: Arial" cellspacing="5">
								<tr><td colspan="2">You have received a support request.</td></tr>
								<tr><td colspan="2">&nbsp;</td></tr>
								<tr><td><strong style="font-weight: bold;">Name:</strong></td><td>{$name}</td></tr>
								<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$telephone}</td></tr>
								<tr><td><strong style="font-weight: bold;">Email Address:</strong></td><td>{$email}</td></tr>
								<tr><td><strong style="font-weight: bold;">Company:</strong></td><td>{$company}</td></tr>
								<tr><td><strong style="font-weight: bold;">Message:</strong></td><td>{$message}</td></tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
HTML;

		$mail->Send();

	}
	

	header('location: /html/pages/contact-thankyou.php');
	exit;