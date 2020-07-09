<?
	include(dirname(__FILE__).'/../userManagement/dashboard-feuser.php');
	$template->clearSection('main');
	BreadCrumb::setBreadCrumb(new BreadCrumbItem('/orders/','Orders'));
	$template->addComponent(Component::get('MyOrders'),'main');
	//$template->addComponent(Component::get('Breadcrumb'),'content-header');
	$context->setTitle('Orders');
?>
