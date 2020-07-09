<?php

// grab recaptcha library
require_once "recaptchalib.php";

session_start();
$_SESSION['get-email'] = $_POST['email'];
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/html/pages/signup-thankyou-sellyourbusiness.php');
	define(CONTACT_FAIL,		'/sell-your-business/index.php');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$copyto = 'jim@bozboz.co.uk, webcontact@bozboz.co.uk';
	$mailto = 'info@csnotepad.co.uk';
	$email_from = 'info@csnotepad.co.uk';
	
        $email;$comment;$captcha;
        if(isset($_POST['email'])){
          $email=$_POST['email'];
        }if(isset($_POST['comment'])){
          $email=$_POST['comment'];
        }if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
			header("Location: /sell-your-business/index.php?CaptchaFail=True#recaptchaerror");
			
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
	$registered = $_POST['registered'];
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
	 */

	function emailClient($mail, $values) {
		$mail->IsHTML(true);
		$mail->From = 'info@csnotepad.co.uk';
		$mail->FromName = $name;
		$mail->Subject = 'Sell your business interest';
		$mail->ClearAddresses();
		$mail->AddAddress('info@csnotepad.co.uk');
		$mail->AddAddress('darren.whatford@dpwit.co.uk');
		/*$mail->AddAddress('rjohnson@csnotepad.co.uk');*/
		$mail->Body= <<<HTML
			<body bgcolor="#f2f2f2" style="background: #f2f2f2;">
				<table width="500" align="center" cellpadding="0" cellspacing="10" bgcolor="#ffffff" style="background: #ffffff;">
					<tr><td colspan="2">You have received a new message from {$_POST['accountName']} showing interest in selling their business.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Name:</strong></td><td>{$_POST['accountName']}</td></tr>
					<!--<tr><td><strong style="font-weight: bold;">Last name:</strong></td><td>{$values['lastName']}</td></tr>-->
					<tr><td><strong style="font-weight: bold;">Email address:</strong></td><td>{$values['email']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Telephone:</strong></td><td>{$values['telephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Request came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}

	header('location: /html/pages/signup-thankyou-sellyourbusiness.php');
	