<div id="shop" class="box thinBorder">
		<h3 class="headerText">Order Complete</h3>
		<table class="basket">
		<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>
			<? foreach($order->order_items() as $item){ ?>
				<tr><td class="item"><?=$item->getLabel()?></td><td class="quantity"> <?=$item->getQuantity()?> </td><td class="price"><?=$item->getTotalPriceFormatted(false)?></td></tr>
			<? } ?>
			<tr><td><strong>Total</strong></td><td class="basketQty"> - </td><td class="basketPrice total"><strong><?=$order->getPrice(true)?></strong></td></tr>
		</table>
<?
	$products = $downloadable = array();
	foreach($order->order_items() as $item){
		if($item->isExtra()) continue;
		if($product = $item->product())
		foreach($product->getLeafProducts() as $product){
			if($product->isDownloadable())
				$downloadable[] = $product;
		}
	}
	
	if($downloadable){
?>
<h3 class="headerText">Downloadable Products</h3>
<p>Some of the products you purchased are digital, you can get these from the following links:</p>
<table class='download-link basket'>
	<thead><tr><th>Download</th><th class="DownloadSmallCol">Valid Until</th><th class="DownloadSmallCol">Tries Left</th></tr></thead>
<? foreach($downloadable as $product) { ?>
	<tr><td>
<? if($product->canDownload()){ ?>
		<a href='<?=$product->download_link()?>'><?=$product->getLabel()?></a>
<? } else { ?>
		<?=$product->getLabel()?>
<? } ?>
</td><td class="DownloadSmallCol"><?=date("d/n/y",$product->getLastDownloadDate())?></td><td class="DownloadSmallCol"><?=$product->getRemainingDownloads()?>/<?=$product->getAllowedDownloads()?></td></tr>
<? } ?>
</table>
<? } ?>
</div>
