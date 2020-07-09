<?
	require_once(__MODELS_BASE__.'/fields/MyPassword.php');
	class CardDate extends CompositeField {
		function __construct($name,$params){
			list($start,$end) = $params['years'];
			if(!$start) $start = date("Y")-20;
			if(!$end) $end = date("Y")+20;
			$years = range($start,$end);
			$years = array_combine($years,$years);
			$fields = array(
				$name.'month'=>new DropDownField($name.'month',array('options'=>array(1=>1,2,3,4,5,6,7,8,9,10,11,12),'label'=>ucwords(str_replace("_"," ",$name)." Month"),'required'=>@$params['required'])),
				$name.'year'=>new DropDownField($name.'year',array('options'=>$years,'label'=>ucwords(str_replace("_"," ",$name)." Year"),'required'=>@$params['required'])),
			);
			parent::__construct($name,$fields,$params);
		}
		function renderTo($obj){
			return Field::renderTo($obj);
		}
		function renderHtml($obj){
			$html='';
			foreach($this->fields as $k => $v){
				$html.="<div class='$k'>".($v->renderHtml($obj))."</div>";
			}
			return $html;
		}
		function transformPostData($post,$obj){
			parent::transformPostData($post,$obj);
			$name = $this->name;
			$this->setValue($obj,$this->getValue($obj,$name.'month').'/'.$this->getValue($obj,$name.'year'));
		}
		function validate($obj){
			if($this->param('required',false)){
				if(!($this->getValue($obj,$this->name.'month') && $this->getValue($obj,$this->name.'year'))){
					$obj->validation_errors[$this->name] = $this->getLabel()." is required";
					return false;
				}
			}
			return true;
		}
	}
?>
