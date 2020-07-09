<?
	$template->setTemplate('template-shop');
	$template->clearSection('left');
	$template->addComponent(Component::get('AccountMenu'),'leftnav');
	$template->clearSection('main');
	$template->addComponent(Component::get('RecoverPasswordProcess'));
?>
