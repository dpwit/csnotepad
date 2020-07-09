<?php

// grab recaptcha library
require_once "recaptchalib.php";

session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/html/pages/signup-thankyou-TA-pricing.php');
	define(CONTACT_FAIL,		'signup-telephone-pricing.php');
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
			header("Location: signup-telephone-pricing.php?CaptchaFail=True#recaptchaerror");
			
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

        $_SESSION['email'] = $email;
        
	$firstName = $_POST['first_name'];
	$lastName = $_POST['last_name'];
	$telephone = $_POST['telephone'];
	$email = $_POST['email'];
	$companyName = $_POST['companyName'];
	$service = $_POST['service'];
	$callPatching = $_POST['callPatching'];
	$virtualOfficeAddressBtn = $_POST['virtualOfficeAddressBtn'];
	$telephoneAnswering = $_POST['telephoneAnswering'];
	$vip = $_POST['vip'];
	$outOfHours = $_POST['outOfHours'];
	$dailySummary = $_POST['dailySummary'];
	$freeNumber = $_POST['freeNumber'];

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
		case 'PAYG':
			break;
		case 'Fixed Monthly':
			break;
		case 'Telephone':
			$file['name'] = 'CSnotepad telephone answering information pack.pdf';
			$file['path'] = dirname(__FILE__) . '/html/pages/signup_process/CSnotepad telephone answering information pack.pdf';
			break;
		case 'Order taking':
			$file['name'] = 'CSnotepad order taking information pack.pdf';
			$file['path'] = dirname(__FILE__) . '/html/pages/signup_process/CSnotepad order taking information pack.pdf';
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
			'companyName' => $companyName,
			'service' => $service,
			'callPatching' => $callPatching,
			'virtualOfficeAddressBtn' => $virtualOfficeAddressBtn,
			'telephoneAnswering' => $telephoneAnswering,
			'vip' => $vip,
			'outOfHours' => $outOfHours,
			'dailySummary' => $dailySummary,
			'freeNumber' => $freeNumber
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
		$mail->Subject = 'CSnotepad - Terms & Conditions';
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
														<strong>CSnotepad - Terms & Conditions</strong><br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														Please find below the link to access, review and sign your Terms & Conditions.
														<br>
														<br>
														We know that customers can't always read and sign their agreements immediately so will still begin the set up of your account, and our terms and conditions will come into effect immediately, unless we hear from you to say otherwise.
														<br>
														<br>
														Please be aware that although we will complete the setup of your service, we are unable to forward on any calls or post to you until we have received your electronically signed agreement, so please complete and return this as soon as possible using the link below.
														<br>
														<br>
															<a href="https://www.csnotepad.co.uk/csnotepad-agreement.php" target="_blank">CSnotepad agreement</a>
														<br>
														<br>
														Should you have any questions then please do not hesitate to contact me, and thank you for choosing CSnotepad.
													</td>
												</tr>
												<tr>
													<td>
														Kind regards,<br>
														Troy
													</td>
												</tr>
											</table>
											<table  style="font-size: 14px; font-family: Arial" cellspacing="5">
												<tr>
													<td width="35%">
														Troy Lownds
													</td>
													<td width="5%" style="border-left: 1px #1C54FF solid; padding-left: 20px;">
														<img src="https://www.csnotepad.co.uk/images/email-phone.png">
													</td>
													<td width="55%">
														01237 741400
													</td>
												</tr>
												<tr>
													<td width="35%">
														Account Manager
													</td>
													<td width="5%" style="border-left: 1px #1C54FF solid; padding-left: 20px;">
														<img src="https://www.csnotepad.co.uk/images/email-email.png">
													</td>
													<td width="55%">
														<a href="mailto:tlownds@csnotepad.co.uk">tlownds@csnotepad.co.uk</a>
													</td>
												</tr>
												<tr>
													<td width="35%">
														CSnotepad
													</td>
													<td width="5%" style="border-left: 1px #1C54FF solid; padding-left: 20px;">
														<img src="https://www.csnotepad.co.uk/images/email-web.png">
													</td>
													<td width="55%">
														<a href="https://www.csnotepad.co.uk">www.csnotepad.co.uk</a>
													</td>
												</tr>
												<tr>
													<td width="35%">
														&nbsp;
													</td>
													<td width="5%" style="border-left: 1px #1C54FF solid; padding-left: 20px;">
														<img src="https://www.csnotepad.co.uk/images/email-address.png">
													</td>
													<td width="55%">
														Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD
													</td>
												</tr>
											</table>
											<table  style="border-top: 1px #1C54FF solid; font-size: 14px; font-family: Arial; margin-top: 20px;" cellspacing="5">
												<tr>
													<td width="45%" style="padding: 10px;">
														<a href="https://www.csnotepad.co.uk"><img src="https://www.csnotepad.co.uk/images/logo_dark_email.png" width="200"></a>
													</td>
													<td width="45%" style="padding: 10px;">
														<a href="https:www.livewebchat.co.uk"><img src="https://www.csnotepad.co.uk/images/live-web-chat-logo.png" width="200"></a>
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
					<tr><td colspan="2">You have received a Telephone Answering Pricing request.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Full name:</strong></td><td>{$values['firstName']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Telephone number:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Email address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Company name:</strong></td><td>{$values['companyName']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Call plan:</strong></td><td>{$values['service']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Call patching:</strong></td><td>{$_POST['callPatching']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Virtual Office Address Brighton:</strong></td><td>{$_POST['virtualOfficeAddressBtn']}</td></tr>
					<tr><td><strong style="font-weight: bold;">24/7 telephone answering:</strong></td><td>{$_POST['telephoneAnswering']}</td></tr>
					<tr><td><strong style="font-weight: bold;">VIP customer recognition:</strong></td><td>{$_POST['vip']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Out of hours personalised voicemail:</strong></td><td>{$_POST['outOfHours']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Daily summary:</strong></td><td>{$_POST['dailySummary']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Free 01/02/07/08 telephone numner:</strong></td><td>{$_POST['freeNumber']}</td></tr>
					<tr><td><strong style="font-weight: bold;">PDF came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}
	header('location: /html/pages/signup-thankyou-TA-pricing.php');
	