<?
	//Article Template
	Breadcrumb::setBreadCrumb(Model::g('Page',array('title'=>'News')));
	$template->setTemplate('template-3cols-news');
	$template->clearSection('main');
	
	$where = array();
	$article = Model::loadModel('news')->getFirst($where,array('order' => 'sorting asc'));
	
	$template->addComponent(Component::get('FileInclude','modules/news/homepage-listing',array('offset'=>0)),'col1');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	
	$template->addComponent(Component::get('NewsArticle',$article),'col2');
	$template->addComponent(Component::get('NewsImage',$article),'col3');
	$context->setTitle('News');
?>
