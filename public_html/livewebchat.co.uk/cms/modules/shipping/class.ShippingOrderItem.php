<?
	Model::loadModel('Order_Item');
	class ShippingOrderItem extends Extra_Charge {
		function getFields(){
			parent::getFields();
			$this->fields['name']->setDefault('Shipping');
			return $this->fields;
		}

		function getAssignArray($obj=null){
			$ass=parent::getAssignArray($obj);
			if(!$obj) $obj=$this;
			$ass['ref_table'] = 'shipping';
			return $ass;
		}

		function setWeight($weight){
			$cost = Config::value('default_shipping_cost','orders');
			if(Config::value('shipping_by_weight','orders')){
				$country = $this->order()->customer_country;
				$shipping = Model::loadModel('ShippingCost')->getFirst(array('country_code'=>$country,'from_weight <'=>$weight),array('order'=>'from_weight desc'));
				if(!$shipping){
					$this->initCountries();
					$shipping = Model::loadModel('ShippingCost')->getFirst(array('region_code'=>@self::$regions[$country],'from_weight <'=>$weight),array('order'=>'from_weight desc'));
				}
				if(!$shipping){
					$shipping = Model::loadModel('ShippingCost')->getFirst(array('region_code'=>'WW','from_weight <'=>$weight),array('order'=>'from_weight desc'));
				}
				if($shipping) {
					$cost = $shipping->price;
				}
				$cost += Config::value('shipping_tare_price','orders');
			}
			$this->setPrice($cost);
			$this->quantity=1;
			$this->triggerAction('orders_shipping_calculating',$weight);

			$this->writeToDB();
		}
		static $countries=false;
		static $regions=false;
		function initCountries(){
			if(!self::$countries){
				include(cms_module_resolve('orders','data/countries.php'));
				self::$regions=$regions;
			}
		}

		function isExtra(){
			return true;
		}

		function isTaxable(){
			return false;
		}
	}
?>
