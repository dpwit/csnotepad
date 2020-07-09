<?
	require_once(dirname(__FILE__).'/class.MP3StoreModel.php');
	class ProductCategoryModel extends MP3StoreModel {
		function __construct($obj=null){
			parent::__construct($obj,'product_category');
			$this->doInternalSQL();
			$this->hasMM('products',array('table'=>'product_in_category','sorting'=>'sorting','local_id'=>'category_uid'));
			$this->hasOne('parent',array('model'=>'ProductCategory'));
			$this->hasMany('children',array('model'=>'ProductCategory','ref_field'=>'parent_uid'));
			$this->hasMM('ancestors',array(
				'table'=>'category_closures',
				'local_id'=>'category_uid',
				'foreign_id'=>'ancestor_uid',
				'model'=>'ProductCategory',
				'composition'=>true,
				'input'=>false));
			$this->hasMM('descendants',array('table'=>'category_closures','local_id'=>'category_uid','foreign_id'=>'ancestor_uid','model'=>'ProductCategory'));
			$pi = Model::loadModel('ProductImage')->loadRel('image');
			$this->hasFile('image',array(
				'file_type'=>'img',
				'extraSizes'=>$pi['extraSizes'],
			));
		}
		function template($for){
			return "modules/products/".$this->applyFilters('template','category-'.$for,$for).".php";
		}
		function filter_template($curr,$purpose){
			if($purpose=='browse') return 'browse';
			else return $curr;
		}
		function getProductTypeName($plural=false){
			return "Category";
		}
		function is_descendant_of($uidOrObj){
			$uid = is_object($uidOrObj) ? $uidOrObj->getId() : $uidOrObj;
			return $this->get($uid,array('descendants.uid'=>$this->getId()));
		}
		function descendant_products_browsing($where=array(),$params=array()){
			$where['product_type.name !='] = 'MP3';
			
			return $this->descendant_products($where,$params);
		}
		function descendant_products($where=array(),$params=array()){
			$where['categories.ancestors.uid'] = $this->getId();
			$model = @$params['model'] ? $params['model'] : 'Product';
			return Model::loadModel($model)->getAll($where,$params);
		}
		function getParent($where=array(),$params=array()){
			$temp = $this->parent($where,$params);
			if($temp) return $temp;
			else return Model::g('Page',array('title'=>'Shop'),array('single'=>true));
		}
		function getTopLevel($where=array(),$params=array()){
			$where['parent_uid'] = 0;
			return $this->getAll($where,$params);
		}

		function getModelName(){
			return "ProductCategory";
		}

		function getListingColumns(){
			$cols = parent::getListingColumns();
			$cols['Name'] = "<a href='overview.php?section=Products&model=ProductCategory&parent_uid=$this->uid'>$cols[Name]</a>";
			return $cols;
		}
		function non_variant_products($where=array(),$params=array()){
			$where['variant'] = 0;
			return $this->products($where,$params);
		}
		function cmsProductListing($where=array(),$params=array()){
			$where['product.product_type.name !=']='MP3';
			$where['variant'] = 0;
			return $this->products($where,$params);
		}
		function orphanedProducts($where=array(),$params=array()){
			$where['cms_editable'] = 1;
			$where['orphaned'] = 1;
			unset($where['parent_uid']);
			return Model::ga('Product',$where,$params);
		}
		function showListing($params=array()){
			if(!$params)$params=array();
			$func = 'getAll';
			$rootListing = array('getAll','orphanedProducts');
			$properListing = array('children','cmsProductListing');

			$functions = $rootListing;
			$parent = $this;
			$restrict = array();
			if(@$_GET['search']){
				$restrict = array('like'=>$_GET['search']);
				$functions = array('getAll',array(Model::loadModel('Product'),'getAll'));
			} elseif(@$_REQUEST['parent_uid']) {
				$functions=$properListing;
				$parent = $this->get($_REQUEST['parent_uid']);
			} else {
				$restrict['parent_uid']=0;
			}
			$this->showView('list-children',array_merge(array( 
				'parent'=>$parent,
				'listings'=>$functions,
				'restrict'=>$restrict
			),$params));
			return true;
		}

		// This stuff all maintains a separate closures table, representing the ancestor/descendant relationship
		// Update closures before saving if existing object
		function on_before_write(){
			$old = $this->origObj;
			if($this->exists() && ($this->parent_uid!=$old->parent_uid)){
				$this->generateClosures();
			}
		}

		// Create closures after saving if this is a new object
		function on_model_created(){
			$this->generateClosures();
			$this->writeToDB();
		}

		// Update children after saving if any
		function on_model_saved($old){
			if(!$this->parent_uid) $this->parent_uid=0;
			if($this->parent_uid!=$old->parent_uid){
				foreach($this->descendants(array('uid !='=>$this->getId()),array('debug'=>1)) as $desc){
					$desc->generateClosures();
					$desc->writeToDB();
				}
			}
		}
		function on_pre_delete(){
			$q = $this->children(array(),array('for_fetch'=>1));
			while($cat = $q->fetch()) $cat->delete();

			$q = $this->products(array(),array('for_fetch'=>1));
			while($p = $q->fetch()){
				if(count($p->categories()<2)) $p->delete();
			}
		}
		function generateClosures(){
			$next = $this;
			$this->ancestors = array();
			do {
				$this->ancestors[] = $next->getId();
				$next = $next->parent();
			} while($next);
		}
		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
//			$fields['parent_uid'] = new HiddenField('parent_uid',array('db-type'=>'int'));
			if($cat = @$_REQUEST['parent_uid']){
				$fields['parent_uid']->setParam('default',$cat);
			}
			if(!Config::value('category_images','products')) unset($fields['image']);
			if(Config::value('category_descriptions','products')) $fields['description'] = new TextArea('description');
			return $fields;
		}

		function cms_move_category($params){
			if(@$params['to']){
				$this->parent_uid = $params['to'];
				$this->writeToDB();
				$this->showView('confirmation');
			} else {
				$this->showView('select_category');
			}
		}
		function manufacturerLinks(){ return array(); }
		function variations(){ return array(); }
		function inStock(){ return false; }
	}
?>
