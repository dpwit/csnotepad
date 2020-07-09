<?
/**
* @package BozBoz_CMS
*/

	class Contact extends BozModel {
		var $requiresCaptcha = true;
		function overrideFields(){
			require_once(__MODELS_BASE__."/fields/CaptchaField.php");
			if($this->requiresCaptcha)
				$this->setField(new Captcha);
			$this->setField(new TextArea('comments'));
			$this->setField(new HiddenField('targetEmail',array('value'=>Config::value('admin-email','site'))));
			parent::overrideFields();
		}
		function getFields(){
			parent::getFields();
			$this->fields['comments']->addValidation(new RequiredValidation);
			$this->fields['email']->addValidation(new RequiredValidation);
			return $this->fields;
		}
		function getTextFields(){
			return array_merge(parent::getTextFields(),array("comments"));
		}
		function getListingColumns(){
			$data = parent::getListingColumns();
			$data['Message'] = substr($this->comments,0,200);
			return $data;
		}
		function getEnglishName($plural=true){
			return $plural ? "Messages" : "Message";
		}
		function getLabel(){
			return "$this->first_name $this->last_name";
		}
		function getLabelField(){
			return "last_name";
		}
		function getImageUrl(){
			return "/img/staff/$this->picture";
		}
		function afterWrite($old,$new){
			mail($this->targetEmail,"Message from $_SERVER[HTTP_HOST]",
				"From: $this->name $this->surname <$this->email>
Tel: $this->phone

$this->comments",
			"From: contact@$_SERVER[HTTP_HOST]\nBCC:webcontact@bozboz.co.uk");
		}
	}
