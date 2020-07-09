<?php 
	include_once 'common.php';
	load_theme_hooks();
	include_once 'db.php';
	include_once 'includes/functions/generalFunctions.php';
	try {
		Model::loadModel('User')->logInCLI();
	} catch(DBException $e){
		trigger_error("Couldn't force cli login");
	}
