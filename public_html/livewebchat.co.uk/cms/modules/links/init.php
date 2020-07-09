<?
	class LinksHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this);
			cms_listen_action('components_loaded',$this);
			cms_register_filter('cms_menu',$this);
			cms_register_filter('cms_section_name',$this);
		}

		function models_loaded(){
			Model::addModel('Link',dirname(__FILE__).'/LinkModel.php','LinkModel');
			Model::addModel('LinkCategory',dirname(__FILE__).'/LinkCategoryModel.php','LinkCategoryModel');
			Model::addModel('Link_Category',dirname(__FILE__).'/LinkCategoryModel.php','LinkCategoryModel');
		}
		function cms_menu($menu){
			$menu['Links'] = array(
				'View Links'=>'overview.php?pageType=links',
				'Add Link'=>'newItem.php?pageType=links&category='.@$_GET['rel_link_category'],
				'View Categories'=>'overview.php?pageType=link_categories',
				'New Category'=>'newItem.php?pageType=link_categories',
			);
			return $menu;
		}
		function cms_section_name($curr){
			if(@$_GET['pageType']=='link_categories') return 'Links';
			return $curr;
		}

		function components_loaded(){
			Component::mapClass('LinksPage',dirname(__FILE__).'/components/LinksPage.php');
		}
	}
	new LinksHooks;
?>
