<html>
<body style='background: white; color: black;  font-size: 12px; width: 600px;'>
<p>Dear <?=$this->customer_title?> <?=$this->customer_lastname?></p>

<p>Your order has been accepted:</p>

<table><tr><th>Item</th><th>Quantity</th><th>Price</th></tr>
<?

foreach($this->order_items() as $item){
?>
	<tr><td><?=$item->getLabel()?></td><td><?=$item->quantity?></td><td><?=$item->getPrice()?></td></tr>
<? } ?>
</table>

