<?
//Include database info
include("dbconfig.php");

// Create new service for PHP Remoting as Class.
class FileBrowser {
	function FileBrowser() {
		//Define the methodTable
		NetDebug::trace("Constructed File gateway");
		$this->methodTable = array(
			
			"readFiles" => array(
				"description" => "Read data from mySQL and pass back assoc array",
				"access" => "remote"
			),
			"deleteFiles" => array(
				"description" => "delete a file from the server",
				"access" => "remote"
			)
		);
		
		//Connect to MySQL and select database
		//$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
		//$db = mysql_select_db(DB_NAME);
		//$db =mysql_select_db(DB_NAME) or die ('Page Error please Try Again: ' . mysql_error()); 
		
	}


	// doRead requests results, passes them back as a resultset which
	// comes back as an instance of mx.remoting.RecordSet
	
	
	function readFiles($folder) {
		// Create SQL query
		//$sql = sprintf("SELECT * FROM $table ORDER BY uid WHERE STATUS ='1' LIMIT %d, %d", $start, $limit);
		// Trace the query in the NetConnection debugger
		//NetDebug::trace("read Table function triggered");
		// Run query on database
		// Return result
		//$result = $folder;
		//return $result;
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
			
		}else {
		
		NetDebug::trace("could not open directory");
		return "failed to open directory";	
		
		}
		
		sort($files);	
		
		return $files;	
		
	}
	
		
	function deleteFiles($file) {

		NetDebug::trace("deleting a file".SERVER_ROOT.$file);
		$success = unlink(SERVER_ROOT.$file);
			if (!$success) return false;			
		}
		
		return true;
	
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
	
	
	
}
?>
