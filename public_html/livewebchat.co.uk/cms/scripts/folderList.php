<?php
/**
* @package BozBoz_CMS
*/


	include 'db.php';

	function readFiles($folder) {

		$baseDir = BASEPATH.$folder;
		NetDebug::trace("opening directory".SERVER_ROOT.$folder);
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
		//NetDebug::trace("could not open directory");
		}
		
		sort($files);	
		return $files;	
	}
	
	echo readFiles ('flv')
	
?>


