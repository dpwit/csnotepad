<?
	class NewsArticle extends FileInclude {
		function __construct($article){
			parent::__construct('modules/news/article',array('article'=>$article));
		}
	}
?>
