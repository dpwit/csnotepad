<?
	$shopItems = array('category','product','manufacturer');
	$extraWhere = array('product'=>array('list_in_shop'=>true));
	$shopItems = cms_apply_filter('shop_item_types',$shopItems);
	foreach($shopItems as $type){
		$page = $type;
		if($type=='productcategory') $page = 'category';
		$items[] = FEContext::forModel(ucwords($type),$page,@$extraWhere[$type]);
	}
	$urls = array(
		"shop"=>array(
			"base"=>"index",
			"search"=>"search",
			"catchall"=>new OneOfPage($items),
			"checkout"=>"checkout",
			"checkout.html"=>array(
				"catchall"=>"checkout",
			),
		),
	);
	FEContext::addUrls($urls,dirname(__FILE__));
?>
