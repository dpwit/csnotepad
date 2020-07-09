
<div id="shop" class="thinBorder box">
		<h3>Checkout : Stage 2 of 2</h3>
		<p>Please review the order details</p>

		<table class="basket">
<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>			
<? foreach($order->order_items() as $item){ ?>
				<tr>
					<td class="item">
						<?php
							try{
								$cat = "";
								if($item->ref_table=="products"){
									$prod=$item->product();
									if($prod->variation_of())
										$cat = $prod->variation_of()->categories(array(),array('single'=>true));
									else
										$cat = $prod->categories(array(),array('single'=>true));
									$cat = $cat->name;
								}
							}
							catch(Exception $ex){
								$cat = "Uncategorised";
							}
						if($cat){ ?><strong><?=$cat?></strong><br /><?php }
						?><?=$item->getLabel()?><br />
						<?php
							if($questionnaireData = json_decode($item->questionnaireData)){
								?><br><?php
								?><strong>Form Criteria</strong><?php
								?><dl><?php
									foreach($questionnaireData as $q=>$a)
									{
										?><dt><?=$q?></dt><?php
										?><dd><?=$a?></dd><?php
									}
								?></dl><?php
							}
						?>
					</td>
					<td class="quantity"><?=$item->getDisplayQuantity()?></td>
					<td class="price"><?=$item->getTotalPriceFormatted(false)?></td>
				</tr>
			<? } ?>
			<!--<tr><td colspan="3" class="midheight">&nbsp;</td></tr>-->
			<tr><td colspan="2"><strong>Total</strong></td><td class="basketPrice"><strong><?=$order->getPrice(true)?></strong></td></tr>
		</table><br><br />
		<table class="basket">
		<thead><tr><th class="basketItem" colspan="3">Details <a href='<?=$screen->changeAddressLink('card')?>'>[Edit]</a></th></tr></thead>
			<tr><td class="detailstd">Name</td><td><?=$order->customer_title?> <?=$order->customer_firstname?> <?=$order->customer_lastname?></td></tr>
			<? if($order->requiresShipping()){ ?>
			<tr><td>Delivery Address</td><td><?=$order->customer_address?>, <?=$order->customer_city?>, <?=$order->customer_country?>, <?=$order->customer_postcode?> <a href='<?=$screen->changeAddressLink('customer')?>'>[change]</a></td></tr>
			<? } ?>
			<? if($order->requiresBillingAddress()){ ?>
			<tr><td class="detailstd">Billing Address</td><td><?=$order->card_address?>, <?=$order->card_city?>, <?=$order->card_country?>, <?=$order->card_postcode?></td></tr>
			<? } ?>
			<? if(true || extra_checkout_fields::isCMSLoggedIn()){ ?>
			<tr><td class="detailstd">Company Name</td><td><?=$order->company_name?></td></tr>
			<tr><td class="detailstd">Company Address</td><td><?=$order->company_address?></td></tr>
			<tr><td class="detailstd">Company Role</td><td><?=$order->company_position?></td></tr>
			<tr><td class="detailstd">Company Activity</td><td><?=$order->company_activity?></td></tr>
			<tr><td class="detailstd">Company Telephone</td><td><?=$order->company_phone?></td></tr>
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