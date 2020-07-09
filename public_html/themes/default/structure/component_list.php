<?
foreach($components as $component){
	if(!$component->isVisible()) continue;
?>
		<?=$component->getHtml($context)?>
<? if(!@$skipWrap) { ?>
	<!--<div style="clear:both"></div>	-->
<? } ?>
<?
}
?>
