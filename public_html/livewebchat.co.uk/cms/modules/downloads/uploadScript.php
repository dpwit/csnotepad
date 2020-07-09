<?php
/**
* @package BozBoz_CMS
*/


//include '../../requireConnections.php';
include '../../db.php';

$fileName = basename($_FILES["Filedata"]["name"]);
//$uploadpath =  BASEPATH.'files/';	
$uploadpath =  BASEPATH.$_POST['filePath'];	
$uploadFile =  $uploadpath.$fileName;

@mkdir(dirname($uploadFile),0777,true);
if (move_uploaded_file($_FILES["Filedata"]["tmp_name"], $uploadFile)) {

	//chmod(dirname(__FILE__) . "/" . $uploadFile, 0777);
	
	if (isset($_GET["thumbDir"])) {	
		$thumbName = $_GET["thumbPrefix"] . substr_replace($fileName, $_GET["thumbSuffix"], strrpos($fileName, "."), 0);
		createThumb($uploadFile, $_GET["uploadDir"] . $_GET["thumbDir"] . $thumbName, $_GET["w"], $_GET["h"]);
	}
	
	echo '1'; echo' Success. Var passed in post '.$uploadFile;
} else {

	echo '0'.'path='.$uploadpath.'uploadfile='.$uploadFile.'filename='.$fileName;
	
}

?>
