<?
	class OrderTypeFilter extends ListingFilter {
		function __construct(){
			parent::__construct('By Type',array('One Off','Subscription','New Subscription'));
		}

		function getTypes($name){
			$types = array(
				0=>array('oneoff'),
				1=>array('subscription_start','subscription_repeat'),
				2=>array('subscription_start'),
			);
			return $types[$name];
		}

		function restrict($model,$restrict,$selected=null){
			if(is_null($selected)) $selected = $this->getSelected();
			if($selected!='any')
				$restrict['payment_type in']=$this->getTypes($selected);
			return $restrict;
		}
	}
	class OrderDateFilter extends ListingFilter {
		function __construct(){
			parent::__construct('By Month',$this->getMonths());
		}

		function getMonths(){
			$date = mktime(0,0,0,date("n"),1,date("Y"));
			$options = array();
			for($a = 0 ; $a<24 ; $a++){
				$options[$date] = date("M Y",$date);
				$date = strtotime("-1 month",$date);
			}
			return $options;
			return array_reverse($options,true);
		}

		function restrict($model,$restrict,$selected=null){
			if(is_null($selected)) $selected = $this->getSelected();
			if($selected!='any'){
				$restrict['ctime >=']=$selected;
				$restrict['ctime <']=strtotime("+1 month",$selected);
			} 
			return $restrict;
		}
	}
?>
