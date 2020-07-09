<?
if(!function_exists('makeLink')){
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
}
