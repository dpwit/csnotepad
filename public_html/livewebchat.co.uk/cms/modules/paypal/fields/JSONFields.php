<?
/**
* @package Boz_Orders
*/

	class JSONField extends Field {
		function transformPostData(){
			return true;
		}
		function renderHTML($obj){
			$value = $this->getValue($obj);
			ob_start();
			print_r($value);
			$data = ob_get_contents();
			ob_end_clean();
			return "<pre>$data</pre>";
		}
	}
?>
