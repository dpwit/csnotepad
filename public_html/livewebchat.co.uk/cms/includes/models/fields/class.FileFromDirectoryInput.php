<?
/**
* @package Elite_Promo
*/

	require_once(__MODELS_BASE__.'/fields/FileUpload.php');

	class FileFromDirectoryInput extends BasicFileInput {
		function transformPostData($post,$obj){
			$hn = $this->htmlName($obj)."-select";
			if($fname = $post[$hn]){
				if(file_exists($abs = $this->getUploadDir($obj)."/$fname")){
					$this->setValue($obj,$abs);
					@$obj->selectedFiles[$this->name] = $abs;
				}
			} else {
				parent::transformPostData($post,$obj);
			}
		}
		function getUploadDir($obj){
			return BASEPATH."/../uploads";
		}

		function checkValid($files){
			if($ext = $this->param('allowed-extensions')){
				foreach($files as $k=>$v){
					$v = preg_replace("/.*\./","",$v);
					if(!in_array($v,$ext))
						unset($files[$k]);
				}
			}
			return $files;
		}
		function availableFiles($obj){
			if($upload_dir = $this->getUploadDir($obj)){
				$dir = @opendir($upload_dir);
				$files = array();
				if($dir)
				while($f = readdir($dir)){
					$abs = "$upload_dir/$f";
					if(is_file($abs)){
						$files[] = basename($abs);
					}
				}
				$files = $this->checkValid($files);
				if($files) $files = array_combine($files,$files);
				return $files;
			}
			return array();
		}
		function renderHTML($obj){
			$html='';
			try {
				$field = $this->name."_image";
				if($obj->$field('exists')){
					$thumb = $obj->$field('thumb');
					$html = "<div class='file_preview'><img src='$thumb'/></div>";
				}
			} catch(BadRelationshipException $e){
			}
			$html .= parent::renderHTML($obj);
			$hn = $this->htmlName($obj)."-select";
			$select = "<select name='$hn'>";
			$options = array_merge(array('Or Select From Existing Files'),$this->availableFiles($obj));

			if(count($options)==1) return $html;
			foreach($options as $k=>$v){
				$select.="<option value='$k'>$v</a>";
			}
			$select.="</select>";
			$html.=$select;
			return $html;
		}
		function afterWrite($obj,$old){
			parent::afterWrite($obj,$old);
			if($old = @$obj->selectedFiles[$this->name]){
				unset($obj->selectedFiles[$this->name]);
				unlink($old);
			}
		}

	}
?>
