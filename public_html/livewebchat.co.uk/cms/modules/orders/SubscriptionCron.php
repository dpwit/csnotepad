<?
/**
* @package Boz_Orders
*/

	class SubscriptionCron extends CronJob {
		function __construct(){
			parent::__construct(1);
		}
		function run(){
			$expiring = Model::loadModel('Subscription')->requireRenewal(array(),array('for_fetch'=>1));
			while($sub = $expiring->fetch()){
				$sub->attemptRenewal();
			}
			$this->markRan(time());
		}
	}
?>
