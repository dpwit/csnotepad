<?php

// grab recaptcha library
require_once "recaptchalib.php";

session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/html/pages/signup-mailbox-thankyou.php');
	define(CONTACT_FAIL,		'signup-vo-li-fullform.php');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$copyto = 'jim@bozboz.co.uk, webcontact@bozboz.co.uk';
	$mailto = 'wfrancis@csnotepad.co.uk';
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
			header("Location: signup-vo-li-fullform.php?CaptchaFail=True#recaptchaerror");
			
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
	$registered = $_POST['registered'];
	$notes = $_POST['notes'];
	$confEmail = $_POST['confEmail'];
	$acAddr = $_POST['acAddr'];
	$acPcode = $_POST['acPcode'];
	$country = $_POST['country'];
	$companyName = $_POST['companyName'];
	$companyWebsite = $_POST['companyWebsite'];
	$nameOne = $_POST['nameOne'];
	$nameTwo = $_POST['nameTwo'];
	$nameThree = $_POST['nameThree'];
	$addNames = $_POST['addNames'];
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
			'service' => $service,
			'registered' => $registered,
			'notes' => $notes
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
		$mail->Subject = 'CSnotepad Virtual Office setup';
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
														<a title="Virtual Receptionist Services by CSnotepad" href="https://www.csnotepad.co.uk/"><img title="CSnotepad - Virtual Receptionist and Virtual Office Services" alt="Virtual Receptionist and other virtual office services by CSnotepad" src="http://www.csnotepad.co.uk/images/logo_dark_25.png"></a><br/>
													</td>
												</tr>
												<tr>
													<td>
														Dear {$_POST['accountName']},<br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														In order to complete the setup of your service we require signed terms and conditions and ID to be held on file.
													</td>
												</tr>
												<tr>
													<td>
														&nbsp;
													</td>
												</tr>
												<tr>
													<td>
														<strong><u>Terms and Conditions:</u></strong>
													</td>
												</tr>
												<tr>
													<td>
														Please find listed below the link to access, review and sign your Terms & Conditions.
														<br>
														<br>
														We know that customers can't always read and sign their agreements immediately so as you have already made payment for your service we will still complete the set up of your account, and our terms and conditions will come into effect immediately, unless we hear from you to say otherwise.
														<br>
														<br>
														Please be aware that although we will complete the setup of your service, we are unable to forward on any post to you until we have received your electronically signed agreement, so please complete and return this as soon as possible.
													</td>
												</tr>
												<tr>
													<td>
														&nbsp;
													</td>
												</tr>
												<tr>
													<td>
														<a href="https://www.csnotepad.co.uk/csnotepad-agreement.php">CSnotepad agreement</a>
													</td>
												</tr>
												<tr>
													<td>
														&nbsp;
													</td>
												</tr>
												<tr>
													<td>
														<strong><u>Photo ID and proof of address:</u></strong>
													</td>
												</tr>
												<tr>
													<td>
														Photographic ID is required for each named person on the account - please note that if the address is to be used in relation to a registered company then we will also require photographic proof of identity for any persons of significant control (PSC).
														<br>
														<br>
														Please email us a clear copy of one of the following identification documents for each named person on the account:
													</td>
												</tr>
												<tr>
													<td>
														&bull;&nbsp;Passport<br>
														&bull;&nbsp;Full Driving Licence (photocard)<br>
														&bull;&nbsp;National Identity Card<br>
														&bull;&nbsp;HM Forces Identity Card<br>
														&bull;&nbsp;A current student card<br>
														&bull;&nbsp;Employment identification card<br>
														&bull;&nbsp;Disabled drivers blue pass
													</td>
												</tr>
												<tr>
													<td><strong>Proof of address:</strong>
													<br>
													In order to comply with HMRC's anti-money laundering regulations we are required to hold proof of address for each named person on the account, including any persons of significant control (PSC's), irrespective of how your mail is handled.
													<br>
													<br>
													Please email us a clear copy of one of the following documents for each named person on the account, dated within the last 3 months:
													</td>
												</tr>
												<tr>
													<td>
														&bull;&nbsp;Gas or Electricity bill<br>
														&bull;&nbsp;Telephone bill<br>
														&bull;&nbsp;Water bill<br>
														&bull;&nbsp;Mortgage Statement<br>
														&bull;&nbsp;Bank/Building Society statement (excludes credit card/store card bill)<br>
														&bull;&nbsp;TV licence<br>
														&bull;&nbsp;Valid insurance certificate<br>
														&bull;&nbsp;P45/P60 statement<br>
														&bull;&nbsp;Financial statement (e.g. pension, endowment)<br>
														&bull;&nbsp;Current benefit book<br>
														&bull;&nbsp;Letter from Benefits Agency<br>
														&bull;&nbsp;Letter from Benefits Agency<br>
														&bull;&nbsp;Student hall of residence agreement or other proof of accommodation<br>
													</td>
												</tr>
												<tr>
													<td>
														Should you have any questions or if you are unable to provide any of the ID or proof of address items listed above, then please contact us on <a href="tel:01273741400">01273 741400</a>
														<br>
														<br>
														Thank you for choosing CSnotepad.
													</td>
												</tr>
												<tr>
													<table style="font-size: 14px; font-family: Arial" cellspacing="5" width="500">
														<tr>
															<td align="center">
																<img title="CSnotepad" alt="CSnotepad logo" src="http://www.csnotepad.co.uk/images/logo_dark_25.png" width="150">
																<br>
																<a href="https://www.csnotepad.co.uk/telephone-answering-service">Telephone Answering</a>
																<br>
																<a href="https://www.csnotepad.co.uk/virtual-office">Virtual Address</a>
																<br>
																<a href="https://www.csnotepad.co.uk/virtual-assistant">Helpdesk Support</a>
															</td>
															<td align="center">
																<img title="CSnotepad" alt="CSnotepad logo" src="http://www.csnotepad.co.uk/images/live-web-chat-logo.png" width="150">
																<br>
																<br>
																<a href="https://www.livewebchat.co.uk/">Live Web Chat</a>
															</td>
														</tr>
													</table>
												</tr>
												<tr>
													<td style="font-size: 10px;">
														CSnotepad is a trading division of Call Solution Ltd registered in England and Wales. Registered number 6107188. Use of any of the services provided by CSnotepad constitutes acceptance of the Terms and Conditions; details of which can be found <a href="https://www.csnotepad.co.uk/terms-and-conditions.php">HERE</a>
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
		$mail->Subject = 'Virtual Office setup request';
		$mail->ClearAddresses();
		$mail->AddAddress('wfrancis@csnotepad.co.uk');
		/*$mail->AddAddress('darren.whatford@dpwit.co.uk');*/
		/*$mail->AddAddress('rjohnson@csnotepad.co.uk');*/
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr><td colspan="2">You have received a new message from {$_POST['accountName']} to set up a new virtual office.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Name:</strong></td><td>{$_POST['accountName']}</td></tr>
					<!--<tr><td><strong style="font-weight: bold;">Last name:</strong></td><td>{$values['lastName']}</td></tr>-->
					<tr><td><strong style="font-weight: bold;">Email address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Account full address:</strong></td><td>{$_POST['acAddr']}</td></tr>
					<!-- <tr><td><strong style="font-weight: bold;">Account postcode:</strong></td><td>{$_POST['acPcode']}</td></tr> -->
					<tr><td><strong style="font-weight: bold;">Country of residence:</strong></td><td>{$_POST['country']}</td></tr>
					<!--<tr><td><strong style="font-weight: bold;">Company Name:</strong></td><td>{$_POST['companyName']}</td></tr>-->
					<tr><td><strong style="font-weight: bold;">Website:</strong></td><td>{$_POST['companyWebsite']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Name 1:</strong></td><td>{$_POST['nameOne']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Name 2:</strong></td><td>{$_POST['nameTwo']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Name 3:</strong></td><td>{$_POST['nameThree']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Additional Names:</strong></td><td>{$_POST['addNames']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Term:</strong></td><td>{$_POST['term']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Preferred payment method:</strong></td><td>{$_POST['method']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Service:</strong></td><td>{$values['service']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Registered:</strong></td><td>{$values['registered']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Notes:</strong></td><td>{$_POST['notes']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Request came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}
	header('location: /html/pages/signup-mailbox-thankyou.php');
	