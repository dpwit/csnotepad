<h2>What type of product do you need to add?</h2>
<?
$types = Model::loadModel('Product_Type')->getAll(array('for_collection'=>1));
$pf = Model::loadModel('Product');
foreach($types as $type){
?>
	<a class='mm-selector-add buttonblock no-ajax' href='<?=$pf->urlFor('new',array('bundle_uid'=>$bundle_uid,'product_type_uid'=>$type->getId()))?>'>New <?=$type->getLabel()?></a>
<?
}
?>
