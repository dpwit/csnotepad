<div class='listing-search-page'>
<?
	include(dirname(__FILE__).'/list-init.php');
global $hasActions;
		$hasActions = $model->applyFilters('cms_has_actions',true);
	if(@$_REQUEST['search'] && !@$title){
		$title='Search Results';
	}
	if(@$title) { ?>
		<h2 class='listing-title'><?=$title?></h2>
	<? }  
	$model->triggerAction('model_listing_before_table',$restrict,$params);
	if(cms_apply_filter('model_listing_show_csv_link',true)){
?>
<?
	}
	$bulkActions = $model->getCmsBulkActions();
	if($bulkActions){
		foreach($bulkActions as $k=>$v)
			if(!$model->checkAccess($k,false)) unset($bulkActions[$k]);
	}
	if(@$_REQUEST['search']) { ?>
<a class='view-all-link' href='<?=$model->urlFor('overview')?>'>View All</a>
<? } 
	if($bulkActions){
?>
<form method='post' action='despatch.php'>
<p>With Selected:</p>
<select name='action'>
<? foreach($bulkActions as $k=>$v){
?>
	<option value='<?=$k?>'><?=$v?></option>
<?
}
?>
</select>
<input type='submit' value='GO'/>
<input type='hidden' name='model' value='<?=$model->getModelName(false)?>'/>
<?
	}
?>

<?php
	if($page>0 || $hasNext){
		echo "<div class='cms-sub-links cms-pagination'>";
		if($page>0) echo "<a href='".makeLink(array('page'=>$page-1))."'>Prev</a>";
		if($hasNext) echo "<a href='".makeLink(array('page'=>$page+1))."'>Next</a>";
		echo "</div>";
	}
	?>

<table class='<?=$model->applyFilters('cms_table_css',"cmstable cmstable-{$model->getTableName()}");?>' cellpadding="2" cellspacing="0">
<thead>
<tr>
<? if($bulkActions) { ?>
	<th class='tableHead col-select'><span>Select</span></th>
<? }
$e = error_reporting();
error_reporting($e&~E_NOTICE);
$cols = $model->getListingColumns();
error_reporting($e);
$colCount = count($cols)+1;
foreach($cols as $label=>$value) { ?>
	<th class='tableHead col-<?=strtolower(str_replace(" ","_",$label))?>'><span><?=$label?></span></th>
<? } ?>
<? if($hasActions) { ?>
<th class='tableHead col-actions'><span>Actions</span></th>
<? } ?>
<?
$model->triggerAction('model_listing_after_column_headings',"<th class='tableHead'><span>%s</span></th>");
?>
</tr>
</thead>
<tbody class='<?=$model->applyFilters('cms_tbody_css',"");?>' cellpadding="2" cellspacing="0">
<?
	function drawRow($obj,$bulkActions){
global $hasActions;
		if(!$obj->checkAccess('view',false)) {
			return;
		}
		$class = "model-row model-row-".strtolower($obj->getModelName());
		$class = $obj->applyFilters('model_listing_row_class',$class);
		?>
	<tr class='<?=$class?>'>
<?
		if($bulkActions) echo "<td class='tablecellLeft'><input type='checkbox' name='cms_uid[{$obj->getID()}]'/></td>";
?>

<? foreach($obj->getListingColumns() as $label=>$value){ ?>
	<td class='tablecell col-<?=strtolower($label)?>'><span><?=$value?></span></td>
<? } ?>
<? if($hasActions) { ?>
<td class='tablecell actionCell'>
<?
		$actions = cms_apply_filter('model_listing_actions',$obj->getCmsActions(),$obj);
		$toGo = count($actions);
		$count=0;
		$toggleMore = 6;
		foreach($actions as $link=>$label){ 
			if(++$count==$toggleMore){
?>
			<div class='toggle-more'>
<?
			}
	?>
	<a class='overviewAction overViewAction-<?=$label?>' href='<?=$link?>'><span class='actionText'><?=$label?></span></a>  <? if (--$toGo>0) echo " - "; ?>
<? } 
			if($count>=$toggleMore) echo "</div>";
?>
		</td>
<? } ?>
<?
	$obj->triggerAction('model_listing_after_column_data',"<td class='tablecell'>%s</td>");
?>
	</tr>
<?
	$obj->triggerAction('model_listing_end');
	}
	foreach($records as $obj){
		drawRow($obj,$bulkActions);
	}
?>
</tbody>
<tfoot>
<tr>
<td class="tablefoot"></td>
<?php
for($a=0;$a<count($cols)+($bulkActions?1:0);$a++) {
?>
<td></td>
<?php } ?>
</tr>
</tfoot>
</table>
<div class="cms-postfooter-pagination">
<?php
	if($page>0 || $hasNext){
		echo "<div class='cms-sub-links cms-pagination'>";
		if($page>0) echo "<a href='".makeLink(array('page'=>$page-1))."'>Prev</a>";
		if($hasNext) echo "<a href='".makeLink(array('page'=>$page+1))."'>Next</a>";
		echo "</div>";
	}
?>
</div>
<?
	cms_trigger_action('model_listing_after_table',$model);
	if($bulkActions) echo "</form>";
?>
</div><!--listing-search-page-->
<div id="listing-csv">
	<a href='<?=makeLink(array('listing-view'=>'csv'))?>'>Download CSV</a>
</div>
