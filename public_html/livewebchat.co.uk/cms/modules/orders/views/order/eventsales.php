<?
/**
* @package Boz_Orders
*/

	$date = $_GET['date'];
	if(!$date) $date = date("Y-m");
	list($year,$month) = explode("-",$date);
	$venue_uid=$_GET['venue'];
	if(!$venue_uid) $venue_uid=1;

?>
<style>
	.date-select {
		float: left;
		margin: 5px;
	}
</style>
<div class='willcall'>
<div class='list-header no-print'>
<h3>Sales By Event</h3>
<div class='date-links'>
<?
	$yeart = date("Y");
	echo "<select name='event-year' id='event-year'>";
	for($a=$yeart+10;$a>$yeart-10; $a--){
		$selected = ($a==$year) ? "selected='true'":"";
		echo "<option value='$a' $selected>$a</option>";
	}
	echo "</select>";
	echo "<select name='event-month' id='event-month'>";
	for($a = 1 ; $a<=12 ; $a++){
		$text = date("M",mktime(12,0,0,$a,1,$year));
		$selected = ($a==$month) ? "selected='true'":"";
		echo "<option value='$a' $selected>$text</option>";
	}
	echo "</select>";
	echo "<select name='event-venue' id='event-venue'>";
	foreach(Model::loadModel('Venue')->getAll() as $venue){
		$selected = ($venue->uid==$venue_uid) ? "selected='true'":"";
		echo "<option value='$venue->uid' $selected>$venue->title</option>";
	}
	echo "</select>";
		
?>
<input type='submit' value='Go' class='date_button' />
<script>
	Event.observe($$('.date_button')[0],'click',function(){
		document.location.href="despatch.php?model=Order&action=eventsales&date="+$F('event-year')+"-"+$F('event-month')+"&venue="+$F('event-venue');
	});
</script>

<div style='clear: both;'></div>
</div>
<?
	$date = $_GET['date'];
	if(!$date) $date = date("Y-m");
	list($year,$month) = explode("-",$date);

	$currEvents = $model->loadModel('Event')->getAll(
		array(
			'date >='=>"$year-$month-01",
			'date <'=>($year+(floor($month/12)?1:0))."-".(($month%12)+1)."-01",
			'venue_uid'=>$venue_uid
		), 
		array(
			'order'=>'date'
		)
	);
	$events = $tickets = array();
	foreach($currEvents as $event){
		foreach($event->tickets() as $ticket){
			if(!array_key_exists($ticket->getId(),$events)){
				$events[$ticket->getId()] = $event->getLabel()." - ".$ticket->ticket_type()->getLabel();
				$available[$ticket->getId()] = $ticket->ticketsAvailable;
			}
			$orderList = $ticket->orders(array('order_state.name'=>'Complete'),array('for_fetch'=>true));
			while($order = $orderList->fetch()){
				$tickets[$ticket->getID()][$order->price]+=$order->quantity;
			}
			$willcall[$ticket->getID()] = "despatch.php?action=willcall&pageType=orders&event=$event->uid";
		}
	}
?>
	<h3>Sales For Date <?=date(" F  Y",mktime(0,0,0,$month,1,$year))?></h3>

<table border="yes" style='width: 100%;'>
	<tr><th>Event</th><th>Tickets</th><th>Price</th><th>Total</th></tr>
<?
	$ttotal = 0;
	$tqty = 0;
	foreach($events as $id=>$event_name){
		$etotal=0;
		$eqty=0;
		if(!$tickets[$id]) continue;
		foreach($tickets[$id] as $price=>$qty){
			$subTotal = $price*$qty;
			echo "<tr><td>$event_name</td><td>$qty</td><td>$price</td><td>".number_format($subTotal,2)."</td></tr>";
			$etotal+=$subTotal;
			$eqty+=$qty;
		}
		echo "<tr><td class='orderSubtotal' style='color:#FFF000'><b>Sub Total</b> - [<a href='$willcall[$id]'>Will Call]</a></td><td class='orderSubtotal' style='color:#FFF000'>$eqty (Tickets Sold)</td><td class='orderSubtotal' style='color:#FFF000'>".$available[$id]." ( Tickets left)</td><td style='color:#FFF000'><b>".number_format($etotal,2)."</b></td></tr>";
		$ttotal+=$etotal;
		$tqty+=$eqty;
	}
?>
	<tr><td>Total No Of Ticket Sales</td><td colspan='3'><?=$tqty?></td></tr>
	<tr><td>Total Value of Ticket Sales</td><td colspan='3'>&pound;<?=number_format($ttotal,2)?></td></tr>
</table>
</div>
