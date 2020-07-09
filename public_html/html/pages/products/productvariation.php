<?
include($context->findTemplate('pages/products/default'));
	$context->setTitle($item->name);
	$template->addComponent(Component::get('ProductVariationDetail',$item),'main');
?>
