<?
include($context->findTemplate('pages/products/default'));
	$context->setTitle($item->name);
	$template->addComponent(Component::get('ProductDetail',$item),'main');
?>
