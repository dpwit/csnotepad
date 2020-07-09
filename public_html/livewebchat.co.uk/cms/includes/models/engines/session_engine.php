<?
	class SessionEngine extends ModelDBEngine {
		static function getInstance(){
			static $instance;
			if(!$instance) $instance = new SessionEngine;
			return $instance;
		}
		function insert($model,$valueArray,$params=array()){
			global $_SESSION;
			$table = $model->getTableName();
			$_SESSION[$table][] = $valueArray;
			$model->setId(max(array_keys($_SESSION[$table])));
		}
		function update($model,$valueArray,$params=array()){
			global $_SESSION;
			$_SESSION[$model->getTableName()][$model->getId()] = $valueArray;
		}
		function delete($model,$params=array()){
			global $_SESSION;
			unset($_SESSION[$model->getTableName()][$model->getId()]);
		}

		function save($model,$params=array()){
			$values = $model->getAssignArray();
			if($model->exists()) $this->update($model,$values);
			else $this->insert($model,$values);
		}
		function getAll($model,$where=array(),$params=array()){
			$list = $this->getFullList($model);

			$this->restrict = $where;
			$list = array_filter($list,array($this,'find_matching'));
			$fetcher = new ArrayFetcher($list,$model);
			return $this->fetchByParams($fetcher,$params);
		}

		function find_matching($arr){
			foreach($this->restrict as $k=>$v){
				@list($field,$op) = explode(" ",$k,2);
				switch($op){
				case '=':
				default:
					if($arr[$field]!=$v) return false;
				}
			}
			return true;
		}

		function fetchByParams($fetcher,$params){
			if(@$params['single']){
				$res = $fetcher->fetch();
				$fetcher->free();
				return $res;
			}

			while(@$params['skip']--) $fetcher->fetch();

			if($params['for_fetch']){
				return $fetcher;
			}

			$results = array();
			while($res = $fetcher->fetch()){
				if($params['limit'] && ($count++>=$params['limit'])) break;
				$results[] = $res;
			}
			$fetcher->free();
			return $results;
		}

		function getFullList($model){
			global $_SESSION;
			$res =  @$_SESSION[$model->getTableName()];
			if(!$res) $res=array();

			foreach($res as $k=>$v){
				$res[$k][$model->getIdField()] = $k;
			}
			return $res;
		}
		function exists($model){
			$id = $model->getID();
			return is_numeric($id);
		}
	}
	class ArrayFetcher extends Fetcher {
		function __construct($array,$model){
			$this->array=$array;
			$this->count = count($array);
			$this->model=$model;
		}
		function fetch(){
			if(!$this->array) return false;
			if($r = array_shift($this->array)){
				$class = get_class($this->model);
				$r2 = new stdclass;
				foreach($r as $k=>$v)$r2->$k=$v;
				return $this->model->create($class,$r2,@$isModel?$this->model->getTableName():false);
			} else {
				$this->free();
				return false;
			}
		}
		function free(){
		}
		function numResults(){
			return $this->count;
		}
	}
