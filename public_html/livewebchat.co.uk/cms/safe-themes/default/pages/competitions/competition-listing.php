<?
	//Article Templateasdasdasd
	Breadcrumb::setBreadCrumb(Model::g('Page',array('title'=>'Competitions')));
	$template->setTemplate('template-3cols-news');
	$template->clearSection('main');
	
	$article = Model::loadModel('news')->getFirst(array(),array('order' => 'cdate desc'));
	
	$template->addComponent(Component::get('FileInclude','modules/news/homepage-listing',array('offset'=>0)),'col1');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	
	$template->addComponent(Component::get('NewsArticle',$article),'col2');
	$template->addComponent(Component::get('NewsImage',$article),'col3');


?>
