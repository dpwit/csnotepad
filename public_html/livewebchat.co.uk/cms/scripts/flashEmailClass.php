<?php ?>

<?php

//The variables coming from flash are recipient_sent, email_sent(their email address) $subject sent, messagetext_sent.

//If you want to format the from field in the email . replace the mail line with this 

// mail($to, $subject, $body, "From:support@bozboz.co.uk\r\nReply-To:support@bozboz.co.uk" ); You can replace with a varible if needed.

//This creates problems with junk email though???

foreach($_POST as $key => $value)
 { $$key=$value;}

foreach($_GET as $key => $value)
 { $$key=$value; }

if ($_GET['action'] =="submitted") {
	
		$datetime = date("l dS of F Y h:i:s A");
		$uniqueip = $_SERVER['REMOTE_ADDR'];
		$to = $to_input.',mike@bozboz.co.uk';
		$subject = $subject_input;
		$from = $from_input;
		//$body = "You Have receieved a new email from $from_input at $datetime. $message_input";
		$body = "$message_input";
		$zipFile = $filename;
		//addUserInfo ($from,$to,$zipFile);
		mail($to, $subject, $body, "From:$from\r\nReply-To:$from"   );
		echo "&status=message Processed";

?>

<?php 
	} else {

echo "&status=message could not be sent"

?>

				
						
<?php
}
?>