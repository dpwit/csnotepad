<?
/**
* @package Elite_Promo
*/

	class Feature extends BozModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,'feature');
			$this->hasMM('products',array(
				'table'=>'featured_products',
				'order'=>'sorting',
				'composition'=>true,
				'input'=>__MODELS_BASE__.'/fields/MMSortedSelector.php:MMSortedSelector',
				'back'=>'features'
			));
		}

		function showListing(){
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
