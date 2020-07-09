<?php

	class product_questionnaire
	{
		function __construct()
		{
			cms_listen_action('addToBasket',$this);
			cms_listen_action('models_loaded',$this,false,20);
			cms_listen_action('items_added',$this);
			cms_register_filter('fields_built_order_item',$this);
		}

		function fields_built_order_item($fields)
		{
			$fields['questionnaireData'] = new HiddenField('questionnaireData');
			return $fields;
		}
		
		function getQuestionairre(){
			$qf = Model::loadModel('QuestionnaireAnswers');
			if(!($q = $qf->getFirst())){
				$q = $qf->createNew();
				$q->writeToDB();
			}
			return $q;		
		}
		
		function addToBasket($basket,$product,$context,$extraUrl)
		{
			$this->getQuestionairre()->addToBasketWithQuestionnaire($product,$context,$extraUrl);
		}
		
		function models_loaded(){
			Model::addModel('QuestionnaireAnswers',dirname(__FILE__).'/class.QuestionnaireAnswers.php');
		}
		
		function items_added($order,$orderItem)
		{
			if($orderItem->ref_table!="products") return;
		
			$data = $this->getQuestionairre()->questions[$orderItem->ref_id];
			$orderItem->questionnaireData = json_encode($data);
			$orderItem->writeToDb();
		}
	}
	
	new product_questionnaire();