<?
/**
* @package BozBoz_CMS
*/

	include_once(dirname(__FILE__).'/../db.php');
	dbConnect();
	include_once(dirname(__FILE__).'/../common.php');
	cms_include_module_hooks();
	include_once(dirname(__FILE__).'/../includes/model.php');

	$image = Model::loadModel('Item');

	$image = $image->get(21);
	$image->writeToDB();
	var_dump($image->title);
?>
