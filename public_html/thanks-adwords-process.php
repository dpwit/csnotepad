<?php

	session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'/');
	define(CONTACT_SUCCESS,		'thanks-adwords');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$mailto = 'will@bozboz.co.uk';
	$mailto = 'rdonald@csnotepad.co.uk, wfrancis@csnotepad.co.uk';
	$email_from = 'Website Enquiry <info@csnotepad.co.uk>';
	//$copyto = 'peter@bozboz.co.uk';
	


//	header('location:' . CONTACT_PAGE);

	if (!$_POST) return;
	
	$callbackboxname = stripslashes(strip_tags($_POST['callbackboxname']));
	$callbackboxnumber = stripslashes(strip_tags($_POST['callbackboxnumber']));
	$callbackboxtime = stripslashes(strip_tags($_POST['callbackboxtime']));
	
	if($callbackboxname =='') {
		header('location:/?entername');
	}
		
	if($callbackboxnumber =='') {
		header('location:/?enternumber');
	}
	
	

	if($callbackboxname & $callbackboxnumber) {
		$now = date('g:i a j-m-y');
		$message = "You received a message from $callbackboxname  at $now \r\n\r\n Number: $callbackboxnumber \r\n\r\n Preferred Callback Time: $callbackboxtime";
		$headers = "From:  info@csnotepad.co.uk\r\n";
		$headers .= 'BCC: ' . $copyto;
		
		if(!mail($mailto,$label . 'Request a Callback from The AdWords landing page' . $subject,$message,$headers)) {
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

?>