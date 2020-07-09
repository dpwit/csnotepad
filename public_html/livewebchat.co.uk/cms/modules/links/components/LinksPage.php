<?
	class LinksPage extends FileInclude {
		function __construct($template=false,$params=array()){
			if(!$template) $template = 'modules/links/page';
			parent::__construct($template,$params);
		}
	}
?>
