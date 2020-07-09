<?php

	class CategoryRelatedCategoryHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this,false,10);
			cms_listen_action('model_instantiated_productcategory',$this); 
		}
		function model_instantiated_productcategory($productcategory)
		{	
			$productcategory->hasMany('CategoryRelatedCategory',array('composition'=>true,'ref_field'=>'category_uid','quick-ui'=>true,/*'back'=>'related_by'*/));
			//$productcategory->hasMany('related_by',array('model'=>'CategoryRelatedCategory','ref_field'=>'related_uid','back'=>'CategoryRelatedCategory'));
		}	
		
		function models_loaded(){
			Model::addModel('CategoryRelatedCategory',dirname(__FILE__).'/class.CategoryRelatedCategory.php','CategoryRelatedCategory');
		}
	}
		
	new CategoryRelatedCategoryHooks;

?>