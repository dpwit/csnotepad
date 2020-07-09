

<?php  include("../wysiwyg/fckeditor.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>FCKeditor - Sample</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex, nofollow">
		<link href="../sample.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	

<?php 
if ($_POST['action'] == "submitted") {

if ( isset( $_POST ) )
   $postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
   $postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	if ( get_magic_quotes_gpc() )
		$postedValue = htmlspecialchars( stripslashes( $value ) ) ;
	else
		$postedValue = htmlspecialchars( $value ) ;

?>
			<tr>
				<td valign="top" nowrap><b><?=$sForm?></b></td>
				<td width="100%"><?=$postedValue?></td>
			</tr>
			
			
	 <?php } ?>	
<?php
		
} else { 

echo "hello";
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" target="_blank">
<input type="hidden" name="action" value="submitted">
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:


$sEnterMode ='br';
$sShiftEnterMode ='br';
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->Width = "250" ; // 250 pixels
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->BasePath = '' ;	// '/fckeditor/' is the default value.
//$oFCKeditor->Config["EnterMode"]= sEnterMode ;
//$oFCKeditor->Config["ShiftEnterMode"]	= sShiftEnterMode ;
$oFCKeditor->Value		= 'This is some <strong>sample text</strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor</a>.' ;
$oFCKeditor->Create() ;
?>
			<br>
			<input type="submit" value="Submit">
		</form>
	
		
<?php } ?>

	
	
	

	</body>
</html>