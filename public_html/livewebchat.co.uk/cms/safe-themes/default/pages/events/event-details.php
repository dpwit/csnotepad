<?
	//Article Template
	$template->setTemplate('template-3cols-news');
	Breadcrumb::setBreadCrumb($item);

	$template->clearSection('main');
	$template->addComponent(Component::get('EventMenu',array('item'=>$item)),'leftnav');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	$template->addComponent(Component::get('EventDetail',$item),'col2');
	//$template->addComponent(Component::get('NewsImage',$item),'col3');
	$context->setTitle($item->title);
?>
 
