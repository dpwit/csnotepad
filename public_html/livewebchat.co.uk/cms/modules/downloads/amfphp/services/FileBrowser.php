<?php 
//Include database info and other Static Vars
include("dbconfig.php");

// Create new service for PHP Remoting as Class.
class FileBrowser {

	//------------------------------------
	// Constructor Function
	//------------------------------------

	function FileBrowser() {
		//Define the methodTable
		NetDebug::trace("Constructed File gateway");
		$this->methodTable = array(
			
			"readFiles" => array(
				"description" => "Read data from mySQL and pass back assoc array",
				"access" => "remote"
			),"deleteFiles" => array(
				"description" => "delete",
				"access" => "remote"
			),"getFileSize" => array(
				"description" => "delete",
				"access" => "remote"
			),"getFileStats" => array(
				"description" => "full fstat as assoc array",
				"access" => "remote"
			),"readFilesAdv" => array(
				"description" => "read files + filesize",
				"access" => "remote"
			),"getSpace" => array(
				"description" => "read files + filesize",
				"access" => "remote"
			),"getFolders" => array(
				"description" => "read files + filesize",
				"access" => "remote"
			),"getFileTotalSize" => array(
				"description" => "return total folder Size",
				"access" => "remote"
			)
		);
		
	
	}
	
	
	//------------------------------------
	// Read a Folder
	//------------------------------------
	
	function getFolders($baseDir) {

	$folders = array();
	$target = SERVER_ROOT.$baseDir;
	NetDebug::trace("opening directory".$target);
	if ($dir = opendir($target)) {
		while ($file = readdir($dir)) {
			//if ($file != "." && $file != "..") {
				if (is_dir($target . "/" . $file)) {
					$folders[] = $file;	
				}								
			//}
		}
			closedir($dir);
	
	}else {
	NetDebug::trace("an error occured");
	}
		
	sort($folders);
	NetDebug::trace("folders".$folders);
	return $folders;
	
	}
	
	//------------------------------------
	// Read a File
	//------------------------------------
	
	function readFiles($folder) {

		$baseDir = SERVER_ROOT.$folder;
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
		NetDebug::trace("could not open directory");
		}
		
		sort($files);	
		return $files;	
	}
	
	//-----------------------------------------
	// Read a File Advanced - returns file info
	//----------------------------------------

	
	function readFilesAdv ($folder) {

		$baseDir = SERVER_ROOT.$folder;
		NetDebug::trace("reading files advanced".SERVER_ROOT.$folder);
		$files = array();
		
		if ($dir = opendir($baseDir)) 
		{
			while ($file = readdir($dir)) 
			{
			  if ($file != "." && $file != ".." && $file != "") 
			  {
				if (!is_dir($baseDir . "/" . $file)) 
				{
				$fileInfo = array();
				//filename
				$fileInfo['fileName']= $file;
				//filesize
				$fileInfo['fileSize']= filesize(SERVER_ROOT.$folder.$file);
				//filedate
				$fileInfo['fileDate']= date("F d Y H:i:s.", filectime(SERVER_ROOT.$folder.$file));
				$files[] = $fileInfo;
			  	}
			}
		}
			
		closedir($dir);
			
		}else 
		{
		NetDebug::trace("could not open directory");
		}
		
		sort($files);	
		return $files;	
	}

	
	//------------------------------------
	// Delete a file
	//------------------------------------
	
	function deleteFiles ($file) 
	{
	NetDebug::trace("deleting".$file);
	$success = unlink(SERVER_ROOT.$file);
	return $success;
	}
	
	//------------------------------------
	// Gets File Size
	//------------------------------------
	
	function getFileSize ($file)
	{
	NetDebug::trace("fetching fileSize for ".$file);
	$file = SERVER_ROOT.$file;
	$filesize = filesize($file);
	return $filesize;
	}
	
	//------------------------------------
	// Gets all stats on a file
	//------------------------------------
	
	function getFileStats ($file)
	{
	NetDebug::trace("fetching stats for ".$file);
	$file = SERVER_ROOT.$file;
	// open a file
	$fp = fopen($file, "r");
	// gather statistics
	$fstat = fstat($fp);
	// close the file
	fclose($fp);
	return $fstat;
	}
	
	
	//------------------------------------
	// Gets all stats on a file
	//------------------------------------
	
	function getSpace ($path)
	{
	$df = disk_free_space (SERVER_ROOT.$path);
	$dt = disk_total_space(SERVER_ROOT.$path);
	return $df;
	
	}
	
}
?>
