<?
//Include database info
include("dbconfig.php");

// Create new service for PHP Remoting as Class.
class DbList {
	function DbList() {
		//Define the methodTable
		NetDebug::trace("COnstructed");
		$this->methodTable = array(
			"doPost" => array(
				"description" => "Writes Flash data to mySQL",
				"access" => "remote"
			),
			"readTable" => array(
				"description" => "Read data from mySQL and pass back assoc array",
				"access" => "remote"
			)
		);
		
		//Connect to MySQL and select database
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
		$db = mysql_select_db(DB_NAME);
		//$db =mysql_select_db(DB_NAME) or die ('Page Error please Try Again: ' . mysql_error()); 
		
	}

	// Do post take an associative array (an Object in Flash) and puts
	// the values in the array into the database. Returns an associative
	// array (which comes back as an object) with a field 'status' which
	// outlines the success or failure of the insertion into the database.
	function doPost($in) {
		// Create SQL statement
		$sql = sprintf("INSERT INTO links VALUES ( NULL, '%s', '%s', '%s', '%s', NOW() )",
				$this->escape($in['name']) , 
				$this->escape($in['email']) , 
				$this->escape($in['theurl']) ,
				$this->escape($in['message']) );
		// Trace the query in the NetConnection debugger
		NetDebug::trace($sql);
		// Run query on database
		$result = mysql_query($sql);
		// Check to see if the query did what it should have and return
		if (mysql_affected_rows() == 1) {
			return array("status" => "success");
		} else {
			return array("status" => "fail");
		}
	}
	
	// doRead requests results, passes them back as a resultset which
	// comes back as an instance of mx.remoting.RecordSet
	
	
	function readTable($start, $limit,$table) {
		// Create SQL query
		$sql = sprintf("SELECT * FROM $table ORDER BY uid LIMIT %d, %d", $start, $limit);
		// Trace the query in the NetConnection debugger
		NetDebug::trace($sql);
		NetDebug::trace("function triggered");
		// Run query on database
		$result = mysql_query($sql);
		// Return result
		return $result;
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
