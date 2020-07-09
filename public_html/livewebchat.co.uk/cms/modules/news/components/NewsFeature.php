<?
	class NewsFeature extends Component
	{
	
		private $artist_uid;
	
		function __construct($artist_uid){
			$this->artist_uid = $artist_uid;
		}
		function doHTML($context){
			$context->showTemplate('modules/news/news-feature.php',array());
		}
	}
?>