<?
	$template->clearSection('main');
	$template->addComponent(Component::get('BasketSummary'),'main');
	$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
	
?>
