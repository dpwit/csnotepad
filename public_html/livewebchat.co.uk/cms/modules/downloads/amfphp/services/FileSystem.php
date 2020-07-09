<?

include("dbconfig.php");

// Create new service for PHP Remoting as Class.
class FileSystem {
	function FileSystem() {
		//Define the methodTable
		NetDebug::trace("Constructed FileSystem");
		$this->methodTable = array(
			"fileExists" => array(
				"description" => "checks if a file exists",
				"access" => "remote"
			),"createThumb" => array(
				"description" => "creates a resized Image and saves",
				"access" => "remote"
			)
		);
		
		; 
		
	}

	// checks if a file exists on the server and returns a 1 if true
	
	function fileExists($filename) {
		// Create SQL statement
	if (file_exists(SERVER_ROOT.$filename))
	{
	return 1;
	NetDebug::trace("file exists".SERVER_ROOT.$filename);
	}
	else
	{
	return 0;
	NetDebug::trace("file does not exist".SERVER_ROOT.$filename);
	}
	
	}
	
		/*
	Function createthumb($name,$filename,$new_w,$new_h)
	creates a resized image
	variables:
	$name		Original path to filename
	$filename	path and Filename of the resized image 
	$new_w		width of resized image
	$new_h		height of resized image
	$quality    qulaity of the new thumb
	*/	
	
	function createThumb($name,$filename,$new_w,$new_h,$quality)
	{
		NetDebug::trace("Creating Thumb for ".SERVER_ROOT.$name."quality will be " .$quality);
		$system=explode(".",SERVER_ROOT.$name);
		if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg(SERVER_ROOT.$name); //echo "it is a jpg";
		}
		if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng(SERVER_ROOT.$name);}
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		//echo "old X".$old_x;
			
		if ($old_x > $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y) 
		{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
		$test = imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		//echo $test;
		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,SERVER_ROOT.$filename); 
		} else {
			imagejpeg($dst_img,SERVER_ROOT.$filename, $quality); 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	}

}
?>
