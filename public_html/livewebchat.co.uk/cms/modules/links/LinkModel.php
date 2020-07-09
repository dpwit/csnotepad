<?
	class LinkModel extends SortableModel {
		function __construct($obj=null){
			parent::__construct($obj,'link');
			$this->hasOne('link_category',array('add-filter'=>true));
			$this->hasFile('image',array('file_type'=>'img','sizes'=>array(
				'thumb'=>array('width'=>100)
				)));
		}

		function getFields(){
			parent::getFields();
			$this->fields['link_category_uid']->setParam('default',@$_GET['category']);
			return $this->fields;
		}
		function getSiblings($where=array(),$params=array()){
			$where['link_category_uid'] = $this->link_category_uid;
			return parent::getSiblings($where,$params);
		}
		function humanReadableLink(){
			$link = str_replace("http://","",$this->link);
			$link = preg_replace('_/$_','',$link);
			return $link;
		}
	}
?>
