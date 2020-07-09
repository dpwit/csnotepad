<?
	BreadCrumb::setBreadcrumb($item);
	$template->clearSection('main');
	$file = $item->urlEncode($item->shortName);
	$abs=false;
	try {
		$abs = $context->findTemplate('content/'.$file);
	} catch(Exception $e){}
	if(file_exists($abs)){
		$context->setTitle($item->title);
		$template->addComponent(new FileInclude($abs,array('item'=>$item)),'main');
	} 
	
	if($item->text){
		$template->addComponent(new PageComponent($item),'col1');
	}
	try {
		$abs = $context->findTemplate('pages/'.$file);
		if(file_exists($abs))
			include($abs);
	} catch(Exception $e){
	}
?>
