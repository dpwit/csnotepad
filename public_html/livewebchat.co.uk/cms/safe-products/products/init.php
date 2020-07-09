<?
	cms_require_module('orders');
	class ProductHooks {
		function __construct(){
			cms_register_filter('cms_menu',$this);
			cms_listen_action('models_loaded',$this,false,10);
			cms_listen_action('components_loaded',$this);
			cms_listen_action('cms_header',$this);
			cms_listen_action('model_instantiated_order_item',$this);
			cms_listen_action('model_instantiated_feuser',$this);
			cms_register_filter('config_defaults',$this);
			cms_register_filter('cms_section_name',$this);
			cms_register_filter('concrete_product_types',$this,false,-10);
			cms_register_filter('create_class_order_item',$this);
			cms_register_filter('get_unloggedin_account_menu',$this);
		}

		function concrete_product_types($array){
			$product = Model::loadModel('Product');
			$types = Model::loadModel('Product_Type')->getAll(new NotLogic(array('abstract'=>1)),array('for_fetch'=>1));
			$std = new stdclass();
			while($type=$types->fetch()){
				$std->product_type_uid=$type->getId();
				$std->variation_of_uid=0;
				$array[$type->getLabel()] = array('class'=>$product->applyFilters('create_class','Product',$std,'products'),'type'=>$type);
			}
			return $array;
		}

		function config_defaults($config){
			$config['products']['category_images'] = 1;
			$config['products']['category_descriptions'] = 1;
			$config['products']['category_display_descendant_products'] = 1;
			$config['products']['category_display_sub_categories'] = 0;
			$config['products']['max_products_per_order'] = 5;
			$config['products']['per_page'] = 12;
			$config['products']['images_for_variations'] = 0;
			$config['orders']['basket_reserved_minutes'] = 15;
			$config['products']['stock_control'] = 1;
			return $config;
		}

		function cms_menu($menu){
			// Bit lazy, but should hopefully work out the currently relevant category
			// in the cms
			$current = @$_GET['parent_uid'] ? $_GET['parent_uid'] : @$_GET['category_uid'];
			$menu['Catalogue'] = array(
				"View Categories"=>"overview.php?section=Products&model=ProductCategory",
				"Featured Products"=>"overview.php?section=Products&model=Feature",
			);
			if(Config::value('stock_control','products')){
				$menu['Catalogue']['Stock Report'] = "overview.php?model=StockControl";
			}
			$menu['Shop Config'] = array(
				"View Product Types"=>"overview.php?section=Shop Config&model=product_type",
				"New Product Type"=>"newItem.php?section=Shop Config&model=product_type",
				"View Attributes"=>"overview.php?section=Shop Config&model=product_attribute",
				"New Attribute"=>"newItem.php?section=Shop Config&model=product_attribute",
//				"View Attribute Options"=>"overview.php?section=Shop Config&model=product_attribute_option",
//				"New Attribute Option"=>"newItem.php?section=Shop Config&model=product_attribute_option",
			);
			return $menu;
		}

		function models_loaded(){
			Model::addModel('Category',dirname(__FILE__).'/class.CategoryModel.php','ProductCategoryModel');
			Model::addModel('ProductCategory',dirname(__FILE__).'/class.CategoryModel.php','ProductCategoryModel');
			Model::addModel('Product',dirname(__FILE__).'/class.ProductModel.php','ProductModel');
			Model::addModel('ProductVariation',dirname(__FILE__).'/class.ProductVariation.php');
			Model::addModel('ProductImage',dirname(__FILE__).'/class.ProductImage.php');
			Model::addModel('Product_Image',dirname(__FILE__).'/class.ProductImage.php','ProductImage');
			Model::addModel('RelatedProduct',dirname(__FILE__).'/class.RelatedProduct.php','RelatedProductModel');
			Model::addModel('Related_Product',dirname(__FILE__).'/class.RelatedProduct.php','RelatedProductModel');
			Model::addModel('Feature',dirname(__FILE__).'/class.Feature.php','Feature');
			Model::addModel('Bundle',dirname(__FILE__).'/class.BundleModel.php','BundleModel');
			Model::addModel('Product_Type',dirname(__FILE__).'/class.ProductModel.php');
			Model::addModel('Product_Attribute',dirname(__FILE__).'/AttributeModels.php');
			Model::addModel('Product_Attribute_Option',dirname(__FILE__).'/AttributeModels.php');
			Model::addModel('Manufacturer',dirname(__FILE__).'/class.ManufacturerModel.php','ManufacturerModel');
			Model::addModel('GenericManufacturer',dirname(__FILE__).'/class.ManufacturerModel.php');
			Controller::addController('StockControl',dirname(__FILE__).'/controllers/StockControl.php','StockControlController');
			Model::addModel('Product_Order_Item',dirname(__FILE__).'/class.ProductOrderItem.php','ProductOrderItem');
		}
		function components_loaded(){
			Component::mapClass('CategoryMenu',dirname(__FILE__).'/components/CategoryMenu.php');
			Component::mapClass('CategoryListing',dirname(__FILE__).'/components/CategoryListing.php');
			Component::mapClass('ProductListing',dirname(__FILE__).'/components/ProductListing.php');
			Component::mapClass('CombinedListing',dirname(__FILE__).'/components/CombinedListing.php');
			Component::mapClass('ProductDetail',dirname(__FILE__).'/components/ProductDetail.php');
			Component::mapClass('ProductBrowse',dirname(__FILE__).'/components/ProductBrowse.php');
			Component::mapClass('ProductSearchForm',dirname(__FILE__).'/components/ProductSearch.php','ProductSearchForm');
		}
		function cms_header(){
?>
<link rel='stylesheet' type='text/css' href='/ext/modules/products/css/cms.css'/>
<?
		}

		function model_instantiated_order_item($oi){
			$oi->hasCustom('product',array($this,'product_for_item'));
		}
		function product_for_item($oi){
			return Model::g('Product',$oi->ref_id);
		}
		function model_instantiated_feuser($user){
			$user->hasCustom('downloads',array($this,'downloads_for_user'));
		}
		function downloads_for_user($user,$where=array(),$params=array()){
			$where['user.id'] = $user->getId();
			return Model::loadModel('Download')->getAll($where,$params);
		}
		function cms_section_name($section,$model){
			if($model instanceof ProductCategoryModel) return 'Catalogue';
			if($model instanceof ProductModel) return 'Catalogue';
			if($model instanceof StockControlController) return 'Catalogue';
			if($model instanceof MP3UploadController) return 'Catalogue';
			if($model instanceof SalesReportController) return 'Orders';
			if($model instanceof Feature) return 'Catalogue';
			return $section;
		}
		function get_unloggedin_account_menu(){
			return Component::get('CategoryMenu');
		}
		function create_class_order_item($class,$factory,$row){
			if($row->ref_table=='products') return 'Product_Order_Item';
			return $class;
		}
	}
	new ProductHooks;
?>
