<?php
class page_ext {
	function __construct(){
		//cms_register_filter('fields_built_product',$this);
		cms_register_filter('config_defaults',$this);
		cms_register_filter('fields_built_product_attribute_option',$this);	
		cms_register_filter('fields_built_product_attribute',$this);	
		cms_register_filter('fields_built_user',$this);	
		cms_register_filter('fields_built_page',$this);
		cms_register_filter('composition_form_view_product_attribute',$this);
		cms_register_filter('view_dirs_productcategory',$this);
		cms_register_filter('view_dirs_product',$this);
		cms_register_filter('cms_menu',$this,false,100);
		//cms_listen_action('model_instantiated_productcategory',$this);
		cms_register_filter('image_sizes_productcategory',$this);
	}
	function image_sizes_productcategory($sizes,$modelImage){
		$sizes['csnotepadCategoryImage']=array('width'=>232,'height'=>128, 'resizer'=>'ImageResizerCropSquare');
		return $sizes;
	}	
	function fields_built_user($fields)
	{
		try{
			$usr = Model::loadModel('User')->getLoggedInUser();
			if(
				$usr && 
				
				$usr->usergroup()->uid==1
			)
				return $fields;
		}
		catch(Exception $ex){}
		$fields['usergroup_uid'] = new HiddenField('usergroup_uid');
		$fields['usergroup_uid']->setParam('default',4);
		return $fields;
	}
	function model_instantiated_productcategory($modelImage){
		$modelImage->hasFile('image',array('file_type'=>'img',
			'extraSizes'=>array(
				'home'=>array( 'width'=>$size,'height'=>$size, 'resizer'=>'ImageResizerFitAndPad' ,),
				'detail'=>array( 'width'=>200, 'height'=>235,'resizer'=>'ImageResizerFitAndPad' ,),
				'list'=>array( 'width'=>168,'resizer'=>'ImageResizerCropSquare' ,),
				'icon'=>array( 'width'=>50,'height'=>50, 'resizer'=>'ImageResizerCropSquare' ,),

				'prodThumbHome'=>array('width'=>90,'height'=>90, 'resizer'=>'ImageResizerFitInBounds'),
				'prodThumb'=>array('width'=>110,'height'=>110, 'resizer'=>'ImageResizerFitInBounds'),
				'prodDetail'=>array('width'=>400,'height'=>400, 'resizer'=>'ImageResizerFitInBounds'),
				'csnotepadCategoryImage'=>array('width'=>232,'height'=>128, 'resizer'=>'ImageResizerCropSquare'),
			)
		));
		//return $modelImage;
	}	

	function cms_menu($array)
	{	
		//var_dump($array['Orders']);
		//unset($array['Orders']['Order States']);
		//unset($array['Orders']['Add Order State']);
		//unset($array['Shop Config']);
		//unset($array['Config']);
		//unset($array['Customer']['Permissions']);
		//unset($array['Customer']['Add Permission']);
		//$array['Shop Config']['New Property Value'];
		return $array;
	}
	function roduct($fields){
		$fields['shortdesc'] = new TextArea('shortdesc');
		$fields['details'] = new TextArea('details');
		return $fields;
	}
	function view_dirs_productcategory($dirs)
	{
		array_unshift(
			$dirs,
			dirname(__FILE__).'/views/productcategory'
		); 
		
		return $dirs;
	}
	
	function view_dirs_product($dirs)
	{
	
		$newDir = dirname(__FILE__).'/views/productmodel';
	
		if(in_array($newDir,$dirs))
			return $dirs;
			
		array_unshift(
			$dirs,
			$newDir
		); 
		
		/*
		foreach($dirs as $dir)
			var_dump($dir,is_dir($dir),'<br>');
		?><hr><?php
		/**/
		
		return $dirs;
	}
	function fields_built_product_attribute($fields){
		//$fields['product_attribute_options']->setParam
		return $fields;
	}
	function fields_built_Product_Attribute_option($fields){
		$fields['info'] = new Field('info');
		return $fields;
	} 
	function composition_form_view_product_attribute($attribute,$view,$relationship){
		switch($relationship){
			case 'options':
				return 'form';
		}
		return $view;
	}
	function config_defaults($confArr)
	{
		$confArr['orders']['display_ex_vat'] = true;
		return $confArr;
	}
	
	function fields_built_page($fields)
	{	
		$fields['metaDescription'] = new Field('metaDescription');
		return $fields;	
	}
}

new page_ext();