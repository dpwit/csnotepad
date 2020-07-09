<?
if(!$model->exists()) $hiddenFields[] = 'products_in';
$bundle = @$_REQUEST['add_to_bundle'] ? @$_REQUEST['add_to_bundle'] : @$_REQUEST['bundle_uid'];
@$hidden.="<input type='hidden' name='add_to_bundle' value='".htmlspecialchars(@$bundle)."'/>";
if(!$model->exists()){
	$bm = Model::loadModel('Bundle')->get($bundle);
	$parent = @$_REQUEST['category_uid'] ? $_REQUEST['category_uid'] : @$_REQUEST['parent_uid'];
	$hidden.="<input type='hidden' name='parent_uid' value='".htmlspecialchars($parent)."'/>";
	if($bm){
		$hidden.="<input type='hidden' name='bundle_uid' value='".htmlspecialchars($bm->getId())."'/>";
	}
}

$breadProduct = $model;
$l = $model->getLabel();
$breadcrumb[$model->exists() ? $model->urlFor('editItem') : 1 ] = $l ? $l : "New ".$model->getEnglishName(false);
if(!@$bm) $bm=$model->bundles(array(),array('single'=>1));
if(@$bm){
	$breadcrumb[$bm->urlFor('editItem')] = $bm->getLabel();
	$cat = $bm->categories(array(),array('single'=>1));
} else {
	if(!$model->exists()) $cat = Model::g('ProductCategory',$parent);
	else $cat = $model->categories(array(),array('single'=>1));
}
while($cat){
	$breadcrumb[$cat->urlFor('overview',array('parent_uid'=>$cat->getId()))] = $cat->getLabel();
	$cat = $cat->parent();
}
$breadcrumb["overview.php?pageType=ProductCategory"] = Model::loadModel('ProductCategory')->createNew(array('uid'=>'','name'=>'All'));
?>
<div class='listing-search-header clearfix'>
<div class='listing-breadcrumb'>
<?php 
//$breadcrumb = array();
$count=0;
foreach(array_reverse($breadcrumb) as $url=>$label){
	if($count++) echo " / ";
	if(is_numeric($url)){
		echo "$label";
	} else {
		echo "<a href='$url'>" . trim($label) . "</a>";
	}
}
?>
</div>
</div>
<?php 
require(__MODELS_BASE__.'/boz/views/default/form.php');
?>
