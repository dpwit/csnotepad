<?
	require_once(dirname(__FILE__).'/../fe-init.php');
	$category = Model::g('ProductCategory')->getFirst();


	var_dump($category->loadRel('image'));
