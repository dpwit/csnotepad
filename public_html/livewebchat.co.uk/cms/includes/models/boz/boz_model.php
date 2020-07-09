<?
/**
* @package Model_System
*/

	define('__PATH_TO_FCK__',dirname(__FILE__).'/../../../wysiwyg/');
	require_once(dirname(__FILE__).'/../viewable.php');
	class BaseModel extends Viewable {
	}

	require_once(dirname(__FILE__).'/../model.php');
	require_once(dirname(__FILE__).'/../factory.php');
	require_once(dirname(__FILE__).'/../engines/mysql_engine.php');
	require_once(dirname(__FILE__).'/../controller.php');

	class Model extends MyModel {
		static $modelClasses = array();
		var $engine=null;

		function __construct($obj=null,$table=false){
			parent::__construct($obj,$table);
		}

		static function addModel($key,$file=null,$class=null){
			$params = array('file'=>$file,'class'=>$class?$class:$key,'type'=>'model');
			if(in_array(strtolower($class),array('mymodel','bozmodel'))){
				$params['p2'] = strtolower($key);
			}
			Factory::mapClass("model_$key",$params);
			if($class)
				Factory::mapClass("model_$class",$params);
		}
		static function listModels(){
			return Factory::listByType('model');
		}

		static function g($key,$id=null,$params=array()){
			$params['single']=1;
			return self::ga($key,$id,$params);
		}
		static function ga($key,$id=array(),$params=array()){
			$m = Model::loadModel($key);
			if(is_array($id)) return $m->getAll($id,$params);
			if(!is_null($id)) return $m->get($id,array(),$params);
			return $m;
		}
		static function loadModel($key,$noWarn=false){
			$origKey = $key;
			$key = "model_$key";
			try {
				try {
					return Factory::getInstance($key,null,strtolower($origKey));
				} catch(NoMappingException $e){
					$np = self::unpluralize($key);
					if($np!=$key){
						return Factory::getInstance($np,null,strtolower(self::unpluralize($origKey)));
					} else {
						throw $e;
					}
				}
			} catch(NoMappingException $e){
				if(!$noWarn){
					trigger_error("Using Default Model Class For '$key'",E_USER_WARNING);
				}
				Model::addModel($origKey,false,'MyModel');
				return Factory::getInstance($key,null,strtolower($origKey));
			}
		}

		static function cmsLoadController(){
			$controllerName = @$_REQUEST['model'] ? $_REQUEST['model'] : $_REQUEST['pageType'];
			try {
				$controller = Controller::getInstance($controllerName);
				if($controller instanceof Controller) return $controller;
			} catch(NoMappingException $e){
			} catch(FactoryException $e){
			}
			return self::cmsLoadModel();

		}
		static function cmsLoadModel(){
			extract($_REQUEST);
			if(!@$model) $model = ucfirst(self::unpluralize(@$_REQUEST['pageType']));
			$model=trim($model);
			if(!$model) return false;
			$model = self::loadModel($model,true);
			if(is_a($model,'BozModel')) $inst = $model->findFromRequest($_REQUEST);
			elseif(@$cms_uid) {
				try {
					$inst = $model->get($cms_uid);
				} catch(Exception $e){}
			}
			if(@$inst) return $inst;
			else return $model;
		}
		function findFromRequest($p){
			if(@$p['cms_uid']) return $this->get($p['cms_uid']);
			return $this;
		}
		static function cliLoadModel(){
			list($exe,$model,$cms_uid) = $_SERVER['argv'];
			if(!$model) $model = ucfirst(self::unpluralize($model));
			$model=trim($model);
			$model = Controller::getInstance($model);
//			$model = self::loadModel($model);
			$remainder = array_slice($_SERVER['argv'],2);
			if($cms_uid) {
				try {
//					$inst = $model->get($cms_uid);
//					$remainder = array_slice($_SERVER['argv'],3);
				} catch(Exception $e){}
				if(@$inst) return $inst;
			}
			$action = array_shift($remainder);
			return array($model,$action,$remainder);
		}
		function defaultModelClass($name){
			return ucfirst($name);
		}
	}

	class BozModel extends Model {
		function __construct($obj=null,$table=null){
			parent::__construct($obj,$table);

			static $registered = array();
			$class = strtolower(get_class($this));
			if(!isset($registered[$class])){
				$registered[$class]=true;
				$table = $this->getTableName(true);
				$model = $this->getModelName(false);
				cms_listen_hook("handle_overview_$table",array($this,'showListing'));
				cms_listen_hook("handle_overview_$model",array($this,'showListing'));
				cms_listen_hook("handle_save_$table",array($this,'cms_save'));
				cms_listen_hook("handle_save_$model",array($this,'cms_save'));
				cms_listen_hook("handle_newform_$table",array($this,'cms_new'));
				cms_listen_hook("handle_newform_$model",array($this,'cms_new'));
				cms_listen_hook("handle_editform_$table",array($this,'cms_edit'));
				cms_listen_hook("handle_editform_$model",array($this,'cms_edit'));
				cms_listen_hook("handle_delete_$table",array($this,'cms_delete'));
				cms_listen_hook("handle_delete_$model",array($this,'cms_delete'));
			}
		}

		function getPageType(){
			$pageType = basename(dirname($this->getOrigin()));
			if(!$pageType) $pageType=$this->getTableName();
			return $pageType;
		}

		function getView($view,$params=array()){
			ob_start();
			$this->showView($view,$params);
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
		function findView($view){
			$model = $this;
			$pageType = $this->getTableName();
			foreach($this->getViewDirectories() as $dir){
				if(file_exists($file = "$dir/$view" ) || file_exists($file="$file.php")){
					return $file;
				}
			}
			if(file_exists($view)){
				return $view;
			}
			throw new Exception("Could not find view ".strtolower(get_class($this)).".$view\n".join("\n",$this->getViewDirectories()));
		}
		function showView($view,$params=array()){
			$model = $this;
			$pageType = $this->getTableName();
			extract($params);
			include($this->findView($view));
		}

		function getListingColumns(){
			$label = $this->getLabelField();
			return array(ucwords(str_replace("_"," ",$label))=>$this->getLabel());
		}
		function getCSVListingColumns(){
			return $this->getListingColumns();
		}
		function getListingHeadings(){
			return array_keys($this->getListingColumns());
		}

		function getMainLinks(){
			$pageType = $this->getPageType();
			return array(
				"overview.php?pageType=$pageType&model=".$this->getModelName(false)=>"View All ".$this->getEnglishName(true),
				"newItem.php?pageType=$pageType&model=".$this->getModelName(false)=>"New ".$this->getEnglishName(false),
			);
		}
		function getModelName($plural=true){
			$class=get_class($this);
			if($class=='BozModel') $class = $this->unpluralize(ucwords(str_replace("_"," ",$this->getTableName(true))));
			return parent::getModelName($plural);
		}
		function cmsUrl($action,$args=array(), $oldStyle=false){
			if(!@$args['pageType']) $args['pageType'] =$this->getPageType();
			if(!@$args['model']) $args['model'] =$this->getModelName(false);
			if(!@$args['cms_uid']) $args['cms_uid'] =$this->getID();
			if(!@$oldStyle){
				$args['action'] = $action;
				$action='despatch';
			} else {
			}
			return "/cms/$action.php?".$this->assignString($args,"&",'urlencode');
		}
		function getCmsActions(){
			$pageType = $this->getPageType();
			$links = array();
			foreach(array('editItem'=>'Edit','deleteItem'=>'Delete') as $command=>$label){
				if(check_access($pageType,$command,false,array('modelName'=>$this->getModelName(),'model'=>$this))){
					$links[$this->cmsUrl($command,false,true)]=$label;
				}
			}
			foreach($this->relationships as $k=>$relationship){
				$relationship = $this->loadRel($k);
				if(@$relationship['no-cms-navigation']) continue;
				switch(@$relationship['type']){
				case __REL_HAS_MANY__:
				case __REL_MM__:
					if(checkAccess(Model::loadModel($relationship['model']),'overview',false)){
						$name = $this->variableToEnglish($k);
						if(@$relationship['show-count']){
							$res = $this->$k(array(),array('for_fetch'=>1));
							$count = $res->numResults();
							$res->free();
							if($count){
								$name.=" ($count)";
							}
						}
						$links[$this->cmsUrl('overview',array('model'=>$relationship['model'],$relationship['ref_field']=>$this->getID()),true)] = "View ".$name;
					}
					break;
				case __REL_BELONGS_TO__:
					if(checkAccess(Model::loadModel($relationship['model']),'edit',false)){
						$ref = $relationship['field'];
						$links[$this->cmsUrl('editItem',array('model'=>$relationship['model'],'cms_uid'=>$this->$ref),true)] = "View ".$this->variableToEnglish($k);
					}
					break;
				case __REL_EXTERNAL__:
					$m = $this->manager($k);
					if(is_callable($f = array($m,'getCmsActions'))){
						$links = array_merge($links,call_user_func($f));
					}
					break;
				}
			}
			if(@$this->hasSingleView){
				$links = array();
				$links[$this->cmsUrl('show'.ucfirst(get_class($this)),array('pageType'=>'simpleInterface','model'=>'SimpleInterface','cms_uid'=>$this->getID()))] = "View ".$this->getModelName(false);
			}
			return $this->applyFilters('cms_actions',$links);
		}
		function getCmsBulkActions(){
			return array();
		}

		function cms_overview(){
			page_is_real();
			return $this->showListing();
		}
		function showListing($params=array()){
			$oparams=$_GET;
			foreach($this->relationships as $k=>$relationship){
				$relationship = $this->loadRel($k);
				switch(@$relationship['type']){
				case __REL_BELONGS_TO__:
					if(array_key_exists($relationship['field'],$_GET)){
						$id = $_GET[$relationship['field']];
						$params['restrict'][$relationship['field']] = $id;
					}
				}
			}
			if(@$_REQUEST['no_template']) cms_no_template();
//			else $this->showView('links');
			$view = @$_GET['listing-view'];
			if(!$view) $view = 'report';
			$params = $this->applyFilters('list_params',array('restrict'=>@$params['restrict']?$params['restrict']:array()),$oparams);
			require_once(__MODELS_BASE__.'/reportable.php');
			$params['report'] = new ModelReporter($this,$params['restrict'],$params);
			$this->showView($this->applyFilters('list_view',$view,$oparams),$this->applyFilters('list_params',$params,$oparams));
			return true;
		}

		function filter_list_view($view,$params){
			if(@$params['format']=='csv') return 'csv-report';
			return $view;
		}
		function filter_list_params($params,$get){
			if(@$get['format']=='csv') $params['perPage'] = 0;
			return $params;
		}

		function cms_list_for_mm($params){
			$p = array();
			if(@$params['restrict'])$p['restrict'] = json_decode(urldecode(stripslashes_if($params['restrict'])),true);
			$this->showView('list_for_mm',$p);
		}

		function cms_editItem(){
			$args = func_get_args();
			if($_POST){
				$this->cms_save();
			} else {
				call_user_func_array(array($this,'cms_edit'),$args);
			}
		}
		function checkAccess($action,$throwException=true){
			return checkAccess($this,$action,$throwException);
		}
		function cms_edit(){
			if((!$_POST) && (!@$this->dontReEdit) && !@$_REQUEST['simplemodal']) $_SESSION['lastRealPage'] = $_SERVER['REQUEST_URI'];
			$this->get($_GET['cms_uid'])->showEditForm();
			return true;
		}
		function cms_new(){
			$this->createNew($this->applyFilters('cms_new_params',array()))->showEditForm();
			return true;
		}

		function cms_save(){
			extract($_GET);
			try {
				$instance=null;
				if($cms_uid)
					$instance = $this->get($cms_uid);
				if(!$instance)
					$instance = $this->createNew();
				$instance->save($instance,$_POST);
				$instance->cms_afterSave();
			} catch(Exception $e){
				$instance->showView('editErrors',array('message'=>$e->getMessage()));
				$instance->showEditForm();
			}
			return true;
		}
		function cms_afterSave(){
			if(!@$this->dontReEdit){
				$_SESSION['lastRealPage'] = $this->urlFor('editItem');
			}
			$this->showView('confirmation',array('dontRedirect'=>@$_REQUEST['simplemodal'],'closeModal'=>@$_REQUEST['simplemodal']));
		}
		function cms_delete(){
			if(@$_POST['confirmed']){
				$this->get($_GET['cms_uid'],array('show_deleted'=>1))->delete();
				$this->showView('confirmation');
			} else {
				$this->showView('confirmDelete');
			}
			return true;
		}

		function showEditForm($params = array()){
			$defaults = array(
				'sections'=>false,
				'template'=>'form',
			);
			$params = array_merge($defaults,$params);
			$this->form->hidden.="<input type='hidden' name='action' value='submitted'/>";
			if(@$_REQUEST['no_template']) cms_no_template();
//			else $this->showView('links');
			$this->showView($params['template'],$params);
			return true;
		}
		function urlFor($action,$params=array()){
			$pageType = $this->getPageType();
			$params = array_merge(array(
				'action'=>$action,
				'pageType'=>$this->getPageType(),
				'cms_uid'=>$this->getID(),
				'model'=>$this->getModelName(false),
				),$params);
			return "/cms/despatch.php?".$this->assignString($params,"&",'urlencode');
		}

		function buildFields(){
			$fields = parent::buildFields();
			if(@$fields['uid']) $fields['uid']->setParam('label','UID');
			foreach($fields as $k=>$v){
				if(!$this->canWriteField($k)){
					$fields[$k] = new PermissionLessDecorator($v);
				}
			}
			return $this->fields = $fields;
		}
		function canWriteField($field){
			return $this->applyFilters('field_access',!in_array($field,array('ctime','mtime')),$field);
		}

		function cms_regenerateImages(){
			$res = $this->getAll(array(),array('for_fetch'=>1));
			while($inst = $res->fetch()){
				foreach($inst->relationships as $k=>$v){
					$v = $inst->loadRel($k);
					if($v['file_type']=='img'){
						$original = $inst->$k('original',array('as_url'=>false));
						$inst->$k=$original;
						$km = $k."_md5";
						$inst->$km='';
						$inst->writeToDB();
					}
				}
				$inst->__destroy();
			}
		}

		function cms_download($params=array()){
			cms_no_template();
			@ob_end_clean();
			@ob_end_clean();
			@ob_end_clean();
			@ob_end_clean();
			require_once(dirname(__FILE__).'/../../functions/downloadFile.php');
			$version = $params['version'];
			$rel = $params['file'];
			$file = $this->$rel($version,array('as_url'=>false));
			session_write_close();
			downloadFile($file,basename($file));
			die();
		}
		function confirmCommand($command){
			if(@$_POST['confirm']){
				return true;
			} else {
				$this->showView('confirmCommand',array('command'=>'clear all orders'));
				return false;
			}
		}
	}

	class SortableModel extends BozModel {
		function getListingColumns(){
			$cols = parent::getListingColumns();
			$cols = array_merge(array("Sort"=>"<div class='sortable-handle'><span>[MOVE]</span></div><input class='id-field' value='".$this->getId()."' type='hidden'/><input class='model-field' value='".$this->getModelName()."' type='hidden'/><input class='type-field' type='hidden' value='record'/>"),$cols);
			return $cols;
		}
		function getSiblings($where=array(),$params=array()){
			return $this->getAll($where,$params);
		}
		function getAll($where = array(),$params=array()){
			$defaults = array('order'=>$this->getSortField());
			return parent::getAll($where,array_merge($defaults,$params));
		}

		function getSortField(){
			return "sorting";
		}
		function defaultFields(){
			$fields = parent::defaultFields();
			$sort = $this->getSortField();
			$fields[$sort] = new SortingField($sort);
			return $fields;
		}
		function getDefaultOrder(){
			return $this->getSortField();
		}
		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
			$sort = $this->getSortField();
			$fields[$sort]= new SortingField($sort);
			return $fields;
		}

		function initialiseSorting(){
			$sortField = $this->getSortField();
			$this->$sortField = -$this->getID();
			$this->writeToDB($this);
		}
		function swapWith($other){
			$sortField = $this->getSortField();
			list($this->$sortField,$other->$sortField) = array($other->$sortField,$this->$sortField);
			$this->writeToDB($this);
			$other->writeToDB($other);
		}

		function unused_writeToDB($obj){
			$existed = $obj->exists();
			parent::writeToDB($obj);
			if(!$existed){
				$sortField = $this->getSortField();
				$obj->$sortField = $obj->getID();
				parent::writeToDB($obj);
			}
		}
		function cms_move_down(){
			try {
				$this->move_down();
				$this->showView('confirmation');
			} catch(Exception $e){	
				$this->showView('editErrors',array('message'=>$e->getMessage()));
			}
		}
		function move_down(){
			$id = $this->getID();
			$found=false;
			$sub = $this->getSiblings(array(),array('for_fetch'=>1));
			while($v = $sub->fetch()){
				if($found){
					$this->swapWith($v);
					return;
				}
				if($v->getID()==$id)
					$found=true;
			}
			if($found)
				throw new Exception('Already at bottom');
			else
				throw new Exception('Internal Error Please Inform Admin');
		}

		function cms_move_up(){
			try {
				$this->move_up();
				$this->showView('confirmation');
			} catch(Exception $e){	
				$this->showView('editErrors',array('message'=>$e->getMessage()));
			}
		}
		function move_up(){
			$id = $this->getID();
			$found=false;
			$last=null;
			$sub = $this->getSiblings(array(),array('for_fetch'=>1));
			while($v = $sub->fetch()){
				if($v->getID()==$id){
					if($last){
						$this->swapWith($last);
						return;
					} else {
						throw new Exception('Already At Top');
					}
				}
				$last = $v;
			}
			throw new Exception('Internal Error Please Inform Admin');
		}

		function cms_move_after($params){
			try {
				$this->move_after($params);
				$this->showView('confirmation');
			} catch(Exception $e){
				$this->showView('editErrors',$e->getMessage());
			}
		}
		function cms_move_before($params){
			try {
				$this->move_before($params);
				$this->showView('confirmation');
			} catch(Exception $e){
				$this->showView('editErrors',$e->getMessage());
			}
		}
		function move_after($params){
			do {
			$sub = $this->getSiblings(array(),array('for_fetch'=>1));
			$found=false;
			$moved = false;
			$last = false;
			while($sib=$sub->fetch()){

				if($sib->getId()==$this->getId()){
					if($last){
						return true ;
					}
					if($found){
						$this->move_up();
					} else {
						$this->move_down();
					}	
					$moved=true;
					break;
				}

				if($sib->getId()==$params['other']) $found=$last=true;
				else $last=false;
			}
			} while($moved);
		}
		function move_before($params){
			do {
				$sub = $this->getSiblings(array(),array('for_fetch'=>1));
				$found=false;
				$moved=false;
			while($sib=$sub->fetch()){
				if($sib->getId()==$params['other']){
					if($last){
						return true ;
					}
					if($found){
						$this->move_down();
					} else {
						$this->move_up();
					}	
					$moved=true;
					break;
				}

				if($sib->getId()==$this->getId()) $found=$last=true;
				else $last=false;
			}
			} while($moved);
		}

		function requiredIndexes(){
			$indexes = parent::requiredIndexes();
			$sort = $this->getSortField();
			if(!is_array($sort)) $sort = array($sort);
			$indexes[] = $sort;
			return $indexes;
		}

		function on_fields_created($fields){
			if(@$fields[$sort = $this->getSortField()]){
				$q = $this->getAll(array(),array('for_fetch'=>1));
				while($r = $q->fetch()){
					$r->$sort = $r->getId();
					$r->writeToDB();
					$r->__destroy();
				}
			}
		}
		function filter_cms_tbody_css($css){
			$css.=" sortable ajax-sortable";
			return $css;
		}
	}

	Model::addModel('MMModel',dirname(__FILE__).'/../models/mmmodel.php');
	cms_trigger_action('models_loaded');
?>
