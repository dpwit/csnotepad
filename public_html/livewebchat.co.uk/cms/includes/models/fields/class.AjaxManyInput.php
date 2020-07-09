<?
	/** Represents a many relationship by embedding the many items into
	 * the item form of the parent object.
	 */
	class AbsoluteCheckboxField extends CheckboxField {
		function htmlName($obj){
			return $this->param('htmlName');
		}
	}
	class AjaxManyInput extends Field {
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
			$label = $this->getRelationshipLabel($model,$obj);

			$html[] = "<div class='many-controls'><a href='#' class='many-add-link'>Add {$label}</a></div>";

			$bits = $obj->$name();
			$index=1;
			if($bits)
			foreach($bits as $instance){
				if(!$instance) continue;
				$html[] = $this->renderInstanceHTML($obj,$instance,$index++,true);
			}
			$created = $obj->manager($this->name)->createRelated(array($model->getIdField()=>"###ID###"));
			$html[] = "<div style='display:none' class='many-template'>".$this->renderInstanceHTML($obj,$created,"###INDEX###",false)."</div>";
			$css_classes = "many-container";
			if($model instanceof SortableModel) $css_classes .= " sortable";
			return "<div class='$css_classes'>".join("",$html)."</div>";
		}
		function transformPostData($data,$obj){
			$value = @$data[$this->htmlname($obj)];
			$remove = @$data[$this->htmlname($obj).'-remove'];
			$remove['###ID###'] = true;
			if(!is_array($value))$value=array();
			$name = $this->getName();
			$byId=array();
			if(@$obj->$name)
			foreach($obj->$name as $v){
				$byId[$v->getId()] = $v;
			}
			foreach($value as $k=>$v){
				if(@$remove[$k]) continue;
				$isNew = strpos($k,'NEW')===0;
				if($isNew){
					$rel = $obj->loadRel($name);
					$this->skip = $rel['ref_field'];
					$model = $rel['model'];
		
					$model = Model::loadModel($model);
					$new[] = $obj->applyFilters('composition_created',$obj->manager($this->name)->createRelated( array($model->getIdField()=>$k)),$this->getName());
				} else {
					$new[] = @$byId[$k];
				}
			}
			$obj->$name = @$new;
		}
		function getRelationshipLabel($obj,$parent){
			return $parent->applyFilters('relationship_label',$obj->getEnglishName(false),$this->getName());
		}
		function renderInstanceHTML($parent,$obj,$index,$open=true){
			$html="<div class='many-record'>";
			$label = $this->getRelationshipLabel($obj,$parent);
			$html.="<h2>".$label." $index</h2>";
			$hr = $this->htmlName($parent)."-remove[".$obj->getId()."]";
			$hn = $this->htmlName($parent)."[".$obj->getId()."]";
			$html.="<div class='many-sub-form'>";
			$fields =$obj->getFields();
			$rel = $parent->loadRel($this->name);
			foreach($obj->relationships as $k=>$brel){
				$brel = $obj->loadRel($k);
				if($brel['field'] = $ref = $rel['ref_field']){
					$fields[$ref] = new HiddenField($this->name,array('value'=>$obj->$ref));
				}
			}
			$fields = $parent->applyFilters('composition_fields',$fields,$this->name);
			$fields[] =  new AbsoluteCheckboxField('remove',array('db'=>false,'htmlName'=>$hr,'label'=>"Remove $label?"));
			$view = $parent->applyFilters('composition_form_view','form',$this->name);
			$html.=$obj->getView($view,array('fields'=>$fields,'noForm'=>true));
			$html.="</div>";
			$html.="<div class='many-record-html-control'><input type='hidden' name='$hn' value='1'/>";
			if($obj instanceof SortableModel) $html.="<div class='sortable-handle'><span>DRAG</span></div>";
			$html.="</div>";
			$html.="<div class='many-footer'></div>";
			$html.="</div>";
			return $html;
		}
	}
?>
