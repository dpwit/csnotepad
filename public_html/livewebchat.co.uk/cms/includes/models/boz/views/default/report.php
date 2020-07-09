<?
	if(@$_REQUEST['search']) $report->restrict('like',$_REQUEST['search']);
	if(!isset($perPage)) $perPage = 25;
?>
<div class='listing-search-page'>
	<h2 class='listing-title'><?=$report->getReportTitle()?></h2>
<?
	if(!@$restrict) $restrict = array();
	$report->triggerAction('model_listing_before_table',$restrict,$params);
	$bulkActions = $report->getCmsBulkActions();
	if($bulkActions){
		foreach($bulkActions as $k=>$v)
			if(!$model->checkAccess($k,false)) unset($bulkActions[$k]);
	}
	if(@$_REQUEST['search']) { ?>
<a class='view-all-link' href='<?=makeLink(array('q'=>''))?>'>View All</a>
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


function drawHeadings($report){
	$report->triggerAction('pre_report_table');
?>
<table class='<?=$report->applyFilters('cms_table_css',"cmstable cmstable-{$report->getTableClass()}");?>' cellpadding="2" cellspacing="0">
<thead>
<?
	$report->triggerAction('head_report_table');
?>
<tr>
<? if($report->getCmsBulkActions()) { ?>
	<th class='tableHead col-select'><span>Select</span></th>
<? }
	$cols = $report->getListingHeadings();
	$colCount = count($cols)+1;
	foreach($cols as $label) { 
?>
		<th class='tableHead col-<?=strtolower(str_replace(" ","_",$label))?>'><span><?=$label?></span></th>
<? 
	} 
	$report->triggerAction('model_listing_after_column_headings',"<th class='tableHead'><span>%s</span></th>");
?>
	</tr>
	</thead>
	<tbody class='<?=$report->applyFilters('cms_tbody_css',"");?>' cellpadding="2" cellspacing="0">
<?
}
?>
<?
	function drawRow($report){
		if(!$report->checkAccess('view',false)) {
			return;
		}
		$class = "model-row model-row-".strtolower($report->getRowClass());
		$class = $report->applyFilters('model_listing_row_class',$class);
		?>
	<tr class='<?=$class?>'>
<?
		if($report->getCmsBulkActions()) echo "<td class='tablecellLeft'><input type='checkbox' name='cms_uid[{$report->getID()}]'/></td>";
?>

<?		
		foreach($report->getListingValues() as $label=>$value)	{ 
?>
			<td class='tablecell col-<?=strtolower($label)?>'><span><?=$value?></span></td>
<? 		
		} 
		$report->triggerAction('model_listing_after_column_data',"<td class='tablecell'>%s</td>");
?>
		</tr>
<?
		$report->triggerAction('model_listing_end');
	}
	$first = true;
	$count=0;
	while($report->next()){
		if($report->newTable()) {
			if(!$first){
				closeTable($report);
			}
			$first = false;
			drawHeadings($report);
		}
		drawRow($report,$bulkActions);
		if($perPage && ++$count>$perPage) break;
	}
	if(!$first) closeTable($report);

	function closeTable($report){
	$report->triggerAction('after_table');
?>
</tbody>
<tfoot>
<tr>
<td class="tablefoot"></td>
<?php
for($a=0;$a<count($report->getListingHeadings())+($report->getCmsBulkActions()?1:0);$a++) {
?>
<td></td>
<?php } ?>
</tr>
</tfoot>
</table>
<?
	}
?>
<div class="cms-postfooter-pagination">
<?php
	$hasNext = $report->next();
	if(@$page>0 || $hasNext){
		echo "<div class='cms-sub-links cms-pagination'>";
		if(@$page>0) echo "<a href='".makeLink(array('page'=>@$page-1))."'>Prev</a>";
		if($hasNext) echo "<a href='".makeLink(array('page'=>@$page+1))."'>Next</a>";
		echo "</div>";
	}
?>
</div>
<?
	$report->triggerAction('report_summary',$report);
	if($bulkActions) echo "</form>";
?>
</div><!--listing-search-page-->
<div id="listing-csv">
	<a href='<?=makeLink(array('format'=>'csv'))?>'>Download CSV</a>
</div>
<?
	$report->triggerAction('report_finished',$report);
?>
