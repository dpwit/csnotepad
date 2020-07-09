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
	if((count($tracks)>1 || !$allowSeparate) && $product->isSelfAvailableForSale(1)){
?>
							<div id="pdSidebar">
		<h3><?=$product->getBuyText()?>:</h3>
								<ul class="tracks">
									<li>
<?
	if(@$basket && $basket->contains($product)) { 
?>
										<a class="add_to_basket" href='/basket/remove/<?=$product->getId()?>'><?=$product->prettyPrice()?><img src="images/shop/basket_delete.png" alt="basket"/></a>
<?		} elseif($product->isAvailableForSale(1) && $allowSeparate) { ?>
										<a class="add_to_basket" href='/basket/add/<?=$product->getId()?>'><?=$product->prettyPrice()?><img src="images/shop/basket_add.png" alt="basket"/></a>
<? 
		} 
		try {
		?>								<a onclick="return false" class="listen mp3-link title" href="<?=htmlspecialchars($product->getPreviewUrl() ,ENT_QUOTES)?>" title="<?=htmlspecialchars($product->getLabel(),ENT_QUOTES)?>"> <img src="images/speaker_icon.png" style="margin: 2px 5px 5px 0" alt="basket"/><span><?=$product->getLabel()?></span></a>
		<? } catcH(BadRelationshipException $e){
		}?>
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
<?						$img = $track->variationImage('icon',array('as_url'=>true));
						 if($img) { ?>
							<img src='<?=$img?>'/>
						<? } ?>
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
