<?
	//Article Template
	Breadcrumb::setBreadCrumb($item);
	$template->setTemplate('template-3cols-news');
	$template->clearSection('main');
	$template->addComponent(Component::get('FileInclude','modules/infoPages/infoPage-menu.php',array('offset'=>0)),'col1');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	//$template->addComponent(Component::get('NewsArticle',$item),'col2');
	//$template->addComponent(Component::get('NewsImage',$item),'col3');
	$template->addComponent(Component::get('FileInclude','modules/infoPages/infoPage-detail.php',array('offset'=>0)),'col2');
	//$template->addComponent(Component::get('FileInclude','modules/infoPages/infoPage-menu.php',array('offset'=>0)),'col3');
	$context->setTitle($item->title);

?>
