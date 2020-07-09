<?
	class ProductSalesReportsHooks {
		function __construct(){
			cms_listen_action('handle_front_end',$this);
			cms_listen_action('front_end_complete',$this);
			//$this->RequestId = time().@$_SERVER['REQUEST_URI'];
			cms_listen_action('models_loaded',$this);
			cms_register_filter('cms_menu',$this);
		}
		
		function cms_menu($menu){
			//$menu['Orders']['Sales Report'] = 'despatch.php?model=salesreport&action=index';
			return $menu;
		}
		function models_loaded(){
			Controller::addController('SalesReport',dirname(__FILE__).'/SalesReportController.php','SalesReportController');
		}
		function handle_front_end(){
			
		}
		function front_end_complete(){
			
		}
	}
	new ProductSalesReportsHooks;
