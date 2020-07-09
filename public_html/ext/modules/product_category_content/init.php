<?php	
class product_category_content	
{		
	function __construct()
	{			
		cms_register_filter('fields_built_productcategory',$this);
	}
	function fields_built_productcategory($fields)
	{	
		$fields['alternativeHeading'] = new Field('alternativeHeading');
		$fields['metaDescription'] = new Field('metaDescription');
		$fields['content'] = new FckeditorField('content');
		$fields['html_title'] = new Field('html_title');
		$fields['featured'] = new CheckBoxField('featured');
		$fields['html_title']->setParam('label', 'HTML Title');
		return $fields;	
	}	
}

new product_category_content();