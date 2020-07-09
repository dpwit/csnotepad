<?
/**
* @package Model_System
*/

require_once(dirname(__FILE__).'/../relationships/FileManagers.php');

	class ThroughManager implements IExternalManager {
		function __construct($name,$rel,$instance){
			$this->instance = $instance;
			$this->name = $name;
			$this->rel = $rel;
		}
		function lateInitRel($rel){ 
			$through_rel = $this->instance->loadRel($rel['through']);
			$through_model = $through_rel['model'];
			$foreign_rel = @$this->instance->$through_model->loadRel($this->name);
			$my_model = $foreign_rel['model'];
			if($my_model){
				$this->instance->$my_model = Model::loadModel($my_model);
				$rel['model'] = $my_model;
			}
			$rel['init'] = true;
			return $rel;
		}
		function initRel($rel){
			return $rel;
		}

		function fetch($where=array(),$params=array()){
			$rel = $this->rel;
			if(!@$rel['init']){
				$this->instance->relationships[$this->name] = $this->rel = $rel = $this->lateInitRel($rel);
			}
			try {
				return $this->recurse($where,$params,$this->instance,$this->rel['through'],$this->name);
			} catch(Exception $e){
			}
			$direct = $this->instance->getRelated($this->rel['through']);
			if(!$direct) return false;

			if(!is_array($direct)) $direct = array($direct);

			$results = @$params['for_fetch'] ? new MultiFetcher : array();
			foreach($direct as $instance){
				$related = $instance->getRelated($this->name,$where,$params);

				if($related){
					if(@$params['single']){
						return $related[0];
					} elseif(@$params['for_fetch']){
						$results->add($related);
					} else {
						if(is_array($related))
							$results = array_merge($results,$related);
						else return $related;
					}
				}
			}
			return $results;
		}
	//	return $this->recurse($where,$params,$this->instance,$this->rel['through'],$this->name);
		function recurse($where,$params,$instance,$relName,$target){
			$rel = $instance->loadRel($relName);
			switch($rel['type']){
			case __REL_EXTERNAL__:
				if($rel['through']){
					return $rel['manager']->recurse($where,$params,$instance,$rel['through'],$target);
				}
				break;
			case __REL_HAS_MANY__:
				$foreign = Model::loadModel($rel['model']);
				$back = @$rel['back'] ? $rel['back'] : $instance->getTableName(false);
				if((!@$foreign->hasRel($target))&&($foreign->hasRel($instance->unpluralize($target)))) $target = $instance->unpluralize($target);
				if(($back_rel=$foreign->loadRel($back))&&($for_rel=$foreign->loadRel($target))){
					$ref = $back_rel['ref_field'];
					switch($for_rel['type']){
					case __REL_EXTERNAL__:
						if($for_rel['through']){
							if($instance->$ref){
								$where[" RECURSE $ref"]=$instance->$ref;
							}
							foreach($where as $k=>$v){
								unset($where[$k]);
								$k = preg_replace("/^ RECURSE /"," RECURSE $back.",$k);
								$where[$k]=$v;
							}
							return $for_rel['manager']->recurse($where,$params,$foreign,$target,$target);
						}
						break;
					case __REL_HAS_MANY__:
						if($instance->$ref){
							$where[" RECURSE $ref"]=$instance->$ref;
						}
						$back2 = @$for_rel['back'] ? $for_rel['back'] : $foreign->getTableName(false);
						foreach($where as $k=>$v){
							unset($where[$k]);
							$k = preg_replace("/^ RECURSE /","$back2.$back.",$k);
							$where[$k]=$v;
						}

						$model = Model::loadModel($for_rel['model']);
						return $model->getAll($where,$params);
					case __REL_HAS_ONE__:
						if($instance->$ref){
							$where[" RECURSE $ref"]=$instance->$ref;
						}
						foreach($where as $k=>$v){
							unset($where[$k]);
							$k = preg_replace("/^ RECURSE /","$t.",$k);
							$where[$k]=$v;
						}

						$model = Model::loadModel($for_rel['model']);
						//var _dump(get_class($model));
						//var _dump($where);
						die();
						return $model->getAll($where,$params);
					}
				}
			default:
//				trigger_error("Bad through relationship $relName ($target) in {$instance->getModelName(false)}");
//				var _dump(get_class($this->instance),$relName,$rel['type']);
			}
			throw new Exception("Couldn't Shortcut ".get_class($instance)." - $target (".$relName.")");
		}

		function includeTable($field,&$tables,$value){
			if(@$table!=$this->rel['through']){
				$rel = $this->instance->loadRel($this->rel['through']);
				$model = $rel['model'];
				$model = $this->instance->$model;
				$this->instance->includeTable($this->rel['through'].".uid",$tables);//,$this->rel['through']);
				return $model->includeTable("$this->name.$field",$tables);

			} else {
				return $this->instance->includeTable($this->rel['through'].".$this->name.$field",$tables);
			}
		}
		function store($newModel,$oldValues,$assigns){}
		function getAssigns(){return array();}
		function setDataFromPost($data,$formName='default'){}
		function validate(){return true;}
		function getInputs(){return array();}
		function on_init(){ }
	}
?>
