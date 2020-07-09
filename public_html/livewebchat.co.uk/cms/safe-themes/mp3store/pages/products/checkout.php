<?
include(dirname(__FILE__)."/default.php");
	BreadCrumb::setBreadCrumb(new BreadCrumbItem('/shop/checkout.html','Checkout',Model::loadModel('Page')->getFirst(array('shortName'=>@$parent))));
	$template->clearSection('left');
	$template->addComponent(Component::get('AccountMenu'),'leftnav');
	$template->addComponent(Component::get('CheckoutProcess',$trailing));
	$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
	$context->setTitle('Checkout');
