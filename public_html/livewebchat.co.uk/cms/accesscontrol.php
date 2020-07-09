<?php session_start(); ?> 

<?php // accesscontrol.php
include_once 'common.php';
include_once 'db.php';

$uid = isset($_POST['uid']) ? $_POST['uid'] : $_SESSION['uid'];
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : $_SESSION['pwd'];

if(!isset($uid)) {
  ?>
  
<?php //$phpbb_root_path = 'forum/'; ?> 
<?php //include("phpbbfetchallcode.php"); ?> 
<?php include("header.php"); ?>  



			
<!-- Start of Body -->
			
			
			
			<div id="Main_Content_Holder" style="float:left; border-right: 5px solid #0F7EB3; width:750px; height:500px; ">
			
																
								<div id="Main_content" class="noscroll" style="height:490px; width:730px; margin-left:20px; margin-right:10px; " align="center"> 
								
								<p><span style="padding-top:300px;">&nbsp </span></p>
								
								
													
								 <form method="post" action="<?=BASEURL?><?=$_SERVER['PHP_SELF']?>">
							 
										 <table width="200" border="0" cellspacing="10">
										  <tr>
											<td class=" title1 ">User ID:</td>
											<td><input class=" formbox " type="text" name="uid" size="15" /></td>
										  </tr>
										  <tr>
											<td class=" title1 ">Password:</td>
											<td><input class=" formbox " type="password" name="pwd" SIZE="15" /></td>
										  </tr>
										  
										  <tr>
											<td></td>
											<td align="right"><input type="submit"  class=" formbox "value="Log in" /></td>
										  </tr>
										</table> 
						
						   </form>
								
								
								
								 </div>

 			 </div>
			 
			
 <!-- End of Body -->
 


<?php //include("footer.php"); ?>  

</body>
</html>

  <?php
  exit;
}

$_SESSION['uid'] = $uid;
$_SESSION['pwd'] = $pwd;
$_SESSION['newpass'] = $newpass;

dbConnect();
$sql = "SELECT * FROM user WHERE userid = '$uid' AND password = '$pwd'";
		
$result = mysql_query($sql);

if (!$result) {

  die ('I cannot connect to the database because: ' . mysql_error()); 


  error('A database error occurred while checking your '.
        'login details.\\nIf this error persists, please '.
        'contact you@example.com.');
}

if (mysql_num_rows($result) == 0) {
  unset($_SESSION['uid']);
  unset($_SESSION['pwd']);
  ?>
  
<?php //$phpbb_root_path = 'forum/'; ?> 
<?php //include("phpbbfetchallcode.php"); ?> 
<?php include("header.php"); ?>  



			
<!-- Start of Body -->
			
			
			
			<div id="Main_Content_Holder" style="float:left; border-right: 5px solid #0F7EB3; width:750px; height:500px; ">
			
																
								<div id="Main_content" class="noscroll" style="height:490px; width:730px; margin-left:20px; margin-right:10px; " align="center"> 
								
													
													
													
										 <h1 style="margin-top:115px; padding-left:20px;">To try logging in again, click
												 <a href="<?=$_SERVER['PHP_SELF']?>">here</a>.</h1>
			 
			
			 
										  <p style="font-weight:bold; padding-left:30px;"">Your Ip has been logged as <?php echo $_SERVER['REMOTE_ADDR']; ?></p>

								
								
								
								 </div>
			
			
			
 			 </div>
			 
			
 <!-- End of Body -->
 


<?php //include("footer.php"); ?>  





</body>
</html>



  
   
  <?php
  exit;
}

$username = mysql_result($result,0,'fullname');
$redirect = mysql_result($result,0,'redirect');
$directory = mysql_result($result,0,'directory');
$projectname= mysql_result($result,0,'projectname');
$project_ftp_user = mysql_result($result,0,'ftp_user');
$project_ftp_pass = mysql_result($result,0,'ftp_pass');
$_SESSION['level'] = mysql_result($result,0,'level');	


// echo $username;
//echo $redirect; 

?>


<head><meta HTTP-EQUIV="refresh" content="1;url=<?php echo $redirect ?>"></head>











