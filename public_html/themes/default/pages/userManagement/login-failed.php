<?
	$template->setTemplate('template-shop');
	$template->clearSection('main');
	$template->addComponent(Component::get('FileInclude','content/login_failed/'.$_GET['reason']));
	$template->addComponent(Component::get('LoginBox'));
?>
