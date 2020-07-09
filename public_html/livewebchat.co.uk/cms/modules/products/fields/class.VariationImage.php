<?
	require_once(__MODELS_BASE__.'/fields/FileUpload.php');
	class VariationImage extends ImagePreviewFileInput {
		function getAssigns(){
			return array();
		}
		function setParams($params=array()){
			$defaults = array(
				'preview-size'=>'icon',
			);
			$params = array_merge($defaults,$params);
			parent::setParams($params);
		}
		function transformPostData($post,$obj){
			$name = $this->htmlName($obj);
			$targetName = str_replace(".","_",$name);
			if(($file = @$_FILES[$targetName]) && ($file['size'])){
				$images = $obj->product_images(array(),array('no-parent'=>1));
				if(!$images){
					$images = array(Model::loadModel('Product_Image')->createNew());
				}
				$obj->product_images = $images;
				$image = $images[0];
				$old = $this->name;
				$this->name='image';
				$_FILES[$this->htmlName($image)] = $_FILES[$name];
				$post[$this->htmlName($image)] = @$post[$name];
				parent::transformPostData($post,$image);
				$this->name=$old;
			}
		}
		function getFileName($obj,$size='original'){
			return $this->getFile($obj,$size,false);
		}
		function getFileUrl($obj,$size='original'){
			return $this->getFile($obj,$size,true);
		}
		function getFile($obj,$size='original',$asUrl=false){
			$name = $this->name;
			$image = $obj->$name(array(),array('single'=>1,'debug'=>1,'no-parent'=>1));
			if($image) {
				return $image->image($size,array('as_url'=>$asUrl));
			} else {
				return false;
			}
		}
		function _getTeaser($obj){
			$name = $this->name;
			$image = $obj->$name(array(),array('single'=>1,'debug'=>1));
			if($image) {
				$this->name='image';
				$teaser = parent::getTeaser($image);
				$this->name = $name;
				return $teaser;
			}
			else return "No Image";
		}
	}
?>
