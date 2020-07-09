<?
/**
* @package Model_System
*/

require_once(dirname(__FILE__).'/FileImportField.php');
class ImageField extends FileUploadField {
	function __construct($name='imageExt',$params=array()){
		parent::__construct($name,$params);
		$this->addListener($this);
	}

	function setParams($params){
		if(!(@$params['fullHeight']||@$params['fullWidth'])){
			$params['fullWidth'] = 600;
		}
		if(!(@$params['thumbHeight']||@$params['thumbWidth'])){
			$params['thumbWidth'] = 146;
			$params['thumbHeight'] = 146;
		}
		$defs = array(
			'jpegQuality'=>'60%',
			'db'=>true,
		);
		$params = array_merge($defs,$params);

		parent::setParams($params);
	}
	function getFilenames($obj){
		$files = array();
		foreach(array('','thumb','original') as $field){
			$files[] = $this->getFilename($obj,$field);
		}
		return $files;
	}

	function renderHTML($obj){
		$name = $this->htmlName($obj);
		$html='';
		if($this->param('showThumbs',true)){
			if($this->param('showEmpty',false) || file_exists($this->getFileName($obj))){
				$v = $this->getValue($obj).$obj->mtime;
				$html.="<div class='image-input'>";
				if($this->param('previewFull',false)){
					$html.="<img id='{$this->htmlName($obj)}-large' src='".$this->getFileUrl($obj)."?$v' width='".($this->param('fullWidth',1200)/4)."' />";
				}
				if($this->param('previewThumb',true)){
					$html.="<img id='{$this->htmlName($obj)}-thumb' src='".$this->getFileUrl($obj,'thumb')."?$v' width='".$this->param('thumbWidth',100)."' />";
				}
				$html.="</div>";
			} else {
				$html.="<h2>No File</h2>";
			}
		}
		$html .= $this->renderFileInput($obj);
		return $html;
	}
	function renderFileInput($obj){
		return parent::renderHTML($obj);
	}

	function importFile($fileOnDisk, $nameOfUpload, $obj, $old){
		parent::importFile($fileOnDisk,$nameOfUpload,$obj,$old);
	//	foreach(array('original','thumb','') as $size){
	//		$old = $this->getFilename($obj,$size);
	//		unlink($old);
	//	}
		$fileName = $this->getFileName($obj);
		foreach( array(	
				''	=>	array($this->param('fullWidth'),$this->param('fullHeight'),$this->param('jpegQuality')),
				'thumb'	=>	array($this->param('thumbWidth'),$this->param('thumbHeight'),$this->param('jpegQuality'))
			) as $size=>$params){
				list($width,$height,$quality) = $params;
				$extraArgs = ($quality && strtolower($this->getValue($obj))=='jpg') ? ' -quality '.$quality : '';
				$newFile = $this->getFileName($obj,$size);
				@mkdir( dirname($newFile),0777,true);
				$action = ($size=='thumb') ? 'thumbnail' : 'resize';
				$this->getResizer()->resize($obj,$size,$this,$fileName,$newFile);
		}
//		} elseif($this->copiedFrom){
//			foreach(array('','thumb') as $size){
//				@copy($this->getFileName($this->copiedFrom,$size),$this->getFileName($obj,$size));
//			}
//		}
	}
	function getResizer(){
		if(!$this->resizer){
			$this->resizer = $this->param('resizer');
			if(is_string($this->resizer)){
				if(!class_exists($this->resizer))$this->resizer="ImageResizer".$this->resizer;
				if(!class_exists($class = $this->resizer))$this->resizer=false;
				else $this->resizer = new $class();
			}
			if(!$this->resizer) $this->resizer = new ImageResizer;
		}
		return $this->resizer;
	}
	function copyFrom($a,$b){
		parent::copyFrom($a,$b);
		$this->copiedFrom=$a;
	}
	function getFileUrl($obj,$size='original',$value=false){
		if(!$value) $value = $this->getValue($obj);
		$parts = explode(".",$value);
		$value = array_pop($parts);
		if(!$id=$obj->getID()) $id=rand().time();
		return '/'.$this->param('dir','img/'.$obj->getTableName()).'/'.$size.'/'.$id.'.'.$value;
	}
	function getFileName($obj,$size='original',$value=false){
		$root = $_SERVER['DOCUMENT_ROOT'];
		if(!$root) $root = dirname(__FILE__).'/../../../../';
		return $root.$this->getFileUrl($obj,$size,$value);
	}
	function getFileNameForStorage($obj,$size='original',$value=false){
		return basename($this->getFileUrl($obj,$size,$value));
	}
}
class ImageFromIDField extends ImageField {
}
class ImageFromTitleField extends ImageField {
	function setParams($params){
		$params['extOnly'] = true;
		parent::setParams($params);
	}
	function getFileUrl($obj,$size='original',$value=false){
		if(!$value) $value = $this->getValue($obj);
		if(!$id=$obj->getID()) $id=rand().time();
		return '/'.$this->param('dir','img/'.$obj->getTableName()).'/'.$size.'/'.$obj->getLabel().'.'.$value;
	}
}
class ImageFromFilenameField extends ImageField {
	function setParams($params){
		$params['extOnly'] = false;
		parent::setParams($params);
	}
	function getFileUrl($obj,$size='original',$value=false){
		if(!$value) $value = $this->getValue($obj);
		if(!$id=$obj->getID()) $id=rand().time();
		return '/'.$this->param('dir','img/'.$obj->getTableName()).'/'.$size.'/'.$value;
	}
}
require_once(dirname(__FILE__).'/ImageResizers.php');
