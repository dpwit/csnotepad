<?php

// grab recaptcha library
require_once "recaptchalib.php";

session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/html/pages/signup-mailbox-thankyou.php');
	define(CONTACT_FAIL,		'card-payment-form.php');
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
			header("Location: card-payment-form.php?CaptchaFail=True#recaptchaerror");
			
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
	$accountName = $_POST['accountName'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$term = $_POST['term'];
	$method = $_POST['method'];
	$service = $_POST['service'];
	$confEmail = $_POST['confEmail'];
	$acAddr = $_POST['acAddr'];
	$acPcode = $_POST['acPcode'];
	$country = $_POST['country'];
	$referer = $_SERVER['HTTP_REFERER'];

	$_SESSION['user-feedback']['success'] = true;
	$_SESSION['user-feedback']['fields'] = $_POST;

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
		$mail->Subject = 'CSnotepad Personal Virtual Address setup';
		$mail->ClearAddresses();
		$mail->AddAddress($email);
		$mail->AddAttachment($file['path'], $file['name']);
		$mail->Body= <<<HTML
			<body>
				<div style="background-color:#7bceeb;">
  
					  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
					    <v:fill type="tile" src="https://www.csnotepad.co.uk/images/background-personalva-email.png" color="#7bceeb"/>
					  </v:background>
  
					<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
						    <td valign="top" align="left" background="https://www.csnotepad.co.uk/images/background-personalva-email.png">
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
														Dear {$_POST['accountName']},<br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														<strong>CSnotepad - Personal Virtual Address</strong><br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														Further to your online sign-up of the virtual address service, please click the link below to access, review and sign your agreement.
													</td>
												</tr>
												<tr>
													<td>
														<a href="https://www.csnotepad.co.uk/csnotepad-agreement.php">CSnotepad agreement</a>
													</td>
												</tr>
												<tr>
													<td>
														
														Should you have any questions please do not hesitate to contact us on <a href="tel:08000862741">0800 086 2741</a>
														<br>
														<br>
														Thank you for choosing CSnotepad.

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
		$mail->Subject = 'Mailbox setup request';
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
					<tr><td colspan="2">You have received a new message from {$_POST['accountName']} to set up a new personal virtual address.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Name:</strong></td><td>{$_POST['accountName']}</td></tr>
					<!--<tr><td><strong style="font-weight: bold;">Last name:</strong></td><td>{$values['lastName']}</td></tr>-->
					<tr><td><strong style="font-weight: bold;">Email address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Account full address:</strong></td><td>{$_POST['acAddr']}</td></tr>
					<!-- <tr><td><strong style="font-weight: bold;">Account postcode:</strong></td><td>{$_POST['acPcode']}</td></tr> -->
					<tr><td><strong style="font-weight: bold;">Country of residence:</strong></td><td>{$_POST['country']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Term:</strong></td><td>{$_POST['term']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Preferred payment method:</strong></td><td>{$_POST['method']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Service:</strong></td><td>{$values['service']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Request came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}
	header('location: /html/pages/signup-mailbox-thankyou.php');
	