<?
	BreadCrumb::setBreadcrumb($item);
	$template->clearSection('main');
	$file = $item->urlEncode($item->shortName);
	$context->setDescription($item->metaDescription);
	$abs=false;
	try {
		$abs = $context->findTemplate('content/'.$file);
	} catch(Exception $e){}
	$context->setTitle($item->title);
	if(file_exists($abs)){
		$template->addComponent(new FileInclude($abs,array('item'=>$item)),'main');
	}

	elseif($item->text){
		$template->addComponent(new PageComponent($item),'main');
	}
	try {
		$abs = $context->findTemplate('pages/'.$file);
		if(file_exists($abs))
			include($abs);
	} catch(Exception $e){
	}
?>
