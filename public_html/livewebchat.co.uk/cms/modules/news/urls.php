<?
	$urls = array(
		"news"=>array(
			"base"=>"news",
			"catchall"=>FEContext::forModel('News','news-detail')
		)
	);
	FEContext::addUrls($urls,dirname(__FILE__));
?>
