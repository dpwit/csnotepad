<?php

$template->setTemplate('template-question');
$context->setTitle('Form Submitted');

$template->addComponent(Component::get('FileInclude','modules/questionnaire_ext/submit.php'),'main');