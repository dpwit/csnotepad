<table><tr><th>Event</th><th>Date</th></tr>
<?
	foreach($events as $event){
?>
	<tr><td><a href='<?=$link?><?=$event->uid?>'><?=$event->title?></a></td><td><?=$event->niceDate()?></td> </tr>
<? } ?>
</table>
