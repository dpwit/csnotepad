<?
	require_once(__MODELS_BASE__.'/fields/MMSortedSelector.php');
	class ProductSelector extends MMSortedSelector {
		function defaultParams(){
			$params = parent::defaultParams();
			$params['add_link'] = array($this,'get_add_link');
			return $params;
		}
		function get_add_link($obj){
			$model = Model::loadModel($this->param('product_model','Product'));
			return $model->urlFor('new',array('bundle_uid'=>$obj->getId()));
		}
	}
