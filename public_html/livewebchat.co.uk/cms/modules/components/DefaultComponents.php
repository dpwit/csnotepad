<?
/**
* @package Elite_Promo
*/

	require_once(dirname(__FILE__).'/Component.php');
	class Menu extends Component {
		var $template_file = null;
		function __construct($list=array(),$params=array()){
			if(is_string($params)) $params = array('template_file'=>$params);
			$defaults = array('urlFunc'=>'getUrl','hideOnEmpty'=>true);
			$params = array_merge($defaults,$params);
			parent::__construct("menu",$params);
			$this->list = $list;
			$this->template_file = @$params['template_file'];
		}
		function isVisible(){
			$vis = parent::isVisible();
			if($this->params['hideOnEmpty']){
				$vis = $vis && (count($this->getItems())>0);
			}
			return $vis;
		}
		function getItems(){
			return $this->list;
		}
		function doHtml($context){
			$list = $this->getItems();
			if(!$this->template_file) $this->template_file='structure/menu';
			$this->view($context,$this->template_file,array('list'=>$list,'params'=>$this->params));
		}
	}
	class BreadCrumb extends Menu {
		function __construct($params=array()){
			$defaults = array(
				"template_file"=>"structure/breadcrumb",
				"separator"=>" &raquo; ",
				'hideOnEmpty'=>false,
			);
			$params = array_merge($defaults,$params);
			parent::__construct(null,$params);
		}
		static $base=array(), $rendered = null;
		function getItems(){
			if(!self::$rendered){
				$item = self::$base;

				if(is_object($item)){
					$list = array($item);
					while ($item = $item->getParent()){
						$list[] = $item;
					}
				} else {
					$list = $item;
				}
				if(is_array($list))
				foreach($list as $k=>$v){
					if(is_string($v)){
						$list[$k] = new BreadCrumbItem($k,$v);
					}
				}
				self::$rendered = @array_reverse($list);
			}
			return self::$rendered;
		}

		static function setBreadcrumb($item){
			self::$base = $item;
			self::$rendered = null;
		}

		static function clear(){
			self::$base = false;	
		}
		static function push($url,$name){
			self::set($url,$name,self::$base);
		}
		static function set($url,$name,$parent=null){
			self::setBreadCrumb(new BreadCrumbItem($url,$name,$parent));
			self::$rendered = null;
		}

		static function stripSlash($url){
			if(@$url[0]=='/') $url = substr($url,1);
			return $url;
		}
		static function selected($url){
			$url = self::stripSlash($url);
			$items = self::getitems();
			if(is_array($items))
			foreach($items as $k=>$v){
				if(self::stripSlash($v->getUrl())==$url){
					return true;
				}
			}
			return false;
		}
		static function selectedExactly($url){
			$items = self::getitems();
			$item = array_pop($items);
			if($item->getUrl()==$url){
				return true;
			}
			return false;
		}

	}
	class BreadCrumbItem extends Model {
		function __construct($url,$name,$parent=null){
			parent::__construct(null);
			$this->name=$name;
			$this->url = $url;
			if(is_string($parent)) $parent = Model::loadModel('Page')->getFirst(array('shortName'=>$parent));
			$this->parent = $parent;
		}
		function getParent(){
			return $this->parent;
		}
		function getUrl(){
			return $this->url;
		}
	}
	class PageMenu extends Menu {
		function __construct($params=array()){
			parent::__construct(array(),def(array('show_in_menu'=>0),$params));
		}
		function getItems(){
			$restrict = array();
			if(!@$this->params['show_all']) $restrict['show_in_menu']=1;
			$restrict['visible']=1;
			return Model::loadModel('Page')->getVisible($restrict);
		}
	}

	class TextComponent extends Component {
		function __construct($text){
			$this->text=$text;
		}
		function doHTML(){
			echo $this->text;
		}
	}

	class FileInclude extends Component {
		function __construct($file,$params = array()){
			$this->file = $file;
			$this->params = $params;
		}
		function debugInfo($extraParams=array()){
			$extraParams['include_file'] = $this->file;
			return parent::debugInfo($extraParams);
		}

		function doHTML($context){
			if(!file_exists($this->file)) $this->file = $context->findTemplate($this->file);
			extract($this->params);
			include($this->file);
		}
	}
	class PageComponent extends FileInclude  {
		function __construct($page){
			if(is_string($page)){
				$page = Model::loadModel('Page')->getBySlug("/$page");
			}
			parent::__construct("modules/pages/page",array('page'=>$page));
			$this->page = $page;
	//		$this->params['page'] = $page;
		}

		function getHeaders(){
			return array('title'=>"<title>".$this->page->title."</title>");
		}
	}
	
	class AlternateContent extends CompositeComponent {
		function __construct($items=array()){
			parent::__construct();
			foreach($items as $item) $this->addComponent($item);
		}


		function isVisible(){
			foreach($this->components as $i) if($i->isVisible()) return parent::isVisible();
			return false;
		}

		function doHTML($context){
			foreach($this->components as $i) if($i->isVisible()) return $i->doHTML($context);
			return false;
		}
	}

	class PageTemplateComponent extends TemplateComponent {
		function getHeaders(){
			$headers = parent::getHeaders();
			foreach(BreadCrumb::getItems() as $item){
				if(method_exists($item,'getFEHeaders'))
					$headers = array_merge($headers,$item->getFEHeaders());
			}
			return $headers;
		}
	}
?>
