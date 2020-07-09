<?php
if(isset($_POST['submit']) && !empty($_POST['submit'])):
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
        //your site secret key
        $secret = '6LekVxoTAAAAALjt0p4h9uXmQR-v-OlSlYtgNfZV';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):
            //contact form submission code
	$firstName = $_POST['first_name'];
	$lastName = $_POST['last_name'];
	$telephone = $_POST['telephone'];
	$email = $_POST['email'];
	$service = $_POST['service'];

	$_SESSION['user-feedback']['success'] = true;
	$_SESSION['user-feedback']['fields'] = $_POST;


	if($firstName === '') {
		$_SESSION['user-feedback']['errors']['first_name'] = 'Please state your first name';
		$_SESSION['user-feedback']['success'] = false;
	}
	if($lastName === '') {
		$_SESSION['user-feedback']['errors']['last_name'] = 'Please state your last name';
		$_SESSION['user-feedback']['success'] = false;
	}
	if(!isValidEmail($email)) {
		$_SESSION['user-feedback']['errors']['email'] = 'Please provide a valid email address';
		$_SESSION['user-feedback']['fields']['email'] = '';
		$_SESSION['user-feedback']['success'] = false;
	}
	if($email === '') {
		$_SESSION['user-feedback']['errors']['email'] = 'Please provide an email address';
		$_SESSION['user-feedback']['success'] = false;
	}

	$file = array(
		'name' => '',
		'path' => ''
	);
	switch($service) {
		case 'Telephone':
			$file['name'] = 'CSnotepad telephone answering information pack.pdf';
			$file['path'] = dirname(__FILE__) . '/CSnotepad telephone answering information pack.pdf';
			break;
		case 'Order taking':
			$file['name'] = 'CSnotepad order taking information pack.pdf';
			$file['path'] = dirname(__FILE__) . '/CSnotepad order taking information pack.pdf';
			break;
		case 'Virtual address':
			$file['name'] = 'CSnotepad virtual office address information pack.pdf';
			$file['path'] = dirname(__FILE__) . '/CSnotepad virtual office address information pack.pdf';
			break;
		default:
			die('<select> option for signup contained a value that was not recognised.');
	}

	if($_SESSION['user-feedback']['success']) {
		require_once('cms/modules/phpmailer/class.phpmailer.php');
		$mail = new phpmailer();
		emailClient($mail, array(
			'firstName' => $firstName,
			'lastName' => $lastName,
			'telephone' => $telephone,
			'email' => $email,
			'service' => $service
		));
		emailUser($mail, $email, $file);
	}

	header('location: ' . $_SERVER['HTTP_REFERER']);

	//Helper functions

	/**
	 * @param $email Email adderess to validate.
	 * @return boolean True if valid, false if not.
	 */
	function isValidEmail($email){
	    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}

	/**
	 * @param $mail Instance of the phpmailer class
	 * @param $emailAddress Email address of the user
	 */
	function emailUser($mail, $email, $file) {
		$mail->IsHTML(true);
		$mail->From = 'contact@csnotepad.co.uk';
		$mail->FromName = 'CSnotepad';
		$mail->Subject = 'CSnotepad info pack';
		$mail->ClearAddresses();
		$mail->AddAddress($email);
		$mail->AddAttachment($file['path'], $file['name']);
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr>
						<td>
							<table style="font-size: 14px; font-family: Arial" cellspacing="5">
								<tr><td><a title="Virtual Receptionist Services by CSnotepad" href="http://www.csnotepad.co.uk/"><img title="CSnotepad - Virtual Receptionist and Virtual Office Services" alt="Virtual Receptionist and other virtual office services by CSnotepad" src="http://www.csnotepad.co.uk/images/logo.png"></a><br/></td>
								<tr><td>Thank you for requesting more information. Please find the requested price list attached.<br/><br/></td></tr>
								<tr><td>Please let us know if you have any questions that you cannot find the answer to.<br/><br/> We can be contacted between <br/> <strong>8:30am - 6:00pm Monday to Friday</strong><br/> by calling us on <strong>01273 741400</strong>.</td></tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}


	/**
	 * @param $mail Instance of the phpmailer class
	 */
	function emailClient($mail, $values) {
		$mail->IsHTML(true);
		$mail->From = 'contact@csnotepad.co.uk';
		$mail->FromName = $name;
		$mail->Subject = 'Signup request';
		$mail->ClearAddresses();
		$mail->AddAddress('rdonald@csnotepad.co.uk');
		$mail->AddAddress('wfrancis@csnotepad.co.uk');
		/*$mail->AddAddress('rjohnson@csnotepad.co.uk');*/
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr><td colspan="2">You have received a signup request.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">First name:</strong></td><td>{$values['firstName']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Last name:</strong></td><td>{$values['lastName']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Email Address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Service:</strong></td><td>{$values['service']}</td></tr>

				</table>
			</body>
HTML;

		$mail->Send();
		
	}
	}
?>