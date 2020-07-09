<?
	//Article Template

	$template->clearSection('main');
	$template->addComponent(Component::get('FileInclude','modules/news/homepage-listing',array('offset'=>0)),'left');
	$template->addComponent(Component::get('NewsArticle',$item));
?>
