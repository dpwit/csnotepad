<?
	class ListingFilter {
		var $default = 'any';
		function __construct($name,$options,$label=null){
			$this->name = $name;
			$this->label = $label ? $label : $name;
			if($options) { 
				$new = array('any'=>'Any');
				foreach($options as $k=>$v) $new[$k] = $v;
				$options = $new;
			}
			$this->options=$options;
		}

		function getOptions($obj=null,$restrict=array()){
			return $this->options;
		}

		function getSelected(){
			$key = str_replace(array(" ","."),"_",'rel_'.$this->name);
			if(array_key_exists($key,$_GET)){
				return $_GET[$key];
			} else {
				return $this->getDefault();
			}
		}
		function getDefault(){
			return $this->default;
		}
		function setDefault($def){
			$o = array_map('strtolower',$this->getOptions());
			if(!array_key_exists($def,$o)){
				$i = array_search(strtolower($def),$o);
				if($i!==false) $def = $i;
			}
			$this->default = $def;
		}
		function isSelected($id){
			return "$id"=="".$this->getSelected();
		}

		function makeLink($key){
			return makeLink(array('rel_'.str_replace('.','_',$this->name)=>$key));
		}

		function getWhereField(){
			return $this->name;
		}
		function doParams($model,$params,$selected=null){
			return $params;
		}
		function restrict($model,$restrict,$selected=null){
			if(is_null($selected)) {
				$selected = $this->getSelected();
			}
			
			if(($selected!='any') && !is_null($selected)){
				$restrict[$this->getWhereField()] = $selected;
			}
			return $restrict;
		}
		function getName(){
			return $this->label;
		}
	}
	class SortFilter extends ListingFilter {
		function doParams($model,$params,$selected=null){
			if(is_null($selected)) {
				$selected = $this->getSelected();
			}
			
			if(($selected!='any') && !is_null($selected)){
				$params['order'] = $selected;
			}
			return $params;
		}
		function restrict($model,$restrict,$selected=null){
			return $restrict;
		}
	}
	class RangeFilter extends ListingFilter {
		function restrict($model,$restrict,$selected=null){
			if(is_null($selected)) {
				$selected = $this->getSelected();
			}
			
			if(($selected!='any') && !is_null($selected)){
				list($min,$max) = explode("-",$selected,2);
				$restrict[$this->getWhereField()." >="] = $min;
				$restrict[$this->getWhereField()." <"] = $max;
			}
			return $restrict;
		}
	}

	class RelationshipListingFilter extends ListingFilter {
		function __construct($name,$rel){
			parent::__construct($name,array());
			$this->rel = $rel;
		}
		function getOptions($obj=null,$restrict=array()){
			$f = $this->rel['model']->getAll(array(),array('for_fetch'=>1));
			$options = array('any'=>'Any');
			while($opt = $f->fetch()){
				if($obj && !$obj->countMatching($this->restrict($obj,$restrict,$opt->getId(),$opt))) continue;
				$options[$opt->getId()] = $opt->getLabel();
			}
			if($obj) $options = $obj->applyFilters('related_options_'.$this->name,$options);
			return $options;
		}
		function getWhereField(){
			return $this->name.".".$this->rel['model']->getIdField();
		}
		function getName(){
			return $this->rel['name'];
		}
	}
	class ListingHooks {
		var $fe = false;
		function __construct(){
			cms_listen_action('model_listing_search_end',$this);
			cms_register_filter('model_listing_restrict_preprocess',$this);
			cms_register_filter('model_listing_param_preprocess',$this);
			cms_listen_action('handle_front_end',$this,false,-100);
			cms_listen_action('admin_header',$this);
			cms_register_filter('model_listing_filters',$this);
			cms_listen_action('model_listing_before_table',$this);
		}

		function handle_front_end(){
			$this->fe = true;
		}

		function model_listing_filters($filters,$obj,$restrict){
			if($obj instanceof Model)
			foreach($obj->relationships as $k => $r){
				$currName = 'Any';
				$r = $obj->loadRel($k);
				if(@$r['add-filter']) switch($r['type']){
				case __REL_BELONGS_TO__:
				case __REL_MM__:
				default:
					if(is_string($r['model'])) $r['model'] = Model::loadModel($r['model']);
					$filters[$k] = new RelationshipListingFilter($k,$r);
					if($d = @$r['default-filter']) {
						$filters[$k]->setDefault($d);
					}
				}
			}
			return $filters;
		}
		function getFilters($obj,$restrict){
			return $obj->applyFilters('model_listing_filters',array(),$restrict);
		}
		function model_listing_search_end($obj,$restrict=array()){
			if($this->fe) return;
			$filters = $this->getFilters($obj,$restrict);
			if($filters){
				echo "<div class='facetted-search'>";
			foreach($filters as $k=>$r){
				$options = $r->getOptions($obj,$restrict);
?>
	<div class='filter filter-<?=$r->getName()?>'>
		<h4><?=$r->getName()?></h4>
		<ul class='filter-list'>
<?
					foreach($options as $id=>$label){
						$selected = ($r->isSelected($id)) ? 'selected' : 'not-selected';
?>
			<li class='<?=$selected?>'><a class='<?=$selected?>' href='<?=$r->makeLink($id)?>'><?=$label?></a></li>
<? 					} ?>
		</ul>
	</div>
<?

			}
				echo "<div class='end-facetted-search'></div>";
				echo "</div>";
			}
		}
		function model_listing_before_table($model,$restrict=array()){
			if(!($model instanceof Model || $model instanceof Reportable)) return;
			?>
			<div class='listing-search-header clearfix'>
			<?
					cms_trigger_action('model_listing_search_inputs',$model);
			?>
			<?
					cms_trigger_action('model_listing_search_start',$model,$restrict);
			?>
			<div class="listing-search-box">
				<form method='get'>
					<input type='hidden' name='page' value=''/>
			<?
					foreach($_GET as $k=>$v) {
						if(in_array($k,array('search','page'))) continue;
						if($k=='action') $k='_action';
						$v = stripslashes_if($v);
			?>
					<input type='hidden' name='<?=$k?>' value='<?=$v?>'/>
			<? } ?>
			Search <?=$model->getEnglishName(true)?>: <input name='search' value='<?=htmlspecialchars(@$_REQUEST['search'],ENT_QUOTES)?>'/>
			<input type='submit' value='Search'/>
				</form>
				</div>
			<?
			cms_trigger_action('model_listing_search_end',$model,$restrict);
		}
		function model_listing_param_preprocess($params,$model){
			$filters = $this->getFilters($model,$params);
			foreach($filters as $k=>$v){
				$key = 'rel_'.$k;
				$params = $v->doParams($model,$params);
			}
			return $params;
		}
		function model_listing_restrict_preprocess($restrict,$model){
			if(@$_REQUEST['search']) $restrict['like'] = $_REQUEST['search'];
			$filters = $this->getFilters($model,$restrict);
			foreach($filters as $k=>$v){
				$key = 'rel_'.$k;
				$restrict = $v->restrict($model,$restrict);
			}
			return $restrict;
		}
		function admin_header(){
?>
	<link rel='stylesheet' type='text/css' href='/cms/modules/listing_filters/filters.css'/>
	<script src='/cms/modules/listing_filters/filters.js' type='text/javascript'></script>
<?
		}
	}
	function makeLink($params=array()){
		$get = $_GET;

		foreach($params as $k=>$v){
			if(($v!==false) && (!is_null($v))) $get[$k] = $v;
			else unset($get[$k]);
		}
		@list($link,$query) = explode('?',$_SERVER['REQUEST_URI']);
		$link.='?';
		foreach($get as $k=>$v){
			$link.="$k=".urlencode($v)."&";
		}
		return $link;
	}
new ListingHooks;
?>
