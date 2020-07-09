<?
/**
* @package Elite_Promo
*/


	class PaginatedTable extends FileInclude {
		var $res = null;
		var $recordTemplate = null;

		function __construct($params=array()){
			if(is_object($params)){
				$params = array('model'=>$params);
			}
			$defaults = array(
				"listing"=>"modules/default/listing",
				"model"=>"Page",
				"listFunc"=>"getAll",
				"perPage"=>10,
				"pagination"=>true,
				"order"=>false,
				"alternate"=>false,
				"title"=>null,
				"footer"=>"",
				"header"=>"",
				"hideOnEmpty"=>true,
				"where"=>array(),
				'query-debug'=>false,
			);
			$params = array_merge($defaults,$params);
			parent::__construct($params['listing'],$params);
			$this->model = $params['model'];
			$this->listFunc = $params['listFunc'];
			$this->perPage=($params['pagination']&&@$_GET['per'])?$_GET['per']:$params['perPage'];
		}
		function isVisible(){
			$vis = parent::isVisible();
			if($this->params['hideOnEmpty'] && !$this->params['alternate']){
				$vis = $vis && ($this->getTotalResults()>0);
			}
			return $vis;
		}
		var $model = 'Page';

		function debugInfo($extraParams=array()){
			$extraParams['model'] = get_class($this->model)." ".$this->model->getLabel();
			$extraParams['include_file'] = $this->file;
			$extraParams['single'] = $this->recordTemplate;

			return parent::debugInfo($extraParams);
		}

		function startQuery(){
			if(!@$this->res){
				$params = array(
					'offset'=>$skip = $this->getCurrentPage()*$this->getResultsPerPage(),
					'limit'=>$this->getResultsPerPage(),
					'for_fetch'=>true
				);
				if(!$this->params['pagination'])
					$params['offset']=0;
				if($this->params['query-debug']) {
					$params['debug'] = true;
				}
				if($params['limit']<0){
					// Should this be in the model class
					unset($params['limit']);
					unset($params['offset']);
				}
				if($order=$this->getOrder()) $params['order'] = $order;
				$dwhere = array('visible'=>1);
				$where = $this->params['where'];
				if($where) $where = array_merge($dwhere,$where);
				else $where = $dwhere;
				if(!$where) $where = array();
				if($q = $this->getCurrentSearchString()){
					$where['like'] = $q;
				}
				$this->res = $this->doQuery($where,$params);
			}
		}
		function doQuery($where=array(),$params=array()){
			if(is_string($this->model)) $this->model=Model::loadModel($this->model);
			return call_user_func_array(array($this->model,$this->listFunc),array($where,$params));
		}
		function getItem(){
			$this->startQuery();
			$item = $this->res->fetch();
			if(!$item){
				unset($this->res);
				return false;
			} else {
				if($this->recordTemplate)
					return $this->createItemComponent($item);
				else
					return $item;
			}
		}
		function createItemComponent($item){
			return new FileInclude($this->recordTemplate,array('item'=>$item));
		}

		var $perPage = 20;
		var $totalResults = 50;
		function getResultsPerPage(){
			return $this->perPage;
		}

		function getTotalResults(){
			$this->startQuery();
			return $this->res->numResults();
		}

		function getPerPageLink($num=10){
			return $this->relink(array('per'=>$num,'p'=>0));
		}
		function getNextLink(){
			$p = $this->getCurrentPage();
			if($p+1<$this->getNumPages()) return $this->getPageLink($p+1);
		}
		function getPrevLink(){
			$p = $this->getCurrentPage();
			if($p>0) return $this->getPageLink($p-1);
		}
		function getCurrentPage(){
			return @$_GET['p'];
		}
		function getOrder(){
			$order = @$_GET['order'];
			if(!@$order) $order = $this->params['order'];
			return $order;
		}
		function getNumPages(){
			if(!$this->params['pagination']) return 1;
			return ceil(($this->getTotalResults())/$this->getResultsPerPage());
		}
		function getPageLink($pageNum){
			return $this->relink(array('p'=>$pageNum));
		}
		function relink($params){
			@list($url,$qstring) = explode("?",$_SERVER['REQUEST_URI']);
			return "$url?".$this->getQuery($params);
		}
		function getSortLink($field){
			if($field==$this->getOrder()){
				$field.=" DESC";
			}
			@list($url,$qstring) = explode("?",$_SERVER['REQUEST_URI']);
			return "$url?".$this->getQuery(array('order'=>$field));
		}
		function getCurrentSearchString(){
			return stripslashes_if(@$_REQUEST['q']);
		}
		function getHiddenSearchInputs(){
			return $this->getHiddenInputs(array('q'=>null));
		}
		function getHiddenInputs($explicit=array()){
			$persist = $this->getPersistentValues($explicit);
			$html='';
			foreach($persist as $k=>$v)
				$html.="<input type='hidden' name='".htmlspecialchars($k)."' value='".htmlspecialchars($v)."'/>";
			return $html;
		}
		function getQuery($explicit=array()){
			$persist = $this->getPersistentValues($explicit);
			$query=array();
			foreach($persist as $k=>$v)
				$query[$k] = urlencode($k)."=".urlencode($v);
			return join("&",$query);
		}

		function valuesToPersist(){
			return array('p'=>$this->getCurrentPage(),'q'=>$this->getCurrentSearchString(),'order'=>$this->getOrder(),'per'=>$this->getResultsPerPage());
		}
		function getPersistentValues($explicit=array()){
			$persist = $this->valuesToPersist();
			foreach($explicit as $k=>$v){
				if(is_null($v)) unset($persist[$k]);
				else $persist[$k]=$v;
			}
			foreach($persist as $k=>$v){
				if(!$v) unset($persist[$k]);
			}
			return $persist;
		}
		function doHTML($context){
			if(($alt = $this->params['alternate'])&&($this->getTotalResults()==0)){
				return is_string($alt) ? $alt : $alt->doHTML($context);
			}
			return parent::doHTML($context);
		}
	}
?>
