<?
	Model::loadModel('Product');
	class ProductVariation extends ProductModel {
		function __construct($obj=null){
			parent::__construct($obj,'product');
			$this->hasOne('variation_of',array('model'=>'Product'));
			//unset($this->relationships['variations']);
			//$this->hasCustom('variations',array($this,'variations'));
			$this->copy_from_original();
		}

		function variations(){
			return array();
		}
		function specialWhere($k,$v){
			switch($k){
			case 'available':
				if($v){
					return	new OrJoin(array('price >'=>0,'variation_of.price >'=>0));
				} 
			}
			return parent::specialWhere($k,$v);
		}

		function __call($func,$args){
			try {
				return parent::__call($func,$args);
			} catch(BadRelationshipException $e){
				return call_user_func_array(array($this->variation_of(),$func),$args);
			}
		}

		function on_pre_composition_post_data($rel,$parent){
			$this->product_type_uid = $parent->product_type_uid;
			if(@$parent->origObj)
				$this->postedParent = clone($parent->origObj);
		}
		function on_before_write(){
			if(@$this->postedParent){
				$this->clear_duplicates($this->postedParent);
			}
			$this->clear_duplicates();
			unset($this->postedParent);
		}

		function on_model_saved(){
			$this->copy_from_original();
		}

		function product_images($where=array(),$params=array()){
			if($res = $this->__call('product_images',array($where,$params))) return $res;
			elseif((!@$params['no-parent']) && $parent = $this->variation_of()) {
				return $parent->product_images($where,$params);
			} else {
				return $res;
			}
		}
		function variationImage($size='',$params=array()){
			if($img = $this->product_images(array(),array('no-parent'=>1,'single'=>1))){
				return $img->image($size,$params);
			}

			foreach($this->product_attribute_options() as $option){
				if($option->image('exists')) return $option->image($size,$params);
			}
			return false;
		}

		function noCopyFields(){
			$no_copy = array('stock','spaceCharacter','internalSQL','fields','status',
				'table','fields','explicitFields','relationships','isPhysical','origObj','Product','status','form',
			);
			$no_copy = array_merge($no_copy,array_keys($this->relationships));
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

		function clear_duplicates($other=null){
			if($other){
				$v = $other;
			} else {
				$v = $this->variation_of();
			} 
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
			$option =  $this->varied_option();
			if($option) return $option->attribute()->name;
		}
		function describeVariation(){
			$opt = $this->varied_option();
			return @$opt->name;
		}

		function getLabel(){
			return parent::getLabel()." (".$this->describeVariation().")";
		}
		/*function getUrl(){
			return $this->variation_of()->getUrl();
		}*/
		function getURL(){
//		var _dump($this->getKeysForHooks('geturl'));
			return $this->applyFilters('geturl',$this->variation_of()->getUrl());
		}
		

		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
			unset($fields['slug']);
			unset($fields['variations']);
			require_once(dirname(__FILE__).'/fields/class.VariationImage.php');
			$fields['product_images'] = new VariationImage('product_images',array('db'=>false));
			$fields['name']->validations = array();
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
		
		function getBySlug($slug, $where, $params)
		{
			$slugParts= explode('-',$slug);
			$productPart = array_splice($slugParts,count($slugParts)-1);
			
			$slugParts = join('-',$slugParts);
			$productPart = end($productPart);
			
			//var _dump($slugParts);
			//var _dump($productPart);
			
			$parentProduct = parent::getBySlug($slugParts, $where, $params);
			if($parentProduct)
			{	
				$variation = $this->getFirst(
					array(
						'variation_of_uid'=>$parentProduct->uid,
						'uid'=>$productPart
					),
					array(
						'debug'=>false
					)
				);
				
				if($variation){
					return $variation;
				}
				die('No Variation');
			}
			return false;
		}
	}
?>
