<?php

#handle post, check for form submittion key and send email


if($_REQUEST['post_key']=='requestcallback'){

$order =  Model::loadModel('order')->getFirst(array('uid'=>$_POST['order_uid']));

	$message = "
	<p>This is an automated email from csnotepad.co.uk. A callback has been requested, please see the details below:</p>

	<ul>
		<li>Order ref: ".$order->uid."</li>
		<li>Name: ".$order->customer_title." ".$order->customer_firstname." ".$order->customer_lastname."</li>
		<li>Contact Number: ".$order->customer_phone."</li>
	<ul>
	";

	$subject = "Order: {$order->uid} Requested a callback";
	$to = Config::value('contact_email','site');

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: csnotepad '.Config::value('contact_email','site') . "\r\n";

	mail($to, $subject, $message, $headers);

	$header = 'Thank you';
	$text_body = 'You have requested a call back from one of our team, we will be in contact shortly at your preferred
	contact time.';
}else{
	$header = 'Request failed';
	$text_body = 'There has been a problem making a callback request, if this persists please call us on 01273 741 400.';
}

?>

<h1><?=$header;?></h1>

<p><?=$text_body;?></p>

<br/>
<br/>