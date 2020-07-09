<?
	$template->setTemplate('template-shop');
	BreadCrumb::setBreadCrumb(Model::loadModel('Page')->getFirst(array('title'=>'register')));
	$template->clearSection('main');
	$template->addComponent(Component::get('PageComponent','register'));
	$template->addComponent(Component::get('Registration'),'main');
	return true;
?>
