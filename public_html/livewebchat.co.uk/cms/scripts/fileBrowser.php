<?
/**
* @package BozBoz_CMS
*/



if (!$uploadDir)

{

$uploadDir ="images/";
}
?>
<?php if ($_SESSION['level']>=2) { ?>
           

<div id="flashContent" ><br/><br/><br/>You will need flash player 8 or above to to view this plugin. Please upgrade your flash player and return

 </div>
 
	<script type="text/javascript" src="<?php echo MASTERURL ;?>/cms/scripts/swfobject.js"></script>
	<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("<?php echo MASTERURL ?>/cms/swf/batchUploader1.swf", "", "650", "400", "8", "#615D5B");
	so.addVariable("masterUrl", "<?php echo MASTERURL ?>"); // add Variable to a flash Movie
	so.addVariable("innitFolder", "<?php echo $docFolder;?>"); // add Variable to a flash Movie
	// this variable is needed for the main file not the preloader. This is fine as the main file is loaded into the prelaoder mc
	//so.addVariable("initPage", "<?php echo $pageName;?>"); // add Variable to a flash Movie
	so.addParam("wmode", "transparent");
	so.write("flashContent");
	// ]]>
	</script

><?php } else  {


echo 'no access to file browser please log in first';

} ?>