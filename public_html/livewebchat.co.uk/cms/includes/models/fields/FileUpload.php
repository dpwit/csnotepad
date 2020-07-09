<?
/**
* @package Model_System
*/

	class BasicFileInput extends Field {
		function defaultParams(){
			$params = parent::defaultparams();
			$params['type'] = 'file';
			$params['delete'] = true;
			return $params;
		}

		function transformPostData($post,$obj){
			$name = $this->htmlName($obj);
			$targetName = str_replace(".","_",$name);
			if(($file = @$_FILES[$targetName]) && ($file['size'])){
				$this->setValue($obj,$file['tmp_name']);
				$obj->uploadedFiles[$this->name] = $file;
			} elseif(@$post["$name-delete"]){
				$this->setValue($obj,null);
			}
		}

		function getAssigns($obj){
			$rel = $obj->loadRel($this->name);
			return $rel['manager']->getAssigns();
		}

		function getTeaser($obj){
			return basename($this->getFileName($obj));
		}
		function checkInvalid($obj){
			if($ext = $this->allowed_extensions()){
				$this->addValidation(new FileTypeValidation($ext));
			}
			return parent::checkInvalid($obj);
		}
		function allowed_extensions(){
			$type = $this->param('file_type');
			if($type) $default = array($type);
			else $default = array();

			return $this->param('allowed-extensions',$default);
		}
		function getFileUrl($obj,$size='original'){
			$field = $this->name;
			$file = $obj->$field(array('size'=>$size,'as_url'=>true));
			return $file;
		}
		function getFileName($obj,$size='original'){
			$field = $this->name;
			$file = $obj->$field(array('size'=>$size,'as_url'=>false));
			return $file;
		}
		function getValueForForm(){
			return '';
		}
		function renderHTML($obj){
			$value = $this->getTeaser($obj);
			$input = parent::renderHTML($obj);

			$file = $this->getFileName($obj);

			if(file_exists($file)){
				$value.=" (".(nice_file_size($file)).")";
			}

			if($value){
				$format = $this->param("format",'<div class="reveal"><div class="reveal-hidden">%1$s<div class="file-types">Accepted types: %3$s</div></div><div class="reveal-teaser">%2$s<div class="delete-link">%4$s</div></div></div>');
			} else {
				$format = $this->param("empty-format",'<div class="file-input">%1$s</div><div class="file-types">Accepted types: %3$s</div>');
			}
			$ext = $this->allowed_extensions();
			if(!$ext) $ext[] = 'any';
			$deleteLink = '';
			if($this->param('delete',false)){
				$deleteLink = "Delete file: <input type='checkbox' name='".$this->htmlName($obj)."-delete'/>";
			}
			$input = sprintf($format,$input,$value,join(", ",$ext),$deleteLink);
			return $input;
		}
	}

	class FileTypeValidation extends ModelValidation {
		function __construct($exts){
			$this->exts = $exts;
		}
		function error($value,$label='none',$field=null,$model=null){
			$allowedExtensions = $this->exts;
			//TODO: SHOULD NOT NEED @ symbol here, is required for product variations images in shop
			if(@is_file($value) && $allowedExtensions){
				$file = @$model->uploadedFiles[$field->name]['name'];
				if(!$file) $file = $value;
				$ext = strtolower(preg_replace("/^.*\./","",$file));
				if(!in_array($ext,$allowedExtensions)) return "Accepted File Types: ".join(", ",$allowedExtensions);
			}
			return false;
		}
	} 

	class ImagePreviewFileInput extends BasicFileInput {
		function setParams($params=array()){
			$defaults = array(
				'allowed-extensions'=>array('jpg','gif','jpeg','png')
			);
			$params = array_merge($defaults,$params);
			parent::setParams($params);
		}
		function getTeaser($obj){
			$name = $this->name;
			if(is_file($thumb = $this->getFileName($obj,'thumb'))){
				return "<img src='".$this->getFileUrl($obj,$this->param('preview-size','thumb'))."'/><br/><span class='caption'>".parent::getTeaser($obj)."</span>";
			}
			return false;
		}
	}
?>
