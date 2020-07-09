<?php
class product_browse_ext
{
	function __construct()
	{
			cms_listen_action('components_loaded',$this);
	}
	
	function components_loaded(){
		Component::mapClass('CategoryInfo',dirname(__FILE__).'/components/CategoryInfo.php');
	}
	
}
new product_browse_ext;