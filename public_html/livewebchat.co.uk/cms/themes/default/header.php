<? echo'<?xml version="1.0" encoding="UTF-8"?>';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href='<?=BASEURL?>/cms/index.html' />
<link href='<?=$themeUrl?>/css/cms.css' rel="stylesheet" type="text/css"/>
<? include(dirname(__FILE__).'/jsIncludes.php'); ?>
<?php 
/*
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<link href='<?=$themeUrl?>/css/simplemodal.css' rel="stylesheet" type="text/css"/>
<link href='<?=$themeUrl?>/css/store.css' rel="stylesheet" type="text/css"/>
<script src='<?=$themeUrl?>/js/jquery.corner.js' type='text/javascript'></script>
<script type="text/javascript">
  $(document).ready(function(){
 $("#pixelwidth").corner();
 $("#subnav a").corner("round 5px");
 $(".save-block").corner("bottom round");
  });
</script>
 */
cms_trigger_action('admin_header');
?>
</head>
<body>
<!--[if lte IE 6]><script src="/cms/js/ie6warn/warning.js"></script><script>window.onload=function(){e("/cms/js/ie6warn/")}</script><![endif]-->
<div id="pixelwidth" class="clearfix">
<div id="header" class="clearfix"><a href='/cms/'><div id="headerlogo"><?=$GLOBALS['project_title']?></div></a><div id='headeruserstatus'>
<? if($a = @$_SESSION['OLD']) { ?>
	<?=$_SESSION['uid']?> - <a href='<?=Model::loadModel('User')->cmsUrl('exit_su')?>'>Switch Back</a>
<? } elseif($_SESSION['uid']) { ?>
	<a href='<?=Model::loadModel('User')->cmsUrl('logout')?>'>Logout (<?=$_SESSION['uid']?>)</a>
<? } else { ?>
Not Logged In
<? } ?>
</div></div>
<div id="mainEqCol">
<div id="leftEqCol">
<div id="navigation">
<?php
$menu = get_module_links();
$categories = cms_apply_filter('categorise_modules',array());
$GLOBALS['keys'] = $menu;

function unsetkey($v,$k){
	unset($GLOBALS['keys'][$v]);
}

array_walk_recursive($categories,'unsetkey');
$categories['Other'] = array_keys($GLOBALS['keys']);
$selected = strtolower(cms_get_sectionname());
foreach($categories as $title=>$list){
?>
	<h2><?=$title?></h2>
<ul class='cms-navigation'>
<?

	foreach($list as $section){
		$parts = @$menu[$section];
		if(!$parts) continue;
	try {
		if(!check_access($section,'viewMenu')) continue;
	$section = trim($section);
	$css_class = ($selected==strtolower($section))||(@$alt==strtolower($section))? "selected":"not-selected";
	?><li class='section-title accordion-element <?=$css_class?>'><a class='accordion-handle <?=$css_class?>'><?=$section?><span></span></a>
		<ul class='cms-section-menu accordion-content'>
<?
	foreach($parts as $text=>$url) { 
		if(!check_access("$section/$text",'viewMenu')) continue;
?>
		<li><a href='<?=$url?>'><?=$text?><span></span></a></li>
<? } ?>
		</ul>
	
	</li><?
	}
	catch(Exception $e){}
}

?>

</ul>
<? } ?>
</div>
<div id="mainCol">
