<?
/**
* @package BozBoz_CMS
*/

	cms_listen_hook('check_access','level2_for_editing',null,-1);
	function level2_for_editing($errors,$action){
		$requiredLevel=3;
		switch($action['action']){
		case 'editItem':
		case 'newItem':
			$requiredLevel=3;
		case 'overview':
			switch(strtolower($action['pageType'])){
			case 'user':
				$requiredLevel=3;
				break;
			case 'usergroup':
				$requiredLevel=4;
			}
		}
		if(@$_SESSION['level']<$requiredLevel) $errors['USER_LEVEL']="You are not authorised to view this page your level is not high enough";
		return $errors;
	}

	function print_warning($warning){
		echo "<p class='warning-message'>$warning</p>";
	}
	cms_listen_hook('show_warning','print_warning');
?>
