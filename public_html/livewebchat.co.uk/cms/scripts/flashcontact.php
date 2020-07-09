<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>

</head>

<?php 
foreach($_POST as $key => $value)
 { $$key=$value;}

foreach($_GET as $key => $value)
 { $$key=$value; }

?>

&nbsp;
<div class="main" style="" >

<!--start content input -->


<?php  if ($action == "submitted") {?>

<?php

$datetime = date("l dS of F Y h:i:s A");
$uniqueip = $_SERVER['REMOTE_ADDR'];
//$to = $to_input; //uncomment if you want to pass to email from flash
$to = "tg1210@hotmail.com, management@slackersconvention.com,";
$subject = $subject_input;
$from = $from_input;

$body = "You have recieved a message from the website \n  Subject is  $subject their email address was $from. \n\n Their message is $message_input";

		mail($to, $subject, $body, "From:$from\r\nReply-To:$from"   );
		echo "success";
?>

<?php 
	} else {
?>

		<div style=" padding-left:50px; padding-top:30px"> 

		 <form name="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" > 
		 <input type="hidden" name="action" value="submitted">
			
			
							<div style=" margin-left:70px;"> 
							
							   <table style="padding-top:20px; padding-bottom:0px; font-weight:bold; ">    
								<tr height="30">
								<td class="title1" align="right" > Email Address:</td>
								<td> <input type="text" class="formbox" name="from_input" value="" size="40"> </td>
								</tr>
								
								<tr height="30">
									<td class="title1" align="right"> Subject :	</td>
									<td> <input type="text" name="subject_input" class="formbox" value="" size="40"> </td>
								</tr>
								
																					
								<tr height="30" >
									<td class="title1" align="right" valign="top"   style=" padding-top:8px; margin-top:10px;">
										Message : </td>
									<td  style=" padding-top:8px; margin-top:10px;" > 
										<textarea name="message_input" class="formbox" cols="60" rows="10"></textarea>
										<div style=" padding-bottom:0px; padding-left:217px; margin-top:5px; border: 0px solid #000000;">
									<input type="submit" name="submit" class="formbox" value="submit"> 
									</form> </div>
									</td>
								</tr>
								
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								</table>
							
							
							</div></div>
							
					
<?php
}
?>

</div>




