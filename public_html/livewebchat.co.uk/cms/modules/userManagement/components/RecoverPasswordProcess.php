<?
/**
* @package Elite_Promo
*/

	class RecoverPasswordProcess extends Component {
		function __construct(){
			if(@$_POST['recover-password']){
				$restrict = $_POST['email'] ? array('email'=>$_POST['email']) : array('userid'=>$_POST['userid']);
				$user = Model::loadModel('User')->getFirst($restrict);
				if($user){
					$user->resetPassword();
				}
				$view='modules/accounts/password-reset/confirmation';
			} else {
				$view = 'modules/accounts/password-reset/form';
			}
			parent::__construct($view,array('hidden'=>'<input type="hidden" name="recover-password" value="1"/>'));
		}
	}
?>
