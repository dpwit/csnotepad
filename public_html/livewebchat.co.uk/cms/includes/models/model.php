<?
/**
 * @package Model_System
 */


	if(!function_exists('cms_register_filter')){
		require_once(dirname(__FILE__).'/hooks.php');
	}

	define('__REL_BELONGS_TO__',1);
	define('__REL_HAS_ONE__',1);
	define('__REL_HAS_MANY__',2);
	define('__REL_MM__',3);
	define('__REL_EXTERNAL__',4);
	define('__MODELS_BASE__',dirname(__FILE__));

	abstract class Fetcher extends BaseModel {
		abstract function fetch();
		abstract function free();
		abstract function numResults();
	}
	class ListFetcher extends Fetcher {
		function __construct($list,$numResults=false){
			parent::__construct();
			$this->list = $list;
			if(!$numResults) $numResults = count($this->list);
			$this->numResults = $numResults;
		}
		function numResults(){
			return $this->numResults;
		}
		function fetch(){
			return array_pop($this->list);
		}
		function free(){
			unset($this->list);
		}
	}
	class MultiFetcher extends Fetcher {
		var $fetchers = array(), $total=0;
		var $current = null;

		function __construct($fetchers = array()){
			foreach($fetchers as $fetcher){
				$this->add($fetcher);
			}
		}
		function add($fetcher){
			$this->fetchers[] = $fetcher;
			$this->total+=$fetcher->numResults();
		}
		function fetch(){
			if(!$this->current){
				if(!$this->fetchers) return false;
				$this->current = array_shift($this->fetchers);
				if(!$this->current) return false;
				return $this->fetch();
			}
			$fetch = $this->current->fetch();
			if($fetch) return $fetch;
			$this->current->free();
			$this->current=null;
			return $this->fetch();
		}
		function free(){
			foreach($this->fetchers as $f) $f->free();
			unset($this->fetchers);
		}
		function numResults(){
			return $this->total;
		}
	}

	class ModelException extends Exception{}
	class BadRelationShipException extends ModelException{}

	require_once(dirname(__FILE__).'/auto_create_model.php');
	require_once(dirname(__FILE__).'/query/base.php');
	class MyModel extends AutoCreateModel {
		var $fields = false;
		var $explicitFields = array();
		var $relationships = array(), $custom=array();
		static $idField = 'uid';
		var $labelField = 'name';
		var $slugField = false;
		var $uid=null;
		var $spaceCharacter='-';
		var $destroyed = false;

		function __destroy(){
			if(is_array(@$this->relationships))
			foreach($this->relationships as $k=>$v){
				if(is_object(@$v['manager']) && is_callable($v['manager'],'__destroy')){
					$v['manager']->__destroy();
				}
			}
			foreach(get_object_vars($this) as $k=>$v){
				unset($this->$k);
			}
			$this->destroyed = true;
		}
		function destroy(){
			foreach(func_get_args() as $obj){
				if(is_array($obj)){
					call_user_func_array(array($this,'destroy'),$obj);
				} elseif(is_object($obj)){
					$obj->__destroy();
				}
			}
		}

		function __construct($obj=null,$table=false,$params=array()){
			parent::__construct($obj,$table);
			$this->debug = false;
			$this->origObj = $obj;
			if($obj){
				foreach($obj as $k=>$v){
					$this->$k=$v;
				}
			}
			if(!$table){
				$table = strtolower(get_class($this));
				$table = preg_replace('/_?model$/','',$table);
			}
			$this->table = $table;
			$this->spaceCharacter = '-';
			$this->setParams($params);
			$this->triggerAction('model_instantiated');
			if($obj){
				$this->prepareInstance();
			}
		}


		function &__get($k){
			if(@$this->relationships[$k]){
				$rel = $this->loadRel($k);
				$this->compositionReady=true;
				if(@$rel['composition']){
					$this->prepareComposition($k);
				}
			} 
			return $this->$k;
		}

		function manager($rel){
			$rel = $this->loadRel($rel);
			return $rel['manager'];
		}
		function engine(){
			if(!@$this->engine){
				static $defaultEngine;
				if(!$defaultEngine) $defaultEngine = $this->applyFilters('db_engine',MySQLEngine::getInstance());
				$this->engine = $defaultEngine;
			}
			return $this->engine;
		}

		function prepareInstance($force=false){
			$this->triggerAction('instance_prepared');
		}

		function setTable($table){
			$this->table = $table;
		}

		function setParams($params){
			$this->params = $params;
		}
		function param($key,$default=null){
			if(!is_array($this->params)) $this->params=array();
			if(array_key_exists($key,$this->params)) return $this->params[$key];
			else return $default;
		}

		static $specialCases; 
		static function initSpecialCases(){
			self::$specialCases = cms_apply_filter('cms_pluralization_special_cases',array('status'=>'statuses'));
			self::$revCases = array_flip(self::$specialCases);
		}
		static $revCases = null;
		static function pluralize($key){
			static $plurals = array();
			if(!@$plurals[$key]){
				$word=$key;
				$sections = explode("_",$word);
				$last = array_pop($sections);
				if(!self::$specialCases) self::initSpecialCases();
				if(isset(self::$specialCases[$last])) return substr($word,0,-strlen($last)).self::$specialCases[$last];
				else {
					if(substr($word,-1)=='y') $word = substr($word,0,-1).'ie';
					if(substr($word,-1)!='s') $word.='s';
				}
				$plurals[$key]=$word;
			}
			return $plurals[$key];
		}
		static function unpluralize($key){
			static $plurals = array();
			if(!@$plurals[$key]){
				$word=$key;
				if(strtolower($word)=='news') return $word;
				$sections = explode("_",$word);
				$last = array_pop($sections);
				if(!self::$specialCases) self::initSpecialCases();

				if(isset(self::$revCases[$last])) return substr($word,0,-strlen($last)).self::$revCases[$last];
				else if(substr($word,-3)=='ies') $word = substr($word,0,-3).'y';
				else if(substr($word,-1)=='s') $word=substr($word,0,-1);
				$plurals[$key]=$word;
			}
			return $plurals[$key];
		}

		function createNew($values=array()){
			$class = $this->applyFilters('new_class',get_class($this),$values);
			$o = new $class(null,$this->getTableName(false));
			$f = $o->getIDField();
			if($f){
				$o->$f='NEW';
			}
			foreach($values as $k=>$v){
				$o->$k = $v;
			}
			$o->prepareInstance(true);

			//foreach($o->getFields() as $f) $f->prepare($o,$values);
			return $o;
		}
		function createCopy($write = true){
			$obj = $this->createNew();
			foreach($obj->getFields() as $field){
				$field->copyFrom($this,$obj);
			}
			$obj->callManagers('copy_from',array($this));
			$obj->triggerAction('model_copied',$this);
			if($write)
				$obj->writeToDB($obj);
			return $obj;
		}

		function getLabel(){
			$labelField = $this->getLabelField();
			return @$this->$labelField;
		}
		function getOutOfContextLabel(){
			return $this->getLabel();
		}
		function getLabelAsURL(){
			$urlfield = $this->getURLField();
			return $this->urlEncode(@$this->$urlfield);
		}
		function getByLabel($label,$where=array(),$params=array()){
			$where[$this->getLabelField()] = $label;
			return $this->geTAll($where,$params);
		}
		function getURLField(){
			return $this->slugField ? $this->slugField : $this->getLabelField();
		}

		function urlDecode($string){
			return str_replace($this->spaceCharacter," ",urldecode($string));
		}

		function urlEncode($string,$safe=true){
			if(!@$this->spaceCharacter) $this->spaceCharacter='-';
			$url = strtolower(str_replace(" ",$this->spaceCharacter,$string));
			if($safe)
				$url = preg_replace("/[^-%_a-zA-Z0-9]/","",$url);
			return urlencode($url);
		}

		function getSlug(){
			return $this->getLabelAsUrl();
		}
		function getURL(){
			return $this->applyFilters('geturl',$this->getUrlPrefix().$this->getSlug());
		}
		function getUrlPrefix(){
			$prefix='';
			if(@$this->prefix) $prefix.="$this->prefix/";
			if(@$this->parent) $prefix.=$this->parent->getURL()."/";
			if($prefix) $prefix='/'.$prefix;
			return $prefix;
		}
		function getByUrl($url,$restrict=array(),$params=array()){
			if(@$this->prefix){
				if(strpos($url,$this->prefix)!=1){
					return;
				} 
				$url = substr($url,strlen($this->prefix)+1);
			}
			return $this->getBySlug($url,$restrict,$params);
		}
		function getBySlug($url,$restrict=array(),$params=array()){
			$parts = explode("/",$url);
			$restrict = array_merge($restrict,$this->urlRestrict($parts));

			// TODO:Should find parent item here...  Maybe the same content shows up in different places??

			$params['single']=1;
			if(!array_key_exists('visible',$restrict)) $restrict['visible']=1;
			return $this->getAll($restrict,$params);
		}
		function urlRestrict($parts){
			$slug = array_pop($parts);
			if(!$this->slugField) $slug = $this->urlDecode($slug);
			return array($this->getUrlField()=>$slug);
		}
		function getDescription(){
			if(@$this->short_text) return $this->short_text;
			else return $this->getLabel();
		}
		function getLabelField(){
			return $this->labelField;
		}

		function hasRel($func){
			return array_key_exists($func,$this->relationships) || array_key_exists($func,$this->custom);
		}
		function loadRel($func){
			if(!array_key_exists($func,$this->relationships)){
				trigger_error("Attempting to use non-existent relationship '$func' in '".get_class($this)."/".$this->getTableName()."' (available relationships: ".join(",",array_keys($this->relationships)).")");
				return false;
			}
			$rel = $this->relationships[$func];
			
			if(@$rel['loaded']) {
				$this->prepareComposition($func);
				$rel = $this->relationships[$func];
				if(@$rel['loaded']) {
					return $rel;
				}
			}
			$model = @$rel['model'];
			if(!$model){
				switch(@$rel['type']){
					case __REL_HAS_MANY__:
					case __REL_MM__:
						$model=$this->unpluralize($func);
						break;
					default:
						if(@$rel['plural']){
							$model = $this->unpluralize($func);
						} else {
							$model= $func;
						}
				}
				$rel['model'] = $model;
			}
			switch(@$rel['type']){
			case __REL_EXTERNAL__: break;
			default:
				$this->$model = $this->loadModel($model,true);
			}
			$defaults = array(
				'additionalWhere'=>array(),
				'name'=>ucwords(str_replace("_"," ",$func)),
			);
			switch(@$rel['type']){
			case __REL_BELONGS_TO__:
				$defaults['ref_field'] = $this->$model->getIDField();
				$defaults['table'] = $this->$model->getTableName();
				$defaults['label'] = ucwords(str_replace("_"," ",$func));
				break;
			case __REL_HAS_MANY__:
				$defaults['ref_field'] = $this->getTablename(false)."_".$this->$model->getIDField();
				$defaults['table'] = $this->$model->getTableName();
				$defaults['label'] = ucwords(str_replace("_"," ",$func));
				break;
			case __REL_MM__:
				$defaults['ref_field'] = $this->$model->getIDField();
				$defaults['my_ref_field'] = $this->getIDField();
				$defaults['foreign_id'] = $this->$model->getTableName(false).'_'.$this->$model->getIDField();
				$defaults['local_id'] = $this->getTableName(false).'_'.$this->getIDField();
				$defaults['mm_model'] = 'MMModel';
				break;
			case __REL_EXTERNAL__:
			}
			foreach($defaults as $k=>$v)
				if((!isset($rel[$k]))||$rel[$k]==false) $rel[$k]=$v;
			$this->relationships[$func] = $rel;
			if(is_string(@$rel['manager'])){
				list($file,$class) = explode(":",$rel['manager']);
				require_once($file);
				$rel['manager']=new $class($func,$rel,$this);
				$rel['manager']->on_init();
			}
			$rel['loaded']=true;
			$this->relationships[$func] = $rel;
			if(@$rel['composition']) {
				$this->prepareComposition($func);
			}
			return $this->relationships[$func];
		}
		function __call($func,$args){
			return $this->__getRelated($func,$args);
		}
		function getRelated(){
			$args = func_get_args();
			$func = array_shift($args);
			return $this->__getRelated($func,$args);
		}
		function __getRelated($func,$args){
			@list($where,$params) = $args;
			$defaults = array('limit'=>null,'offset'=>null,'whereJoin'=>'AND','for_fetch'=>false,'single'=>false,'no_cache'=>false);
			$params = is_array($params) ? array_merge($defaults,$params) : $defaults;
			$cacheKey = strtolower(get_class($this)."-".$this->getID()."-").$func."-".serialize($args);
			if(!($params['no_cache'] || $params['for_fetch'])){
				$res = $this->cacheGet($cacheKey);
				if($res) return $res;
			}

			if(@$this->relationships[$func] || @$this->relationships[$func = strtolower($func)]){
				$rel = $this->relationships[$func];
				$rel= $this->loadRel($func);
				extract($rel);
				switch($type){
				case __REL_BELONGS_TO__:
					if($rel['composition']) return $this->$func;
					$where[$ref_field]=@$this->$field;
					if($this->$model)
						$remotes = $this->$model->getAll($where,$params);
					switch(count($remotes)){
					 case 1: $remotes=$remotes[0];break;
					 case 0: $remotes=false; break;
					 default: 
					}
					return $this->cachePut($cacheKey,$remotes);
					break;
				case __REL_HAS_MANY__:
					if(!$where) $where = array();
					if(!$params) $params = array();
					$myWhere = $additionalWhere;
					$myWhere[$ref_field]=$this->$field;
					if($this->$field=='NEW') return $params['for_fetch'] ? new ListFetcher(array()):array();
					if(is_array($where)){
						$where = array_merge($where,$myWhere);
					} else {
						$myWhere[] = $where;
						$where = new AndJoin($myWhere);
					}

					// This should have been handled already in loadRel, need to find out why that is not
					//happening for product variations / StockByAttributeField
					if(!$this->$model) $this->$model = Model::loadModel($model);
					$remotes = $this->$model->__getAll($where,$params);
					$this->cachePut($cacheKey,$remotes);
					return $remotes;
					break;
				case __REL_MM__:
					if($rel['manager'])
						return call_user_func_array(array($rel['manager'],'fetch'),$args);
					$idField = $this->getIDField();
					if(isset($order)){
						$order = "ORDER BY $order";
					} else {
						$order='';
					}
					$limit = '';
					if($lim = $params['limit']){
						if($skip = $params['offset']){
							$limit=" LIMIT $skip,$lim";
						}
					}
					$q = mysql_query($sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $table WHERE $local_id='".$this->$ref_field."' $order $limit");
					if($params['for_fetch']){
						$lastCount = mysql_result(mysql_query("SELECT FOUND_ROWS()"),0);
					}

					$results = array();
					if($e = mysql_error()){
						trigger_error("Problem in MM Configuration '$e'");
					} else {
						// This negates the point of the for fetch parameter, but makes the logic simpler
						//TODO: Fix this or move it out to manager class
						if($order){
							while($r = mysql_fetch_object($q)){
								$r->table = $table;
								$r->function = $func;
								if($found = $this->$model->get($r->$foreign_id)) {
									if(@$found->mm) $found = clone($found);
									$found->mm = $r;
									$results[] = $found;
								}
							}
						} else {
							$temp = array();
							while($r = mysql_fetch_object($q)){
								$r->table = $table;
								$r->function = $func;
								$temp[$r->$foreign_id] = $r;
							}

							$results = $this->$model->getAll(array($this->$model->getIDField().' in'=>array_keys($temp)));
							foreach($results as $r){
								$r->mm = $temp[$r->getId()];
							}
						}
					}
					if($this->canCache())
						$this->cachePut($cacheKey,$results);
					if($params['for_fetch']) return new ListFetcher($results,count($results));
					return $results;
					break;
				case __REL_EXTERNAL__:
				
					return call_user_func_array(array($rel['manager'],'fetch'),$args);
				default:
					throw new BadRelationshipException("Unknown relationship type '$func'");
				}
			} elseif($f = @$this->custom[$func]) {
				array_unshift($args,$this);
				foreach(array_reverse($f['args']) as $v){
					array_unshift($args,$v);
				}
				return call_user_func_array($f['fn'],$args);
			} else {
				throw new BadRelationshipException("No Such Method '".get_class($this)."'->'$func'\n Available relationships: ".join(", ",array_keys($this->relationships)));
			}
		}

		function hasMM($name,$params=array()){
			$item = preg_replace('/^x_/','',$name);
			$stripped = $this->unpluralize($name);
			$model = $this->defaultModelClass($stripped);

			$table = $this->getTableName(false);
			$stripped = preg_replace('/s$/','',$name);

			$this->relationships[$name] = $params;
			$defaults = array(
				'local_id'=>false,
				'foreign_id'=>false,
				'table'=>$this->getTableName(true).'_mm_'.$name,
				'ref_field'=>false,
				'model'=>$model,
				'composition'=>false,
				"manager"=>dirname(__FILE__).'/relationships/MMManager.php:'.(@$params['order']?'SortedMMManager':'BasicMMManager'),
			);
			$params = array_merge($defaults,$params);

			$params['type'] = __REL_MM__;

			$model = $params['model'];
			$this->relationships[$name] = $params;

			if($params['composition']) $this->prepareComposition($name);
		}

		var $compositionReady = false;
		var $preparedComposition = array();
		function prepareComposition($name,$force=false){
			if(!$this->compositionReady) return;
			if(@$this->preparedComposition[$name]) return;
			$params = $this->relationships[$name];
			if(!$params['composition']) return;
			if(!@$params['loaded']) $params = $this->loadRel($name);
			switch(@$params['type']){
			case __REL_MM__:
				unset($params['loaded']);
				$defaults = array(
					"input"=>dirname(__FILE__).'/fields/MMInput.php:BasicMMInput',
				);
				$params = array_merge($defaults,$params);
				$this->relationships[$name]['plural']=true;
				unset($this->preparedComposition[$name]);
				$this->hasRelationship($name,$params);
				break;
			case __REL_BELONGS_TO__:
				unset($params['loaded']);
				$defaults = array(
					"manager"=>dirname(__FILE__).'/relationships/CompositionManager.php:BelongsCompositionManager',
				);
				$params = array_merge($defaults,$params);
				unset($this->preparedComposition[$name]);
				$this->hasRelationship($name,$params);
				break;
			case __REL_HAS_MANY__:
				unset($params['loaded']);
				$defaults = array(
					"manager"=>dirname(__FILE__).'/relationships/CompositionManager.php:ManyCompositionManager',
				);
				$params = array_merge($defaults,$params);
				unset($this->preparedComposition[$name]);
				$this->hasRelationship($name,$params);
				break;
			}
		}
		function hasOne($name,$params=array()){
			$item = preg_replace('/^x_/','',$name);

			$model = $this->defaultModelClass($name);

			$defaults = array(
				'field'=>$item.'_'.$this->getIDField(),
				'table'=>false,
				'ref_field'=>false, //Should be other
				'model'=>$model,
				'composition'=>false,
			);
			$params = array_merge($defaults,$params);

			$params['type'] = __REL_BELONGS_TO__;

			$this->relationships[$name] = $params;
			if($params['composition']) $this->prepareComposition($name);
		}
		function hasMany($name,$params = array()){
			$item = preg_replace('/^x_/','',$this->getTableName(false));
			$stripped = $this->unpluralize($name);
			$model = $this->defaultModelClass($stripped);
			$defaults = array(
				'field'=>$this->getIDField(),
				'table'=>false,
				'ref_field'=>false,
				'composition'=>false,
				'model'=>$model,
			);
			if(!@$params['composition'])
				$defaults["manager"]=dirname(__FILE__).'/relationships/ManyManager.php:ManyManager';
			$params = array_merge($defaults,$params);
			$params['type'] = __REL_HAS_MANY__;

			$this->relationships[$name] = $params;
			if($params['composition']) $this->prepareComposition($name);
		}

		function loadComposition($name){
			$rel = $this->loadRel($name);
			switch($rel['type']){
			case __REL_MM__:
				if(!$this->exists()) return;
				$mm = Model::loadModel($rel['mm_model']);
				$mm->setRelationship($name,$rel);
				if($this->exists())
					$this->$name = $mm->getAll(array($rel['local_id']=>$this->getId()));
				break;
			case __REL_EXTERNAL__:
				call_user_func_array(array($rel['manager'],'composition'),array());
				break;
			case __REL_BELONGS_TO__:
				$instance = $this->getRelated($name);
				if(!$instance) $instance = Model::loadModel($rel['model'])->createNew();
				$this->$name = $instance;
				break;
			case __REL_HAS_MANY__:
				$this->$name = $this->getRelated($name);
				break;
			}
		}
		function hasCustom($name,$callback,$args =array()){
			$this->custom[strtolower($name)] = array('fn'=>$callback,'args'=>$args);
		}
		function hasFile($field,$params=array()){
			$defaults = array(
				"manager"=>dirname(__FILE__).'/relationships/FileManagers.php:BasicFileManager',
				"input"=>dirname(__FILE__).'/fields/FileUpload.php:BasicFileInput',
			);
			if(@$params['file_type']=='img'){
				$defaults["manager"]=dirname(__FILE__).'/relationships/ImageManagers.php:ImageFileManager';
				$defaults["input"]=dirname(__FILE__).'/fields/FileUpload.php:ImagePreviewFileInput';
			}
			$this->hasRelationship($field,array_merge($defaults,$params));
		}
		function hasExternal($field,$params=array()){
			$this->hasRelationship($field,$params);
		}
		function hasRelationship($field,$params=array()){
			$defaults = array(
				"type"=>__REL_EXTERNAL__,
				'composition'=>false,
			);
			$params['type'] = __REL_EXTERNAL__;
			$this->relationships[$field] = $params = array_merge($defaults,$params);
			if($params['composition']){
				$this->loadComposition($field);
			} 
			$params = $this->relationships[$field];
			if(is_string(@$params['manager'])){
				list($file,$class) = explode(":",$params['manager']);
				require_once($file);
				$params['manager']=new $class($field,$params,$this);
			}
			if(@$params['manager']){
				$params = $params['manager']->initRel($params);
			}
			$this->relationships[$field] = $params;
		}
		/** Allows shortcuts to be specified, whereby indirect relations can be fetched.
		 * Not 100% Working Yet.
		 */
		function hasThrough($relation,$throughRelation,$params=array()){
			$defaults = array(
				'through'=>$throughRelation,
				'manager'=>dirname(__FILE__).'/relationships/ThroughManager.php:ThroughManager'
			);
			$params = array_merge($defaults,$params);
			$this->hasRelationship($relation,$params);
		}

		function createInstance($obj){
			$class = get_class($this);
			return new $class($obj);
		}

		function getTableName($plural = true){
			$tableName = $this->table;
			if($plural) $tableName=$this->pluralize($tableName);
			return $tableName;
		}
		function getModelName($plural=true){
			$class = get_class($this);
			if(in_array($class,array('MyModel'))){
				return $this->getTableName($plural);
			}
			return parent::getModelName($plural);
		}

		function getEnglishName($plural = true){
			$table = $this->getTableName($plural);
			return $this->variableToEnglish($table);
		}
		function variableToEnglish($table){
			$class = ucwords(str_replace('_',' ',$table));
			$class = preg_replace("/([^ ])([A-Z])/","\$1 \$2",$class);
			return $class;
		}

		function getIDField(){
			return self::$idField;
		}
		function getID(){
			$field = $this->getIDField();
			if(property_exists($this,$field)) return $this->$field;
		}
		function setID($id){
			$field = $this->getIDField();
			$this->$field = $id;
		}
		function exists(){
			return $this->engine()->exists($this);
		}
		function get($id,$params=array()){
			if((!@$params['no_cache']) && ($obj = self::cacheGet(strtolower(get_class($this))."-".$id))) return $obj;
			$tableName = $this->getTableName();
			return $this->getFirst(array($this->getIDField()=>$id),$params);
		}
		function getVisible($where=array(),$params=array()){
			$where = array_merge($this->getVisibleWhere(),$where);
			return $this->__getAll($where,$params);
		}
		function getVisibleWhere(){
			return array();
		}
		function specialWhere($k,$v){
			switch($k){
			case 'visible':
				if($v) return $this->getVisibleWhere();
				else return array();
			case 'like':
				return $this->getLikeWhere($v);
			}
			return $this->applyFilters('special_where',false,$k,$v);
			return false;
		}

		function getLikeWhere($query){
			$query = explode(" ",$query);
			$query = $this->applyFilters('like_query_preprocess',$query);
			$textFields = $this->getTextFields();
			$where = array();
			foreach($query as $v){
				$q = array();
				foreach($textFields as $t){
					$q["$t like"] = "%$v%";
				}
				$where[] = new OrJoin($q);
			}
			return $where;
		}
		function getDeletedWhere(){
			return array();
		}
		function getIrrelevantWhere(){
			return array();
		}
		function getFirst($where=array(),$params=array()){
			$cacheKey = 'getFirst-'.get_class($this).'-'.serialize($where).serialize($params);
			if(!@$params['no_cache']){
				$res = self::cacheGet($cacheKey);

				if($res) return $res;
			}

			$params['limit'] = 1;
			$params['single'] = 1;

			$res = $this->__getAll($where,$params);

			return $this->cachePut($cacheKey,$res);
		}

		function getDefaultOrder(){
			return false;
		}

		/** Used internally to allow automatic joining by way of using the relationships.
		 */
		function includeTable($field,&$tables,$value=null){
			return $this->engine()->includeTable($this,$field,$tables,$value);
		}
		function getAll($where = array(),$params=array()){
			$res=null;
			cms_trigger_action('model_listed',$this);
			$key = $this->getModelName()."->getAll-".serialize(array($where,$params));
			if(!(@$params['for_fetch'] || @$params['no_cache']))
				$res = $this->cacheGet($key);
			if(!$res){
				$res = $this->__getAll($where,$params);
				if(!(@$params['for_fetch'] || @$params['no_cache']))
					$this->cachePut($key,$res);
			} else {
				if(@$params['debug']) echo "GOT CACHED $key\n";
			}
			return $res;
		}
		/* This could be massively optimised when the cassandra branch is merged
		 * in with it's php evaluation of where parameters.
		 */
		function matchesQuery($where=array(),$params=array()){
			$params['show_deleted']=1;
			$where['uid'] = $this->getId();
			return $this->getFirst($where,$params);
		}
		function useDB($use=true){
			static $old = array();
			if($db = $this->param('db','__MYSQL_NAME__')){
				if($use){
					$cur = mysql_result(mysql_query("SELECT DATABASE()"),0);
					if($cur!=$db){
						array_push($old,$cur);
						mysql_query("USE $db");
					} else {
						array_push($old,false);
					}
				} else {
					if($db = array_pop($old))
						mysql_query("USE $db");
				}
			}
		}
		function unuseDB(){
			$this->useDB(false);
		}
		function __getAll($where = array(),$params=array()){
			return $this->engine()->getAll($this,$where,$params);
		}
		function wrapResult($rawResource,$params){
			return $this->engine()->wrapResult($this,$rawResource,$params);
		}
		function fetch(){
			if(!$this->lastGet) return false;
			extract($this->lastGet);
			if(!isset($this->lastGet['peek'])){
				$this->lastGet['peek'] = $this->engine()->fetch_data($q);
			}
			if($r = $this->lastGet['peek']){
				$this->lastGet['peek'] = $this->engine()->fetch_data($q);
				if(!$this->lastGet['peek']) {
					$this->engine()->free_result($q);
					$this->lastGet=false;
				}
				return $this->create($class,$r,$isModel?$this->getTableName(false):false);
			}
			$this->lastGet=false;
			return false;
		}

		function countMatching($where=array(),$params=array()){
			return $this->engine()->count($this,$where,$params);
		}
		static $maxCachedModels=100;
		static $cachedModels = array();
		static $cacheDisabled = false;

		static function disableCache(){
			self::$cacheDisabled++;
		}
		static function enableCache(){
			if(self::$cacheDisabled) self::$cacheDisabled--;
		}
		static function canCache(){
			return defined('FE')&&!self::$cacheDisabled;
		}
		function cachePut($key,$obj){
			if(!$this->canCache()) return $obj;
			if(count(self::$cachedModels)>self::$maxCachedModels){
				array_shift(self::$cachedModels);
			}
			self::$cachedModels[$key] = $obj;
			return $obj;
		}
		function cacheGet($key){
			if(!$this->canCache()) return null;
			if(isset(self::$cachedModels[$key])) {
				$obj = self::$cachedModels[$key];
				self::$cachedModels[$key]=$obj;
				if(is_array($obj)){
					$valid = true;
					foreach($obj as $k=>$v){
						if($v->destroyed) $valid=false;
					}
					if($valid) return $obj;
				} else {
					if(!@$obj->destroyed)
						return $obj;
				}
				unset(self::$cachedModels[$key]);
			}
		}
		static function cacheClear($key){
			unset(self::$cachedModels[$key]);
		}
		function on_model_saved(){
			self::$cachedModels = array();
		}
		function create($class,$record,$table=false){
			if($this->canCache($class,$record,$table)){
				$idField = $this->getIDField();
				$key = @strtolower("$class-$table-".$record->$idField);
				if($obj = $this->cacheGet($key)) return $obj;
				return $this->cachePut($key,MyModel::createUnCached($class,$record,$table));
			} else {
				return MyModel::createUnCached($class,$record,$table);
			}
		}
		function createUnCached($class,$record,$table=false){
			$class = $this->applyFilters('create_class',$class,$record,$table);
			if(Factory::hasMapping($key = "model_$class")){
				$class = Model::loadModel($class);
				$class = get_class($class);
			}
			if($table){
				return new $class($record,$table);
			} else {
				return new $class($record);
			}
		}


		function numResults(){
			return $this->lastCount;
		}
		function getTextFields(){
			return array($this->getLabelField());
		}
		function filterCommonWords($words){
			return $words;
		}
		function getSearchTerms($string){
			$parts = explode('"',$string);
			$inquotes = 1;
			$terms = array();
			foreach($parts as $part){
				$inquotes = !$inquotes;
				$part = trim($part);
				if(!$part) continue;
				
				if($inquotes){
					$terms[] = $part;
				} else {
					$terms = array_merge($terms,explode(" ",$part));
				}
	
			}
			return $terms;
		}
		function getLike($string,$params=array()){
			$defaults = array('restrict'=>array(),'min_length'=>1);
			$params = array_merge($defaults,$params);

			$restrict = $params['restrict'];
			$terms = $this->getSearchTerms($string);
			foreach($this->filterCommonWords($terms) as $word){
				if(strlen($word)<$params['min_length']) continue;
				$fields = array();
				foreach($this->getTextFields() as $f){
					$fields["$f like"]="%$word%";
				}	
				$myRestrict[$word] = new OrJoin($fields);
			}
			$restrict[] = new OrJoin($myRestrict);
			$order = "0";
			foreach($myRestrict as $word=>$v){
				$order .= " + IF(".$v->restrict($this,$tables,array()).",".strlen($word).",0)";
			}
			if(@$params['order']) $params['order'].=" , ";
			if(count($myRestrict>1)){
				foreach($this->getTextFields() as $f){
					$fields["$f like"] = "%$string%";
				}
				$j = new OrJoin($fields);
				@$params['order'].=$j->restrict($this,$tables,array())." DESC, ";
			}
			$params['order'] .= "$order DESC";
			if($def = $this->getDefaultOrder()){
				@list($def,$dir) = explode(" ",$def,2);
				$def = $this->includeTable($def,$irrelevant);
				$params['order'] .= ", $def $dir";
			}
			$params['order_explicit'] = true;
			return $this->getAll($restrict,$params);
		}
		function getRelationFields(){
			$relationFields = array();
			foreach($this->relationships as $k=> $rel) try {
				if(@$rel['skip_ui']) continue;
				try {
					$rel = $this->loadRel($k);
				} catch(Exception $e){
					trigger_error($e->getMessage());
					continue;
				}
				if($f = $this->manualField($k)){
					$relationFields[$k]=$f;
					continue;
				}
				if($obj = cms_apply_filter('create_cms_relationship_field',null,$this,$k,$rel)){
					$relationFields[$obj->name] = $obj;
					continue;
				}
				switch(@$rel['type']){
				case __REL_BELONGS_TO__:
				if($rel['composition']){
					$instance = @$this->getRelated($k);
					if($instance){
						$fields = $instance->getFields();
						foreach($fields as $field){
							$field->pushParam('old-db',$field->param('db',true));
							$field->setParam('db',false);
							$field->pushParam('related',$k);
							$relationFields[] = $field;
						}
					}
				} else {
					$model = $rel['model'];
					$params = array('ref'=> array(
							'table'=>$this->$model->getTableName(),
							'value'=>$rel['ref_field'],
							'label'=>$this->$model->getLabelField(),
							'order'=>@$rel['order'] ? $rel['order'] : $this->$model->getIDField(),
							'model'=>$this->$model,
						),
						'label'=>$rel['label']
					);
					foreach(array('required','default') as $key)
						if(array_key_exists($key,$rel))
							$params[$key]=$rel[$key];
					if(isset($rel['default'])) $params['default'] = $rel['default'];
					if(isset($rel['ref_where'])) $params['ref']['where'] = $rel['ref_where'];

					$relationFields[$rel['field']] = new ForeignField($rel['field'],$params);
				}
					break;
				case __REL_MM__:
					if(!@$rel['ui']) continue;
					$model = $rel['model'];
					$table = $k;
					$relationFields[$table] = $cb = new MMCheckboxes($table,
						array(	'ref'=> array(
								'table'=>$this->$model->getTableName(),
								'value'=>$rel['ref_field'],
								'label'=>$this->$model->getLabelField(),
						),'rel'=>$rel,'function'=>$k));
					break;
				case __REL_EXTERNAL__:
					if(@$rel['input']){
						list($file,$class) = explode(":",$rel['input']);
						require_once($file);
						unset($rel['type']);
						$relationFields[$k]=new $class($k,$rel);
					} else {
						$relationFields = array_merge($relationFields,$rel['manager']->getInputs());
					}
					break;
				}
			} catch(Exception $e){
				error_log("Failed creating relationship field for $k");
			}
			return $relationFields;
		}
		function getFieldsFromDB(){
			if(@$this->exportsSchema()) return array_merge($this->defaultFields(),$this->getRelationFields());
			$modelName = get_class($this);
			$tableName = $this->getTableName();
			$q = mysql_query($sql = "DESCRIBE $tableName");
			if(!$q) throw new Exception(mysql_error()." in $sql");
			$fields = array();
			$explicit = array_merge($this->getRelationFields(),$this->explicitFields);
			while($field = mysql_fetch_object($q)){
				if(array_key_exists($field->Field,$this->explicitFields)) {
					$fields[$field->Field] = $explicit[$field->Field];
					unset($explicit[$field->Field]);
				} else {
					$fields[$field->Field] = $this->autoCreate($field);
				}
			}
			$fields = array_merge($fields,$explicit);
			return $fields;
		}
		function manualField($field){
			return false;
		}
		function autoCreate($field){
			if($f = $this->manualField($field->Field)) return $f;
			return autofields::createFor($field,$this);
		}
		function setField($field){
			$this->explicitFields[$field->getName()] = $field;
		}
		function hideField($name){
			if(!is_array($name)) $name = array($name);
			foreach($name as $name)
				$this->setField(new SkippedField($name));
		}

		function overrideFields(){
		}

		function getIndexFields(){
			$indexes = array($this->getIdField());
			foreach($this->relationships as $k=>$v){
				$v = $this->loadRel($k);
				switch($v['type']){
				case __REL_BELONGS_TO__:
					$indexes[] = $v['field'];
					break;
				}
			}
			return $indexes;
		}

		static $sharedFields;
		function buildFields(){
			if(!@$this->fields){
				$model = $this->getModelName();
				$table = $this->getTableName();
				if($fields = @self::$sharedFields[$model][$table]){
					$this->fields = $fields;
				} else {
					$this->overrideFields();
					$this->fields = self::$sharedFields[$model][$table] = $this->getFieldsFromDB();
				}
				$this->fields = $this->applyFilters('fields_built',$this->fields);
			}
			return $this->fields;
		}
		function filter_fields_built($fields){
			return $fields;
		}
		function getFields(){
			$this->compositionReady=true;
			static $first = true;
			if($first) {
				require_once(dirname(__FILE__).'/fields.php');
				$first=false;
			}
			if(!@$this->fields) $this->fields = $this->buildFields();
			$this->triggerAction('getting_fields');
			return $this->fields;
		}
		function getField($key){
			if(!@$this->fields)
				$this->getFields();
			return $this->fields[$key];
		}
		function validate($obj = null){
			if(!$obj) $obj = $this;
			$obj->validation_errors = array();
			foreach($this->getFields() as $field){
				$field->validate($obj);
			}
			foreach($this->relationships as $k=>$v){
				$v = $this->loadRel($k);
				switch(@$v['type']){
				case __REL_EXTERNAL__:
					$v['manager']->validate();
					break;
				}
			}
			if($obj->validation_errors) throw new FormValidationException(join("\n",$obj->validation_errors));
			return true;
		}


		function setDataFromPost($data,$obj,$form='default'){
			$this->getFields();
			foreach($this->fields as $field){
				$field->transformPostData($data,$obj);
			}
			foreach($this->relationships as $k=>$v){
				if(@$v['composition']){
					$v = $this->loadRel($k);
					$v['manager']->setDataFromPost($data,$form);
				}
			}
		}

		function save($obj=null,$post=null,$form='default'){
			if(is_null($post)) $post=$_POST;
			$this->getFields();
			if(!$obj){
				$obj = $this;
			}
			$this->setDataFromPost($post,$obj,$form);
			$this->validate($obj);
			$obj->writeToDB($obj);
		}
		
		function saveSomeFields($fields=array(),$data=array()){
			if(!$data) $data = $_POST;
			$ofields = $this->getFields();
			foreach($fields as $field){
				if(is_string($field)) $field = $ofields[$field];
				$field->transformPostData($data,$this);
			}
			$this->validate($this);
			$this->writeToDB($this);
		}


		function assignString($fields,$join=", ",$proc='mysql_escape_string'){
			$assign = array();
			$b1 = ($proc=='mysql_escape_string')?'`':'';
			$b2 = ($proc=='mysql_escape_string')?"'":'';
			foreach($fields as $k=>$v){
				if(!(cms_apply_filter('null_db_values',true) && is_null($v))) $v = $b2.$proc($v).$b2;
				else $v="NULL";
				$assign[$k] = $b1.$proc($k).$b1."=$v";
			}
			return join($join,$assign);
		}

		function getAssignArray($obj=null){
			if(!$obj) $obj=$this;
			$fields = array();
			foreach($this->getFields() as $k=>$v){
				$fields+= $v->getAssigns($obj);
			}
			//$this->origObj;			
			return $this->applyFilters('assign_array',$fields);
		}
		function trimAssignArray($fields,$obj=null){
			if(!$obj) $obj=$this;
			foreach($fields as $k=>$v){
				if(@$obj->origObj->$k==$v){
					unset($fields[$k]);
				}
			}
			return $fields;
		}
		function writeToDB($obj=null,$params=array()){
			$existed = $this->exists();
			if(!$obj) $obj = $this;
			unset($obj->validation_errors);
			$this->triggerAction('before_write');
			$this->callManagers('before_write');
			$assign = $this->getAssignArray($obj);
			$assign = $this->trimAssignArray($assign);
			$this->engine()->save($obj,$params);
			$orig = $obj->origObj?clone($obj->origObj):null;
			foreach($assign as $k=>$v) @$obj->origObj->$k=$v;
			$this->afterWrite($obj,$existed?clone($obj->origObj):null,$assign);
			unset($this->fields);
		}
		function writeDelayed(){
			$this->delayed = true;
			$this->writeToDB();
			$this->delayed = false;
		}

		function callManagers($func,$args=array(),$type=null){
			foreach($this->relationships as $k=>$v){
				$v = $this->loadRel($k);
				if($type && ($type!=$v['type'])) continue;
				$handle = array(@$v['manager'],$func);
				if(is_callable($handle))
					call_user_func_array($handle,$args);
			}
		}
		function afterWrite($obj,$orig,$assign){
			$this->callManagers('store',array($obj,$orig,$assign));
			foreach($this->fields as $v){
				$v->afterWrite($obj,$orig,$assign);
			}

			if(!$orig) $this->triggerAction('model_created',$orig,$assign);

			$this->triggerAction('model_saved',$orig,$assign);
		}

		function delete(){
			foreach($this->getFields() as $field){
				$field->onDelete($this);
			}
			$this->callManagers('pre_delete');
			$this->triggerAction('pre_delete');
			$this->do_delete();
			$this->callManagers('post_delete');
			$this->cacheClear(strtolower(get_class($this)."-".$this->getID()));
			$this->triggerAction('model_deleted');
			//$this->__destroy();
		}
		function do_delete(){
			$this->engine()->delete($this);
		}
		function __toString(){
			return $this->getEnglishName()." ".$this->getId();
		}
		function summarize($text,$length){
			if(strlen($text)>$length-3){
				$text = substr($text,0,$length-3).'...';
			}
			return $text;
		}

		function getForm($obj=null,$form='default'){
			return $this->getFormForFields($this->getFields($obj));
		}
		function getFormForFields($fields){
			$idField = $this->getIDField();
			$wasNull = !@$this->exists();
			if(!@$this->validation_errors) $this->validation_errors=array();
			$this->form->hidden=array();
			if($wasNull){
				foreach($fields as $field)
					$field->prepare($this,array());
			}
			if($this)
				foreach($fields as $k=>$v){
					$v->renderTo($this);
				}
			$this->form->hidden = @join("\n",$this->form->hidden);
			return $this->form->inputs;
		}

		function required($field){
			$this->addValidation($field,new RequiredValidation);
		}

		function addValidation($field,$validation){
			if(!$this->fields[$field]) throw new ExceptioN("No Such Field '$field'");
			$this->fields[$field]->addValidation($validation);
		}
		function getFilterFields(){
			$fields = array();
			foreach($this->relationships as $k=>$rel){
				$rel = $this->loadRel($k);
				switch($rel['type']){
				case __REL_BELONGS_TO__:
					$fields[] = $this->unpluralize($rel['table']);
				}
			}
			return $fields;
		}

		function createFromCSV($data){
			$obj = $this->createNew();
			foreach($data as $k=>$v){
				$obj->$k=$v;
			}
			$obj->writeToDB($obj);
			return $obj;
		}
	}

	


	require_once(dirname(__FILE__)."/relationships/FileManagers.php");
?>
