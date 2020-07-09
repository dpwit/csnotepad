<?php /*?><h2 id="productTitle"><?=$product->getLabel()?></h2><?php */?>
<?php if ($product->image('exists')) {?>
								<div class='productImages'>
									<div id="productImage">
										<img src="<?=$product->image('detail',array('default'=>'png'))?>" alt="<?=$product->imageCaption()?>" title="<?=$product->imageCaption()?>"/>
									</div>
								<?php } ?>
<?php /*?><? 
$images = $product->product_images();
if(count($images)>1){
?>
	<div class='productThumbs'>
<?	foreach($images as $image){
?>
		<div class='productThumb'><a href='<?=$image->image('detail',array('default'=>'png'))?>' class='thumb-link'><img src='<?=$image->image('icon',array('default'=>'png'))?>' title='<?=$image->getLabel()?$image->getLabel():$product->getLabel()?>'/></a></div>
<?
}
?>
	</div>
<?
}
?>
</div>
<?php } ?>
<script>
$('a.thumb-link').live('mouseenter',function(){
});
$('a.thumb-link').live('click',function(){
	$('#productImage img').attr('src',$(this).attr('href'));
	return false;
});
</script>
<?php */?>
<?
	$links=array();
	if($artists = $product->manufacturerLinks()){
		foreach($artists as $url=>$label){
			if(is_numeric($url)){
				$links[] = $label;
			} else {
				$links[] = "<a href='".$url."'>".$label."</a>";
			}
		}
	}
?>
								
<? if($links) { ?>
								<h4 id="productArtists"><?=join(", ",$links)?></h4>
<? } ?>
								<div id="productDesc">
<?=paragraphs($product->description)?>
								</div>
							</div>
<!--</div>-->
