<?php // db.php
/**
* @package BozBoz_CMS
*/

header("Content-type: text/html; charset=utf-8");
if(!defined('FE')) define('FE',true);

if(!function_exists('dbConnect')) {
require_once(dirname(__FILE__).'/config.php');
require_once(BASEPATH.'common.php');


function dbConnect() {
    global $dbhost, $dbuser, $dbpass,$dbname;
    $db=$dbname;
    $dbcnx = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die ('cant select database: ' . mysql_error()); 

    if ($db!='' and !@mysql_select_db($db))
       die ('Page Error please Try Again: ' . mysql_error()); 

    
    return $dbcnx;
}

function dbConnect2($dbase) {
    global $dbhost, $dbuser, $dbpass;
    $db='$dbase';
    $dbcnx = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die ('cant select database: ' . mysql_error()); 

    if ($db!='' and !@mysql_select_db($db))
       die ('Page Error please Try Again: ' . mysql_error()); 

    
    return $dbcnx;
}

/** Creates a string suitable for use in SQL expressions.
 *
 * \param $array	Key value pairs to be assigned in expression
 * \param $join		Placed between the pairs " , " will create a string
 * 	suitable for an UPDATE or INSERT statement. " AND " will create a
 * 	string suitable for a where clause.
 */
function sql_assignString($array,$join=" , "){
	$isMatch =array();
	foreach($array as $k=>$v){
		$isMatch[] = "`$k`='$v'";
	}
	return join($isMatch,$join);
}

function sql_insert($table,$values){
	return mysql_query("INSERT INTO $table SET ".sql_assignString($values));
}

function sql_update($table,$values,$where=1){
	return mysql_query("UPDATE $table SET ".sql_assignString($values)." WHERE $where");
}


dbConnect();

}

?>
