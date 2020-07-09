<?php
/**
* @package BozBoz_CMS
*/


include '../db.php';

//$fileName = basename($_FILES["Filedata"]["name"]);
//$uploadpath =  BASEPATH.'images/originals/';	
//$uploadFile =  $uploadpath.$fileName;


/*if (move_uploaded_file($_FILES["Filedata"]["tmp_name"], $uploadFile)) {

	//chmod(dirname(__FILE__) . "/" . $uploadFile, 0777);
	
	if (isset($_GET["thumbDir"])) {	
		$thumbName = $_GET["thumbPrefix"] . substr_replace($fileName, $_GET["thumbSuffix"], strrpos($fileName, "."), 0);
		createThumb($uploadFile, $_GET["uploadDir"] . $_GET["thumbDir"] . $thumbName, $_GET["w"], $_GET["h"]);
	}
	
	echo '1';
	
} else {

	echo '0'.'path='.uploadpath.'uploadfile='.uploadFile.'filename='.fileName;
	
}*/


?>

	
<?php 

   	// this should be set outside script ... $uploadpath =  "/home/blah/public_html/images/news/originals/";
    $uploadpath =  BASEPATH.'images/originals/';
	$source = $HTTP_POST_FILES['Filedata']['tmp_name']; 
    $fileName = $HTTP_POST_FILES['Filedata']['name'];

    $dest = ''; 

    if ( ($source != 'none') && ($source != '' )) 
	{ 
	//get the file extension
	//get all info about file
	$path_parts = pathinfo($fileName);
	$ext = $path_parts['extension'];
	$fName = strip_ext ($fileName);

	//echo 'Extension of the file uploaded is '.$ext .'<br/>';
	//echo 'Name of the file uploaded is '.$fName.'<br/>';
	
	switch ($ext ) { 

    case 'JPG': 

    //echo '<BR> File extension renamed <BR>'; 
	$dest = $uploadpath.$fName.'.jpg'; 
	$fileName = $fName.'.jpg'; 
    break; 

    case 'gif': 
    //echo '<BR> Please note the Image was a GIF file and this is not allowed <BR>'; 
    $dest = '';
    break; 
	
	case 'png': 
    //echo '<BR> Image is a .png file <BR>'; 
	$dest = $uploadpath.$fileName;  
    break; 
             
    case 'jpg': 
    //echo '<BR> Image is a .jpg file <BR>'; 
	$dest = $uploadpath.$fileName;  
	break; 
	
	default:
   // echo '<BR> I do not recognise this type of file. It will not be uploaded<BR>'; 
	  $dest = '';
	break; 
          
    
   }
	   
   //echo $dest;	  
   if ( $dest != '') 
   { 
       if ( move_uploaded_file( $source, $dest ) ) 
		   { 
		    // echo 'File successfully stored for moderation<BR>'; 
		   //echo '$dest'."destination"; 
		   //echo "destination is ".$dest;
		   //echo "fileName is ".$fileName."im in the file upload script";
		   
		  // if (isset($_GET["thumbDir"])) {	
		//$thumbName = $_GET["thumbPrefix"] . substr_replace($fileName, $_GET["thumbSuffix"], strrpos($fileName, "."), 0);
		//createThumb($uploadFile, $_GET["uploadDir"] . $_GET["thumbDir"] . $thumbName, $_GET["w"], $_GET["h"]);
		//}
		echo '1';
		
		} else 
		   { 
		   //echo 'File could not be stored.<BR>'; 
		   echo '0'.'path='.uploadpath.'uploadfile='.uploadFile.'filename='.fileName;
		   } 
       }  

    } else { 
        echo 'image was not included , or file too big. No Image was uploaded<BR>'; 
		$dest ="undefined";

    } 

?> 







<?php 

// returns the basepart of a fileName
	function strip_ext($name) 
    { 
       $ext = strrchr($name, '.'); 
       if($ext !== false) 
       { 
           $name = substr($name, 0, -strlen($ext)); 
      } 
       return $name; 
    } 
	
?>

<?

function createThumb($sourceUrl, $targetUrl, $w, $h) {

	$ext = strrchr($sourceUrl, ".");
	
	if ($ext == ".jpg" || $ext == ".jpeg" || $ext == ".JPG" ) {
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
	
	if ($ext == ".jpg" || $ext == ".jpeg" || $ext == ".JPG") {
		imagejpeg($targetPic, $targetUrl); 
	} else if ($ext == ".png") {
		imagepng($targetPic, $targetUrl);
	}
	
	imagedestroy($targetPic); 
	imagedestroy($sourcePic);

}

?>