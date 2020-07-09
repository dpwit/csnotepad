<?php 
/**
* @package BozBoz_CMS
*/


 //--->>>>----------------------------------------------------->>>>
 //        Pass this function the id of the category and it will return its name
 //--->>>>----------------------------------------------------->>>>
 
 function getNameFromId ($id,$table,$categoryName) 
 {
 $sql = "SELECT * FROM $table WHERE uid= '$id' LIMIT 1 ";
 $result = mysql_query($sql);
 while ($data= mysql_fetch_array($result, MYSQL_BOTH)) { 
 return $data [$categoryName];
 }
 mysql_free_result($result);
 }
 
function redirectLastPage($id=false,$delayed=false){
	$page = str_replace('###INS_UID###',$id,@$_SESSION['lastRealPage']);
	$page = preg_replace('_^/+_','/',$page);
	redirectTo($page,$delayed);
}
function redirectReferer($fallback=false){
	if($_SERVER['HTTP_REFERER']){
		redirectTo($_SERVER['HTTP_REFERER']);
		return true;
	}
	if($fallback){
		redirectTo($fallback);
		return true;
	}
	return false;
}
function redirectTo($page,$delay=0){
	if(!$delay && !headers_sent()) header("Location: $page");
?>	<script>
	setTimeout("document.location='<?=$page?>'",1000);
	</script>
	<noscript>
		<meta http-equiv="refresh" content="5;url=<?=$page?>" />
	</noscript>
<?
}

class AccessException extends Exception {
	function __construct($errors,$object,$action){
		parent::__construct(join("\n",$errors));
		$this->errors=$errors;
		$this->object = $object;
		$this->action = $action;
	}
}
function checkAccess($obj,$action,$throwException=true){
	try {
		$p = $obj->getPageType();
	} catch(Exception $e){
		$p = $obj->getModelName(false);
	}
	$errors = array();
	$errors = cms_call_hook('check_access',$errors,array('pageType'=>$p,'uid'=>$obj->getId(),'action'=>$action,'model'=>$obj,'modelName'=>$obj->getModelName(false)));
	if($errors){
		if($throwException) throw new AccessException($errors,$obj,$action);
		else return false;
	} else {
		return true;
	}
}

function array_insert($array,$item,$index){
	return array_merge(array_slice($array,0,$index),array($item),array_slice($array,$index));
}

function truncate($text,$length=20,$append='...'){
	if(strlen($text)>$length){
		$text = substr($text,0,$length).$append;
	}
	return $text;
}

function paragraphs($text,$class=''){
	if($class) $class=" class='$class'";
	$text = explode("\n",$text);
	foreach($text as $k=>$v){
		if(!$v) unset($text[$k]);
	}

	$text = join("</p><p$class>",$text);
	if($text) return "<p$class>$text</p>";
	return "";
}

function def($defaults=array(),$params=array()){
	if(!is_array($defaults)) return $params;
	if(!is_array($params)) return $defaults;
	return array_merge($defaults,$params);
}
function stripslashes_if($string){
	if(get_magic_quotes_gpc()) $string = stripslashes($string);
	return $string;
}
function nice_file_size($sizeOrFile){
	if(file_exists($sizeOrFile)) {
		$file = $sizeOrFile;
		$size = filesize($file);
	} else {
		$size = $sizeOrFile;
	}

	$orders = array("B","KB","MB","TB","PB");
	$order = array_shift($orders);
	while($size>512){
		$size/=1024;
		$order = array_shift($orders);
	}
	return number_format($size,2).$order;
}

function number_format_max_places($num,$maxPlaces=2){
	return preg_replace("/\.?00$/","",number_format($num,$maxPlaces));
}

function find_by_url($url=false,$classes = array()){
	if(!$classes)
		$classes = cms_call_hook('content_classes',array());
	if(!$url) $url=$_SERVER['SCRIPT_URL'];
	if(!$url) $url=$_SERVER['REQUEST_URI'];
	foreach($classes as $class){
		$model=Model::loadModel($class);
		$found = $model->getByUrl($url,array(),array('single'=>1));
		if($found) return $found;
	}
}

function array_method_map($method,$array){
	$args = func_get_args();
	$args = array_slice($args,2);
	foreach($array as $k=>$v){
		$array[$k] = call_user_func_array(array($v,$method),$args);
	}
	return $array;
}
?>
