<?
	$template->setTemplate('template-shop');
	$template->clearSection('main');
	$template->addComponent(Component::get('RecoverPasswordProcess'));
?>
