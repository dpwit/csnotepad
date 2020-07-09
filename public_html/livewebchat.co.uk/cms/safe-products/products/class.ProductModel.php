<?
	require_once(dirname(__FILE__).'/class.MP3StoreModel.php');
	class ProductModel extends MP3StoreModel {
		var $isPhysical = true;
		function __construct($obj=null){
			parent::__construct($obj,'product');
			$this->doInternalSQL();
			$this->hasMM('categories',array('table'=>'product_in_category','composition'=>1,'model'=>'ProductCategory','foreign_id'=>'category_uid'));
			$this->hasMM('bundles',array('table'=>'product_in_bundle','foreign_id'=>'bundle_uid','back'=>'products_in'));
			$this->hasOne('product_type',array('required'=>true));
			$this->hasMM('manufacturers',array('table'=>'products_mm_manufacturers','order'=>'manufacturers_order','composition'=>true));
			$this->hasMM('features',array('table'=>'featured_products'));
			$this->hasMM('product_attribute_options',array(
				'composition'=>true,
				'input'=>__MODELS_BASE__.'/fields/MMInput.php:BasicMMRadio',
			));
			$this->hasOne('variation_of',array('model'=>'Product'));
			$this->hasMany('variations',array('model'=>'ProductVariation','ref_field'=>'variation_of_uid','composition'=>true,'quick-ui'=>true));
			$this->hasMany('product_images',array('composition'=>true,'input'=>__MODELS_BASE__.'/fields/class.AjaxManyInput.php:AjaxManyInput'));
//			$this->hasMany('related_products',array('composition'=>true));
			if(!@$this->uid && !@$this->product_type_uid) $this->product_type_uid = @$_GET['product_type_uid'];
		}
		function getPurchaseUrl(){
			return "/basket/add/".$this->getId();
		}
		function filter_composition_fields($fields,$relationship){
			switch($relationship){
				case 'variations':
					$old = $fields;
					$fields = array(
						'stock'=>$old['stock'],
						'product_attribute_options'=>$old['product_attribute_options'],
					);
					$fields['product_attribute_options']->setParam('cols',1);
			}
			return $fields;
		}
		function activateOldImages(){
			$size = Config::value('news-homepage-width','site');
		$this->hasFile('image',array('file_type'=>'img',
				'extraSizes'=>array(
					'home'=>array( 'width'=>$size,'height'=>$size, 'resizer'=>'ImageResizerFitAndPad' ,),
					'detail'=>array( 'width'=>300,'height'=>300,'resizer'=>'ImageResizerFitAndPad' ,),
					'list'=>array( 'width'=>168,'resizer'=>'ImageResizerCropSquare' ,),
					'icon'=>array( 'width'=>50,'height'=>50, 'resizer'=>'ImageResizerCropSquare' ,),
					
					'prodThumbHome'=>array('width'=>90,'height'=>90, 'resizer'=>'ImageResizerFitInBounds'),
					'prodThumb'=>array('width'=>110,'height'=>110, 'resizer'=>'ImageResizerFitInBounds'),
					'prodDetail'=>array('width'=>400,'height'=>400, 'resizer'=>'ImageResizerFitInBounds'),

				)
			));
		}
 
		function getTextFields(){
			return array("name","manufacturer.name","description");
		}

		function shouldDeleteWithBundle(){
			return $this->matchesQuery(array('has_product_page'=>0));
		}

		function image($size='',$params=array()){
			return $this->main_image()->image($size,$params);
		}
		function imageCaption(){
			return $this->main_image()->caption;
		}
		function main_image(){
			if($im = $this->product_images()) return array_shift($im);
			return Model::loadModel('Product_Image')->createNew();
		}
		function getModelNamesForHooks(){
			return array_merge(parent::getModelNamesForHooks(),array('product'));
		}
		function isOwnedBy($user){
			if(!$user) return false;
			$order = Model::loadModel('Order')->getFirst(array(
				'user_uid'=>$user->getId(),
				'order_items.ref_table'=>'products',
				'order_items.ref_id'=>$this->getId(),
				'order_state.name'=>'Complete'
			));
			if($order) return true;

			foreach($this->bundles() as $bundle){
				if($bundle->isOwnedBy($user)) return true;
			}

			return false;
		}

		// AMBIGUOUS... WILL NOT ALWAYS WORK...
		function getParent(){
			if($bundle = $this->bundles(array(),array('single'=>1))) return $bundle;
			else return $this->categories(array(),array('single'=>1));
		}
		function getIrrelevantWhere(){
			$id = $this->restrictTypeId();
			$where=array();
			if($id){
				$where['product_type_uid !='] = $id;
			}
			return $where;
		}

		function getSiblings($where=array(),$params=array()){
			$cat = $this->categories(array(),array('single'=>1));
			if($cat){
				$where['categories.uid']=  $cat->getId();
			} else {
				$where['categories.uid is'] = 'null';
			}
			$where['cms_listable'] = true;
			$params['irrelevant'] = false;
			return parent::getAll($where,$params);
		}
		function getViewDirectories(){
			$dirs = parent::getViewDirectories();
			$dirs = array_insert($dirs,cms_module_resolve('products','views/productmodel'),1);
			return $dirs;
		}
		function restrictTypeId(){
			return false;
		}

		function getLeafProducts(){
			return array($this);
		}

		function manufacturerLinks(){
			$links = array();
			foreach($this->manufacturers() as $a){
				if($a->status>0){
					$links[$a->getUrl()] = $a->getLabel();
				} else {
					$links[] = $a->getLabel();
				}
			}
			return $links;
		}

		function cms_afterSave(){
			if(($b=@$_REQUEST['add_to_bundle']) && (!$this instanceof BundleModel)){
				$b = Model::g('Bundle',$b);
				$b->products_in[] = $this->getId();
				$b->writeToDB();
			}
			parent::cms_afterSave();
		}
		function createNew($values=array()){
			if($id = $this->restrictTypeId()){
				$values['product_type_uid'] = $id;
			}
			$new = parent::createNew($values);
			if($b=@$_REQUEST['bundle_uid']){
				$b = Model::g('Bundle',$b);
				$new->copyFromBundle($b);
			}
			return $new;
		}
		function copyFromBundle($b){
			foreach($b->categories() as $c){
				$this->categories[] = $c->getId();
			}
		}

		function getPrice(){
			return $this->price;
		}
		function prettyPrice(){
			return $this->makePrettyPrice($this->getPrice());
		}
		function makePrettyPrice($price){
			return "&pound;".number_format($price,2);
		}

		function minPrice($available=true){
			$price = $this->getPrice();
			if(!$price) $price=1000000;
			$where = array();
			if($available) $where['available'] = 1;
			foreach($this->variations($where) as $v){
				$vp = $v->minPrice();
				if($vp<$price) $price=$vp;
			}
			if($price<1000000) return $price;
		}
		function filter_fields_built($fields){
static $count;
var_dump("HERE ".get_class($this));
if(++$count>20) {
dump_trace();
die("Hmmmm");
}
			$fields = parent::filter_fields_built($fields);
			$cat = @$_REQUEST['category_uid'];
			if(!$cat) $cat=@$_REQUEST['parent_uid'];
			if($cat){
				if(!$this->exists()) {
					$categories = explode(",",$cat);
					$this->categories = $categories;
				}
			}
			if($t = $this->restrictTypeId()){
				$fields['product_type_uid'] = new ConstantField('product_type_uid',array('value'=>$t));
			} else {
				$fields['product_type_uid'] = new ForeignLabel('product_type',array('pass-through'=>true));
			}
			$fields['name']->addValidation(new RequiredValidation());
			//$fields['categories']->setParam('cols',1);
			require_once(dirname(__FILE__).'/fields/class.PriceCalculatorField.php');
			if(Config::value('use_vat','orders')){
				$fields['price'] = new PriceCalculatorField('price');
			}
			//unset($fields['slug']);
			unset($fields['categories']);
			if(!@$variation_of_uid){
				$fields['variation_of_uid'] = new HiddenField('variation_of_uid');
			} 
		
		
			$images = @$fields['product_images'];
			unset($fields['product_images']);
			$fields['catalogue_number'] = new Field('catalogue_number');
			if($images)
			$fields['product_images'] = $images;
//			require_once(dirname(__FILE__).'/fields/class.StockByAttributeField.php');
//			$fields['stock_by_attribute'] = new StockByAttributeField('stock_by_attribute');
			if(!($this->product_type()&&$this->product_type()->product_attributes())) unset($fields['variations']); 
			else $fields['variations']->setParam('label','Product Variations');
			
			$fields['description'] = new FCKEditorField('description');
			$fields['price'] = new NumericField('price');
			if($this->hasInfiniteStock()) {
				unset($fields['stock']);
			} else {
				$fields['stock'] = new NumericField('stock',array('places'=>0,'default'=>" 0"));
			}
			unset($fields['other_artists']);
			try {
				if($v = $this->variations()){
					require_once(__MODELS_BASE__.'/fields/NoteField.php');
					$fields['stock'] = new NoteField('stock',array('note'=>$this->getTotalStock()."(".count($v)." styles)",'db'=>true,'value'=>0));
				} 
			} catch(DBException $e){
				//This happens during table creation
			}
			cms_module_require('products','BundleFields.php');
			$fields['manufacturers'] = new MMSortedSelector('manufacturers',$this->loadRel('manufacturers'),array('where'=>array('visible'=>0)));
			$fields['weight'] = $this->isPhysical() ? new NumericField('weight') : new HiddenField('weight',array('value'=>0,'db-type'=>'decimal'));
			unset($fields['other_artists']);
			return $fields;
		}

		/** Allows different classes to be instantiated based on properties of the product
		 * record itself.
		 */
		function create($class,$r,$table){
			$class = cms_apply_filter('get_product_class',$class,$r->product_type_uid,$table);
			return parent::create($class,$r,$table);
		}
		function filter_new_class($class,$values){
			$class = cms_apply_filter('get_product_class',$class,@$values['product_type_uid']);
			return $class;
		}

		function filter_cms_new_params($array){
			$array['product_type_uid'] = @$_REQUEST['product_type_uid'];
			return $array;
		}
		function filter_create_class($class,$record,$table){
			if($record->variation_of_uid) {
				Model::loadModel('ProductVariation');
				return 'ProductVariation';
			}
			return $class;
		}

		function configuredAvailable($count){
			return $this->status>0 && $this->price>0.00;
		}

		function getAvailabilityErrors($qty,$order_item_uid=0){
			if(!$this->isAvailableForSale($qty,$order_item_uid)){
				while(--$qty>0){
					if($this->isAvailableForSale($qty,$order_item_uid)){
						break;
					}
				}
				if($qty){
					return "Only $qty of ".$this->getLabel()." available";
				} else {
					return $this->getLabel()." is out of stock";
				}
			}
		}

		function specialWhere($k,$v){
			switch($k){
			case 'list_in_shop':
				return new AndJoin(array('available'=>1,'visible'=>1,'has_product_page'=>1));
			case 'available':
				if($v){
					return	new OrJoin(array('price >'=>0,'variation_of.price >'=>0,'variations.price >'=>0));
				} else {
					return array();
				}
			case 'has_product_page':
				return $this->specialWhere('abstract',!$v);
			case 'abstract':
				$v = !$v;
			case 'cms_listable':
			case 'cms_editable':
				return array('product_type.abstract'=>$v ? '0' : '1');
			case 'orphaned':
				return array('categories.uid '.($v?'is':'is not')=>'null');
			case 'variant':
				$ret = new OrJoin(array('variation_of_uid'=>0,'variation_of_uid is'=>'null'));
				if($v){
					$ret = new NotLogic($ret);
				}
				return $ret;
			}
			return parent::specialWhere($k,$v);
		}

		function setStock($stock){
			$this->stock = $stock;
		}
		function getStock(){
			return $this->hasInfiniteStock() ? 999999 : $this->stock;
		}
		function getTotalStock(){
			$stock = $this->getStock();
			foreach($this->variations() as $v){
				$stock+=$v->getTotalStock();
			}
			return $stock;
		}
		function lockTable(){
			mysql_query("LOCK TABLE $products WRITE");
		}
		function releaseLock(){
			mysql_query("UNLOCK TABLES");
		}
		function addStock($stock){
			$this->lockTable();
			$this->stock+=$stock;
			$this->writeToDB();
			$this->releaseLock();
		}
		function inStock($count=1,$order_uid=0){
//Possibly should account for stock of variations
			return $this->hasInfiniteStock() || ($this->stock>=($count+$this->quantityInBasketsOtherThan($order_uid)));
		}
		function itemsSold($count){
			if(!$this->hasInfiniteStock()){
				$this->stock-=$count;
				$this->writeToDB();
			}
		}
		function getNumberAvailableForSale(){
			return min($this->getStock()-$this->quantityInBaskets(),Config::value('max_products_per_order','products'));
		}

		function quantityInBaskets(){
			return $this->quantityInBasketsOtherThan(0);
		}
		function activeStatuses(){
			return array('NEW','In Process','3DAUTH');
		}
		function quantityInBasketsOtherThan($order_item_uid){
			$other_items = Model::loadModel('Order_Item')->getAll(array(
				'ref_id'=>$this->getId(),
				'ref_table'=>'products',
				'uid !='=>$order_item_uid,
				'order.mtime >' => round((time()-Config::value('basket_reserved_minutes','orders')*60)/60)*60,
				'order.order_state.name in'=>$this->activeStatuses(),
			),array('for_fetch'=>1,'debug'=>0));
			$total = 0;
			while($item = $other_items->fetch()){
				$total+=$item->getQuantity();
			}
			return $total;
		}

		function getVisibleWhere(){
			return new OrJoin(array('status >'=>0,'variation_of.status >'=>0,'variations.status >'=>0));
		}


		function isAvailableForSale($count=1,$order_item_uid=0){
			return $this->configuredAvailable($count) && $this->inStock($count,$order_item_uid);
		}

		function isDownloadable(){
			return !$this->isPhysical();
		}

		function getDescription(){
			return $this->description;
		}
		function containingProducts(){
			$products = array($this);
			foreach($this->bundles() as $product){
				$products = array_merge($products,$product->containingProducts());
			}
			return $products;
		}

		function getProductTypeName($plural=false){
			return $this->product_type()->getLabel();
		}
		function isPhysical(){
			return $this->isPhysical;
		}
		function requiresShipping(){
			return $this->isPhysical();
		}
		function hasInfiniteStock(){
			return !$this->isPhysical();
		}
		function getWeight(){
			return $this->weight;
		}

		function createVariation($fields=array()){
			$defaults = array('status'=>1);
			$fields['variation_of_uid'] = $this->getId();
			$fields = array_merge($defaults,$fields);
			$variation =  Model::loadModel('ProductVariation')->createNew($fields);
			$variation->copy_from_original();
			return $variation;
		}
		function filter_cms_edit_form($sections){
			$hiddenFields = array('uid','categories','product_attribute_options');
			$keys = $sections[''];

			unset($sections['']);
			$sections['Basics'] = array('name','status','slug','label','product_type_uid','catalogue_number','label_uid',);
			$sections['Stock'] = array('price','weight','stock','stock_by_attribute');
			$sections['Info'] = array('description','product_images','products_in','related_products','manufacturers');

			foreach($sections as $k=>$v){
				$hiddenFields = array_merge($hiddenFields,$v);
			}

			$sections['Other'] = array_diff($keys,$hiddenFields);
//			$parts = $sections['Parts'];
//			unset($sections['Parts']);
//			$sections['Parts'] = $parts;
			return $sections;
		}

		function cms_move_category($params){
			if(@$params['to']){
				$this->categories = array($params['to']);
				$this->writeToDB();
				$this->showView('confirmation');
			} else {
				$this->showView('select_category');
			}
		}
		function getBuySubProductsText(){
			return $this->product_type()->getBuySubProductsText();
		}
		function getBuyText(){
			return $this->product_type()->getBuyText();
		}
		function categories($where=array(),$params=array()){
			if($rel = $this->getRelated('categories',$where,$params)) return $rel;
			if($bundle = $this->bundles(array(),array('single'=>1))){
				return $bundle->categories($where,$params);
			}
			return array();
		}
	}
	class PhysicalProductModel extends ProductModel {
		function __construct($obj=null){
			parent::__construct($obj);
			$this->isPhysical=true;
		}
	}
	abstract class DigitalProductModel extends ProductModel {
		function isPhysical(){
			return false;
		}
		abstract function download_link();
		abstract function canDownload();
		abstract function getTimesDownloaded();
		abstract function getAllowedDownloads();
		abstract function getLastDownloadDate();
	}

	class Product_Type extends BozModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,$table);
			$this->doInternalSQL();
			$this->hasOne('parent',array('model'=>'Product_Type'));
			$this->hasMM('product_attributes',array('composition'=>true));
		}
		function is_descendant_of($uidOrObj){
			$uid = is_object($uidOrObj) ? $uidOrObj->getId() : $uidOrObj;
			if(!$uid) return false;
			if($this->getId()==$uid) return true;
			elseif($p = $this->parent()) return $p->is_descendant_of($uidOrObj);
			else return $p;
		}
		function filter_fields_built($fields){
			$fields['abstract'] = new CheckboxField('abstract');
			$fields['description'] = new TextArea('description');
			$fields['buy_text'] = new Field('buy_text');
			$fields['display_name'] = new Field('display_name');
			$fields['buy_subproducts_text'] = new Field('buy_subproducts_text');
			return $fields;
		}
		function getBuyText(){
			if($this->buy_text) return $this->buy_text;
			if($p = $this->parent()) return $p->getBuyText();
			return 'Buy Product';
		}
		function getBuySubProductsText(){
			if($this->buy_subproducts_text) return $this->buy_subproducts_text;
			if($p = $this->parent()) return $p->getBuySubProductsText();
			return 'Buy Individually';
		}

		function displayName(){
			return $this->display_name ? $this->display_name : $this->getLabel();
		}
	}
?>
