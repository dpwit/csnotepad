<?php
/**
* @package BozBoz_CMS
*/


	include 'db.php';

	function readFiles($folder) {

		$baseDir = BASEPATH.$folder;
		//NetDebug::trace("opening directory".SERVER_ROOT.$folder);
			//echo $baseDir;
		$files = array();
		
		if ($dir = opendir($baseDir)) {
			while ($file = readdir($dir)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($baseDir . "/" . $file)) {
						$files[] = $file;
					}
				}
			}
			
			closedir($dir);
			
		}else 
		{
		echo "could not open directory";
		}
		
		sort($files);	
		return $files;	
	}
	
	$fileArray = readFiles ('flv/');
	$arrayLength =  count($fileArray);

	//echo $arrayLength;
	
	//echo $fileArray[0];	echo $fileArray[1];
	
	
	for ($i = 0; $i <= $arrayLength ; $i++) {
    echo $fileArray[$i].'<br />';
}


	
?>


