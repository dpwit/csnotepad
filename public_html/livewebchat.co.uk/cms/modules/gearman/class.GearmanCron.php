<?
/**
 * @package Elite_Promo
 *
 * package background_job_handlers should return an array of key=>callbacks where key is the key
 * of the background process and callback is the function to execute in the background.
*/
	if(!defined('MAX_LOAD_AVG_TRACKS')) define('MAX_LOAD_AVG_TRACKS',3);

	include("Net/Gearman/Job.php");
	function __autoload($class_name){
		$pref = str_replace(".","_",__SERVER_DOMAIN__)."_";
		$class = preg_replace("/$pref/","",$class_name);
		$job = str_replace("Net_Gearman_Job_","",$class);
		if($class_name!=$class && class_exists($class)){
			eval("class $class_name extends $class{ }");
		} else if($job!=$class){
			eval("class $class extends MyGearmanJob { var \$my_job_key='$job'; }");
		}
	}

	class MyGearmanJob extends Net_Gearman_Job_Common {
		function run($args){
			$handlers = cms_apply_filter('background_job_handlers',array());
			$handler = $handlers[$this->my_job_key];
			if(is_object($handler)) return $handler->run($args);
			else return call_user_func($handler,$args);
		}
	}

	class GearmanCron extends CronJob {
		public function shouldRun(){
			$loadAverage = 1.0*preg_replace("/ .*$/","",file_get_contents("/proc/loadavg"));
			return $loadAverage < MAX_LOAD_AVG_TRACKS;
		}

		public function run(){
//			cms_apply_filter('background_job_run','TestJob','Go');
			$pref = str_replace(".","_",__SERVER_DOMAIN__)."_";
			ini_set('include_path',ini_get('include_path').':/usr/share/php');
			require_once(dirname(__FILE__).'/NonBlockingWorker.php');

			try {
				$foregroundWorker = new Net_Gearman_Worker(array("localhost:4730"));
				$backgroundWorker = new NonBlockingWorker(array("localhost:4730"));
				$handlers = cms_apply_filter('background_job_handlers',array());
				foreach($handlers as $key=>$handler){
					//if(@$handler->isBlocking) $foregroundWorker->addAbility($pref.$key);
					$backgroundWorker->addAbility($pref.$key);
				}
				error_reporting(E_ALL&~E_NOTICE&~E_WARNING);
//				$foregroundWorker->beginWork();
				$backgroundWorker->beginWork();
			} catch (Net_Gearman_Exception $e) {
				echo $e->getMessage() . "\n";
				return;
			} 
		}
	}
?>
