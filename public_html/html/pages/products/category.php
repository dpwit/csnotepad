<?
include($context->findTemplate('pages/products/default'));
$template->setTemplate('template-category');
$page_title = $item->html_title? $item->html_title : $item->name;
$context->setTitle($page_title);
$context->setDescription($item->metaDescription);
if(Config::value('category_display_sub_categories')){
	$template->addComponent(Component::get('CombinedListing', $item, array('perPage'=>Config::value('per_page','products'))));
} else {
	$template->addComponent(Component::get('ProductBrowse', $item, array('perPage'=>Config::value('per_page','products'))), 'above-main');
}
$template->addComponent(Component::get('CategoryInfo', $item));
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
