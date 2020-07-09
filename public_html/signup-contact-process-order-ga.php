<?php

// grab recaptcha library
require_once "recaptchalib.php";

session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/html/pages/signup-thankyou.php');
	define(CONTACT_FAIL,		'signup-order-ga.php');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$copyto = 'jim@bozboz.co.uk, webcontact@bozboz.co.uk';
	$mailto = 'rdonald@csnotepad.co.uk, wfrancis@csnotepad.co.uk, tlownds@csnotepad.co.uk, rcross@csnotepad.co.uk, darren.whatford@dpwit.co.uk';
	$email_from = 'contact@csnotepad.co.uk';
	
	

	

        $email;$comment;$captcha;
        if(isset($_POST['email'])){
          $email=$_POST['email'];
        }if(isset($_POST['comment'])){
          $email=$_POST['comment'];
        }if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
			header("Location: signup-order-ga.php?CaptchaFail=True#recaptchaerror");
			
          exit;
        }
        $secretKey = "6LekVxoTAAAAALjt0p4h9uXmQR-v-OlSlYtgNfZV";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
          echo '<h2>We believe you may be a spammer!  Please complete the form fully including the reCAPTCHA box, or kindly leave.  Thank you.</h2>';
        } 
		else {
          header('location:' . CONTACT_SUCCESS);
        }

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
			$file['path'] = dirname(__FILE__) . '/html/pages/signup_process/CSnotepad telephone answering information pack.pdf';
			break;
		case 'Order taking':
			$file['name'] = 'CSnotepad order taking information pack-ga.pdf';
			$file['path'] = dirname(__FILE__) . '/html/pages/signup_process/CSnotepad order taking information pack-ga.pdf';
			break;
		case 'Virtual address':
			$file['name'] = 'CSnotepad virtual office address information pack.pdf';
			$file['path'] = dirname(__FILE__) . '/html/pages/signup_process/CSnotepad virtual office address information pack.pdf';
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
		$mail->Subject = 'CSnotepad Information Pack & Price List';
		$mail->ClearAddresses();
		$mail->AddAddress($email);
		$mail->AddAttachment($file['path'], $file['name']);
		$mail->Body= <<<HTML
			<body>
				<div style="background-color:#7bceeb;">
  
					  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
					    <v:fill type="tile" src="https://www.csnotepad.co.uk/images/bg-email.png" color="#7bceeb"/>
					  </v:background>
  
					<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
						    <td valign="top" align="left" background="https://www.csnotepad.co.uk/images/bg-email.png">
								<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
									<tr>
										<td>
											<table style="font-size: 14px; font-family: Arial" cellspacing="5">
												<tr>
													<td>
														<a title="Virtual Receptionist Services by CSnotepad" href="http://www.csnotepad.co.uk/"><img title="CSnotepad - Virtual Receptionist and Virtual Office Services" alt="Virtual Receptionist and other virtual office services by CSnotepad" src="http://www.csnotepad.co.uk/images/logo_dark_25.png"></a><br/>
													</td>
												</tr>
												<tr>
													<td>
														Hi {$_POST['first_name']},<br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														<strong>CSnotepad - Information Pack &amp; Price List</strong><br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														Please find attached the information pack you requested.<br><br>
														One of the team will be in touch via email to say 'hi' and to introduce themselves as your point of contact<br><br>
														In the meantime if you have any questions or would like to have a chat to one of our friendly team then please don't hesitate to call on 01273 741400 or email us at 
														<a href="mailto: info@csnotepad.co.uk">info@csnotepad.co.uk</a><br><br>
													</td>
												</tr>
												<tr>
													<td>
														Kind regards,<br>
														CSnotepad
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
    					</tr>
  					</table>
				</div>
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
		$mail->AddAddress('tlownds@csnotepad.co.uk');
		$mail->AddAddress('rcross@csnotepad.co.uk');
		$mail->AddAddress('darren.whatford@dpwit.co.uk');
		/*$mail->AddAddress('rjohnson@csnotepad.co.uk');*/
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr><td colspan="2">You have received a signup request.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Name:</strong></td><td>{$values['firstName']}</td></tr>
					<!--<tr><td><strong style="font-weight: bold;">Last name:</strong></td><td>{$values['lastName']}</td></tr>-->
					<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Email Address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Service:</strong></td><td>{$values['service']}</td></tr>
					<tr><td><strong style="font-weight: bold;">PDF came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}
	header('location: /html/pages/signup-thankyou.php');
	