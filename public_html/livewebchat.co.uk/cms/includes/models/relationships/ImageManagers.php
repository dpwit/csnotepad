<?
/**
* @package Model_System
*/

	class ImageFileManager extends BasicFileManager {
		function __construct($field,$params,$model){
			$defaults = cms_apply_filter('image_manager_defaults',array( 
				'sizes' => array(
					''=> array( 'width'=>400,'height'=>300, 'resizer'=>'ImageResizerFitInBounds' ),
					'thumb'=> array( 'width'=>200,'height'=>200, 'resizer'=>'ImageResizerCropSquare' ),
				),
				'extraSizes'=>array()
			),$model,$field,$params);
			parent::__construct($field,array_merge($defaults,$params),$model);
		}
		function getInputs(){
			return array();
		}
		function newSourceFile(){
			require_once(dirname(__FILE__).'/ImageResizers.php');
			$name = $this->name;
			$value = $this->fetch('original',array('as_url'=>false));
			if(!is_file($value)) return;

			$sizes = $this->params['sizes'];
			$sizes = $this->model->applyFilters('image_sizes',array_merge($this->params['sizes'],$this->params['extraSizes']),$name);

			foreach($sizes as $key=>$params){
				$skey = $key;
				if(!$skey) $skey = 'full';
				foreach($params as $k=>$v){
					$this->params[$skey.ucfirst($k)] = $v;
				}
				$class = @$params['resizer'];
				if(!@class_exists($class)) $class='ImageResizerFitInBounds';
				$resizer = new $class;
				$thumb = $this->fetch($key,array('as_url'=>false));
				@mkdir(dirname($thumb),0777,true);
				$resizer->resize($this->model,$key,$this,$this->master_file(),$thumb);
				@chmod($thumb,0777);
			}
		}
		function master_file(){
			return $this->fetch('original',array('as_url'=>false));
		}

		function allVersions(){
			return array_merge(array('original'),array_keys($this->params['sizes']),array_keys($this->params['extraSizes']));
		}

		function param($key,$default=null){
			if(array_key_exists($key,$this->params)) return $this->params[$key];
			return $default;
		}
	}

?>
