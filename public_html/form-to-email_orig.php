<?php
session_start();
$accountName = $_GET['accountName'];
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$accountName = $_POST['accountName'];
$telephone = $_POST['telephone'];
$service = $_POST['service'];
$confEmail = $_POST['confEmail'];
$acAddr = $_POST['acAddr'];
$acPcode = $_POST['acPcode'];

if(IsInjected($email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'contact@csnotepad.co.uk';//<== update the email address
$email_subject = "Mailbox setup request";
$email_body = "You have received a new message from $confEmail to set up a new mailbox.\n\n".
    
    "Account name: $accountName\n".
    "Telephone: $telephone\n".
    "Conf email: $confEmail\n".
    "Account address: $acAddr\n".
    "Service: $service\n".
    "Account postcode: $acPcode\n".
    "Email: $confEmail\n".
    
$to = "darren.whatford@dpwit.co.uk, darrenwhatford@hotmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
//$headers .= "Reply-To: $email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: /html/pages/signup-mailbox-thankyou.php');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 