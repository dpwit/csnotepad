<?
	require_once(dirname(__FILE__).'/base_engine.php');
	if(!defined('__TMP_DIR__')) define('__TMP_DIR__','/tmp');

	class JsonEngine extends ModelDBEngine {
		function __construct(){
			$this->dir = __TMP_DIR__;
		}

		static function getInstance(){
			static $instance;
			if(!$instance) $instance = (new JsonEngine());
			return $instance;
		}

		function wrapResult($model,$q,$params){
			if(@$params['single']) return $q->fetch();
			if(@$params['for_fetch']) return $q;
			else {
				$results = array();
				while($r = $q->fetch()) $results[] = $r;
				return $results;
			}
		}
		function delete($model,$params=array()){
			$data = $this->readAndLock($model->getTableName());
			unset($data[$model->getId()]);
			$this->writeAndRelease($model->getTableName(),$data);
		}
		function save($model,$params=array()){
			$values = $model->getAssignArray();
			if($model->exists()) $this->update($model,$values,$params);
			else $this->insert($model,$values,$params);
		}

		function insert($model,$values,$params=array()){
			$table = $model->getTableName();
			$cf=$table;

			$t = time();
			$id = $t."-".rand();
			$model->uid = $id;
			$values['uid'] = $id;
			$this->update($model,$values,$params);
		}

		function update($model,$values,$params=array()){
			$data = $this->readAndLock($model->getTableName());
			$data[$model->getId()] = $values;
			$this->writeAndRelease($model->getTableName(),$data);
		}
		function getAll($model,$where = array(),$params=array()){
			//TODO: use indexes where available
			$res = new ArrayBruteFetcher($this->read($model->getTableName()),$model,$where,$params);
			return $this->wrapResult($model,$res,$params);
		}
		function exists($model){
			$id = $model->getID();
			return $id && (strpos($id,'NEW')!==0);
		}
		function listFields($model){
			return array();
		}
		function createTable($model){
			touch($this->dir.'/'.$model->getTableName().'.json');
			return;
		}
		function createFields($model,$fields){
			return;
		}
		function getIndexes($model){
			return array();
		}
		function createIndex($model,$fields){
			return;
		}

		function readAndLock($table){
			$this->lock($table);
			unset(self::$dataFiles[$table]);
			return $this->read($table);
		}

		function read($table){
			if(!@self::$dataFiles[$table]) self::$dataFiles[$table] = json_decode(file_get_contents("$this->dir/$table.json"),true);
			return self::$dataFiles[$table];
		}
		function writeAndRelease($table,$data){
			$this->write($table,$data);
			$this->release($table);
		}
		function write($table,$data){
			file_put_contents("$this->dir/$table.json",json_encode($data));
			self::$dataFiles[$table] = $data;
		}

		function lock($table){}
		function release($table){}

		static $dataFiles = array();
	}

require_once(dirname(__FILE__).'/bruteforce_fetcher.php');
	class ArrayBruteFetcher extends BruteFetcher {
		var $data;

		function __construct($data,$model,$where,$params){
			parent::__construct($model,$where,$params);
			$this->data = $data;
		}
		function fetchObject(){
			$value = @array_shift($this->data);
			if(!$value) return false;
			$obj = new stdclass();
			foreach($value as $k=>$v){
				$obj->$k=$v;
			}
			return $obj;
		}
		function free(){
		}
	}
?>
