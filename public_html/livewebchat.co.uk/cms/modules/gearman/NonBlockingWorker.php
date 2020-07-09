<?
/**
* @package Elite_Promo
*/

	ini_set('include_path',ini_get('include_path').'/usr/share/php');
	require_once("Net/Gearman/Worker.php");

	class NonBlockingWorker extends Net_Gearman_Worker {
		function beginWork(){
			$start = mysql_result(mysql_query("SELECT UNIX_TIMESTAMP()"),0);
			do {
				$didWork = false;
				foreach($this->conn as $connection){
					$didWork = $didWork || $this->doWork($connection);
				}
				$loadAverage = 1.0*preg_replace("/ .*$/","",file_get_contents("/proc/loadavg"));
				$now = mysql_result(mysql_query("SELECT UNIX_TIMESTAMP()"),0);
			} while($didWork && ($loadAverage<MAX_LOAD_AVG_TRACKS) && ($now<$start+1200));
		}
	}
	
