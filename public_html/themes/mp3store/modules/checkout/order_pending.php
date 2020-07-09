<div id="shop" class="thinBorder box">
<h2>Order Pending</h2>
<p>Your order is currently processing, you will receive notification by email when it is complete.</p>
		<table class='order-summary'>
			<? foreach($order->order_items() as $item){ ?>
				<tr><td><?=$item->getLabel()?></td><td> <?=$item->getQuantity()?> </td><td><?=$item->getTotalPriceFormatted()?></td></tr>
			<? } ?>
			<tr><td>Total </td><td> - </td><td><?=$order->getPrice()?></td></tr>
		</table>
</div>