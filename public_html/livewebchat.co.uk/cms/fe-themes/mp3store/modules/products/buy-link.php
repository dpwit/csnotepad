<?
		$variations = $product->variations();

		$url = false;
		try {
			$url = $product->getPreviewUrl();
		} catch(BadRelationshipException $e){
		}
		if($url) { 
/* <div class='browsePrice'><?= $product->prettyPrice() ?></div> */ ?>
									<li><a onclick="return false" class='mp3-link trackListen' href='<?=htmlspecialchars($product->getPreviewUrl() ,ENT_QUOTES)?>' title='<?=htmlspecialchars($product->getLabel(),ENT_QUOTES)?>'><img src="/images/shop/speaker_icon.png" style="position: relative; right: -1px" alt="headphones"/>Preview </a></li>
<?
		}
                    if (@$basket && $basket->contains($product)) {
?>
									<li><a title="Remove From Cart" href="/basket/remove/<?=$product->getId()?>"><img src="images/shop/basket_delete.png" alt="basket"/><?=$product->prettyPrice()?> </a></li>
<? } else { 

			if($variations){
				$price = $product->minPrice();
				if($price){
?>
					<li><a href='<?=$product->getUrl()?>'><?=$product->makePrettyPrice($price)?></a></li>
<?
				}
			} elseif($product->inStock()) {
?>
									<li><a title="Add To Cart" href="/basket/add/<?=$product->getId()?>"><img src="images/shop/basket_add.png" alt="basket"/><?=$product->prettyPrice()?></a></li>
<? } else { ?>
									<p>Out Of Stock</p>
<? }
} ?>
