Dear <?=$this->customer_title?> <?=$this->customer_lastname?>

Your order has been accepted:

Item					Quantity	Price
<?

foreach($this->order_items() as $item){
?>
<?=$item->getLabel()?>		<?=$item->quantity?>	<?=$item->getPrice()?>
<? } ?>

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

*Download URLS*

Some of the products you purchased are digital, you can get these from the following links:

<? foreach($downloadable as $product) { ?>
	* <?=$product->getLabel()?> - <?=$product->download_link()?>
<? } ?>
<? } ?>
