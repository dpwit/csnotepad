<script>
	
</script>
<div class='listing-search-page'>
<div class='listing-search-header clearfix'>
<?
		$count=0;
		cms_trigger_action('model_listing_search_start',$model);
?>
<div class="">
<?
		cms_trigger_action('model_listing_search_inputs',$model);
?>  
</div>

<?
	$current = $parent;
	$breadcrumb = array();
	while($current && $current->exists()){
		$breadcrumb[] = $current;
		$current = $current->parent();
	}
	$breadcrumb[] = Model::loadModel('ProductCategory')->createNew(array('uid'=>'','name'=>'Categories'));
	$current = @$_REQUEST['parent_uid'] ? $_REQUEST['parent_uid'] : @$_REQUEST['category_uid'];
?>
<div class='listing-breadcrumb'>
<?
	foreach(array_reverse($breadcrumb) as $item){
		if($count++) echo " / ";
?>
	<a href='overview.php?section=Products&model=ProductCategory&parent_uid=<?=$item->getId()?>'><?=$item->getLabel()?></a> 
<?
	} 

?>
</div>

<div class="listing-search-box">
	<form method='get'>
		<input type='hidden' name='page' value=''/>
<?
		foreach($_GET as $k=>$v) {
			if(in_array($k,array('search','page'))) continue;
?>
		<input type='hidden' name='<?=$k?>' value='<?=$v?>'/>
<? } ?>
Search <?=$model->getEnglishName(true)?>: <input name='search' value='<?=htmlspecialchars(@$_REQUEST['search'],ENT_QUOTES)?>'/>
<input type='submit' value='Search'/>
	</form>
</div> 
<?
		cms_trigger_action('model_listing_search_end',$model);
?>
</div><!--listing-search-header-->

<div class='listing-links'>
	<a class='buttonblock' href='newItem.php?section=Products&model=ProductCategory&parent_uid=<?=$current?>'>New Category</a>
	<? foreach(cms_apply_filter('concrete_product_types',array()) as $name=>$array) { 
		$class = $array['class'];
		$type = $array['type']->getId();
	?>
		<a class='buttonblock' href='newItem.php?section=Products&model=<?=$class?>&parent_uid=<?=$current?>&product_type_uid=<?=$type?>'>New <?=$name?></a>
	<? } ?>
</div>
<div style='clear:both'></div>
<?
	$done=false;
	$params['for_fetch'] = true;
	foreach($listings as $function){
?>
<table class='cmstable cmstable-products' cellpadding="2" cellspacing="0">
<thead>
<tr><th>Type</th><th>Title</th><th>Status</th><th>Stock</th><th>Cat No.</th><th>Sort</th><th>Move</th><th>Edit</th><th>Delete</th></tr>
</thead>
<tbody class='sortable ajax-sortable'>
<?
		if(is_string($function)){
			$q = $parent->$function($restrict,$params);
		} else {
			$q = call_user_func($function,$restrict,$params);
		}
if(!$q) var_dump($function);
		if($r = $q->fetch()) {
			$done=true;
			do {
				if(!$r->checkAccess('view',false)) continue;
				$class = "model-row model-row-".strtolower($r->getModelName())." model-row-".strtolower($r->getProductTypeName());
				$class = cms_apply_filter('model_listing_row_class',$class,$r);
		?>
			<tr class='<?=$class?>'>
<?
				$visibility = $r->status>0 ? "public":"private";
				$mainUrl = ($r instanceof ProductCategoryModel) ? "overview.php?section=Products&model=ProductCategory&parent_uid=$r->uid" : $r->urlFor('editItem');
				if(@$bulkActions) echo "<td class='tablecell tablecellLeft'><input type='checkbox' name='cms_uid[{$obj->getID()}]'/></td>";
?>
				<td class='tablecell col-type'><?=$r->getProductTypeName()?>
					<input type='hidden' class='id-field' value='<?=$r->getID()?>'/>
					<input type='hidden' class='type-field' value='<?=$r->getTableName()?>'/>
					<input type='hidden' class='model-field' value='<?=$r->getModelName()?>'/>
				</td>
				<td class='tablecell col-name'><span><a href='<?=$mainUrl?>'><?=$r->getLabel()?></a></span></td>
				<td class='tablecell col-status col-status-<?=$visibility?>'><span>
					<a href='<?=$r->urlFor('toggleActive')?>'>
					<?=ucwords($visibility)?>
					</a>
				</span></td>
				<td class="tablecell">
<? if($r instanceof ProductModel) { ?>
					<?=$r->hasInfiniteStock()?'N/A':$r->getTotalStock()?>
<? } else { ?>
	N/A
<? } ?>
				</td>
				<td class='tablecell'>
					<?=$r->catalogue_number?>
				</td>
				<td class='tablecell col-sort sortable-handle'>
					<span>DRAG</span>
				</td>
				<td class='tablecell col-move'>
					<a href='<?=$r->urlFor('move_category')?>'>Move</a>
				</td>
				<td class='tablecell col-edit'><a href='<?=$r->urlFor('editItem')?>'>Edit</a></td>
				<td class='tablecell col-delete'><a href='<?=$r->urlFor('delete')?>' class='confirm-link'>Delete</a></td>
<?
	cms_trigger_action('model_listing_after_column_data',$r,"<td class='tablecell'>%s</td>");
?>
	</tr>
<?
			} while($r=$q->fetch());
?>
<? 	
	cms_trigger_action('model_listing_after_table',$model);
		}
		?>
</tbody>
<tfoot><tr><td colspan="99"></td></tr></tfoot>
</table>
<?
	}
?>
<div class="cms-postfooter-pagination"> 
<?php
	if(@$page>0 || @$hasNext){
		echo "<div class='cms-sub-links cms-pagination'>";
		if($page>0) echo "<a href='".makeLink(array('page'=>$page-1))."'>Prev</a>";
		if($hasNext) echo "<a href='".makeLink(array('page'=>$page+1))."'>Next</a>";
		echo "</div>";
	}
?>
</div>
<?
	if(!$done){
?>
	<h2>Empty Category</h2>
<?
	}
	if(@$bulkActions) echo "</form>";
?>
</div><!--listing-search-page-->
