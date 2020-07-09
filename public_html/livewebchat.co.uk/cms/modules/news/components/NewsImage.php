<?
	class NewsImage extends Component
	{
	
		private $article;
	
		function __construct($article){
			$this->article = $article;
		}
		function doHTML($context){
			$context->showTemplate('modules/news/news-image.php',array('article'=>$this->article));
		}
	}
?>