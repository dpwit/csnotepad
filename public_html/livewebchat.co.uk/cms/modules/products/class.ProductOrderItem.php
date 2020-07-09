<?
	cms_module_require('orders','OrderModel.php');

	class ProductOrderItem extends Order_Item {
		function __construct($obj=null){
			parent::__construct($obj);
			$this->hasOne('product',array('field'=>'ref_id'));
		}
		function product($where=array(),$params=array()){
			return $this->referenced($where,$params);
		}
		function getIrrelevantWhere(){
			$where = parent::getIrrelevantWhere();
			$where['ref_table !=']='products';
			return $where;
		}

		function getReadLockTables(){
			$tables = parent::getReadLockTables();
			$tables[] = 'products';
			$tables[] = 'products as `bundles`';
			$tables[] = 'product_in_bundle';
			$tables[] = 'product_types';
			$tables[] = 'product_in_bundle as `product_in_bundles`';
			$tables[] = 'product_in_category as `product_in_categories`';
			$tables[] = 'products_mm_product_attribute_options';

			$tables = array_unique($this->referenced()->applyFilters('checkout_read_lock_tables',$tables));
			return $tables;
		}

		function isAvailableForSale($qty){
			$p = $this->product();
			return $p->isAvailableForSale($qty,$this->uid);
		}

		function getAvailabilityErrors(){
			$p = $this->product();
			if(!$p instanceof ProductModel) return;
			return $p->getAvailabilityErrors($this->getQuantity(),$this->getId());
		}
		function correctAvailabilityErrors(){
			$p = $this->product();
			if(!$p instanceof ProductModel) return;
			if(!$this->isAvailableForSale($this->quantity)){
				$qty = $this->quantity;
				while(--$qty>0){
					if($this->isAvailableForSale($qty)){
						break;
					}
				}
				if($qty){
					$this->quantity=$qty;
					$this->writeToDB();
				} else {
					$this->delete();
				}
			}
		}

		function on_updateAvailability(){
			$this->product()->itemsSold($this->getQuantity());
		}

		function on_order_state_changed(){
			if($this->order()->order_state()->end_state){
				$basket = Model::loadModel('Basket')->getFirst();
				if($basket) $basket->removeItem($this->ref_id);
			}
		}

		function requiresShipping(){
			return $this->referenced()->requiresShipping();
		}
		function getTotalWeight(){
			return $this->getWeight()*$this->getQuantity();
		}
		function getWeight(){
			return $this->referenced()->getWeight();
		}
	}
?>
