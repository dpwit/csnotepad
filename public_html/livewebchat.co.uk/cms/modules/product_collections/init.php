<?
	class ProductCollectionHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this);
			cms_listen_action('controllers_loaded',$this);
			cms_register_filter('get_product_class',$this);
			cms_listen_action('cms_header',$this);
			cms_register_filter('special_where_product_type',$this);
			cms_register_filter('special_where_product',$this);
			cms_register_filter('product_browsing_restrict',$this);
		}
		function product_browsing_restrict($where){
//			$where['bundle.uid is'] = 'null';
			return $where;
		}
		function cms_header(){
?>
<script type='text/javascript' src='/cms/modules/product_collections/css/cms.js'></script>
<?
		}

		function special_where_product($curr,$type,$key,$value){
			switch($key){
			case 'collection_appropriate':
				$curr = array('variation_of_uid is'=>'null');
				break;
			}
			return $curr;
		}
		function special_where_product_type($curr,$type,$key,$value){
			switch($key){
			case 'for_collection':
				//TODO: Should we allow these recursively, i.e. collections of collections?
				//TODO: This should check for child product types
				return array('name !='=>'Collection');
			}
			return $curr;
		}

		function models_loaded(){
			Model::addModel('ProductCollection',dirname(__FILE__).'/models/class.ProductCollection.php');
		}
		function controllers_loaded(){
			Controller::addController('NewProduct',dirname(__FILE__).'/controllers/class.NewProductController.php','NewProductController');
			Controller::addController('NewProductController',dirname(__FILE__).'/controllers/class.NewProductController.php','NewProductController');
		}

		function get_product_class($class,$typeId,$typeObj){
			static $colTypes;
			if(!$colTypes){
				//TODO: Should this be here?  Should we have worked out the root path before calling filters?
				$parents = $colTypes = Model::loadModel('Product_Type')->getAll(array('name'=>'Collection'));

				while($parents){
					$next = array();
					foreach($parents as $type){
						$next = array_merge($next,$type->children());
					}
					$colTypes = array_merge($colTypes,$next);
					$parents = $next;
				}
				$colTypes = array_method_map('getId',$colTypes);
			}
			switch($typeObj->name){
			case 'Collection':
				return 'ProductCollection';
			}
			return $class;
		}
	}
	new ProductCollectionHooks;
?>
