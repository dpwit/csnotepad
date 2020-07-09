<?
	require_once(__MODELS_BASE__.'/fields/MMSortedSelector.php');
	class ProductSelector extends MMSortedSelector {
		function setParams($params=array()){
			$params['add_link'] = array($this,'get_add_link');
			parent::setParams($params);
		}
		function get_add_link($obj){
			$model = Model::loadModel($this->param('product_model','Product'));
			return $model->urlFor('new',array('bundle_uid'=>$obj->getId()));
		}
	}
