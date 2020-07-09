<?php
	class flames_feature_categories{
		function __construct(){
			cms_listen_action('model_instantiated_feature',$this);	
			cms_listen_action('model_instantiated_productcategory',$this);	
		}	
		function model_instantiated_feature($feature){
			$feature->hasMM('categories',array(				
				'table'=>'featured_categories',
				'foreign_id'=>'category_uid',
				'composition'=>true,				
				'input'=>__MODELS_BASE__.'/fields/MMSortedSelector.php:MMSortedSelector',
				'back'=>'features'
			));
		}	
		function model_instantiated_productcategory($category){
			$category->hasMM('features',array(
				'table'=>'featured_categories',
				'local_id'=>'category_uid'
			));
		}
	}
	new flames_feature_categories;