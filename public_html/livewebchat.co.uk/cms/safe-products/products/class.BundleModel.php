<?
	require_once(dirname(__FILE__).'/class.ProductModel.php');
	class BundleModel extends ProductModel {
		function __construct($obj=null){
			parent::__construct($obj);
			$this->hasMM('products_in',array(
				'table'=>'product_in_bundle',
				'model'=>'Product',
				'composition'=>1,
				'local_id'=>'bundle_uid',
				'order'=>'sorting',
				'back'=>'bundles'
			));
		}

		function cms_afterSave(){
			$_SESSION['lastRealPage'] = $this->urlFor('editItem');
			parent::cms_afterSave();
		}

		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
			require_once(dirname(__FILE__).'/BundleFields.php');
			$fields['products_in'] = new ProductSelector('products_in',$this->loadRel('products_in'),array('where'=>array('visible'=>0),'edit_link'=>true));
			return $fields;
		}
		function fiter_checkout_read_lock_tables($tables){
			foreach($this->products_in() as $product){
				$tables = $product->applyFilter('checkout_read_lock_tables',$tables);
			}
			return $tables;
		}
		function getViewDirectories(){
			$dirs = parent::getViewDirectories();
			$dirs = array_insert($dirs,cms_module_resolve('products','views/bundlemodel'),2);
			return $dirs;
		}

		function inStock($count=1,$my_order_item=0){
			foreach($this->products_in() as $product){
				if(!$product->inStock($count,$my_order_item)) return false;
			}
			return true;
		}
		function getLeafProducts(){
			$products = array();
			foreach($this->products_in() as $product){
				$products = array_merge($products,$product->getLeafProducts());
			}
			return $products;
		}
		function isPhysical(){
			foreach($this->products_in() as $product){
				if($product->isPhysical()) return true;
			}
			return false;
		}
		function getWeight(){
			$weight = 0;
			foreach($this->products_in() as $product){
				$weight+=$product->getWeight();
			}
			return $weight;
		}

		function canSellSeparately(){
			return true;
		}

		function on_pre_delete(){
			$q = $this->products_in(array(),array('for_fetch'=>1));
			while($p = $q->fetch()){
				if((count($p->bundles()<2))&&($p->shouldDeleteWithBundle())) {
					$p->delete();
				}
			}
		}
	}
?>
