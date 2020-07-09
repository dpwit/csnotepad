<?php



	session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'thanks');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$copyto = 'jim@bozboz.co.uk, webcontact@bozboz.co.uk';
	$mailto = 'rdonald@csnotepad.co.uk, wfrancis@csnotepad.co.uk, tlownds@csnotepad.co.uk, rcross@csnotepad.co.uk, darren.whatford@dpwit.co.uk';
	$email_from = 'Website Enquiry <info@csnotepad.co.uk>';
	
	

	header('location:' . CONTACT_PAGE);
	
	if(isset($_POST['submit']) && !empty($_POST['submit'])){
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
    //your site secret key
    $secret = '6LekVxoTAAAAALjt0p4h9uXmQR-v-OlSlYtgNfZV';
    //get verify response data
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if($responseData->success){
        //contact form submission code goes here

	if (!$_POST) return;
	
	$additionalInfo = stripslashes(strip_tags($_POST['additionalInfo']));
	$name = stripslashes(strip_tags($_POST['name']));
	$businessName = stripslashes(strip_tags($_POST['businessName']));
	$email = stripslashes(strip_tags($_POST['email']));
	$phone = stripslashes(strip_tags($_POST['phone']));
	$contactBy = stripslashes(strip_tags($_POST['contactBy']));
	$interestedIn = stripslashes(strip_tags($_POST['interestedIn']));
	
	$errors = array();

	
	
	if(!count($errors)){
		
		$now = date('g:i a j-m-y');
		$message = "You received a message from $name ($email) at $now \r\n\r\n Interested in: $interestedIn \r\n\r\n Additional info: $additionalInfo \r\n\r\n Business name: $businessName \r\n\r\n Email: $email \r\n\r\n Phone: $phone \r\n\r\n Contact Method: $contactBy";
		$headers = 'From: ' . $email_from . "\r\n" . 'Reply-To: '.$name.'<'.$email.'>' . "\r\n";
		if ($copyto) $headers .= 'CC: ' . $copyto;
		
		if(!mail($mailto,$label . ' Website Enquiry - ' . $subject,$message,$headers)) {
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

    }else{
        $errMsg = 'Robot verification failed, please try again.';
    }
  }else{
    $errMsg = 'Please click on the reCAPTCHA box.';
  }
}

?>