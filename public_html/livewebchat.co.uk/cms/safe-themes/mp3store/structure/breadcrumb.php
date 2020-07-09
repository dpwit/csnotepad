<?php 
if ($list) {
$separator = "&gt;";
?>
<div id="breadcrumb"><h3>You are here: 
<a class='breadcrumb' href='/'>Home</a> <?php 
	$links = array();
	$first=false;
foreach($list as $k=>$v){
	if(is_object($v)){
		$k = $v->getUrl();
		$v = $v->getLabel();
	}
	if(!$first){
		//$v = $v;
	} else {
		$first=false;
	}
	if($k){
?> <?=$separator?> <a class="breadcrumb" href="<?=$k?>"><?=$v?></a><?
	} else {
?><span class="breadcrumb"><?=$v?></span><?

	}
}
?>
</h3></div>
<div id="breadcrumb-search-fields" style="display:none;">
	<input type='hidden' name='from' value='<?=@$_REQUEST['from']?$_REQUEST['from']:$_SERVER['REQUEST_URI']?>'/>
</div>
<?php 
}
?>
