<?
/**
* @package Elite_Promo
*
* This is the version designed to work with the new composition style mm relationships.
*/

	class MMSortedSelector extends Field {
		function __construct($name,$rel,$options=array()){
			$options = array_merge($options,array('rel'=>$rel,'db'=>false));
			parent::__construct($name,$options);
			$this->rel = $rel;
		}

		function transformPostData($post,$obj){
			$hn = $this->htmlName($obj);
			@array_shift($post[$hn]);
			parent::transformPostData($post,$obj);
		}
		function renderHTML($obj){
			$func = $this->name;
			$model = Model::loadModel($this->params['rel']['model']);

			$where = $this->param('where',array());
			$dwhere = array('visible'=>false);
			$where =array_merge($dwhere,$where);
			if($obj->$func){
				$found=array();
				foreach($obj->$func as $k=>$v){
					if(is_numeric($v)) $v = $model->get($v);
					else $v=$v->remote(array('show_deleted'=>false));
					if(!$v) continue;
					$found[$k]=$v;
				}
			}
			else $found = $obj->$func($where);//array(),array('for_fetch'=>1));
			$json = array();

			$mfield = @$this->rel['ref']['field'];
			foreach($found as $k=>$v){
				$field = $mfield ? $mfield : $v->getIDField();
				$id = $v->$field;
				$json[] = array('id'=>$v->getId(),'label'=>$v->applyFilters('mm_listing_label',$v->getLabel()));
			}
			$json = json_encode($json);
			$hn = $this->htmlName($obj);
			$prototype_control='';
			if($this->rel['order']){
				$prototype_control.="
					<td class='tbl-select-down'><a href='#' class='mm-selector-sort mm-selector-down sortable-handle'><span>[DRAG]</span></a></td>
				";
			}
			$prototype_control .= "
				<td class='tbl-select-remove'><a href='#' class='mm-selector-remove'>[Remove]</a></td>
			";
			$label = "###LABEL###";
			if($this->param('edit_link',false)){
				$label = "<a href='editItem.php?cms_uid=###ID###&model=".$this->params['rel']['model']."'>$label</a>";
				$prototype_control .= "<td class='tbl-select-edit'><a href='editItem.php?cms_uid=###ID###&model=".$this->params['rel']['model']."'>[Edit]</a></td>";
			}
			$html='
			<script src="/cms/includes/models/fields/mm-selector.js"></script>
			<div id="'.$hn.'-wrapper" class="mm-selector-wrapper">
				<table style="display: none"><tbody class="mm-selector-prototype">
					<tr class="mm-selector-item"><td class="tbl-select-item">
						<input type="hidden" name="'.$hn.'[###ID###]" value="###ID###"/>
						'.$label.'</td>';
			$html.=$prototype_control;
			$html.='	</tr>
				</tbody></table>
				<table class="mm-selector-list sortable">
				</table>
				<div class="mm-selector-search">';
			if($this->param('existing_link',true)){
				$html.='	<a href="'.$model->urlFor('list_for_mm').'&mfield='.$mfield.$this->param('extra-url','').'" class="mm-selector-add popup-link buttonblock">Add Existing '.$model->getEnglishName(false).'</a>';
			}

			if($obj->exists() && $l = $this->param('add_link',false)){
				if(is_callable($l)) $l = call_user_func($l,$obj);
				else $l = str_replace('###ID###',$obj->getId(),$l);
				$html.='<a href="'.$l.'" class="mm-selector-add buttonblock">Add New '.$model->getEnglishName(false).'</a>';
			}
			$html.=	'</div>
			<div style="clear: both"></div>
			</div>';
			$options = array('inline'=>$this->param('inline',false),'itemtag'=>'tr');
			$options = json_encode($options);
			$html.="<script>
				$(function(){
					$('#$hn-wrapper').mm_selector($json,$options);
				});
			</script>";
			return $html;

		}
	}
?>
