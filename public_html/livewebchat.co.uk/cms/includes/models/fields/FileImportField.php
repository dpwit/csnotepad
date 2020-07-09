<?
/**
* @package Model_System
*/

class FileImportField extends Field {
	var $listeners = array();
	function renderHTML($obj){
		$name = $this->htmlName($obj);
		$html='';
		if($this->param('db') && $this->param('show-value',true)) $html=$this->getValue($obj)."<br/>";
		return $html." <input type='file' name='$name'/>";
	}
	function setParams($params){
		$defaults = array(
			'db'=>false,
			'listeners'=>array(),
		);
		parent::setParams(array_merge($defaults,$params));
		$this->listeners = $this->param('listeners');
	}
	function transformPostData($post,$obj){
		$targetName = str_replace(".","_",$this->htmlName($obj));
		if(($file = $_FILES[$targetName]) && ($file['size'] && !$file['imported'])){
			$_FILES[$targetName]['imported'] = true;
			$obj->tmpFile[$this->name] = $file;
			$name = $file['name'];
			if($this->param('extOnly',false)){
				$name =  array_pop(explode(".",$name));
			}
			$this->setValue($obj,$name);
		}
	}
	function addListener($listener){
		$this->listeners[] = $listener;
	}

	function afterWrite($obj,$oldObj){
		if(($tmpFile = @$obj->tmpFile[$this->name]) && !$tmpFile['imported']){
			$obj->tmpFile[$this->name]['imported'] = true;
			$listeners = $this->listeners;
			if(!$listeners) $listeners = array($obj);
			unset($obj->tmpFile[$this->name]);
			foreach($listeners as $listen){
				$listen->importFile($tmpFile['tmp_name'],$tmpFile['name'],$obj,$oldObj);
			}
		}
	}
}
abstract class FileUploadField extends FileImportField {
	function __construct($name,$params=array()){
		parent::__construct($name,$params);
		$this->addListener($this);
	}
	function transformPostData($post,$obj){
		$old = $this->getFilename($obj);
		$forDelete = $this->getFilenames($obj);
		parent::transformPostData($post,$obj);
		$new = $this->getFilename($obj);
		if($old!=$new){
			$this->markForDeletion($forDelete);
			$counter=0;
			$value = $this->getValue($obj);
			$parts = explode(".",$value);
			$ext = array_pop($parts);
			while(file_exists($name = $this->getFileName($obj)) && ($name!=$last)){
				$counter++;
				$fullName=join(".",$parts)."-$counter.".$ext;
				$this->setValue($obj,$fullName);
				$last = $name;
			}
		}
	}
	function getFilenames($obj){
		return array($this->getFilename($obj));
	}
	abstract function getFilename($obj);
	function markForDeletion($files){
		if(!is_array($files)) $files = array($files);
		foreach($files as $file) $this->forDelete[] = $file;
	}
	function importFile($fileOnDisk, $nameOfUpload, $obj, $old){
		$fileName = $this->getFileName($obj);
		if(file_exists($fileOnDisk)) {
			@mkdir(dirname($fileName),0777,true);
			copy($fileOnDisk,$fileName);
		}
		if(is_array($this->forDelete))
		foreach($this->forDelete as $f){
			if(file_exists($f))
				unlink($f);
		}
	}
}
?>
