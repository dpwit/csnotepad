<?php

class signup extends Component
{

	private $youtube_videoCode;

	function __construct($youtube_videoCode){
		$this->youtube_videoCode = $youtube_videoCode;
	}
	function doHTML($context){
		$context->showTemplate('modules/skint_temp/news1.php',array());
	}
}
?>



