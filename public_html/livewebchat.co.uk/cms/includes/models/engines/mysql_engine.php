<?
	require_once(dirname(__FILE__).'/base_engine.php');
	class MySQLEngine extends ModelDBEngine {
		static function getInstance(){
			static $instance;
			if(!$instance) $instance = (new MySQLEngine());
			//if(!$instance) $instance = new MemCacheEngine(new MySQLEngine());
			return $instance;
		}

		function wrapResult($model,$q,$params){
			$model->lastCount = mysql_result(mysql_query("SELECT FOUND_ROWS()"),0);
			$results = array();
			$class = get_class($model);
			$isModel = in_array(strtolower($class),array('model','mymodel','bozmodel'));
			$model->lastGet = array('q'=>$q,'class'=>$class,'isModel'=>$isModel,'found'=>$model->lastCount);
			$fetcher = $this->getFetcher($model,$params);
			if($params['single']){
				$res = $fetcher->fetch();
				$fetcher->free();
				return $res;
			} 
			if(!$params['for_fetch']){
				$results = array();
				while($result = $model->fetch()) $results[] = $result;
				return $results;
			} else {
				return new MySQLFetcher($model->lastGet,$model);
			}
		}
		function getFetcher($model,$params){
			return new MySQLFetcher($model->lastGet,$model);
		}
		function delete($model,$params=array()){
			mysql_query($sql ="DELETE FROM ".$model->getTableName()." WHERE ".$model->getIDField()."='".$model->getID()."'");
			if(@$params['debug']){
				var_dump("$sql\n");
			}
		}
		function save($model,$params=array()){
			$values = $model->getAssignArray();
			if($model->exists()) $this->update($model,$values,$params);
			else $this->insert($model,$values,$params);
		}

		function update($model,$values,$params=array()){
			$table = $model->getTableName();
			$assign = $model->assignString($values);
			$idField=$model->getIDField();
			$id = $model->getId();
			mysql_query($sql = "UPDATE $table SET $assign WHERE `$idField` = '$id'");
			if(@$params['debug']){
				var_dump("$sql\n");
			}
			if($e = mysql_error()) throw new DBException($e." in ".$sql);         
		}
		function insert($model,$values,$params=array()){
			$table = $model->getTableName();
			$assign = $model->assignString($values);
			mysql_query($sql = "INSERT INTO $table SET $assign");
			if(@$params['debug']){
				var_dump("$sql\n");
			}
			if($e = mysql_error()) throw new DBException($e." in ".$sql);
			$id = mysql_insert_id();
			if($id){
				$model->setId($id);
				if(@$params['debug']){
					var_dump("Insert '$id'\n");
				}
			}
		}
		function getAll($model,$where = array(),$params=array()){
			$model->included = array();
			$defaults = array('limit'=>null,'offset'=>null,
				'order'=>$model->getDefaultOrder(),
				'whereJoin'=>'AND',
				'for_fetch'=>false,'order_explicit'=>false,
				'show_deleted'=>false,'single'=>false,
				'includeTables'=>array(),'debug'=>false,
				'irrelevant' => $model->getIrrelevantWhere(),
			);
			$params = array_merge($defaults,$params);
			extract($params);

			$factors = array();
			if(!is_object($where)) $where = new AndJoin($where);
			$factors[] = $where;
			if($irrelevant)
				$factors[] = new NotLogic($irrelevant);
			if(!$show_deleted && ($w=$model->getDeletedWhere())){
				$factors[] = new NotLogic($w);
			}
			$where = new AndJoin($factors);

			$tableName = $model->getTableName();
			$tableRef = $model->pluralize($tableName);
			$tables = $orig_tables = "`$tableName` AS `$tableRef`";
			foreach($params['includeTables'] as $table){
				$model->includeTable("$table.uid",$tables);
			}
			if(!$where) $where="1=1";
			if(is_array($where)){
				switch($params['whereJoin']){
				case 'OR':
					$param = new OrJoin($where);
					break;
				case 'AND': default:
					$param = new AndJoin($where);
				}
				$where = $param->restrict($model,$tables,$params);
			} elseif(is_object($where)){
				$where = $where->restrict($model,$tables,$params);
			}
			if($single) $limit=1;


			$limitText='';
			if($limit) {
				$limitText = " LIMIT ";
				if($offset) $limitText.=$offset.", ";
				$limitText.="$limit";
			}
			if($params['order'] && !@$params['order_explicit']){
				if(!is_array($order)){
					$order = array($order);
				}
				$combined=array();
				foreach($order as $order){
					@list($field,$dir) = explode(" ",$order);
					$field = $this->includeTable($model,$field,$tables);
					$combined[] = "$field $dir";
				}
				$order = join(",",$combined);
			}
			$model->useDB();
			$id = $model->getIDField();
			$group = ( ($tables!=$orig_tables) && $id)  ? " GROUP BY $tableRef.$id" : "";
			$mod = $single ? "" : "SQL_CALC_FOUND_ROWS";
			if($params['debug']) var_dump($params);
			if($order) $order = "ORDER BY $order";
			$q = mysql_query($sql = "SELECT $mod $tableRef.* FROM $tables WHERE $where $group $order $limitText");
			if($params['debug']){
				echo "<li>$sql</li>";
				error_log($sql);
			}
			@$GLOBALS['SQL']++;
			
			if($model->debug) echo("<hr/>$sql");
			
			$e = mysql_error();
			//var_dump($sql);
			$model->unuseDB();
			if($e){
				throw new DBException ($e." in ".$sql);
			}
			return $this->wrapResult($model,$q,$params);
		}
		function includeTable($mobj,$field,&$tables,$value=null){
			static $trans;
			$origField = $field;
			@list($table,$field) = explode(".",$field,2);
			$tableName = $mobj->getTableName();
			$tableRef = $mobj->pluralize($tableName);
			if(@$trans){
				$tableRef=$trans[count($trans)-1];
			}
			if(!$field){
				return "`$tableRef`.`$origField`";
			}

			$otable = $table;
			$ref = $mobj->pluralize($table);
			$trans[] = $ref;
			if(@preg_match("/`($table|$ref)`/",$tables)){
				if($rel = @$mobj->loadRel(strtolower($table))){
					$model = $rel['model'];
					$where=$mobj->$model->specialWhere($field,$value);
					if($where !== false){
						if(is_array($where)){
							$where = new AndJoin($where);
						}

						$where = $where->rebase(strtolower($table));
						$field = $where;
					} else {
						if(!$mobj2 = @$mobj->$model){
							$mobj2=Model::loadModel($model);
						}
						$field = $mobj2->includeTable($field,$tables,$value);
					}
				} else {
					$field = $mobj->includeTable($field,$tables,$value);
				}
			} elseif(@$field && ($table!=$tableName)){
				if(($rel = @$mobj->loadRel(strtolower($table)))||
					($rel = @$mobj->loadRel(strtolower($mobj->pluralize($table))))){
					$table = $mobj->unpluralize($table);
					extract($rel,EXTR_SKIP);
					$where=$mobj->$model->specialWhere($field,$value);
					if($where !== false){
						if(is_array($where)){
							$where = new AndJoin($where);
						}

						$where = $where->rebase(strtolower($otable));
						$field = $where;
					} else {
					switch($rel['type']){
					case __REL_BELONGS_TO__:
						$tables.=" LEFT JOIN `$rel[table]` `$ref` ON `$tableRef`.`$rel[field]`=`$ref`.`$rel[ref_field]`";
						$field = $mobj->$model->includeTable($field,$tables,$value);
						break;
					case __REL_MM__:
						$tables.=" LEFT JOIN `$rel[table]` ON `$tableRef`.`$rel[my_ref_field]`=`$rel[table]`.`$rel[local_id]`";
						$for = $mobj->$model->getTableName();
						$ref = $mobj->pluralize($table);
						$forId =$mobj->$model->getIDField();
						$tables.=" LEFT JOIN `$for` `$ref` ON `$ref`.`$forId`=`$rel[table]`.`$rel[foreign_id]`";
						$field = $mobj->$model->includeTable($field,$tables,$value);
						break;
					case __REL_HAS_MANY__:
						$ref = $mobj->pluralize($table);
						$trans[] = $ref;
						$tables.=" LEFT JOIN `$rel[table]` `$ref` ON `$tableRef`.`$rel[field]`=`$ref`.`$rel[ref_field]`";
						$field = $mobj->$model->includeTable($field,$tables,$value);
						array_pop($trans);
						break;
					case __REL_EXTERNAL__:
						$field = $rel['manager']->includeTable($field,$tables,$value,$table);
					}
					}
				} else {
					$tables.=" JOIN `$table` ON `$tableRef`.`$table".$mobj->getIDField()."`=`$table`.`".$mobj->getIDField()."`";
					$field = $mobj->includeTable($field,$tables,$value);
				}
				$mobj->included[$table] = $mobj->included[$otable] = true;
			} else {
				$ref = $mobj->pluralize($table);
				if($field)
					$field = "`$ref`.`$field`";
				else
					$field="`$tableRef`.`$origField`";
			}
			array_pop($trans);
			return $field;
		}
		function exists($model){
			$id = $model->getID();
			return $model->origObj && $id && (strpos($id,'NEW')!==0);
		}
		function fetch_data($q){
			return mysql_fetch_object($q);
		}
		function free_result($q){
			mysql_free_result($q);
		}
		function listFields($model){
			if(is_object($model)) $model = $model->getTableName();
			$q = mysql_query("DESCRIBE ".$model);
			$fields = array();
			if($q)
			while($r = mysql_fetch_assoc($q)){
				$fields[$r['Field']] = $this->mapTypeFromSQL($r['Type'],$r['Field']);
			}
			return $fields;
		}
		function createTable($model){
			if(is_object($model)) $model = $model->getTableName();
			mysql_query("CREATE TABLE `$model` (uid int(11) auto_increment primary key)");
		}
		function clearTable($model){
			if(is_object($model)) $model = $model->getTableName();
			mysql_query("TRUNCATe `$model`");
		}
		function createFields($model,$fields){
			if(is_object($model)) $model = $model->getTableName();
			$existing = $this->listFields($model);
			$alter = array();

			foreach($fields as $k=>$v){
				$spec = @$existing[$k] ? "CHANGE `$k` " : "ADD ";
				$spec.=" `$k` ".$this->mapTypeToSQL($v,$k);
				$alter[] =$spec;
			}
			mysql_query($sql = "ALTER TABLE ".$model." ".join(", ",$alter));
			var_dump($sql);
		}
		function getIndexes($model){
			if(is_object($model)) $model = $model->getTableName();
			$q = mysql_query("SHOW INDEX FROM ".$model);
			$indexes = array();
			while($r = mysql_fetch_assoc($q)){
				$indexes[] = explode(",",$r['Column_name']);
			}
			return $indexes;
		}
		function createIndex($model,$fields){
			mysql_query($sql = "ALTER TABLE ".$model->getTableName()." ADD INDEX (".join(",",$fields).")");
			var_dump($sql);
		}
		function mapTypeToSQL($type,$name){
			$types = array(
				"int"=>"int(11)",
				"bool"=>"bool not NULL",
				"string"=>"varchar(255)",
				"text"=>"text",
				"data"=>"longblob",
				"float"=>"float",
				"datetime"=>"datetime",
			);
			if(is_string($type) && @$types[$type]) return $types[$type];
			if(is_array($type)){
				return "enum ('".join("','",array_map('mysql_escape_string',$type))."')";
			}
			if(preg_match("/decimal([\d]*)\.([\d*])/",$type,$matches)){
				@list($full,$pre,$post) = $matches;
				if(!$pre) $pre=10;
				if(!$post) $post=2;
				return "decimal($pre,$post)";
			}
			var_dump($type);
		}
		function mapTypeFromSQL($type,$name){
			preg_match("/([^\(]*)(?:\((.*)\))?/",$type,$matches);
			switch($matches[1]){
			case 'int':
				return 'int';
			case 'tinyint':
				return 'bool';
			case 'varchar':
			case 'tinytext':
				return 'string';
			case 'text':
				return 'text';
			case 'float':
				return 'float';
			case 'longblob':
				return 'data';
			case 'enum':
				$options = explode("','",substr($matches[2],1,-1));
				if($options==array("","1")) return "oldbool";
				return $options;
			case 'decimal':
				if(preg_match("/^([\d]+),([\d]+)$/",$matches[2],$sub)){
					list($full,$pre,$post) = $sub;
					if($pre==10) $pre='';
					if($post)$post=".$post";
					return "decimal$pre$post";
				}
				die("$type ($matches[2]) doesn't match decimal pattern");
			}
			return $type;
		}
	}
	class MySQLFetcher extends Fetcher {
		function __construct($query,$model){
			parent::__construct();
			$this->lastGet=$query;
			$this->model=$model;
		}
		function fetch(){
			if(!$this->lastGet['q']) return false;
			extract($this->lastGet);
			if($r = mysql_fetch_object($q)){
				return $this->createFor($class,$r,$isModel);
			} else {
				$this->free();
				return false;
			}
		}
		function createFor($class,$r,$isModel){
			return $this->model->create($class,$r,$isModel?$this->model->getTableName():false);
		}
		function free(){
			if($this->lastGet['q']){
				mysql_free_result($this->lastGet['q']);
				$this->lastGet['q']=false;
			}
		}
		function numResults(){
			return $this->lastGet['found'];
		}

	}
?>
