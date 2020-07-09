<?php include("accesscontrol_check.php"); 
/**
* @package BozBoz_CMS
*/

 include_once 'includes/functions/generalFunctions.php';
 include_theme_file('init.php');
 ob_start();
 $rootpath=" " ;
 $pageType=@$_GET['pageType'];
 if (@$_POST ['pageType']) {
 
 $pageType=$_POST['pageType'];

 }
?>
