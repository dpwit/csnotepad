<?
/**
* @package Model_System
*/

function dump_trace(){
	foreach(debug_backtrace() as $frame){
		unset($class);
		extract($frame);
		echo "<li> ".@$class.".$function $file.$line</li>\n";
	}
}

function cms_register_filter($key,$fn,$file=null,$sorting=0){
	global $__CMS_HOOKS;
	if(is_object($fn)) $fn = array($fn,$key);
	$__CMS_HOOKS['sorted']['filter'][$key]=false;
	$__CMS_HOOKS['filter'][$key][]=array("fn"=>$fn,"file"=>$file,'sorting'=>$sorting);
}
function cms_listen_action($key,$fn,$file=null,$sorting=0){
	global $__CMS_HOOKS;
	if(is_object($fn)) $fn = array($fn,$key);
	$__CMS_HOOKS['sorted']['action'][$key]=false;
	$__CMS_HOOKS['action'][$key][]=array("fn"=>$fn,"file"=>$file,'sorting'=>$sorting);
}

function sort_by_sorting($a,$b){
	$a = $a['sorting'];
	$b = $b['sorting'];

	
	if ($a == $b) {
		return 0;
	}
	return ($a < $b) ? -1 : 1;
}

function cms_get_sorted_hooks($type,$key){
	global $__CMS_HOOKS;
	if(!@$__CMS_HOOKS['sorted'][$type][$key]){
		@uasort($__CMS_HOOKS[$type][$key],'sort_by_sorting');
		$__CMS_HOOKS['sorted'][$type][$key] = true;
		if($hooks = $__CMS_HOOKS[$type][$key]) 
		foreach($hooks as $k=>$hook){
			extract($hook);
			if($file){
				require_once($file);
				unset($__CMS_HOOKS[$type][$key]['file']);
				unset($file);
			}
		}
	}
	return $__CMS_HOOKS[$type][$key];
}
function cms_trigger_action($key,$arg=false,$arg2=false){
	$wasRecurse = @$GLOBALS['recursed'];
	$args = func_get_args();
	$args = array_slice($args,1);
	if($hooks = cms_get_sorted_hooks('action',$key))
	foreach($hooks as $hook){
		call_user_func_array($hook['fn'],$args);
	}
	if(!$wasRecurse){
		$GLOBALS['recursed'] = true;
		array_unshift($args,$key);
		call_user_func_array('cms_call_hook',$args);
	}
	$GLOBALS['recursed'] = $wasRecurse;
}
function cms_apply_filter($key,$arg=false,$arg2=false){
	$wasRecurse = @$GLOBALS['recursed'];
	global $__CMS_HOOKS;
	$args = func_get_args();
	$args = array_slice($args,1);

	if($hooks = cms_get_sorted_hooks('filter',$key))
	foreach($hooks as $hook){
		$file = $hook['file'];
		$fn = $hook['fn'];
		if($file){
			require_once($file);
			unset($__CMS_HOOKS[$key]['file']);
		}
		$arg = call_user_func_array($fn,$args);
		$args[0]=$arg;
	}
	if(!$wasRecurse){
		$GLOBALS['recursed'] = true;
		array_unshift($args,$key);
		$arg = call_user_func_array('cms_call_hook',$args);
	}
	$GLOBALS['recursed'] = $wasRecurse;
	return $arg;
}
function cms_push_hooks(){
	global $__CMS_HOOKS , $__CMS_HOOKS_STACK;
	$__CMS_HOOKS_STACK[] = $__CMS_HOOKS;
}
function cms_pop_hooks(){
	global $__CMS_HOOKS , $__CMS_HOOKS_STACK;
	$__CMS_HOOKS = array_pop($__CMS_HOOKS_STACK);
}
// For debugging, this prints a list of hooks
function cms_dump_hooks(){
	global $__CMS_HOOKS;
	$hooks = array_map('obj2class',$__CMS_HOOKS);
	echo "<pre>";
	print_r($hooks);
	echo "</pre>";
}
function obj2class($array){
	if(is_object($array)) return get_class($array);
	if(is_array($array)) return array_map('obj2class',$array);
	else return $array;
}
/** DEPRECATED: For backward compatibility.
 * See cms_register_filter or cms_listen_action
 * */
function cms_listen_hook($key,$fn,$file=null,$sorting=0){
	global $__CMS_HOOKS;
	$__CMS_HOOKS['sorted']['old_skool_hooks'][$key]=false;
	$__CMS_HOOKS['old_skool_hooks'][$key][]=array("fn"=>$fn,"file"=>$file,'sorting'=>$sorting);
}
/** DEPRECATED: For backward compatibility
 * See cms_apply_filter or cms_trigger_action
 * 
 */
function cms_call_hook($key,$arg=false,$arg2=false){
	$wasRecurse = $GLOBALS['recursed'];

	global $__CMS_HOOKS;
	$args = func_get_args();
	$args = array_slice($args,1);

	if($hooks = cms_get_sorted_hooks('old_skool_hooks',$key))
	foreach($hooks as $hook){
		$file = $hook['file'];
		$fn = $hook['fn'];
		if($file){
			require_once($file);
			unset($__CMS_HOOKS[$key]['file']);
		}
		$arg = call_user_func_array($fn,$args);
		$args[0]=$arg;
	}
	array_unshift($args,$key);

	if(!$wasRecurse){
		$GLOBALS['recursed'] = true;
		call_user_func_array('cms_trigger_action',$args);
		$arg = call_user_func_array('cms_apply_filter',$args);
	}
	$GLOBALS['recursed'] = $wasRecurse;
	return $arg;
}
/** DEPRECATED: For backward compatibility*/
function cms_call_hooks($keys,$arg=false,$arg2=false){
	foreach($keys as $key){
		$arg = cms_call_hook($key,$arg,$arg2);
	}
	return $arg;
}
cms_listen_action('models_loaded','makeLink',dirname(__FILE__).'/functions.php',1000);

?>
