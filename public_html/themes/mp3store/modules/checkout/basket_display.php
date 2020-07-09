<h2 class="headerText">Basket</h2>
<table>
<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>			
<? foreach($order->order_items_no_extras() as $item){ ?>
				<tr><td><?=$item->getLabel()?></td><td> <?=$item->getQuantity()?> </td><td class="basketPrice"><?=$item->getTotalPriceFormatted()?></td></tr>
			<? } ?>
			<tr><td>Total </td><td></td><td class="basketPrice"><?=$order->getPrice(false)?></td></tr>
		</table>
<br/>
<form method='post'><?=$this->getHiddenForm()?>
<div class="submitButton">
	<input type='submit' name='confirm' class='buttonSubmit' value='Next'/>
</div>
</form>
 
