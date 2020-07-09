<div id="shop" class="box thinBorder">

	<h1 class="headerText">Order Complete</h1>

	<p>Thank you for order with us.</p><br/>

	<h3>Setup your account:</h3><br/>

	<?php
		//based on the 6 products, change what the form shows.
		$querystring = '?';
		foreach($order->order_items() as $item){
			$categories = $item->product()->categories;
			if(!$categories){continue;}
			foreach($categories as $category){
				if($category->category_uid==13){$querystring .= 'telephone_answering&';}
				if($category->category_uid==15){$querystring .= 'order_taking&';}
				if($category->category_uid==14){$querystring .= 'call_patching&';}
				if($category->category_uid==16){$querystring .= 'virtual_address&';}
				if($category->category_uid==27){$querystring .= 'virtual_phone_number&';}
				if($category->category_uid==18){$querystring .= 'voicemail&';}
			}
		}
		$href_form = "http://www.csnotepad.co.uk/questionnaire/".$order->uid.$querystring;
	?>
	<button id="callmegreen" class="callme" onClick="window.location.href='<?=$href_form;?>';">Online</button>

	<br/>

	<form action="http://www.csnotepad.co.uk/questionnaire/request-callback" method="POST">
		<input type="hidden" name="post_key" id="post_key" value="requestcallback" />
		<input type="hidden" name="order_uid" id="order_uid" value="<?=$order->uid;?>" />

		<input type="submit" value="Over the phone" id="callmegreen" class="callme">
	</form>

		<?/*<p>
			Your order has been successfully processed. One of our team will be in touch shortly to confirm the setup of your products.
			<br />
			You  will also receive confirmation of this order by email.
		</p>

		<table class="basket">
		<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>
			<? foreach($order->order_items() as $item){ ?>
				<tr>
					<td class="item"><?=$item->getLabel()?></td><td class="quantity"> <?=$item->getQuantity()?> </td>
					<td class="price"><?=$item->getTotalPriceFormatted(false)?></td>
				</tr>
			<? } ?>
			<tr><td><strong>Total</strong></td><td class="basketQty"> - </td><td class="basketPrice total"><strong><?=$order->getPrice(true)?></strong></td></tr>
		</table>*/?>
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
?>
		<p>
			Your order has been successfully processed. One of our team will be in touch shortly to confirm the setup of your products.
			<br />
			You  will also receive confirmation of this order by email.
		</p>

<?php
	if(false && $downloadable){
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
