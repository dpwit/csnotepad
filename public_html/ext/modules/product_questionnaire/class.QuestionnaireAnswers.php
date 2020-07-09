<?php
	class QuestionnaireAnswers extends BozModel
	{
		function __construct($obj=null){
			$this->engine = SessionEngine::getInstance();
			$this->hasRelationship('products',array(
				'manager'=>__MODELS_BASE__.'/relationships/class.MMCommaSeparated.php:MMCommaSeparated'
			));
			parent::__construct($obj,'questionnaireAnswers');
		}
		
		function getFields(){
			require_once(__MODELS_BASE__.'/fields.php');
			$this->fields = array(
				'questions'=>new Field('questions')
			);
			return $this->fields;
		}
		
		function addToBasketWithQuestionnaire($productId,$context,$extraUrl){
			$this->questions[$productId] = ($_POST['questions']);//json_encode($_POST['questions']);
			$this->writeToDB();
			
			//var _dump($productId,$_POST['questions']);
			//die('Adding To Basket');
		}
	}