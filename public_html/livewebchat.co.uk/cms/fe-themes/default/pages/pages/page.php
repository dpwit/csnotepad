<?
	BreadCrumb::setBreadcrumb($item);
	$template->clearSection('main');
	$file = $item->urlEncode($item->shortName);
	$abs=false;
	try {
		$abs = $template->findTemplate('content/'.$file);
	} catch(Exception $e){}
	if(file_exists($abs)){
		$template->addComponent(new FileInclude($abs),'main');
	} 
	
	if($item->text){
		$template->addComponent(new PageComponent($item),'col1');
	}
	try {
		$abs = $template->findTemplate('pages/'.$file);
		if(is_file($abs))
			include($abs);
	} catch(NoSuchTemplateException $e){
	}
	
/*	cms_listen_hook('fe_template_head',function(){
?>
	<script> alert(" this is a page based on a db page");</script>
<?
	});*/
?>
