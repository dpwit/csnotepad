						<div id="productDetail">
							<div id="pdContent">
<?php if ($product->image('exists')) {?>
								<div class='productImages'>
									<div id="productImage">
										<img src="<?=$product->image('detail',array('default'=>'png'))?>" alt=""/>
									</div>
<? 
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
								<h3 id="productTitle"><?=$product->getLabel()?></h3>
<? if($links) { ?>
								<h4 id="productArtists"><?=join(", ",$links)?></h4>
<? } ?>
								<div id="productDesc">
<?=paragraphs($product->description)?>
								</div>
							</div>
<?
	if($product instanceof BundleModel){
		$tracks = $product->products_in();
		$allowSeparate = $product->canSellSeparately();
	} elseif($v = $product->variations()) {
		$tracks = $v;
		$allowSeparate = true;
	} else {
		$tracks = array($product);
		$allowSeparate = true;
	}
?>
<?
	if((count($tracks)>1 || !$allowSeparate) && $product->isAvailableForSale(1)){
?>
							<div id="pdSidebar">
		<h3><?=$product->getBuyText()?>:</h3>
								<ul class="tracks">
									<li>
<?
	if(@$basket && $basket->contains($track)) { 
?>
										<a class="add_to_basket" href='/basket/remove/<?=$product->getId()?>'><?=$product->prettyPrice()?><img src="images/shop/basket_delete.png" alt="basket"/></a>
<?		} elseif($product->isAvailableForSale(1) && $allowSeparate) { ?>
										<a class="add_to_basket" href='/basket/add/<?=$product->getId()?>'><?=$product->prettyPrice()?><img src="images/shop/basket_add.png" alt="basket"/></a>
<? 
		} 
		?>								<a onclick="return false" class="listen mp3-link title" href="<?=htmlspecialchars($product->getPreviewUrl() ,ENT_QUOTES)?>" title="<?=htmlspecialchars($product->getLabel(),ENT_QUOTES)?>"> <img src="images/speaker_icon.png" style="margin: 2px 5px 5px 0" alt="basket"/><span><?=$product->getLabel()?></span></a>

									</li>

<?
	//$this->view($context,'modules/products/buy-link',array('product'=>$product,'basket'=>$basket));
?>
								</ul>
							</div>
<? } ?><div id="pdSidebar">
<h3 class="trackH3"><?=$product->getBuySubProductsText()?>:</h3>
								<ul class="tracks">
<?
		foreach($tracks as $track){
			$trackProduct = count($tracks)>1 ? $track : $product;
?>
									<li>
<?
	if(@$basket && $basket->contains($track)) { 
?>
										<a class="add_to_basket" href='/basket/remove/<?=$track->getId()?>'><?=$track->prettyPrice()?><img src="images/shop/basket_delete.png" alt="basket"/></a>
<?		} elseif($track->isAvailableForSale(1) && $allowSeparate) { ?>
										<a class="add_to_basket" href='/basket/add/<?=$track->getId()?>'><?=$track->prettyPrice()?><img src="images/shop/basket_add.png" alt="basket"/></a>
<? 
		} 


			if(@$track->mp3 && $track->mp3->mp3('exists')){ 
?>
										<!--<a onClick="handleClick('<?=htmlspecialchars($trackProduct->getPreviewUrl(),ENT_QUOTES)?>','<?=htmlspecialchars($trackProduct->getLabel(),ENT_QUOTES)?>'); return false;" href="<?=htmlspecialchars($trackProduct->getPreviewUrl() ,ENT_QUOTES)?>" title="<?=htmlspecialchars($track->getLabel(),ENT_QUOTES)?>"> <img src="images/speaker_icon.png" style="margin: 2px 5px 5px 0" alt="basket"/><?=$track->getLabel()?></a>-->
										<a onclick="return false" class="listen mp3-link" href="<?=htmlspecialchars($trackProduct->getPreviewUrl() ,ENT_QUOTES)?>" title="<?=htmlspecialchars($track->getLabel(),ENT_QUOTES)?>"> <img src="images/speaker_icon.png" style="margin: 2px 5px 5px 0" alt="basket"/><span><?=$track->getLabel()?></span></a>
<? 
			} elseif($track instanceof ProductVariation) {
?>
				<a><?=$track->describeVariation()?></a>
<? 
			} else { 
?>
				<a><?=$track->getLabel()?></a>
<? 
			} 
?>
									</li>
<?
		}
?>
								</ul>
							</div>
						</div>		


<?php  /* 
QUANTITY NOT NEEDED FOR DIGITAL PRODUCTS
<form action='/basket/add/<?=$product->getId()?>' method='post'>
<div id="addToBox"><label for="qty">Qty:</label><input type="textbox" id="qty" name='qty' value="1"/></div> 			</form> 
*/ ?>
