<?
	$template->setTemplate('template-2cols-artists');
	Breadcrumb::setBreadCrumb(Model::g('Page',array('title'=>'Artists')));

	$template->addComponent(Component::get('ArtistMenu'),'leftnav');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
		
	$template->addComponent(Component::get('ArtistList'),'col2');
	$context->setTitle('Artists');
?>
