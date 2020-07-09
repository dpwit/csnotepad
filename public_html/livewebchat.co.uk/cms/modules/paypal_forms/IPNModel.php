<?
/**
* @package Boz_Orders
*/

	class IPN extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'paypal_ipn');
		}

		function getFields(){
			parent::getFields();
			require_once(dirname(__FILE__).'/fields/JSONFields.php');
			$this->fields['ip'] = new ConstantField('ip',array('default'=>$_SERVER['REMOTE_ADDR']));
			$this->fields['post'] = new JSONField('post');
			$this->fields['get'] = new JSONField('get');
			return $this->fields;
		}
		function on_model_instantiated(){
			$this->post = json_decode($this->post,true);
			$this->get = json_decode($this->get,true);
		}
		function order(){
			return Model::g('Order',$this->post['transaction_subject']);
		}
		function getAssignArray(){
			$array = parent::getAssignArray();
			$array['post'] = json_encode($this->post);
			$array['get'] = json_encode($this->get);
			if($this->post['test_ipn']){
				$array['mode']='test';
			}
			return $array;
		}
	}
?>
