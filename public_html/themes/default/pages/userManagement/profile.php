<?
	$user = Model::loadModel('User')->getLoggedInUser();
	BreadCrumb::setBreadCrumb(new BreadCrumbItem("/profile.html","Personal Details"));
	$template->addComponent(Component::get('Breadcrumb'),'content-header');
	$template->addComponent(Component::get('AccountMenu'),'leftnav');
	$template->clearSection('main');
	$template->addComponent(Component::get('EditProfile'));
	$context->setTitle('User details');
