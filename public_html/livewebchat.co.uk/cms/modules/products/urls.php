<?
	$shopItems = array('category','product','productvariation','manufacturer');
	$extraWhere = array('product'=>array('list_in_shop'=>true));
	$shopItems = cms_apply_filter('shop_item_types',$shopItems);
	foreach($shopItems as $type){
		$page = $type;
		if($type=='productcategory') $page = 'category';
		$items[] = FEContext::forModel(ucwords($type),$page,@$extraWhere[$type]);
	}
	$urls = array(
		"our-services"=>array(
			"base"=>"index",
			"search"=>"search",
			"catchall"=>new OneOfPage($items),
			"checkout"=>"checkout",
			"checkout.html"=>array(
				"catchall"=>"checkout",
			),
			"featured"=>array(
				"catchall"=>FEContext::forModel('FeaturedProducts','feature'),
			),
		),
		// Start - Checkout in 2 places, rather than moving it around.
		'shop' => array(
			"checkout"=>"checkout",
			"checkout.html"=>array(
				"catchall"=>"checkout",
			)
		)
		// End - Checkout in 2 places, rather than moving it around.
	);
	FEContext::addUrls($urls,dirname(__FILE__));
?>
