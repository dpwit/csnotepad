<?
/**
* @package Boz_Orders
*/

	$orders = $order->getAll(array(
		'ctime >='=>$last, 'ctime <'=>$now,
		'order_state_uid'=>3
		)
	);

	$totals = array();
	foreach($orders as $order){
		$totals[$order->ticket()->event()->getLabel()][$order->ticket()->description()][$order->ticket()->nicePrice()]['qty'] += $order->quantity;
		$totals[$order->ticket()->event()->getLabel()][$order->ticket()->description()][$order->ticket()->nicePrice()]['bf'] = "&pound;".number_format($order->booking_fee,2);
	}
	ksort($totals);
	$total = 0;
	$tnum = 0;
	$dateFormat = "d/M/Y H:i";
	echo "<h2>Summary of orders from ".date( $dateFormat ,$last)." to ".date($dateFormat,$now)."</h2>";
	echo "<table>";
	foreach($totals as $event=>$tickets){
		foreach($tickets as $type=>$prices){
			foreach($prices as $price=>$stats){
				$quantity=$stats['qty'];
				$bf = $stats['bf'];
				echo "<tr><td>$event</td><td>$type</td>";
				echo "<td>$quantity</td> <td>x</td> <td>$price</td> <td>+</td><td>$bf</td>\n";
				$total+=$quantity*str_replace("&pound;","",$price);
				$tnum+=$quantity;
			}
		}
	}
	echo "</table>";
	echo "<p>Total of $tnum tickets at &pound; ".number_format($total,2)."</p>";
?>
