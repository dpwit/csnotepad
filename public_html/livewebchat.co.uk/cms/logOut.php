<?
/**
* @package BozBoz_CMS
*/

session_start();
$_SESSION['uid']='';
$_SESSION['pwd']='';
$_SESSION['id']='';
header("Location: index.php");
die();
include(dirname(__FILE__).'/common.php');
include(dirname(__FILE__).'/db.php');
include(dirname(__FILE__).'/header.php');

include(dirname(__FILE__).'/accesscontrol_check.php');

?>
<?
include(dirname(__FILE__).'/footer.php');
?>
