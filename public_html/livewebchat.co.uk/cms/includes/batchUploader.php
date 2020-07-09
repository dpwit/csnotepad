<?
/**
* @package BozBoz_CMS
*/



// a config file is included which sets these vars
$filePath=$filePathVar;
$fileDescription=$fileDescVar; // i.e "Files (*.swf)"
$fileTypes= $fileTypeVar; //"*.swf; *.swf" deliminated by semi colon ; 
$uploadPath=MASTERURL."/cms/".$uploadScriptPath;

?>

<?php if ($_SESSION['level']>=2) { ?>
<div style=" margin-left:auto; margin-right:auto; width:550px"> 
<div id="flashContent" ><br/><br/><br/>You will need flash player 8 or above to to view this plugin. Please upgrade your flash player and return

 </div>
  </div>
 
	<script type="text/javascript" src="<?php echo MASTERURL ;?>/cms/scripts/swfobject.js"></script>
	<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("<?php echo MASTERURL ?>/cms/swf/genericFileUploader4.swf", "", "550", "400", "6", "#615D5B");
	so.addVariable("masterUrl", "<?php echo MASTERURL; ?>"); // add Variable to a flash Movie
	so.addVariable("filePath", "<?php echo $filePath; ?>"); // add Variable to a flash Movie
	so.addVariable("fileDescription", "<?php echo $fileDescription; ?>"); // add Variable to a flash Movie
	so.addVariable("fileTypes", "<?php echo $fileTypes; ?>"); // add Variable to a flash Movie
	so.addVariable("uploadPath", "<?php echo $uploadPath; ?>"); // add Variable to a flash Movie
	
	// this variable is needed for the main file not the preloader. This is fine as the main file is loaded into the prelaoder mc

	so.addParam("wmode", "transparent");
	so.write("flashContent");
	// ]]>
	</script

><?php } else  {


echo 'no access to file browser please log in first';

} ?>