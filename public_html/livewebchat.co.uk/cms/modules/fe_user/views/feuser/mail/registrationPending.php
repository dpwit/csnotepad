<h1>Account Registered</h1>
<?
	if(Config::value('user_requires_activation')){
?>
<p>Your account must be manually approved.  You will receive an email when our administrators have checked your details</p>
<?	
	} else {
?>
	<p>Your account is now active, you can log in at http://<?=__SERVER_DOMAIN__?>/login.html</p>
<?
	}
?>
