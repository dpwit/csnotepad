<?
/**
* @package Elite_Promo
*/

	class Feature extends SortableModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,'feature');
			$this->doInternalSQL();
			$this->hasMM('products',array(
				'table'=>'featured_products',
				//'order'=>'sorting',
				'composition'=>true,
				'input'=>__MODELS_BASE__.'/fields/MMSortedSelector.php:MMSortedSelector',
				'back'=>'features'
			));
		}

		function getParent(){
			return Model::ga('Pages',array('title'=>'shop'),array('single'=>1));
		}
		function getUrlPrefix(){
			return "/our-services/featured/";
		}

		function showListing(){
			if(Config::value('allow_multiple_features','products')) return parent::showListing();
			$_GET['cms_uid'] = 1;
			$feat = $this->get(1);
			if(!$feat) {
				$feat = $this->createNew(array('name'=>'Featured Items'));
				$feat->writeToDB();
			}
			$this->cms_editItem();
			return true;
		}

		function filter_fields_built($fields){
			$fields['products']->setParam('label','Featured Products');
			$fields['products']->setParam('extra-url','&restrict='.urlencode(json_encode(array('abstract'=>0))));
			return $this->fields;
		}

		function availableProducts($where=array(),$params=array()){
			$where['available'] = 1;
			return $this->products($where,$params);
		}
	}
?>
