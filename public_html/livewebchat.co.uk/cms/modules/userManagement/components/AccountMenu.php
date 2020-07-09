<?
	class AccountMenu extends FileInclude {
		var $alternate = null;
		function __construct(){
			parent::__construct('structure/account-menu');
		}
		function preProcess(){
			if(!Model::loadModel('User')->getLoggedInUser()){
				$this->alternate = cms_apply_filter('get_unloggedin_account_menu',null);
				if($this->alternate) $this->alternate->preProcess();
			}
		}
		function doHTML($context){
			if($this->alternate){
				$this->alternate->doHTML($context);
			} else {
				parent::doHTML($context);
			}
		}
	}
