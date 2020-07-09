<?
/**
* @package Elite_Promo
*/

	class LoginBox extends FileInclude {
		function __construct($view=null){
			if(!$view) $view = 'structure/login-form';
			parent::__construct($view,array('user'=>Model::loadModel('User')->getLoggedInUser()));
		
		}
	}
?>
