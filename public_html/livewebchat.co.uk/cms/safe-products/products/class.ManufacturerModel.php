<?
	class ManufacturerModel extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'manufacturer');
			$this->doInternalSQL();
			$this->hasMM('products',array('table'=>'products_mm_manufacturers','order'=>'products_order'));
			if(!@$this->type) $this->type = $this->getType();
		}

		function filter_mm_listing_label($label){
			return "$label ($this->type)";
		}

		function getModelNamesForHooks(){
			return array("manufacturer",strtolower($this->getModelName(false)));
		}
		function filter_create_class($class,$valueObj){
			return $this->classForType(@$valueObj->type,$class);
		}

		function filter_new_class($class,$values){
			return $this->classForType(@$values['type'],$class);
		}

		function classForType($type,$class){
			$types = $this->getManufacturerClasses();
			if($model = @$types[$type]){
				$model = Model::loadModel($model);
				$class = get_class($model);
			}
			return $class;
		}

		function getManufacturerTypes(){
			return array_keys($this->getManufacturerClasses());
		}
		function getManufacturerClasses(){
			$types = array('manufacturer'=>'GenericManufacturer');
			return $this->applyFilters('item_types',$types);
		}

		function filter_fields_built($fields){
			$fields = parent::filter_fields_built($fields);
			$types = $this->getManufacturerTypes();
			$fields['type'] = new DropDownField('type',array('options'=>array_combine($types,$types),'default'=>$this->getType(),'hidden'=>true));
			return $fields;
		}

		function getIrrelevantWhere(){
			if($type = $this->getType()){
				return array('type !='=>$type);
			}
		}

		function getType(){
			return false;
		}
	}

	class GenericManufacturer extends ManufacturerModel {
		function getType(){
			return 'manufacturer';
		}
	}
?>
