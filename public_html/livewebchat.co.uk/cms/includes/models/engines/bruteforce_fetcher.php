<?
/** Implements all joining/sorting logic in php so that any linear storage
 * can be queried in a relational way.
 */
	abstract class BruteFetcher extends Fetcher {
		var $cached = array();
		function __construct($model,$where,$params){
			$this->model=$model;
			$this->where=$where;
			$this->params=$params;
			$this->offset=0;
			parent::__construct();
			$this->fetch_from = @$params['skip'];
			$this->fetch_to = $this->fetch_from + @$params['limit'];
		}
		function fetch(){
			if($ret = $this->pop())
				return $ret;
			return false;
		}
		function createFor($class,$r,$isModel){
			return $this->model->create($class,$r,$isModel?$this->model->getTableName():false);
		}
		function numResults(){
			$this->cacheAll();
			return count($this->results);
		}
		function compare($a,$b){
			$order = $this->params['order'];
			if(!is_array($order)) $order = array($order);
			foreach($order as $field){
				@list($field,$dir) = explode(" ",$field);
				if($dir && strtolower($dir=='desc')){
					$dir=-1;
				} else {
					$dir=1;
				}
				if($a->$field==$b->$field) continue;
				return ($a->$field<$b->$field)?-$dir:$dir;
			}
			return 0;
		}
		function peek(){
			if($this->offset==0 && (@$this->params['order'])){
				$this->cacheAll();
				usort($this->cached,array($this,'compare'));
			}
			if(!$this->cached) $this->cacheOne();
			if($this->cached) return $this->cached[0];
		}
		function pop(){
			$res = $this->peek();
			@array_shift($this->cached);
			return $res;
		}
		function cacheAll(){
			do {
				$last = count($this->cached);
				$this->cacheOne();
			} while(count($this->cached)>$last);
		}
		function cacheOne(){
			if($this->fetch_to && ($this->offset>=$this->fetch_to)) return false;
			while($res = $this->fetchObject()){
				if($this->matchesRawFilter($res)){
					$class = get_class($this->model);
					$isModel = in_array(strtolower($class),array('model','mymodel','bozmodel'));
					$res = $this->createFor($class,$res,$isModel?$this->model->getTablename():false);
					if($this->matchesModelFilter($res)){
						$this->cached[] = $res;
						$this->offset++;
						return;
					}
				}
			}
		}
		abstract function fetchObject();
		function matchesRawFilter($res){
			$where = $this->where;
			if(!$where) return true;
			if(is_array($where))
				$where = new AndJoin($where);
			if(!$where->matchesRaw($res,$this->model)) return false;
			$this->offset++;
			return $this->offset>$this->fetch_from;
		}

		function matchesModelFilter($res){
			$where = $this->where;
			if(!$where) return true;
			if(is_array($where))
				$where = new AndJoin($where);
			return $where->matchesModel($res);
		}
	}
