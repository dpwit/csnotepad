<?
/**
* @package Elite_Promo
*/

	ini_set('max_$this->execution_time',20);
	class AudioFileManager extends BasicFileManager {
		function getExtension($size=''){
			switch($size){
			case '':
			case 'original':
				return parent::getExtension('');
			case 'preview':
			case 'wav':
				return "wav";
			case 'watermarked':
				return 'mcf';
			default:
				return "mp3";
			}
		}
		function fetch($size='original',$params = array()){
			if(($size=='wav') && ($this->getExtension('original')=='wav')){
				$size='original';
			}
			if(is_array($size)){
				$params = $size;
				$size = $params['size'];
				if(!$size) $size='original';
			}
			if($size=='best'){
				$user = Model::loadModel('User')->getLoggedInUser();
				$size = 'preview96';
				if($user && $user->canListen($this->model)){ 
					$size='full96';
				}
			}
			return parent::fetch($size,$params);
		}

		var $useGearman = true;
		function store($new,$old){
			parent::store($new,$old);
			if(($new->preview_start!=$old->preview_start)||($new->preview_end!=$old->preview_end)){
				$this->newPreview();
				return;
			}
		}
		function background($task,$args=array()){
			$pref = str_replace(".","_",__SERVER_DOMAIN__)."_";
			if(!$this->useGearman) return false;
			error_log("Background $pref$task ".json_encode($args));
			require_once("Net/Gearman/Client.php");

			$client = new Net_Gearman_Client(array("localhost:4730"));

			$task = new Net_Gearman_Task($pref."TillComplete",array('task'=>$pref.$task,'args'=>$args));
			$task->type = Net_Gearman_Task::JOB_BACKGROUND;
 
			$set = new Net_Gearman_Set();
			$set->addTask($task);

			$client->runSet($set);

			return  true;
		}
		function newSourceFile(){
			if(!$this->background('Watermark',$this->model->getId())){
				$this->generateWatermark();
			}
			$this->generatedPreview=true;
		}
		function newPreview(){
			if($this->generatedPreview) return;
			if(!$this->background('Preview',$this->model->getId())){
				$this->generatePreview();
			}
			$this->generatedPreview=true;
		}

		function requireWav(){
			$original = $this->fetch('original',array('as_url'=>false));
			$wav = $this->fetch('wav',array('as_url'=>false));
			if($wav!=$original){
				mkdir(dirname($wav),0777,true);
				$this->exec(__PATH_LAME__." --decode ".escapeshellcmd($original)." ".escapeshellcmd($wav)."");	
			}
			return $wav;
		}
		function releaseWav(){
			$original = $this->fetch('original',array('as_url'=>false));
			$wav = $this->fetch('wav',array('as_url'=>false));
			if($wav!=$original){
				unlink($wav);
			}
			return $wav;
		}
		function generateWatermark(){
		try {
			$this->generatePreview();
			$obj = $this->model;
			$original = $this->fetch('original',array('as_url'=>false));
			$wav = $this->requireWav();

			if($wav!=$original){
				mkdir(dirname($wav),0777,true);
				$this->exec(__PATH_LAME__." --decode ".escapeshellcmd($original)." ".escapeshellcmd($wav)."");	
			}

			$watermarked = $this->fetch('watermarked',array('as_url'=>false));
			$full96 = $this->fetch('full96',array('as_url'=>false));
			@mkdir(dirname($full96),0777,true);
			$this->exec($cmd = __PATH_LAME__." --cbr -b 96 -h -m s --strictly-enforce-ISO ".escapeshellcmd($wav)." ".escapeshellcmd($full96)."");


			@mkdir(dirname($watermarked),0777,true);

			$this->exec(dirname(__FILE__).'/lib/mp3Container/timeout.sh 7200 '.dirname(__FILE__).'/lib/mp3Container/pre_process.sh '.escapeshellcmd($wav).' '.escapeshellcmd($watermarked)."");

			chmod($watermarked,0777);
			chmod($full96,0777);
			$this->releaseWav();
		} catch(Exception $e){
			$this->releaseWav();
			throw $e;
		}
		}

		function allVersions(){
			return array('wav','preview','original','watermarked','preview96','full96');
		}

		function audioLength($file){
			preg_match("/\.([^.]+)$/",$file,$match);
			switch($match[1]){
			case 'wav':
			case 'mp3':
				$this->exec($cmd = "exiftool ".escapeshellcmd($file)," 2>/dev/null",$output);
				$values = array();
				foreach($output as $v){
					if(preg_match("/^(.*[^ ]) *: (.*)$/",$v,$match)){
						$values[$match[1]] = $match[2];
					}
				}

				if($values['Avg Bytes Per Sec']){
					$bits = filesize($file);
					return $bits/$values['Avg Bytes Per Sec'];
				} elseif($values['Duration']){
					if(preg_match("/^(\d+):(\d+) /",$values,$match)){
						return $match[1]*60+$match[2];
					}
				}
				break;
			}
			throw new Exception("Can't Calculate File Length");
		}
		function generatePreview(){
			try {
			$obj = $this->model;
			$original = $this->requireWav();
			$preview = $this->fetch('preview',array('as_url'=>false));
			$preview96 = $this->fetch('preview96',array('as_url'=>false));
			$preview_start = $this->audioLength($original)/2 - 15;
			$preview_end = $preview_start+30;
			@mkdir(dirname($preview),0777,true);
			$this->exec($cmd = "sox ".escapeshellcmd($original)." ".escapeshellcmd($preview)." trim $preview_start ".($preview_end-$preview_start)."");
			@mkdir(dirname($preview96),0777,true);
			$this->exec($cmd = __PATH_LAME__." --cbr -b 96 -h -m s --strictly-enforce-ISO ".escapeshellcmd($preview)." ".escapeshellcmd($preview96)."");
			chmod($preview96,0777);
			chmod($preview,0777);
			$obj->file_status='online';
			$obj->writeToDB();
			unlink($preview);
			$this->releaseWav();
			} catch(Exception $e){
				$this->releaseWav();
				@unlink($this->fetch('preview',array('as_url'=>false)));
				throw $e;
			}
		}

		function exec($cmd,$redirection=" >/dev/null 2>&1",&$output=false){
			$cmd.=" $redirection";
			exec("nice -n 10 $cmd",$output,$return);
			if($return){
				error_log("EXEC FAILED : $cmd");
				error_log("OUTPUT: ".join("\n",$output));
				throw new Exception("Execution Failed $cmd");
			} else {
				error_log("EXEC SUCCESS: $cmd");
			}
		}
	}


