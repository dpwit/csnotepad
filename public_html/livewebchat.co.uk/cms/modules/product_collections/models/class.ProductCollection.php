<?
	Model::loadModel('Bundle');
	class ProductCollection extends BundleModel {
		function getPrice(){
			$price=0;
			foreach($this->products_in() as $p){
				$price+=$p->getPrice();
			}

			return $price;
		}
		function inStock($count=1,$my_order_item=0){
			foreach($this->products_in() as $product){
				if(!$product->anyInStock($count,$my_order_item)) return false;
			}
			return true;
		}
		function filter_fields_built($fields){
			require_once(__MODELS_BASE__.'/fields/NoteField.php');
			$fields = parent::filter_fields_built($fields);
			$fields['products_in']->setParam('add_link',array($this,'get_add_link'));
			$fields['products_in']->setParam('extra-url','&restrict='.urlencode(json_encode(array('collection_appropriate'=>1,'product_type.name !='=>'Collection','uid !='=>$this->getId()))));
			$fields['price'] = new NoteField('price',array('note'=>$this->prettyPrice()));
			return $fields;
		}

		function get_add_link($link){
			return Controller::getInstance('NewProduct')->urlFor('selectType',array('bundle_uid'=>$this->getId()));
		}
	}
?>
