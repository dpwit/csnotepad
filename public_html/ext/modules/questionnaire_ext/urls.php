<?
	$urls = array(
		'questionnaire'=>array(
			'request-callback' =>'request-callback',
			'submit' =>'submit',
			"catchall"=>FEContext::forModel('Order','questionnaire')
		)
	);
	FEContext::addUrls($urls,dirname(__FILE__));
?>