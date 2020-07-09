<?
	/** Represents a many relationship by embedding the many items into
	 * the item form of the parent object.
	 */
	class ManyInput extends Field {
		function defaultParams(){
			return array_merge(parent::defaultParams(),array(
				'db'=>false,
			));
		}
		function renderHTML($obj){
			$name = $this->getName();
			$rel = $obj->loadRel($name);
			$this->skip = $rel['ref_field'];
			$model = $rel['model'];

			$model = Model::loadModel($model);

			$bits = $obj->$name();
			if($bits)
			foreach($bits as $instance){
				$html[] = $this->renderInstanceHTML($obj,$instance,true);
			}
			$inst = $obj->manager($this->name)->createRelated();
			$inst->uid.=$obj->getId();
			$html[] = $this->renderInstanceHTML($obj,$inst,false);
			$css_classes = "many-container";
			if($model instanceof SortableModel) $css_classes .= " sortable";
			return "<div class='$css_classes'>".join("",$html)."</div>";
		}
		function transformPostData($data,$obj){
			$value = @$data[$this->htmlname($obj)];
			if(!is_array($value))$value=array();
			$name = $this->getName();
			$byId=array();
			if(@$obj->$name)
			foreach($obj->$name as $v){
				$byId[$v->getId()] = $v;
			}
			foreach($value as $k=>$v){
				if(strpos($k,'NEW')!==0){
					$new[] = @$byId[$k];
				} else {
					$rel = $obj->loadRel($name);
					$this->skip = $rel['ref_field'];
					$model = $rel['model'];
		
					$new[] = $created = $obj->manager($this->name)->createRelated();
					$created->uid=$k;
				}
			}
			$obj->$name = @$new;
		}
		function getFieldsForObj($obj,$parent){
			$fields =$obj->getFields();
			$fields = $parent->applyFilters('composition_fields',$fields,$this->name);
			return $fields;
		}
		function renderInstanceHTML($parent,$obj,$open=true){
			$html="<div class='many-record'>";
			$hn = $this->htmlName($parent)."[".$obj->getId()."]";
			$html.="<div class='many-record-html-control'>".($obj->exists()?'Keep':'Add')."<input type='checkbox' name='$hn' value='on' ".($open?"checked='true'":"")."/>";
			if($obj instanceof SortableModel) $html.="<div class='sortable-handle'><span>DRAG</span></div>";
			$html.="</div>";
			$html.="<div class='many-sub-form'>";
			$fields = $this->getFieldsForObj($obj,$parent);
			$html.=$obj->getView('form',array('fields'=>$fields,'noForm'=>true));
			$html.="</div>";
			$html.="<div class='many-footer'></div>";
			$html.="</div>";
			return $html;
		}
	}
?>
