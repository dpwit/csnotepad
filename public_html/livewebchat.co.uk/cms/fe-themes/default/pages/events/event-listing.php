<?
	//Article Template
	$template->setTemplate('template-2cols-events');
	Breadcrumb::setBreadCrumb(Model::g('page',array('title'=>'Events')));

	$template->clearSection('main');
	$template->addComponent(Component::get('EventMenu',array('item'=>$item)),'leftnav');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	$template->addComponent(Component::get('FileInclude','modules/events/event-listing',array('item'=>$article)),'col2');
	//$template->addComponent(Component::get('NewsImage',$item),'col3');
	$context->setTitle('Events');
?>
 



