<?
/**
* @package Boz_Orders
*/
	cms_listen_action('model_listing_end','order_total');
	global $orderStats;
	$orderStats=array('count'=>0,'sum'=>0);
	function order_total($order){
		global $orderStats;
		$orderStats['count']++;
		$orderStats['sum']+=$order->getTotal();
	}
