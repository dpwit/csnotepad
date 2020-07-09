<?
include($context->findTemplate('pages/products/default'));
BreadCrumb::setBreadCrumb(Model::g('Page',array('title'=>'Shop')));
$template->addComponent($browse = Component::get('ProductBrowse',Model::loadModel('Product'),array('perPage'=>Config::value('per_page','products'),'listFunc'=>'getAll','where'=>array('abstract'=>0))));
BreadCrumb::push($_SERVER['REQUEST_URI'],'Search For '.$browse->describeSearch());
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');

$context->setTitle('Shop');
?>
