<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/../relationships/FileManagers.php');
	class BasicMMManager implements IExternalManager {
		function initRel($rel){ 
			$defaults = array(
				'allow-duplicates'=>false
			);
			$rel = array_merge($defaults,$rel);
			return $rel;
		}
		function __construct($field,$params,$model){
			$this->name = $field;
			$defaults = array('model'=>$model);
			$params = array_merge($defaults,$params);
			$this->params = $params;
			$this->model=$model;
		}
		function __destroy(){
			foreach(get_object_vars($this) as $k=>$v){
				unset($this->$k);
			}
		}

		function fetch($where = array(),$params=array()){
			$name = $this->name;

			$model = Model::loadModel($this->params['model']);

			$mine = $this->model->loadRel($this->name);
			if(@$mine['back']){
				$other = $model->loadRel($k=$mine['back']);
			} else {
				try {
					$other = @$model->loadRel($k = $this->name);
				} catch(Exception $e){
				}
			}
			if(!$other){
				foreach($model->relationships as $k=>$r){
					$r = $model->loadRel($k);
					if(@$r['table'] == @$mine['table']){
						$other = $r;
						break;
					}
				}
			}
			if($other){
				$table = $k;
				$idField = $this->model->getIDField();
				$id = $this->model->getID();
				$where["$table.$idField"] = $id;
			} else {
				trigger_error('No Back Mapping For '.$this->model->getEnglishName().' '.$this->name);
			}

			return $model->getAll($where,$params);
		}
		function post_delete(){
			$mm=$this->loadMMModel();
			$rel = $this->model->loadRel($this->name);
			if(!@$rel['clean_on_delete']) return;
			$myId = $this->model->getId();
			$q = $mm->getAll(array($rel['local_id']=>$myId),array('for_fetch'=>1));
			while($r = $q->fetch()) $r->delete();

		}
		function store($newModel,$oldValues,$assigns){
			$model = Model::loadModel($this->params['model']);

			$mine = $this->model->loadRel($this->name);
			if(!$mine['composition']) return;

			$old = $this->getCurrent();
			$name = $this->name;
			$new = @$this->model->$name;


			//if(!is_array($new)) return; //Should this delete everything?
			
			if(!is_array($old)) $old = array();
			if(!is_array($new)) $new = array();

			$old_ids = array_unique($this->array2ids($old));
			$new_ids = array_unique($this->array2ids($new));

			$extra = array_diff($old_ids,$new_ids);
			$missing = array_diff($new_ids,$old_ids);
			cms_trigger_action('relationship_add_remove',$newModel,$this->params,$missing,$extra);
			$foreign = $this->params['foreign_id'];
			foreach($old as $mm){
				if(in_array($mm->$foreign,$extra)) $mm->delete();
			}
			foreach($missing as $v){
				$mm = $this->createRel($v);
				$mm->writeToDB();
			}
		}
		function createRel($v){
			$mm = $this->loadMMModel();
			$new = $mm->createNew(array($this->params['local_id']=>$this->model->getId(),$this->params['foreign_id']=>$v));
			return $new;
		}

		function array2Ids($array){
			$ids = array();
			if(is_array($array))
			foreach($array as $v){
				if(!$v) continue;
				if(is_numeric($v)) $ids[] = $v;
				else if(is_object($v)) {
					if($v instanceof MMModel) $v = $v->remote();
					if($v) $ids[] = $v->getId();
				}
			}
			return $ids;
		}
		function getAssigns(){
			$name = $this->name;
			return array($name=>$this->getFilename());
		}
		function composition(){
			$name = $this->name;
			if(!isset($this->model->$name))
				$this->model->$name = $this->getCurrent();
		}
		var $mm_factory = null;
		function loadMMModel(){
			if(!$this->mm_factory){
				$rel = $this->model->loadRel($this->name);
				$mm = Factory::newInstance("model_".$rel['mm_model']);
				$mm->setRelationship($this->name,$rel);
				$this->mm_factory = $mm;
			}
			return $this->mm_factory;
		}
		function getCurrent(){
			$model=$this->model;
			$rel = $model->loadRel($this->name);
			$mm = $this->loadMMModel();
			$params = @$rel['order'] ? array('order'=>$rel['order']):array();
			if($model->exists()){
				return $mm->getAll(array($rel['local_id']=>$model->getId(),'visible'=>false),$params);
			} else {
				return array();
			}
		}
		function setDataFromPost($data,$formName='default'){}
		function validate(){ return true;}
		function getInputs(){
			return array();
		}
		function on_init(){}
		function includeTable($field,&$tables,$value,$table){
			$rel = $this->model->loadRel($this->name);
			$mobj = $this->model;
			$tableRef = $mobj->getTableName();
			$model = $rel['model'];
			$tables.=" LEFT JOIN `$rel[table]` ON `$tableRef`.`$rel[my_ref_field]`=`$rel[table]`.`$rel[local_id]`";
			$for = $mobj->$model->getTableName();
			$ref = $mobj->pluralize($table);
			$forId =$mobj->$model->getIDField();
			$tables.=" LEFT JOIN `$for` `$ref` ON `$ref`.`$forId`=`$rel[table]`.`$rel[foreign_id]`";
			$field = $mobj->$model->includeTable($field,$tables,$value);
			return $field;
		}
	}
	class SortedMMManager extends BasicMMManager {
		function fetch($where=array(),$params=array()){
			$rel = $this->model->loadRel($this->name);
			$field = $rel['order'];
			$params['order'] = $this->params['table'].".$field";
			$params['order_explicit']= true;
			return parent::fetch($where,$params);
		}
		function store($newModel,$oldValues,$assigns){
			$mm = $this->loadMMModel();
			$rel = $this->model->loadRel($this->name);
			if(!$rel['composition']) return;
			$field = $rel['order'];
			$old = $this->getCurrent();
			$name = $this->name;
			$new = $this->array2ids($this->model->$name);
			if(!$rel['allow-duplicates']) $new = array_unique($new);



			//if(!is_array($new)) return; //Should this delete everything?
			
			$pn = each($new);
			$pn = $pn[1];
			$po = each($old);
			$po = $po[1];
			$sorting = 0;

			do {
				$sorting++;
				$in = $pn;
				$io = $po ? $po->getId() : null;
				if($in && ($in == $io)){
					if($po->$field<$sorting){
						$po->$field = $sorting;
						$po->writeToDB();
					} else {
						$sorting = $po->$field;
					}
						$po = each($old);
						$po = $po[1];
						$pn = each($new);
						$pn = $pn[1];
				} else {
					if($io){
						$po->delete();
						$po = each($old);
						$po = $po[1];
					} elseif($in) {
						$rel = $this->createRel($pn);
						$rel->$field = $sorting;
						$rel->writeToDB();
						$pn = each($new);
						$pn = $pn[1];
					}
				}
			} while($in || $io);
		}
		function moveUp($id){
			$this->move($id,'up');
		}

		function moveDown($id){
			$this->move($id,'down');
		}
		function findIndex($id){
			$name = $this->name;
			$records = $this->model->$name;
			foreach($records as $k=>$v){
				if($v->getId()==$id) return $k;
			}
		}
		function move($id,$dir){
			$name = $this->name;
			$records = $this->model->$name;
			$k = $this->findIndex($id);
			switch($dir){
			case 'down':
				$first = $k;
				break;
			case 'up':
				$first = $k-1;
				break;
			}
			$a = $records[$first];
			$b = $records[$first+1];
			$records[$first] = $b;
			$records[$first+1] = $a;

			$this->model->$name = array_values($records);
			$this->model->writeToDB();
		}
		function remove($id){
			$name = $this->name;
			$records = $this->model->$name;
			$k = $this->findIndex($id);
			unset($records[$k]);
			$this->model->$name = array_values($records);
			$this->model->writeToDB();
		}
	}
?>
