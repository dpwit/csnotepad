<?
	class CategoryInfo extends Component {
		
		private $category;
		
		function __construct($category){
			$this->category = $category;
		}
		
		function doHTML($context) {
			$context->showTemplate('modules/products/category-info.php', array('item'=>$this->category));
		}

	}
?>