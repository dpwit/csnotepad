<?
/**
 * Replace old restriction classes.
 */
	interface SQLRestriction {
		function restrict($model,&$tables,$params);
	}
	class C implements ArrayAccess,SQLRestriction {
		function __construct($array=array(),$join='AND'){
			if(is_object($array)) $array = array($array);
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
			if(is_numeric($key) && is_array($value) && !is_object($value)){
				$value = new C($value);
			} 
			if(!$value instanceof SQLRestriction){
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
			if(!$parts) return 1;
			return "(".join(" $this->join ",$parts).")";
		}

		function matchesRaw($obj,$factory){
			foreach($this->values as $r){
				if($r->matchesRaw($obj,$factory)){
					if($this->join=='OR') return true;
				} else {
					if($this->join=='AND') return false;
				}
			}
			return $this->join=='AND';
		}
		function matchesModel($obj){
			foreach($this->values as $r){
				if($r->matchesModel($obj)){
					if($this->join=='OR') return true;
				} else {
					if($this->join=='AND') return false;
				}
			}
			return $this->join=='AND';
		}
		function rebase($table){
			$r = clone($this);
			$r->rebaseInternal($table);
			return $r;
		}

		function rebaseInternal($table){
			foreach($this->values as $k=>$v){
				$this->values[$k] = $v->rebase($table);
			}
		}
	}
	class R implements SQLRestriction {
		var $field;
		var $operator;
		var $value;
		var $special =false;

		var $delay = false;
		protected function __construct($a,$op,$b){
			$this->field = $a;
			$this->operator = $op;
			$this->value = $b;
		}

		function rebase($table){
			$r = clone($this);
			$r->rebaseInternal($table);
			return $r;
		}

		function rebaseInternal($table){
			$this->field = "$table.$this->field";
		}

		static function r($a,$op,$b=null){
			$mappings = array(
				'in'=>'InR',
				'is not'=>'NullR',
				'is'=>'NullR',
				'like'=>'LikeR',
			);
			$op = strtolower($op);
			$class = @$mappings[$op];
			if(!$class) $class='R';
			return new $class($a,$op,$b);
		}	
		function restrict($model,&$tables,$params){
			$special = $model->specialWhere($this->field,$this->value);
			if((!$this->special) && ($special !==false)){
				$c = new C($special);
				$this->special = $c;
			}
			if($this->special){
				return $this->special->restrict($model,$tables,$params);
			}
			$inc = $this->includeTable($model,$tables);
			if(is_object($inc)) return $inc->restrict($model,$tables,$params);
			return $inc." $this->operator '".mysql_escape_string($this->value)."'";
		}
		function includeTable($model,&$tables){
			return $model->includeTable($this->field,$tables,$this->value);
		}
		function matchesRaw($obj,$factory){
			$special = $factory->specialWhere($this->field,$this->value);
			if((!$this->special) && ($special !==false)){
				$c = new C($special);
				$this->special = $c;
			}
			if($this->special){
				return $c->matchesRaw($obj,$factory);
			}
			if($this->delay) return true;
			//TODO: SOMETHING?
			if(property_exists($obj,$this->field)){
				$f = $this->field;
				$v = $obj->$f;
				return $this->matchesValue($v);
				//Is this right?
				switch($this->operator){
				case '=':
				case '==':
					return ($v==$this->value);
				case '!=':
					return ($v!=$this->value);
				case 'in':
					return (in_array($v,$this->value));
				}
			}
			$this->delay=true;
			return true;
		}
		function matchesModel($obj){
			$special = $obj->specialWhere($this->field,$this->value);
			if((!$this->special) && ($special !==false)){
				$c = new C($special);
				$this->special = $c;
			}
			if($special = $this->special){
				$c = new C($special);
				return $c->matchesModel($obj);
			}
		//	if(!$this->delay) return true;
			$f = $this->field;
			@list($table,$field) = explode(".",$f,2);
			if($field){
				$inst = @$obj->$table;
				if(!$inst) $inst = $obj->$table();
				if($inst && !is_array($inst)) $inst = array($inst);
				$sub = clone($this);
				$sub->field = $field;
				if(is_array($inst))
				foreach($inst as $inst){
					if($sub->matchesModel($inst)) return true;
				}
				if(!@count($inst) ) return $this->operator == 'is';
				return false;
			}
			return $this->matchesValue($obj->$f);
		}
		function matchesValue($v){
			switch($this->operator){
			case '=':
			case '==':
				return ($v==$this->value);
			case '!=':
				return ($v!=$this->value);
			case 'in':
				return (in_array($v,$this->value));
			case 'is':
				return is_null($v);
			case 'is not':
				return !is_null($v);
			}
			trigger_error("Failed evaluating $this->field $this->operator $this->value");
			return false;
		}

	}
	class Not extends R{
		static function r($r){
			return new Not($r);
		}

		public function __construct($r){
			if(is_array($r)){
				$r = new C($r);
			}
			$this->internal = $r;
		}

		function restrict($model,&$tables,$params){
			return "NOT (".$this->internal->restrict($model,$tables,$params).")";
		}

		function matchesRaw($obj,$factory){
			return !$this->internal->matchesRaw($obj,$factory);
		}
		function matchesModel($obj){
			return !$this->internal->matchesModel($obj);
		}
	}
	class InR extends R {
		function restrict($model,&$tables,$params){
			return $this->includeTable($model,$tables,$this->value)." $this->operator ('".join("','",array_map('mysql_escape_string',$this->value))."')";
		}
	}
	class LikeR extends R {
		function matchesValue($v){
			$e = strtolower($this->value);
			$v = strtolower($v);
			$e = str_replace("%",".*",preg_quote($e,'/'));
			return preg_match("/$e/",$v);
		}
	}
	class NullR extends R {
		function restrict($model,&$tables,$params){
			return $this->includeTable($model,$tables,$this->value)." $this->operator NULL";
		}
		function matchesRaw(){
			return true;
		}
		function matchesModel($obj){
			$f = $this->field;
			@list($table,$field) = explode(".",$f,2);
			if($field){
				$inst = @$obj->$table;
				if(!$inst) $inst = $obj->$table();
				if(!$inst) return $this->operator == 'is';
				if($inst && !is_array($inst)) $inst = array($inst);
				$sub = clone($this);
				$sub->field = $field;
				if(is_array($inst))
				foreach($inst as $inst){
					if($sub->matchesModel($inst)) return true;
				}
				return false;
			}
			$v = $obj->$f;
			switch($this->operator){
			case 'is':
				return is_null($v);
			case 'is not':
				return !is_null($v);
			}
			trigger_error("Failed evaluating $this->field $this->operator $this->value");
			return false;
		}
	}

	class NotLogic extends Not{}
	class AndJoin extends C{}
	class OrJoin extends C{
		function __construct($array=array()){
			parent::__construct($array,'OR');
		}
	}
	class MySQLLiteral {
		function __construct($string){
			$this->string = $string;
		}
		
		function restrict($model,$tables,$params){
			return $this->string;
		}
		
	}
