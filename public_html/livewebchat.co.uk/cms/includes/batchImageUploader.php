<?
/**
* @package BozBoz_CMS
*/

// a config file is included which sets max imagesize etc
$filePath='images/originals/';
$finalPath='images/'.$pageType.'/'; 
$thumbPath='images/'.$pageType.'/thumbs/' ;
$uploadPath=MASTERURL."/cms/".$uploadScriptPath;
$thumbMaxSize = $thumbMaxSizeVar;
$imageMaxSize = $imageMaxSizeVar;
$imageQuality= $imageQualityVar;
$thumbQuality= $thumbQualityVar;
$imageDatabaseTable=$pageType;
$categoryDatabaseTable= $pageType."Ids";

?>

<?php if ($_SESSION['level']>=2) { ?>
 <div style=" margin-left:auto; margin-right:auto; width:550px"> 
<div id="flashContent" margin-left:auto; margin-right:auto;   ><br/><br/><br/>You will need flash player 8 or above to to view this plugin. Please upgrade your flash player and return

 </div>
</div>
	<script type="text/javascript" src="<?php echo MASTERURL ;?>/cms/scripts/swfobject.js"></script>
	<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("<?php echo MASTERURL ?>/cms/swf/batchImageUploader5.5.swf", "", "550", "400", "6", "#615D5B");
	so.addVariable("masterUrl", "<?php echo MASTERURL; ?>"); // add Variable to a flash Movie
	so.addVariable("filePath", "<?php echo $filePath; ?>"); // add Variable to a flash Movie
	so.addVariable("finalPath", "<?php echo $finalPath; ?>"); // add Variable to a flash Movie
	so.addVariable("thumbPath", "<?php echo $thumbPath;?>"); // add Variable to a flash Movie
	so.addVariable("uploadPath", "<?php echo $uploadPath;?>"); // add Variable to a flash Movie
	so.addVariable("thumbMaxSize", "<?php echo $thumbMaxSize ?>"); // add Variable to a flash Movie
	so.addVariable("imageMaxSize", "<?php echo $imageMaxSize;?>"); // add Variable to a flash Movie
	so.addVariable("imageQuality", "<?php echo $imageQuality ?>"); // add Variable to a flash Movie
	so.addVariable("thumbQuality", "<?php echo $thumbQuality;?>"); // add Variable to a flash Movie
	so.addVariable("imageDatabaseTable", "<?php echo $imageDatabaseTable ?>"); // add Variable to a flash Movie
	so.addVariable("categoryDatabaseTable", "<?php echo $categoryDatabaseTable;?>"); // add Variable to a flash Movie
	// this variable is needed for the main file not the preloader. This is fine as the main file is loaded into the prelaoder mc

	so.addParam("wmode", "transparent");
	so.write("flashContent");
	// ]]>
	</script

><?php } else  {


echo 'no access to file browser please log in first';

} ?>