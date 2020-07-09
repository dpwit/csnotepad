<?php

#handle post, check for form submittion key and send email

$module_path = '/home/csnotepa/public_html/ext/modules/questionnaire_ext/';

require_once $module_path.'class.phpmailer.php';

$header = 'Thank you';
$text_body = 'You have sucessfully submited your form to us, one of our team members will be in contact in regards to your order.';

if($_REQUEST['post_key']=='questionnariesubmit'){

	$order =  Model::loadModel('order')->getFirst(array('uid'=>$_POST['orderuid']));

	$exclude = array('PHPSESSID','__utma','__utmb','__utmc','__utmz','output','post_key','orderuid','is_returning');

	$message = '<p>This is an automated email from csnotepad.co.uk. The questionnarie has been filled out, please see below:</p>';
	$message .= '<table border="1">';
	foreach($_REQUEST as $key => $post){

		if(in_array($key,$exclude)){continue;}

		if(is_array($post)){$post=implode(" / ", $post);}

		$message .= '<tr>';
			$message .= '<td style="text-align:right">'.$key.': </td>';
			$message .= '<td> '.$post.'</td>';
		$message .= '</tr>';
	}
	$message .= '</table>';

	$mail = new PHPMailer(true);
	try {
		$mail->AddReplyTo(Config::value('contact_email','site'), 'csnotepad');
		$mail->SetFrom(Config::value('contact_email','site'), 'csnotepad');

		$mail->AddAddress(Config::value('contact_email','site'));
		#$mail->AddAddress('adam@bozboz.co.uk');

		$mail->Subject = "Order: {$order->uid} Information form";

		$mail->MsgHTML($message);
		if($imgfile){
			$mail->AddAttachment($imgfile);
		}

		$mail->Send();

		if($imgfile){
			unlink($imgfile);
		}
	} catch (Exception $e) {
		$header = 'Submit failed.';
		$text_body = 'There has been a problem submitting your form to us, if this persists please call us on 01273 741 400.';
	}

}else{
	$header = 'Submit failed';
	$text_body = 'There has been a problem submitting your form to us, if this persists please call us on 01273 741 400.';
}

?>

<h1><?=$header;?></h1>

<p><?=$text_body;?></p>

<br/>
<br/>