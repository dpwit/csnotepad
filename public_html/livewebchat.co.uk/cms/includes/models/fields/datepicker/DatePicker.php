<?
/**
* @package Model_System
*/

	class DatePicker extends Field {
		function renderHTML($obj){
			$html = "";
			if($this->param('includeDatePicker',true)){
			$html .= "<script src='/cms/js/jqueryui1.8/minified/jquery.ui.core.min.js'></script>";
			$html .= "<script src='/cms/js/jqueryui1.8/minified/jquery.ui.datepicker.min.js'></script>";	
			$html .= "<script src='/cms/js/jquery.ui-datepicker-autodates-ext.js'></script>";
			
			$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/vader/jquery.ui.core.css' />";			
			$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/vader/jquery.ui.theme.css' />";			
			$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/vader/jquery.ui.datepicker.css' />";									
			
			/*
				$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/vader/jquery.ui.core.css' />";			
				$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/vader/jquery.ui.theme.css' />";			
				$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/vader/jquery.ui.datepicker.css' />";									
			*/
			}
/*			
Could of included just the 'ui.all.css' file instead which @imports others (inc. datepicker.css, accordian.css etc) 
While easier this requires more KB than just grabbing core+theme+datepicker.
$html .= "<link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/ui.all.css' />";			
	*/		
			
			
			$name = $this->htmlName($obj);
			$value = $this->getTransformedValue($obj);
			if(!is_null($value)) $value = date("d-m-Y",$value);
	
			
			$dpParams = array(
				'yearRange'=>$this->param('start','2000').":".$this->param('end',date("Y")+5),
			);

			$html.="<div class='date-selector'><input type='text' {$this->paramsToString()} name='$name' id='$name' value='".htmlspecialchars($value,ENT_QUOTES)."'/><input type='hidden' class='params' value='".json_encode($dpParams)."'/></div>";
			return $html;
		}

		function getTransformedValue($obj){
			if($this->param('tstamp',false)){
				$v = parent::getValue($obj);
			} else {
				$v = parent::getValue($obj);
				if($v && $v!='0000-00-00 00:00:00' && $v!='0000-00-00') $v = strtotime($v);
				else return null;
			}
			return $v;
		}

		function setTransformedValue($obj,$tstamp){
			if(!$this->param('tstamp',false)){
				if($tstamp) $tstamp = date("Y-m-d H:i",$tstamp);
				else $tstamp = null;
			}
			$this->setValue($obj,$tstamp);
		}
		function transformPostData($post,$obj){
			$name = $this->htmlName($obj);
			if(array_key_exists($name,$post)){
				$value = $post[$name];
				@list($d,$m,$y) = explode("-",$value);

				$tstamp = @mktime(0,0,0,$m,$d,$y);
				$this->setTransformedValue($obj,$tstamp);
			}
		}

		function getDBType(){
			return $this->param('tstamp',false) ? 'int' : "datetime";
		}
	}

	class DateTimePicker extends DatePicker {
		function renderHTML($obj){
			$html = parent::renderHTML($obj);

			$tstamp = $this->getTransformedValue($obj);
	
			$hr = $tstamp ? (int)date('H',$tstamp) :0;
			$min = $tstamp ? (int)date('i',$tstamp) :0;

			$html.="<div class='time-selector'>";

				$html.="<select name='{$this->htmlName($obj)}-hour'>";
				foreach(array_map(array($this,'leadingZero'),range(0,23)) as $k=>$v)
					$html.="<option value='$v'" .($k===$hr?' selected="selected"':'') . ">$v</option>";
				$html.="</select>";

				$html.="<select name='{$this->htmlName($obj)}-minute'>";
				foreach(array_map(array($this,'leadingZero'),range(0,59,$this->param('minute_step',5))) as $k=>$v)
					$html.="<option value='$v'" .($k===$min?' selected="selected"':'') . ">$v</option>";
				$html.="</select>";

			$html .='</div>';

			return $html;
		}

		function leadingZero($num){
			return str_pad ($num,2,"0",STR_PAD_LEFT);
		}

		function transformPostData($post,$obj){
			parent::transformPostData($post,$obj);
			$baseName = $this->htmlName($obj);
			$hrName =  $baseName . '-hour';
			$minName =  $baseName . '-minute';
			
			$hr = $post[$hrName];
			$min = $post[$minName];

			$val = $this->getTransformedValue($obj);
			if($val){
				$val = mktime($hr,$min,0,(int)date('n',$val),(int)date('j',$val),(int)date('Y',$val));


				$this->setTransformedValue($obj,$val);
			}
		}

	}
?>
