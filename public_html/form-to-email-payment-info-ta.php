<?php

// grab recaptcha library
require_once "recaptchalib.php";

session_start();
$_SESSION['get-email'] = $_POST['email'];
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/html/pages/signup-thankyou-payment-info-ta.php');
	define(CONTACT_FAIL,		'payment-info-ta.php');
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
			header("Location: payment-info-ta.php?CaptchaFail=True#recaptchaerror");
			
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
	$options = $_POST['options'];
	$confEmail = $_POST['confEmail'];
	$acAddr = $_POST['acAddr'];
	$acPcode = $_POST['acPcode'];
	$country = $_POST['country'];
	$additionalInfo = $_POST['additionalInfo'];
	$termTotal = $_POST['termTotal'];
	$cardName = $_POST['cardName'];
	$cardNumber = $_POST['cardNumber'];
	$cardExpMonth = $_POST['cardExpMonth'];
	$cardExpYear = $_POST['cardExpYear'];
	$cardCvc = $_POST['cardCvc'];
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
			'additionalInfo' => $additionalInfo
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
		$mail->Subject = 'CSnotepad Payment confirmation';
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
														<strong><u>Terms and Conditions:</u></strong>
													</td>
												</tr>
												
												<tr>
													<td>
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
		$mail->Subject = 'Payment confirmation';
		$mail->ClearAddresses();
		$mail->AddAddress('wfrancis@csnotepad.co.uk');
		/*$mail->AddAddress('darren.whatford@dpwit.co.uk');*/
		/*$mail->AddAddress('rjohnson@csnotepad.co.uk');*/
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr><td colspan="2">You have received a new payment confirmation from {$_POST['accountName']} to set up a new Telephone Answering service.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Name:</strong></td><td>{$_POST['accountName']}</td></tr>
					<!--<tr><td><strong style="font-weight: bold;">Last name:</strong></td><td>{$values['lastName']}</td></tr>-->
					<tr><td><strong style="font-weight: bold;">Email address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Account full address:</strong></td><td>{$_POST['acAddr']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Account postcode:</strong></td><td>{$_POST['acPcode']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Country of residence:</strong></td><td>{$_POST['country']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Registered name:</strong></td><td>{$_POST['nameOne']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Additional name 1:</strong></td><td>{$_POST['addNames']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Additional name 2:</strong></td><td>{$_POST['nameTwo']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Additional name 3:</strong></td><td>{$_POST['nameThree']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Term:</strong></td><td>&pound;{$_POST['term']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Total paid (Term+VAT+Deposit):</strong></td><td>{$_POST['termTotal']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Preferred payment method:</strong></td><td>{$_POST['method']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Name on card:</strong></td><td>{$_POST['cardName']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Card Number:</strong></td><td>{$_POST['cardNumber']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Exp Month:</strong></td><td>{$_POST['cardExpMonth']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Exp Year:</strong></td><td>{$_POST['cardExpYear']}</td></tr>
					<tr><td><strong style="font-weight: bold;">CVC:</strong></td><td>{$_POST['cardCvc']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Service:</strong></td><td>{$_POST['service']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Additional notes:</strong></td><td>{$_POST['additionalInfo']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Request came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}

	header('location: /html/pages/signup-thankyou-payment-info-ta.php');
		
	