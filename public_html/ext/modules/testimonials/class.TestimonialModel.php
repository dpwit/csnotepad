<?php	
class TestimonialModel extends BozModel {
	function __construct($obj=null){
		parent::__construct($obj,'testimonials');
	}
	function getLabelField(){
		return "url";
	}
	
		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
		$fields['comment1']= new TextArea('comment1');
		$fields['comment2']= new TextArea('comment2');
		return $fields;
	}
}