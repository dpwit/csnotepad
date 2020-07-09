<?
/**
* @package BozBoz_CMS
*/

if($GLOBALS['SHOW_TEMPLATE']){
	$output = ob_get_contents();
	ob_end_clean();
 	include("header.php"); 
	echo $output;
	include_theme_file('footer.php');
	ob_end_flush();
} else {
	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
}
?>
