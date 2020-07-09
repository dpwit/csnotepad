<?
/**
* @package Boz_Orders
*/

	require_once(dirname(__FILE__).'/OrderModel.php');
	class SubscriptionOrder extends BaseOrder {
		function __construct($obj=null){
			parent::__construct($obj,'order');
			$this->hasMany('subscriptions');
			$this->payment_type='subscription_start';
		}
		function getDeletedWhere(){
			return array('payment_type !='=>'subscription_start');
		}
		function subscription($where=array(),$params=array()){
			$params['single'] = 1;
			return $this->subscriptions($where,$params);
		}
		function getFields(){
			parent::getFields();
			$this->fields['payment_type']->setParam('default','subscription_start');
			return $this->fields;
		}

		var $isFree = false;
		function processFree(){
			$this->isFree=true;
			parent::processFree();
			$this->isFree=false;
		}
		function processPayment(){
			if(!$this->isFree){
				return $this->getGateway()->createSubscription($this);
			}
		}
		function on_orderConfirmed(){
			parent::on_orderConfirmed();
			$sub = $this->createSubscription();
			$sub->writeToDB();
		}

		function createSubscription(){
			$sub = Model::loadModel('Subscription')->createNew(
				array(
					'order_uid'=>$this->getId(),
					'user_uid'=>$this->user()->getId(),
					'type'=>$this->isFree ? 'free' : 'paid',
					'status'=>'running',
					'last_validated'=>date("Y-m-d"),
				)
			);
			return $sub;
		}
		function isSubscription(){
			return true;
		}
	}
	class SubscriptionRepeatOrder extends BaseOrder {
		function __construct($obj=null){
			parent::__construct($obj,'order');
			$this->hasOne('subscription');
			$this->hasThrough('order','subscription',array('model'=>'GenericOrder'));
			$this->payment_type='subscription_repeat';
		}

		function getDeletedWhere(){
			return array('payment_type !='=>'subscription_repeat');
		}
		function on_orderConfirmed(){
			parent::on_orderConfirmed();
			$s = $this->subscription();
			$s->last_validated=date("Y-m-d",$this->ctime);
			$s->status='running';
			$s->writeToDB();
		}
		function on_orderFailed(){
			parent::on_orderConfirmed();
			$s = $this->subscription();
			$s->paymentFailed();
		}

		function processManually(){
			$gw = $this->getGateway();
			$gw->reprocessSubscription($this,$this->subscription());
		}
		function isSubscription(){
			return true;
		}
	}
	class Subscription extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'subscription');
			$this->hasOne('order',array('model'=>'SubscriptionOrder'));
			$this->hasThrough('order_items','order');
			$this->hasThrough('user','order');
			$this->hasMany('repeats',array('model'=>'SubscriptionRepeatOrder'));
		}
		function getTextFields(){
			return array('user.realName','user.userid');
		}
		function getListingColumns(){
			$cols = parent::getListingColumns();
			$cols['Name'] = $this->user()->realName;
			$cols['Status'] = $this->status;
			$cols['Renewed'] = $this->last_validated;
			return $cols;
		}
		function getGateway(){
			$order = $this->order();
			return $order ? $order->getGateway() : null;
		}
		function requireRenewal($where=array(),$params = array()){
			$where['status'] = 'running';
			$where['last_validated <']=date("Y-m-d",strtotime("-1 month"));
			return $this->getAll($where,$params);
		}
		function createRepeat(){
			$order = $this->order();
			$repeat = Model::loadModel('SubscriptionRepeatOrder')->createNew(array(
				'subscription_uid'=>$this->getId(),
				'user_uid'=>$order->user_uid,
			));

			foreach($order->order_items() as $item){
				$repeat->addItem($item->createCopy(false));
			}
			cms_trigger_action('repeating_subscription',$repeat);
			$repeat->writeToDB();
			return $repeat;
		}
		function attemptRenewal(){
			if(!$order = $this->order()) {
				error_log("Subscription $this has no order - cannot renew");
				$this->cannotRenew();
				return;
			}
			$gw = $this->getGateway();
			$features = $gw ? $gw->getFeatures() : array();
			if(($this->type=='free') || ($features['manualRenewal'])){
				$new = $this->createRepeat();
				switch($this->type){
				case 'free':
					$new->processFree();
					break;
				default:
					$new->processManually();
					break;
				}

				if($new->isComplete()){
					return true;
				}
			}

			$this->cannotRenew();
		}

		function cannotRenew(){
			$gw = $this->getGateway();
			$features = $gw ? $gw->getFeatures() : array();
			if($features['autoRenewal']){
				if(strtotime($this->last_validated)<strtotime("-1 week",strtotime("-1 month"))){
					// Out of date by 1 week - cancel subscription
					$this->paymentFailed();
				}
			} else {
				$this->paymentFailed();
			}
		}

		function cancel(){
			$this->status='cancelled';
			$this->writeToDB();
		}
		function paymentFailed(){
			$this->status='failed';
			$this->writeToDB();
		}
	}
?>
