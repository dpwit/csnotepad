<html>
<body style='background: white; color: black; font-size: 16px; width: 600px;'>
<p>Dear <?=$this->customer_title?> <?=$this->customer_lastname?></p>

<p>Your order has been accepted:</p>

<table><tr><th width="80%" style="border-bottom:4px double black">Item</th><th width="10%" style="border-bottom:4px double black" align="center">Quantity</th><th width="10%" style="border-bottom:4px double black" align="right">Price</th></tr>
<?

foreach($this->order_items() as $item){
?>
	<tr><td width="80%"><?=$item->getLabel()?></td><td width="10%" align="center"><?=$item->quantity?></td><td width="10%" align="right"><?=$item->getPrice()?></td></tr>
<? } ?>

</table>
<?
	$products = array();
	$downloadable = array();
	foreach($this->order_items() as $item){
		$product = $item->product();
		if($product instanceof Product)
		foreach($product->getLeafProducts() as $product){
			if($product->isDownloadable())
				$downloadable[] = $product;
		}
	}
	
	if($downloadable){
?>
<h2>Downloadable Products</h2>
<p>Some of the products you purchased are digital, you can get these from the following links:</p>
<ul>
<? foreach($downloadable as $product) { ?>
	<li><a href='<?=$product->download_link()?>'><?=$product->getLabel()?></a></li>
<? } ?>
</ul>
<? } ?>
</body>
</html>
