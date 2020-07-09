	<!-- HERE IS WHERE THE FILE IS UPLOADED THIS SCRIPT MAY NEED SOME TWEAKING -->	
	<?php //original URL: http://www.zend.com/zend/spotlight/uploading.php?article=uploading&kind=sl&id=8678&open=1&anc=0&view=1 
	echo '<p>';
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
	

	<?php 

   	// this should be set outside script ... $uploadpath =  "/home/blah/public_html/images/news/originals/";
    $source = $HTTP_POST_FILES['file1']['tmp_name']; 
    $fileName = $HTTP_POST_FILES['file1']['name'];

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

    echo '<BR> File extension renamed <BR>'; 
	$dest = $uploadpath.$fName.'.jpg'; 
	$fileName = $fName.'.jpg'; 
    break; 

    case 'gif': 
    echo '<BR> Please note the Image was a GIF file and this is not allowed <BR>'; 
    $dest = '';
    break; 
	
	case 'png': 
    echo '<BR> Image is a .png file <BR>'; 
	$dest = $uploadpath.$fileName;  
    break; 
             
    case 'jpg': 
    echo '<BR> Image is a .jpg file <BR>'; 
	$dest = $uploadpath.$fileName;  
	break; 
	
	default:
    echo '<BR> I do not recognise this type of file. It will not be uploaded<BR>'; 
	  $dest = '';
	break; 
          
    
   }
	   
   //echo $dest;	  
   if ( $dest != '') 
   { 
       if ( move_uploaded_file( $source, $dest ) ) 
		   { 
		   echo 'File successfully stored for moderation<BR>'; 
		   //echo '$dest'."destination"; 
		   //echo "destination is ".$dest;
		   //echo "fileName is ".$fileName."im in the file upload script";
		   } else 
		   { 
		   echo 'File could not be stored.<BR>'; 
		   } 
       }  

    } else { 
        //echo 'image was not included , or file too big. No Image was uploaded<BR>'; 
		$dest ="undefined";

    } 

?> 

<?php  

 

?>