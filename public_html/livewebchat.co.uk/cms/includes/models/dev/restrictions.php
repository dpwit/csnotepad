<?
/**
 * Replace old restriction classes.
 */
	require_once(dirname(__FILE__).'/../www/cms/cli-env.php');
	interface SQLRestriction {
		function restrict($model,&$tables,$params);
	}
	class C implements ArrayAccess,SQLRestriction {
		function __construct($array=array(),$join='AND'){
			$this->join = $join;
			$this->values = $array;
			foreach($array as $k=>$v){
				if(!$v instanceof R){
					$this->offsetSet($k,$v);
				}
			}
		}
		function offsetExists($key){
			return array_key_exists($key,$this->values);
		}
		function offsetGet($key){
			return $this->values[$key];
		}
		function offsetSet($key,$value){
			if(!$value instanceof R){
				@list($a,$operator) = explode(" ",$key,2);
				if(!$operator) $operator='=';
				$value=R::r($a,$operator,$value);
			}
			$this->values[$key]=$value;
		}
		function offsetUnset($key){
			unset($this->values[$key]);
		}

		function restrict($model,&$tables,$params){
			$parts = array();
			foreach($this->values as $r){
				$parts[] = $r->restrict($model,$tables,$params);
			}
			return "(".join(" $this->join ",$parts).")";
		}
	}
	class R implements SQLRestriction {
		var $field;
		var $operator;
		var $value;
		protected function __construct($a,$op,$b){
			$this->field = $a;
			$this->operator = $op;
			$this->value = $b;
		}

		static function r($a,$op,$b=null){
			$mappings = array(
				'in'=>'InR',
				'is not'=>'NullR',
				'is'=>'NullR'
			);
			$op = strtolower($op);
			$class = @$mappings[$op];
			if(!$class) $class='R';
			return new $class($a,$op,$b);
		}	
		function restrict($model,&$tables,$params){
			if($special = $model->specialWhere($this->field,$this->value)){
				$c = new C($special);
				return $c->restrict($model,$tables,$params);
			}
			return $this->includeTable($model,$tables)." $this->operator '".mysql_escape_string($this->value)."'";
		}
		function includeTable($model,&$tables){
			return $model->includeTable($this->field,$tables);
		}
	}
	class Not extends R{
		static function r($r){
			return new Not($r);
		}

		protected function __construct($r){
			if(is_array($r)){
				$r = new C($r);
			}
			$this->internal = $r;
		}

		function restrict($model,&$tables,$params){
			return "NOT (".$this->internal->restrict($model,$tables,$params).")";
		}
	}
	class InR extends R {
		function restrict($model,&$tables,$params){
			return $this->includeTable($model,$tables)." $this->operator ('".join("','",array_map('mysql_escape_string',$this->value))."')";
		}
	}
	class NullR extends R {
		function restrict($model,&$tables,$params){
			return $this->includeTable($model,$tables)." $this->operator NULL";
		}
	}

/*	class NotLogic extends R{}
	class AndJoin extends C{}
	class OrJoin extends C{
		function __construct($array=array()){
			parent::__construct($array,'OR');
		}
	}
 */
	$c = array();
	$c = new C($c);
	$c['uid in']=array(1,2,3);
	$c['name like']='%test%';
	$c['author.uid is not'] = 'null';
	$c[] = Not::r(R::r('uid','is not','null'));

	Model::addModel('Test',false,'BozModel');
	$model = Model::loadModel('Test');
	$model->hasOne('author');
	$tables = "tests";
	$where = $c->restrict($model,$tables,array());
	echo "SELECT * FROM $tables WHERE $where\n";
?>
