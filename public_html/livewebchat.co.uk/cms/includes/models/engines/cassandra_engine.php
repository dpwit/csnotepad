<?
	require_once(dirname(__FILE__).'/base_engine.php');

$GLOBALS['THRIFT_ROOT'] = '/usr/share/php/Thrift';
require_once $GLOBALS['THRIFT_ROOT'].'/packages/cassandra/Cassandra.php';
require_once $GLOBALS['THRIFT_ROOT'].'/packages/cassandra/cassandra_types.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php';
require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TFramedTransport.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php';
if(!defined('__CASSANDRA_NAME__')) define('__CASSANDRA_NAME__',__MYSQL_NAME__);

	class CassandraEngine extends ModelDBEngine {
		function __construct(){
			$this->socket = new TSocket('127.0.0.1', 9160);
			$this->transport = new TBufferedTransport($this->socket, 1024, 1024);
			$this->protocol = new TBinaryProtocolAccelerated($this->transport);
			$this->client = new CassandraClient($this->protocol);
			$this->transport->open();
			$this->keyspace=__CASSANDRA_NAME__;
			cms_listen_action('tables_created',$this);
		}

		var $tablesCreated = array();
		function tables_created(){
			return true;
			ob_start();
?>
	<Keyspace Name="<?=$this->keyspace?>">
<?
			foreach($this->tablesCreated as $table=>$config){
?>
	<ColumnFamily Name="<?=$table?>"
		ColumnType="<?=$config['super'] ? "Super" : "Standard"?>"
		    CompareWith="<?=$config['compare']?>"
<? if($config['super']) { ?>
		    CompareSubcolumnsWith="<?=$config['compare']?>" 
<? } ?>
		/>
<?
			}
?>
      <ReplicaPlacementStrategy>org.apache.cassandra.locator.RackUnawareStrategy</ReplicaPlacementStrategy>
      <ReplicationFactor>1</ReplicationFactor>
      <EndPointSnitch>org.apache.cassandra.locator.EndPointSnitch</EndPointSnitch>
	</Keyspace>
<?
			file_put_contents($file = BASEPATH.'/../../config/cassandra-storage.xml',ob_get_contents());
			ob_end_clean();
			echo "\nWrote Cassandra Config to '$file'\n";
		}
		static function getInstance(){
			static $instance;
			if(!$instance) $instance = (new CassandraEngine());
			//if(!$instance) $instance = new MemCacheEngine(new MySQLEngine());
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
			$this->deleteProper($model->getTableName(),$model->getId());
		}
		function deleteProper($table,$id){
			$consistency_level = cassandra_ConsistencyLevel::ONE;
			$columnParent = new cassandra_ColumnParent();
			$columnParent->column_family = $table;
			$columnParent->super_column = NULL;
			$this->client->remove($this->keyspace,$id, $columnParent, time(), $consistency_level);
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
			// Create index records...
		}

		function getMutation($model,$values,$isInsert=false){
			$t = time();
			$table = $model->getTableName();
			$values = array($model->getTableName()=>$values);
			foreach($model->getIndexFields() as $i){
				if($i==$model->getIdField()) continue;
				$col = new cassandra_Column();
				$col->name = $model->getId();
				$col->value = 1;
				$col->timestamp=$t;
				$c_or_sc = new cassandra_ColumnOrSuperColumn;
				$c_or_sc->column = $col;
				$mn = new cassandra_Mutation();
				$mn->column_or_supercolumn = $c_or_sc;
				$mutation[$model->$i][$table."_by_".$i]=array($mn);
			}

			foreach($values as $table=>$rows){
				$sc = new cassandra_SuperColumn();
				$sc->name = "data";
				foreach($rows as $k=>$v){
					$col= new cassandra_Column();
					$col->name=$k;
					if(is_null($v)) $v='';
					$col->value=$v;
					$col->timestamp=$t;
					$sc->columns[] = $col;
				}
				$c_or_sc = new cassandra_ColumnOrSuperColumn();
				$c_or_sc->super_column = $sc;
				$mn = new cassandra_Mutation();
				$mn->column_or_supercolumn = $c_or_sc;
				$mutation[$model->getId()][$table] = array($mn);
			}

			if(@$params['debug']) var_dump(array("TABLE"=>$model->getTableName(),"INSERT"=>$values));

			return $mutation;
		}

		function update($model,$values,$params=array()){
			$id = $model->getId();
			$consistency_level = cassandra_ConsistencyLevel::ONE;
			$this->client->batch_mutate($this->keyspace,$this->getMutation($model,$values),$consistency_level);
		}
		function getAll($model,$where = array(),$params=array()){
			//TODO: use indexes where available
			$res = new CassandraBruteFetcher($this->keyspace,$this->client,$model,$where,$params);
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
			$this->tablesCreated[is_object($model) ? $model->getTableName() : $model] = array('super'=>true,"compare"=>"BytesType");
			//TODO: Do We Need This?
			return;
		}
		function createFields($model,$fields){
			//TODO: Do We Need This?
			return;
		}
		function getIndexes($model){
			//TODO: Implement these as look up columns
			return array();
		}
		function createIndex($model,$fields){
			if(count($fields)==1){
				$field = array_pop($fields);
				if(($field=='uid') || (is_object($model) && ($field==$model->getIDField()))) return;
				$this->tablesCreated[(is_object($model) ? $model->getTableName() : $model)."_by_".$field] = array('super'=>false,"compare"=>"BytesType");
				return;
			}

			throw new Exception("Unimplemented ".__CLASS__.".".__FUNCTION__." for multiple fields");
		}
	}

require_once(dirname(__FILE__).'/bruteforce_fetcher.php');
	class CassandraRealBruteFetcher extends BruteFetcher {
		var $emptyQ = false;
		var $current = array();
		var $lastKey = "";
		var $firstKey = "";

		function __construct($keyspace,$client,$model,$where,$params){
			parent::__construct($model,$where,$params);
			$this->client = $client;
			$this->keyspace = $keyspace;
		}
		function fetchObject(){
			while($this->current || !$this->emptyQ){
				if(!$this->current) $this->reQuery();
				do {
					$next = array_shift($this->current);
					if(!$this->firstKey) $this->firstKey = $next->key;
					elseif($next->key==$this->firstKey){
						$this->current=array();
						$this->emptyQ = true;
						$next = false;
					}
				} while($this->current && !$next->columns);
				if($next && $next->columns){
					$obj = new stdclass();
					$obj->cassandra_tstamp = array();
					foreach($next->columns[0]->super_column->columns as $column){
						$name = $column->name;
						$obj->$name = $column->value;
						$obj->cassandra_tstamp[$column->name] = $column->timestamp;
					}
					$obj->uid = $next->key;
					return $obj;
				}
			}
			return false;
		}
		function reQuery(){
			$consistency_level = cassandra_ConsistencyLevel::ONE;


			$sliceRange = new cassandra_SliceRange();
			$sliceRange->start = "";
			$sliceRange->finish = "";
			$sliceRange->count=100;
			$predicate = new cassandra_SlicePredicate();
			list() = $predicate->column_names;
			$predicate->slice_range = $sliceRange;
			
			$indexes = $this->model->getIndexFields();
			foreach($indexes as $k=>$v){
				if(@$this->where[$v]){
					$useIndex = $v;
					break;
				}
			}
			if(@$useIndex){
				if($useIndex!='uid'){
					$table = $this->model->getTableName()."_by_".$useIndex;
					$columnParent = new cassandra_ColumnPath();
					$columnParent->column_family = $table;
					try {
						$res = $this->client->get_slice($this->keyspace,$this->where[$useIndex],$columnParent,$predicate,$consistency_level);
						$relatedIds = array();
						foreach($res as $c_or_sc){
							$relation = $c_or_sc->column;
							if($relation->value) $relatedIds[] = $relation->name;
						}

					} catch(cassandra_NotFoundException $e){
						$this->current = array();
					}
				} else {
					$relatedIds = array($this->where['uid']);
				}
				$columnParent = new cassandra_ColumnPath();
				$columnParent->column_family = $this->model->getTableName();
				try {
					$res =$this->client->multiget_slice($this->keyspace,$relatedIds,$columnParent,$predicate,$consistency_level);
					$this->current=array();
					foreach($res as $k=>$c_or_sc_array){
						$c = new stdclass();
						$c->key=$k;
						$c->columns = $c_or_sc_array;
						$this->current[] = $c;
					}
				} catch(cassandra_NotFoundException $e){
					$this->current = array();
				}
				$this->emptyQ = true;
			} else {
				$keyRange = new cassandra_KeyRange();
				$keyRange->start_key = $this->lastKey;
				$keyRange->end_key = "";//$this->firstKey;
				$keyRange->count=100;
				$columnParent = new cassandra_ColumnParent();
				$columnParent->column_family = $this->model->getTableName();
				$columnParent->super_column = NULL;
				$this->current = $this->client->get_range_slices($this->keyspace,$columnParent,$predicate,$keyRange,$consistency_level);
				$numFound = count($this->current);
				if($numFound<$keyRange->count)$this->emptyQ=true;
				if($this->lastKey) {
					array_shift($this->current);
					$numFound--;
				} else {
//					$this->firstKey = $this->current[0]->key;
				}
				if($numFound){
					$this->lastKey=$this->current[$numFound-1]->key;
				}
			}
		}
		function free(){
			unset($this->current);
			unset($this->cached);
		}
	}
	class CassandraBruteFetcher extends CassandraRealBruteFetcher {
		function __reQuery(){
			// Mem-cache?
			static $query_cache=array(),$t_cache=array();
			$table = $this->model->getTableName();
			if(array_key_exists($table,$query_cache)){
				$this->current = $query_cache[$table];
				return;
			}

			parent::reQuery();

			if(array_key_exists($table,$t_cache)) $t_cache[$table] = array_merge($t_cache[$table],$this->current);
			else $t_cache[$table] = $this->current;

			if($this->emptyQ){
				$query_cache[$table] = $t_cache[$table];
			}
		}
	}
?>
