<?
/**
* @package BozBoz_CMS
*/

	require_once(dirname(__FILE__).'/../user/UserModel.php');
	class CustomUser extends UserModel {
		function __construct($obj=null,$extraTable=false){
			if(!in_array(strtolower($extraTable),array('user','customuser'))){
				if($this->extraTable = $extraTable){
					$this->hasOne($extraTable,array('composition'=>true));
				}
			}
			parent::__construct($obj);
		}
		function getDefaultOrder(){
			return array('realName','userid');
		}
		function resetPassword(){
			require_once(dirname(__FILE__).'/lib/generatePassword.php');
			$password = generatePassword();
			$this->password = md5($password);
			$this->sendMail($this->email,__SERVER_DOMAIN__." Password Reset",false,$this->getView('mail/password-reset',array('userid'=>$this->userid,'password'=>$password)));
			
			$this->writeToDb();
		}
		function getCmsActions(){
			$array = parent::getCMSActions();
			if(check_access('userManagement','su',$this->getID(),array('model'=>$this))){
				$array[$this->cmsUrl('su')]='Switch User';
			}
			return $array;
		}
		function getFields(){
			$user = Model::loadModel('User')->getLoggedInUser();
			$f = parent::getFields();
			if($user && ($user->getId()==$this->getId())){
				$f = $this->makeProfileFields($f);
			}
			$this->fields['userid']->addValidation(new UniqueValidation(array(),array('model'=>Model::loadModel('User'))));
			return $this->fields = $f;
		}
		function makeProfileFields($fields){
			require_once(__MODELS_BASE__.'/fields/MyPassword.php');
			$fields['password'] = new MyPassword('password');
			$fields['userid'] = new HiddenField('userid');
			$fields['usergroup_uid'] = new HiddenField('usergroup_uid');
			$fields['status'] = new HiddenField('status');
			return $fields;
		}
		function __getFields() {
			$fields = parent::getFields();
			if($_GET['userGroup']){
				$fields['usergroup_uid']->setParam('default',$_GET['userGroup']);
			}
			$fields['userid']->addValidation(new UniqueValidation(array('status >'=>-2)));
			return $this->fields = $fields;
		}
		function getGroupClasses(){
			$classes = cms_apply_filter('cms_user_classes',array());
			$groups =array();
			foreach($classes as $a=>$b){
				if(@$b['class']) $groups[$b['group']] = $b['class'];
				elseif(@$b['model']) $groups[$b['group']] = $b['model'];
			}
			return $groups;
		}
		function create($class,$r,$table){
			if(!@$r->userGroupUid){
				$r->userGroupUid = @$_GET['userGroup'];
			}
			$classes = $this->getGroupClasses();
			$group = Model::loadModel('UserGroup')->get($r->usergroup_uid);

			if($group && $custom = @$classes[$group->name]){
				$class = $custom;
			}
			Model::loadModel($class);
			return new $class($r);
		}

		function getMainLinks(){
			$pageType = $this->getPageType();
			$links = array(
				"overview.php?pageType=userManagement&model=CustomUser"=>"View All ".$this->getEnglishName(true),
			);
			$classes = $this->getGroupClasses();
			$groups = Model::loadModel('UserGroup')->getAll();
			foreach($groups as $group){
				$model = $classes[$group->name];
				if(!$model) $model='CustomUser';
				$uid = $group->getId();
				$name = $group->name;
				if(check_access('userManagement','newItem',false,array('modelName'=>$model))){
					$links["newItem.php?pageType=$pageType&model=$model&userGroup=$uid"]="New $name";
				}
			}

			return $links;
		}
		function showListing(){
			$restrict = array();
			$user = $this->getLoggedInUser();
parent::showListing(array('restrict'=>$restrict));
			return true;
		}
		function getListingColumns(){
			$cols = parent::getListingColumns();
			return $cols;
		}
		//DEPRECATED: Should be removed
		function statusString(){
			return $this->statusToString();
		}

		function setPassword($newPass){
			$newPass = md5($newPass);
			if($newPass==$this->password) throw new Exception("You have used this password before");
			$old = $this->old_passwords(array('pass'=>$newPass,'cdate >'=>time()-365*24*3600));
			if($old) throw new Exception("You have used this password before");
			$this->password=md5($newPass);
			$this->writeToDB();
		}

		function cms_exit_su(){
			if($_SESSION['OLD']){
				$_SESSION=$_SESSION['OLD'];
				$this->showView('confirmation');
				redirectLastPage();
			} else {
				$this->showView('error',array('message'=>'Not currently in switched user mode'));
			}
		}
		function cms_su(){
			$old = array();
			foreach($_SESSION as $k=>$v){
				$old[$k] = $v;
			}
			$_SESSION['OLD'] = $old;
			$_SESSION['uid'] = $this->userid;
			$_SESSION['id'] = $this->getID();
			$_SESSION['groupId'] = $this->userGroup()->getID();
			$_SESSION['groupName'] = $this->userGroup()->getLabel();
			$_SESSION['level'] = $this->getLevel();
			$_SESSION['lastRealPage'] = $this->userGroup()->defaultUrl;
			$this->showView('confirmation');
			redirectLastPage();
		}
		function requiresReactivation(){
			return (($this->getLevel()<2) && ($this->admin_validated<time()-28*60*60*24));
		}
		function accessErrors($action,&$errors){
			extract($oa = $action);
			if($pageType=='userManagement'){
				switch($action){
				case 'exit_su':
				case 'logout':
					unset($errors['USER_LEVEL']);
					break;
				case 'deleteItem':
				case 'editItem':
				case 'save':
					if($this && (!$this->isAdmin()) && ($this->getLevel()<=$model->getLevel()))
						$errors['USER_LEVEL']='You can only switch to users with lower level than yourself';
					if((!$this) || ($this->getLevel()<3))
						$errors['USER_LEVEL']='You need to log in to switch users';
					break;
				case 'newItem':
					$classes = cms_call_hook('cms_this_classes',array());
					if($this->isAdmin()) unset($errors['USER_LEVEL']);
					foreach($classes as $info){
						if($info['class']==$modelName){
							$group = Model::loadModel('UserGroup')->getFirst(array('name'=>$info['group']));
							if($group->getLevel()>=$this->getLevel()) $errors['USER_LEVEL'] = "Cannot create users higher than yourself";
						}
					}
					break;
				case 'overview':
				case 'view':
					break;
				default:
					$errors['USER_LEVEL'] = 'You do not have permission to do this';
				}
			}
		}
		function getGroupUid(){
			foreach(cms_call_hook('cms_user_classes',array()) as $user_class){
				extract($user_class);
				if($class==get_class($this)){
					return Model::loadModel('UserGroup')->getFirst(array('name'=>$group))->uid;
				}
			}
			return false;
		}
		function getVisibleWhere(){
			return array('status >'=>0);
		}
		function sendMail($to,$subject,$textContent,$htmlContent='',$from=false){
			if(!$from) $from = "no-reply@".__SERVER_DOMAIN__;
			cms_module_require('phpmailer','class.phpmailer.php');
			$mail = new phpmailer();
			$mail->From = $from;
			$mail->FromName="Accounts ".__SERVER_DOMAIN__;
			$mail->Subject = $subject;

			$footers = $this->getEmailFooters();

			if($htmlContent){
				$mail->IsHtml(true);
				$mail->Body=$htmlContent.$footers['html'];
				if(!$textContent){
					$textContent = strip_tags($htmlContent);
				}
				$mail->AltBody=$textContent.$footers['text'];
			} else {
				$mail->Body=$textContent.$footers['text'];
			}
			$mail->AddAddress($to);
			$mail->AddBCC("don@don-benjamin.co.uk");
			$mail->AddBCC("webcontact@bozboz.co.uk");
			$mail->AddBCC(Config::value('admin-email','site'));
			//$mail->AddBCC("mike@bozboz.co.uk");
			$mail->Send();
		}
		function getEmailFooters(){
			try {
				$footer = $this->getView('mail/emailFooter');
				return array(
					'html'=>$footer,
					'text'=>strip_tags($footer),
				);
			} catch(Exception $e){
				return array('html'=>'','text'=>'');
			}
		}
		function isSU(){
			return @$_SESSION['old'];
		}
		function subscribePHPList($listId){
			mysql_query("USE ".__PHPLIST_DB__);

			$email = trim($this->email);
			if(!$email) return;
			
			$confirmed =1;
			$htmlemail = 1;

			$userId = @mysql_result(mysql_query("SELECT id FROM phplist_user_user WHERE email='$email'"),0);
			$sql_addUser ="INSERT INTO phplist_user_user  (  email, confirmed, htmlemail) VALUES ( '$email', '$confirmed', '$htmlemail')";

			if(!$userId){
				$result = mysql_query($sql_addUser) or die (' But I cannot connect do the sql query because: ' . mysql_error());
				$userId = mysql_insert_id();
			}

			//stick user in appropriate list and other bitties

                        $sql_addToList ="INSERT INTO phplist_listuser  (  userid, listid) VALUES ( '$userId', '$listId')";
			$result = mysql_query($sql_addToList);// or die (' But I cannot connect do the sql query because: ' . mysql_error());


			if(@$this->firstName) {
				$first = $this->firstName;
				$last = $this->lastName;
			} else {
				@list($first,$last) = explode(" ",$this->realName,2);
			}
			$attributes = array(
				1=>$first,
				2=>$last,
				3=>$this->phone, 
			);
			foreach($attributes as $k=>$v){
				$sql_addFistName ="INSERT INTO phplist_user_user_attribute  (  userid, attributeid,value) VALUES ( '$userId','$k', '$v' ) ON DUPLICATE KEY UPDATE value='$v'";
				mysql_query($sql_addFistName);
			}

			mysql_query("USE ".__MYSQL_NAME__);
		}
	}

	class AdminUser extends CustomUser {
		function __construct($object=null,$table=false){
			parent::__construct($object);
		}
		function _resetPassword(){
			throw new Exception("Cannot Reset Admin Passwords");
		}
		function getFields() {
			$fields = parent::getFields();
			$fields['usergroup_uid']->setParam('default',2);
			return $fields;
		}
		function accessErrors($action,&$errors){
			extract($action);
			switch($action){
			case 'su':
				if($model && ($model->getLevel()>=$this->getLevel())){
					$errors['USER_LEVEL']='Can only switch to users with lower level than yourself';
				}
				break;
			}
			if(@$model && is_a($model,'UserModel')){
				switch($action){
				case 'vew':
					break;
				case 'editItem': case 'save':
					if ($model->getId()==$this->getId()){
						unset($errors['USER_LEVEL']);
						return $errors;
					}
				default:
					if($model->getLevel()>=$this->getLevel()){
						$errors['USER_LEVEL']='Can only edit users with lower level than yourself';
					}
				}

			}
		}
		function isUnrestricted(){
			return false;
		}

		function getEnglishName($plural=false){
			$name = 'Customer';
			if($plural) $name = $this->pluralize($name);
			return $name;
		}
	}
	class SuperAdminUser extends AdminUser {
		function getFields() {
			$fields = parent::getFields();
			$fields['usergroup_uid']->setParam('default',1);
			return $fields;
		}
		function accessErrors($action,&$errors){
			$errors = array();
		}
		function isUnrestricted(){
			return true;
		}
	}

?>
