<?
	Model::loadModel('Product');
	class ProductVariation extends ProductModel {
		function __construct($obj=null){
			parent::__construct($obj,'product');
			$this->hasOne('variation_of',array('model'=>'Product'));
			$this->hasCustom('variations',array($this,'variations'));
			$this->copy_from_original();
		}

		function variations(){
			return array();
		}

		function __call($func,$args){
			try {
				return parent::__call($func,$args);
			} catch(BadRelationshipException $e){
				return call_user_func_array(array($this->variation_of(),$func),$args);
			}
		}

		function on_before_write(){
			$this->clear_duplicates();
		}

		function on_model_saved(){
			$this->copy_from_original();
		}

		function product_images($where=array(),$params=array()){
			if($res = $this->__call('product_images',$where,$params)) return $res;
			elseif($parent = $this->variation_of()) {
				return $parent->product_images($where,$params);
			} else {
				return $res;
			}
		}

		function noCopyFields(){
			$no_copy = array('stock','spaceCharacter','internalSQL','fields','status',
				'table','fields','explicitFields','relationships','isPhysical','origObj','Product','status');
			return $no_copy;
		}
		function copy_from_original(){
			if(!$this->variation_of_uid) return;

			// Possibly need to be able to explicitly specify that they are separate although same value

			$v = $this->variation_of();

			$no_copy = $this->noCopyFields();

			if($v)
			foreach($v as $k=>$v){
				$mine = @$this->$k;
				if(in_array($k,$no_copy)) continue;
				if((!$mine) || (is_numeric($mine) && (0==$mine)))
					$this->$k=$v;
			}
		}

		function clear_duplicates(){
			$v = $this->variation_of();
			$whiteList = $this->noCopyFields();

			if($v)
			foreach($v as $k=>$v){
				if(in_array($k,$whiteList)) continue;
				if($this->$k==$v) unset($this->$k);
			}
		}

		function varied_option(){
			return $this->product_attribute_options(array(),array('single'=>1));
		}

		function variesBy(){
			return $this->varied_option()->attribute()->name;
		}
		function describeVariation(){
			$opt = $this->varied_option();
			return @$opt->name;
		}

		function getLabel(){
			return parent::getLabel()." (".$this->describeVariation().")";
		}
		function getUrl(){
			return $this->variation_of()->getUrl();
		}

		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
			unset($fields['slug']);
			unset($fields['variations']);
			return $fields;
		}
		function categories($where=array(),$params=array()){
			if($v = $this->variation_of()) return $v->categories($where,$params);
			else return $this->getRelated('categories',$where,$params);
		}
		function filter_cms_edit_form($sections){
			$sections = parent::filter_cms_edit_form($sections);
			$sections['Info'][] = 'product_attribute_options';
			return $sections;
		}
	}
?>
