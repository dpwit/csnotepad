<?php

class NewsHome extends Component
{
 
	private $limit;
	private $archiveLink;

	function __construct($limit,$archiveLink){
		$this->limit = $limit;
		$this->archiveLink = $archiveLink;
	}
	function doHTML($context){
		$context->showTemplate('modules/skint_temp/news-home.php',array('limit'=>$this->limit,'archiveLink'=>$this->archiveLink));
	}
}
?>



