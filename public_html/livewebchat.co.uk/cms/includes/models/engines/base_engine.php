<?
	class DBException extends Exception{}
	abstract class ModelDBEngine {
		/** This intentionally avoids using sql based optimisations so that it does not require
		 * re-engineering to replace mysql.
		 */
		function count($model,$where,$params){

			$defaults = array(
				'destroy'=>false,
				'group'=>array(),
				'aggregate'=>array(),
			);
			$params = array_merge($defaults,$params);
			$group_fields = $params['group'];
			if(!is_array($group_fields)) $group_fields = array($group_fields);
			$aggregators = $this->instantiateAggregators($params['aggregate']);
			$params['for_fetch'] = 1;
			$res = $model->getAll($where,$params);
			if(!($group_fields || $aggregators)) {
				$num = $res->numResults();
				$res->free();
				return $num;
			} else {
				$results = array();
				while($row = $res->fetch()){
					$keys = array();
					foreach($group_fields as $field){
						if(is_string($field)) $field = new StringGrouper($field);
						$key = $field->extractKey($row);
						$keys[] = $key;
					}
					// This is lazy and flawed (will break for multiple fields containing double colons)
					$key = join("::",$keys);
					$results[$key]['key'] = $key;
					$results[$key]['keys'] = $keys;
					@$results[$key]['count']++;

					foreach($aggregators as $aggregator){
						$results[$key] = call_user_func($aggregator,$row,$results[$key]);
					}


					if($params['destroy']) $row->__destroy();
				}
				return $results;
			}
		}
		function instantiateAggregators($aggregators = array()){
			foreach($aggregators as $k=>$v){
				if(is_string($v)) $v = new SumAggregator($v);
				if(is_object($v)) $aggregators[$k] = array($v,'aggregate');
			}
			return $aggregators;
		}
		
		abstract function insert($model,$valueArray,$params=array());
		abstract function update($model,$valueArray,$params=array());
		abstract function delete($model,$params=array());
		abstract function getAll($model,$where=array(),$params=array());
		abstract function exists($model);

		function save($model,$params=array()){
			$values = $model->getAssignArray();
			if($model->exists()) $this->update($model,$values);
			else $this->insert($model,$values);
		}
		function hasIndexes(){
			return true;
		}
		function hasSchema(){
			return true;
		}
	}

	interface Aggregator {
		function aggregate($row,$dataSoFar);
	}
	class SumAggregator implements Aggregator {
		function __construct($field){
			$this->field = $field;
		}
		function aggregate($row,$data){
			$field = $this->field;
			@$data[$field]+=$row->$field;
			return $data;
		}
	}
	class AnyAggregator implements Aggregator {
		function __construct($field){
			$this->field = $field;
		}
		function aggregate($row,$data){
			$field = $this->field;
			if(!@$data[$field]) $data[$field]=$row->$field;
			return $data;
		}
	}
	interface Grouper {
		function extractKey($model);
	}
	class StringGrouper implements Grouper {
		function __construct($fieldSpec){
			$this->field = $fieldSpec;
		}
		function extractKey($row){
			return $this->extractRaw($row);
		}
		function extractRaw($row){
			@list($rel,$field) = explode(".",$this->field,2);
			if($field){
				$row=$row->$rel();
				$sub = clone($this);
				$sub->field = $field;
				$key = $sub->extractRaw($row);
			} else {
				$field = $rel;
				$key = @$row->$field;
			}
			return $key;
		}
	}
