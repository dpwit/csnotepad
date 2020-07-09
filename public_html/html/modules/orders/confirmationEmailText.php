Dear <?=$this->customer_title?> <?=$this->customer_lastname?>

We will be in contact shortly to arrange the setup of your service.

Order details:

Item					Quantity	Price
<?

foreach($this->order_items() as $item){
?>
<?=$item->getLabel()?>		<?=number_format($item->quantity,0)?>	<?=$item->getTotalPriceFormatted(false)?>
<? } ?>
Total		<?=$this->getPrice(true)?>

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
	
	if($downloadable && false){
?>

*Download URLS*

Some of the products you purchased are digital, you can get these from the following links:

<? foreach($downloadable as $product) { ?>
	* <?=$product->getLabel()?> - <?=$product->download_link()?>
<? } ?>
<? } ?>

Billing Address:
<?=$this->customer_address?>, <?=$this->customer_city?>, <?=$this->customer_country?>, <?=$this->customer_postcode?>

Telephone Number:
<?=$this->customer_phone?>

<?php /*if(true || extra_checkout_fields::isCMSLoggedIn()){*/ ?>
Company Name:
<?=$this->company_name?>

Your Role:
<?=$this->company_position?>

Company Address:
<?=$this->company_address?>

Company Activity:
<?=$this->company_activity?>

Company Phone Number:
<?=$this->company_phone?>

Where You Heard About Us:
<?=$this->refered_from?>

Prefered Contact Method:
<?=$this->prefered_contact?>
<?php /*}*/ ?>

CSnotepad, Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD
T: 0330 300 3990, F: 0330 300 3991
Use of your service constitutes acceptance of our pricing and terms and conditions. CSnotepad is a trading division of Call Solution Ltd Registered in England 6107188.