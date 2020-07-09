<p>Select the category you would like to move the <?=$model->getModelName()?> <?=$model->getLabel()?> into:</p>
<p class='category'><a href='<?=$model->urlFor('move_category',array('to'=>'root'))?>'>Top Level</a></li>
<?
	drawCategories(Model::loadModel('ProductCategory')->getTopLevel(),$model);
?>
<?
	function drawCategories($categories,$product){
?>
<ul class='category-list'>
<?
		foreach($categories as $category){
			if("$category"!="$product"){
?>
			<li class='category'><a href='<?=$product->urlFor('move_category',array('to'=>$category->getId()))?>'><?=$category->getLabel()?></a></li>
<?
			if($children = $category->children()){
				drawCategories($children,$product);
			}
			} else {
?>
			<li class='category'><?=$category->getLabel()?></li>
<?
			}
		}
?>
</ul>
<?
	}
?>
