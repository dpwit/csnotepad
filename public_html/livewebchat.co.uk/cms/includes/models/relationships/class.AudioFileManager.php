<?
/**
* @package Elite_Promo
*/

class ExecutionFailedException extends Exception{}
	class AudioFileManager extends BasicFileManager {
		function initRel($rel){
			$defaults = array(
				'waveform_image'=>true,
			);
			$rel = array_merge($defaults,$rel);
			if(@$rel['waveform_image']){
				$this->model->hasFile($this->name.'_image',array('file_type'=>'img','id-only'=>true,'db'=>false,
					'extraSizes'=>   array(
						'thumb'=> array( 'width'=>350,'height'=>200, 'resizer'=>'ImageResizerFitInBounds' ),
					),
					'ext'=>'png',
					'input'=>false
				));
			}
			return parent::initRel($rel);
		}
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
		function store($new,$old,$assign){
			parent::store($new,$old,$assign);
			foreach(array('preview_start','preview_end') as $field){
				if(array_key_exists($field,$assign)){
					$this->newPreview();
					return;
				}
			}
		}
		function background($task,$args=array()){
			$backgroundFailed = cms_apply_filter('background_job_run',$task,$args);
			return !$backgroundFailed;
		}
		function newSourceFile(){
			if(!$this->background('EncodeAudio',$this->model->getId())){
				$this->encodeAudio();
			}
			$this->generatedPreview=true;
		}
		function newPreview(){
			if($this->generatedPreview) return;
			if(!$this->background('PreviewAudio',$this->model->getId())){
				$this->generatePreviewAudio();
			}
			$this->generatedPreview=true;
		}

		function requireWav(){
			$original = $this->fetch('original',array('as_url'=>false));
			$wav = $this->fetch('wav',array('as_url'=>false));
			if($wav!=$original){
				@mkdir(dirname($wav),0777,true);
				$this->exec(__PATH_MPG123__." -w '".escapeshellcmd($wav)."' '".escapeshellcmd($original)."'");	
			}
			$rate = $this->sampleRate($wav);
			if($rate!=44100){
				$temp = $wav.".tmp.wav";
				rename($wav,$temp);
				$this->exec(__PATH_SOX__." '".escapeshellcmd($temp)."' -r 44100 '".escapeshellcmd($wav)."' rate ");
				unlink($temp);
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
		function encodeAudio(){
		try {
			$this->generatePreviewAudio();
			$obj = $this->model;
			$original = $this->fetch('original',array('as_url'=>false));
			$wav = $this->requireWav();
			if(@$this->params['waveform_image']){
				$this->generatePreviewImage();
			}

			$full96 = $this->fetch('full96',array('as_url'=>false));
			$full320 = $this->fetch('full320',array('as_url'=>false));
			@mkdir(dirname($full96),0777,true);
			@mkdir(dirname($full320),0777,true);

			$this->exec($cmd = __PATH_LAME__." --cbr -b 96 -h -m s --strictly-enforce-ISO '".escapeshellcmd($wav)."' '".escapeshellcmd($full96)."'");
			$this->doID3($full96);
			$this->exec($cmd = __PATH_LAME__." --cbr -b 320 -h -m s --strictly-enforce-ISO '".escapeshellcmd($wav)."' '".escapeshellcmd($full320)."'");
			$this->doID3($full320);

			chmod($full96,0777);
			chmod($full320,0777);
			$this->releaseWav();
		} catch(Exception $e){
			$this->releaseWav();
			throw $e;
		}
		}

		function allVersions(){
			return array('wav','preview','original','preview96','full96','full320');
		}

		function audioLength($file){
			preg_match("/\.([^.]+)$/",$file,$match);
			switch($match[1]){
			case 'wav':
			case 'mp3':
				$values = $this->exifTool($file);

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
		function sampleRate($file){
			$values = $this->exifTool($file);
			return $values['Sample Rate'];
		}
		function exifTool($file){
			$this->exec($cmd = "exiftool '".escapeshellcmd($file)."'"," 2>/dev/null",$output);
			$values = array();
			foreach($output as $v){
				if(preg_match("/^(.*[^ ]) *: (.*)$/",$v,$match)){
					$values[$match[1]] = $match[2];
				}
			}
			return $values;
		}
		function generatePreviewAudio(){
			try {
			$obj = $this->model;
			$original = $this->requireWav();
			$preview = $this->fetch('preview',array('as_url'=>false));
			$preview96 = $this->fetch('preview96',array('as_url'=>false));
			$this->doID3($preview96);
			$rel = $this->model->loadRel($this->name);
			if($length = @$rel['preview_length']){
			
			} else {
				$length = Config::value('default_preview_length');
			}
			$audio_length = $this->audioLength($original);

			if(is_numeric($obj->preview_start) && Config::value('use_suggested_preview_start')) $preview_start = $obj->preview_start;
			else $preview_start = $audio_length/2 - $length/2;
			if($preview_start<0) $preview_start=0;
			if($obj->preview_end && Config::value('use_suggested_preview_length')) $preview_end = $obj->preview_end;
			else $preview_end = $preview_start+$length;
			if($preview_end<$preview_start) $preview_end = $preview_start+$length;
			if($preview_end>$audio_length) $preview_end = $audio_length;

			@mkdir(dirname($preview),0777,true);
			$this->exec($cmd = "sox '".escapeshellcmd($original)."' '".escapeshellcmd($preview)."' trim $preview_start ".($preview_end-$preview_start)."");
			@mkdir(dirname($preview96),0777,true);
			$this->exec($cmd = __PATH_LAME__." --cbr -b 96 -h -m s --resample 44100 --strictly-enforce-ISO '".escapeshellcmd($preview)."' '".escapeshellcmd($preview96)."'");
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

		function generatePreviewImage(){
			try {
				$instance = $this->model;
				$file = "/tmp/preview.png";
				$file2 = "/tmp/preview2.png";
				$wav2png = defined('__PATH_WAV2PNG__') ? __PATH_WAV2PNG__ : 'wav2png';
				$this->exec("$wav2png -a $file ".$this->requireWav());
				$this->exec("convert $file -negate  -modulate 100,0 $file2");
				$field = $this->name."_image";
				$instance->$field = $file2;
				$instance->writeToDB();
				unlink($file);
				unlink($file2);
			} catch(ExecutionFailedException $e){
				// Ignore if wav2png is not working correctly...
			}
		}

		function exec($cmd,$redirection=" >/dev/null 2>&1",&$output=false){
			$cmd.=" $redirection";
			exec("nice -n 10 $cmd",$output,$return);
			if($return){
				error_log("EXEC FAILED : $cmd");
				error_log("OUTPUT: ".join("\n",$output));
				throw new ExecutionFailedException("Execution Failed $cmd");
			} else {
				error_log("EXEC SUCCESS: $cmd");
			}
		}

		function doID3($file){
			try {
				$id3 = $this->model->getID3Tags();
				if(!defined('__PATH_ID3__')) return;
				if(!defined('__TYPE_ID3__')) define('__TYPE_ID3__',basename(__PATH_ID3__));

				$map = array(
					'artist'=>'a',
					'album'=>'A',
					'title'=>'s',
					'comment'=>'c',
					'description'=>'C',
					'year'=>'y',
					'track'=>'t',
					'of'=>'T',
					'genre'=>'g'
				);
				switch(__TYPE_ID3__){
				case 'id3':
					$map['title']='t';
				}

				foreach($id3 as $k=>$v){
					$id3[$map[$k]]=$v;
					unset($id3[$k]);
				}
				switch(__TYPE_ID3__){
				case 'id3tag':
					$cmd = __PATH_ID3__;
					foreach($id3 as $k=>$v){
						$cmd.=" -$k\"".escapeshellcmd($v)."\"";
					}
					$this->exec($cmd." \"".escapeshellcmd($file)."\"");
					break;
				case 'id3':
					foreach($id3 as $k=>$v){
						$this->exec(__PATH_ID3__." -$k \"".escapeshellcmd($v)."\" \"".escapeshellcmd($file)."\"");
					}
					break;
				}
			} catch(BadRelationshipException $e){
				//ID3 Stuff not implemented so skip
			} catch(ExecutionFailedException $e){
				//ID3 Stuff not implemented so skip
			}
		}
	}


