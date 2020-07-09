<style>
	.stock-report .stock-control-form {
display:inline;
	}
.stock-level, .stock-description {
	display: block;
	float: left;
	width: 150px;
}
	.stock-control-form input[type='text'] {
		width: 1em;
	}
</style>
<div class='stock-report'>
<h1>STOCK REPORT</h1>
<?
$GLOBALS['controller'] = $this;
function drawProductStock($prod){
	global $controller;
	if($variations = $prod->variations()){
?>
	<ul>
<?
		foreach($variations as $v){
?>
	<li><span class='stock-description'><?=$v->variesBy()?> <?=$v->describeVariation()?> </span> <?drawProductStock($v)?></li>
<?
	$v->__destroy();
		}
?>
	</ul>
<?
	} elseif($prod->hasInfiniteStock()){
?>
		<p>Stock Uncontrolled</p>
<?
	} else {
?>
	<span class='stock-level'>Stock <?=$prod->stock?> </span><form class='stock-control-form' method='post' action='<?=$controller->urlFor('updateStock',array('product'=>$prod->getId()))?>'><input type='text' name='stock' value='1'/><input type='submit' name='add' value='Add'/><input type='submit' name='remove' value='Remove'/></form>
<?
	}
}
function drawProduct($prod){
?>
<div class='product'>
	<h3><?=$prod->getLabel()?></h3>
<? if(!$prod->variations()) { ?>
	<span class='stock-description'>&nbsp;</span>
<? } ?>
<?
	drawProductStock($prod);
	$prod->__destroy();
?>
</div>
<?
}
function drawCategory($cat){
?>
<div class='category'>
	<h2><?=$cat->getLabel()?></h2>
<?
	foreach($cat->non_variant_products() as $product){
		drawProduct($product);
	}
?>

<?
	foreach($cat->children() as $cat2){
		drawCategory($cat2);
		$cat2->__destroy();
	}
?>
</div>
<?
}

$cats = Model::loadModel('ProductCategory')->getTopLevel();
foreach($cats as $cat){
	drawCategory($cat);
	$cat->__destroy();
}
$orphaned = Model::loadModel('Product')->getAll(array('orphaned'=>1,'cms_editable'=>1),array('for_fetch'=>1));
while($p = $orphaned->fetch()){
	drawProduct($p);
}
?>
</div>
