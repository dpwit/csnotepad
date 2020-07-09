<?php include("accesscontrol_check.php"); 
/**
* @package BozBoz_CMS
*/

 include("header.php"); 
 $rootpath=" " ;
 $pageType=$_GET['pageType'];
?>
			
<!-- Start of Body -->
			

<?php if ($_SESSION['level']>=1) {?>
 		
 <?php 
 
 
  //$docFolder  to specify folder to view
 $docFolder =$folder.'/';
 include 'scripts/fileBrowser.php';

 
 ?>
	 
			
 <!-- End of Body -->

<?php }else {?> <p>You are not authorised to view this page your level is not high enough</p> <?php }?> 


<?php include("footer.php"); ?>  

</body>
</html>
