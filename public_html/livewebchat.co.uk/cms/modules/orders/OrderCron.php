<?
/**
* @package Boz_Orders
*/

	class OrderCron extends TaggedCronJob {
		function __construct(){
			parent::__construct("daily_orders");
		}
		function shouldRun(){
			$day = date("d/M/Y");
			$last = date("d/M/Y",$this->lastRan());
			return ($day!=$last);
		}
		function run(){
			$now = time();
			$last = $this->lastRan();
			if($now-$last>3600*48) $last = $now-3600*48;
			ob_start();
			$order = Model::loadModel('GenericOrder');
			require(dirname(__FILE__).'/views/order/dailySummary.php');
			$msg = ob_get_contents();
			ob_end_clean();
			$order->__sendMail($order->adminEmail,
				__SERVER_DOMAIN__." Order Summary ".date("d/M/Y",$now),
				strip_tags($msg),$msg);

			$this->markRan($now);
		}
	}
?>
