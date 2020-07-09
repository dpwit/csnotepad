<?
/**
* @package Elite_FE
*/

	cms_module_require('userManagement','CustomUserModel.php');
	require_once(dirname(__FILE__).'/../../../cms/includes/functions/generalFunctions.php');
	class FEUser extends CustomUser {
		static $fe=false;
		function __construct($obj=null){
			parent::__construct($obj);
		}

		function getFields(){
			parent::getFields();
			$this->fields['usergroup_uid']->setParam('default',5);
			return $this->fields;
		}
		function on_model_saved($old){
			if((!$old) || ($this->status!=@$old->status)){
				$this->triggerAction('status_changed',@$old->status,$this->status,$old?false:true);
			}
		}
		function filter_model_view_dirs($views){
			foreach(cms_apply_filter('get_theme_directories',array()) as $dir){
				array_unshift($views,"$dir/modules/accounts/");
			}
			return $views;
		}

		function on_status_changed($old,$new,$isRegistration){
			if($isRegistration){
				if(Config::value('users_require_activation','site')){
					$this->sendRegistrationPendingEmail();
				} else {
					$this->sendRegistrationEmail();
				}
				return;
			}
			switch($new){
			case 1:
				if(Config::value('users_require_activation')){
					$this->sendActivationEmail();
				} else {
					$this->sendRegistrationEmail();
				}
				break;
			case -1:
				switch($old){
				case 0:
					$this->sendDeniedEmail();
					break;
				case 1:
				default:
					$this->sendDeactivationEmail();
				}
				break;
			case -2:
				$this->sendDeletedEmail();
				foreach($this->subscriptions() as $sub) $sub->cancel();
				break;
			case 0:
				$this->sendReactivationRequestEmail();
				break;
			}
		}

		function on_public_note_added($note){
			$this->mail(array('subject'=>__SERVER_DOMAIN__.' - New Note Added To Your Account',
						'html'=>$note->getView('email-summary')));
		}

		function sendActivationEmail(){
			$this->mail(array(
				'subject'=>"Your ".__SERVER_DOMAIN__." Account Has Been Activated",
				'html'=>$this->getView('mail/activation')
			));
		}
		function sendDeniedEmail(){
			$this->mail(array(
				'subject'=>"".__SERVER_DOMAIN__." Account Registration Unsuccessful",
				'html'=>$this->getView('mail/requestDenied')
			));
		}
		function sendRegistrationPendingEmail(){
			$this->mail(array(
				'subject'=>"Your ".__SERVER_DOMAIN__." Registration Received",
				'html'=>$this->getView('mail/registrationPending')
			));
		}
		function sendRegistrationEmail(){
			$this->mail(array(
				'subject'=>"Your ".__SERVER_DOMAIN__." Registration Received",
				'html'=>$this->getView('mail/registrationSuccess')
			));
		}
		function sendReactivationRequestEmail(){
			$this->mail(array(
				'subject'=>"Your ".__SERVER_DOMAIN__." Re-activation Request Received",
				'html'=>$this->getView('mail/reactivationRequest')
			));
		}
		function sendDeactivationEmail(){
			$this->mail(array(
				'subject'=>"Your ".__SERVER_DOMAIN__." Account has been deactivated",
				'html'=>$this->getView('mail/deactivated')
			));
		}
		function sendDeletedEmail(){
			$this->mail(array(
				'subject'=>"Your ".__SERVER_DOMAIN__." Account Has Been Deleted",
				'html'=>$this->getView('mail/deleted')
			));
		}
		function adminEmail($params){
			$params['email'] = Config::value('admin-email','site');
			$this->mail($params);
		}

		function getViewDirectories(){
			return array_insert(parent::getViewDirectories(),dirname(__FILE__).'/views/feuser',1);
		}

		function mail($params=array()){
			if(!$params['subject']) return false;
			if(!(@$params['text'] || @$params['html'])) return false;
			$footers = $this->getEmailFooters();
			$params = array_merge(array(
				"email"=>$this->email,
				"subject"=>__SERVER_DOMAIN__." Accounts",
				"from"=>Config::value('registration_email','site'),
				"fromName"=>Config::value('name','site')." Registration",
				"text"=>html_entity_decode(strip_tags($params['html'])),
				"html_footer"=>$footers['html'],
				"text_footer"=>$footers['text'],
				"bcc"=>array(
					'web-contact@bozboz.co.uk',
					'don@don-benjamin.co.uk'
				)
			),$params);

			cms_module_require('phpmailer','class.phpmailer.php');

			$mail = new PHPMailer();
			$mail->addAddress($params['email']);

			foreach($params['bcc'] as $bcc){
				$mail->addBCC($bcc);
			}

			$mail->From = $params['from'];
			$mail->FromName=$params['fromName'];
			$mail->Subject = $params['subject'];
			if($params['html']){
				$mail->IsHtml(true);
				$mail->Body=$params['html'].$params['html_footer'];
				$mail->AltBody=$params['text'].$params['text_footer'];
			} else {
				$mail->Body=$params['text'];
			}

			$mail->Send();
		}

		function checkLogin(){
			global $_SESSION;
			if(@$_POST['login']){
				$user = $this->getFirst($w = array('userid'=>@$_POST['un'],'password'=>md5(@$_POST['pw'])),array('show_deleted'=>1,'order'=>'status desc'));
				if($user && $user->isAdmin()) $user=false;
				if($user && $user->status>0){
					$_SESSION['fe'] = $user->getId();
					if(!$_POST['no-redirect']){
						redirectReferer();
						die();
					}
					cms_trigger_action('fe_logged_in');
				} elseif($user && $user->status==0){
					$reason='not_active';
					cms_trigger_action('fe_login_failed','This account has not been activated.  You will receive an email when your request has been processed');
				} elseif($user){
					$reason='deactivated';
					cms_trigger_action('fe_login_failed','This account has been de-activated.');
				} else {
					$reason='not_matched';
					cms_trigger_action('fe_login_failed','Your details have not been recognised');
				}
				if($_POST['no-redirect']){
					$_GET['failure_reason'] = @$reason;
				} else {
					header("Location: /loginFailed.html?reason=$reason&user=$_POST[un]");
					die();
				}
			}
		}
		function forceLogin(){
			if(self::$fe){
				global $_SESSION;
				$_SESSION['fe'] = $this->getID();
			} else {
				parent::forceLogin();
			}
		}
		function logOut(){
			global $_SESSION;
			if(self::$fe){
				$logged = @$_SESSION['old_fe'];
				foreach($_SESSION as $k=>$v){
					if($k!='preview') $_SESSION[$k] = null;
				}
				$_SESSION['fe'] = $logged;
			} else {
				parent::logOut();
			}
			cms_trigger_action('fe_logged_out',$this);
		}
		function getLoggedInUser(){
			global $_SESSION;
			if(self::$fe){
				$id = @$_SESSION['fe'];
				if($id) return $this->get($id);
			} else {
				return parent::getLoggedInUser();
			}
		}

		function request_delete(){
			$this->status=-2;
			$this->writeToDB();
		}
		function delete(){
			$user = $this->getLoggedInUser();
			if(!$user->isAdmin()) return $this->request_delete();

			$this->status=-3;
			$this->writeToDB();
		}

		function validStatuses(){
			return array(
				-3=>"Deleted",
				-2=>"Deletion Requested",
				-1=>"De-activated",
				"Awaiting Activation",
				"Active");
		}
		function filter_model_listing_filters($array){
			$array[] = new ListingFilter('status',$this->validStatuses());
			return $array;
		}
	}
