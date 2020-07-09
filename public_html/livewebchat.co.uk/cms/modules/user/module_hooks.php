<?
/**
* @package BozBoz_CMS
*/

	cms_listen_action('after_login','use_groups');
	cms_listen_action('after_logout','logout_group');

	function get_theme_url($theme){
		switch($theme){
		case 'cms':
			return MASTERURL.'/cms';
		case 'frontend': 
		default:
			return MASTERURL;
		}
	}

	function use_groups(){
		$r = mysql_fetch_row(mysql_query("SELECT g.uid,g.name,g.level,u.id,g.defaultUrl,g.requireTheme FROM user u JOIN usergroups g ON u.usergroup_uid=g.uid WHERE u.userid='$_SESSION[uid]' AND status>0"));
		$_SESSION['id']=$r[3];
		$_SESSION['groupId']=$r[0];
		$_SESSION['groupName']=$r[1];
		$_SESSION['level']=$r[2];
		$url = $r[4];
//		if($r[5] && ($r[5]!=get_theme())){
//			$url = get_theme_url($r[5]).'/'.$r[4];
//		}
		if(strpos($url,'http')!==0) $url = "http://$_SERVER[HTTP_HOST]$url";
		$url = cms_apply_filter('cms_landing_page',$url);
		header("Location: $url");
	}
	function logout_group(){
		unset($_SESSION['groupName']);
		unset($_SESSION['groupId']);
		unset($_SESSION['id']);
		unset($_SESSION['level']);
	}

	cms_register_filter('cms_menu','user_cms_menu');
	function user_add_links($array){
		$array = array_merge(array('User Groups'=>'UserGroup'),$array);
		$array = array_merge(array('Manage Users'=>'user'),$array);
		return $array;
	}
		function user_cms_menu($array){
		$user = Model::loadModel('User')->getLoggedInUser();
		$showPermissionsTab = $user->userGroup()->name==('Super Admin');
			//unset($array['Modules']);
			$array['Account']['My Profile']=$user->urlFor('editItem');
			if($user->isAdmin()){
				$array['Customer'] =array( 
					"View Customers"=>"overview.php?pageType=user",
					"Add Customer"=>"newItem.php?pageType=user",
				);
				if($showPermissionsTab){
					$array['Customer']['Permissions']='overview.php?pageType=group_permission&section=User';
					$array['Customer']['Add Permission']='newItem.php?pageType=group_permission&section=User';
				}
			}
			return $array;
		}
	cms_register_filter('cms_section_name','customers_are_users');
	function customers_are_users($section,$model){
		if($model instanceof UserModel) return 'customer';
		if($model instanceof Group_Permission) return 'customer';
		return $section;
	}

	cms_register_filter('get_allowed_groups','get_allowed_groups');
	function get_allowed_groups($groups,$userData){
		if($groups) return $groups;

		global $USER;
		$editingSelf = ($userData['id']==$USER->getID());
		$q = mysql_query("SELECT uid,name FROM usergroups WHERE level ".($editingSelf?'<=':'<').$_SESSION['level']);
		while($r = mysql_fetch_row($q)){
			$groups[$r[0]]=$r[1];
		}
		return $groups;
	}
	
	cms_listen_action('models_loaded','user_load_model');
	function user_load_model(){
		Model::addModel('User',dirname(__FILE__).'/UserModel.php','UserModel');
		Model::addModel('UserGroup',dirname(__FILE__).'/UserModel.php');
		Model::addModel('Group_Permission',dirname(__FILE__).'/UserModel.php');
	//	Model::loadModel('User');
	}
//	cms_register_filter('model_field_access','db_permissions',__FILE__,30);
	cms_register_filter('check_access','db_permissions',__FILE__,30);
	function db_permissions($errors,$params){
		if(is_array($params))
			extract($params);
		$user = Model::loadModel('User')->getLoggedInUser();
		if($user){
			static $cache = array();
			$checked =& $cache[$user->getId()];
			$checkGroups = array($user);
			static $groups = array();
			if(!$groups){
				$gm = Model::loadModel('UserGroup');
				while($checkGroups){
					$group = array_shift($checkGroups);
					if(!$group) continue;
					$groups[] = $group;
					foreach($group->permissions(array('pageType'=>'inherit')) as $inherit){
						if(is_numeric($inherit->action)){
							$checkGroups[] = $gm->get($inherit->action);
						} else {
							$checkGroups[] = $gm->getFirst(array('name'=>$inherit->action));
						}
					}
				}
			}

			foreach(array(@$params['modelName'],@$params['pageType']) as $type)
				foreach(array($action,'all') as $thisAction){

				if(isset($checked[$type][$thisAction])){
					$value = $checked[$type][$thisAction];
					if($value){
						break(2);
					}
				} else {
					foreach($groups as $group) {
						$can = $group->permissions($srch = array('pageType'=>$type,'action'=>$thisAction),array('single'=>1));
						$value=0;
						if($can){
							$value = $can->valid?1:-1;
							$checked[$type][$thisAction] = $value;
							break(3);
						}
					}
					$checked[$type][$thisAction] = $value;
				}
			}
			if($value){
				if($value>0){
					unset($errors['USER_LEVEL']);
				} else {
					$errors['USER_LEVEL']='Explicitly Denied';
				}
			}
		}
		return $errors;
	}
?>
