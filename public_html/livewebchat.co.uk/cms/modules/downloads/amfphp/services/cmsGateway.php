<?
//Include database info
include("dbconfig.php");

// Create new service for PHP Remoting as Class.
class cmsGateway {
	function cmsGateway() {
		//Define the methodTable
		NetDebug::trace("Constructed Gallery gateway");
		$this->methodTable = array(
			"insertDatabaseTable" => array(
				"description" => "Writes Flash data to mySQL",
				"access" => "remote"
			),
			"readTable" => array(
				"description" => "Read data from mySQL and pass back assoc array",
				"access" => "remote"
			),
			"readTableAsc" => array(
				"description" => "Read data from mySQL and pass back assoc array ascending Order",
				"access" => "remote"
			),
			"readWholeTable" => array(
				"description" => "read whole table not relying on actiev status",
				"access" => "remote"
			),"getChildren" => array(
				"description" => "read children data objects where parent id is specified",
				"access" => "remote"
			),
			"executeSqlStatement" => array(
				"description" => "executes any sql Statement passed in",
				"access" => "remote"
			),
			"createthumb" => array(
				"description" => "createthumb",
				"access" => "remote"
			)
	
		);
		
		//Connect to MySQL and select database
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
		$db = mysql_select_db(DB_NAME);
		//$db =mysql_select_db(DB_NAME) or die ('Page Error please Try Again: ' . mysql_error()); 
		
	}


	// doRead requests results, passes them back as a resultset which
	// comes back as an instance of mx.remoting.RecordSet
	
	
	function readTable($start, $limit,$table,$sortOrder) {
		// Create SQL query
		//$sql = sprintf("SELECT * FROM $table ORDER BY uid WHERE STATUS ='1' LIMIT %d, %d", $start, $limit);
		// Trace the query in the NetConnection debugger
		
		$sql = "SELECT * FROM $table WHERE status = '1' ORDER BY $sortOrder DESC ";
		$result = mysql_query($sql);
			if (!$result) {
			  die ('I cannot connect to the database because: ' . mysql_error()); 
			  error('A database error occurred  ');
		}
				
		NetDebug::trace($sql);
		NetDebug::trace("read Table function triggered");
		// Run query on database
		$result = mysql_query($sql);
		// Return result
		return $result;
	}
	
		function readTableAsc($start, $limit,$table,$sortOrder) {
		// Create SQL query
		//$sql = sprintf("SELECT * FROM $table ORDER BY uid WHERE STATUS ='1' LIMIT %d, %d", $start, $limit);
		// Trace the query in the NetConnection debugger
		
		$sql = "SELECT * FROM $table WHERE status = '1' ORDER BY $sortOrder ";
		$result = mysql_query($sql);
			if (!$result) {
			  die ('I cannot connect to the database because: ' . mysql_error()); 
			  error('A database error occurred  ');
		}
				
		NetDebug::trace($sql);
		NetDebug::trace("read Table function triggered");
		// Run query on database
		$result = mysql_query($sql);
		// Return result
		return $result;
	}
	
	// doRead requests results, passes them back as a resultset which
	// comes back as an instance of mx.remoting.RecordSet
	
	function getChildren($table,$uid) {
		// Create SQL query
		//$sql = sprintf("SELECT * FROM $table ORDER BY uid WHERE STATUS ='1' LIMIT %d, %d", $start, $limit);
		// Trace the query in the NetConnection debugger
		
		$sql = "SELECT * FROM $table WHERE parentUid = $uid ";
		$result = mysql_query($sql);
			if (!$result) {
			  die ('I cannot connect to the database because: ' . mysql_error()); 
			  error('A database error occurred  ');
		}
				
		NetDebug::trace($sql);
		NetDebug::trace("read children function triggered");
		// Run query on database
		$result = mysql_query($sql);
		// Return result
		return $result;
	}
	
	
	function readWholeTable($start, $limit,$table) {
		// Create SQL query
		//$sql = sprintf("SELECT * FROM $table ORDER BY uid WHERE STATUS ='1' LIMIT %d, %d", $start, $limit);
		// Trace the query in the NetConnection debugger
		
		$sql = "SELECT * FROM $table ORDER BY uid ";
		$result = mysql_query($sql);
			if (!$result) {
			  die ('I cannot connect to the database because: ' . mysql_error()); 
			  error('A database error occurred  ');
		}
				
		NetDebug::trace($sql);
		NetDebug::trace("read Whole Table function triggered");
		// Run query on database
		$result = mysql_query($sql);
		// Return result
		return $result;
	}
	
	function insertDatabaseTable ($table,$SqlObjectArray) {
	NetDebug::trace("Insert Data into".$table);
	//get a string of all the keys from the SqlObjectArray to be used in sql Statement (object property names in flash)
	$string ="";
	$dataIn ="";
	while( $element = each( $SqlObjectArray ) )
	{
	 $string .=  $element[ 'key' ].",";
	 $dataIn .= "'".$element[ 'value' ]."',";
	}
	//trim the last comma 	
	$trimmedKeys = htmlspecialchars (substr($string, 0, -1));  
	$trimmedValues = htmlspecialchars (substr($dataIn, 0, -1));  
	
	//get a string of all the values from the array **object property values in flash
	//$values =  associativeArrayToString ($SqlObjectArray,'value');
	//$sql_newItem  = "INSERT INTO $table ( title ) VALUES ( 'hello' )";
	$sql_newItem  = "INSERT INTO $table ( $trimmedKeys ) VALUES ( $trimmedValues )";
	NetDebug::trace("SQL WILL BE ".$sql_newItem);
	$sql_uid  = "SELECT LAST_INSERT_ID()";
	$result = mysql_query($sql_newItem);
	return mysql_insert_id();
	}
	
	function executeSqlStatement ($sql) {

	NetDebug::trace("SQL Statement will be BE ".$sql);
	$result = mysql_query($sql);
	return $result;
	
	}
	
		/*
	Function createthumb($name,$filename,$new_w,$new_h)
	creates a resized image
	variables:
	$name		Original path to filename
	$filename	path and Filename of the resized image 
	$new_w		width of resized image
	$new_h		height of resized image
	*/	
	
	function createthumb($name,$filename,$new_w,$new_h)
	{
		NetDebug::trace("Creating Thumb for ".SERVER_ROOT.$name);
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
			imagejpeg($dst_img,SERVER_ROOT.$filename, 100); 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	}
	
	// escape is a private method used for escaping strings before putting them
	// in the db. Otherwise you will have issues with ' (quotes). 
	// You don't have to declare it in the methodTable since you
	// won't call it remotely. mysql_real_escape_string is considered more
	// secure than addslashes. You might want to do sanity check here too.
	function escape($string)
	{
		return mysql_real_escape_string(htmlspecialchars($string));
	}
}
?>
