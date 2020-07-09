<?
	$user =Model::loadModel('User')->getLoggedInUser();

	if($user){
		include($context->findTemplate('pages/userManagement/dashboard-feuser'));
	} else {
		$template->setTemplate('template-shop');
		$template->clearSection('main');
		$template->addComponent(Component::get('QuickRegistration'));
	}
?>
