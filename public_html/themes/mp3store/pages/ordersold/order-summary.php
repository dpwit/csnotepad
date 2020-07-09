<?
	$template->addComponent(Component::get('AccountMenu'),'leftnav');
	BreadCrumb::setBreadCrumb(new BreadCrumbItem("/orders/","Orders"));
	BreadCrumb::push($_SERVER['REQUEST_URI'],$item->title);
	$template->addComponent(Component::get('Breadcrumb'),'content-header');
	switch($item->order_state()->name){
	case 'Complete':
		$template->addComponent(Component::get('FileInclude','modules/checkout/order_complete',array('order'=>$item)),'main');
		break;
	case 'Pending':
		$template->addComponent(Component::get('FileInclude','modules/checkout/order_pending',array('order'=>$item)),'main');
		break;
	}
	$context->setTitle('Order Summary');
?>
