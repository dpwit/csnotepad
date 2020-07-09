<?
	cms_module_require('components','Table.php');
	//require_once("/cms/modules/components/Table.php");
	class NewsListing extends PaginatedTable {
		function __construct($params=array()){
			if(!is_array($params)) $params=array();
			$defaults = array(
				'model'=>Model::loadModel('News'),
				'perPage'=>1,
				'where'=>cms_apply_filter('news_restrict', array())
				//'listing'=>'module/news/listing'
			);
			$params = array_merge($defaults,$params);
			parent::__construct($params);
		}
		
	}
?>