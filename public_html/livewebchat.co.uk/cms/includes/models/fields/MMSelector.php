<?
/**
* @package Model_System
*/

	class MMSelector extends MMCheckboxes {
		function setParams($params){
			$defaults = array();
			if($params['rel']['order']) $defaults['has-sorting'] = true;
			parent::setParams(array_merge($defaults,$params));
		}
		function replaceFrom($templateVar,$obj){
			$bits = explode("_",$templateVar);
			switch($bits[0]){
			case 'ID':
				return $obj->getID();
			case 'NAME':
				return $obj->getLabel();
			case 'VALUE':
				$field = $bits[1];
				return htmlspecialchars($obj->mm->$field,ENT_QUOTES);
			}
		}
		function getFunction(){
			return $this->name;
		}
		function getTable(){
			return $this->params['rel']['table'];
		}
		function renderHTML($obj){
			$html='';
			if($obj->exists()){
				$have = $this->getExisting($obj);
			} else {
				$have = array();
				if($defaults = $this->param('default')){
					foreach($defaults as $o){
						@$have[$o->getID()]++;
					}
				}
			}
			$options = $this->getOptions();
			$html.="<script src='/js/jquery.boxy.js'></script>";
			$html.="<link rel='stylesheet' href='/js/stylesheets/boxy.css'></script>";
			$ref = $this->param('ref');
			$rel = $this->getFunction();
			$mmrel = $this->param('structure',$ref['table']);

			$fields = $this->getFields($obj);
			$html.="<div class='mm-selector' rel='$mmrel' id='mm-selector-{$this->htmlName($obj)}'>";
			$html.="<ul class='mm-items'>";
			$testObj = new Model(null,Model::unpluralize($this->getTable()));
			$testObj->uid = $obj->getID().".###TEMPLATE_ID###";
			$example = "<li class='mm-example'><input type='hidden' name='{$this->htmlName($obj)}[###TEMPLATE_ID###]' value='###TEMPLATE_ID###'> <span class='mm-item-controls'>
				<a class='mm-remove-link' href='#'><span>Remove</span></a>";
			if($this->param('has-sorting',false)){
				$example.="<a class='mm-move-up-link' href='#'><span>Move Up</span></a>
				<a class='mm-move-down-link' href='#'><span>Move Down</span></a>";
			}
			$example.="	</span>
				###TEMPLATE_ID### - ###TEMPLATE_NAME###";
			foreach($fields as $k=>$v){
				if($v->name=='sorting' && $this->params['rel']['hide-sorting']) continue;
				$v->setValue($testObj,"###TEMPLATE_VALUE_{$v->getName()}###");
				$v->renderTo($testObj);
			}
			if(is_array($testObj->form->inputs))
			foreach($testObj->form->inputs as $k){
				$l = $k['label'];
				$in = $k['html'];
				$example.= "<div class='mm-data' style='clear: left'><div class='mm-label'><strong>$l</strong></div><div class='mm-input'>$in</div><!--input--></div><!--data-->";
			}
			$example.="</li>";
			$objects = $obj->$rel();
			$assoc = array();
			foreach($objects as $k=>$v){
				$assoc[$v->getID()] = $v;
			}
			foreach($have as $k=>$v){
				$other = $assoc[$k];
				if($v) $myhtml.=preg_replace("/###TEMPLATE_([^#]+)###/e",'$this->replaceFrom("\\1",$other)',str_replace('mm-example','',$example));
			}
			$example = preg_replace("/###TEMPLATE_VALUE_([^#]+)###/",'',$example);
			
			$html.=$example.$myhtml;
			$html.="</ul>";
			$itemLabel = $this->param('itemLabel');
			$html.="<div class='mm-add-link'><a href='#'>Add $itemLabel</a></div>";
			$html.="<script>";
			static $jsIncluded = false;
			if(!$jsIncluded){
				$html.=file_get_contents(dirname(__FILE__).'/mm.js');
				$jsIncluded = true;
			}
			if($itemLabel = $this->param('itemLabel')){
				$html = str_replace("Add Item","Add $itemLabel",$html);
			}
			$html.="</script>";
			$html.="<div style='clear: both'></div>";
			$html.="</div>";
			return $html;
		}

		var $fields = array(), $explicitFields = array();

		function getFields($obj){
			if(!$this->fields){
				$rel = $this->param('rel');
				if($skipFields = $rel['skipFields']){
					foreach($skipFields as $field){
						$this->setField(new SkippedField($field));
					}
				}
				$ignore = array('uid','id',$rel['order'],$rel['local_id'],$rel['foreign_id']);
				$q = mysql_query("DESCRIBE `$rel[table]`");
				while($r = mysql_fetch_object($q)){
					if(in_array($r->Field,$ignore)) continue;

					if($f = $this->explicitFields[$r->Field]){
						$this->fields[$r->Field] = $f;
					} else {
						$this->fields[$r->Field] = $obj->autoCreate($r,array('fromMM'=>true,'mm_table'=>$rel['table']));
					}
				}
			}
			return $this->fields;
		}
		function setField($field){
			$this->explicitFields[$field->getName()] = $field;
		}

		function transformPostData($post,$obj){
			parent::transformPostData($post,$obj);
			$this->post = $post;
		}

		function afterWrite($obj){
			$set = $obj->setMM[$this->name];
			$field = $this->name."_post";
			$want = @$obj->$field;
			unset($want['###TEMPLATE_ID###']);
			parent::afterWrite($obj);
			if(!$set) return;

			$f = $this->getFunction();
			$have = $obj->$f();
			$have_assoc = array();
			foreach($have as $o){
				$have_assoc[$o->getID()] = $o;
			}
			if(!$want) $want = array();
			$count=0;
			extract($this->params);
			$fields = $this->getFields($obj);
			foreach($want as $id=>$nothing){
				$count++;
				$otherFields='';
				$testObj = new Model(null,Model::unpluralize($this->getTable()));
				if($have = $have_assoc[$id]){
					foreach($have->mm as $k=>$v){
						if($k=='table') continue;
						$testObj->$k = $v;
					}
				}
				$testObj->uid=$obj->getID().".".$id;
				$assigns = array(
					'sorting'=>$count
				);
				foreach($fields as $k=>$v){
					$v->transformPostData($this->post,$testObj);
				}
				foreach($fields as $k=>$v){
					$assigns = array_merge($assigns,$v->getAssigns($testObj));
				}
				mysql_query($sql = "UPDATE {$rel['table']} SET ".$testObj->assignString($assigns)."$otherFields WHERE {$rel['local_id']} = '{$obj->getID()}' AND {$rel['foreign_id']} ='$id'");
				cms_trigger_action('relationship_updated',$obj,$this,$assigns);
				foreach($fields as $k=>$v){
					$v->afterWrite($testObj,$testObj->origObj);
				}
			}
		}
	}
?>
