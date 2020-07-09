<?
if(!$pagination) return;
$prev = $this->getPrevLink();
$next = $this->getNextLink();
$cur = $this->getCurrentPage();
$per = $this->getResultsPerPage();
$num = $this->getTotalResults();

if($per>=0){
	$start = $per*$cur+1;
	$end = min($per*($cur+1),$num);
} else {
	$start = 1;
	$end = $num;
}
$start = min($start,$end);
?>

<?
if($num > 10){
?>

	<div class='per-page pagination floatleft'>Show: 
<?
	foreach(array(20=>20,50=>50,-1=>"All") as $limit => $text){
		if(@$count++>0) echo ", ";
?>
	<a href='<?=$this->getPerPageLink($limit)?>'><?=$text?></a>
<?
	}
?>
</div>
<?
}
?>

<div class='pagination floatright'>
<?  if($prev) { ?> <a class='prev' href='<?=$prev?>'>&raquo Prev</a> <?  } ?>
<span class='position'>&nbsp;&nbsp;&nbsp;Results <?=$start?>-<?=$end?> of <?=$num?>&nbsp;&nbsp;&nbsp;</span>
<?  if($next) { ?> <a class='next' href='<?=$next?>'>Next &raquo</a> <?  } ?>
</div>
