<?
//Include database info
include("dbconfig.php");

// Create new service for PHP Remoting as Class.
class PhpList {
	function PhpList() {
		//Define the methodTable
		NetDebug::trace("Constructed PhpList gateway");
		$this->methodTable = array(
			"insertDatabaseTable" => array(
				"description" => "Writes Flash data to mySQL",
				"access" => "remote"
			),
			"phplistGetUser" => array(
				"description" => "Read data from mySQL and pass back assoc array",
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
	
	
	function phplistGetUser ($start, $userId) {
				
		$sql = "SELECT * FROM phplist_user_user WHERE email='$userId'  ";
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
