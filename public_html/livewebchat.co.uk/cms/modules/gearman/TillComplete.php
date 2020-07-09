<?
/**
* @package Elite_Promo
*/

	class TillCompleteWorker {

		function run($args){
			$this->args = $args;
			error_log("Ensuring ".json_encode($args));
			$pref = str_replace(".","_",__SERVER_DOMAIN__)."_";
			$task = $args['task'];
			$args = $args['args'];
			require_once("Net/Gearman/Client.php");

			$this->client = $client = new Net_Gearman_Client(array("localhost:4730"));

			do {
				$this->task = $task;
				$this->args = $args;
				$task = new Net_Gearman_Task($task,$args);
				$task->type = Net_Gearman_Task::JOB_HIGH;
				$task->attachCallback(array($this,'fail'),Net_Gearman_Task::TASK_FAIL);
	 
				$set = new Net_Gearman_Set();
				$set->addTask($task);

				$this->success=true;
				$client->runSet($set);
			} while(++$retries<5 && !$this->success);

			if(!$this->success){
				error_log("Retrying ".json_encode($args));
				$args = array('task'=>$task,'args'=>$args);
				array_unshift($args,$task);
				$task=$pref.'TillComplete';
				$task = new Net_Gearman_Task($task,$args);
				$task->type = Net_Gearman_Task::JOB_BACKGROUND;
				$set = new Net_Gearman_Set();
				$set->addTask($task);
				$client->runSet($set);
			}

			return  true;
		}

		function fail(){
			error_log("Task Failed ".json_encode($this->args));
			$this->success=false;
		}
	}

class GoWorker {
	function run(){
		echo " Running In Background...";
		if(rand()>rand())	throw new Exception("Task Failed");
		echo "Go Go Go...\n";
		return true;
	}
}
?>
