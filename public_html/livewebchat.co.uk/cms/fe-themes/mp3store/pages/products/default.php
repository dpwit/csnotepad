<?
	$template->setTemplate('template-shop');
	$template->clearSection('main');
	$template->addComponent(Component::get('CategoryMenu'),'leftnav');
	$template->addComponent(Component::get('BreadCrumb'),'content-header');
?>
