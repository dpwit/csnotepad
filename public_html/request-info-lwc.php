<?php


// grab recaptcha library
require_once "recaptchalib.php";

session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'/live-web-chat.php');
	define(CONTACT_FAIL,		'/live-web-chat');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$copyto = 'jim@bozboz.co.uk, webcontact@bozboz.co.uk';
	$mailto = 'rdonald@csnotepad.co.uk, wfrancis@csnotepad.co.uk, tlownds@csnotepad.co.uk, rcross@csnotepad.co.uk, darren.whatford@dpwit.co.uk';
	$email_from = 'Website Live Web Chat Enquiry <info@csnotepad.co.uk>';
	
	

	

        $email;$comment;$captcha;
        if(isset($_POST['email'])){
          $email=$_POST['email'];
        }if(isset($_POST['comment'])){
          $email=$_POST['comment'];
        }if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
			header("Location: /live-web-chat?CaptchaFail=True#recaptchaerror");
			
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
		{
        //contact form submission code goes here

	if (!$_POST) return;

	$callbackboxname = stripslashes(strip_tags($_POST['callbackboxname']));
	$callbackboxcompany = stripslashes(strip_tags($_POST['callbackboxcompany']));
	$callbackboxemail = stripslashes(strip_tags($_POST['callbackboxemail']));
	$callbackboxnumber = stripslashes(strip_tags($_POST['callbackboxnumber']));
	$callbackboxtime = stripslashes(strip_tags($_POST['callbackboxtime']));
	$camefrom = $_SERVER['HTTP_REFERER'];

	if($callbackboxname =='') {
		header('location:/?entername');
	}

	if($callbackboxnumber =='') {
		$callbackboxnumber = 'Not specified';
	}
	if($callbackboxcompany === '') {
		$callbackboxcompany = 'Not specified';
	}

	if($callbackboxname & $callbackboxnumber) {
		$now = date('g:i a j-m-y');
		$message = "You received an enquiry to try Live Web Chat for free from $callbackboxname at $now \r\n\r\n Name: $callbackboxname \r\n\r\n Company name: $callbackboxcompany \r\n\r\n Number: $callbackboxnumber \r\n\r\n email: $callbackboxemail \r\n\r\n Came from: $camefrom";
		$headers = "From:  info@csnotepad.co.uk\r\n";
		$headers .= 'BCC: ' . $copyto;

		if(!mail($mailto,$label . 'Try Live Web Chat for free' . $subject,$message,$headers)) {
			$errors['mail'] = "Couldn't send message";
		} else {
			unset($_SESSION['contactErrors']);
			unset($_SESSION['contactValues']);
			header('location:' . CONTACT_SUCCESS);
			return;
		}
	}

	$_SESSION['contactValues'] = $_POST;
	$_SESSION['contactErrors'] = $errors;
	return;

    }
		
?>
