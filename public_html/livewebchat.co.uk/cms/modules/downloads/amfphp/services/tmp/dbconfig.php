<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/cms/config.php');

define("DB_HOST", $dbhhost);
define("DB_USER", $dbuser);
define("DB_PASS", $dbpass);
define("DB_NAME", $dbname);
define("SERVER_ROOT",  dirname(BASEPATH)."/");

?>
