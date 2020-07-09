<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/ManagerInterface.php');
	class BasicFileManager implements IExternalManager {
		function __construct($field,$params,$model){
			$this->name = $field;
			$defaults = array('file_type'=>'img','keep_on_delete'=>false,'db'=>true);
			$params = array_merge($defaults,$params);
			$this->params = $params;
			$this->model=$model;
			cms_trigger_action('file_manager_created',$this);
		}
		function __destroy(){
			foreach(get_object_vars($this) as $k=>$v){
				unset($this->$k);
			}
		}
		function initRel($rel){ return $rel;}

		function getExtension($size=''){
			if(($size=='original') && ($ext = @$this->params['original-ext'])) return $ext;
			if($ext = @$this->params['ext']) return $ext;
			$name=$this->name;
			return preg_replace("/^.*\.([^.]*$)/",'\\1',$this->getFilename());
		}
		function getBase(){
			return preg_replace("/\.[^.]*$/","",basename($this->getFilename()));
		}

		function getFileUrl($size='',$id = null , $extension = null){
			if(is_null($id)) $id = $this->model->getID();
			if(is_null($extension)) $extension = $this->getExtension($size);
			$base = "$id.$extension";
			if(!@$this->params['id-only']){
				$base =$this->model->urlEncode($this->getBase())."-".$base;
			}
			return "/".$this->params['file_type']."/".$this->model->getTableName()."/$this->name/$size/$base";
		}
		function getDocRoot(){
			if($root = $_SERVER['DOCUMENT_ROOT']) return $root;
			return realpath(dirname(__FILE__).'/../../../..');
		}
		function fetch($size='',$params=array()){
			if($size=='exists') return is_file($this->fetch('original',array('as_url'=>false)));
			if(is_array($size)) $params = $size;
			else $params['size'] = $size;
			$defaults = array('size'=>'','as_url'=>true,'default'=>false);
			$params = array_merge($defaults,$params);

			$relative = $this->getFileUrl($params['size']);
			$abs = $this->getDocRoot().$relative;

			if($params['default']){
				$fName='default';
				if(@$params['defaultFileName'])
					$fName = $params['defaultFileName'];
				if(!file_exists($abs)){
					$relative = dirname($this->getFileUrl($params['size']))."/$fName.$params[default]";
					$abs = $this->getDocRoot().$relative;
				}
			}
			return $params['as_url'] ? $relative : $abs;
		}
		function before_write(){
			$name = $this->name;
			$field5 = $name."_md5";
			$value = @$this->model->$name;
			$this->old_md5 = @$this->model->$field5;
			$temp = $this->model->$name;
			$this->model->$name = @$this->model->origObj->$name;
			$this->oldFiles = $this->fetchAll();
			$this->model->$name = $temp;
			if(is_file($value)){
				$md5 = md5_file($value);
				$this->model->$field5=$md5;
			}
		}
		function store($newModel,$oldValues,$assigns){
			$name = $this->name;
			$field5 = $name."_md5";
			$value = @$newModel->$name;
			$deleteFiles = array_diff($this->fetchAll(),$this->oldFiles);
			foreach($deleteFiles as $old) if(is_file($old)){
				unlink($old);
			}
			if(is_file($value)){
				$name = $this->fetch('original',array('as_url'=>false));
				@mkdir(dirname($name),0777,true);
				copy($value,$name);
				if($newModel->$field5 != $this->old_md5){
					$this->newSourceFile();
				}
			}
		}
		function newSourceFile(){
		}
		function getFilename(){
			$name = $this->name;
			if($file = @$this->model->uploadedFiles[$name]){
				return $file['name'];
			} else {
				return preg_replace("/-(?:".preg_quote($this->model->getId())."|NEW\d*)(.[^.]*$)/i","\\1",@$this->model->$name);
			}
		}
		function getAssigns(){
			if(!$this->params['db']) return array();
			$name = $this->name;
			$fname = $this->getFilename();
			if(is_file($fname)) $fname = basename($fname);

			if(!@$this->params['id-only']){
				$fname = basename($this->getFileUrl());
			}
			return array($name=>$fname);
		}

		function setDataFromPost($data,$form='default'){
		}

		function validate(){
			return true;
		}

		function allVersions(){
			return array('original','');
		}
		function fetchAll($as_url = false){
			$all = array();
			foreach($this->allVersions() as $v){
				$all[$v] = $this->fetch($v,array('as_url'=>$as_url));
			}
			return $all;
		}
		function pre_delete(){
			$this->toDelete = $this->fetchAll();
		}
		function post_delete(){
			if($this->params['keep_on_delete']) return;
			foreach($this->toDelete as $file){
				if(is_file($file)) {
					//echo "Delete $file\n";
					unlink($file);
				} else {
					//echo "No File $file\n";
				}
			}
		}
		function on_init(){}

		function getAllDownloadLinks(){
			$actions = array();
			foreach($this->allVersions() as $v){
				$actions[$this->model->urlFor('download',array('file'=>$this->name,'version'=>$v))] = $this->model->variableToEnglish($v);
			}
			return $actions;
		}
		function getCmsActions(){
			$actions = array();
			if(@$this->params['download_link']){
				return array_merge($actions,$this->getAlLDownloadLinks());
			}
			return $actions;
		}
	}
?>
