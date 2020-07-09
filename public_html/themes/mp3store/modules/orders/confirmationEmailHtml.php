<html>
<body style='background: white; color: black; font-size: 14px; width: 600px;'>
<p style="font-family: Arial">Dear <?=$this->customer_title?> <?=$this->customer_lastname?></p>

<p style="font-family: Arial">Thank you for shopping at <?=Config::value('title','site')?>, your order has been accepted.</p>

<p style="font-family: Arial">Order details:</p>

<table><tr><th width="80%" style="border-bottom:4px double black; font-family: Arial">Item</th><th width="10%" style="border-bottom:4px double black" align="center">Quantity</th><th width="10%" style="border-bottom:4px double black" align="right">Price</th></tr>
<?

foreach($this->order_items() as $item){
?>
	<tr><td width="80%"><?=$item->getLabel()?></td><td width="10%" align="center"><?=$item->quantity?></td><td width="10%" align="right"><?=$item->getPrice()?></td></tr>
<? } ?>

</table>
<p style="font-family: Arial">Your items will be posted to your address in the next 2-3 working days, subject to availability.</p>
<p style="font-family: Arial">If you have ordered any digital products, you can download them by <a href="<?=MASTERURL?>/login.html">logging in</a> to your account and clicking on your recent orders.</p>
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
<h2 style="font-family: Arial">Downloadable Products</h2>
<?php /*<p style="font-family: Arial">Some of the products you purchased are digital, you can get these from the following links:</p>*/?>
<p style="font-family: Arial">Your MP3s are ready for you to download. Please login by clicking <a href="<?=MASTERURL?>/login.html">here</a> and go to your recent orders to download them.</p>
<ul>
<? foreach($downloadable as $product) { ?>
	<li><a href='<?=$product->download_link()?>'><?=$product->getLabel()?></a></li>
<? } ?>
</ul>
<? } ?>
</body>
</html>
