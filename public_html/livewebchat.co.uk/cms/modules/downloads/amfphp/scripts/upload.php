<?php

include '../services/dbconfig.php'

$fileName = basename($_FILES["Filedata"]["name"]);
$uploadpath =  SERVER_ROOT."images/gallery/originals/";	
$uploadFile =  $uploadpath.$fileName;


if (move_uploaded_file($_FILES["Filedata"]["tmp_name"], $uploadFile)) {

	//chmod(dirname(__FILE__) . "/" . $uploadFile, 0777);
	
	if (isset($_GET["thumbDir"])) {	
		$thumbName = $_GET["thumbPrefix"] . substr_replace($fileName, $_GET["thumbSuffix"], strrpos($fileName, "."), 0);
		createThumb($uploadFile, $_GET["uploadDir"] . $_GET["thumbDir"] . $thumbName, $_GET["w"], $_GET["h"]);
	}
	
	print 1;
	
} else {

	print 0;
	
}


function createThumb($sourceUrl, $targetUrl, $w, $h) {

	$ext = strrchr($sourceUrl, ".");
	
	if ($ext == ".jpg" || $ext == ".jpeg") {
		$sourcePic = imagecreatefromjpeg($sourceUrl);
	} else if ($ext == ".png") {
		$sourcePic = imagecreatefrompng($sourceUrl);
	} else {
		return;
	}
	
	$picW = imageSX($sourcePic);
	$picH = imageSY($sourcePic);	
	
	if (isset($w)) {		
		$thumbW = $w;
		$thumbH = $picH / ($picW/$thumbW);		
	} else if (isset($h)) {
		$thumbH = $h;
		$thumbW = $picW / ($picH/$thumbH);	
	}
	
	$targetPic = imagecreatetruecolor($thumbW, $thumbH);
	imagecopyresampled($targetPic, $sourcePic, 0, 0, 0, 0, $thumbW, $thumbH, $picW, $picH);
	
	if ($ext == ".jpg" || $ext == ".jpeg") {
		imagejpeg($targetPic, $targetUrl); 
	} else if ($ext == ".png") {
		imagepng($targetPic, $targetUrl);
	}
	
	imagedestroy($targetPic); 
	imagedestroy($sourcePic);

}

?>