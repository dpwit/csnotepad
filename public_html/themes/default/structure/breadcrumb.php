<?php 
if ($list) {
?>
<div id='breadcrumb'><h2 class="headerText">
<?php 
	$links = array();
	$first=true;
foreach($list as $k=>$v){
	if(is_object($v)){
		$k = $v->getUrl();
		$v = $v->getLabel();
	}
	if(!$first){
		$v = " : ".$v;
	} else {
		$first=false;
	}
	if($k){
?>
	<a class='breadcrumb' href='<?=$k?>'><?=$v?></a>
<?
	} else {
?>
	<span class='breadcrumb'><?=$v?></span>
<?

	}
}
?></h2>
</div>
<div id='breadcrumb-search-fields' style='display:none;'>
	<input type='hidden' name='from' value='<?=$_REQUEST['from']?$_REQUEST['from']:$_SERVER['REQUEST_URI']?>'/>
</div>
<?php 
}
?>
