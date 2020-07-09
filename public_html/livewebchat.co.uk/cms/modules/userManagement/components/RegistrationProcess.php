<?
/**
* @package Elite_Promo
*/

	cms_module_require('components','ScreenFlow.php');
	cms_module_require('components','Form.php');

	/** This class was a mistake in the development process, it basically
	 * does the same job as FormScreen but in a slightly different way
	 * so it has been left in to avoid having to rework the various sub-classes.
	 */
	class DataPage extends FormScreen {
		function __construct($name,$object=null,$params=array()){
			$params['write'] = true;
			if(!@$params['view'])
				$params['view'] = 'fe_form';
			parent::__construct($name,$object,$params);
		}
		function getFields(){
			return $this->object->getFields();
		}
	}
	class UserData extends DataPage {
		function __construct($name,$user=null,$params=array()){
			if(!$user) $user=Model::loadModel('User')->createNew();
			if(!@$params['view']) $params['view']='user-profile-edit';
			$this->user=$user;
			parent::__construct($name,$user,$params);
		}
		function getFields(){
			$fields = parent::getFields();
			unset($fields['status']);
			unset($fields['usergroup_uid']);
//			if($this->user->exists()) unset($fields['password']);
			return $fields;
		}
		function writeTo($model){
			if(Config::value('users_require_activation','site')){
				$model->status=0;
			} else {
				$model->status=1;
			}
			parent::writeTo($model);
		}
	}
	class PasswordChangeScreen extends DataPage {
		function __construct($name,$user=null,$params=array()){
			if(!$user) $user=Model::loadModel('User')->createNew();
			if(!@$params['view']) $params['view']='user-password-change';
			$this->user=$user;
			parent::__construct($name,$user,$params);
		}
		function getFields(){
			$fields = parent::getFields();
			foreach($fields as $k=>$v){
				if($k!='password') unset($fields[$k]);
			}
			return $fields;
		}
		function writeTo($model){
			if(Config::value('users_require_activation','site')){
				$model->status=0;
			} else {
				$model->status=1;
			}
			parent::writeTo($model);
		}
	}
	class RegistrationScreenFlow extends ScreenFlow {
		function __construct(){
			parent::__construct();
			$this->basePath='modules/accounts/';
		}
	}
	class Registration extends RegistrationScreenFlow {
		function __construct(){
			parent::__construct();
			$this->addScreen(new UserData('register',null,array('submitLabel'=>'Register')));
			$this->addScreen(new ConfirmationScreen('confirmation',
				Config::value('users_require_activation','site') ?  "modules/accounts/confirmation-pending":"modules/accounts/confirmation"));
			$this->processInput();
		}
	}
	class EditProfile extends RegistrationScreenFlow {
		function __construct(){
			parent::__construct();
			$user = Model::loadModel('User')->getLoggedInUser();
			$this->addScreen(new UserData('profile',$user,array('submitLabel'=>'Save Profile')));
			$this->addScreen(new ConfirmationScreen('confirmation',"modules/accounts/confirm-profile-edited"));
			$this->processInput();
		}
	}
	class PasswordChangeProcess extends RegistrationScreenFlow {
		function __construct(){
			parent::__construct();
			$user = Model::loadModel('User')->getLoggedInUser();
			$this->addScreen(new PasswordChangeScreen('password',$user,array('submitLabel'=>'Change Password')));
			$this->addScreen(new ConfirmationScreen('confirmation',"modules/accounts/confirm-password-change"));
			$this->processInput();
		}
	}

	class SimpleUserData extends UserData {
		function __construct($name,$object,$params){
			$params['view'] = 'login-form';
			parent::__construct($name,$object,$params);
		}
		function getFields(){
			$fields = parent::getFields();
			$allowed = array('userid','password','email');
			foreach($fields as $k=>$v){
				if(!in_array($k,$allowed)) unset($fields[$k]);
			}
			return $fields;
		}
		function process(){
			if(@$_POST['register'] && parent::process()){
				if(!Config::value('users_require_activation','site')){
					$this->object->forceLogin();
					redirectTo('/profile.html');
				}
				return true;
			}
		}
	}
	class QuickRegistration extends RegistrationScreenFlow {
		function __construct(){
			parent::__construct();
			$this->addScreen(new SimpleUserData('quick-register',null,array('submitLabel'=>'Register')));
			$this->addScreen(new ConfirmationScreen('confirmation',
				Config::value('users_require_activation','site') ?  "modules/accounts/confirmation-pending":"modules/accounts/confirmation"));
		}

		function doHTML($context){
			parent::doHTML($context);

		}
	}

?>
