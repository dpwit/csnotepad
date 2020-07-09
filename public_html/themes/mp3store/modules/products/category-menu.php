
						<h2>View by Category</h2>
						<ul>
<?
	function drawCategories($list){
		foreach($list as $category){
			$url = $category->getUrl();
			$selected=BreadCrumb::selected($url);
			$css = $selected ? "selected" : "not-selected";
?>
							<li><a href="<?=$url?>" class="<?=$css?>" title="<?=$category->getLabel()?>"><?=$category->getLabel()?></a>
<?
			if(($children = $category->children()) && $selected) { 
				echo '<ul class="subCat">';
				drawCategories($children);
				echo "</ul>";
			}
		}
	}
	if(!$where) $where=array();
	drawCategories(Model::loadModel('Category')->getTopLevel($where));
?></li>
						</ul>
