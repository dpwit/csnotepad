<?php
//if(!class_exists('AutoTextArea'))
//class AutoTextArea extends TextArea
//{

//}

class extra_checkout_fields
{
	function __construct()
	{
		cms_listen_action('models_loaded',$this,false,10000);
	}
	function models_loaded(){
		//if(self::isCMSLoggedIn()){
		//if(false){
			cms_register_filter('checkout_fields',$this);
			cms_register_filter('checkout_fields_process',$this);
			cms_register_filter('checkout_field_sections',$this);
			cms_register_filter('checkout_field_details',$this);
			cms_register_filter('checkout_field_addressdetailsscreen',$this);
			cms_register_filter('fields_built_order',$this);	
		//}
	}
	
	
	private static $hasChecked=false;
	private static $isCMSLoggedIn = false;
	
	static function isCMSLoggedIn()
	{
		if(!self::$hasChecked){
		
			Model::loadModel('User');
		
			$initVal = FEUser::$fe;
			
			FEUser::$fe=false;
			
			self::$isCMSLoggedIn = Model::loadModel('User')->getLoggedInUser();
			self::$hasChecked = true;
			
			FEUser::$fe=$initVal;
			
		}
		return self::$isCMSLoggedIn;
	}	
	
	function fields_built_order($fields)
	{
		$fields['company_address'] = new TextArea('company_address');
		return $fields;
	}
	
	function checkout_field_addressdetailsscreen($fields,$type)
	{
		if($type=="card")
			return $this->checkout_fields($fields,$type);
		return $fields;
	}
	
	function checkout_fields($fields,$type="customer")
	{
		if(is_array($type))
			$type="customer";
		if(is_object($type))
			$type="customer";
		
		include_once dirname(__FILE__).'/fields/field.AutoAddressField.php';
		$fields[] = new TextField('company_position',array('label'=>'Your role','required'=>true));
		$fields[] = new TextField('refered_from',array('label'=>'Where did you hear about us','required'=>true));
		$fields[] = new TextField('company_name',array('label'=>'Company Name','required'=>true));
		$fields[] = new TextField('company_activity',array('label'=>'Company Activity','required'=>true));
		$fields[] = new AutoAddressField('company_address',array('label'=>'Company Address ','required'=>true, 'field_prefix' => $type));
		$fields[] = new TextField('company_phone',array('label'=>'Company phone number','required'=>true));
		$fields[] = new DropDownField('prefered_contact',array('label'=>'Prefered Contact Method','required'=>true,'options'=>array('Phone'=>'Phone','Email'=>'Email')));

		return $fields; 
	}
	
	function checkout_field_details($fields)
	{
		$index_of_lastname = array_search('customer_lastname',$fields)+1;
		$index_of_phone = array_search('customer_phone',$fields)+1;
		
		array_splice($fields,$index_of_lastname,0,array('company_position'));
		array_splice($fields,$index_of_phone,0,array('refered_from'));
		//$fields[] = 'prefered_contact';
		
		return $fields;
	}
	
	function checkout_field_sections($sections)
	{
		$sections['Personal Information'] = $sections['Personal Info'];
		unset($sections['Personal Info']);
		$sections = array_reverse($sections);
		
		$sections['Company Information'] = array('company_name',"company_activity",'company_address','company_phone');
		$sections[''] = array('prefered_contact');
		
		return $sections;
	}
}

new extra_checkout_fields;