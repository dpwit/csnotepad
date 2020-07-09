<?
	$user = Model::loadModel('User')->getLoggedInUser();

	class Logout implements Renderable {
		function render($context,$extraUrl){
			$user = Model::loadModel('User')->getLoggedInUser();
			if($user) $user->logout();
			$context->renderPage(array(dirname(__FILE__),"logout"));
			return true;
		}
		function delete_account($context,$extraUrl){
			$user = Model::loadModel('User')->getLoggedInUser();
			$user->delete();
			$user->logout();
			$context->renderPage(array(dirname(__FILE__),"account-deleted"));
			return true;
		}
		function reactivate_account($context,$extraUrl){
			$user = Model::loadModel('User')->get(array_shift($extraUrl),array('show_deleted'=>true));
			if($user->status<0){
				$user->status=0;
				$user->writeToDB();
			}
			$context->renderPage(array(dirname(__FILE__),"account-reactivated"));
		}
		function su($context,$extraUrl){
			$id = array_shift($extraUrl);
			$user = Model::loadModel('User')->getFirst(array('userid'=>$id));
			$user->su();
		}
		function switchback($context,$extraUrl){
			$user = Model::loadModel('User')->getLoggedInUser();
			if($user->isSU()){
				$user->logout();
			}
			redirectTo('/dashboard.html');
		}
	}
	$urls = array(
		"dashboard"=>"dashboard-".strtolower(@get_class($user)),
		"register"=>"register",
		"forgot-password"=>"recover-password",
		"change-password"=>"change-password",
		"profile"=>"profile",
		"login"=>"login",
		"logout"=>new Logout(),
		"switchback"=>array('func'=>array(new Logout(),'switchback')),
		"loginFailed"=>"login-failed",
		"reactivate"=>"reactivate",
		"su"=>array("func"=>array(new Logout,"su")),
		"user"=>array(
			"delete"=>array(
				"func"=>array(new Logout(),'delete_account'),
			),
			"reactivate"=>array(
				"func"=>array(new Logout(),'reactivate_account'),
			),
		),
		"quick-register"=>"quick-register",
	);
	FEContext::addUrls($urls,dirname(__FILE__));
