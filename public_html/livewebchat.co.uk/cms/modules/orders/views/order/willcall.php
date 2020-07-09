<?
/**
* @package Boz_Orders
*/

?>
<div class='willcall'>
<div class='list-header'>
<div class='list-header-left'>
<h3><?=$event->getStatus()?></h3>
</div>
<div class='list-header-right'>
<h3><?=$event->title?></h3>
<p><?=$event->niceDate()?> @ <?=$event->startTime?></p>
<?  foreach($event->tickets() as $ticket){?>
<p>
	<?=$ticket->nicePrice()?> - <?=$ticket->description()?>
</p>
<? } ?>
</div>

<div class='list-header'>
<h3>CREDIT CARD FRAUD PREVENTION POLICY</h3>
<p>ALL WILL-CALL TICKET HOLDERS MUST PRESENT THE ORIGINAL CREDIT CARD USED FOR PURCHASE IN ORDER TO PICK UP TICKETS. YOU MUST VERIFY THAT NAME ON CREDIT CARD AND LAST FOUR DIGITS OF CARD NUMBER MATCH ORDER INFORMATION. FOR SECURITY REASONS, THERE CAN BE NO EXCEPTIONS TO THIS POLICY.</p>
</div>
<h3>
<?
switch($event->status){
case 1:
?>
TICKETS ARE STILL ON SALE - THIS LIST IS NOT FINAL
<?
	break;
case 2:
?>
THIS IS THE FINAL WILL CALL LIST - TICKETS ARE NO LONGER BEING SOLD
<?
	break;
default:
?>
BOOKING HAS NOT BEEN CLOSED - THIS LIST IS NOT FINAL
<?
}
?>
</h3>
<table border="yes" style='width: 100%;'>
	<tr><th>Name</th><th> Email</th><th>Tickets</th><th>Reference</th><th>Post Code</th><th>Ident</th><th>Amount</th></tr>
<?
	$ttn = 0;
	$ttp = 0;
foreach($event->tickets() as $ticket){
?>
	<tr><td colspan='7' align='center'><strong><?=$ticket->description()?></strong></td></tr>
<?
	$totalNumber = $totalPrice = 0;
	foreach($ticket->orders(array('order_state_uid'=>3),array('order'=>'customer_lastname')) as $order){
		$totalNumber+=$order->quantity;
		$totalPrice +=$order->quantity*$order->price;
?>
	<tr><td><?=$order->customer_lastname?>, <?=$order->customer_firstname?></td><td> <?=$order->customer_email?> </td>
<td><?=$order->quantity?>
&nbsp;&nbsp;
<? for($a = 0 ; $a<$order->quantity ; $a++){ ?>
[ ]
<? } ?>
</td><td><?=$order->order_ref?></td>
<td><?=$order->customer_postcode?></td>
<td><?=$order->display_card?></td>
<td><?=$order->getPrice(false);?></td></tr>
<?
	}
	$ttn+=$totalNumber;
	$ttp+=$totalPrice;
?>
	<tr><td><strong>Total No Of <?=$ticket->description()?></strong></td><td colspan='6'><?=$totalNumber?></td></tr>
	<tr><td><strong>Total Value of <?=$ticket->description()?></strong></td><td colspan='6'>&pound;<?=number_format($totalPrice,2)?></td></tr>
<?
}
?>
	<tr><td colspan='7'>&nbsp;</td></tr>
	<tr><td colspan='7'>&nbsp;</td></tr>
	<tr><td><strong>Total No Of Ticket Sales</strong></td><td colspan='6'><?=$ttn?></td></tr>
	<tr><td><strong>Total Value of Ticket Sales</strong></td><td colspan='6'>&pound;<?=number_format($ttp,2)?></td></tr>
</table>
</div>
