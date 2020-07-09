<?
	class ShippingCost extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'shipping_break');
			$this->doInternalSQL();
		}

		function filter_fields_built($fields){
			include(cms_module_resolve('orders','/data/countries.php'));
			unset($fields['slug']);
			$fields['country_code'] = new DropDownField('country_code',array('options'=>$countries));
			$regions = array_unique($regions);
			$regions = array_combine($regions,$regions);
			$fields['region_code'] = new DropDownField('region_code',array('options'=>array_merge(array('WW'=>'Worldwide'),$regions)));
			$fields['from_weight'] = new NumericField('from_weight',array('places'=>3));
			$fields['price'] = new NumericField('price');
			return $fields;
		}

		function getDefaultOrder(){
			return array('country_code','region_code','from_weight');
		}
		function getListingColumns(){
			return array('Region'=>$this->region_code,'Country'=>$this->country_code,'Min Weight'=>$this->from_weight,'Cost'=>$this->price);
		}
	}
?>
