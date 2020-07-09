<?php

//Include database info
//include("dbconfig.php");


class FileBrowser {


	function FileBrowser() {
	
	
		NetDebug::trace("opening class";
		$this->methodTable = array(
		
			"getFolders" => array(
				"description" => "",
				"access" => "remote"//,
				//"roles" => "admin"
            ),
		
 			"getFiles" => array(
				"description" => "",
				"access" => "remote"//,
				//"roles" => "admin"
            ),
            
            "deleteFiles" => array(
				"description" => "",
				"access" => "remote"//,
				//"roles" => "admin"
            ),
            
            "getNonusedFiles" => array(
				"description" => "",
				"access" => "remote"//,
				//"roles" => "admin"
            ) 				
								
		);		
	}
	
	
	function getFolders($baseDir) {

		$folders = array();
		NetDebug::trace("opening directory");
		if ($dir = opendir(SERVER_ROOT.$baseDir)) {
			while ($file = readdir($dir)) {
				if ($file != "." && $file != "..") {
					if (is_dir($baseDir . "/" . $file)) {
						$folders[] = $file;	
					}								
				}
			}
			
			closedir($dir);
			
		}
		
		sort($folders);
		
		return $folders;
	
	}
	
	
	function getFiles() {
		NetDebug::trace("opening directory");
		/*$files = array();
		
		if ($dir = opendir($baseDir)) {
			while ($file = readdir($dir)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($baseDir . "/" . $file)) {
						$files[] = $file;
					}
				}
			}
			
			closedir($dir);
			
		}
		
		sort($files);	
		
		return $files;	*/
		return "fucksake ";
	
	}
	
	
	function deleteFiles($path, $files) {
	
		foreach($files as $file) {		
			$success = unlink($path . $file);
			if (!$success) return false;			
		}
		
		return true;
	
	}
	
	
	function getNonusedFiles($uploadFolder, $selectedFolder) {
		
		return true;
	
	}
	
	
}

?> 