<?php

class QuestionnaireComponent extends FileInclude {
	function __construct($item) {
		$basket = Model::loadModel('Basket')->getFirst();
		parent::__construct('modules/questionnaire_ext/questionnaire.php', array('order'=>$item));
	}
}

?>