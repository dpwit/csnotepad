<?
	//Article Template
	$template->setTemplate('template-3cols-news');
	$template->clearSection('main');
	$template->addComponent(Component::get('FileInclude','modules/news/homepage-listing',array('offset'=>0)),'col1');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	$template->addComponent(Component::get('NewsArticle',$item),'col2');
	$template->addComponent(Component::get('NewsImage',$item),'col3');
	$context->setTitle($item->title);

?>
