<?
/**
* @package Model_System
*/

class RadioDecorator extends Decorator {
	function renderHTML($obj){
		$useKeys = $this->param('useKeys',true);
		$value = $this->getValue($obj);
		$name = $this->htmlName($obj);
		foreach($this->getOptions($obj) as $k=>$v){
			if(!$useKeys) $k=$v;
			$label =ucwords($v);
			$selected = ($k==$value) ? " checked='true'":"";
			$output .= "<div class='radio_item'><input type='radio' name='$name' id='$name.$k'$selected value='$k'/><label class='radio_label' for='$name.$k'>$label</label></div>";
		}
		return $output;
	}
	function renderToRenderer($renderer){
		EnumField::renderToRenderer($renderer);
	}
}

class ForeignRadio extends RadioDecorator {
	function __construct($name,$params=array()){
		parent::__construct(new ForeignField($name,$params));
	}
}
?>
