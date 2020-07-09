<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/decorator.php');
	class autofields {
		static function createFor($field,$model){
			if($obj = cms_apply_filter('create_cms_field',null,$field)){
				return $obj;
			}
			@list($type,$size) = explode("(",str_replace(")","",$field->Type));
			switch($field->Field){
			case 'id': case'uid': case $model->getIDField(): return new IDField($field->Field,array('label'=>'ID'));
			case 'password': return new PasswordField($field->Field,array('md5'=>true));

			case 'ctime': case 'cdate': return new CreatedDateField($field->Field,array('dbFormat'=>$field->Type));
			case 'mtime': case 'mdate': return new ModifiedDateField($field->Field,array('dbFormat'=>$field->Type));

			case 'deleted': return new SkippedField($field->Field);
			case 'status': 
				switch($type){
				case 'tinyint':
					return new DropDownField('status',array('skip-empty'=>true,'options'=>array(0=>'Inactive',1=>'Active'),'db-type'=>'bool','default'=>0));
				}
				break;
			case 'slug':
				return new URLSlugField('slug');
			}
			switch($type){
			case 'text':
			case 'mediumtext':
			case 'longtext': 
				if(defined('MODELS_NO_FCK')) return new TextArea($field->Field);
				return new FckeditorField($field->Field);
			case 'enum':
				$options = explode(",",str_replace("'","",$size));
				if(count($options)==2){
					foreach($options as $a){
						if(!$a){
							return new CheckboxField($field->Field);
						}
					}
				}
				return new DropDownField($field->Field,array('options'=>array_combine($options,$options)));
			case 'timestamp':
				return new DateField($field->Field);
			case 'date':
			case 'datetime': {
				require_once(dirname(__FILE__).'/fields/datepicker/DatePicker.php');

				return new DatePicker($field->Field);
			}
			case 'tinyint':
			case 'smallint':
				switch($size){
				case 1:
					return new CheckboxField($field->Field,array('default'=>0));
				default:
					return new NumericField($field->Field,array('places'=>0));
				}
			case 'decimal':
				switch($size){
				case 2:
					return new MoneyField($field->Field);
				default:
					list($pre,$post) = explode(",",$size);
					return new NumericField($field->Field,array('places'=>$post));
				}
			case 'float':
				return new NumericField($field->Field,array('places'=>4));
			case 'int':
				return new NumericField($field->Field,array('places'=>0));
			default:
				return new Field($field->Field);
			}
		}
	}
	class Field extends Decoratable {
		var $name=null;
		var $params = array();
		var $validations = array();

		function __construct($name,$params=array()){
			parent::__construct();
			$this->name = $name;
			$this->setParams($params);
		}
		function defaultParams(){
			return array(
				'type'=>'text',
				'label'=>$this->dbFieldNameToEnglish($this->name),
				'required'=>false,
				'db'=>true,
				'css_class'=>strtolower(get_class($this)),
				'params-for-html'=>array('class','style','type','autocomplete','size','disabled'),
			);
		}
		function dbFieldNameToEnglish($name){
			$name = preg_replace("/[A-Z]/","_$0",$name);
			return ucwords(str_replace('_',' ',$name));
		}
		function setParams($params){
			$this->params = array_merge($this->defaultParams(),$params);
			if($this->params['required']) $this->required();
		}
		function setDefault($def){$this->setParam('default',$def);}
		function getDBFields(){
			$fields = array();
			if($this->param('db',true)){
				$fields[$this->getName()] = $this->getDBType();
			}
			return $fields;
		}

		function getDBType(){
			return $this->param('db-type',"string");
		}

		function paramsToString($params = null){
			if(is_null($params)) $params = $this->param('params-for-html');
			$string='';
			foreach($params as $k=>$v){
				if(is_numeric($k))$k=$v;
				if($val = $this->param($k,false)){
					$string.=htmlspecialchars($k)."='".htmlspecialchars($val,ENT_QUOTES)."'";
				}
			}
			return $string;
		}
		function setParam($k,$v){
			$this->params[$k]=$v;
			if($k=='required' && $v) $this->required();
		}

		function getAssigns($obj){
			if($this->param('db')) return array($this->name=>$this->getValue($obj));
			return array();
		}
		function afterWrite($obj,$old){
		}
		function afterCopy($newObj,$oldObj){
		}
		function onDelete($obj){
		}

		function required(){
			$this->addValidation(new RequiredValidation);
		}

		function getName(){
			return $this->name;
		}
		function getValue($obj,$field=false){
			if(!$field) $field = $this->name;
			if(is_null(@$obj->$field)) $obj->$field = $this->param('default');
			return @$obj->$field;
		}

		function copyFrom($a,$b){
			$this->setValue($b,$this->getValue($a));
		}
		function setValue($obj,$value,$field = false){
			if(!$field) $field = $this->name;
			$obj->$field = $value;
		}

		function htmlName($obj,$field=null){
			if(!$field)$field = $this->name;
			return str_replace(".","_",strtolower(trim($obj->getTableName(false))).'-'.$obj->getID().'-'.$field);
		}
		function getValueForForm($obj){
			return htmlspecialchars($this->getValue($obj),ENT_QUOTES);
		}
		function renderHTML($obj){
			$value = $this->getValueForForm($obj);
			$args = '';
			if($title = $this->param('title')){
				$args .= " title='$title'";
			}
			$args.=$this->paramsToString();
			return "<input $args value='$value' name='{$this->htmlName($obj)}' id='{$this->htmlName($obj)}'/>";
		}
		function param($k,$v=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $v;
		}
		function pushParam($name,$value){
			$p = $this->param($name,array());
			$p[] = $value;
			$this->params[$name] = $p;
		}
		function peekParam($name,$default=null){
			$p = $this->param($name,array($default));
			return array_pop($p);
		}
		function popParam($name,$default=null){
			$p = $this->peekParam($name,$default);
			array_pop($this->params[$name]);
			if(!$this->params[$name]) unset($this->params['name']);
			return $p;
		}
		function renderTo($obj){
			$name = $this->renderName();
			if($this->param('hidden',false)) return;
			$obj->form->inputs[$name] = array(
				'html'=>$this->decorated->renderHTML($obj),
				'name'=>$this->name,
				'id'=>$this->htmlName($obj),
				'label'=>$this->getLabel(),
				'field'=>$this,
				'errors'=>@$obj->validation_errors[$name],
				'notes'=>$this->param('notes',''),
			);
		}
		function getLabel(){
			return $this->param('label',$this->name);
		}
		function transformPostData($post,$obj){
			$field = $this->name;
			$pfield = $this->htmlName($obj);
			if(array_key_exists($pfield,$post)){
				$value = $post[$pfield];
				if(get_magic_quotes_gpc() && !is_array($value)){
					$value = stripslashes($value);
				}
				$obj->$field = $value;
			}
		}
		function prepare($obj,$values){
			$field = $this->name;
			if(isset($values[$field])) $obj->$field = $values[$field];
			else if(!isset($obj->$field)) $obj->$field = $this->param('default','');
		}

		function renderName(){
			return $this->param('render_to',$this->name);
		}
		function validate($obj){
			$field = $this->renderName();
			if($errors = $this->checkInvalid($obj)){
				$obj->validation_errors[$field] = $errors;
			}
			return !$errors;
		}
		function checkInvalid($obj){
			$value = $this->getValue($obj);
			$label = $this->getLabel();
			$errors = array();
			foreach($this->validations as $v){
				if(!is_callable($v)){
					$v = array($v,'error');
				}
				$result = call_user_func($v,$value,$label,$this->decorated,$obj);
				if($result) return $result;
			}
			return $errors;
		}
		function addValidation($validation){
			$this->validations[] = $validation;
		}
	}

	class ModelValidation {
		function validate($value,$label='none',$field=null,$model=null){
			$e = $this->error($value,$label,$field,$model);
			//var _dump($e);
			return !$e;
		}
		function error($value,$label='none',$field=null,$model=null){
			return false;
		}
	}

	class RequiredValidation extends ModelValidation {
		function error($value,$label='none',$field=null,$model=null){
			// This logic specifically allows status (default 0) to be required
			$msg_format = $model->applyFilters('required_message','%s is Required',$field);
			if(!($value||($value===0)||($value==='0'))) return sprintf($msg_format,$label);
			return false;
		}
	}
	class PostCodeValidation extends RegExValidation {
		function __construct(){
			parent::__construct("/^[A-Z]{1,2}[0-9]{0,2}.* [0-9]{0,2}[A-Z]{0,2}.*/i","Please enter a valid postcode");
		}
	}
	class UniqueValidation extends ModelValidation {
		function __construct($where=array(),$params=array()){
			$this->restrictions = $where;
			$this->params = $params;
		}
		function error($value,$label='none',$field=null,$model=null){
			$lister = (@$this->params['model']) ? $this->params['model'] : $model;
			$r = array();

			foreach($this->restrictions as $k=>$v){
				if(is_numeric($k)){
					$r[$v]=$obj->$v;
				} else {
					$r[$k]=$v;
				}
			}
			$name = @$this->params['name'];
			if(!$name) $name=$field->getName();
			$r[$name]=$value;

			$r[$model->getIDField()." !="]=$model->getID();
			$found = $lister->getAll($r,array('unique_query'=>true));
			$myid = $model->getID();
			if($found){
				$message = @$this->params['message'];
				if(!$message) $message = '%1$s Not Unique "%2$s"';
				return sprintf($message,$label,$value);
			}
		}
	}

	class RegExValidation extends ModelValidation {
		function __construct($regEx,$message='%s is invalid'){
			$this->regEx = $regEx;
			$this->message = $message;
		}

		function error($value,$label='none',$field=null,$model=null){
			if($value && !preg_match($this->regEx,$value)) return sprintf($this->message,$label);
		}
	}

	class EmailValidation extends RegExValidation {
		function __construct(){
			parent::__construct('/.+@.+\..+/','Please enter a valid email address');
		}
	}


	class TextField extends Field {
	}
	class TextArea extends Field {
		function defaultParams(){
			$d =parent::defaultParams();
			$d['db-type'] = 'text';
			return $d;
		}
		function z__setParams($params=array()){
			$defaults = array('cols'=>80,'rows'=>10);
			parent::setParams(array_merge($defaults,$params));
		}
		function renderHTML($obj){
			$field = $this->name;
			$value = htmlspecialchars($this->getValue($obj),ENT_QUOTES);
			$atts = $this->paramsToString(array('rows','cols','class'));
			//$atts = " cols='{$this->param('cols')}' rows='{$this->param('rows')}'";
			return "<textarea name='{$this->htmlName($obj)}' $atts>$value</textarea>";
		}
	}
	class PasswordField extends Field {
		function setParams($params){
			$params['type'] = 'password';
			parent::setParams($params);
		}
		function transformPostData($post,$obj){
			$field = $this->name;
			$pfield = $this->htmlName($obj);

			if(array_key_exists($pfield,$post)){
				if($post[$pfield] && ($post[$pfield]!='pass_hidden')){
					$p = $post[$pfield];
					if($this->param('md5',false)) $p = md5($p);
					if($this->param('mysql_pass',false)) $p = mysql_result(mysql_query("SELECT OLD_PASSWORD('".mysql_escape_string($p)."')"),0);
					$obj->$field = $p;
				}
			}
		}
		function renderHTML($obj){
			$outputValue = '';
			$field = $this->name;
			$value = htmlspecialchars($obj->$field,ENT_QUOTES);
			if($value) $outputValue = "pass_hidden";
			$args = $this->paramsToString();
			return "<input $args value='$outputValue' name='{$this->htmlName($obj)}' autocomplete='".$this->param('autocomplete','off')."'/>";
		}
	}
	class FckeditorField extends Field {
		function defaultParams(){
			$d =parent::defaultParams();
			$d['db-type'] = 'text';
			return $d;
		}
		function renderHTML($obj)	{
			require_once(__PATH_TO_FCK__."/fckeditor.php");
			$oFCKeditor = new FCKeditor($this->htmlName($obj));
			$oFCKeditor->BasePath = '/cms/wysiwyg/';
			$oFCKeditor->Value = $this->getValue($obj);
			$oFCKeditor->ToolbarSet = $this->param('toolbar',cms_apply_filter('default_fck_toolbar','Basic'));
	
			foreach(array('Width','Height') as $dim){
				if($val = $this->param(strtolower($dim))){
					$oFCKeditor->$dim = $val;
				}
			}
			return $oFCKeditor->CreateHtml();
		}
	}
	class IDField extends Field {
		function copyFrom($a,$b){
		}
		function setParams($params){
			$defaults = array(
				'default'=>'NEW',
				'newText'=>'New %s',
				'db-type'=>'int',
			);
			parent::setParams(array_merge($defaults,$params));
		}
		function renderTo($obj){
			if($this->param('hidden',false)) return;
			parent::renderTo($obj);
			$field = $this->htmlName($obj);
			$value = $this->getValue($obj);
			$obj->form->hidden[$this->name]	= "<input type='hidden' name='$field' value='$value'/>";
			if((!$value) || ($value=='NEW')) $value=sprintf($this->param('newText','NEW'),$obj->getEnglishName(false));
			$obj->form->inputs[$this->name]['html'] = $value;
		}
	}
	class HiddenIDField extends IDField {
		function renderTo($obj){
			return ;
		}
	}

	class DropDownField extends Field {
		function renderHTML($obj){
			$value = $this->getValue($obj);
			$options = $this->getOptions();

			$html="<select {$this->paramsToString()} name='{$this->htmlName($obj)}' id='{$this->htmlName($obj)}'>";
			if(!($this->param('required',false) || $this->param('skip-empty',false))){
				$options=array(''=>'Select')+$options;
			}
			if($this->param('allow-existing',false)&&!@$options[$value]) $options[$value]=$value;
			foreach($options as $k=>$v){
				if($k==$value) {
					$selected=' selected="true"';
				} else {
					$selected = '';
				}
				$v = htmlentities($v,ENT_QUOTES);
				$k = htmlentities($k,ENT_QUOTES);
				$html.="<option $selected value='$k'>$v</option>";
			}
			$html.="</select>";
			return $html;
		}
		function getOptions(){
			$options = $this->param('options',array());
			if(!$this->param('useKeys',true)){
				$options = array_combine($options,$options);
			}
			return $options;
		}
		function getDBType(){
			return $this->param('db-type',array_keys($this->getOptions()));
		}
	}
	class RadioButtonField extends DropDownField {
		function renderHTML($obj){
			$value = $this->getValue($obj);
			$options = $this->getOptions();

			$html='';
			if($this->param('default-first',false) && (!array_key_exists($value,$options))){
				$value = array_shift(array_keys($options));
			}
			foreach($options as $k=>$v){
				if($k==$value) {
					$selected=' checked="true"';
				} else {
					$selected = '';
				}
							$id = $this->htmlName($obj);
				$html.="<div class='radio-wrapper'><input type='radio' {$this->paramsToString(array('class'))} $selected value='$k' name='$id' id='$id-$k'><label for='$id-$k'>$v</label></div>";
			}
			return $html;
		}
	}
	class ForeignField extends DropDownField {
		function getOptions(){
			$ref = $this->param('ref');
			extract($ref);
			$options=array();
			if(@$model){
				$dwhere = array('visible'=>1);
				if(!@$where){
					$where = $this->param('where',array());
					//$where = array();
				}
				$where = array_merge($dwhere,$where);
				$params = array('for_fetch'=>1);
				if(@$ref['order']) $params['order'] = $ref['order'];
				$model->getAll($where,$params);
				while($o = $model->fetch()){
					$options[$o->getID()] = $o->getLabel();
				}
			} else {
				if(!$value) $value='id';
				if(!isset($label)) $label='name';
				if(!isset($order)) $order=$label;

				$where = (@$where) ? "WHERE $where" : "";
				$q = mysql_query($sql = "SELECT $value,$label FROM $table $where ORDER BY $order");
				if($e= mysql_error()) throw new Exception($e.' in '.$sql);
				while($r = mysql_fetch_row($q)){
					$options[$r[0]] = $r[1];
				}
			}
			return $options;
		}
		function getDBType(){
			return "int";
		}
	}
	class ForeignLabel extends Field {
		function __construct($relName,$params=array()){
			$params['type']='hidden';
			parent::__construct($relName."_uid",$params);
			$this->rel = $relName;
		}
		function getLabel(){
			return str_replace(" Uid","",parent::getLabel());
		}
		function renderHTML($obj){
			$rel = $this->rel;
			$related = $obj->$rel();
			if($related) return sprintf($this->param('format','%2$s%1$s'),$related->getLabel(),parent::renderHTML($obj));
		}
		function transformPostData($post,$obj){
			if($this->param('pass-through',false)) return parent::transformPostData($post,$obj);
			return false;
		}
	}
	class MMCheckBoxes extends Field {
		function setParams($params){
			$defaults = array( 'db'=>false);
			parent::setParams(array_merge($defaults,$params));
		}
		function getOptions(){
			return ForeignField::getOptions();
		}


		function getExisting($obj){
			$field = $this->name."_exist";
			if(is_array(@$obj->$field)) return $obj->$field;
			$function =$this->name;
			$have = array();
			foreach($obj->$function() as $item){
				$have[$item->getID()] = $item->getID();
			}

			return $obj->$field = $have;
		}
		function renderHTML($obj){
			$html='';
			$html .= "<div class='MMCheckboxGroup'>";
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
			$index=0;
			foreach($this->getOptions() as $k=>$option){
				$checked=@$have[$k]?' checked="true"' : '';//TODO: Fix this
				$html.="<div class='MMCheckbox'><label class='checkboxLabels' for='".$this->htmlName($obj)."[$k]'>$option</label><input type='checkbox' class='inputCheckbox' name='".$this->htmlName($obj)."[$k]' id='".$this->htmlName($obj)."[$k]' value='$k' $checked/></div>";
			}
			$html .= "</div>";
			return $html;
		}

		function transformPostData($post,$obj){
			$posted = @$post[$this->htmlName($obj)];
			$field = $this->name."_post";
			$obj->$field = $posted ? $posted : array();
			$obj->setMM[$this->name] = true;
		}
		function afterWrite($obj,$old){
			if(!@$obj->setMM[$this->name]) return;
			$obj->setMM[$this->name] = false;
			$have = $this->getExisting($obj);
			$field = $this->name."_post";
			$want = @$obj->$field;
			if(!$want) $want = array();

			$need = array_diff($want,$have);
			$dontNeed = array_diff($have,$want);

			extract($this->params);
			cms_trigger_action('relationship_add_remove',$obj,$this->params,$need,$dontNeed);
			mysql_query("DELETE FROM {$rel['table']} WHERE {$rel['local_id']} = '{$obj->getID()}' AND {$rel['foreign_id']} IN ('".join("','",$dontNeed)."');");
			foreach($need as $id){
				mysql_query($sql = "INSERT INTO $rel[table] SET $rel[local_id] = {$obj->getID()}, $rel[foreign_id]=$id");
			}
			$field = $this->name."_exist";
			unset($obj->$field);
		}
	}
	class ConstantField extends Field {
		function defaultParams(){
			$params = parent::defaultparams();
			$params['type']='hidden';
			return $params;
		}
		function getValue($obj,$field = false){
			return $this->param('value',parent::getValue($obj,$field));
		}
		function renderHTML($obj){
			$html = parent::renderHTML($obj);
			$value = $this->getValue($obj);
			return $html.$value;
		}
	}
	class HiddenField extends Field {
		function defaultParams(){
			$d = parent::defaultParams();
			$d['type']='hidden';
			return $d;
		}
		function renderTo($obj){
		}
		function transformPostData($post,$obj){
		}
	}

	class SkippedField extends HiddenField {
		function getAssigns($obj){
			return array();
		}
	}

	class SortingField extends HiddenField {
		function getAssigns($obj){
			$this->existed = $obj->exists();
			if(!$this->existed && !$this->getValue($obj)){
				$first = $obj->getFirst(array(),array('order'=>$this->name));
				$this->setValue($obj,$this->getValue($first)-1);
			}
			$assigns = parent::getAssigns($obj);
			return $assigns;
		}

		function afterWrite($obj,$old){
			return;
			if(!$this->existed) {
//				$obj->initialiseSorting();
			}
		}
		function getDBFields(){
			return array($this->getName()=>'int');
		}
	}
	class CheckboxField extends Field {
		function defaultParams(){
			return array_merge(parent::defaultParams(),array('default'=>0));
		}
		function transformPostData($post,$obj){
			$pname = $this->htmlName($obj);
			$rname = $this->hiddenName($obj);
			if(array_key_exists($rname,$post)){
				$this->setValue($obj,@$post[$pname]?1:0);
			}
		}
		function getDBType(){
			return "bool";
		}
		function renderHTML($obj){
			$checked = $this->getValue($obj) ? " checked='true'":"";
			$html = "<input class='inputCheckbox' name='{$this->htmlName($obj)}' value='1' $checked type='checkbox'/>";
			$html.="<input name='{$this->hiddenName($obj)}' value='1' type='hidden'/>";
			return $html;
		}
		function hiddenName($obj){
			return "posted-".$this->htmlName($obj);
		}
	}

	class DateField extends ConstantField {
		function defaultParams(){
			$d = parent::defaultParams();
			$d['db-type'] = 'int';
			return $d;
		}
		function renderHTML($obj){
			$html = Field::renderHTML($obj);
			$value = $this->getValue($obj);
			if($value)
				$value = @date($this->param('format','Y-m-d H:i:s'),$value);
			else
				$value='N/A';
			return $html.$value;
		}
	}
	class ModifiedDateField extends DateField {
		function getAssigns($obj){
			$value = time();
			switch($this->param('dbFormat')){
				case 'date': case 'datetime':
					$value = date($this->param('format','Y-m-d H:i:s'),$value);
					break;
			}
			return array($this->name=>$value);
		}
	}
	class CreatedDateField extends ModifiedDateField {
		function getAssigns($obj){
			if($obj->exists()) return array();
			else return parent::getAssigns($obj);
		}
	}

	class NumericField extends Field {
		function transformPostData($post,$obj){
			$pname = $this->htmlName($obj);
			if(array_key_exists($pname,$post))
				$post[$pname] = preg_replace("/[^-0-9.]/","",$post[$pname]);
			return parent::transformPostData($post,$obj);
		}
		function getValueForForm($obj){
			$v = parent::getValueForForm($obj);
			if($v){
				$places = $this->param('places',2);
				if($places<10) $v = number_format($v,$places);
				return $this->param('prefix','').$v;
			}
			return '';
		}
		function getDBType(){
			$places = $this->param('places',2);
			return $places	? "decimal.$places" : "int";
		}
	}
	class MoneyField extends NumericField {
		function setParams($params){
			$params = array_merge(array('prefix'=>'&pound;'),$params);
			parent::setParams($params);
		}
	}
	class HistoryField extends HiddenField {
		function __construct($name='history',$params=array()){
			parent::__construct($name,$params);
		}
		function setParams($params){
			$params['db']=false;
			parent::setParams($params);
		}
		function afterWrite($obj,$old,$assign){
			$this->recordChange($old?"UPDATE":"INSERT",$obj,$old,$assign);
		}
		function recordChange($type,$new,$old,$assign=array()){
			$done=array();
			$changes = "";
			if($type!='DELETE') $obj=$new;
			if(@$old){
				foreach($assign as $k=>$v){
					$changes.="$k='".@mysql_escape_string($v)."' to '".@mysql_escape_string($obj->$k)."'\n";
					if(@$obj)
						@$obj->origObj->$k=@$obj->$k;
					$done[$k] = true;
				} 
			}
			if(@$obj)
			foreach($assign as $k=>$v){
				if(@$done[$k]) continue;

				$changes.="$k=NULL to '".mysql_escape_string($v)."'\n";
				if(@$obj->origObj)
					$obj->origObj->$k=$obj->$k;
			} 
			if(!$changes) return;
			$changes = "$type\n$changes";
			$post = $_POST;
			foreach($post as $k=>$v){
				if(preg_match("/^card_/",$k)) unset($post[$k]);
			}
			$values = array(
				'changes'=>$changes,
				'ref_id'=>$new->getId(),
				'ref_table'=>$new->getTableName(),
				'cdate'=>time(),
				'url'=>@$_SERVER['REQUEST_URI'],
				'ref_url'=>@$_SERVER['HTTP_REFERER'],
				'post_data'=>json_encode($post),
				'args'=>json_encode(@$_SERVER['argv']),
				'php_sapi_name'=>php_sapi_name(),
			);
			$values = cms_call_hook('process_history_data',$values);
			// Add in user info etc??
			if(@$values['other'] && (is_array($values['other']) || is_object($values['other']))) $values['other'] = json_encode($values['other']);
			$obj = Model::loadModel('History')->createNew();
			foreach($values as $k=>$v){
				$obj->$k = $v;
			}
			$obj->writeDelayed();
		}
		function onDelete($obj){
			$this->recordChange("DELETE",$obj,$obj->origObj);
		}
	}
	class URLValidation extends RegExValidation {
		function __construct(){
			parent::__construct('#.*\..*#','Please enter a valid url for %1s');
		}
	}

	class URLField extends Field {
		function __construct($name,$params=array()){
			parent::__construct($name,$params);
			$this->addValidation(new URLValidation);
		}
		function transformPostData($post,$obj){
			$value = $post[$this->htmlName($obj)];
			$value = preg_replace('#^https?://#','',$value);
			$this->setValue($obj,$value);
		}
	}
class FormValidationException extends Exception {
}

	class PermissionLessDecorator extends Decorator {
		function renderTo($obj){
			return "";
		}

		function transformPostData(){
			return;
		}
	}
	class FieldObjectDecorator {
		function __construct($field,$object,$usePrefix=true){
			$this->field = $field;
			$this->object = $object;
			$this->usePrefix = $usePrefix;
		}
		function __call($func,$args){
			return call_user_func_array(array($this->field,$func),$args);
		}

		function renderTo($obj){
			$this->field->renderTo($this->object);
			if(!@$this->object->form->inputs) $this->object->form->inputs =  array();
			$pref = $this->usePrefix ? $this->object->getTableName(false)."." : '';
			foreach($this->object->form->inputs as $k=>$v){
				$obj->form->inputs[$pref.$k] =$v;
			}
		}
		function getAssigns(){
			return array();
		}
		function transformPostData($data,$obj){
			// Don't think this is used?
			$this->field->transformPostData($data,$this->object);
		}
		function validate($obj){
			$name = $this->field->renderName();
			$this->object->validation_errors[$name]=false;
			try {
				$res = $this->field->validate($this->object);

			} catch(Exception $e){
			}
			unset($obj->validation_errors[$name]);
			if($err = @$this->object->validation_errors[$name]){
				$obj->validation_errors[$name] = $err;
			}

			if(@$e) throw $e;
			return $res;
		}
		function getDBFields(){ return array();}
	}

	class URLSlugField extends Field {
		function __construct($name,$params=array()){
			parent::__construct($name,$params);
			$this->addValidation(new UniqueValidation);
		}
		function defaultParams(){
			$d = parent::defaultParams();
			$d['label'] = 'SEO Friendly URL';
			return $d;
		}
		function renderHTML($obj){
			$this->setParam('default',$this->getDefault($obj));
			$html = parent::renderHTML($obj);
			if($obj->exists()){
				$html.="<script>$('#".$this->htmlName($obj)."').focus(function(){
					if(!$(this).hasClass('confirmed')){
						if(confirm(\"You should not edit this url if it has been made public.\\nAre you sure?\")){
							$(this).addClass('confirmed');
						} else {
							$(this).closest('.form_row').next('.form_row').find('input,select').focus();
						}
					};
				});</script>";
			}
			return $html;
		}
		function transformPostData($data,$obj){
			$hn = $this->htmlName($obj);
			if(@$data[$hn]) $data[$hn] = $this->getDefault($obj,$data[$hn]);
			else $data[$hn] = $this->getDefault($obj);
			parent::transformPostData($data,$obj);
		}
		function getDefault($obj,$orig=false){
			if(!$orig) {
				$orig = $obj->urlEncode($obj->getLabel());
			}
			$orig = preg_replace("/-+/","-",$orig);
			$def = $orig;
			$count=0;
			$max = 1;
			while($obj->getAll(array($this->name=>$def,$obj->getIDField()." !="=>$obj->getId()))){
				$count+=rand(1,$max); $max*=2;
				$def = $orig."-$count";
			}
			return $def;
		}
		function validate($obj){
			if(!$v = $this->getValue($obj)){
				$this->setValue($this->getDefault($obj),$obj);
			}
			return parent::validate($obj);
		}
		function getAssigns($obj){
			$this->setParam('default',$this->getDefault($obj));
			$as= array($this->getName()=>$this->getValue($obj));
			return $as;
		}
	}
cms_trigger_action('model_fields_loaded');

