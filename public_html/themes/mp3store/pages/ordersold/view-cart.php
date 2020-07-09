<?
	include(dirname(__FILE__)."/../products/default.php");
	BreadCrumb::setBreadCrumb(new BreadCrumbItem('view-cart.html','View Cart',Model::loadModel('Page')->getFirst(array('shortName'=>'Shop'))));
	$template->clearSection('left');
	$template->addComponent(Component::get('CategoryMenu'),'leftnav');
	$template->addComponent(Component::get('ViewCartProcess'));
	$context->setTitle('View Cart');
