<?
/**
* @package Model_System
*/

	class BasicMMInput extends Field {
		function setParams($params){
			$defaults = array( 'db'=>false);
			$params = array_merge($defaults,$params);

			$mod = Model::loadModel($params['model']);
			if(!@$params['ref']) $params['ref'] = array();
			$params['ref'] = array_merge($params['ref'],array('table'=>$mod->getTableName(), 'value'=>$mod->getIDField(), 'label'=>$mod->getLabelField(),'model'=>$mod));
			return parent::setParams($params);
		}
		function getOptions(){
			$name = $this->name;
			return ForeignField::getOptions();
		}

		function getDBName(){
			return $this->name;
		}

		function getId($obj){
			if($obj instanceof MMModel) $obj = $obj->remote();
			return $obj->getId();
		}

		function transformPostData($post,$obj){
			$name = $this->getDBName();
			$p = @$post[$this->htmlName($obj)];
			if(!$p) $p = array();
			$old=array();
			if($obj->$name)
				$old = array_merge(
					array_filter($obj->$name,'is_numeric'),
					array_map(
						array($this,'getId'),
						array_filter($obj->$name,'is_object')
					)
				);
			$ignore = array_diff($old,array_keys($this->getOptions()));
			$p = array_merge($ignore,$p);
			$obj->$name = $p;
		}

		function getExisting($obj){
			$name = $this->getDBName();
			$ids = array();
			if(is_array(@$obj->$name))
			foreach($obj->$name as $v){
				if(is_numeric($v) || is_string($v)) $ids[$v] = $v;
				if($v instanceof MMModel) {
					$relId = $v->getRelatedId();
					$ids[$relId] = $relId;
				}
				else $ids[$v->getId()] = $v->getID();
			}
			return $ids;
		}
		function renderHTML($obj){
			$html='';
			$have = $this->getExisting($obj);
			if(!($have || $obj->exists())){
				$have = array();
				if($defaults = $this->param('default')){
					foreach($defaults as $o){
						if(is_object($o)) $o = $o->getId();
						$have[$o]++;
					}
				}
			}
			return $this->renderHTMLWithValues($obj,$have);
		}
		function renderHTMLWithValues($obj,$have){
			$index=0;
			$columns = $this->param('cols',2);
			$html = "<table class='mm-items'>";
			foreach($this->getOptions() as $k=>$option){
				$pos = $index%$columns;
				$checked=@$have[$k]?' checked="true"' : '';//TODO: Fix this
				if ($pos==0)	{
					$html.="<tr>";
				}
				$html.="<td class='col-$pos mm-item-checkbox'><label class='checkboxLabels' for='".$this->htmlName($obj)."[$k]'>$option</label>".
					$this->getCheckbox($this->htmlName($obj),$k,$checked);
				"</td>";
				if ($pos==$columns-1)	{
					$html.="</tr>";
				}
				$index++;
			}
			$html.="</table>";
			return $html;
		}
		function getCheckbox($hn,$k,$checked){
			return "<input type='checkbox' class='inputCheckbox' name='".$hn."[$k]' id='".$hn."[$k]' value='$k' $checked/>";
		}
	}

	class BasicMMRadio extends BasicMMInput {
		function getCheckbox($hn,$k,$checked){
			return "<input type='radio' class='inputCheckbox' name='".$hn."[1]' id='".$hn."[$k]' value='$k' $checked/>";
		}
	}
	class MMSelect extends BasicMMInput {
		function renderHTMLWithValues($obj,$have){
			$index=0;
			$hn = $this->htmlName($obj);
			$html = "<select name='".$hn."[]' id='".$hn."[]'>";
			if(!$this->param('required',false))
				$html.="<option value=''></option>";
			foreach($this->getOptions() as $k=>$option){
				$checked=@$have[$k]?' selected="true"' : '';//TODO: Fix this
				$html.="<option value='$k' $checked>$option</option>";
			}
			$html.="</select>";
			return $html;
		}
	}
?>
