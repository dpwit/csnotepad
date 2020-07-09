<?
/**
* @package BozBoz_CMS
*/

	class UserModel extends BozModel {
		function __construct($obj=null,$table=null){
			parent::__construct($obj,'user');
			$this->hasOne('usergroup',array('field'=>'usergroup_uid','add-filter'=>true));
		}
		function filter_related_options_usergroup($options){
			$user = $this->getLoggedInUser();
			if(!$user->isUnrestricted()){
				foreach($options as $k=>$v){
					if(strpos($v,'Admin')!==false) {
						unset($options[$k]);
					}
				}
			}
			return $options;
		}
		function getModelNamesForHooks(){
			return array_merge(parent::getModelNamesForHooks(),array('user'));
		}

		function getTextFields(){
			return array('realName','userid','email');
		}
		function manualField($field){
			switch($field){
			case 'status':
				return new DropDownField($field,array('options'=>$this->validStatuses()));
			case 'realName':
//				return new HiddenField($field);
				return new Field($field,array('label'=>'Real Name'));
			case 'redirect': case 'appendlogin': case 'level':
				return new SkippedField($field);
			case 'address':
				return new TextArea($field);
			}
			return parent::manualField($field);
		}

		function getAssignArray(){
			$assign = parent::getAssignArray();
			if(@$this->fields['firstName']){
				$assign['realName'] = $this->firstName." ".$this->lastName;
			}
			return $assign;
		}
		function getLabelField(){
			return 'realName';
		}

		function getTableName(){
			return "user";
		}
		function getEnglishName($plural=true){
			return $plural ? "Users": "User";
		}
		function getIDField(){
			return "id";
		}

		function getLabel(){
			if(trim($this->realName)) return $this->realName;
			return $this->userid;
		}

		function hasImage(){
			return is_file($this->getImageFileName());
		}
		function getImageFileName($size=''){
			return dirname(__FILE__).'/../../images/news/'.$this->image; 
		}
		function getImageUrl($size=''){
			$image = $this->image;
			if(!$this->hasImage())$image = 'default.jpg';
			return 'images/news/'.$size.'/'.$image; 
		}
		function getVisibleWhere(){
			$where['status']=1;
			return $where;
		}
		function specialWhere($key,$value){
			if($key=='uid'){
				return array($this->getIDField()=>$value);
			}
			return parent::specialWhere($key,$value);
		}

		function getDescription(){
			return $this->shorttext;
		}

		function getLevel(){
			if(!@$this->cacheLevel){
				$this->cacheLevel=@$this->UserGroup()->level;
			}
			return $this->cacheLevel;
		}
		function isAdmin(){
			return $this->getLevel()>=3;
		}
		function isUnrestricted(){
			return $this->isAdmin();
		}
		static function getUser(){
			static $user;
			if($user) return $user;
			return $user = Model::loadModel('User')->getLoggedInUser();
		}
		function getLoggedInUser(){
			global $_SESSION;
			static $users = array();
			$id = @$_SESSION['id'];
			if(!@$users[$id]) $users[$id] = $this->get($id);
			return $users[$id];
		}

		function logInCLI(){
			$this->getFirst(array('userid in'=>array('cron','cli','don')))->forceLogin();
		}
		function forceLogin(){
			global $_SESSION;
			$_SESSION['uid'] = $this->userid;
			$_SESSION['id'] = $this->getID();
			$_SESSION['level'] = $this->getLevel();
		}
		function cms_logout(){
			$this->logout();
		}
		function logout(){
			foreach($_SESSION as $k=>$v){
				unset($_SESSION[$k]);
			}
			$this->showView('loggedOut');
		}
		function getViewDirectories(){
			$dirs = parent::getViewDirectories();
			$default = array_pop($dirs);
			$dirs[] = dirname(__FILE__).'/views/user';
			$dirs[] = $default;
			return $dirs;
		}

		function permissions($where=array(),$params=array()){
			return $this->UserGroup()->permissions($where,$params);
		}

		function getFields(){
			$user = Model::loadModel('User')->getLoggedInUser();
			$minLength = ($user && $user->isAdmin()) ? 3 : 6;
			parent::getFields();
			$this->fields['userid']->setParam('label','User Name');
			$this->fields['userid']->addValidation(new RequiredValidation);
			$this->fields['userid']->addValidation(new RegExValidation("/^[a-zA-Z0-9_.]{".$minLength.",}$/","Must be  at least $minLength letters and/or numbers (no spaces)"));
			$this->fields['userid']->addValidation(new UniqueValidation(array('status >'=>-2),array('name'=>'userid')));
			$this->fields['email']->addValidation(new RequiredValidation);
			$this->fields['email']->addValidation(new EmailValidation);

			$user = Model::loadModel('User')->getLoggedInUser();
			if(!($user && $user->isAdmin())){
				require_once(__MODELS_BASE__.'/fields/MyPassword.php');
				$this->fields['password'] = new MyPassword('password');
			}
			$this->fields['password']->addValidation(new RequiredValidation);
			return $this->fields;
		}
		function cms_afterSave(){
			$user = Model::loadModel('User')->getLoggedInUser();
			if($user->getId() == $this->getId()){
				$this->showView('confirmation',array('delayRedirect'=>true));
			} else {
				parent::cms_afterSave();
			}
		}
		function getListingColumns(){
			$cols['Name'] = @$this->getLabel();
			$cols['Login'] = @$this->userid;
			$cols['Real Name'] = @$this->realName;

			$cols['group']=@$this->UserGroup()->name;
			$cols['Status'] = $this->statusToString();
			return $cols;
		}
		function statusToString(){
			$statuses = $this->validStatuses();
			return $statuses[$this->status];
		}
		function validStatuses(){
			return array("Inactive","Active");
		}

		function getDeletedWhere(){
			return array("status <"=>0);
		}
		function isActive(){
			return $this->status>0;
		}
		function do_delete(){
			$this->status=-1;
			$this->writeToDB();
		}
	}
	class UserGroup extends BozModel {
		function __construct($model=null){
			parent::__construct($model);
			$this->hasMany('group_permissions');
			$this->hasMany('users');
		}
		function getFields(){
			parent::getFields();
			$this->fields['name'] = new Field('name');
			$this->fields['name']->addValidation(new UniqueValidation);
			unset($this->fields['requireTheme']);
			return $this->fields;
		}
		function getLevel(){
			return $this->level;
		}
		function getEnglishName($plural=true){
			return $plural ? 'Groups' : 'Group';
		}
		function permissions($where=array(),$params=array()){
			return $this->group_permissions($where,$params);
		}
		function canCMS(){
			return $this->name!='Anonymous';
		}
	}
	class Group_Permission extends BozModel {
		function __construct($model=null){
			parent::__construct($model);
			$this->hasOne('userGroup');
		}

		function overrideFields(){
			$this->setField(new DropDownField('valid',array('options'=>array(1=>'Yes',0=>'No'))));
			return parent::overrideFields();
		}

		function getLabel(){
			return $this->userGroup()->name." ".$this->pageType.".".$this->action." ".($this->valid?"Y":"x");
		}
		function getListingColumns(){
			return array('Group'=>$this->userGroup()->name,'Type'=>$this->pageType,'Action'=>$this->action,'Allow'=>($this->valid?'Y':'x'));
		}
		function getCmsActions(){
			$actions = parent::getCmsActions();
			$actions[$this->urlFor('duplicate')] = 'Duplicate';
			return $actions;
		}

		function cms_duplicate(){
			$copy = $this->createCopy();
			$copy->showEditForm();
		}
	}
?>
