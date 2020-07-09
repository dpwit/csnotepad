<? 
	session_start();
	define('FE',true);
	include("cms/fe-init.php");
	cms_trigger_action('handle_front_end');
	cms_trigger_action('front_end_complete');
