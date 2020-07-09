<?
	$user = Model::loadModel('User')->getLoggedInUser();
	//BreadCrumb::setBreadCrumb(new BreadCrumbItem("/change-password.html","Change Password",Model::loadModel('Page')->getFirst(array('title'=>'dashboard'))));
	BreadCrumb::setBreadCrumb(new BreadCrumbItem('change-password.html','Change Password'));
	$template->addComponent(Component::get('AccountMenu'),'leftnav');
	$template->clearSection('main');
	$template->addComponent(Component::get('Breadcrumb'),'content-header');
	$template->addComponent(Component::get('ChangePassword'));
	$context->setTitle('Change Password');
