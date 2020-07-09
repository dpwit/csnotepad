<?php // common.php
/**
* @package BozBoz_CMS
*/

@include_once(dirname(__FILE__).'/config.php');
@session_start();
include_once dirname(__FILE__).'/includes/functions/generalFunctions.php';

function error($msg) {
    ?>
    <html>
    <head>
    <script language="JavaScript">
    <!--
        alert("<?=$msg?>");
        history.back();
    //-->
    </script>
    </head>
    <body>
    </body>
    </html>
    <?
    exit;
}

require_once(dirname(__FILE__).'/includes/models/hooks.php');
function cms_get_module_directories(){
	return cms_apply_filter('module_directories',array(
		dirname(__FILE__).'/../ext/modules',
		dirname(__FILE__).'/modules',
	));
}
function cms_get_modules(){
	require_once(dirname(__FILE__).'/common_hooks.php');
	if(file_exists(dirname(__FILE__).'/../ext/init.php'))
		require_once(dirname(__FILE__).'/../ext/init.php');
	$dirs = cms_get_module_directories();
	$modules = array();
	foreach(array_reverse($dirs) as $dir){
		$md = opendir($dir);
		while($mod = readdir($md)){
			if(is_dir("$dir/$mod") && ($mod[0]!='.'))
				$modules[$mod] = true;
		}
	}
	return cms_apply_filter('valid_modules',array_keys($modules));
}
function cms_module_require($module,$path){
	require_once(__cms_module_resolve($module,$path));
}
function cms_module_include($module,$path){
	if(file_exists($file = __cms_module_resolve($module,$path))){
		include($file);
	}
}
function cms_module_resolve($module,$path=''){
	return __cms_module_resolve($module,$path);
}
function __cms_module_resolve($module,$path){
	$dirs = cms_get_module_directories();
	foreach($dirs as $dir){
		if(is_dir("$dir/$module")){
			return "$dir/$module/$path";
			break;
		}
	}
}
function cms_require_module($module){
	if(!cms_include_module($module)) throw new Exception("Could not load required module '$module'");
}
function cms_include_module($module){
	static $included = array();
	if(@$included[$module]) return;
	$dirs = cms_get_module_directories();
	foreach($dirs as $dir){
		if(is_dir("$dir/$module")){
			foreach(array('init','module_hooks') as $file){
				if(file_exists($path = "$dir/$module/$file.php")){
					require_once($path);
					break;
				}
			}
			return true;
		}
	}
	return false;
}
function cms_include_module_hooks(){
	include_once dirname(__FILE__).'/db.php';
	cms_include_module('config');
	foreach(cms_get_modules() as $module){
		cms_include_module($module);
	}
	include_once dirname(__FILE__).'/includes/model.php';
}
cms_listen_hook('check_access','check_user_level',null,-1);
function check_access($pageType,$action,$id=null,$params=array()){
	return !get_access_errors($pageType,$action,$id,$params);
}
function get_access_errors($pageType,$action,$id=null,$params = array()){
	$params = array_merge($params,array('action'=>$action,'pageType'=>$pageType,'uid'=>$id));
	return cms_apply_filter('check_access',array(),$params);
}
function check_user_level($errors,$action){
	if(@!$_SESSION['uid']){
		$errors['USER_LEVEL'] = 'You must login to access this data';
	} elseif(@$_SESSION['level']<=2){
		$errors['USER_LEVEL'] = 'You are not permitted to access this data';
	}
	return $errors;
}
function set_theme($theme){
	get_theme($theme);
	load_theme_hooks();
}
if(!function_exists('get_theme')){
function get_theme($newTheme=null){
	static $theme = 'default';
	if($newTheme) $theme = $newTheme;
	return $theme;
}
}

function find_theme($theme,$absolute=true){
	foreach(array('/ext/themes','/cms/themes/') as $dir){
		$adir =dirname(__FILE__)."/../$dir";
		if(is_dir("$adir/$theme")) return ($absolute ? $adir : $dir) ."/$theme";
	}
}

function get_theme_file($file){
	foreach(array(find_theme(get_theme()),dirname(__FILE__).'/themes/default') as $dir){
		if(file_exists("$dir/$file")) return "$dir/$file";
	}
}

function include_theme_file($file,$vars = array()){
	$vars['themeUrl'] = find_theme(get_theme(),false);
	extract($vars);
	include($file = get_theme_file($file));
}

function load_theme_hooks(){
	static $done = array();
	$modules = !count($done);
	if(!@$done[$theme = get_theme()]){
		include_theme_file('module_hooks.php');
		$done[$theme] = true;
	}
	if($modules) 
		cms_include_module_hooks();
}
function get_module_links(){
	// Get old style modules
	$old_links = cms_apply_filter('get_module_links',array());

	// Arrange into menu structure

	$menu = array();
	foreach($old_links as $k=>$v){
		if (!check_access($v,'overview')) continue;
		@list($pageType,$stuff) = explode("&",$v,2);
		$model = Model::loadModel($pageType,true);
		if($model instanceof BozModel) {
			$l = array_flip($model->getMainLinks());
			$eng = $model->getEnglishName(false);
			$eng = $model->getEnglishName(true);
			foreach($l as $k=>$v){
				$nk = str_replace($eng,"Item",$k);
				$nk = $k;
				$menu[$eng][$nk] = $v;
			}
		} else {
			$menu['Modules'][$k] = "overview.php?pageType=$v";
		}
	}
	// Transform to new style menu
	return cms_apply_filter('cms_menu',$menu);

}
function cms_get_sectionname(){
	$links = get_module_links();
	$keys = array_map('strtolower',array_keys($links));
	$keys = array_map('trim',$keys);
	$get = $_GET;
	if(@$_GET['section']){
		$section = strtolower($_GET['section']);
	} 
	if(@$_GET['model'] && !@in_array($section,$keys)){
		$section = strtolower(Model::loadModel($_GET['model'],true)->getEnglishName(false));
	} 
	if(@$_GET['pageType'] && !@in_array($section,$keys)){
		$section = strtolower($_GET['pageType']);
	}
	if(@$_GET['pageType'] && !@in_array($section,$keys)){
		$section = strtolower(Model::unpluralize($_GET['pageType']));
	}
	if(!@in_array($section,$keys)) $section = 'modules';

	return cms_apply_filter('cms_section_name',$section,Model::cmsLoadController());
}
function cms_get_pagetype(){
	return $_GET['pageType'];
}
function get_module_links_filtered(){
	$links = get_module_links();
	foreach($links as $k=>$v){
		if(!check_access($v,'overview')) unset($links[$k]);
	}
	return $links;
}
function page_is_real(){
	if(!@$_REQUEST['no_template'])
		$_SESSION['lastRealPage'] = $_SERVER['REQUEST_URI'];
}

function yes(){ return true; }
function no(){ return false; }

$GLOBALS['SHOW_TEMPLATE'] = !@$_REQUEST['no_template'];
function cms_no_template(){
	$GLOBALS['SHOW_TEMPLATE'] = false;
}

	function debug($msg){
		if($GLOBALS['debug']) error_log($msg);
	}
	
	
		function substr_words($maxCharLen=100,$str,$suffix=' ...')
		{
			if(strlen($str) <= $maxCharLen) return $str;
			
			$maxCharLen -= strlen($suffix); // prob ok to get rid of this line?
			
			$temp = substr($str,0,$maxCharLen);
			$index = strrpos($temp,' ');
			if( $index === false ) 
				$index = strlen($temp);
				
			return substr($temp,0,$index).$suffix;
		}
		
		
register_shutdown_function('cms_trigger_action','php_shutdown');
?>
