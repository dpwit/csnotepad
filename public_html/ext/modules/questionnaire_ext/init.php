<?php
class questionnaire_ext
{
	function __construct(){
		cms_listen_action('components_loaded',$this);
	}
	
	function components_loaded()
	{
		Component::mapClass('QuestionnaireComponent',dirname(__FILE__).'/components/QuestionnaireComponent.php');
	}
}

new questionnaire_ext;