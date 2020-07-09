<?
	interface Reportable {
		function next();
		function setFormat($format);

		function getAvailableColumns();
		function setListingColumns($cols);

		function getListingHeadings();
		function getListingValues();

		function triggerAction($action);
		function applyFilters($filter);
	}

	class ModelReporter extends Viewable implements Reportable{
		var $format = 'html';
		var $q = null;
		var $next = null;
		var $cols = array();
		var $skip = 0;

		function __construct($model,$where=array(),$params=array()){
			parent::__construct();
			$params['for_fetch'] = 1;
			$this->next = $model;
			$this->first = true;
			$this->model = $model;
			$where = $this->applyFilters('model_listing_restrict_preprocess',$where);
			$params = $this->applyFilters('model_listing_param_preprocess',$params);
			$this->where = $where;
			$this->params = $params;
		}

		function __call($func,$params){
			return call_user_func_array(array($this->next ? $this->next : $this->model,$func),$params);
		}

		function restrict($k,$v){
			$this->where[$k]=$v;
		}
		function skip($n){
			$this->skip = $n;
		}

		function hasTextSearch(){
			return $this->model->getTextFields();
		}
		function newTable(){
			$n = $this->first;
			$this->first=false;
			return $n;
		}
		function getCmsBulkActions(){
			return $this->model->getCmsBulkActions();
		}

		function getReportTitle(){
			return $this->model->getEnglishName()." Listing";
		}
		function triggerAction($action){
			$dontRecurse = array('model_listing_before_table');
			call_user_func_array(array('Viewable','triggerAction'),func_get_args());
			if(!in_array($action,$dontRecurse))
			call_user_func_array(array($this->next?$this->next:$this->model,'triggerAction'),func_get_args());
		}
		function applyFilters($filter){
			$args = func_get_args();
			$args[1] = call_user_func_array(array('Viewable','applyFilters'),$args);
			return call_user_func_array(array($this->next?$this->next:$this->model,'applyFilters'),$args);
		}
		function getEnglishName($plural = false){
			return $this->model->getEnglishName($plural);
		}
	
		function startQuery(){
			$this->q = $this->model->getAll($this->where,$this->params);
		}
		function next(){
			if(!$this->q) $this->startQuery();
			while($this->skip) {
				$this->skip--;
				$this->q->fetch();
			}
			return $this->next = $this->q->fetch();
		}
		function setFormat($format){
			$this->format = $format;
		}

		function getAvailableColumns(){
			return $this->next->getListingHeadings();
		}
		function setListingColumns($cols){
			$this->cols = $cols;
		}

		function getListingHeadings(){
			$e = error_reporting();
			error_reporting($e &~E_NOTICE);
			$headings = array_keys($this->intersectedColumns($this->model));
			error_reporting($e);
			return $this->applyFilters('heading_format_'.$this->format,$headings);
			return $headings;
		}
		function checkAccess($action){
			return $this->next->checkAccess($action,false);
		}

		function intersectedColumns($model=false){
			if(!$model) $model=$this->next;
			switch($this->format){
			case 'csv':
				$cols = $model->getCsvListingColumns();
				break;
			default:
				$cols = $model->getListingColumns();
			}
			if($this->applyFilters('cms_has_actions',true)){
			$actions = $this->applyFilters('model_listing_actions',$model->getCmsActions(),$this->next);
			$toGo = count($actions);
			$count=0;
			$toggleMore = 6;
			ob_start();
			foreach($actions as $link=>$label){ 
				if(++$count==$toggleMore){
?>
					<div class='toggle-more'>
<?
				}
?>
				<a class='overviewAction overViewAction-<?=$label?>' href='<?=$link?>'><span class='actionText'><?=$label?></span></a>  <? if (--$toGo>0) echo " - "; ?>
<? 			} 
			if($count>=$toggleMore) echo "</div>";
			$cols['Actions'] = ob_get_contents();
			ob_end_clean();
			}
			if($this->cols){
				foreach($cols as $k=>$v){
					if(!in_array($this->cols,$k)) unset($cols[$k]);
				}
			}
			return $cols;
		}
		function getListingValues(){
			return $this->applyFilters('listing_format_'.$this->format,$this->intersectedColumns());
		}

		function filter_heading_format_csv($values){
			return array_diff($values,array('Actions','Sort'));
		}
		function filter_listing_format_csv($values){
			unset($values['Actions']);
			unset($values['Sort']);
			$values = array_map('html_entity_decode',array_map('strip_tags',$values));
			return $values;
		}

		function getRowClass(){
			return $this->next->getModelName();
		}
		function getTableClass(){
			return $this->next->getTableName(false);
		}
	}

?>
