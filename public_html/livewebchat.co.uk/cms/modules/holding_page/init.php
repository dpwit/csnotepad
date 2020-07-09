<?
	class HoldingPageHooks {
		function __construct(){
			cms_listen_action('handle_front_end',array($this,'show_holding_page'),false,-10);
		}
		function show_holding_page(){
			$url = @$_SERVER['SCRIPT_URL'];
			if(!$url) {
				$url=urldecode($_SERVER['REQUEST_URI']);
				@list($url,$qstring) =explode("?",$url);
			}
			$bypass = cms_apply_filter('no_holding_urls',array('/ipn','/forms-ipn'));
			if((!in_array($url,$bypass) || cms_apply_filter('no_holding_page',false))){
				if(@$_GET['p']||@$_GET['preview']) $_SESSION['preview'] = true;
				if(!@$_SESSION['preview']){
					include($_SERVER['DOCUMENT_ROOT']."/holding-page.html");
					exit();
				}
			}
		}
	}
	new HoldingPageHooks();
