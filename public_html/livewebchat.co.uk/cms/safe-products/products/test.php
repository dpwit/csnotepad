<?
	require_once(dirname(__FILE__).'/../../../cms/cli-env.php');
	$cat = Model::g('ProductCategory',1);
	var_dump($cat->products());
?>