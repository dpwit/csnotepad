<?php 
	include_once 'common.php';
	load_theme_hooks();
	include_once 'db.php';
	cms_include_module_hooks();
	require_once(dirname(__FILE__).'/../cms/includes/model.php');
	cms_trigger_action('front_end_init');
