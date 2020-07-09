<?
	class ImportFailedException extends Exception{}
	class FugaImporter extends CronJob {
		function __construct($dir){
			$this->baseDir = $dir;
			parent::__construct("fuga_import");
		}
		function shouldRun(){
			return true;
			return time() - $this->lastRan() > 55;
		}
		function run(){
			exec("chmod 777 -R $this->baseDir 2>/dev/null");
			$files = glob("$this->baseDir/*");
			$count=0;
			foreach($files as $file){
				$base = basename($file);
				if($base=='completed') continue;
				if($base=='failed') continue;


				if(glob("$file/*.complete")){
					$this->importRelease($file);
				}
				if($count++>40) return;
			}
		}
		function findLabel($label_name,$params=array()){
			return $this->findOrCreate('label',$label_name,$params);
		}
		function findArtist($artist_name,$params=array()){
			return $this->findOrCreate('artist',$artist_name,$params);
		}
		function findOrCreate($type,$artist_name,$params=array()){
			$artistF = Model::loadModel($type);
			$artist_name = cms_apply_filter('fuga_'.$type.'_mapping',$orig_name=$artist_name);
			$artist_name = cms_apply_filter('fuga_mapping',$artist_name,$type);
			$artist = $artistF->getByLabel($artist_name,array(),array('single'=>1));
			if(!$artist){
				$params = array_merge(array('status'=>$this->autoPublish($type),$artistF->getLabelField()=>$artist_name),$params);
				$artist = $artistF->createNew($params);
				$artist->writeToDB();
				cms_trigger_action('fuga_'.$type.'_created',$artist,$artist_name);
				cms_trigger_action('fuga_created',$type,$artist,$artist_name);
			}
			return $artist;
		}
		function autoPublish($type){
			return Config::value('auto_publish_'.$type.'s','fuga');
		}
		function importRelease($file){
			$base = basename($file);
			$dir = dirname($file);
			$failed = "$dir/failed/$base";
			$current = "$dir/current/$base";
			$complete = "$dir/complete/$base";
			@mkdir(dirname($failed),0777);
			@mkdir(dirname($current),0777);
			@mkdir(dirname($complete),0777);
			try {
				rename($file,$current);
				$file=$current;

				$xml_file = array_pop(glob("$file/*.xml"));
				if(!$xml_file) throw new ImportFailedException("No XML File");
				$xml = simplexml_load_file($xml_file);
				if(!$xml) throw new ImportFailedException("Invalid XML File ".basename($xml_file));

				$categoryF = Model::loadModel('Category');
				$bundleF = Model::loadModel('MP3Bundle');
				$trackF = Model::loadModel('MP3Product');
				$mp3F = Model::loadModel('MP3');
				$if = Model::loadModel('ProductImage');
				$fugaF = @Model::loadModel('Fuga_Import');

				$new = $fugaF->createNew(array(
					'import_id'=>(string)$xml->upc_code,
					'xml'=>file_get_contents($xml_file),
				));
				$old = $new->previous(array('product.visible'=>1),array('single'=>1));
				if($old && ($bundle = $old->product())){
				} else {
					$bundle = $bundleF->createNew(array('status'=>$this->autoPublish('release')));
					$category = $categoryF->getFirst(array('name'=>Config::value('default_category','fuga')));
					if(!$category){
						$category = $categoryF->createNew(array('name'=>Config::value('default_category','fuga'),'status'=>$this->autoPublish('categorie'),'parent_uid'=>0));
						$category->writeToDB();
					}
					$bundle->categories[] = $category;
				}
				if(!$bundle->description) $bundle->description = $xml->album_notes;
				foreach($xml as $k=>$v){
					$bundle->release->$k = (string)$v;
				}
				$bundle->release->territories = array();
				foreach($xml->territories->territory as $t){
					$bundle->release->territories[] = (string)$t;
				}
				$bundle->release->release_date = (string)$xml->release_date;
				$bundle->release->territories = join(",",$bundle->release->territories);
				$bundle->name = $xml->name;
				$bundle->label_uid = $this->findLabel((string)$xml->label)->getId();
				$artist_params = array('label_uid'=>$bundle->label_uid);
				$bundle->product_images[0] = $if->createNew(array('image'=>"$file/".(string)$xml->cover_art->image->file->name));

				foreach($xml->artists->artist as $artist){
					$artist = $this->findArtist((string)$artist->name,$artist_params);
					$new_artists[$artist->getid()] = $artist;
				}
				$bundle->manufacturers = $new_artists;

				$done = array();
				foreach($xml->assets->tracks->track as $xml_track){
					$track = $bundle->products_in(array('mp3.isrc_code'=>(string)$xml_track->isrc_code),array('single'=>1));

					if(!$track) $track = $trackF->createNew(array('isrc_code'=>(string)$xml_track->isrc_code,'status'=>$this->autoPublish('release')));

					if(!$track->description) $track->description = $xml_track->album_notes;
					$track->mp3->preview_start = (string)$xml_track->suggested_preview_start;
					$track->mp3->preview_end = $track->mp3->preview_start + (string)$xml_track->suggested_preview_length;
					foreach($xml_track->resources->audio as $audio){
						if(((string)$audio->recording_type)=="full")
							$track->mp3->mp3 = $file."/".(string)$audio->file->name;
					}
					$track->mp3->isrc_code = $xml_track->isrc_code;
					$track->name = $xml_track->name;
					$track->mp3->version = (string)$xml_track->track_version;
					$track_artists = array(); //$new_artists;
					foreach($xml_track->artists->artist as $artist){
						$artist = $this->findArtist((string)$artist->name,$artist_params);
						$track_artists[$artist->getid()] = $artist;
					}
					if(!$track_artists) $track_artists = $new_artists;
					$track->manufacturers = $track_artists;
					$track->triggerAction('fuga_track_created',$bundle,$xml_track,$xml,$xml_file);
					$track->writeToDB();

					$done[$track->getId()] = $track;
				}
				foreach($bundle->products_in() as $track){
					if(!$done[$track->getId()]) $track->delete();
				}
				$bundle->products_in = $done;
				$bundle->triggerAction('fuga_album_created',$xml,$xml_file);
				$bundle->writeToDB();

				$new->product_uid = $bundle->getId();
				$new->writeToDB();

				rename($file,$complete);
				$file = $complete;
			} catch(ImportFailedException $e){
				rename($file,$failed);
				file_put_contents("$failed/failure-reason.txt",$e->getMessage());
				var_dump($e->getMessage());
			}
		}
	}
?>
