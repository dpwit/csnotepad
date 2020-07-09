<?
	class HistoryModel extends BozModel {
		function __construct($obj=null){
			parent::__construct($obj,'histories');
		}

		function getIDField(){
			return 'id';
		}

		function getDefaultOrder(){
			return "cdate asc";
		}

		function getLabel(){
			return $this->ref_table.".".$this->ref_id;
		}
		function getLabelField(){
			return $this->ref_table;
		}

		function getListingColumns(){
			$cols = parent::getListingColumns();
			$cols['At'] = date("Y-m-d H:i:s",$this->cdate);
			try {
				$ref = $this->referenced();
			} catch(Exception $e){
			}
			$cols['Ref'] = $ref ? $ref->getLabel() : '';
			return $cols;
		}
		function getTextFields(){
			return array("ref_table","ref_id","changes");
		}
		function getCMSActions(){
			$actions = parent::getCMSActions();
			try {
				$actions[$this->referenced()->urlFor('editItem')] = 'Edit Referenced';
			} catch(Exception $e){}
			return $actions;
		}

		function referenced(){
			$model = $this->unpluralize($this->ref_table);
			$model = Model::loadModel($model);
			return $model->get($this->ref_id);
		}
		function cms_revert(){
			$obj = $this->referenced();
			if(!$obj->exists()) throw new Exception("Cannot Revert on Non-existent Object...");
			foreach(explode("\n",$this->changes) as $change){
				if(preg_match("/^([^=]+)='(.*)' to '(.*)'$/",$change,$match)){
					$check[$match[1]] = $match[3];
					$set[$match[1]] = $match[2];
				}
			}
			foreach($check as $k=>$v){
				if($obj->$k=='0' && $v=='') continue;
				if($obj->$k!=$v) throw new Exception("Object has been edited?");
			}
			foreach($set as $k=>$v){
				$obj->$k = $v;
			}
			$obj->writeToDB();
			$this->showView('confirmation');
		}
	}
?>
