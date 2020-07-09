<div class="last box thinBorder" id="shop">
<!--<h2 class="headerText">Items in Cart</h2>-->
<?
	$err.=$errors;
	if($err) {
?>
<div class='errors'>
<p>Some of the products selected are not available:</p>
<?=paragraphs($err)?>
</div>
<? } ?>
<form method='post'><?=$this->getHiddenForm()?>
		<table class="basket" cellspacing="5">
<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>			
			<? foreach($order->order_items_no_extras() as $item){ ?>
				<tr><td class="item"> <?=$this->view($context,'modules/checkout/item-description',array('item'=>$item))?> </td><td class="quantity"> <input class="inputQty" type="text" name='qty[<?=$item->getId()?>]' value='<?=$item->getQuantity()?>' size='2'/></td><td class="checkoutPrice"><?=$item->getTotalPriceFormatted()?></td></tr>
			<? } ?>
			<tr><td><strong>Total</strong></td><td></td><td class="checkoutPrice totalCost"><?=$order->getPrice(false)?></td></tr>
		</table>

<div class='payment-navigation'>
<div class="formButtons">
	<input type='submit' name='back' id="back" class="coolButton" value='Back'/>

	<input type='submit' name='update' id="update" class="coolButton" value='Update Cart'/>

	<input type='submit' name='confirm' id="next" class="coolButton" value='Checkout'/>
</div>
</div>
</form>
</div>