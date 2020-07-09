<?
	//Article Template
	$template->setTemplate('template-3cols-news');
	Breadcrumb::setBreadCrumb(Model::loadModel('page')->getFirst(array('slug'=>'competitions')));

	$template->clearSection('main');
	$template->addComponent(Component::get('CompetitionMenu',array('item'=>$item)),'leftnav');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	$template->addComponent(Component::get('CompetitionListing',$item),'col2');
	//$template->addComponent(Component::get('NewsImage',$item),'col3');
?>
 
