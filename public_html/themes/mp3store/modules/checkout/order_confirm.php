<div id="shop" class="thinBorder box">
		<h3>Please Review the order details</h3>

		<table class="basket">
<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>			
<? foreach($order->order_items() as $item){ ?>
				<tr><td class="item"><?=$item->getLabel()?></td><td class="quantity"><?=$item->getDisplayQuantity()?> </td><td class="price"><?=$item->getTotalPriceFormatted(false)?></td></tr>
			<? } ?>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr><td>Total </td><td></td><td class="basketPrice"><?=$order->getPrice(true)?></td></tr>
		</table>
<br/><br/>
		<table class="basket">
		<thead><tr><th class="basketItem" colspan="3">Details</th></tr></thead>
			<tr><td class="detailstd">Name</td><td><?=$order->customer_title?> <?=$order->customer_firstname?> <?=$order->customer_lastname?></td></tr>
			<? if($order->requiresShipping()){ ?>
			<tr><td>Delivery Address</td><td><?=$order->customer_address?> <?=$order->customer_city?> <?=$order->customer_postcode?> <?=$order->customer_country?> <a href='<?=$screen->changeAddressLink('customer')?>'>[change]</a></td></tr>
			<? } ?>
			<? if($order->requiresBillingAddress()){ ?>
			<tr><td class="detailstd">Billing Address</td><td><?=$order->card_address?> <?=$order->card_city?> <?=$order->card_postcode?> <?=$order->card_country?> <a href='<?=$screen->changeAddressLink('card')?>'>[change]</a></td></tr>
			<? } ?>
<? if(@$order->card_number) { ?>
			<tr><td>Card</td><td><?=$order->obfuscatedCardDetails()?></td></tr>
<? } ?>
		</table>
<? 
	try {	
?>
<?$hidden = $this->getHiddenForm();?>
<form method='post'><?=$hidden?>
<div class="submitButton formButtons" style="margin-top: 10px;">
	<input type='submit' name='confirm' class='coolButton' value='Confirm Order'/>
</div>
</form>
<?	} catch(Exception $e){
}?>
</div>