<?
	$template->clearSection('col1');
	$template->addComponent(Component::get('BreadCrumb'),'col1');
	$template->addComponent(Component::get('PageComponent','links'),'col1');
	$template->clearSection('main');
	$template->addComponent(Component::get('LinksPage'));
?>
