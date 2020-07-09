<?
	//Article Template
	Breadcrumb::setBreadCrumb(Model::g('Page',array('title'=>'Info')));
	$template->setTemplate('template-3cols-news');
	$template->clearSection('main');
	
	$where = array();

	$article = Model::loadModel('InfoPage')->getFirst($where,array('order' => 'sorting asc'));
	
	$template->addComponent(Component::get('FileInclude','modules/infoPages/infoPage-menu.php',array('offset'=>0)),'col1');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	
	//$template->addComponent(Component::get('NewsArticle',$article),'col2');
	//$template->addComponent(Component::get('NewsImage',$article),'col3');
	$template->addComponent(Component::get('FileInclude','modules/infoPages/infoPage.php',array('offset'=>0)),'col2');
	$context->setTitle('News');
?>
