<?
/**
* @package Elite_Promo
*/

	class Form extends BozModel {
		function writeTODB(){
			return false;
		}

		function getFields(){
			throw new Exception("No Fields Defined");
		}

		function exists(){
			return true;
		}
		function getViewDirectories(){
			if($this->screen){
				$o = $this->getObject();
				$objDirs = $o ? $o->getViewDirectories() : array();
				$dirs = array_merge(array_reverse($this->screen->getViewDirectories()),parent::getViewDirectories(),$objDirs);
			}
			return $dirs;
		}
		function findView($view){
			$found = parent::findView($view);
			$debug = array(
				"View"=>$view,
				"Found"=>$found,
				"Search Path"=>$this->getViewDirectories(),
			);
			if(class_exists('FEContext')){
				FEContext::$views[] = $debug;
			}
			return $found;
		}

		function getObject(){
			return @$this->object;
		}
	}


	class FormFromFieldFactory extends Form {
		function __construct($factory,$object=false,$screen=false){
			parent::__construct();
			$this->factory = $factory;
			$this->object = $object;
			$this->screen = $screen ? $screen : $factory;
			$values=$object->getAssignArray();
			if($values) foreach ($values as $k=>$v){
				$this->$k=$v;
			} 
			foreach($object->relationships as $k=>$v){
				if(@$object->$k) $this->$k=$object->$k;
			}
		}
		function __call($func,$args){
			return call_user_func_array(array($this->getObject(),$func),$args);
		}
		function __getAll($where=array(),$params=array()){
			return $this->object->__getAll($where,$params);
		}
		function exists(){
			return $this->object->exists();
		}
		function getFields(){
			require_once(__MODELS_BASE__.'/fields.php');
			$fields = $this->factory->getFields($this);
			$this->fields = array();
			foreach($fields as $k=>$v){
				$this->fields[$k] = new FieldObjectDecorator($v,$this->object,false);
			}
			return $this->fields;
		}

		function getTableName($p=true){
			if($o = $this->getObject()){
				return $o->getTableName($p);
			}
			return parent::getTableName($p);
		}

		function getId(){
			if($o = $this->getObject()){
				return $o->getId();
			}
			return parent::getId();
		}
		function getIdField(){
			if($o = $this->getObject()){
				return $o->getIdField();
			}
			return parent::getIdField();
		}
	}

	class FormScreen extends Screen {
		function __construct($name,$object = null,$params=array()){
			parent::__construct(@$name);
			$defaults = array('submitLabel'=>'','write'=>false,'extraParams'=>array());
			$params = array_merge($defaults,$params);
			$this->submitLabel = $params['submitLabel'];
			$this->params=$params;
			$this->object = $object;
		}
		function getObject(){
			return $this->object;
		}
		function getForm(){
			if(!@$this->form)
				$this->form = new FormFromFieldFactory($this,$this->getObject());
			return $this->form;
		}
		var $attempted = false;

		function doHTML($context){
			$uri = @$_SERVER['SCRIPT_URI'];
			if(!$uri) $uri = @$_SERVER['REDIRECT_URL'];
			$this->showForm($context,array_merge(array('submitLabel'=>$this->submitLabel, 'action'=>$uri,'hidden'=>$this->getHiddenForm(),'sections'=>@$this->params['sections'],'mainSection'=>@$this->params['mainSection'],'screen'=>$this),$this->params['extraParams']));
		}

		function getFields(){
			return $this->getObject()->getFields();
		}
		function showForm($context,$params){
			$view = @$this->params['view'] ? $this->params['view'] : strtolower(get_class($this));
			$this->shown_views["trying"] = "Looking For $view.php or form.php";
			$this->shown_views['from_dir'] = $this->getForm()->getViewDirectories();
			if(!file_exists($view)){
			try {
				$this->getForm()->findView($view);
			} catch(Exception $e){
				$view = 'form';
			}
			$this->shown_views["found"] = $this->getForm()->findView($view);
			} else {
			$this->shown_views["found"] = $view;
			}
			$this->shown_views['actual']=$view;
			$this->shown_views['data'] = $params;
			$form = $this->getForm();
			$this->shown_views['form'] = $form;
			$params['screen'] = $this;
			
			$form->showView($view,$params);
		}
		function process(){
			$valid = parent::process();
			if($valid && $this->params['write']){
				$this->writeTo($this->getObject());
			}
			$this->writeTo($this->getForm());
			return $valid;
		}

		function validate(){
			try {
				if(!$_POST) return false;
				$this->attempted=true;
				$f = $this->getForm();
				$f->save();
				return true;
			} catch(Exception $e){
				return false;
			}
		}
		function writeTo($model){
			foreach($this->getFields() as $field){
				$field->transformPostData($_POST,$model);
			}
			$model->writeToDB();
		}
	}
?>
