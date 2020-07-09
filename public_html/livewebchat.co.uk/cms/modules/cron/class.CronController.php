<?
/**
* @package BozBoz_CMS
*/

	require_once(dirname(__FILE__).'/class.CronJob.php');
	class CronController extends Controller {
		function cms_runCron(){
			$jobs = cms_apply_filter('get_cron_jobs',array());
			shuffle($jobs);
			foreach($jobs as $job){
				$job->runIfNecessary();
			}
		}
	}
?>
