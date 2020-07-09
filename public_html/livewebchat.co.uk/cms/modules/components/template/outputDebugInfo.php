<?
ini_set('xdebug.max_nesting_level',1000);
session_write_close();

	function highlight_special_debug($class,$key,$subObj,$parentKey){
		return "special";
		$special = array('visible_components','used_screen','screenFlow','template_file','shown_views','found','main','origObj','model');
		$child_special = array('components','visible_components');
		if(in_array($key,$special) && !is_numeric($key)) return "special";
		if(in_array($parentKey,$child_special)) return "all-special";
		return $class;
	}
	function notes_special_debug($notes,$key,$fullObj){
		$special = array(
			'visible_components'=>'Components which have been rendered',
			'used_screen'=>'Screen which has been rendered',
			'screenFlow'=>'This has a sub-screenflow',
		);
		if(!$notes) $notes = @$special[$key];
		
		return $notes;
	}
	cms_register_filter('component_debug_help','notes_special_debug');
	cms_register_filter('component_debug_css','highlight_special_debug');
	function showLevel($debug,$recurse=10,$parentKey=false){
		if(!$recurse--) return;
		$ul_class = ($recurse%2) ? "even" : "odd";
?>
	<ul class='debug-list debug-list-<?=$ul_class?>'>
<?
		if($notes = cms_apply_filter('component_debug_help','',$parentKey,$debug)) {
			echo "<li>...$notes</li>";
		}
		if(is_object($debug)) {
			echo "<li>__class: ".get_class($debug)."</li>";
		}
		if(is_callable(array($debug,'debugInfo'))){
			try {
				$debug = $debug->debugInfo();
			} catch(Exception $e){
			}
		}
		foreach($debug as $k=>$v){
			$debug_css = cms_apply_filter('component_debug_css','normal',$k,$debug,$parentKey);
			if($k==='decorated') continue;
			if(is_array($v) || is_object($v)) $debug_css.=" debug-handle debug-handle-closed";
?>
			<li><span class='head <?=$debug_css?>'><?=$k?></span>:
<?
			if(is_array($v) || is_object($v)) showLevel($v,$recurse,$k);
			else echo htmlspecialchars($v);
?>
			</li>
<?
		}
?>
	</ul>
<?
	}


	function stripViewStuff($data){
		
		$possible = array(@$data->file,@$data->template_file);
		if(@$data->shown_views)
		foreach(@$data->shown_views as $v) $possible[] = $v['file'];
		foreach($possible as $k=>$v)
			if(!$v) unset($possible[$k]);
		return array_unique($possible);
	}
	function recurse2String($component){
		$debug=array();
		$class = get_class($component);
		if($class!='CompositeComponent'){
			$debug['Class'] = $class;
			$debug['shown_views'] = stripViewStuff($component);
		}
		if(@$component->components){
			foreach($component->components as $k=>$v){
				$debug[$k] = recurse2String($v);
			}
		}
		return $debug;
	}
	$views = FEContext::$views;
	foreach($views as $k=>$v){
		$views[$v['View']] = $v;
		unset($views[$k]);
	}
	$debug = array(
		"Page Structure"=>$template->params['page_file'],
		"Templates"=>$views,
		"Elements"=>recurse2String($template),
	);
	showLevel($debug);
?>
