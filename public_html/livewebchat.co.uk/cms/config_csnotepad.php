<?
if(file_exists($file = dirname(__FILE__).'/../../config/config.php')) require_once($file);

global $dbhost, $dbuser,$dbpass,$dbname , $project_title;

$dbhost = 'localhost';
$dbuser = '15327sql';
$dbpass = 'SXslwSes';
$dbname = '15327db';

$project_title = 'CSnotepad';

define("BASEPATH", dirname(__FILE__).'/');
if(!defined('__SERVER_DOMAIN__')) define('__SERVER_DOMAIN__','www.csnotepad.co.uk');
define("MASTERURL", 'http'.($_SERVER['HTTPS']?'s':'')."://".__SERVER_DOMAIN__);
define('BASEURL',MASTERURL);
define('CMSURL',BASEURL.'/cms');

?>
