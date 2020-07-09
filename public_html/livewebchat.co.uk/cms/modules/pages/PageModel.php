<?
/**
* @package BozBoz_CMS
*/

	class Page Extends SortableModel {
		function __construct($obj=null,$table='pages'){
			parent::__construct($obj,$table);
			$this->dontReEdit=true;
			$this->hasOne('parent',array('model'=>'Page','field'=>'parentUid'));
		}
		function filter_fields_built($fields){
			foreach(array(
				'swf', 'short_text','parentUid','hasChildren',
				'asFunction','packages',
			) as $hideField) unset($fields[$hideField]);
			$fields['label'] = new Field('label',array('label'=>'Heading'));
			$fields['title'] = new Field('title',array('label'=>'HTML Title'));
			$fields['shortName'] = new Field('shortName',array('label'=>'Menu Title'));
			$fields['show_if']->setParam('default','Always');
			$fields['slug'] = new URLSlugField('slug');
			return $fields;
		}
		function getListingColumns(){
			$cols = parent::getListingColumns();
			unset($cols['ShortName']);
			$cols['Page'] = $this->getLabel();
			$cols['Visible'] = $this->status ? 
				"<img src='/cms/images/icons/tick_icon.png' alt='Yes'/>":"";
			$cols['In Menu'] = $this->show_in_menu ?
				"<img src='/cms/images/icons/tick_icon.png' alt='Yes'/>":"";
			$cols['Show'] = $this->show_if;
			return $cols;
		}
		function getAssignArray(){
			$fields = parent::getAssignArray();

			$titles = array('shortName','label','title');
			foreach($titles as $field){
				if($defTitle = $fields[$field]) break;
			}
			foreach($titles as $field){
				if(!$fields[$field]) $fields[$field]=$defTitle;
			}
			return $fields;
		}
		function getUrl(){
			$url = parent::getUrl();
			$url = preg_replace("/home$/",'',$url);
			return $url;
		}
		function getBySlug($url){
			if(!$url) $url='/home';
			return parent::getBySlug($url);
		}
		function getUrlField(){
			return 'slug';
		}
		function getLabelField(){
			return 'shortName';
		}
		function getDescription(){
			if(@$this->description) return $this->description;
			if(@$this->shortText) return $this->shortText;
			return truncate(strip_tags($this->text),300);
		}
		function hasContent(){
			return strip_tags(trim($this->text));
		}
		function getCmsActions(){
			$actions = parent::getCmsActions();
			$user = Model::loadModel('User')->getLoggedInUser();
			
			$hide = array('View Parent');
			if(!$user->isUnrestricted()){			
				$hide = array_merge($hide,array('Move Up','Move Down'));
			}
			foreach($actions as $k=>$v){
				if(in_array($v,$hide))unset($actions[$k]);
			}
			return $actions;
		}
		function getParent(){
			return $this->parent();
		}

		function getVisibleWhere(){
			static $where = array();
			if(!$where){
				$user = Model::loadModel("User")->getLoggedInUser();
				if($user) $where['show_if !='] = 'Not Logged In';
				else $where['show_if !='] = 'Logged In';
			}
			$where['status >']=0;
			return $where;
		}

		function getFEHeaders(){
			$headers = array();
			$headers['title']		= "<title>".htmlspecialchars(cms_apply_filter('title_tag',$this->title))."</title>";
			$headers['meta-description'] 	= 
				"<meta name='description' value=\"".htmlspecialchars(cms_apply_filter('meta_description',$this->getDescription()))."\"/>";
			if(@$this->keywords){
				$headers['meta-keywords'] 	= "<meta name='keywords' value=\"".htmlspecialchars(cms_apply_filter('meta_keywords',$this->keywords))."\"/>";
			}
			return $headers;
		}
	}
?>
