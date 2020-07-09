<div id='subnav'>
	<ul>
<?
	foreach($model->getMainLinks() as $link=>$label){
?>
		<li><a href='<?=$link?>'><?=$label?></a></li>
<? } ?>
	</ul>
</div>
<div style='clear: both;'></div>
