<?
/**
* @package BozBoz_CMS
*/

	abstract class CronJob {
		function __construct($frequency=-1,$key=null){
			$this->frequency = $frequency;
			$this->key = is_null($key) ? get_class($this) : $key;
		}
		function shouldRun(){
			return (($this->frequency>0) && (time()-$this->lastRan()>$this->frequency));
		}

		function lastRan(){
			$q = mysql_query("SELECT MAX(last_ran) FROM cron_history WHERE `key`='$this->key'");
			echo mysql_error();
			$r = mysql_fetch_row($q);
			return $r[0];
		}

		function markRan(){
			mysql_query("INSERT INTO cron_history SET `key`='$this->key', last_ran='".time()."'");
		}

		function runIfNecessary(){
			if($this->shouldRun()){
				$this->markRan();
				$this->run();
			}
		}

		function __toString(){
			return get_class($this);
		}

		abstract function run();
	}
?>
