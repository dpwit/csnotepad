<?
include($context->findTemplate('pages/products/default'));
$context->setTitle($item->name);
if(Config::value('category_display_sub_categories')){
	$template->addComponent(Component::get('CombinedListing',$item,array('perPage'=>12)));
} else {
	$template->addComponent(Component::get('ProductBrowse',$item,array('perPage'=>12)));
}
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
