<?php

session_start();
	
	date_default_timezone_set('Europe/London');
	
	define(CONTACT_PAGE,		'contact');
	define(CONTACT_SUCCESS,		'csnotepad-agreement-ta.php');
	define(CONTACT_FAIL,		'setup-questions-ta.php');
	//$mailto = 'contactus@csnotepad.co.uk';
	//$copyto = 'jim@bozboz.co.uk, webcontact@bozboz.co.uk';
	$mailto = 'rdonald@csnotepad.co.uk, wfrancis@csnotepad.co.uk, tlownds@csnotepad.co.uk, rcross@csnotepad.co.uk, darren.whatford@dpwit.co.uk';
	$email_from = 'contact@csnotepad.co.uk';


        $email;$comment;
        if(isset($_POST['email'])){
          $email=$_POST['email'];
        }
        if(isset($_POST['comment'])){
          $email=$_POST['comment'];
        } 
		else {
          header('location:' . CONTACT_SUCCESS);
        }

        $_SESSION['email'] = $email;
        
	$firstName = $_POST['first_name'];
	$businessName = $_POST['businessName'];
	$contactName = $_POST['contactName'];
	$officeAddress = $_POST['officeAddress'];
	$email = $_POST['email'];
	$addressType = $_POST['addressType'];
	$companyName = $_POST['companyName'];
	$personalAddress = $_POST['personalAddress'];
	$businessTelephone = $_POST['businessTelephone'];
	$mobileTelephone = $_POST['mobileTelephone'];
	$emailAddressCallers = $_POST['emailAddressCallers'];
	$emailAddressInternal = $_POST['emailAddressInternal'];
	$websiteAddress = $_POST['websiteAddress'];
	$websiteUpToDate = $_POST['websiteUpToDate'];
	$businessDesc = $_POST['businessDesc'];
	$callsAnswered = $_POST['callsAnswered'];
	$statusUnavailable = $_POST['statusUnavailable'];
	$emailToUse = $_POST['emailToUse'];
	$sms = $_POST['sms'];
	$staff = $_POST['staff'];
	$callPatching = $_POST['callPatching'];
	$callPatchingCont = $_POST['callPatchingCont'];
	$directions = $_POST['directions'];
	$openingTimes = $_POST['openingTimes'];
	$anyFAQS = $_POST['anyFAQS'];
	$infoFromCaller = $_POST['infoFromCaller'];
	$adviceCallers = $_POST['adviceCallers'];
	$usefulInfo = $_POST['usefulInfo'];
	$coverRequired = $_POST['coverRequired'];
	$howCalls = $_POST['howCalls'];
	$accMgrContact = $_POST['accMgrContact'];

	$_SESSION['user-feedback']['success'] = true;
	$_SESSION['user-feedback']['fields'] = $_POST;

	$file = array(
		'name' => '',
		'path' => ''
	);

	if($_SESSION['user-feedback']['success']) {
		require_once('cms/modules/phpmailer/class.phpmailer.php');
		$mail = new phpmailer();
		emailClient($mail, array(
			'companyName' => $companyName,
			'first_name' => $firstName,
			'officeAddress' => $officeAddress,
			'addressType' => $addressType,
			'personalAddress' => $personalAddress,
			'businessTelephone' => $businessTelephone,
			'mobileTelephone' => $mobileTelephone,
			'emailAddressCallers' => $emailAddressCallers,
			'emailAddressInternal' => $emailAddressInternal,
			'websiteAddress' => $websiteAddress,
			'websiteUpToDate' => $websiteUpToDate,
			'businessDesc' => $businessDesc,
			'howCalls' => $howCalls
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
		$mail->Subject = 'CSnotepad - Setup questions';
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
													<td align="center">
														<a title="Virtual Receptionist Services by CSnotepad" href="http://www.csnotepad.co.uk/"><img title="CSnotepad - Virtual Receptionist and Virtual Office Services" alt="Virtual Receptionist and other virtual office services by CSnotepad" src="http://www.csnotepad.co.uk/images/logo_dark_25.png"></a><br/>
													</td>
												</tr>
												<tr>
													<td>
														Hi {$_POST['first_name']},<br/><br/>
													</td>
												</tr>
												<tr>
													<td style="border-top: 2px #7bceeb solid; padding-top: 20px;">
														<strong>CSnotepad - Setup questions</strong><br/><br/>
													</td>
												</tr>
												<tr>
													<td>
														Thanks for completing your setup questions.
														<br>
														<br>
														We've received them successfully.
														<br>
														<br>
														Should we have any questions we'll be in touch and thank you for choosing CSnotepad.
													</td>
												</tr>
												<tr>
													<td>
														Kind regards,
													</td>
												</tr>
											</table>
											<table  style="font-size: 14px; font-family: Arial" cellspacing="5">
												<tr>
													<td width="35%">
														Troy Lownds
													</td>
													<td width="5%" style="padding-left: 20px;">
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
													<td width="5%" style="padding-left: 20px;">
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
		$mail->Subject = 'Setup questions - Answers';
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
					<tr><td colspan="2">You have received some answers to the setup questions.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td><strong style="font-weight: bold;">Company name:</strong></td><td>{$values['companyName']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Contact name:</strong></td><td>{$values['first_name']}</td></tr>
					<tr><td><strong style="font-weight: bold;">What's your office address:</strong></td><td>{$values['officeAddress']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Physical, Virtual or Home:</strong></td><td>{$values['addressType']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Personal address:</strong></td><td>{$values['personalAddress']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Business telephone:</strong></td><td>{$_POST['businessTelephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Mobile telephone:</strong></td><td>{$_POST['mobileTelephone']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Email address for callers:</strong></td><td>{$_POST['emailAddressCallers']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Email address for internal:</strong></td><td>{$_POST['emailAddressInternal']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Website address:</strong></td><td>{$_POST['websiteAddress']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Up to date?:</strong></td><td>{$_POST['websiteUpToDate']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Description of business:</strong></td><td>{$_POST['businessDesc']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Calls answered?:</strong></td><td>{$_POST['callsAnswered']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Unavailable status:</strong></td><td>{$_POST['statusUnavailable']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Email to use:</strong></td><td>{$_POST['emailToUse']}</td></tr>
					<tr><td><strong style="font-weight: bold;">SMS:</strong></td><td>{$_POST['sms']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Staff:</strong></td><td>{$_POST['staff']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Call patching:</strong></td><td>{$_POST['callPatching']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Call patching cont:</strong></td><td>{$_POST['callPatchingCont']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Directions:</strong></td><td>{$_POST['directions']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Any FAQs:</strong></td><td>{$_POST['anyFAQS']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Info obtained from caller:</strong></td><td>{$_POST['infoFromCaller']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Advise callers:</strong></td><td>{$_POST['adviceCallers']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Other useful info:</strong></td><td>{$_POST['usefulInfo']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Cover required:</strong></td><td>{$_POST['coverRequired']}</td></tr>
					<tr><td><strong style="font-weight: bold;">How your calls will reach us:</strong></td><td>{$_POST['howCalls']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Account Manager to contact:</strong></td><td>{$_POST['accMgrContact']}</td></tr>
					<tr><td><strong style="font-weight: bold;">Setup questions came from:</strong></td><td>{$_SERVER['HTTP_REFERER']}</td></tr>
				</table>
			</body>
HTML;

		$mail->Send();
	}
	header('location: csnotepad-agreement-ta.php');
