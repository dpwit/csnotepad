
		<table class="basket">
<thead><tr><th class="basketItem">Item</th><th class="basketQty">Qty</th><th class="basketPrice">Price</th></tr></thead>			
			<? foreach($order->order_items_no_extras() as $item){ ?>
				<tr><td class="item">
<?=$this->view($context,'modules/checkout/item-description',array('item'=>$item))?>
</td><td class="quantity"> <?=$item->getQuantity()?></td><td class="basketPrice"><?=$item->getTotalPriceFormatted()?></td></tr>
			<? } ?>
			<tr><td>Total </td><td class="basketQty">-</td><td class="basketPrice totalCost"><?=$order->getPrice(false)?></td></tr>
		</table>
