					<div class="thinBorder box" id="artistsList">
						<ul>
					<div class='category-section'>
						<h2>View by Category</h2>
						<ul class="shop cats">
<?
	function drawCategories($list){
		foreach($list as $category){
			$url = $category->getUrl();
			$selected=BreadCrumb::selected($url);
			$css = $selected ? "selected" : "not-selected";
?>
							<li><a href="<?=$url?>" class="<?=$css?>"><?=$category->getLabel()?></a>
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
					</div></div>
					
