<?php session_start(); 
/**
* @package BozBoz_CMS
*/

// accesscontrol.php
$mem=ini_get('memory_limit');
if(str_replace("M","",$mem)*1<100){
ini_set('memory_limit','256M');
}
include_once 'common.php';
load_theme_hooks();
include_once 'db.php';
	cms_trigger_action('pre_access');

function logout(){
	$oldUid = $_SESSION['uid'];
	unset($_SESSION['uid']);
	unset($_SESSION['level']);
	unset($_SESSION['pwd']);
	unset($_SESSION['origpass']);
	cms_trigger_action('after_logout',$oldUid);
}

 foreach($_POST as $key => $value)
     { $$key=$value;}

 foreach($_GET as $key => $value)
     { $$key=$value; }
 if(@$logout) logout();


//commented out to allow flash login, not sure what they do exactly some checking
$uid = @$_SESSION['uid'];
$pwd = @$_SESSION['pwd'];
$loginMessage = '';
if(isset($_POST['login'])){
	$uid=$_POST['uid'];
	$pwd=$_POST['pwd'];
}
$requiresLogin = cms_apply_filter('theme_requires_login',php_sapi_name()!='cli');
if(@$_POST['login']){
//encrypt the string if this has not been done already
if (!@$_SESSION['pwd'])
{
$_SESSION['origpass'] = $pwd;
$enc= md5($pwd);
$pwd = $enc;
}

$_SESSION['uid'] = $uid;
$_SESSION['pwd'] = $pwd;
//echo $pwd.'password';

$user = Model::g('User');
try {
	$handleLogin = $user->handlesLogin();
} catch(BadRelationshipException $e){
	$handleLogin = false;
}
if($handleLogin){
	$validLogin = $user->checkLogin($_SESSION['uid'],$_SESSION['origpass']);
} else {
	$sql = "SELECT * FROM user WHERE userid = '$uid' AND password = '$pwd' AND status='1'";
	
	$result = mysql_query($sql);
	$userData = mysql_fetch_assoc($result);


	if (!$result) {

	  die ('I cannot connect to the database because: ' . mysql_error()); 


	  error('A database error occurred while checking your '.
	        'login details.\\nIf this error persists, please '.
	        'contact you@example.com.');
	}
// This allows modules to invalidate logins based on custom logic (e.g. accounts expired, bills not paid, cms down for maintenance)
$user = Model::g('User',$userData['id']);
$validLogin = $user && cms_apply_filter('validate_login',mysql_num_rows($result),$userData,$user);
}
if (!$validLogin) {
  unset($_SESSION['uid']);
  unset($_SESSION['pwd']);
  unset($uid);
  $loginMessage = 'Login Failed';
  if($requiresLogin){
  ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link href="css/style.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Login Area</title>
</head>

<body leftmargin="0" topmargin="0" bottomargin="0" marginwidth="0" marginheight="0" >

<p>&nbsp;</p>
<p>&nbsp;</p>
<div style=" width:750px; height:500px; margin-right:10px;">

<div style="height:20px; width:730px; margin-left:20px; margin-right:10px; background-color:  margin-bottom:10px; padding-right:10px;" align="right"> </div>

	<div class="noscroll" style="height:490px; width:730px; margin-left:20px; margin-right:10px; " align="center"> 
   
   
   
    <h1 style="margin-top:115px; padding-left:20px;">To try logging in again, click <a href="<?=$_SERVER['PHP_SELF']?>">here</a>.</h1>
    <p style="font-weight:bold; padding-left:30px;"">Your Ip has been logged as <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
  
  
   </div>

&nbsp;</div>


</body>
</html>
   
  <?php
  exit;
  }
}

//$username = mysql_result($result,0,'fullname');
//$redirect = mysql_result($result,0,'redirect');
//$directory = mysql_result($result,0,'directory');
//$projectname= mysql_result($result,0,'projectname');
//$project_ftp_user = mysql_result($result,0,'ftp_user');
//$project_ftp_pass = mysql_result($result,0,'ftp_pass');

if($validLogin && !$handleLogin){
	$_SESSION['level'] = mysql_result($result,0,'level');	
	cms_trigger_action('after_login',$userData);
}
//echo $_SESSION['level'].'level';
// echo $username;
//echo $redirect; 
}
if(!Model::loadModel('User')->getLoggedInUser()) {
	if(!$requiresLogin) return;
  ?>
  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link href="css/style.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Login Area</title>
<style>
<!--
body {font-family: Arial, Helvetica, sans-serif; background: #fff;}
table {border: 1px solid #ccc;}
.coolButton { background: #444; color: #FFF; font: bold 12px/15px Arial; padding: 4px 5px; border: none; text-transform: uppercase; display: inline-block; text-align: right; margin: 0 5px }
.coolButton:hover {background: #000;}

-->
</style>
</head>

<body leftmargin="0" topmargin="0" bottomargin="0" marginwidth="0" marginheight="0" >


<p>&nbsp;</p>
<p>&nbsp;</p>
<div style=" width:750px; height:500px;  margin-left:auto; margin-right:auto;">

	<div class="noscroll" style="height:500px; width:730px;  " align="center"> 
	
	 <form method="post" action="<?=BASEURL?><?=$_SERVER['PHP_SELF']?>">

<? if($loginMessage){ ?>
	<h1><?=$loginMessage?></h1>
<? } ?>
								 
	<table border="0" cellspacing="10">
	<tr>
    <td colspan="2"><img src="/images/logo.png" alt="CMS Login" style="margin: 10px"></td></tr>
    <tr>
	<td class=" title1 " align="right">User ID:</td>
	<td><input class=" formbox " type="text" style="padding: 2px" name="uid" size="23" /></td>
	</tr>
	<tr>
	<td style="padding-top: 10px" class=" title1 " align="right">Password:</td>
	<td style="padding-top: 10px"><input class=" formbox " style="padding: 2px" type="password" name="pwd" SIZE="23" /></td>
	</tr>
											  
	<tr>
	<td></td>
	<td align="right" style="padding:20px"><input type="submit"  class="coolButton formbox " name='login' value="Log in" /></td>
	</tr>
	</table> 
							
	 </form>
	</div>

</div>


</body>
</html>
 
 <?php
  exit;
}

?>
