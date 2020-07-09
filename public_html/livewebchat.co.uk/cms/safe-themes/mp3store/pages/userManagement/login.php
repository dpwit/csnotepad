<?
	$user =Model::loadModel('User')->getLoggedInUser();
	BreadCrumb::setBreadCrumb(new BreadCrumbItem('login.html','Login'));//,Model::loadModel('Page')->getFirst(array('shortName'=>'Shop'))));
	if($user){
		include($context->findTemplate('pages/userManagement/dashboard-feuser'));
	} else {
		$template->setTemplate('template-shop');
		$template->addComponent(Component::get('CategoryMenu'),'leftnav');
		$template->clearSection('main');
		$template->addComponent(Component::get('BreadCrumb'),'content-header');
		$template->addComponent(Component::get('QuickRegistration'));
	}
?>
