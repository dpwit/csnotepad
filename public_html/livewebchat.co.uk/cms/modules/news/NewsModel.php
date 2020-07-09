<?
/**
* @package BozBoz_CMS
*/

	class News extends SortableModel {
		function __construct($obj=null){
			parent::__construct($obj,'news');
			$this->dontReEdit = true;
			$size = Config::value('news-homepage-width','site');
			$this->hasFile('image',array('file_type'=>'img','default'=>'jpg',
				'extraSizes'=>array(
					'home'=>array('width'=>$size,'height'=>$size, 'resizer'=>'ImageResizerFitInBounds'),

					'photo'=>array('width'=>350, 'resizer'=>'ImageResizerFitInBounds'),
					'photoThumb'=>array('width'=>65,'height'=>65, 'resizer'=>'ImageResizerFitInBounds'),
				)
			));
		}
		function getEnglishName($plural=true){
			return "Article".($plural?'s':'');
		}
		function getLabelField(){
			return 'title';
		}

		function getUrlPrefix(){
			return "newsItem/";
		}
		function on_before_write(){
			if(!$this->slug) $this->slug = $this->urlEncode($this->title);
		}

		function getParent(){
			return Model::g('Page',array('title'=>'News'));
		}

		function getImageUrl($size=''){
			$image = $this->image;
			if(!$this->hasImage())$image = 'default.jpg';
			return 'images/news/'.$size.'/'.$image; 
		}
		function getVisible($where=array(),$params=array()){
			$where['status']=1;
			return $this->getAll($where,$params);
		}

		function getDescription(){
			return $this->shorttext;
		}
		
		function miniShorttext($limit=50)
		{
			return substr(strip_tags($this->shorttext),0,$limit);
		}
		
		function miniTitle($limit=40)
		{
			return substr($this->title,0,$limit);
		}

		function getFields(){
			parent::getFields();
			//$this->fields['slug']->setParam('label','Append URL');
			$this->fields['slug']->setParam('label','SEO Friendly URL');
			$this->fields['shorttext']->setParam('label','Intro Text');
			unset($this->fields['date']);
			$this->fields['keywords'] = new TextArea('keywords',array('label'=>'Keywords','notes'=>'Please seperate your keywords or phrases with a comma and a space'));
			if($this->fields['cdate'])
			$this->fields['cdate']->setParam('hidden',true);
			return $this->fields;
		}
		function getSlug(){
			return $this->slug;
		}
		function getBySlug($url){
			if($url[0]=='/') $url = substr($url,1);
			return $this->getFirst(array('slug'=>$url));
		}
		
//		function getURL()		{
//			return '/newsItem/'.$this->urlTitle;
//		}
	}
?>
