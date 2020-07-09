<?php

$template->setTemplate('template-question');
$context->setTitle('Questionnaire');
$template->addComponent(Component::get('QuestionnaireComponent',$item),'main');