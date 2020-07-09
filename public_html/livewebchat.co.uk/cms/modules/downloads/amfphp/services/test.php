<?php 

include("dbconfig.php");
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
$db = mysql_select_db(DB_NAME);

$sql_uid  = "SELECT LAST_INSERT_ID() FROM `gallery` LIMIT 1";
//$sql_uid  = "SELECT * FROM gallery";
$result2 = mysql_query($sql_uid);
while ($galleries = mysql_fetch_array($result2, MYSQL_BOTH)) { 
 echo $galleries['LAST_INSERT_ID()']; 
 echo $galleries['1']; 
 echo $galleries['2']; 
 }


?>
