<?
	cms_module_require('components','Table.php');
	class MyOrders extends PaginatedTable {
		function __construct(){
			parent::__construct(array(
				'model'=>Model::loadModel('User')->getLoggedInUser(),
				'listFunc'=>'orders',
				'listing'=>'modules/orders/my-orders',
				'where'=>array('order_state.name in'=>array('Complete','Pending')),
				'alternate'=>Component::get('FileInclude','modules/orders/no-orders'),
			));
		}
	}
?>
