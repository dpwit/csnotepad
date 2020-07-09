<? if($item instanceof ProductOrderItem){
	$prod=$item->product(); 
?>
<a href="<?=$prod->getURL()?>"><img src="<?=$prod->image('icon',array('as_url'=>true))?>" class="basket-image" alt="<?=$prod->getLabel()?>"/></a>
<span class='basket-label'>
	<a href="<?=$prod->getURL()?>"><?=$prod->getLabel()?></a>
</span>
<?
	try {
	if($url = $prod->getPreviewUrl()) { 
?>
<!--<div class='preview-wrapper'>-->
<ul class="buttons" style="width: 90px">
	<li><a onClick="handleClick('<?=htmlspecialchars($prod->getPreviewUrl(),ENT_QUOTES)?>','<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>'); return false;" class="trackListen" href="<?=htmlspecialchars($prod->getPreviewUrl() ,ENT_QUOTES)?>" title="<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>"><img src="/images/headphones.png" alt="headphones"/>Preview</a></li>
</ul>
<!--</div>-->
<? 	
	}
	} catch(BadRelationshipException $e){}
} else {  

?>
	<span class='basket-label'><?=$item->getLabel()?></span>
<? } ?>
