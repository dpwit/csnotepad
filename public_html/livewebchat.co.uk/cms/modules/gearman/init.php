<?
	class Gearman_Hooks {
		function __construct(){
			cms_register_filter('get_cron_jobs',$this,false,30);
			cms_register_filter('background_job_handlers',$this);
			cms_register_filter('background_job_run',$this);
		}
		function get_cron_jobs($array){
			require_once(dirname(__FILE__).'/class.GearmanCron.php');
			$array[] = new GearmanCron();
			return $array;
		}
		function background_job_handlers($array){
			require_once(dirname(__FILE__).'/TillComplete.php');
			$array['TillComplete'] = new TillCompleteWorker();
			$array['TestJob'] = new GoWorker();
			return $array;
		}
		function background_job_run($key,$args){
			if(!$key) return;
			$pref = str_replace(".","_",__SERVER_DOMAIN__)."_";
			error_log("Background $pref$key ".json_encode($args));
			require_once("Net/Gearman/Client.php");

			$client = new Net_Gearman_Client(array("localhost:4730"));

			$task = new Net_Gearman_Task($pref."TillComplete",array('task'=>$pref.$key,'args'=>$args));
			$task->type = Net_Gearman_Task::JOB_BACKGROUND;
 
			$set = new Net_Gearman_Set();
			$set->addTask($task);

			$client->runSet($set);

			return  false;
		}
	}
	new Gearman_Hooks;
?>
