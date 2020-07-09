<?php

	class product_pro_rata_ext
	{

		function __construct()
		{
			cms_listen_action('items_added',$this);
			cms_listen_action('items_modified',$this);
		}
		
		function items_added($order,$orderItem)
		{
			if($orderItem->ref_table!="products") return;
			$product = $orderItem->product();
			if($product->product_type_uid==19) return;
			//if($product->product_type_uid<7 || $product->product_type_uid>12) return;

			foreach($product->product_attribute_options() as $att_op)
				if(false !== strpos($att_op->name,'Annual '))
					return;
			
			$daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
			$daysLeft = $daysInMonth - date('d');
			$perDayAmount = $product->price / $daysInMonth;
			$proRataAmmount = number_format($perDayAmount * $daysLeft,2);
			$proRataAmmount = round($perDayAmount * $daysLeft,2);

		
			if($proRataAmmount=="0.00") 
				return;
			
			$catName = $product->categories();
			$catName = $catName[0]->name;
			
			$proRataItem = $order->addItem("<strong>$catName</strong><br />" . $orderItem->name." - Pro Rata - Current Month",$proRataAmmount,1,"order_items",$orderItem->uid);
			$proRataItem->sorting = $orderItem->sorting-0.2;
			$proRataItem->writeToDB();
		}
		
		var $internal=false;
		
		function items_modified($order)
		{
			if($this->internal) return;
			$this->internal=true;
			
			foreach($order->order_items(array("ref_table"=>"order_items"),array()) as $item)
				if(!$order->order_items(array("uid"=>$item->ref_id),array()))
					$item->delete();
			
			$this->internal=false;
		}

	}

	new product_pro_rata_ext();