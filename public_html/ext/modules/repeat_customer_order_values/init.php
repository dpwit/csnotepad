<?php

class repeat_customer_order_values{

	function __construct(){
		cms_listen_action('order_state_changed',$this);
		cms_listen_action('basket_copied_to_order',$this);
	}
	
	function order_state_changed($orderItem)
	{
		$_SESSION['previousOrder_uid'] = $orderItem->order_uid;
	}
	
	static $alreadyRun = false;
	
	function basket_copied_to_order($basket,$order)
	{
	
		if(!@$_SESSION['previousOrder_uid'])
			return;

		if($this->alreadyRun) 
			return; 
		else
			$this->alreadyRun = true;
		
		$prevOrder = $order->getFirst(array('uid'=>$_SESSION['previousOrder_uid']));
		if($prevOrder){
			$order->customer_email = $prevOrder->customer_email;
			$order->customer_title = $prevOrder->customer_title;
			$order->customer_firstname = $prevOrder->customer_firstname;
			$order->customer_middlename = $prevOrder->customer_middlename;
			$order->customer_lastname = $prevOrder->customer_lastname;
			$order->customer_address = $prevOrder->customer_address;
			$order->customer_city = $prevOrder->customer_city;
			$order->customer_country = $prevOrder->customer_country;
			$order->customer_postcode = $prevOrder->customer_postcode;
			$order->customer_phone = $prevOrder->customer_phone;
			$order->customer_mobile = $prevOrder->customer_mobile;
			$order->card_title = $prevOrder->card_title;
			$order->card_firstname = $prevOrder->card_firstname;
			$order->card_middlename = $prevOrder->card_middlename;
			$order->card_lastname = $prevOrder->card_lastname;
			$order->card_address = $prevOrder->card_address;
			$order->card_city = $prevOrder->card_city;
			$order->card_country = $prevOrder->card_country;
			$order->card_postcode = $prevOrder->card_postcode;

			$order->company_position = $prevOrder->company_position;
			$order->refered_from = $prevOrder->refered_from;
			$order->company_name = $prevOrder->company_name;
			$order->company_activity = $prevOrder->company_activity;
			$order->company_address = $prevOrder->company_address;
			$order->company_phone = $prevOrder->company_phone;
			}
	}

}

new repeat_customer_order_values;

?>